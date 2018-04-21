package sshread

import (
	"fmt"
	"os"
	"syscall"
	"time"
)

// 写入日志
func Log(info string) {
	now := time.Now().Format("2006-01-02 15:04:05")
	var f *os.File
	if _, err := os.Stat("ssh.log"); err != nil {
		if os.IsNotExist(err) {
			f, err = os.Create("ssh.log")
			if err != nil {
				fmt.Println(now + "\t" + err.Error())
			}
		}
	} else {
		f, err = os.OpenFile("ssh.log", syscall.O_WRONLY|syscall.O_APPEND, 0666)
		if err != nil {
			fmt.Println(now + "\t" + err.Error())
		}
	}

	defer f.Close()
	_, err := f.WriteString(now + "\t" + info + "\n")
	if err != nil {
		fmt.Println(now + "\t" + err.Error())
	}
}
