<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Hero extends Component
{

    public string $class;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(string $class = '')
    {
        $this->class = $class;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.hero');
    }
}
