package sshread

import (
	"errors"
	"net"
	"strconv"
	"time"

	"golang.org/x/crypto/ssh"
)

//获取连接
func GetConnection(host string, port int, user string, password string) (*ssh.Client, error) {
	client, err := ssh.Dial("tcp", host+":"+strconv.Itoa(port), &ssh.ClientConfig{
		User: user,
		Auth: []ssh.AuthMethod{ssh.Password(password)},
		HostKeyCallback: func(hostname string, remote net.Addr, key ssh.PublicKey) error {
			return nil
		},
	})
	if err != nil {
		Log("连接初始对象失败：" + err.Error())
		return nil, err
	}
	return client, nil
}

func NewSession(client *ssh.Client) (*ssh.Session, error) {
	start := time.Now().Unix()

	for {
		session, err := client.NewSession()
		if err == nil {
			return session, nil
		} else if time.Now().Unix()-3 >= start {
			return nil, errors.New("连接超时")
		}
	}
}
