<?php

namespace App\Http\Controllers\API;

use App\Actions\HandlerResponse;
use App\Actions\UpdateProductQuantity;
use App\Constants\OrderRequest;
use App\Constants\PrefixCodeID;
use App\Events\OrderCreatedEvent;
use App\Http\Controllers\Controller;
use App\Http\Requests\API\OrderStoreRequest;
use App\Http\Resources\CustomerOrderCollection;
use App\Http\Resources\CustomerOrderResource;
use App\Http\Resources\CustomerSelectCollection;
use App\Http\Resources\LocationStockResource;
use App\Http\Resources\Orderchart2Collection;
use App\Http\Resources\OrderchartCollection;
use App\Http\Resources\OrderCollection;
use App\Http\Resources\ProductCollection;
use App\Models\Customer;
use App\Models\LocationStock;
use App\Models\Order;
use App\Models\Product;
use App\Models\Location;
use App\Models\Productable;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Validator;

class OrderAPIController extends Controller
{
    use HandlerResponse;

    public function customerorder(Request $request)
    {
        Log::info($request->customer_id);
        $customer = Customer::find($request->customer_id);
        //dd($customer);
        Log::info(json_encode($customer));
        if ($customer) {
            $orders = $customer->orders();
            return $this->responseCollection(data: new CustomerOrderCollection($orders->paginate(10)));
        }
        return $this->responseUnprocessable(message: 'Customer does not exist.');
    }

    public function per_year_chart_data(Request $request)
    {
        //$customer_count = DB::Select('MONTHNAME(created_at),');
        $year = $request->has('year') ? $request->year : now()->year;
        $results = Order::selectRaw('MONTHNAME(created_at) as month, count(*) as count')
            ->whereYear('created_at', $year)->where('createable_id', auth()->user()->id)
            ->groupBy(DB::raw('MONTHNAME(created_at)'))->get();
        return $this->responseCollection(data: new OrderchartCollection($results));
    }

    public function per_month_chart_data(Request $request)
    {
        $month = $request->has('month') ? $request->month : now()->month;
        $year = $request->has('year') ? $request->year : now()->year;
        $results = Order::selectRaw('order_status as status, count(*) as count')->where('createable_id', auth()->user()->id)->whereMonth('created_at', $month)->whereYear('created_at', $year)
            ->groupBy('order_status')->get();
        return $this->responseCollection(data: new Orderchart2Collection($results));
    }

    public function per_week_chart_data(Request $request)
    {
        $month = $request->has('month') ? $request->month : now()->month;
        $year = $request->has('year') ? $request->year : now()->year;

        //Log::debug();

        $results = Order::selectRaw('FLOOR((DAYOFMONTH(Date(created_at)) - 1) / 7) + 1 as month, count(*) as count')
            ->whereMonth('created_at', $month)->whereYear('created_at', $year)
            ->where('createable_id', auth()->user()->id)
            ->groupBy(DB::raw('month'))->get();
        return $this->responseCollection(data: new OrderchartCollection($results));
    }

    public function orderLocationStockProducts(Request $request)
    {
        $stockProducts = LocationStock::join('products', 'products.id', 'location_stocks.product_id')
                                        ->join('brands', 'brands.id', 'products.brand_id')
                                        ->join('categories', 'categories.id', 'products.category_id')
                                        ->select(
                                        'products.*',
                                        'location_stocks.quantity as count',
                                        'brands.name as brand' , 
                                        'categories.name as category',
                                        \DB::raw("CONCAT('" . asset('/products/image/') . "',  '/',products.image) AS image"))
                                        ->where('location_stocks.location_id', $request->location_id)
                                        ->orderBy('products.id', 'desc')
                                        ->paginate(10);                       
         return $this->responseCollection(data: new LocationStockResource($stockProducts));
    }

