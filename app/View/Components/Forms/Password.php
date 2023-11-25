<?php

namespace App\View\Components\Forms;

use Illuminate\View\Component;

class Password extends Component
{

    public string $label;
    public string $name;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(string $name, string $label)
    {
        $this->name = $name;
        $this->label = $label;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.forms.password');
    }
}
