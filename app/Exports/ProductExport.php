<?php

namespace App\Exports;

use App\Actions\HandleFilterQuery;
use App\Models\Product;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class ProductExport implements FromView
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
        $query        = Product::select('code', 'name', 'category_id', 'brand_id', 'model_id', 'type_id', 'design_id', 'quantity', 'price', 'created_by', 'created_at');

        $keyword    = $this->request->search;
        $start_date = $this->request->start_date;
        $end_date   = $this->request->end_date;

        return view('exports.product', [
            'products' => (new HandleFilterQuery(keyword: $keyword, start_date: $start_date, end_date: $end_date))->executeProductFilter(query: $query)->get(),
            'is_export' => true
        ]);
    }
}
