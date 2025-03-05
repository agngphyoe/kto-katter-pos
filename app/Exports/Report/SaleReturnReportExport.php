<?php

namespace App\Exports\Report;

use App\Actions\ReportHandler;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class SaleReturnReportExport implements FromView
{
    protected Request $request;

    public function __construct($request)
    {
        $this->request         = $request;
    }
    /**
     * @return \Illuminate\Support\Collection
     */
    public function view(): View
    {
        // dd($this->request->all());
        $date_range = $this->request->date;
        list($start_date, $end_date) = explode(' - ', $date_range);

        $returnables = (new ReportHandler(request: $this->request))->executeSaleReturn();
        // dd($returnables);
        return view('exports.report.sale-return', [
            'returnables' => $returnables,
            'start_date' => $start_date,
            'end_date' => $end_date,
        ]);
    }
}
