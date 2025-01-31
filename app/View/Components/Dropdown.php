<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Dropdown extends Component
{
    public $align;
    public $width;

    public function __construct($align = 'right', $width = '48')
    {
        $this->align = $align;
        $this->width = $width;
    }

    public function render()
    {
        return view('components.dropdown');
    }
}