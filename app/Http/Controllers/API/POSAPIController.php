<?php

namespace App\Http\Controllers\API;

use App\Models\PointOfSale;
use App\Models\PointOfSaleProduct;
use App\Models\Product;
use App\Models\IMEIProduct;
use App\Models\LocationStock;
use Illuminate\Http\Request;
use App\Actions\HandlerResponse;
use App\Http\Controllers\Controller;
use App\Traits\GetUserLocationTrait;
use Illuminate\Support\Facades\Auth;
use DB;

class POSAPIController extends Controller
{

    use HandlerResponse, GetUserLocationTrait;

    public function index(Request $request)
    {
        $sales = PointOfSale::whereDate('order_date', '=', date('Y-m-d'))
                            ->with('saleConsultant','paymentType')
                            ->get();

        return $this->responseCollection(data: $sales);
    }

    public function details(Request $request)
    {
        $sale = PointOfSale::where('id', $request->pos_id)
                            ->with('saleConsultant', 'pointOfSaleProducts','paymentType','shopper','user', 'location')
                            ->first();

        foreach($sale->pointOfSaleProducts as $data){
            $product = Product::find($data->product_id);
            $data->product_name = $product->name;
            $data->product_code = $product->code;
            $data->category = $product->category->name;
            $data->brand = $product->brand->name;
            $data->model = $product->productModel->name;
            $data->design = $product->design->name ?? null;
            $data->type = $product->type->name ?? null;
            $data->image = asset('/products/image/' . $product->image);
            $data->imei = $product->is_imei 
    ? (is_array($data->imei) ? $data->imei : json_decode($data->imei, true)) 
    : [];
        }

        return $this->responseCollection(data: $sale);
    }

    public function checkout(Request $request)
    {
        $invoice_number = 'POS-' . date('YmdHis');
        $location = $this->getBranchLocations();
        
        try{
            DB::beginTransaction();

            $order = PointOfSale::create([
                'order_number' => $invoice_number,
                'order_date' => now(),
                'shopper_id' => $request->shopper_id,
                'location_id' => $location[0]['id'],
                'total_quantity' => $request->total_quantity,
                'total_amount' => $request->total_amount,
                'discount_amount' => $request->discount_amount,
                'net_amount' => $request->total_amount - $request->discount_amount,
                'paid_amount' => $request->paid_amount,
                'change_amount' => $request->change_amount,
                'bank_id' => $request->bank_id,
                'createable_id' => auth()->user()->id,
                'createable_type' => 'App\Models\Users',
                'sale_consultant_id' => $request->sale_consultant_id,
            ]);

            foreach($request->order_products as $order_product){
                $pos_product = PointOfSaleProduct::create([
                                        'point_of_sale_id' => $order->id,
                                        'product_id' => $order_product['product_id'],
                                        'unit_price' => $order_product['unit_price'],
                                        'quantity' => $order_product['quantity'],
                                        'is_promote' => $order_product['is_promoted'] ?? 0,
                                        'promotion_id' => $order_product['promotion_id'] ?? null,
                                        'price' => ($order_product['unit_price'] * $order_product['quantity']),
                                    ]);

                if($order_product['isIMEI'] == 1){
                    $pos_product->imei = json_encode($order_product['imei']);
                    $pos_product->save();

                    $imeiNumbers = json_decode($pos_product->imei, true);
                    foreach ($imeiNumbers as $imei) {
                        $imei_data = IMEIProduct::where('imei_number', $imei)
                                                    ->update([
                                                        'status' => 'Sold'
                                                    ]);
                    }
                }

                $locationStock = LocationStock::where('location_id', $location[0]['id'])
                                                ->where('product_id', $order_product['product_id'])
                                                ->first();

                $locationStock->quantity -= $order_product['quantity'];
                $locationStock->save();

                
            }
            DB::commit();
            
            return $this->responseSuccessMessage(message: "Order Created Successfully");
        }catch (\Exception $e){
            DB::rollback();
            // dd($e);
            return $this->responseUnprocessable(message: "Something Went Wrong");
        }   
    }
}
