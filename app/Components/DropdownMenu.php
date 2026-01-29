<?php

namespace App\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class DropdownMenu extends Component
{
    public $items;
    public $position;
    public $width;

    /**
     * Create a new component instance.
     */
    public function __construct($items = [], $position = 'left', $width = 'w-48')
    {
        $this->items = $items;
        $this->position = $position;
        $this->width = $width;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.dropdown-menu');
    }
}
