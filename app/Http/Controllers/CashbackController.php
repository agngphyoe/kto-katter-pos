<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SupplierCashback;
use App\Models\Supplier;
use DB;

class CashbackController extends Controller
{
    public function index()
    {
        $total_remaining_cashback = SupplierCashback::where('payment_status', 'unpaid')->sum('amount');

        $suppliers = Supplier::join('supplier_cashbacks', 'supplier_cashbacks.supplier_id', '=', 'suppliers.id')
                                ->where('supplier_cashbacks.payment_status', 'unpaid')
                                ->selectRaw('suppliers.id, suppliers.name, supplier_cashbacks.payment_status, SUM(supplier_cashbacks.amount) as total_unpaid_amount')
                                ->groupBy('suppliers.id', 'suppliers.name', 'supplier_cashbacks.payment_status')
                                ->get();

        return view('pos-cashback.index', compact('total_remaining_cashback', 'suppliers'));
    }

    public function details(Supplier $supplier)
    {
        $remaining_cashback = SupplierCashback::where('supplier_id', $supplier->id)
                                                ->where('payment_status', 'unpaid')
                                                ->sum('amount');

        $cashback_products = SupplierCashback::where('supplier_id', $supplier->id)
                                                ->where('payment_status', 'unpaid')
                                                ->get();

        return view('pos-cashback.details', compact('supplier', 'remaining_cashback', 'cashback_products'));
    }

    public function changeStatus(Supplier $supplier)
    {
        try {
            DB::beginTransaction();
            $cashback_products = SupplierCashback::where('supplier_id', $supplier->id)
                                                    ->where('payment_status', 'unpaid')
                                                    ->get();

            $cashback_amount = 0;
            foreach ($cashback_products as $cashback_product) {
                $cashback_product->payment_status = 'paid';
                $cashback_product->save();

                $cashback_amount += $cashback_product->amount;
            }

            $cashback_payment = DB::table('cashback_payments')
                                    ->insert([
                                        'supplier_id' => $supplier->id,
                                        'amount' => $cashback_amount,
                                        'payment_date' => date('Y-m-d'),
                                        'remarks' => 'Cashback Payment',
                                        'created_at' => now(),
                                        'updated_at' => now()
                                    ]);

            DB::commit();

            return redirect->route('pos-cashback-list')->with('success', 'Cashback Status Changed Successfully');
        } catch (\Exception $e) {
            DB::rollback();

            return redirect()->back()->with('error', 'Failed to import data. Please try again.');
        }
        
        return view('pos-cashback.change-status');
    }
}
