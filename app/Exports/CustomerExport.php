<?php

namespace App\Exports;

use App\Actions\HandleFilterQuery;
use App\Models\Customer;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class CustomerExport implements FromView
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
        $query        = Customer::select('name', 'user_number', 'c_type', 'phone', 'township', 'division', 'created_at');

        $keyword    = $this->request->search;
        $start_date = $this->request->start_date;
        $end_date   = $this->request->end_date;

        return view('exports.customer', [
            'customers' => (new HandleFilterQuery(keyword: $keyword, start_date: $start_date, end_date: $end_date))->executeCustomerFilter(query: $query)->get(),
            'is_export' => true
        ]);
    }
}
