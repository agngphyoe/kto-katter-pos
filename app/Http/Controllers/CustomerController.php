<?php

namespace App\Http\Controllers;

use App\Actions\HandleFilterQuery;
use App\Actions\HandlePagination;
use App\Actions\ImageStoreInPublic;
use App\Constants\PrefixCodeID;
use App\Constants\ProgressStatus;
use App\Constants\SaleProcess;
use App\Constants\SaleType;
use App\Constants\OrderRequest;
use App\Events\CustmoerCreatedEvent;
use App\Http\Requests\Customer\StoreCustomerRequest;
use App\Http\Requests\Customer\UpdateCustomerRequest;
use App\Models\Customer;
use App\Models\Division;
use App\Models\Order;
use App\Models\Sale;
use App\Models\Township;
use App\Models\Address;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\View;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $customers = Customer::latest()->take(5)->get();

        $customer_orders = Order::where('order_status', ProgressStatus::ONGOING)->whereDate('created_at', Carbon::today())->latest()->take(10)->get();

        $total_count    = Customer::count();


        return view('customer.index', compact('customers', 'customer_orders', 'total_count', 'new_customers'));
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function list(Request $request)
    {
        if ($request->ajax()) {

            $query        = Customer::query();

            $keyword    = $request->search;
            $start_date = $request->start_date;
            $end_date   = $request->end_date;

            $customers = (new HandleFilterQuery(keyword: $keyword, start_date: $start_date, end_date: $end_date))->executeCustomerFilter(query: $query)->paginate(10);

            $html = View::make('customer.search', compact('customers'))->render();

            return response()->json([
                'success' => true,
                'html' => $html,
                'pagination' => (new HandlePagination(data: $customers))->pagination()
            ]);
        }

        $customers = Customer::orderByDesc('id')
                            ->paginate(10);

        $total_count    = Customer::count();

        $new_customers = Customer::whereIsNew(1)
                                    ->orderByDesc('id')
                                    ->take(10)
                                    ->get();

        return view('customer.list', compact('customers', 'new_customers', 'total_count'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function saleList(Request $request)
    {
        if ($request->ajax()) {

            $query        = Customer::query();

            $keyword    = $request->search;
            $start_date = $request->start_date;
            $end_date   = $request->end_date;

            $query = (new HandleFilterQuery(keyword: $keyword, start_date: $start_date, end_date: $end_date))->executeCustomerFilter(query: $query);

            $customers = $query->get();

            $first_customer = $customers[0] ?? null;

            $html = View::make('customer.sale-search-list', compact('customers', 'first_customer'))->render();

            return response()->json([
                'success' => true,
                'html' => $html,
            ]);
        }

        $customers = Customer::all();

        $total_count    = $customers->count();

        $first_customer = Customer::first();

        return view('customer.sale-list', compact('customers', 'first_customer', 'total_count'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function paymentList(Request $request)
    {
        if ($request->ajax()) {

            $query    = Customer::query();

            $keyword    = $request->search;
            $start_date = $request->start_date;
            $end_date   = $request->end_date;

            $query = (new HandleFilterQuery(keyword: $keyword, start_date: $start_date, end_date: $end_date))->executeCustomerFilter(query: $query);

            $customers = $query->get();

            $first_customer = $customers[0] ?? null;

            $html = View::make('customer.sale-search-list', compact('customers', 'first_customer'))->render();

            return response()->json([
                'success' => true,
                'html' => $html,
            ]);
        }

        $customers = Customer::all();

        return view('customer.payment-list', compact('customers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $exist_record = Customer::latest()->first();

        $user_number = getAutoGenerateID(PrefixCodeID::CUSTOMER, $exist_record?->user_number);

        $divisions = DB::table('addresses')
                        ->where('type', 'state')
                        ->orderBy('name', 'asc')
                        ->get();

        return view('customer.create', compact('divisions', 'user_number'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $image = $request->image ? (new ImageStoreInPublic())->storePublic(destination: 'customers/image', image: $request->image) : null;

        $phone = str_replace("+", "", $request->phone);

        $exist_record = Customer::latest()->first();
        $user_number = getAutoGenerateID(PrefixCodeID::CUSTOMER, $exist_record?->user_number); 

        $request = $request->all();
        $request['c_type'] = 'all';
        $request['image'] = $image;
        $request['is_new'] = 0;
        $request['phone'] = $phone;
        $request['user_number'] = $user_number;
        $request['createable_id'] = auth()->user()->id;
        $request['createable_type'] = 'App\Models\User';

        $customer = Customer::create($request);

        if ($customer) {

            // event(new CustmoerCreatedEvent($customer));

            return redirect()->route('customer-list')->with('success', 'Success! Customer Created');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function show(Customer $customer)
    {
        $customer_sales = $customer->sales();

        $cash_count = $customer_sales->whereActionType(SaleType::TYPES['Cash'])->count();

        $credit_count = $customer_sales->whereActionType(SaleType::TYPES['Credit'])->count();

        $payment_success = $customer_sales->whereSaleStatus(ProgressStatus::COMPLETE)->count();

        $payment_ongoing = $customer_sales->whereSaleStatus(ProgressStatus::ONGOING)->count();

        $delivery_count = $customer_sales->whereSaleProcess(SaleProcess::TYPES['Delivery'])->count();

        $total_products = $customer->sales()->sum('total_quantity');

        $sale_info = [
            'cash' => $cash_count,
            'credit' => $credit_count,
        ];

        $payment_info = [
            'success' => $payment_success,
            'ongoing' => $payment_ongoing,
        ];

        return view('customer.detail', compact('customer', 'sale_info', 'payment_info', 'delivery_count', 'total_products'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function edit(Customer $customer)

    {
        $divisions = Address::where('type', 'state')
                            ->get();

        $townships = Address::where('code', 'like', '%'.$customer->division.'%')
                            ->where('type', 'township')
                            ->get();

        return view('customer.edit', compact('customer', 'divisions', 'townships'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Customer $customer)
    {
        $image  = $customer->image;

        if ($request->hasFile('image')) {

            File::delete(public_path('customers/image/' . $customer->image));

            $image = (new ImageStoreInPublic())->storePublic(destination: 'customers/image', image: $request->image);
        }

        $request = $request->all();
        $request['image'] = $image;

        $customer = $customer->update($request);

        if ($customer) {

            return redirect('customer')->with('success', 'Success! Customer Updated');
        }

        return back()->with('failed', 'Failed! Customer not updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Customer $customer)
    {
        $image  = $customer->image;

        if ($image) {

            File::delete(public_path('customers/image/' . $image));
        }

        $customer->delete();

        return response()->json([
            'message' => 'The record has been deleted successfully.',
            'status' => 200,
        ], 200);
    }

    public function getTownshipData(Request $request)
    {
        $division_id = $request->input('division_id');
        
        $townships = DB::table('addresses')
                        ->where('code', 'like', '%'.$division_id.'%')
                        ->where('type', 'township')
                        ->orderBy('name', 'asc')
                        ->get();
                        
        $html = View::make('customer.township-data', compact('townships'))->render();
        return response()->json([
            'success' => true,
            'html' => $html,
        ]);
    }

    public function listCard(Request $request)
    {
        $customer_id = $request->input('customer_id');

        $customer = Customer::find($customer_id);

        $html = View::make('customer.list-card', compact('customer'))->render();

        return response()->json([
            'success' => true,
            'html' => $html,
        ]);
    }

    public function getNewCustomers()
    {
        $new_customers = Customer::whereIsNew(1)->orderByDesc('id')->get();
        $new_customer_count = $new_customers->count();
        $html = View::make('customer.new-customer', compact('new_customers'))->render();

        return response()->json([
            'success' => true,
            'html' => $html,
            'new_customer_count' => $new_customer_count,
        ]);
    }

    public function customerNewDetail(Request $request)
    {
        $customer = Customer::find($request->id);
        $customer->is_new = 0;
        $customer->save();
        return $this->show($customer);
    }

    public function getCustomerOrders($id){
        $orders = Order::where('customer_id', $id)
                        ->orderByDesc('id')
                        ->paginate(10);

        $total_count    = Order::where('customer_id', $id)
                                ->count();

        $normal_count    = Order::where('customer_id', $id)
                                    ->whereOrderRequest(OrderRequest::OrderRequests['Normal'])
                                    ->count();

        $urgent_count    = Order::where('customer_id', $id)
                                    ->whereOrderRequest(OrderRequest::OrderRequests['Urgent'])
                                    ->count();

        $new_orders = Order::where('customer_id', $id)
                            ->whereIsNew(1)->orderByRaw("FIELD(order_request, 'Urgent', 'Normal')")
                            ->orderByDesc('id')->take(10)
                            ->get();

        $order_count_info = [
            'normal_count' => $normal_count,
            'urgent_count' => $urgent_count,
        ];
        return view('customer.customer-orders-list', compact('orders', 'total_count', 'order_count_info', 'new_orders'));
    }

    public function getCustomerSales($id){
        $sales          = Sale::where('saleableby_id', $id)
                                ->orderByDesc('id')
                                ->paginate(10);
     
        $total_count    = Sale::where('saleableby_id', $id)
                                ->count();

        $new_sales = Sale::where('saleableby_id', $id)
                        ->whereSaleStatus(ProgressStatus::ONGOING)
                        ->join('orders', function ($join) {
                            $join->on('sales.saleable_id', '=', 'orders.id')
                                ->where('sales.saleable_type', '=', 'App\Models\Order');
                        })
                        ->orderBy('orders.order_request', 'desc')
                        ->orderByDesc('sales.id')
                        ->select('sales.*')
                        ->take(10)
                        ->get();

        return view('customer.customer-sales-list', compact('sales', 'total_count', 'new_sales'));
    }
}
