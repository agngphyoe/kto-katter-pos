<?php

namespace App\Exports;

use App\Actions\HandleFilterQuery;
use App\Models\Permission;
use App\Models\PointOfSale;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class POSExport implements FromView
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
        $query        = PointOfSale::query();

        $data = json_decode($this->request->data, true);
        $keyword = $data['search'];
        $start_date = $data['start_date'];
        $end_date = $data['end_date'];

        return view('exports.pos', [
            'sales' => (new HandleFilterQuery(keyword: $keyword, start_date: $start_date, end_date: $end_date))->executePOSFilter(query: $query)->get(),
            'is_export' => true,
        ]);
    }
}
