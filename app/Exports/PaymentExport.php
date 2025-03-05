<?php

namespace App\Exports;

use App\Actions\HandleFilterQuery;
use App\Models\Paymentable;
use App\Models\Sale;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PaymentExport implements FromView
{
    /**
     * @return \Illuminate\Support\Collection
     */

    protected Request $request;

    public function __construct($request)
    {
        $this->request         = $request;
    }

    public function view(): View
    {
        $query        = Paymentable::where('paymentable_type', Sale::class)->select('paymentable_id', DB::raw('MAX(id) as id'))->groupBy('paymentable_id')->orderByDesc('id');

        $keyword    = $this->request->search;
        $start_date = $this->request->start_date;
        $end_date   = $this->request->end_date;
        return view('exports.payment', [
            'payments' => (new HandleFilterQuery(keyword: $keyword, start_date: $start_date, end_date: $end_date))->executePaymentFilter(query: $query)->get(),
            'is_export' => true,
        ]);
    }
}
