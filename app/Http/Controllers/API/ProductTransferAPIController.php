<?php

namespace App\Http\Controllers\API;

use Carbon\Carbon;
use App\Models\Product;
use App\Models\Location;
use Illuminate\Http\Request;
use App\Constants\PrefixCodeID;
use App\Models\ProductTransfer;
use App\Actions\HandlerResponse;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Traits\GetUserLocationTrait;
use App\Http\Resources\ProductResource;
use App\Http\Resources\LocationResource;
use App\Http\Resources\ProductCollection;
use App\Http\Resources\ProductTransferCollection;
use App\Http\Resources\ProductTransferResource;

class ProductTransferAPIController extends Controller
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

    public function productTransferStore(Request $request) 
    {
            $login_user = Auth()->user();
            $status = 'pending';
            $type = config('productStatus.productTransferType.new_transfer');

            $exist_record = ProductTransfer::orderByDesc('id')->first();
    
            $invoice_number = getAutoGenerateID(PrefixCodeID::TRANSFER, $exist_record?->transfer_inv_code);
    
            DB::beginTransaction();
    
            try {
                
                $products =  $request->products;
                foreach ($products as $product) {
                    $productTran = new ProductTransfer();
                    $productTran->transfer_inv_code = $invoice_number;
                    $productTran->from_location_id = $request->from_location_id;
                    $productTran->to_location_id = $request->to_location_id;
                    $productTran->product_id =  $product['product_id'];
                    $productTran->transfer_qty = $product['quantity'];
                    $productTran->stock_qty =  $product['quantity'];
                    $productTran->status = $status;
                    $productTran->transfer_type = $type;
                    $productTran->created_by = $login_user->id;
                    $productTran->transfer_date = Carbon::createFromFormat('m/d/Y', $request->date ?? now()->format('m/d/Y'))->format('Y-m-d');
                    $productTran->save();
    
                    $storeProduct = Product::find($product['product_id']);
                    if (($storeProduct->quantity - $product['quantity']) < 0) {
                        return $this->responseSuccessMessage(message: '!Product have not enough', status_code: 201);
                    }else{
                        $storeProduct->quantity = ($storeProduct->quantity - $product['quantity']) ;
                        $storeProduct->update();
                    }
                }
    
                DB::commit();
    
                return $this->responseSuccessMessage(message: 'Success! Product Transfer Created', status_code: 201);
            } catch (\Exception $e) {
                DB::rollback();
                dd($e);
                return $this->responseUnprocessable(status_code: 422, message: 'Failed! Product Transfer cannot Created.');
            }
    }

    public function index(Request $request)
    {
        $productTransfersQuery = ProductTransfer::with('user', 'fromLocationName', 'toLocationName')
                                            ->whereIn('to_location_id', $this->validateLocation())
                                            ->when($request->filter, function ($query) use ($request) {
                                                $query->where('transfer_inv_code', 'like', '%' . $request->filter . '%')
                                                    ->orWhereHas('user', function ($query) use ($request) {
                                                        $query->where('name', 'like', '%' . $request->filter . '%');
                                                    });
                                            })
                                            ->where('status', 'pending')
                                            ->select('transfer_inv_code', 'status', 'from_location_id', 'to_location_id', 'created_by')
                                            ->groupByRaw('transfer_inv_code, status, from_location_id, to_location_id, created_by');
        // Fetch total count
        $totalCount = $productTransfersQuery->count();
     
        $data = [
                'product_transfers' =>  ProductTransferResource::collection($productTransfersQuery->paginate(10)),
                'total' => $totalCount,
        ];
        return $this->responseCollection(data: $data);

    }

    public function productTransferDetails($product)
    {
        $products = ProductTransfer::with( 'user', 'fromLocationName', 'toLocationName' , 'product')->where('transfer_inv_code', $product)->get();
        return $this->responseCollection(ProductTransferResource::collection($products));
    }

}
