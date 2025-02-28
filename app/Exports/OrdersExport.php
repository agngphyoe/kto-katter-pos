<?php

namespace App\Exports;

use App\Actions\HandleFilterQuery;
use App\Models\Order;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class OrdersExport implements FromView
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
        $query        = Order::query();

        $keyword    = $this->request->search;
        $start_date = $this->request->start_date;
        $end_date   = $this->request->end_date;

        return view('exports.order', [
            'orders' => (new HandleFilterQuery(keyword: $keyword, start_date: $start_date, end_date: $end_date))->executeOrderFilter(query: $query)->get(),
            'is_export' => true,
        ]);
    }
}
