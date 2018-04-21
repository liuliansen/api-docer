package main

import (
	"flag"
	"fmt"
	"sshread"
)

func main() {
	host := flag.String("h", "", "remote host ip or domain")
	port := flag.Int("P", 22, "remote host port")
	user := flag.String("u", "", "ssh user")
	password := flag.String("p", "", "ssh user's password")
	worktype := flag.String("m", "", "this work called method (\"info\" or \"read\")")
	configure := flag.String("c", "", "his work configure as json string")
	flag.Parse()
	if *worktype == "info" {
		sshread.GetFilesTimestamp(*host, *port, *user, *password, configure)
	} else if *worktype == "read" {
		sshread.CreateFilesCache(*host, *port, *user, *password, configure)
	} else {
		fmt.Println("Unknow -t value")
	}
}
