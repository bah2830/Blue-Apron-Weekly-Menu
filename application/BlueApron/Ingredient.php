<?php
namespace BlueApron;

class Ingredient
{
    public $name;
    public $quantity;

    public function __construct($ingredient)
    {
        $this->name = ucwords($ingredient->description);
        $this->quantity = trim(str_replace(strtolower($this->name), '', strtolower($ingredient->customer_facing_name)));
    }

    public function __tostring()
    {
        return "{$this->quantity} {$this->name}";
    }

    public static function combine($ingredients)
    {

        $newSet = [];
        foreach ($ingredients as $ingredient) {
            if (isset($newSet[$ingredient->name])) {
                $oldQuantity = self::splitUnit($newSet[$ingredient->name]->quantity);
                $newQuantity = self::splitUnit($ingredient->quantity);

                $newTotal = $oldQuantity->number + $newQuantity->number;
                $newSet[$ingredient->name]->quantity = $newTotal . " " . $oldQuantity->unit;
            } else {
                $quantity = self::splitUnit($ingredient->quantity);
                $ingredient->quantity = $quantity->number . ' ' . $quantity->unit;

                $newSet[$ingredient->name] = $ingredient;
            }
        }

        return $newSet;
    }

    public static function splitUnit($quantity)
    {
        $newQuantity = new \stdClass();

        $number = trim(preg_replace('/[A-Za-z]+/', '', $quantity));
        if (preg_match('/(?P<fraction>\d+\/\d+)/', $number, $match)) {
            $wholeNumber = trim(str_replace($match['fraction'], '', $number));

            $numbers = split('/', $match['fraction']);
            $number = round($wholeNumber . ($numbers[0] / $numbers[1]), 2);
        }

        $newQuantity->number = $number;
        $newQuantity->unit = self::abreviateUnit(trim(preg_replace('/\d+|\//', '', $quantity)));

        return $newQuantity;
    }

    private static function abreviateUnit($unit)
    {
        switch (true) {
            case (strpos(strtolower($unit), 'tablespoon') !== false):
                $unit = 'Tbsp';
                break;
            case (strpos(strtolower($unit), 'teaspoon') !== false):
                $unit = 'tsp';
                break;
            case (strpos(strtolower($unit), 'ounce') !== false):
                $unit = 'oz';
                break;
            case (strpos(strtolower($unit), 'pound') !== false):
                $unit = 'lbs';
                break;
            case (strpos(strtolower($unit), 'cup') !== false):
                $unit = $unit;
        }

        return $unit;
    }
}