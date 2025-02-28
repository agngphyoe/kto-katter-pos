<?php

namespace App\Exports;
use Illuminate\Http\Request;
use App\Models\ProductReturn;
use App\Actions\HandleFilterQuery;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\View\View;
use App\Traits\GetUserLocationTrait;

use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\FromCollection;

class ExportProductRestore implements FromView
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
        $query = ProductReturn::whereIn('to_location_id', $this->validateLocation()) 
                               ->select('return_inv_code', 'status', 'from_location_id', 'to_location_id', 'created_by', 'created_at', 'remark')
                               ->groupByRaw('return_inv_code, status, from_location_id, to_location_id, created_by, created_at, remark');
       
        $data = json_decode($this->request->data, true);
        $keyword = $data['search'];
        $start_date = $data['start_date'];
        $end_date = $data['end_date'];
         
         return view('exports.product-restore', [
             'product_restores' => (new HandleFilterQuery(keyword: $keyword, start_date: $start_date, end_date: $end_date))->executeProductTransferFilter(query: $query)->get(),
             'is_export' => true,
         ]);
     }
}
