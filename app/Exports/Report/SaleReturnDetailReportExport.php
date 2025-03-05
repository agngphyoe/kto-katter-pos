<?php

namespace App\Exports\Report;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class SaleReturnDetailReportExport implements FromView
{
    protected $return;

    public function __construct($return)
    {
        $this->return = $return;
    }

    public function view(): View
    {
        return view('exports.report.sale-return-detail', [
            'return' => $this->return,
            'returnProducts' => $this->return->posReturnProducts,
        ]);
    }
}
