<?php

namespace App\View\Components;

use Illuminate\View\Component;

class SelectComponent extends Component
{
    public $label, $name, $id, $data;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($label, $name, $id, $data)
    {
        $this->label = $label;
        $this->name = $name;
        $this->id = $id;
        $this->data = $data;
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
            'datas' => $this->data
        ];
        return view('components.select-component')->with($datas);
    }
}
