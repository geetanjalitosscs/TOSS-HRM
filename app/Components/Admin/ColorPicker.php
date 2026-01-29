<?php

namespace App\Components\Admin;

use Illuminate\View\Component;

class ColorPicker extends Component
{
    public $name;
    public $label;
    public $value;
    public $required;

    /**
     * Create a new component instance.
     */
    public function __construct($name, $label, $value = '#8B5CF6', $required = false)
    {
        $this->name = $name;
        $this->label = $label;
        $this->value = $value;
        $this->required = $required;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render()
    {
        return view('components.admin.color-picker');
    }
}
