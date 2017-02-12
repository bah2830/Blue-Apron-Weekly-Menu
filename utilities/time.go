package utilities

import "time"

// GetUnixTimestamp returns the number of seconds since the epoch.
func GetUnixTimestamp() int64 {
	return time.Now().Unix()
}
