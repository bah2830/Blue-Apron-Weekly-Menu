package main

import (
	"github.com/bah2830/Blue-Apron-Weekly-Menu/blueapron"
	"github.com/bah2830/Blue-Apron-Weekly-Menu/logger"
	"github.com/bah2830/Blue-Apron-Weekly-Menu/webserver"
)

func main() {
	logger.Log("Starting...")

	// Start the poller to keep the cache updated
	blueapron.StartPoller()

	// Start the web server
	webserver.Start()
}
