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
        $response = $this->getCachedResponse($endpoint);
        if ($response != null) {
            return $response;
        }

        $response = shell_exec("curl {$this->apiBaseUrl}{$endpoint}");

        if ($jsonEncode) {
            $response = json_decode($response);
            if (!is_object($response)) {
                throw new \Exception("Invalid json returned");
            }
        } else {
            $response = (string)$response;
        }

        $this->cacheResponse($endpoint, $response);

        return $response;
    }

    private function getCachedResponse($endpoint)
    {
        if (file_exists($this->getCacheFilePath($endpoint))) {
            $fileContents = unserialize(file_get_contents($this->getCacheFilePath($endpoint)));

            if (time() - $fileContents['createDate'] > 60 * 60 * 6) {
                unlink($this->getCacheFilePath($endpoint));
                return null;
            }

            return $fileContents['content'];
        }

        return null;
    }

    private function cacheResponse($endpoint, $response)
    {
        $fileContents = [
            'createDate' => time(),
            'content' => $response
        ];

        file_put_contents($this->getCacheFilePath($endpoint), serialize($fileContents));
    }

    private function getCacheFilePath($endpoint)
    {
        $cleanEndpoint = preg_replace('/^_/', '', str_replace('/', '_', $endpoint));
        return ROOT_DIR . "/cache/{$cleanEndpoint}";
    }
}