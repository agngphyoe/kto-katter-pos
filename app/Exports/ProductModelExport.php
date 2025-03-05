<?php

namespace App\Exports;

use App\Actions\HandleFilterQuery;
use App\Models\ProductModel;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class ProductModelExport implements FromView
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
        $query        = ProductModel::select('name', 'prefix', 'brand_id', 'created_by', 'created_at');

        $data = json_decode($this->request->data, true);
        $keyword    = $data['search'];
        $start_date = $data['start_date'];
        $end_date   = $data['end_date'];

        return view('exports.product-model', [
            'product_models' => (new HandleFilterQuery(keyword: $keyword, start_date: $start_date, end_date: $end_date))->executeKeyDataForProductFilter(query: $query)->get(),
            'is_export' => true
        ]);
    }
}
