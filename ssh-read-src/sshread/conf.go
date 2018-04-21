package sshread

import (
	"encoding/json"
	"errors"
	"reflect"
)

type InfoConf []string

// 程序调用参数
type ReadConf struct {
	CacheDir string   `json:"cache_dir"`
	Files    []string `json:"files"`
}

func GetConf(configure *string, conf interface{}) error {
	t := reflect.TypeOf(conf).String()
	if t != "*sshread.ReadConf" && t != "*sshread.InfoConf" {
		return errors.New("不支持的参数类型:" + t)
	}

	if *configure == "" {
		return errors.New("未设置源码文件列表")
	}

	err := json.Unmarshal([]byte(*configure), conf)
	if err != nil {
		return errors.New("参数解析失败" + err.Error() + "\n原始参数：" + *configure)
	}
	return nil

}
