<?php

namespace App\Exports\Report;

use App\Models\PointOfSale;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;

class SaleDetailReportExport implements FromView
{
    protected $pointOfSale;

    public function __construct(PointOfSale $pointOfSale)
    {
        $this->pointOfSale = $pointOfSale;
    }

    public function view(): View
    {
        return view('exports.report.sale-detail', [
            'sale' => $this->pointOfSale,
            'products' => $this->pointOfSale->pointOfSaleProducts,
        ]);
    }
}

