<?php

namespace App\Components\Recruitment;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Tabs extends Component
{
    public $activeTab;

    /**
     * Create a new component instance.
     */
    public function __construct($activeTab = 'candidates')
    {
        $this->activeTab = $activeTab;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.recruitment.tabs');
    }
}
