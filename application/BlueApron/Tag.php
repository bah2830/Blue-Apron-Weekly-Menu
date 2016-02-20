<?php
namespace BlueApron;

class Tag
{
    public $type;
    public $values;

    public function __construct($type, $values)
    {
        $this->type = $type;
        $this->values = $values;
    }
}