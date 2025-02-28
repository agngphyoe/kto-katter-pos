<?php

namespace App\Exports;

use App\Actions\HandleFilterQuery;
use App\Models\Purchase;
use App\Models\PurchaseReturn;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class PurchaseReturnExport implements FromView
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
        $query        = PurchaseReturn::select('id', 'remark', 'purchase_id', 'return_date', 'return_quantity', 'return_amount', 'created_by', 'created_at');

        $data = json_decode($this->request->data, true);
        $keyword = $data['search'];
        $start_date = $data['start_date'];
        $end_date = $data['end_date'];

        return view('exports.purchase-return', [
            'purchase_returns' => (new HandleFilterQuery(keyword: $keyword, start_date: $start_date, end_date: $end_date))->executeProductPurchaseReturnFilter(query: $query)->get(),
            'is_export' => true
        ]);
    }
}
