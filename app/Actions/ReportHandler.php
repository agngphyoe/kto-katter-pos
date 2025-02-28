<?php

namespace App\Actions;

use App\Models\Cashbook;
use App\Models\Customer;
use App\Models\Supplier;
use App\Models\Paymentable;
use App\Models\Product;
use App\Models\Productable;
use App\Models\Purchase;
use App\Models\Returnable;
use App\Models\Sale;
use App\Models\PurchaseReturn;
use App\Models\Bank;
use App\Models\PointOfSale;
use App\Models\PosReturn;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportHandler
{
    protected Request $request;

    public function __construct($request)
    {
        $this->request = $request;
    }

    // public function executeProduct()
    // {
    //     $category   = $this->request->category;
    //     $date_range = $this->request->date;
    //     list($start_date, $end_date) = explode(' - ', $date_range);
    //     $start_date = format_date($start_date);
    //     $end_date   = format_date($end_date);

    //     $productables = Productable::when($category, function ($query) use ($category) {
    //         $query->whereHas('product', function ($query) use ($category) {
    //             $query->whereCategoryId($category);
    //         });
    //     })->when($start_date && $end_date, function ($query) use ($start_date, $end_date) {
    //         $query->whereDate('created_at', '>=', $start_date)
    //             ->whereDate('created_at', '<=', $end_date);
    //     })->whereIn('id', function ($query) use ($start_date, $end_date) {
    //         $query->select(DB::raw('MAX(id)'))
    //             ->from('productable')
    //             ->whereDate('created_at', '>=', $start_date)
    //             ->whereDate('created_at', '<=', $end_date)
    //             ->groupBy('product_id');
    //     })->orderByDesc('id')->get();

    //     return $productables;
    // }

    public function executeProduct()
    {
        $category     = $this->request->category;
        $brand        = $this->request->brand;
        $product_code = $this->request->product_code;

        $query = Product::query();

        if (!empty($category)) {
            $query->whereHas('category', function ($query) use ($category) {
                $query->where('id', $category);
            });
        }

        if (!empty($brand)) {
            $query->whereHas('brand', function ($query) use ($brand) {
                $query->where('id', $brand);
            });
        }

        if (!empty($product_code)) {
            $query->where('code', 'like', "%{$product_code}%");
        }

        return $query->orderByDesc('id')->get();
    }

    public function executeCustomer()
    {

        $division = $this->request->division;
        $township = $this->request->township;
        $date_range = $this->request->date;
        list($start_date, $end_date) = explode(' - ', $date_range);
        $start_date = format_date($start_date);
        $end_date   = format_date($end_date);

        $customers = Customer::when($division, function ($query) use ($division) {
            $query->whereHas('division', function ($query) use ($division) {
                $query->where('id', $division);
            });
        })->when($township, function ($query) use ($township) {
            $query->whereHas('township', function ($query) use ($township) {
                $query->where('id', $township);
            });
        })->when($start_date && $end_date, function ($query) use ($start_date, $end_date) {
            $query->whereDate('created_at', '>=', $start_date)
                ->whereDate('created_at', '<=', $end_date);
        })->orderByDesc('id')->get();

        return $customers;
    }

    public function executeSale()
    {
        $order_number = $this->request->sale_number;
        $date_range = $this->request->date;

        $query = PointOfSale::query();

        if (!empty($order_number)) {
            $query->where('order_number', $order_number);
        }

        if (!empty($date_range) && empty($order_number)) {
            list($start_date, $end_date) = explode(' - ', $date_range);
            $start_date = format_date($start_date);
            $end_date = format_date($end_date);

            $query->whereDate('created_at', '>=', $start_date)
                  ->whereDate('created_at', '<=', $end_date);
        }

        return $query->orderByDesc('id')->get();
    }

    public function executePurchase()
    {
        // Get request inputs
        $supplier         = $this->request->supplier;
        $purchase_type    = $this->request->purchase_type;
        $purchase_status  = $this->request->purchase_status;
        $invoice_number   = $this->request->invoice_number;

        $date_range       = $this->request->date;

        $query = Purchase::query();

            if (!empty($supplier)) {
                $query->whereHas('supplier', function ($query) use ($supplier) {
                    $query->where('id', $supplier);
                });
            }

            if (!empty($purchase_type)) {
                $query->where('action_type', $purchase_type);
            }

            if (!empty($purchase_status)) {
                $query->where('purchase_status', $purchase_status);
            }

            if (!empty($invoice_number)) {
                $query->where('invoice_number', 'like', "%{$invoice_number}%");
            }

            if (empty($supplier) && empty($purchase_type) && empty($purchase_status) && empty($invoice_number) && !empty($date_range)) {
                list($start_date, $end_date) = explode(' - ', $date_range);
                $start_date = format_date($start_date);
                $end_date   = format_date($end_date);

                $query->whereDate('action_date', '>=', $start_date)
                      ->whereDate('action_date', '<=', $end_date);
            }

        return $query->orderByDesc('id')->get();

    }

    // public function executePurchaseReturn()
    // {

    //     $supplier   = $this->request->supplier;
    //     $brand            = $this->request->brand;
    //     $category         = $this->request->category;
    //     $model            = $this->request->model;

    //     $date_range = $this->request->date;
    //     list($start_date, $end_date) = explode(' - ', $date_range);
    //     $start_date = format_date($start_date);
    //     $end_date   = format_date($end_date);

    //     $returnables = Returnable::whereHasMorph('returnable', [Purchase::class], function ($query) use ($supplier, $start_date, $end_date) {

    //         $query->when($supplier, function ($query) use ($supplier) {
    //             $query->whereHas('supplier', function ($query) use ($supplier) {
    //                 $query->where('id', $supplier);
    //             });
    //         })->when($start_date && $end_date, function ($query) use ($start_date, $end_date) {
    //             $query->whereDate('return_date', '>=', $start_date)
    //                 ->whereDate('return_date', '<=', $end_date);
    //         });
    //     })->orderByDesc('id')->get();

    //     return $returnables;
    // }

    public function executePurchaseReturn()
    {

        $supplier   = $this->request->supplier;
        $brand            = $this->request->brand;
        $category         = $this->request->category;
        $model            = $this->request->model;

        $date_range = $this->request->date;
        list($start_date, $end_date) = explode(' - ', $date_range);
        $start_date = format_date($start_date);
        $end_date   = format_date($end_date);

        $returnables = PurchaseReturn::when($supplier, function ($query) use ($supplier) {
            $query->whereHas('purchase.supplier', function ($query) use ($supplier) {
                $query->where('id', $supplier);
            });
        })->when($brand, function ($query) use ($brand) {
            $query->whereHas('purchaseReturnProduct.product.brand', function ($query) use ($brand) {
                $query->where('id', $brand);
            });
        })->when($category, function ($query) use ($category) {
            $query->whereHas('purchaseReturnProduct.product.brand', function ($query) use ($category) {
                $query->where('category_id', $category);
            });
        })->when($model, function ($query) use ($model) {
            $query->whereHas('purchaseReturnProduct.product', function ($query) use ($model) {
                $query->where('model_id', $model);
            });
        })->orderByDesc('id')->get();

        return $returnables;
    }

    public function executeSalePayment()
    {

        $customer   = $this->request->customer;
        $division   = $this->request->division;
        $township   = $this->request->township;
        $status   = $this->request->status;
        $date_range = $this->request->date;
        list($start_date, $end_date) = explode(' - ', $date_range);
        $start_date = format_date($start_date);
        $end_date   = format_date($end_date);

        $paymentables = Paymentable::whereHasMorph('paymentableby', [Customer::class], function ($query) use ($customer, $division, $township, $status, $start_date, $end_date) {

            $query->when($customer, function ($query) use ($customer) {
                $query->whereHas('paymentables', function ($query) use ($customer) {
                    $query->where('paymentableby_id', $customer);
                });
            })->when($division, function ($query) use ($division) {
                $query->whereHas('division', function ($query) use ($division) {
                    $query->where('id', $division);
                });
            })->when($township, function ($query) use ($township) {
                $query->whereHas('township', function ($query) use ($township) {
                    $query->where('id', $township);
                });
            })->when($status, function ($query) use ($status) {
                $query->where('payment_status', $status);
            })->when($start_date && $end_date, function ($query) use ($start_date, $end_date) {
                $query->whereDate('payment_date', '>=', $start_date)
                    ->whereDate('payment_date', '<=', $end_date);
            });
        })->orderByDesc('id')->get();

        return $paymentables;
    }

    public function executePurchasePayment()
    {
        $supplier   = $this->request->supplier;
        $status     = $this->request->status;
        $date_range = $this->request->date;

        $query = Paymentable::whereHasMorph('paymentableby', [Supplier::class], function ($query) use ($supplier, $status, $date_range) {

            if (!empty($supplier)) {
                $query->whereHas('paymentables', function ($query) use ($supplier) {
                    $query->where('paymentableby_id', $supplier);
                });
            }

            if (!empty($status)) {
                $query->where('payment_status', $status);
            }

            if (empty($supplier) && empty($status) && !empty($date_range)) {
                list($start_date, $end_date) = explode(' - ', $date_range);
                $start_date = format_date($start_date);
                $end_date   = format_date($end_date);

                $query->whereDate('payment_date', '>=', $start_date)
                      ->whereDate('payment_date', '<=', $end_date);
            }

        });

        return $query->orderByDesc('id')->get();
    }

    public function executeSaleReturn()
    {
        // $brand        = $this->request->brand;
        // $category     = $this->request->category;
        // $model        = $this->request->model;
        $order_number = $this->request->order_number;

        $date_range = $this->request->date;

        $query = PosReturn::query();

        if (!empty($order_number)) {
            $query->whereHas('pointOfSale', function ($query) use ($order_number) {
                $query->where('order_number', 'like', "%{$order_number}%");
            });
        }

        if (empty($order_number) && !empty($date_range)) {
            list($start_date, $end_date) = explode(' - ', $date_range);
            $start_date = format_date($start_date);
            $end_date   = format_date($end_date);

            $query->whereDate('return_date', '>=', $start_date)
                  ->whereDate('return_date', '<=', $end_date);
        }

        return $query->orderByDesc('id')->get();
    }

    public function executeCashBook()
    {
        $request = $this->request;
        $date_range = $this->request->date;
        list($start_date, $end_date) = explode(' - ', $date_range);
        $start_date = format_date($start_date);
        $end_date   = format_date($end_date);

        $cash_book_records = Cashbook::where(function ($query) use ($request) {
            $query->when($request->business_type, function ($query) use ($request) {
                $query->where('business_type_id', $request->business_type);
            });

            $query->when($request->account, function ($query) use ($request) {
                $query->where('account_id', $request->account);
            });
        })->when($start_date && $end_date, function ($query) use ($start_date, $end_date) {
            $query->whereDate('created_at', '>=', $start_date)
                ->whereDate('created_at', '<=', $end_date);
        })->orderByDesc('id')->get();

        return $cash_book_records;
    }

    public function executeBank()
    {
        $request = $this->request;
        $date_range = $this->request->date;
        list($start_date, $end_date) = explode(' - ', $date_range);
        $start_date = format_date($start_date);
        $end_date   = format_date($end_date);

        $cash_book_records = Cashbook::where(function ($query) use ($request) {
            $query->when($request->business_type, function ($query) use ($request) {
                $query->where('business_type_id', $request->business_type);
            });

            $query->when($request->bank, function ($query) use ($request) {
                $query->where('bank_id', $request->bank);
            });
        })->when($start_date && $end_date, function ($query) use ($start_date, $end_date) {
            $query->whereDate('created_at', '>=', $start_date)
                ->whereDate('created_at', '<=', $end_date);
        })->orderByDesc('id')->get();

        return $cash_book_records;
    }

    // public function executeBank()
    // {
    //     $request = $this->request;
    //     $date_range = $this->request->date;
    //     list($start_date, $end_date) = explode(' - ', $date_range);
    //     $start_date = format_date($start_date);
    //     $end_date   = format_date($end_date);

    //     $bank_records = Bank::when($start_date && $end_date, function ($query) use ($start_date, $end_date) {
    //         $query->whereDate('created_at', '>=', $start_date)
    //             ->whereDate('created_at', '<=', $end_date);
    //     })->orderByDesc('id')->get();

    //     return $bank_records;
    // }
}
