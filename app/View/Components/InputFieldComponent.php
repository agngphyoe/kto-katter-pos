<?php

namespace App\View\Components;

use Illuminate\View\Component;

class InputFieldComponent extends Component
{
    public $type, $value, $label, $field_name, $field_id, $place_text, $readonly, $max, $required;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($type = "text", $value = null, $label, $name, $id, $text, $max = null, $readonly = false, $required = false)
    {
        $this->type = $type;
        $this->value = $value;
        $this->label = $label;
        $this->field_name = $name;
        $this->field_id = $id;
        $this->place_text = $text;
        $this->readonly = $readonly;
        $this->max = $max;
        $this->required = $required;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        $data = [
            'value' => $this->value,
            'label' => $this->label,
            'fieldName' => $this->field_name,
            'fieldID' => $this->field_id,
            'placeText' => $this->place_text,
            'readonly' => $this->readonly,
            'max' => $this->max,
            'required' => $this->required,
        ];
        return view('components.input-field-component')->with($data);
    }
}
