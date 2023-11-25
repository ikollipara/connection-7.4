<?php

namespace App\View\Components\Forms;

use Illuminate\View\Component;

class Image extends Component
{
    public string $label;
    public string $name;
    public bool $showText;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(
        string $label,
        string $name,
        bool $showText = true
    ) {
        $this->label = $label;
        $this->name = $name;
        $this->showText = $showText;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view("components.forms.image");
    }
}
