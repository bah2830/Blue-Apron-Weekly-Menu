package logger

import (
	"fmt"
	"time"
)

// Log - Display general log info
func Log(message string) {
	fmt.Printf("%s [INFO] %s\n", getDateString(), message)
}

// Error - Display error information
func Error(message string) {
	fmt.Printf("%s [ERROR] %s\n", getDateString(), message)
}

func getDateString() string {
	t := time.Now()
	return t.Format("2006-01-02 15:04:05")
}
