<?php

namespace App\Exports;

use Illuminate\Http\Request;
use App\Models\ProductRequest;
use App\Models\ProductTransfer;
use App\Actions\HandleFilterQuery;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\View\View;
use App\Traits\GetUserLocationTrait;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\FromCollection;

class ExportProductRequests implements FromView
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
        $query = ProductRequest::whereIn('from_location_id', $this->validateLocation())
                                 ->select('request_inv_code', 'status', 'from_location_id', 'to_location_id', 'created_by', 'remark')
                                 ->groupByRaw('request_inv_code, status, from_location_id, to_location_id, created_by, remark');
       
        $data = json_decode($this->request->data, true);
        $keyword = $data['search'];
        $start_date = $data['start_date'];
        $end_date = $data['end_date'];
         
         return view('exports.product-request', [
             'product_requests' => (new HandleFilterQuery(keyword: $keyword, start_date: $start_date, end_date: $end_date))->executeProductOrderRequestFilter(query: $query)->get(),
             'is_export' => true,
         ]);
     }
}
