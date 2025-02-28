<?php

namespace App\Exports\Report;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class PurchaseReturnDetailReportExport implements FromView
{
    protected $return_product;

    public function __construct($return_product)
    {
        $this->return_product = $return_product;
    }

    public function view(): View
    {
        return view('exports.report.purchase-return-detail', [
            'return_product' => $this->return_product,
            'returnProducts' => $this->return_product->purchaseReturnProducts,
        ]);
    }
}
