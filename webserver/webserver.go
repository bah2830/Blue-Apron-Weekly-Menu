package webserver

import (
	"encoding/json"
	"html/template"
	"log"
	"net/http"

	"github.com/bah2830/Blue-Apron-Weekly-Menu/blueapron"
	"github.com/bah2830/Blue-Apron-Weekly-Menu/logger"
	"github.com/bah2830/Blue-Apron-Weekly-Menu/utilities"
)

var funcMap = template.FuncMap{
	"timestamp": utilities.GetUnixTimestamp,
}

var templates = template.Must(template.New("main").Funcs(funcMap).ParseGlob("templates/*.html"))

type indexPage struct {
	PageTitle string
	Recipes   [][]blueapron.Recipe
}

type postBody struct {
	Recipes []string `json:"recipes"`
}

// Start Webserver
func Start() {
	logger.Log("Starting webserver...")

	http.HandleFunc("/", indexHandler)
	http.HandleFunc("/shoppingList", shoppingListHandler)

	// Setup file server for html resources
	fs := http.FileServer(http.Dir("content"))
	http.Handle("/content/", http.StripPrefix("/content/", fs))

	err := http.ListenAndServe(":8080", nil)
	if err != nil {
		log.Fatal(err)
	}
}

func indexHandler(w http.ResponseWriter, r *http.Request) {
	p := indexPage{
		PageTitle: "Blue Apron Menu",
	}

	menu := blueapron.GetMenu()

	var allRecipes []blueapron.Recipes
	allRecipes = append(allRecipes, menu.TwoPersonPlan.Recipes...)
	allRecipes = append(allRecipes, menu.FamilyPlan.Recipes...)

	// Split recipes into groups of 4 for generating the html layout.
	var chunkedData [][]blueapron.Recipe
	var chunk []blueapron.Recipe
	for i, recipe := range allRecipes {
		if i != 0 && i%4 == 0 {
			chunkedData = append(chunkedData, chunk)
			chunk = nil
		}

		chunk = append(chunk, recipe.Recipe)
	}

	p.Recipes = append(chunkedData, chunk)

	templates.ExecuteTemplate(w, "index.html", p)
}

func shoppingListHandler(w http.ResponseWriter, r *http.Request) {
	var requestBody postBody
	decoder := json.NewDecoder(r.Body)
	err := decoder.Decode(&requestBody)
	if err != nil {
		logger.Error(err.Error())
	}

	defer r.Body.Close()
	shoppingList := blueapron.GetShoppingList(requestBody.Recipes)

	templates.ExecuteTemplate(w, "shoppingList.html", shoppingList)
}
