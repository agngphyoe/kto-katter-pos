<?php

namespace App\Exports;

use App\Actions\HandleFilterQuery;
use App\Actions\ReportHandler;
use App\Models\Brand;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;

class BrandExport implements FromView
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
        $query        = Brand::select('name', 'prefix', 'category_id', 'created_by', 'created_at');

        $data = json_decode($this->request->data, true);
        $keyword    = $data['search'];
        $start_date = $data['start_date'];
        $end_date   = $data['end_date'];

        return view('exports.brand', [
            'brands' => (new HandleFilterQuery(keyword: $keyword, start_date: $start_date, end_date: $end_date))->executeKeyDataForProductFilter(query: $query)->get(),
            'is_export' => true
        ]);
    }
}
