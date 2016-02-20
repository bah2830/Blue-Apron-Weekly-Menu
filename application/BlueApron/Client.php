<?php
namespace BlueApron;

class Client
{
    private $apiBaseUrl = 'https://www.blueapron.com';
    private $apiRecipeFormat = 'json';

    public function getRecipeFromId($id)
    {
        $recipe = $this->sendRequest('/recipes/' . $id . $this->apiRecipeFormat);

        if (!isset($recipe->recipe)) {
            throw new \Exception("No recipe found for id {$id}");
        }

        $recipe = $recipe->recipe;

        return $recipe;
    }

    public function getWeeklyMenu()
    {
        $response = $this->sendRequest("/api/recipes/on_the_menu");

        $recipes = [];
        foreach ($response->two_person_plan->recipes as $recipe) {
            $recipes[] = new Recipe($recipe->recipe);
        }

        return $recipes;
    }

    private function sendRequest($endpoint, $jsonEncode = true)
    {
        $response = shell_exec("curl {$this->apiBaseUrl}{$endpoint}");

        if ($jsonEncode) {
            $response = json_decode($response);
            if (!is_object($response)) {
                throw new \Exception("Invalid json returned");
            }
        } else {
            $response = (string)$response;
        }

        return $response;
    }
}