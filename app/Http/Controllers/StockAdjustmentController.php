<?php

namespace App\Http\Controllers;

use App\Actions\HandleFilterQuery;
use App\Actions\HandlePagination;
use App\Actions\UpdateProductQuantity;
use App\Constants\AdjustmentType;
use App\Http\Requests\StockAdjustment\FinalFormRequest;
use App\Http\Requests\StockAdjustment\SecondFormRequest;
use App\Models\Product;
use App\Models\StockAdjustment;
use App\Models\StockAdjustmentProduct;
use App\Models\Location;
use App\Models\IMEIProduct;
use App\Models\LocationStock;
use App\Models\DistributionTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use App\Traits\GetUserLocationTrait;
use Auth;

class StockAdjustmentController extends Controller
{
    use GetUserLocationTrait;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user = Auth::user();

        if($user->hasRole('Super Admin')){
            $query = StockAdjustment::query();
        }else{
            $query = StockAdjustment::where('created_by', auth()->user()->id);
        }

        if ($request->ajax()) {

            $keyword    = $request->search;
            $start_date = $request->start_date;
            $end_date   = $request->end_date;

            $query = (new HandleFilterQuery(keyword: $keyword, start_date: $start_date, end_date: $end_date))->executeStockAdjustmentFilter(query: $query);

            $stockAdjustments = $query->paginate(10);

            $html = View::make('product-stock.search', compact('stockAdjustments'))->render();

            return response()->json([
                'success' => true,
                'html' => $html,
                'pagination' => (new HandlePagination(data: $stockAdjustments))->pagination()
            ]);
        }

        $stockAdjustments = $query->paginate(10);

        $total_count    = $query->get()->count();

