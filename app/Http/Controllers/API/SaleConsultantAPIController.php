<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SaleConsultant;
use App\Actions\HandlerResponse;
use App\Traits\GetUserLocationTrait;

class SaleConsultantAPIController extends Controller
{
    use HandlerResponse, GetUserLocationTrait;

    public function index(Request $request)
    {
        if($request->search){
            $keyword = '%'. $request->search . '%';

            $sale_consultants = SaleConsultant::whereIn('location_id', $this->validateLocation())
                                                ->where('name', 'LIKE', $keyword)
                                                ->get();
        }else{
            $sale_consultants = SaleConsultant::whereIn('location_id', $this->validateLocation())
                                                ->get();
        }
        
        return $this->responseCollection(data: $sale_consultants);
    }
}
