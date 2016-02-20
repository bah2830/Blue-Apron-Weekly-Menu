<?php
namespace BlueApron;

class Recipe
{
    public $title;
    public $previewTitle;
    public $previewSubTitle;
    public $description;
    public $linkPath;
    public $minCookTime;
    public $maxCookTime;
    public $previewImage;
    public $image;
    public $ingredientsImage;
    public $ingredients;
    public $tags;
    public $instructions;

    public function __construct($recipe)
    {
        $this->title = $recipe->title;
        $this->previewTitle = $recipe->main_title;
        $this->previewSubTitle = $recipe->sub_title;
        $this->linkPath = 'https://www.blueapron.com' . $recipe->location;
        $this->description = $recipe->description;
        $this->previewImage = 'http:' . $recipe->high_menu_thumb_url;
        $this->image = 'http:' . $recipe->square_hi_res_image_url;
        $this->ingredientsImage = 'http:' . $recipe->ingredient_image_url;
        $this->minCookTime = $recipe->min_cook_time;
        $this->maxCookTime = $recipe->max_cook_time;

        $this->ingredients = [];
        foreach ($recipe->ingredients as $ingredient) {
            $this->ingredients[] = new Ingredient($ingredient);
        }

        $this->tags = [];
        foreach ($recipe->tags as $type => $values) {
            $this->tags[] = new Tag($type, $values);
        }

        $this->instructions = [];
        foreach ($recipe->recipe_steps as $instruction) {
            $this->instructions[$instruction->step_number] = new Step($instruction);
        }
    }
}