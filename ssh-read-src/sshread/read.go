package sshread

import (
	"bytes"
	"crypto/md5"
	"encoding/hex"
	"encoding/json"
	"errors"
	"fmt"
	"os"
	"regexp"
	"runtime"
	"strconv"
	"strings"
	"sync"

	"golang.org/x/crypto/ssh"
)

// 接口参数
type Parameter struct {
	Name    string `json:"name"`
	Require int    `json:"require"`
	Type    string `json:"type"`
	Default string `json:"default"`
	Desc    string `json:"desc"`
}

// 单个接口信息
type Api struct {
	Module      string      `json:"module"`
	Title       string      `json:"title"`
	Method      string      `json:"method"`
	Url         string      `json:"url"`
	Description []string    `json:"description"`
	Author      string      `json:"author"`
	Param       []Parameter `json:"param"`
	Return      []string    `json:"return"`
	LastLabel   string      `json:"lastLabel"`
	Md5         string      `json:"md5"`
}

// 将获取文件的文件内容解析成api文档信息
func parseContent(out string) (string, error) {
	reg := regexp.MustCompile(`(/\*\*[.\s\S]+?\*/)+?`)
	metachs := reg.FindAllString(out, -1)
	if len(metachs) == 0 {
		return "", errors.New("not found comment")
	}

	moduleReg := regexp.MustCompile(`@module\s+(.*)`)
	urlReg := regexp.MustCompile(`@url\s+(.*)`)
	methodReg := regexp.MustCompile(`@method\s+(.*)`)
	anyReg := regexp.MustCompile(`@(\w+)\s+(.*)`)
	trimReg := regexp.MustCompile(`[^/]\*[^/](.*)`)
	md5ctx := md5.New()
	var api_doc []Api
	module := "" //模块名
	for _, comm := range metachs {
		mMatch := moduleReg.FindStringSubmatch(comm)
		if len(mMatch) > 0 && module == "" {
			module = mMatch[1]
		}
		urlMatch := urlReg.FindStringSubmatch(comm)
		if len(urlMatch) == 0 {
			continue
		}
		methodMatch := methodReg.FindStringSubmatch(comm)
		if len(methodMatch) == 0 {
			continue
		}

		rows := strings.Split(comm, "\n")
		_api := Api{}
		for _, row := range rows {
			anyMatch := anyReg.FindStringSubmatch(row)

			if len(anyMatch) == 0 {
				trimMatch := trimReg.FindStringSubmatch(row)
				if len(trimMatch) >= 2 {
					if _api.LastLabel == "docreturn" {
						_api.Return = append(_api.Return, trimMatch[1])
					} else {
						_api.LastLabel = "description"
						_api.Description = append(_api.Description, trimMatch[1])
					}
				}

			} else {
				switch anyMatch[1] {
				case "title":
					_api.Title = anyMatch[2]
				case "author":
					_api.Author = anyMatch[2]
				case "module":
					_api.Module = anyMatch[2]
				case "url":
					_api.Url = anyMatch[2]
				case "method":
					_api.Method = anyMatch[2]
				case "docreturn":
					_api.Return = append(_api.Return, anyMatch[2])
				case "param":
					_info := strings.Split(anyMatch[2], " ")
					param := Parameter{}
					for _, _item := range _info {
						_set := strings.Split(_item, ":")
						if len(_set) != 2 {
							continue
						}
						switch _set[0] {
						case "name":
							param.Name = _set[1]
						case "require":
							param.Require, _ = strconv.Atoi(_set[1])
						case "type":
							param.Type = _set[1]
						case "default":
							param.Default = _set[1]
						case "desc":
							param.Desc = _set[1]
						}
					}

					_api.Param = append(_api.Param, param)

				}
				_api.LastLabel = anyMatch[1]

			}
		}
		md5ctx.Reset()
		md5ctx.Write([]byte(_api.Url + _api.Method))
		_api.Md5 = hex.EncodeToString(md5ctx.Sum(nil))

		if _api.Module == "" {
			_api.Module = module
			if _api.Module == "" {
				_api.Module = "未归类接口"
			}
		}

		api_doc = append(api_doc, _api)
	}

	buf := bytes.NewBufferString("")
	encoder := json.NewEncoder(buf)
	encoder.SetEscapeHTML(false)
	if err := encoder.Encode(&api_doc); err != nil {
		return "", errors.New("can not convert to json")
	}

	return string(buf.Bytes()), nil

}

// 获取源码文件内容
func getFileContent(client *ssh.Client, file string, conf *ReadConf) {
	defer wg.Done()
	session, err := NewSession(client)
	if err != nil {
		Log(err.Error())
		return
	}
	defer session.Close()
	out, err := session.Output("cat " + file)
	if err != nil {
		Log("文件读取失败：" + err.Error())
		ch <- &SuccInfo{file, false}
		return
	}
	jsonStr, err := parseContent(string(out))
	if err != nil {
		Log("文件解析失败：" + err.Error())
		ch <- &SuccInfo{file, false}
		return
	}

	md5ctx := md5.New()
	md5ctx.Write([]byte(file))
	v := md5ctx.Sum(nil)
	md5v := hex.EncodeToString(v)
	var DS, fileName string
	if runtime.GOOS == "windows" {
		DS = "\\"
	} else {
		DS = "/"
	}
	if conf.CacheDir == "" {
		fileName = md5v + ".cache"
	} else {
		fileName = conf.CacheDir + DS + md5v + ".cache"
	}

	f, err := os.Create(fileName)
	if err != nil {
		Log("缓存文件创建失败失败：" + err.Error())
		ch <- &SuccInfo{file, false}
		return
	}
	defer f.Close()
	_, err = f.WriteString(jsonStr)
	if err != nil {
		Log("缓存文件写入失败：" + err.Error())
		ch <- &SuccInfo{file, false}
		return
	}
	ch <- &SuccInfo{file, true}

}

type SuccInfo struct {
	name       string
	successful bool
}

var wg sync.WaitGroup
var ch chan *SuccInfo

func CreateFilesCache(host string, port int, user string, password string, configure *string) {
	var conf ReadConf
	err := GetConf(configure, &conf)
	if err != nil {
		Log(err.Error())
		return
	}
	client, err := GetConnection(host, port, user, password)

	if err != nil {
		Log("连接建立失败" + err.Error())
		return
	}
	ch = make(chan *SuccInfo, len(conf.Files))
	for _, file := range conf.Files {
		wg.Add(1)
		go getFileContent(client, file, &conf)
	}
	wg.Wait()

	for i := 0; i < len(conf.Files); i++ {
		item := <-ch
		if !(*item).successful {
			Log((*item).name + "文件读取失败")
			fmt.Println((*item).name + "文件读取失败")
		}
	}
}
