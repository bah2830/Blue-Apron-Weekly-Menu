package blueapron

import (
	"encoding/json"

	"github.com/bah2830/Blue-Apron-Weekly-Menu/logger"
)

// WeeklyMenu - List of recipes for each week
type WeeklyMenu struct {
	FamilyPlan    MealPlan `json:"family_plan"`
	TwoPersonPlan MealPlan `json:"two_person_plan"`
}

// MealPlan - Details about each type of plan
type MealPlan struct {
	Recipes []Recipes `json:"recipes"`
}

// Recipes - List of recipes in plan
type Recipes struct {
	Recipe Recipe `json:"recipe"`
}

// Recipe - Instructions
type Recipe struct {
	Title            string       `json:"title"`
	Description      string       `json:"description"`
	PreviewTitle     string       `json:"main_title"`
	PreviewSubTitle  string       `json:"sub_title"`
	LinkPath         string       `json:"location"`
	MinCookTime      int          `json:"min_cook_time"`
	MaxCookTime      int          `json:"max_cook_time"`
	PreviewImage     string       `json:"high_menu_thumb_url"`
	Image            string       `json:"square_hi_res_image_url"`
	IngredientsImage string       `json:"ingredient_image_url"`
	Servings         string       `json:"servings"`
	Ingredients      []Ingredient `json:"ingredients"`
}

// Ingredient - Item used in recipe
type Ingredient struct {
	Name     string `json:"description"`
	Quantity string `json:"customer_facing_quantity"`
	FullName string `json:"customer_facing_ingredient_name"`
}

// GetWeeklyMenu - Returns list of all recipes for the week
func GetWeeklyMenu() WeeklyMenu {
	client := getClient()
	response, err := client.sendRequest("/api/recipes/on_the_menu")
	if err != nil {
		logger.Error(err.Error())
	}

	var menu WeeklyMenu
	err = json.Unmarshal(response, &menu)
	if err != nil {
		logger.Error(err.Error())
	}

	return menu
}
