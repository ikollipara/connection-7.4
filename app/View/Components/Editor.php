<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Editor extends Component
{

    public string $name;
    public bool $readOnly;
    public bool $cannotUpload;
    public string $model;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(string $name, bool $readOnly = false, bool $cannotUpload = false, string $model = '')
    {
        $this->name = $name;
        $this->readOnly = $readOnly;
        $this->cannotUpload = $cannotUpload;
        $this->model = $model;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.editor');
    }
}
