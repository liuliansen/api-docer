package sshread

import (
	"fmt"
	"strings"
	"sync"

	"golang.org/x/crypto/ssh"
)

var wg1 sync.WaitGroup
var wg2 sync.WaitGroup

func GetFileTimestamp(client *ssh.Client, file string) {
	defer wg2.Done()
	session1, err := NewSession(client)
	out, err := session1.Output("stat -c %Y " + file)
	if err != nil {
		Log("文件: " + file + "最后修改时间获取失败：" + err.Error())
		return
	}
	defer session1.Close()
	ret := strings.Trim(strings.TrimSpace(string(out)), "\n")
	fmt.Printf("{\"%s\":%s}\n", file, ret)
}

func GetInfo(client *ssh.Client, file string) {
	defer wg1.Done()
	session, err := NewSession(client)
	if err != nil {
		Log(err.Error())
		return
	}
	defer session.Close()
	//	fmt.Println(file)
	out, err := session.Output("stat -c %F " + file)
	if err != nil {
		Log("文件: " + file + "信息失败：" + err.Error())
		return
	}
	ret := strings.Trim(strings.TrimSpace(string(out)), "\n")
	if ret == "directory" {
		session1, err := NewSession(client)
		out, err = session1.Output("ls " + file + " | grep \".*\\.php\"")
		if err != nil {
			Log("文件: " + file + "最后修改时间获取失败：" + err.Error())
			return
		}
		defer session1.Close()
		ret := strings.Trim(strings.TrimSpace(string(out)), "\n")
		_files := strings.Split(ret, "\n")
		if file[len(file)-1:len(file)] != "/" {
			file += "/"
		}
		for _, _file := range _files {
			wg2.Add(1)
			go GetFileTimestamp(client, file+_file)
		}
	} else if ret == "regular file" {
		wg2.Add(1)
		go GetFileTimestamp(client, file)
	}
	wg2.Wait()

}

func GetFilesTimestamp(host string, port int, user string, password string, configure *string) {
	var files InfoConf
	err := GetConf(configure, &files)
	if err != nil {
		Log("源码文件规则列表配置解析失败：" + err.Error())
		return
	}
	client, err := GetConnection(host, port, user, password)

	if err != nil {
		Log("连接建立失败" + err.Error())
		return
	}
	for _, file := range files {
		wg1.Add(1)
		go GetInfo(client, file)
	}
	wg1.Wait()

}
