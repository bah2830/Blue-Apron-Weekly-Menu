package main

import (
	"fmt"

	"github.com/bah2830/Blue-Apron-Weekly-Menu/blueapron"
	"github.com/bah2830/Blue-Apron-Weekly-Menu/logger"
)

func main() {
	logger.Log("Starting...")

	menu := blueapron.GetWeeklyMenu()

	fmt.Printf("\nFamily Plan:")
	for _, recipe := range menu.FamilyPlan.Recipes {
		fmt.Printf("\n\t%s", recipe.Recipe.Title)
	}

	fmt.Printf("\n\nTwo Person Plan:")
	for _, recipe := range menu.TwoPersonPlan.Recipes {
		fmt.Printf("\n\t%s", recipe.Recipe.Title)
	}
	fmt.Printf("\n\n")

	// fmt.Printf("%+v\n", menu)

	// Start the web server
	// webserver.Start()
}
