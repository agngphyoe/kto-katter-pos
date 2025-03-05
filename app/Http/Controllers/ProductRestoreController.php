<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Actions\HandleFilterQuery;
use App\Actions\HandlePagination;
use App\Models\Product;
use App\Models\Location;
use App\Models\ProductReturn;
use App\Models\ProductTransfer;
use App\Models\ProductPrefix;
use App\Models\LocationStock;
use App\Models\DistributionTransaction;
use App\Models\IMEIProduct;
use App\Constants\PrefixCodeID;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;

use App\Traits\GetUserLocationTrait;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;
use Carbon\Carbon;

class ProductRestoreController extends Controller
{
    use GetUserLocationTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {

            $keyword     = $request->input('search');
            // $start_date  = $request->input('start_date');
            // $end_date    = $request->input('end_date');
            $query       = ProductReturn::query();

            $query = (new HandleFilterQuery(keyword: $keyword))->executeProductReturnRestoreFilter(query: $query);

            $product_restores = $query->whereIn('to_location_id', $this->validateLocation())
                                        ->selectRaw('
                                            return_inv_code,
                                            CASE 
                                                WHEN SUM(CASE WHEN status = "partial" THEN 1 ELSE 0 END) > 0 THEN "partial"
                                                ELSE MAX(status)
                                            END as status,
                                            from_location_id,
                                            to_location_id,
                                            created_by,
                                            created_at,
                                            remark,
                                            MAX(id) as id
                                        ')
                                        ->groupBy('return_inv_code', 'from_location_id', 'to_location_id', 'created_by', 'created_at', 'remark')
                                        ->orderBy('id', 'desc')
                                        ->paginate(10);

            $html = View::make('product-restore.search', compact('product_restores'))->render();

            return response()->json([
                'success' => true,
                'html' => $html,
                'pagination' => (new HandlePagination(data: $product_restores))->pagination()
            ]);
        }

        $product_restores = ProductReturn::whereIn('to_location_id', $this->validateLocation())
                                        ->selectRaw('
                                            return_inv_code,
                                            CASE 
                                                WHEN SUM(CASE WHEN status = "partial" THEN 1 ELSE 0 END) > 0 THEN "partial"
                                                ELSE MAX(status)
                                            END as status,
                                            from_location_id,
                                            to_location_id,
                                            created_by,
                                            created_at,
                                            remark,
                                            MAX(id) as id
                                        ')
                                        ->groupBy('return_inv_code', 'from_location_id', 'to_location_id', 'created_by', 'created_at', 'remark')
                                        ->orderBy('id', 'desc')
                                        ->paginate(10);

        $total_count    = ProductReturn::count();

        return view('product-restore.index', compact('product_restores', 'total_count'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $code = $request->code;

        try {
            DB::beginTransaction();

           $productReturns  = ProductReturn::where('return_inv_code', $request->code)
                                            ->where('status', 'pending')
                                            ->get();

            foreach ($productReturns as $productReturn) {

                $productReturn->status = 'active';
                $productReturn->save();

                $toLocationStock = LocationStock::where('location_id', $productReturn->to_location_id)
                                                    ->where('product_id', $productReturn->product_id)
                                                    ->first();

                $toLocationStock->quantity += $productReturn->quantity;
                $toLocationStock->save();

                if($productReturn->imei_numbers != null){
                    $imeiNumbers = json_decode($productReturn->imei_numbers, true);
                    foreach ($imeiNumbers as $imei) {
                        $imei_data = IMEIProduct::where('imei_number', $imei)->first();
                        $imei_data->location_id = $productReturn->to_location_id;
                        $imei_data->save();
                    }
                }

                $return_quantity = $productReturn->quantity;
                $availableStocks = DistributionTransaction::where('product_id', $productReturn->product_id)
                                                            ->where('location_id', $productReturn->to_location_id)
                                                            ->orderBy('created_at', 'desc')
                                                            ->get();
                
                foreach ($availableStocks as $stock) {

                    if($stock->quantity > $stock->remaining_quantity){
                        $restock_qty = $stock->quantity - $stock->remaining_quantity;
                        if($restock_qty <= $return_quantity){
                            $return_quantity -= $restock_qty;                           
            
                            $stock->remaining_quantity += $restock_qty;
                            $stock->save();
                        }else{
                            $restock_qty = 0;

                            $stock->remaining_quantity += $return_quantity;
                            $stock->save();
                        }
                    }else{
                        continue;
                    }

                    if ($return_quantity == 0) {
                        break;
                    }
                }
            }

            DB::commit();

            return redirect()->route('product-restore')->with('success', 'Success! Products are Restored');
        } catch (\Exception $e) {

            DB::rollback();
            // dd($e);
            return back()->with('failed', 'Failed! Products cannot Receive!');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function rejectAll(Request $request)
    {
        $code = $request->code;

        DB::beginTransaction();

        try {
            $product_returns = ProductReturn::where('return_inv_code', $code)
                                            ->where('status', 'pending')
                                            ->get();


            foreach($product_returns as $data){
                $data->update(['status' => 'reject',
                                'stock_qty' => 0]);

                $productStock = LocationStock::where('location_id', $data->from_location_id)
                                        ->where('product_id', $data->product_id)
                                        ->first();

                $productStock->quantity += $data->quantity;
                $productStock->save();
            }

            

            DB::commit();

            return redirect()->route('product-restore')->with('success', 'Success! Products are Rejected');
        } catch (\Exception $e) {

            DB::rollback();
            // dd($e);
            return back()->with('failed', 'Failed! Products cannot reject!');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function restore(Request $request)
    {
        $code = $request->code;
        $products = $request->receiveAmmounts;
        
        try {
            DB::beginTransaction();

            foreach ($products as $key => $product) {
                $key = [$key];
                $productReturn = ProductReturn::where('return_inv_code', $code)
                                                ->where('status', 'pending')
                                                ->where('id', $key)
                                                ->first();

                if ($productReturn) {
                    $returnAmount = $productReturn->quantity; //10

                    if($returnAmount != $product){  
                        $productReturn->status = 'partial';
                        $productReturn->stock_qty = $product;
                        $productReturn->update();

                        $fromLocationStock = LocationStock::where('location_id', $productReturn->from_location_id)
                                                    ->where('product_id', $productReturn->product_id)
                                                    ->first();
                        
                        $fromLocationStock->quantity += $returnAmount - $product;
                        $fromLocationStock->save();
                    }else{
                        $productReturn->status = 'active';
                        $productReturn->update();
                    }
                }

                if($productReturn->imei_numbers != null){
                    $imeiNumbers = json_decode($productReturn->imei_numbers, true);
                    foreach ($imeiNumbers as $imei) {
                        $imei_data = IMEIProduct::where('imei_number', $imei)->first();
                        $imei_data->location_id = $productReturn->to_location_id;
                        $imei_data->save();
                    }
                }

                $toLocationStock = LocationStock::where('location_id', $productReturn->to_location_id)
                                                    ->where('product_id', $productReturn->product_id)
                                                    ->first();

                $toLocationStock->quantity += $product;
                $toLocationStock->save();

                $productId = $productReturn->product_id;
                $return_quantity = $product;

                $availableStocks = DistributionTransaction::where('product_id', $productId)
                                                            ->where('location_id', $productReturn->to_location_id)
                                                            ->orderBy('created_at', 'desc')
                                                            ->get();

                                                
                foreach ($availableStocks as $stock) {

                    if($stock->quantity > $stock->remaining_quantity){
                        $restock_qty = $stock->quantity - $stock->remaining_quantity;
                        if($restock_qty <= $return_quantity){
                            $return_quantity -= $restock_qty;                           
            
                            $stock->remaining_quantity += $restock_qty;
                            $stock->save();
                        }else{
                            $restock_qty = 0;

                            $stock->remaining_quantity += $return_quantity;
                            $stock->save();
                        }
                    }else{
                        continue;
                    }

                    if ($return_quantity == 0) {
                        break;
                    }
                }
            }
            DB::commit();

            return redirect()->route('product-restore')->with('success', 'Success! Products are Received');
        } catch (\Exception $e) {

            DB::rollback();
            // dd($e);
            return back()->with('failed', 'Failed! Products cannot Receive!');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($product)
    {
        $ids = [];
        $productRestore = ProductReturn::where('return_inv_code', $product)->first();
        $products = ProductReturn::where('return_inv_code', $product)->get();
        return view('product-restore.detail', compact('productRestore', 'products'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
