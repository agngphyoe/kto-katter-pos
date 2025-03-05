<?php

namespace App\Exports;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\View\View;
use App\Traits\GetUserLocationTrait;
use Maatwebsite\Excel\Concerns\FromView;
use App\Actions\HandleFilterQuery;
use App\Models\ProductReturn;

class ExportProductReturn implements FromView
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
        $query = ProductReturn::whereIn('from_location_id', $this->validateLocation())
                                    ->select('return_inv_code', 'status', 'from_location_id', 'to_location_id', 'created_by', 'created_at', 'remark')
                                    ->groupByRaw('return_inv_code, status, from_location_id, to_location_id, created_by, created_at, remark');
       
         $keyword    = $this->request->search;
         $start_date = $this->request->start_date;
         $end_date   = $this->request->end_date;
         
         return view('exports.product-return', [
             'product_returns' => (new HandleFilterQuery(keyword: $keyword, start_date: $start_date, end_date: $end_date))->executeProductTransferFilter(query: $query)->get(),
             'is_export' => true,
         ]);
     }
}

