<?php

namespace App\Exports\Report;

use App\Models\Purchase;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;

class PurchaseDetailReportExport implements FromView
{
    protected $purchase;

    public function __construct(Purchase $purchase)
    {
        $this->purchase = $purchase;
    }

    public function view(): View
    {
        return view('exports.report.purchase-detail', [
            'purchase' => $this->purchase,
            'products' => $this->purchase->purchaseProducts,
        ]);
    }
}
