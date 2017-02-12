package webserver

import (
	"html/template"
	"log"
	"net/http"

	"github.com/bah2830/Blue-Apron-Weekly-Menu/blueapron"
	"github.com/bah2830/Blue-Apron-Weekly-Menu/logger"
)

var templates = template.Must(template.ParseGlob("templates/*.html"))

type page struct {
	PageTitle string
	Sections  []Section
}

type Section struct {
	Name    string
	Recipes [][]blueapron.Recipe
}

// Start Webserver
func Start() {
	logger.Log("Starting webserver...")

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
	p := page{
		PageTitle: "Blue Apron Menu",
	}

	menu := blueapron.GetMenu()
	section := Section{
		Name:    "Two Person Plan",
		Recipes: splitIntoColumns(menu.TwoPersonPlan.Recipes, 4),
	}

	p.Sections = append(p.Sections, section)

	section = Section{
		Name:    "Family Plan",
		Recipes: splitIntoColumns(menu.FamilyPlan.Recipes, 4),
	}

	p.Sections = append(p.Sections, section)

	templates.ExecuteTemplate(w, "index.html", p)
}

func splitIntoColumns(recipes []blueapron.Recipes, columns int) [][]blueapron.Recipe {
	var chunkedData [][]blueapron.Recipe
	var chunk []blueapron.Recipe

	for i, recipe := range recipes {
		if i != 0 && i%4 == 0 {
			chunkedData = append(chunkedData, chunk)
			chunk = nil
		}

		chunk = append(chunk, recipe.Recipe)
	}

	chunkedData = append(chunkedData, chunk)

	return chunkedData
}
