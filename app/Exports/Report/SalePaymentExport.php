<?php

namespace App\Exports\Report;

use App\Actions\ReportHandler;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class SalePaymentExport implements FromView
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
        $date_range = $this->request->date;
        list($start_date, $end_date) = explode(' - ', $date_range);

        $paymentables = (new ReportHandler(request: $this->request))->executeSalePayment();

        return view('exports.report.sale-payment', [
            'paymentables' => $paymentables,
            'start_date' => $start_date,
            'end_date' => $end_date,
        ]);
    }
}
