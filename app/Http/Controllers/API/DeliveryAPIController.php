<?php

namespace App\Http\Controllers\API;

use App\Models\Sale;
use App\Models\Delivery;
use App\Models\Address;
use Illuminate\Http\Request;
use App\Constants\SaleProcess;
use App\Actions\HandlerResponse;
use App\Constants\DeliveryStatus;
use App\Actions\ImageStoreInPublic;
use App\Http\Controllers\Controller;
use App\Http\Resources\SaleResource;
use App\Traits\GetUserLocationTrait;
use App\Http\Resources\DeliveryResource;
use Illuminate\Support\Facades\Validator;

class DeliveryAPIController extends Controller
{
    use HandlerResponse, GetUserLocationTrait;
    
    public function index(Request $request)
    {

        $total_count = Delivery::count();
        $deliveries = Delivery::with('sale', 'user')
                                ->where('created_by' , auth()->user()->id)
                                ->orderByDesc('id')
                                // ->select('id', 'status',)
                                ->get();

        foreach ($deliveries as $delivery) { 
            $sale = $delivery->sale;         
            $sale->division = Address::where('code', $sale->division)
                                            ->value('name');

            $sale->township = Address::where('code', $sale->township)
                                            ->value('name');

        }
        
        $new_sales = Sale::whereDoesntHave('delivery')
            ->join('orders', function ($join) {
                $join->on('sales.saleable_id', '=', 'orders.id')
                    ->where('sales.saleable_type', '=', 'App\Models\Order');
            })
            ->where('created_by' , auth()->user()->id)
            ->orderBy('orders.order_request', 'desc')
            ->orderByDesc('sales.id')
            ->select('sales.*')
            ->get();

        foreach ($new_sales as $data) {
            $data->division = Address::where('code', $data->division)
                                ->value('name');

            $data->township = Address::where('code', $data->township)
                                ->value('name');
        }
        
        $data = [
                'new_sales' =>  SaleResource::collection($new_sales),
                'deliveries' => $deliveries,
                'sale_total' => $total_count,
        ];
       
        return $this->responseCollection(data: $data);
        
    }

    public function create()
    {
        $status = DeliveryStatus::Status;

        $delivered_sales = Delivery::pluck('sale_id')->where('created_by' , auth()->user()->id)->toArray();
    
        $sales  = Sale::whereNotIn('id', $delivered_sales)->where('created_by' , auth()->user()->id)->whereSaleProcess(SaleProcess::TYPES['Delivery'])->get();

        $data = [
            'sales' =>  SaleResource::collection($sales),
            'status' => $status
         ];
   
         return $this->responseCollection(data: $data);
    }


    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'sale_id' => ['required', 'exists:sales,id'],
            'status' => ['required'],
            'receipt' => ['required', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048']
        ]);
        if ($validator->fails()) {
            return $this->responseValidationErrorMessage($validator->errors(), 422);
        }

        $image = $request->receipt ? (new ImageStoreInPublic())->storePublic(destination: 'receipts/image', image: $request->receipt) : null;
      
        try {          

            Delivery::create([
                "sale_id" => $request->sale_id,
                "status" => $request->status,
                "image"=> $image,
                "created_by" => auth()->user()->id
            ]);

            return $this->responseSuccessMessage(message: 'Success! Delivery Created', status_code: 201);
        } catch (\Throwable $th) {
            return $this->responseSuccessMessage(message: 'Failed! Delivery can\'t Created', status_code: 500);
        }

    }


}
