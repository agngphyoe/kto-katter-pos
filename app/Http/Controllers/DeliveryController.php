<?php

namespace App\Http\Controllers;

use App\Actions\HandleFilterQuery;
use App\Actions\HandlePagination;
use App\Actions\ImageStoreInPublic;
use App\Constants\DeliveryStatus;
use App\Constants\ProgressStatus;
use App\Constants\SaleProcess;
use App\Http\Requests\Delivery\StoreDeliveryRequest;
use App\Models\Delivery;
use App\Models\Sale;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use DB;

class DeliveryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {

            $query      = Delivery::query();

            $keyword    = $request->search;
            // $start_date = $request->start_date;
            // $end_date   = $request->end_date;

            $query = (new HandleFilterQuery(keyword: $keyword))->executeDeliveryFilter(query: $query);

            $deliveries = $query->paginate(10);

            $html = View::make('delivery.search', compact('deliveries'))->render();

            return response()->json([
                'success' => true,
                'html' => $html,
                'pagination' => (new HandlePagination(data: $deliveries))->pagination()
            ]);
        }

        $deliveries = Delivery::orderByDesc('id')->paginate(10);

        $total_count    = Delivery::count();

        $new_sales = Sale::join('orders', 'orders.id', 'sales.saleable_id')
                            ->where('sales.is_new', 1)
                            ->orderBy('orders.order_request', 'desc')
                            ->orderByDesc('sales.id')
                            ->select('sales.*')
                            ->get();

        return view('delivery.index', compact('deliveries', 'total_count', 'new_sales'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $status = DeliveryStatus::Status;

        $delivered_sales = Delivery::pluck('sale_id')->toArray();
    
        $sales  = Sale::whereNotIn('id', $delivered_sales)->get();
        return view('delivery.create', compact('status', 'sales'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreDeliveryRequest $request)
    {
        $image = $request->receipt ? (new ImageStoreInPublic())->storePublic(destination: 'receipts/image', image: $request->receipt) : null;
        $request['image'] = $image;
        $delivery = Delivery::create($request->all());

        $sale = Sale::find($request->sale_id);
        $sale->is_new = 0;
        $sale->save();

        if ($delivery) {

            return redirect()->route('delivery')->with('success', 'Success! Delivery Created');
        }

        return back()->with('error', 'Failed! Delivery can\'t Created');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Delivery  $delivery
     * @return \Illuminate\Http\Response
     */
    public function show(Delivery $delivery)
    {

        $sale = Sale::find($delivery->sale_id);
        $customer = $sale->saleableBy;
        $order  = $sale->saleable;

        return view('delivery.detail', compact('sale', 'customer', 'order', 'delivery'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Delivery  $delivery
     * @return \Illuminate\Http\Response
     */
    public function edit(Delivery $delivery)
    {

        $types = DeliveryStatus::Status;

        // $delivered_sales = Delivery::where('sale_id', '<>', $delivery->sale_id)->pluck('sale_id')->toArray();

        // $sales  = Sale::whereNotIn('id', $delivered_sales)->whereSaleStatus(ProgressStatus::ONGOING)->get();
        $delivery->sale = Sale::find($delivery->sale_id);

        $sale = Sale::find($delivery->sale_id);
        $customer = $sale->saleableBy;
        $order  = $sale->saleable;

        return view('delivery.edit', compact('delivery', 'types', 'sale', 'customer', 'order'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Delivery  $delivery
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Delivery $delivery)
    {
        $image = $request->receipt ? (new ImageStoreInPublic())->storePublic(destination: 'receipts/image', image: $request->receipt) : null;
        $request['image'] = $image;
        
        $delivery = $delivery->update($request->all());

        if ($delivery) {

            return redirect()->route('delivery')->with('success', 'Success! Delivery Updated');
        }

        return back()->with('error', 'Failed! Delivery can\'t Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Delivery  $delivery
     * @return \Illuminate\Http\Response
     */
    public function destroy(Delivery $delivery)
    {

        Sale::where('id', $delivery->sale_id)
                ->update([
                    'is_new' => 1
                ]);

        $delivery->delete();

        return response()->json([
            'message' => 'The record has been deleted successfully.',
            'status' => 200,
        ], 200);
    }

    public function getNewSales()
    {
        $new_sales = Sale::whereDoesntHave('delivery')
            ->join('orders', function ($join) {
                $join->on('sales.saleable_id', '=', 'orders.id')
                    ->where('sales.saleable_type', '=', 'App\Models\Order');
            })
            ->orderBy('orders.order_request', 'desc')
            ->orderByDesc('sales.id')
            ->select('sales.*')
            ->get();

        $new_sales_count = $new_sales->count();
        $html = View::make('sale.new-sale', compact('new_sales'))->render();

        return response()->json([
            'success' => true,
            'html' => $html,
            'new_sales_count' => $new_sales_count,
        ]);
    }

    public function getSaleData(Request $request){
        
        $sale = Sale::find($request->sale);
        $customer = $sale->saleableBy;
        $order  = $sale->saleable;

        return view('delivery.sale-data', compact('sale', 'customer', 'order'));
    }
}
