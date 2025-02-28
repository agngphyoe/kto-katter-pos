<?php

namespace App\Actions;

use App\Models\Product;
use App\Models\Purchase;

class ExecuteIMEIProduct
{
    protected Product $product;
    protected array $imei_products;
    protected Purchase $purchase;

    public function __construct(Product $product, array $imei_products, Purchase $purchase)
    {
        $this->product = $product;
        $this->imei_products = $imei_products;
        $this->purchase = $purchase;
    }

    public function store()
    {

        $imei_product_array = [];

        foreach ($this->imei_products as $imei_number) {

            $imei_product_array[] = [
                'imei_number' => $imei_number,
                'purchase_id' => $this->purchase->id,
            ];
        }

        return $this->product->imei_products()->createMany($imei_product_array);
    }
}
