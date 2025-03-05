<?php

namespace App\Exports\Report;

use App\Actions\ReportHandler;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;

class CustomerReportExport implements FromView
{

    protected Request $request;

    public function __construct($request)
    {
        $this->request         = $request;
    }

    public function view(): View
    {
        $date_range = $this->request->date;
        list($start_date, $end_date) = explode(' - ', $date_range);

        $customers = (new ReportHandler(request: $this->request))->executeCustomer();

        return view('exports.report.customer', [
            'customers' => $customers,
            'start_date' => $start_date,
            'end_date' => $end_date,
        ]);
    }
}
