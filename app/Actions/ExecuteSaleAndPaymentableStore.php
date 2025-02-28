<?php

namespace App\Actions;

use App\Models\Paymentable;
use App\Models\Sale;
use Carbon\Carbon;

class ExecuteSaleAndPaymentableStore
{
    public function executeSaleStore($saleable_type, $saleable_by, $data)
    {
        $sale   = new Sale();

        $sale->saleable()->associate($saleable_type);

        $sale->saleableBy()->associate($saleable_by);
        $sale->invoice_number    = $data['invoice_number'];
        $sale->division          = $data['division'];
        $sale->township          = $data['township'];
        $sale->cash_down         = $data['cash_down'] ?? 0;
        $sale->delivery_amount   = $data['delivery_charges'];
        $sale->total_quantity    = $saleable_type->total_quantity;
        $sale->order_amount      = $saleable_type->total_amount;
        $sale->total_amount      = $saleable_type->total_amount + $data['delivery_charges'];
        $sale->total_paid_amount = $data['cash_down'] ?? 0;
        $sale->remaining_amount  = ($saleable_type->total_amount + $data['delivery_charges']) - ($data['cash_down'] ?? 0);
        $sale->payment_type      = $data['payment_type'];
        $sale->action_type       = $data['action_type'];
        $sale->sale_process      = $data['sale_process'];
        $sale->action_date       = format_date($data['action_date']);
        $sale->due_date          = format_date($data['due_date']);
        $sale->sale_process      = $data['sale_process'];
        $sale->address           = $data['address'];

        $sale->save();
        return $sale;
    }

    public function executeSalAPIStore($saleable_type, $saleable_by, $data)
    {
        $sale = new Sale();
        $sale->saleable()->associate($saleable_type);
        $sale->saleableBy()->associate($saleable_by);
        $sale->cash_down = $data['cash_down'] ?? 0;
        
        $sale->fill([
            'invoice_number'       => $data['invoice_number'],
            'address'              => $data['address'],
            'payment_type'         => $data['payment_type'] ?? "K-Pay",
            'division'             => $data['division'],
            'township'             => $data['township'],
            'total_quantity'       => $saleable_type->total_quantity,
            'total_amount'         => $saleable_type->total_amount,
            'total_paid_amount'    => $sale->cash_down, // Using the cash_down value directly
            'remaining_amount'     => $saleable_type->total_amount - $sale->cash_down, // Using the cash_down value directly
            'due_date'             => format_date($data['due_date']),
            'action_date'          => format_date($data['action_date']),
            'sale_process'         => $data['sale_process'] ?? 'PickUp',
            'action_type'          => $data['action_type'] ?? 'Cash',
            'saleable_id'          => $data['order_id'],
            'saleableby_id'        => $data['customer_id'],
            'cash_down'            => $data['cash_down'] ?? 0,
            'tax_amount'           => $data['tax_amount'] ?? 0,
            'delivery_amount'      => $data['delivery_amount'] ?? 0,
           
        ]);
    
        $sale->save();
       return $sale;
    }

    public function executePaymentStore(array $payment_info)
    {
        $last_payment = $payment_info['paymentable']->paymentables()->latest()->first();
        $payment   = new Paymentable();

        $payment->paymentable()->associate($payment_info['paymentable']);

        $payment->paymentableBy()->associate($payment_info['paymentableby']);
      
        $payment->payment_type   = isset($payment_info['payment_type']) ? isset($payment_info['payment_type']) : null;
        $payment->payment_status = $payment_info['status'];
        $payment->payment_date   = $payment_info['payment_date'];
        $payment->next_payment_date   = isset($payment_info['next_payment_date']) ? format_date($payment_info['next_payment_date']) : null;
        $payment->amount   = $payment_info['amount'];
        $payment->remaining_amount   = isset($payment_info['remaining_amount']) ? $payment_info['remaining_amount'] : 0;
        $payment->total_paid_amount   = $last_payment ? $last_payment->total_paid_amount + $payment_info['amount'] : $payment_info['amount'];
        $payment->save();
        return $payment;
    }
}