        return view('product-stock.index', compact('stockAdjustments', 'total_count'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function createFirst(Request $request)
    {
        $location_id = $request->location_id;
        if($request->ajax()){
            $keyword                = $request->input('search');
            $location_id            = $request->input('location_id');
            $selected_products      = $request->input('selectedData');
            $selected_products      = $selected_products ?? [];

            $query = Product::join('location_stocks as ls', 'ls.product_id', 'products.id')
                                ->where('ls.location_id', $request->location_id)
                                ->select('products.*', 'ls.quantity as quantity');

            $query = (new HandleFilterQuery(keyword: $keyword))->executeProductFilter(query: $query);

            $products = $query->orderByDesc('id')->paginate(20);

            $html = View::make('product.search-product-list', compact('products', 'selected_products'))->render();

        return response()->json([
            'success' => true,
            'html' => $html,
        ]);
        }

        $products = Product::join('location_stocks as ls', 'ls.product_id', 'products.id')
                            ->where('ls.location_id', $location_id)
                            ->select('products.*', 'ls.quantity as quantity')
                            ->get();

        return view('product-stock.create-first', compact('products', 'location_id'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function createSecond(Request $request)
    {
        $location = Location::find($request->location_id);
        $products_data = json_decode($request->selected_products, true);

        if(!$products_data){
            return back()->with('error', 'No Product is Selected !');
        }
        $product_ids = [];
        foreach ($products_data as $data) {
            $product_ids [] = $data['id'];
        }

        $products = Product::join('location_stocks as ls', 'ls.product_id', 'products.id')
                            ->where('ls.location_id', $location->id)
                            ->whereIn('ls.product_id', $product_ids)
                            ->select('products.*', 'ls.quantity as quantity')
                            ->get();

        $types = AdjustmentType::TYPES;

        return view('product-stock.create-second', compact('products','location', 'types'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function createFinal(Request $request)
    {
        $product = Product::find($request->product_id);

        $data = $request->all();

        return view('product-stock.create-final', compact('data', 'product'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $location = Location::find($request->location_id);
        $location_type = $location->getLocationTypeByIdAttribute();

        try {
            DB::beginTransaction();

            $stockAdjustment = StockAdjustment::create([
                        'remark' => $request->remark,
                        'adjustment_date' => date('Y-m-d'),
                        'created_by' => Auth::user()->id,
                        'location_id' => $location->id,
                    ]);

            foreach ($request->products_id as $product_id) {

                $productData = LocationStock::where('product_id', $product_id)
                                        ->where('location_id', $location->id)
                                        ->first();

                if($request->status[$product_id] == 'remove' && $productData->quantity < $request->adjustAmount[$product_id]){
                    throw new \Exception('Something went Wrong !');
                }

                if($productData->product->is_imei){
                    $imei = str_replace('\"', '"', $request->imei_data[$product_id]);
                    if (empty($imei)) {
                        throw new \Exception('IMEI data is required for IMEI products');
                    }

                    $imeiArray = json_decode($imei, true);
                    if (json_last_error() !== JSON_ERROR_NONE || !is_array($imeiArray)) {
                        throw new \Exception('Invalid IMEI data format');
                    }

                    $imeiArray = array_filter($imeiArray, function($value) {
                        return !empty($value);
                    });

                    if (empty($imeiArray)) {
                        throw new \Exception('No valid IMEI numbers provided');
                    }

                    if (count($imeiArray) != $request->adjustAmount[$product_id]) {
                        throw new \Exception('Number of IMEI entries does not match adjustment amount');
                    }

                    if($request->status[$product_id] == 'add'){
                        foreach ($imeiArray as $imei) {
                            $existImei = IMEIProduct::where('imei_number', $imei)->first();
                            if ($existImei) {
                                throw new \Exception('Duplicate entry. Record already exists.');
                            }
                            $imeiProduct = IMEIProduct::create([
                                'product_id' => $product_id,
                                'imei_number' => $imei,
                                'status' => 'Available',
                                'location_id' => $location->id,
                            ]);
                        }

                        $productData->quantity += $request->adjustAmount[$product_id];
                        $productData->save();

                    }else{
                        $existImeis = IMEIProduct::where('imei_number', $imeiArray)->first();
                        if (!$existImeis) {
                            throw new \Exception('Record does not exists.');
                        }

                        IMEIProduct::where('status', 'Available')
                                    ->whereIn('imei_number', $imeiArray)
                                    ->delete();

                        $productData->quantity -= $request->adjustAmount[$product_id];
                        $productData->save();
                    }

                }else{
                    if($request->status[$product_id] == 'add'){
                        $productData->quantity += $request->adjustAmount[$product_id];
                        $productData->save();


                    }else{
                        $productData->quantity -= $request->adjustAmount[$product_id];
                        $productData->save();
                    }
                }

                $stockAdjustmentProduct = StockAdjustmentProduct::create([
                    'stock_adjustment_id' => $stockAdjustment->id,
                    'product_id' => $product_id,
                    'status' => $request->status[$product_id],
                    'quantity' => $request->adjustAmount[$product_id],
                ]);

            }
            DB::commit();

            return redirect()->route('product-stock')->with('success', 'Success! Stock Adjustment created');
        } catch (\Exception $e) {
            DB::rollback();

            $errorMessage = 'Failed! Stock Adjustment cannot be created.';

            if (str_contains($e->getMessage(), 'Duplicate entry')) {
                $errorMessage = 'Failed! IMEI number already exists.';
            } else if (str_contains($e->getMessage(), 'Record does not exists')) {
                $errorMessage = 'Failed! IMEI number does not exist.';
            } else if (str_contains($e->getMessage(), 'IMEI data is required')) {
                $errorMessage = 'Failed! IMEI data is required.';
            } else if (str_contains($e->getMessage(), 'Number of IMEI entries')) {
                $errorMessage = 'Failed! Number of IMEI entries must match the adjustment amount.';
            }

            return back()->with('error', $errorMessage);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\StockAdjustment  $stockAdjustment
     * @return \Illuminate\Http\Response
     */
    public function show(StockAdjustment $stockAdjustment)
    {

        $products = StockAdjustmentProduct::where('stock_adjustment_id', $stockAdjustment->id)
                                            ->get();

        return view('product-stock.detail', compact('stockAdjustment', 'products'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\StockAdjustment  $stockAdjustment
     * @return \Illuminate\Http\Response
     */
    public function edit(StockAdjustment $stockAdjustment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\StockAdjustment  $stockAdjustment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, StockAdjustment $stockAdjustment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\StockAdjustment  $stockAdjustment
     * @return \Illuminate\Http\Response
     */
    public function destroy(StockAdjustment $stockAdjustment)
    {
        //
    }

    public function chooseLocation(){
        $locationIds = $this->validateLocation();

        $locations = Location::whereIn('id', $locationIds)
                                ->get();

        return view('product-stock.choose-location', compact('locations'));
    }

    public function searchProduct(Request $request)
    {
        $keyword = $request->input('search');
        $location_id = $request->input('location_id');
        $location = Location::find($location_id);
        $location_type = $location->getLocationTypeByIdAttribute();

        if($location_type->sale_type == 'Store'){
            $products = Product::where('location_id', $location_id)
                                ->where('name', 'like', '%' .$keyword . '%')
                                ->get();
        }else{
            $products = Product::join('location_stocks as ls', 'ls.product_id', 'products.id')
                                ->join('locations as l', 'l.id', 'ls.location_id')
                                ->where('ls.location_id', $location_id)
                                ->where('name', 'like', '%'. $keyword . '%')
                                ->select('products.id', 'products.name', 'ls.quantity')
                                ->get();
        }

        $products = $products ?? [];

        $html = View::make('product-stock.search-product-list', compact('products'))->render();

        return response()->json([
            'success' => true,
            'html' => $html,
        ]);
    }
}
