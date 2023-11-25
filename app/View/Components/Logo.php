<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Logo extends Component
{

    public int $width;
    public int $height;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(int $width = 40, int $height = 40)
    {
        $this->width = $width;
        $this->height = $height;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.logo');
    }
}
