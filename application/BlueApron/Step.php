<?php
namespace BlueApron;

class Step
{
    public $title;
    public $text;
    public $image;

    public function __construct($step)
    {
        $this->title = $step->step_title;
        $this->text = $step->step_text;
        $this->image = 'http:' . $step->recipe_step_image_url;
    }
}