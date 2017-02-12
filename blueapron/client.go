package blueapron

import (
	"crypto/tls"
	"fmt"
	"io/ioutil"
	"net/http"

	"github.com/bah2830/Blue-Apron-Weekly-Menu/logger"
)

// Client for Blue apron api
type Client struct {
	APIBaseURL      string
	APIRecipeFormat string
}

func getClient() Client {
	client := Client{
		APIBaseURL:      "https://www.blueapron.com",
		APIRecipeFormat: "json",
	}

	return client
}

func (c Client) sendRequest(endPoint string) ([]byte, error) {
	url := fmt.Sprintf("%s%s", c.APIBaseURL, endPoint)
	logger.Log(fmt.Sprintf("Sending request to %s", url))

	tr := &http.Transport{
		TLSClientConfig: &tls.Config{
			InsecureSkipVerify: true,
		},
	}
	client := &http.Client{Transport: tr}

	req, err := http.NewRequest("GET", url, nil)
	if err != nil {
		logger.Error(err.Error())
	}

	// Required by server to not respond with a 406 error
	req.Header.Add("Accept", "application/vnd.blueapron.com.v20150315+json")

	resp, err := client.Do(req)
	if err != nil {
		logger.Error(err.Error())
	}

	defer resp.Body.Close()

	body, err := ioutil.ReadAll(resp.Body)
	if err != nil {
		logger.Error(err.Error())
	}

	return body, err
}
