<?php

namespace App\Actions;


trait HandleReturnable
{

    public function checkReturnIsEmpty($model)
    {

        return $model->productReturnables->isEmpty();
    }

    public function getReturnableProducts($model)
    {
        if ($this->checkReturnIsEmpty($model)) {

            foreach ($model->productable as $purchase_product) {

                $product_returnable_data[] = [
                    'product_id'    => $purchase_product->product_id,
                    'quantity'      => $purchase_product->quantity,
                    'buy_price'     => $purchase_product->buy_price,
                    'retail_sell_price' => $purchase_product->retail_sell_price,
                    'wholesale_sell_price' => $purchase_product->wholesale_sell_price,
                ];
            }

            $products = $model->productReturnables()->createMany($product_returnable_data);
        } else {

            $products = $model->productReturnables;
        }

        return $products;
    }
}
