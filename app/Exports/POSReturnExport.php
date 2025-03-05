<?php

namespace App\Exports;

use App\Actions\HandleFilterQuery;
use App\Models\PosReturn;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class POSReturnExport implements FromView
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
        $query        = PosReturn::where('created_by', auth()->user()->id);

        $data = json_decode($this->request->data, true);
        $keyword = $data['search'];
        $start_date = $data['start_date'];
        $end_date = $data['end_date'];

        return view('exports.pos-return', [
            'returns' => (new HandleFilterQuery(keyword: $keyword, start_date: $start_date, end_date: $end_date))->executePOSFilter(query: $query)->get(),
            'is_export' => true,
        ]);
    }
}
