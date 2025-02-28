<?php

namespace App\Actions;

use App\Events\UpdateQuantity;
use App\Models\Product;
use Illuminate\Database\Eloquent\Builder;

class UpdateProductQuantity
{
    protected $product, $clone_product;
    protected int $quantity;

    public function __construct(int $id, int $quantity)
    {
        $this->quantity = $quantity;

        $this->product = Product::whereId($id)->lockForUpdate()->first();

        $this->clone_product = clone $this->product;
    }

    public function increaseProductQuantity(int $retail_price = null, int $wholesale_price = null)
    {

        $data = ['quantity' => $this->product->quantity + $this->quantity];

        if ($retail_price) {

            $data['retail_price'] = $retail_price;
        }

        if ($wholesale_price) {
            $data['wholesale_price'] = $wholesale_price;
        }

        $this->product->update($data);

        event(new UpdateQuantity($this->product));

        return $this->clone_product;
    }

    public function decreaseProductQuantity()
    {
    
        $this->product->update([
            'quantity' => $this->product->quantity - $this->quantity,
        ]);
       
        event(new UpdateQuantity($this->product));

        return $this->clone_product;
    }

    public function checkProductQuantity(int $original_quantity, int $new_quantity)
    {
        if ($original_quantity > $new_quantity) {

            $this->quantity = $original_quantity - $new_quantity;

            $this->increaseProductQuantity();
        } elseif ($original_quantity < $new_quantity) {

            $this->quantity = $new_quantity - $original_quantity;

            $this->decreaseProductQuantity();
        }

        return $this->clone_product;
    }
}
