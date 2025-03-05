<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Shopper;
use App\Actions\HandlerResponse;

class ShopperAPIController extends Controller
{
    use HandlerResponse;
    
    public function index(Request $request)
    {
        if($request->search){
            $keyword = '%'. $request->search . '%';

            $shoppers = Shopper::where('name', 'LIKE', $keyword)
                                ->orWhere('code', 'LIKE', $keyword)
                                ->orWhere('phone', 'LIKE', $keyword)
                                ->get();
        }else{
            $shoppers = Shopper::orderBy('id', 'desc')->get();
        }
        
        return $this->responseCollection(data: $shoppers);
    }

    public function store(Request $request)
    {
        try {
            $code = 'SID' . date('YmdHis'); 
            $requestData = $request->all(); 
    
            $requestData = array_merge($requestData, ['code' => $code]);
    
            $shopper = Shopper::create($requestData);

            return $this->responseSuccess(data: $shopper, message: 'Shopper Created Successfully');
            
        } catch (\Exception $e) {
            return $this->responseUnprocessable(message: 'Something Wrong');
        }
    }
}
