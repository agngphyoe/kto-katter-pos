<?php

namespace App\Exports;

use App\Actions\HandleFilterQuery;
use App\Models\Purchase;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class PurchaseExport implements FromView
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
        $query        = Purchase::select('id', 'invoice_number', 'supplier_id', 'total_amount', 'discount_amount', 'cash_down', 'action_type', 'total_quantity', 'action_date', 'created_by', 'total_paid_amount');

        $data = json_decode($this->request->data, true);
        $keyword = $data['search'];
        $start_date = $data['start_date'];
        $end_date = $data['end_date'];

        return view('exports.purchase', [
            'purchases' => (new HandleFilterQuery(keyword: $keyword, start_date: $start_date, end_date: $end_date))->executePurchaseFilter(query: $query)->get(),
            'is_export' => true
        ]);
    }
}
