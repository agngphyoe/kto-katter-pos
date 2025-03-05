<?php

namespace App\Http\Controllers\API;

use Exception;
use App\Models\Bank;
use App\Models\Sale;
use App\Models\Order;
use App\Models\Customer;
use App\Models\Division;
use App\Models\Address;
use App\Models\Productable;
use App\Models\Product;
use App\Models\LocationStock;
use App\Constants\SaleType;
use Illuminate\Http\Request;
use App\Constants\SaleProcess;
use App\Constants\PrefixCodeID;
use App\Actions\HandlerResponse;
use App\Events\SaleCreatedEvent;
use App\Constants\ProgressStatus;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Http\Resources\BankCollection;
use App\Http\Resources\SaleCollection;
use App\Http\Resources\OrderCollection;
use App\Http\Requests\SaleCreateRequest;
use App\Http\Resources\DivisionCollection;
use App\Http\Resources\orderselectCollection;
use App\Actions\ExecuteSaleAndPaymentableStore;
use App\Http\Resources\CustomerchartCollection;
use App\Http\Resources\CustomerSelectCollection;
use Illuminate\Support\Facades\Gate;

class SalesAPIController extends Controller
{
    use HandlerResponse;

    public function saleslist(Request $request)
    {
        $keyword  = $request->search;
        if($keyword){
            $sales = Sale::where('created_by', auth()->user()->id)
                        ->where('invoice_number', 'like' , '%'. $keyword . '%')
                        ->paginate(10);

            foreach ($sales as $sale) {
                $customer = Customer::find($sale->saleableby_id);
                $sale->division = Address::where('code', $sale->division)
                                            ->value('name');
                $sale->township = Address::where('code', $sale->township)
                                            ->value('name');
                $sale->customer_name = $customer->name;
                $sale->sale_products = Productable::where('productable_type', 'App\Models\Order')
                                                    ->where('productable_id', $sale->id)
                                                    ->select('product_id', 'quantity', 'wholesale_sell_price', 'amount')
                                                    ->get();

                $sale->delivery = $sale->delivery;

                foreach ($sale->sale_products as $data) {
                    $product = Product::find($data->product_id);

                    $data->product_name = $product->name;
                    $data->category_name = $product->category->name;
                    $data->brand_name = $product->brand->name;
                    $data->model_name = $product->productModel->name;
                    $data->img = asset('/products/image/') .'/'.  $product->image;
                }
            }
        }else{
            $sales = Sale::where('created_by', auth()->user()->id)
                        ->paginate(10);

            foreach ($sales as $sale) {
                $customer = Customer::find($sale->saleableby_id);

                $sale->division = Address::where('code', $sale->division)
                                            ->value('name');
                $sale->township = Address::where('code', $sale->township)
                                            ->value('name');
                $sale->customer_name = $customer->name;
                $sale->sale_products = Productable::where('productable_type', 'App\Models\Order')
                                                    ->where('productable_id', $sale->saleable_id)
                                                    ->select('product_id', 'quantity', 'wholesale_sell_price', 'amount')
                                                    ->get();
                $sale->delivery = $sale->delivery;

                foreach ($sale->sale_products as $data) {
                    $product = Product::find($data->product_id);

                    $data->product_name = $product->name;
                    $data->category_name = $product->category->name;
                    $data->brand_name = $product->brand->name;
                    $data->model_name = $product->productModel->name;
                    $data->img = asset('/products/image/') .'/'.  $product->image;
                }
            }
        }

        return $this->responseCollection(data: $sales); 
    }

    public function getCustomersWithSalableOrders(Request $request)
    {
        // Get the currently authenticated user's ID
        //$userId = auth()->user()->id;

        // Retrieve the customers who have orders that are salable and were created by the authenticated user
        $customers = Customer::whereHas('orders', function ($query) {
            $query->where('order_status', 'ongoing');
        });
        //$customers = Customer::where('createable_id', $userId)->whereHas('orders', function ($query) {
        //    $query->where('order_status', 'ongoing');
        //});
        // Transform the customers using the CustomerSelectResource and wrap it in a CustomerSelectCollection, then paginate the results
        $customers = new CustomerSelectCollection($customers->paginate(10));

        // Return the customers as a JSON response using the responseCollection method
        return $this->responseCollection(data: $customers);
    }

    public function getCustomerOrders(Request $request)
    {
        // Retrieve the specified customer's orders with an "ongoing" status
        $customerId = $request->customer_id;
        $orders = Order::where('customer_id', $customerId)->where('order_status', 'ongoing');
        // Return the orders as a JSON response using the responseCollection method
        return $this->responseCollection(data: new orderselectCollection($orders->paginate(10)));
    }