    public function index(Request $request)
    {

        Log::debug($request->has('filter'));
        //'order_number'  => $this->order_number,
        //'customer_id' => $this->customer_id,
        //'customer'      => new CustomerResource($this->customer),
        //'order_status' => $this->order_status,
        //'order_request' => $this->order_request,
        //'total_quantity' => $this->total_quantity,
        //'total_amount'  => $this->total_amount,
        //'order_date'    => $this->order_date,

        $orders = Order::where('createable_id', auth()->user()->id)
            ->when($request->order_number, function ($query) use ($request) {
                $query->where('order_number', 'like', '%' . $request->order_number . '%');
            })->when('filter', function ($query) use ($request) {
                $query->where('order_number', 'like', '%' . $request->filter . '%')
                    ->orWhereHas('customer', function ($query) use ($request) {
                        $query->where('name', 'like',  '%' . $request->filter . '%');
                    });
            })
            ->when($request->customer_name, function ($query) use ($request) {
                $query->whereHas('customer', function ($query) use ($request) {
                    $query->where('name', 'like', '%' . $request->customer_name . '%');
                });
            })->where('createable_id', auth()->user()->id)->orderByDesc('created_at');



        return $this->responseCollection(data: new OrderCollection($orders->paginate(10)));
    }

    public function ordercount(Request $request)
    {
        $orders = Order::where('createable_id', auth()->user()->id)->get();
        $ordercount = count($orders);
        return $ordercount;
    }

    public function getOrderInfo(Request $request)
    {
        $order = Order::find($request->order_id);
        $order->customer = Customer::where('id', $order->customer_id)
                                    ->value('name');

        $order->location = Location::where('id', $order->location_id)
                                        ->value('location_name');
        
        $order->order_products = Productable::where('productable_type', 'App\Models\Order')
                                            ->where('productable_id', $order->id)
                                            ->select('product_id', 'quantity', 'wholesale_sell_price', 'amount')
                                            ->get();

        foreach ($order->order_products as $data) {
            $product = Product::find($data->product_id);

            $data->product_name = $product->name;
            $data->category_name = $product->category->name;
            $data->brand_name = $product->brand->name;
            $data->model_name = $product->productModel->name;
            $data->img = asset('/products/image/') .'/'.  $product->image;
        }

        return $this->responseCollection(data: $order);        
    }

    public function store(OrderStoreRequest $request)
    {
        $customer_id    = $request->customer_id;
        $order_request  = $request->order_request;
        $order_products = $request->products;
        $location_id    = $request->location_id;
        $order_product_data = [];
        $total_amount = 0;
        $total_quantity = 0;
        
        $exist_record = Order::latest()->first();

        $order_number = getAutoGenerateID(PrefixCodeID::ORDER, $exist_record?->order_number);

       

        try {
            DB::beginTransaction();
            foreach ($order_products as $order_product) {
                
                $product_id = $order_product['id'];
                $price      = $order_product['wholesale_price'];
                $quantity   = $order_product['quantity'];
                $amount     = $price * $quantity;
                $total_amount     += $amount;
                $total_quantity     += $quantity;

                (new UpdateProductQuantity(id: $product_id, quantity: $quantity))->decreaseProductQuantity();


                $order_product_data[] = [
                    'product_id' => $product_id,
                    'quantity' => $quantity,
                    'wholesale_sell_price' => $price,
                    'amount' => $amount,
                ];
            }
           
            $order = Order::create([
                'order_number' => $order_number,
                'order_date' => now(),
                'customer_id' => $customer_id,
                'order_request' => $order_request,
                'total_amount' => $total_amount,
                'total_quantity' => $total_quantity,
                'location_id' => $request->location_id,
            ]);
            
             $order->orderProducts()->createMany($order_product_data);
             
            if ($order) {
                event(new OrderCreatedEvent($order));
            }

            DB::commit();

            return $this->responseSuccessMessage(message: 'Successfully Order Created.', status_code: 201);
        } catch (\Exception $e) {

            DB::rollback();

            return $this->responseUnprocessable(status_code: 422, message: 'Something went wrong.');
        }
    }
}
