<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Shopper;

class ShopperController extends Controller
{
    public function store(Request $request){
        try {
            $code = 'SID' . date('YmdHis'); 
            $requestData = $request->all(); 
    
            $requestData = array_merge($requestData, ['code' => $code]);
    
            Shopper::create($requestData);

            $shoppers = Shopper::all();
    
            return response()->json(['message' => 'Shopper created successfully', 'data' => $shoppers], 201);
            
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to create shopper: ' . $e->getMessage()], 500);
        }
    }
}
