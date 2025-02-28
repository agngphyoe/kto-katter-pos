<?php

namespace App\Exports;

use App\Actions\HandleFilterQuery;
use App\Models\Supplier;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class SupplierExport implements FromView
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
        $query        = Supplier::select('name', 'user_number', 'phone', 'contact_name', 'contact_phone', 'created_by', 'created_at');

        $data = json_decode($this->request->data, true);
        $keyword = $data['search'];
        $start_date = $data['start_date'];
        $end_date = $data['end_date'];

        return view('exports.supplier', [
            'suppliers' => (new HandleFilterQuery(keyword: $keyword, start_date: $start_date, end_date: $end_date))->executeSupplierFilter(query: $query)->get(),
            'is_export' => true
        ]);
    }
}
