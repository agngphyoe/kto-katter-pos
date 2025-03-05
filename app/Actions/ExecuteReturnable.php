<?php

namespace App\Actions;

use App\Models\Returnable;

class ExecuteReturnable
{
    protected array $return_products;

    public function __construct(array $return_products)
    {
        $this->return_products = $return_products;
    }

    public function saveReturnable(array $return_info)
    {

        $returnable   = new Returnable();

        $returnable->returnable()->associate($return_info['returnable']);
        $returnable->returnableBy()->associate($return_info['returnableby']);

        $returnable->cash_back_amount = isset($return_info['cash_back_amount']) ? $return_info['cash_back_amount'] : 0;
        $returnable->exchange_cash_type = isset($return_info['cash_type']) ? $return_info['cash_type'] : null;
        $returnable->remark         = isset($return_info['remark']) ? $return_info['remark'] : null;

        $returnable->latest_cash_back_amount = isset($return_info['latest_cash_back_amount']) ? $return_info['latest_cash_back_amount'] : 0;
        $returnable->latest_cash_back_type = isset($return_info['latest_cash_back_type']) ? $return_info['latest_cash_back_type'] : null;

        $returnable->return_type    = isset($return_info['return_type']) ? $return_info['return_type'] : null;
        $returnable->total_exchange_quantity = isset($return_info['total_exchange_quantity']) ? $return_info['total_exchange_quantity'] : 0;
        $returnable->total_exchange_amount = isset($return_info['total_exchange_amount']) ? $return_info['total_exchange_amount'] : 0;

        $returnable->total_return_quantity   = $return_info['total_return_quantity'];
        $returnable->total_return_amount = $return_info['total_return_amount'];
        $returnable->return_date   = $return_info['return_date'];
        $returnable->created_by = auth()->user()->id;

        $returnable->save();

        $returnable->productable()->createMany($this->return_products);

        return $returnable;
    }
}
