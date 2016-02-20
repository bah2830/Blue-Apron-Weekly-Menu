<?php
namespace BlueApron;

class Ingredient
{
    public $name;
    public $quantity;

    public function __construct($ingredient)
    {
        $this->name = $ingredient->description;
        $this->quantity = trim(str_replace($this->name, '', $ingredient->customer_facing_name));
    }
}