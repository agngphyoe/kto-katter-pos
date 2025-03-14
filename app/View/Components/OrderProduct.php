<?php

namespace App\View\Components;

use Illuminate\View\Component;

class OrderProduct extends Component
{
    public $orders;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($orders)
    {
        $this->orders = $orders;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.order-product')->with('orders', $this->orders);
    }
}
