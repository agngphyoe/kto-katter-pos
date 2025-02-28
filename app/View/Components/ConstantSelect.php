<?php

namespace App\View\Components;

use Illuminate\View\Component;

class ConstantSelect extends Component
{
    public $label, $name, $id, $types;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($label, $name, $id, $types)
    {
        $this->label = $label;
        $this->name = $name;
        $this->id = $id;
        $this->types = $types;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        $datas = [
            'label' => $this->label,
            'name' => $this->name,
            'id' => $this->id,
            'types' => $this->types
        ];
        return view('components.constant-select')->with($datas);
    }
}