    public function generateSaleinvoice(Request $request)
    {
        if ($request->order_id) {
            $exist_record = Sale::latest()->first();

            $invoice_number = getAutoGenerateID(PrefixCodeID::SALE_INVOICE, $exist_record?->invoice_number);

            $sale_types     = SaleType::TYPES;

            $banks  = Bank::all();

            $divisions      = Address::where('type', 'state')
                                        ->orderBy('name')
                                        ->get();

            $sale_process   = SaleProcess::TYPES;

            $order = Order::find($request->order_id);

            $data = [
                'invoice_number' => $invoice_number,
                'sale_types' => $sale_types,
                'sale_process' => $sale_process,
                'banks' => new BankCollection($banks),
                'division' => new DivisionCollection($divisions),
                'order' => $order,
            ];

            return $this->responseCollection(data: $data);
        } else {
            return $this->responseUnprocessable(status_code: 500, message: "Please Select orders first");
        }
    }

    public function peryearfunction(Request $request)
    {
        //$customer_count = DB::Select('MONTHNAME(created_at),');
        $year = $request->has('year') ? $request->year : now()->year;
        $results = Sale::selectRaw('MONTHNAME(created_at) as month, count(*) as count')
            ->whereYear('created_at', $year)->where('created_by', auth()->user()->id)
            ->groupBy(DB::raw('MONTHNAME(created_at)'))->get();
        return $this->responseCollection(data: new CustomerchartCollection($results));
    }

    public function per_week_chart_data(Request $request)
    {
        $month = $request->has('month') ? $request->month : now()->month;
        $year = $request->has('year') ? $request->year : now()->year;

        $results = Sale::selectRaw('FLOOR((DAYOFMONTH(Date(created_at)) - 1) / 7) + 1 as month, count(*) as count')
            ->whereMonth('created_at', $month)->whereYear('created_at', $year)
            ->where('created_by', auth()->user()->id)
            ->groupBy(DB::raw('month'))->get();
        return $this->responseCollection(data: new CustomerchartCollection($results));
    }

    public function salesstore(SaleCreateRequest $request)
    {
        $data = $request->input('data');

        try {
            DB::beginTransaction();

            $order      = Order::find($data['order_id']);

            $customer   = Customer::find($data['customer_id']);


            $sale = (new ExecuteSaleAndPaymentableStore())->executeSalAPIStore(saleable_type: $order, saleable_by: $customer, data: $data);
            
            $order->update([
                'order_status' => ProgressStatus::COMPLETE ?? 'Complete',
            ]);

            $products = Productable::where('productable_type', 'App\Models\Order')
                                    ->where('productable_id', $order->id)
                                    ->select('product_id', 'quantity')
                                    ->get();

            foreach ($products as $product) {
                $productData = Product::find($product->product_id);
                $locationStock = LocationStock::where('location_id', $order->location_id)
                                                ->where('product_id', $product->product_id)
                                                ->first();
                if($product->is_imei== 1){
                // $imei = IMEIProduct::whereIn('imei_number', $product['imei'])
                //                     ->update(['status' => IMEIStatus::Sold]);
                }
                $locationStock->quantity -= $product->quantity;
                $locationStock->update();                 
            }
            
            if ($data['action_type'] == SaleType::TYPES['Cash']) {
               
                $sale->update([
                    'sale_status' => ProgressStatus::COMPLETE ?? 'Complete',
                    'total_paid_amount' => $sale->total_amount,
                    'remaining_amount' => 0
                ]);

                $payment_info = [
                    'paymentable' => $sale,
                    'paymentableby' => $customer,
                    'payment_type' => $data['payment_type'],
                    'status' => ProgressStatus::COMPLETE,
                    'payment_date' => format_date($data['action_date']),
                    'amount' => $sale->total_amount,
                    'remaining_amount' => 0,
                ];

                (new ExecuteSaleAndPaymentableStore())->executePaymentStore(payment_info: $payment_info);
            }
           
            if ($sale) {
                event(new SaleCreatedEvent($sale));
            }
            DB::commit();
            return $this->responseCollection(data: $sale);
        } catch (\Exception $e) {
            // return $e;
            DB::rollback();
            return $this->responseUnprocessable(status_code: 500, message: $e);
        }
    }

    public function getSaleInfo(Request $request){
       
    }
}
