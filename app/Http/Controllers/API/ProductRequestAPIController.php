<?php

namespace App\Http\Controllers\API;

use Carbon\Carbon;
use App\Models\Product;
use App\Models\Location;
use Illuminate\Http\Request;
use App\Models\ProductRequest;
use App\Constants\PrefixCodeID;
use App\Actions\HandlerResponse;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Traits\GetUserLocationTrait;
use App\Http\Resources\ProductResource;
use App\Http\Resources\LocationResource;
use App\Http\Resources\ProductRequestResource;

class ProductRequestAPIController extends Controller
{
    use HandlerResponse, GetUserLocationTrait;

    public function getProductInfo() 
    {
    
        $locations_from = collect( Location::join('location_types as types', 'types.id', 'locations.location_type_id')
                        ->where('types.sale_type', '!=', 'Store')
                        ->select('locations.*')
                        ->get());

        $locations_to = collect(Location::join('location_types as types', 'types.id', 'locations.location_type_id')
                        ->where('types.sale_type', 'Store')
                        ->select('locations.*')
                        ->get());
       
        $productsPaginator = Product::where('quantity', '>', 0)->paginate(10);

        $products = $productsPaginator->items();
      
        $productData = [
            'data' => ProductResource::collection($products),
            'links' => [
                'first' => $productsPaginator->url(1),
                'last' => $productsPaginator->url($productsPaginator->lastPage()),
                'prev' => $productsPaginator->previousPageUrl(),
                'next' => $productsPaginator->nextPageUrl(),
            ],
            'meta' => [
                'current_page' => $productsPaginator->currentPage(),
                'per_page' => $productsPaginator->perPage(),
                'total' => $productsPaginator->total(),
            ],
            'has_more' => $productsPaginator->hasMorePages(),
        ];
        

        $data = [
            'to' => LocationResource::collection($locations_to),
            'from' => LocationResource::collection($locations_from),
            'products' => $productData,
        ];
        return $this->responseCollection(data : $data);
    }

    public function productRequestStore(Request $request) 
    {
            $login_user = Auth()->user();
            $status = 'pending';
            $type = config('productStatus.productRequestType.new_request');

            $exist_record = ProductRequest::orderByDesc('id')->first();
    
            $invoice_number = getAutoGenerateID(PrefixCodeID::PO_REQUEST, $exist_record?->request_inv_code);
    
            DB::beginTransaction();
    
            try {
                
                $products =  $request->products;
                foreach ($products as $product) {
                    $productRequest = new ProductRequest();
                    $productRequest->request_inv_code = $invoice_number;
                    $productRequest->from_location_id = $request->from_location_id;
                    $productRequest->to_location_id = $request->to_location_id;
                    $productRequest->remark = $request->remark;
                    $productRequest->product_id = $product['product_id'];
                    $productRequest->request_qty = $product['quantity'];
                    $productRequest->quantity = 0;
                    $productRequest->status = $status;
                    $productRequest->created_by = $login_user->id;
                    $productRequest->save();
                }
    
                DB::commit();
    
                return $this->responseSuccessMessage(message: 'Success! Product Transfer Created', status_code: 201);
            } catch (\Exception $e) {
                DB::rollback();
                return $e;
                return $this->responseUnprocessable(status_code: 422, message: 'Failed! Product Transfer cannot Created.');
            }
    }

    public function index(Request $request)
    {
        $keyword = $request->search;
        if($keyword){
            $productRequests = ProductRequest::where('created_by', auth()->user()->id)
                                            ->where('status', 'pending')
                                            ->distinct('request_inv_code')
                                            ->where(function ($query) use ($keyword) {
                                                $query->where('request_inv_code', 'like', '%' . $keyword . '%');
                                            })
                                            ->select('request_inv_code')
                                            ->paginate(10);

            foreach ($productRequests as $productRequest) {
                $productRequest->request_data = ProductRequest::where('request_inv_code', $productRequest->request_inv_code)
                                                        ->select('product_transfer_id', 'from_location_id',
                                                        'to_location_id', 'product_id', 'request_qty',
                                                        'quantity', 'status', 'created_at', 'updated_at')
                                                        ->get();

                foreach ($productRequest->request_data as $data) {
                    $from = Location::where('id', $data->from_location_id)->value('location_name');
                    $to = Location::where('id', $data->to_location_id)->value('location_name');

                    $data->from_location_name = $from;
                    $data->to_location_name = $to;

                    $data->product = Product::where('id', $data->product_id)
                                            ->select('id', 'code', 'name', 'retail_price', 'wholesale_price', 'image')
                                            ->first();
                    
                    $data->product->image = asset('/products/image/') .'/'.  $data->product->image;
                }            
            }
        }else{
            $productRequests = ProductRequest::where('created_by', auth()->user()->id)
                                            ->where('status', 'pending')
                                            ->distinct('request_inv_code')
                                            ->select('request_inv_code')
                                            ->paginate(10);

            foreach ($productRequests as $productRequest) {
                $productRequest->request_data = ProductRequest::where('request_inv_code', $productRequest->request_inv_code)
                                                        ->select('product_transfer_id', 'from_location_id',
                                                        'to_location_id', 'product_id', 'request_qty',
                                                        'quantity', 'status', 'created_at', 'updated_at')
                                                        ->get();

                foreach ($productRequest->request_data as $data) {
                    $from = Location::where('id', $data->from_location_id)->value('location_name');
                    $to = Location::where('id', $data->to_location_id)->value('location_name');

                    $data->from_location_name = $from;
                    $data->to_location_name = $to;

                    $data->product = Product::where('id', $data->product_id)
                                            ->select('id', 'code', 'name', 'retail_price', 'wholesale_price', 'image')
                                            ->first();
                    
                    $data->product->image = asset('/products/image/') .'/'.  $data->product->image;
                }            
            }
        }
        return $this->responseCollection(data: $productRequests);
    }

    public function productRequestDetails(Request $request)
    {
        $code = ProductRequest::where('request_inv_code', $request->request_inv_code)
                                            ->distinct('request_inv_code')
                                            ->value('request_inv_code');

        $request_datas = ProductRequest::where('request_inv_code', $request->request_inv_code)
                                            ->select('product_transfer_id', 'from_location_id',
                                            'to_location_id', 'product_id', 'request_qty',
                                            'quantity', 'status', 'created_at', 'updated_at')
                                            ->get();

        foreach ($request_datas as $data) {
            $data->product = Product::where('id', $data->product_id)
                                            ->select('id', 'code', 'name', 'retail_price', 'wholesale_price', 'image')
                                            ->first();

            $data->product->image = asset('/products/image/') .'/'.  $data->product->image;
        }
        $response = [];
        $response = [
            'request_inv_code' => $code,
            'request_data' => $request_datas,
        ];
        return $this->responseCollection(data: $response);
    }

}
