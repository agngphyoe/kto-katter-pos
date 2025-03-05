<?php

namespace App\Http\Controllers\API;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\LocationStock;
use App\Models\ProductTransfer;
use App\Actions\HandlerResponse;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Traits\GetUserLocationTrait;

class ProductReceiveAPIController extends Controller
{
    use HandlerResponse, GetUserLocationTrait;

    public function productReceive(Request $request) 
    {
        $code = $request->code;
        $products = $request->receiveAmmounts;
        
        try {
            DB::beginTransaction();

            foreach ($products as $key => $product) {
                $productReceive = ProductTransfer::where('transfer_inv_code', $code)
                                                  ->where('status', 'pending')                      
                                                  ->where('id', $product['product_transfer_id'])
                                                  ->first();
                if ($productReceive) {
                    $transferAmount = $productReceive->transfer_qty;
                    $productReceive->status = 'active';
                    $productReceive->transfer_qty = $product['quantity'];
                    $productReceive->stock_qty = $product['quantity'];
                    $productReceive->update();
                }else{
                    return $this->responseSuccessMessage(message: 'Success! Product transfer are already exits or not exit  ', status_code: 422);
                }

                $locationStockExist = LocationStock::where('location_id', $productReceive->to_location_id)
                                                    ->where('product_id', $productReceive->product_id)
                                                    ->first();
                
                if($locationStockExist){
                    $locationStockExist->quantity += $product['quantity'];
                    $locationStockExist->save();
                }else{
                   $locationStock = LocationStock::create([
                    'location_id' => $productReceive->to_location_id,
                    'product_id' => $productReceive->product_id,
                    'quantity' => $product['quantity']
                   ]);
                }

                $productId = $productReceive->product_id;
                $storeProduct = Product::where('id', $productId)->first();
                if ($storeProduct && $transferAmount > $product['quantity']) {
                    $rejectAmount = $transferAmount - $product['quantity'];
                    $storeProduct->quantity = $storeProduct->quantity + $rejectAmount;
                    $storeProduct->update();
                }
            }
            DB::commit();
                 return $this->responseSuccessMessage(message: 'Success! Product Receive Successfully ', status_code: 201);
            } catch (\Exception $e) {
                DB::rollback();
                dd($e);
                return $this->responseUnprocessable(status_code: 422, message: 'Failed!  Product Receive unsuccessfully');
            }
    }

    public function productReject(Request $request) 
    {
        $code = $request->code;
        DB::beginTransaction();
        try {

            if (ProductTransfer::where('transfer_inv_code', $code)->where('status', 'pending')->exists()) {
                ProductTransfer::where('transfer_inv_code', $code)
                            ->where('status', 'pending')
                            ->update(array('status' => 'reject'));

                $products = ProductTransfer::where('transfer_inv_code', $request->code)->get();

                foreach ($products as $product) {
                    $storeProduct = Product::find($product['product_id']);
                    $storeProduct->quantity = $storeProduct->quantity + $product->transfer_qty;
                    $storeProduct->update();
                }
                DB::commit();
                return $this->responseSuccessMessage(message: 'Success! Product Transfer Reject  Successfully ', status_code: 201);
            } else {
                return response()->json(['error' => 'Product Transfer Code not found'], 500);
            }
       } catch (\Exception $e) {
           DB::rollback();
           dd($e);
           return $this->responseUnprocessable(status_code: 422, message: 'Failed!  Product Transfer Reject  unsuccessfully');
       }
    }


    
}
