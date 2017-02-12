package blueapron

// GetShoppingList builds a list of ingredients and their quantities needed for specific recipes.
func GetShoppingList(recipeTitles []string) []Ingredient {
	var shoppingList []Ingredient
	var ingredients []Ingredient

	for _, recipeTitle := range recipeTitles {
		ingredients = getIngredientsForRecipe(recipeTitle)
		shoppingList = append(shoppingList, ingredients...)
	}
	return shoppingList
}

func getIngredientsForRecipe(title string) []Ingredient {
	var ingredients []Ingredient

	for _, recipe := range menu.FamilyPlan.Recipes {
		if recipe.Recipe.Title == title {
			for _, ingredient := range recipe.Recipe.Ingredients {
				ingredients = append(ingredients, ingredient)
			}
		}
	}

	for _, recipe := range menu.TwoPersonPlan.Recipes {
		if recipe.Recipe.Title == title {
			for _, ingredient := range recipe.Recipe.Ingredients {
				ingredients = append(ingredients, ingredient)
			}
		}
	}

	return ingredients
}
