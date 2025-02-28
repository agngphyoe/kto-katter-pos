<?php

namespace App\Exports;

use App\Actions\HandleFilterQuery;
use App\Models\Paymentable;
use App\Models\Purchase;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PurchasePaymentExport implements FromView
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
        $query        = Paymentable::where('paymentable_type', Purchase::class)->select('paymentable_id', DB::raw('MAX(id) as id'))->groupBy('paymentable_id')->orderByDesc('id');

        $data = json_decode($this->request->data, true);
        $keyword = $data['search'];
        $start_date = $data['start_date'];
        $end_date = $data['end_date'];
        
        return view('exports.purchase-payment', [
            'payments' => (new HandleFilterQuery(keyword: $keyword, start_date: $start_date, end_date: $end_date))->executePaymentFilter(query: $query)->get(),
            'is_export' => true,
        ]);
    }
}
