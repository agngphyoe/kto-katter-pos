<?php

namespace App\View\Components;

use Illuminate\View\Component;

class SaleDetail extends Component
{
    public $sale;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($sale)
    {
        $this->sale = $sale;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.sale-detail')->with('sale', $this->sale);
    }
}
