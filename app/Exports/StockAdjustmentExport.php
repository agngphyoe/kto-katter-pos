<?php

namespace App\Exports;

use App\Actions\HandleFilterQuery;
use App\Models\StockAdjustment;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Traits\GetUserLocationTrait;
use Auth;

class StockAdjustmentExport implements FromView
{
    use GetUserLocationTrait;
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
        $user = Auth::user();

        if($user->hasRole('Super Admin')){
            $query = StockAdjustment::query();
        }else{
            $query = StockAdjustment::where('created_by', auth()->user()->id);
        }

        $data = json_decode($this->request->data, true);
        $keyword = $data['search'];
        $start_date = $data['start_date'];
        $end_date = $data['end_date'];

        return view('exports.stock', [
            'stockAdjustments' => (new HandleFilterQuery(keyword: $keyword, start_date: $start_date, end_date: $end_date))->executeStockAdjustmentFilter(query: $query)->get(),
            'is_export' => true,
        ]);
    }
}
