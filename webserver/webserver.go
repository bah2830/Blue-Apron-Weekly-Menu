package webserver

import (
	"fmt"
	"html/template"
	"log"
	"net/http"
)

var templates = template.Must(template.ParseGlob("templates/*.html"))

type page struct {
	Title       string
	Name        string
	Email       string
	PhoneNumber string
	Address     string
}

// Start Webserver
func Start() {
	fmt.Println("Starting webserver...")

	http.HandleFunc("/", indexHandler)

	// Setup file server for html resources
	fs := http.FileServer(http.Dir("content"))
	http.Handle("/content/", http.StripPrefix("/content/", fs))

	err := http.ListenAndServe(":8080", nil)
	if err != nil {
		log.Fatal(err)
	}
}

func indexHandler(w http.ResponseWriter, r *http.Request) {
	p := page{}

	templates.ExecuteTemplate(w, "index.html", p)
}
