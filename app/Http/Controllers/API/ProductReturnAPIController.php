<?php

namespace App\Http\Controllers\API;

use Carbon\Carbon;
use App\Models\Product;
use App\Models\Location;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\LocationStock;
use App\Models\ProductReturn;
use App\Constants\PrefixCodeID;
use App\Actions\HandlerResponse;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Traits\GetUserLocationTrait;
use App\Http\Resources\ProductResource;
use App\Http\Resources\LocationResource;
use App\Http\Resources\ProductCollection;
use App\Http\Resources\ProductStockResource;
use App\Http\Resources\ProductReturnResource;

class ProductReturnAPIController extends Controller
{

    use HandlerResponse, GetUserLocationTrait;
    public function index(Request $request)
    {
                        
        $product_returns_paginate = ProductReturn::with('user','fromLocationName', 'toLocationName')
                                            ->where('created_by' , auth()->user()->id)
                                            ->whereIn('from_location_id', $this->validateLocation())
                                            ->where('status', 'pending')
                                            ->select('return_inv_code', 'status', 'from_location_id', 'to_location_id', 'created_by')
                                            ->groupByRaw('return_inv_code, status, from_location_id, to_location_id, created_by')
                                            ->paginate(10);

        
        $products_return = $product_returns_paginate->items();

        $productData = [
            'data' => ProductReturnResource::collection($products_return),
            'links' => [
                'first' => $product_returns_paginate->url(1),
                'last' => $product_returns_paginate->url($product_returns_paginate->lastPage()),
                'prev' => $product_returns_paginate->previousPageUrl(),
                'next' => $product_returns_paginate->nextPageUrl(),
            ],
            'meta' => [
                'current_page' => $product_returns_paginate->currentPage(),
                'per_page' => $product_returns_paginate->perPage(),
                'total' => $product_returns_paginate->total(),
            ],
            'has_more' => $product_returns_paginate->hasMorePages(),
        ];

        $total_count    = ProductReturn::count();
        $data = [
            'product_returns' =>  $productData,
            'total' => $total_count,
        ];
        return $this->responseCollection(data: $data);
    }

    public function productReturnDetails($product)
    {
        $products_return = ProductReturn::with( 'user', 'fromLocationName', 'toLocationName' , 'product')
                                  ->where('return_inv_code', $product)
                                  ->get()
                                  ->map(function ($item) {
                                    if (!Str::startsWith($item->product->image, ['http://', 'https://'])) {
                                        $item->product->image = asset('/products/image/') . '/' . $item->product->image;
                                    }
                                    return $item;
                                });
                                
        return $this->responseCollection(ProductReturnResource::collection($products_return));
    }

    public function productReturnStore(Request $request) 
    {
        $login_user = Auth()->user();
        $status = 'pending';
        $type = config('productStatus.productTransferType.return');
        
        $exist_record = ProductReturn::orderByDesc('id')->first();
        $invoice_number = getAutoGenerateID(PrefixCodeID::RETURN, $exist_record?->return_inv_code);
        DB::beginTransaction();
       
        try {

            $products =  $request->products;
             
            foreach ($products as $product) {
                $productRtn = new ProductReturn();
                $productRtn->return_inv_code = $invoice_number;
                $productRtn->from_location_id = $request->from_location_id;
                $productRtn->to_location_id = $request->to_location_id;
                $productRtn->product_id = $product['product_id'];
                $productRtn->quantity = $product['quantity'];
                $productRtn->status = $status;
                $productRtn->created_by = $login_user->id;
                $productRtn->save();

            }

            DB::commit();

            return $this->responseSuccessMessage(message: '!Product Return created successfully', status_code: 201);
        } catch (\Exception $e) {

            DB::rollback();
            // dd($e);
            return $this->responseSuccessMessage(message: '!Product Return created unsuccessfully', status_code: 201);
        }
    }

    public function getProductReturnInfo() 
    {
    
        $locations_from = collect( Location::join('location_types as types', 'types.id', 'locations.location_type_id')
                        ->where('types.sale_type', '!=', 'Store')
                        ->select('locations.*')
                        ->get());

        $locations_to = collect(Location::join('location_types as types', 'types.id', 'locations.location_type_id')
                        ->where('types.sale_type', 'Store')
                        ->select('locations.*')
                        ->get());

        $stockProductsPaginator = LocationStock::join('products', 'products.id', 'location_stocks.product_id')
                                                ->join('brands', 'brands.id', 'products.brand_id')
                                                ->join('categories', 'categories.id', 'products.category_id')
                                                ->select(
                                                'products.*',
                                                'location_stocks.quantity as count',
                                                'brands.name as brand' , 
                                                'categories.name as category',
                                                \DB::raw("CONCAT('" . asset('/products/image/') . "',  '/',products.image) AS image"))
                                                ->orderBy('products.id', 'desc')
                                                ->paginate(10);

        $products = $stockProductsPaginator->items();
          
        $productData = [
            'data' => ProductStockResource::collection($products),
            'links' => [
                'first' => $stockProductsPaginator->url(1),
                'last' => $stockProductsPaginator->url($stockProductsPaginator->lastPage()),
                'prev' => $stockProductsPaginator->previousPageUrl(),
                'next' => $stockProductsPaginator->nextPageUrl(),
            ],
            'meta' => [
                'current_page' => $stockProductsPaginator->currentPage(),
                'per_page' => $stockProductsPaginator->perPage(),
                'total' => $stockProductsPaginator->total(),
            ],
            'has_more' => $stockProductsPaginator->hasMorePages(),
        ];
        

        $data = [
            'to' => LocationResource::collection($locations_to),
            'from' => LocationResource::collection($locations_from),
            'products' => $productData,
        ];
        return $this->responseCollection(data : $data);
    }


}
