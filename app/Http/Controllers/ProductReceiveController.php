<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Actions\HandleFilterQuery;
use App\Actions\HandlePagination;
use App\Models\Product;
use App\Models\LocationStock;
use App\Models\Location;
use App\Models\ProductTransfer;
use App\Models\ProductPrefix;
use App\Models\DistributionTransaction;
use App\Models\IMEIProduct;
use App\Constants\PrefixCodeID;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;

use App\Traits\GetUserLocationTrait;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;
use Carbon\Carbon;

class ProductReceiveController extends Controller
{
    use GetUserLocationTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $product_receives = ProductTransfer::whereIn('to_location_id', $this->validateLocation())
                                            ->selectRaw('
                                            transfer_inv_code,
                                            CASE 
                                                WHEN SUM(CASE WHEN status = "partial" THEN 1 ELSE 0 END) > 0 THEN "partial"
                                                ELSE MAX(status)
                                            END as status,
                                            from_location_id,
                                            to_location_id,
                                            created_by,
                                            transfer_date,
                                            remark,
                                            MAX(id) as id
                                        ')
                                        ->groupBy('transfer_inv_code', 'from_location_id', 'to_location_id', 'created_by', 'transfer_date', 'remark')
                                        ->orderBy('id', 'desc')
                                        ->paginate(10);

        $total_count    = $product_receives->total();
      
        if ($request->ajax()) {
            $keyword     = $request->input('search');
            $start_date  = $request->input('start_date');
            $end_date    = $request->input('end_date');
            $query        = ProductTransfer::query();

            $query = (new HandleFilterQuery(keyword: $keyword, start_date: $start_date, end_date: $end_date))->executeProductReceiveFilter(query: $query);

            $product_receives = $query->whereIn('to_location_id', $this->validateLocation())
                                                ->selectRaw('
                                                transfer_inv_code,
                                                CASE 
                                                    WHEN SUM(CASE WHEN status = "partial" THEN 1 ELSE 0 END) > 0 THEN "partial"
                                                    ELSE MAX(status)
                                                END as status,
                                                from_location_id,
                                                to_location_id,
                                                created_by,
                                                transfer_date,
                                                remark,
                                                MAX(id) as id
                                            ')
                                            ->groupBy('transfer_inv_code', 'from_location_id', 'to_location_id', 'created_by', 'transfer_date', 'remark')
                                            ->orderBy('id', 'desc')
                                            ->paginate(10);
           
            $html = View::make('product-receive.search', compact('product_receives'))->render();

            return response()->json([
                'success' => true,
                'total_count' => $total_count,
                'search_count' => $product_receives->total(),
                'html' => $html,
                'pagination' => (new HandlePagination(data: $product_receives))->pagination()
            ]);
        }

        return view('product-receive.index', compact('product_receives', 'total_count'));
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

            $productTransfers = ProductTransfer::where('transfer_inv_code', $code)
                                            ->where('status', 'pending')
                                            ->get();

            foreach ($productTransfers as $productTransfer) {
                $productTransfer->status = 'active';
                $productTransfer->update();

                $locationStockExist = LocationStock::where('location_id', $productTransfer->to_location_id)
                                                ->where('product_id', $productTransfer->product_id)
                                                ->first();

                if($locationStockExist){
                    $locationStockExist->quantity += $productTransfer->transfer_qty;
                    $locationStockExist->save();
                }else{
                    $locationStock = LocationStock::create([
                                                'location_id' => $productTransfer->to_location_id,
                                                'product_id' => $productTransfer->product_id,
                                                'quantity' => $productTransfer->transfer_qty,
                                                ]);
                }

                if($productTransfer->imei_numbers != null){
                    $imeiNumbers = json_decode($productTransfer->imei_numbers, true);
                    foreach ($imeiNumbers as $imei) {
                        // $imei_data = IMEIProduct::where('imei_number', $imei)
                        //                             ->update([
                        //                                 'location_id' => $productTransfer->to_location_id
                        //                             ]);
                        $imei_data = IMEIProduct::where('imei_number', $imei)->first();
                        $imei_data->location_id = $productTransfer->to_location_id;
                        $imei_data->save();
                    }
                }
            }

            DB::commit();

            return redirect()->route('product-receive')->with('success', 'Success! Products are Received');
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

        try {
            DB::beginTransaction();

            ProductTransfer::where('transfer_inv_code', $code)
                            ->where('status', 'pending')
                            ->update(array('status' => 'reject', 'stock_qty' => 0));

            $productTransfers = ProductTransfer::where('transfer_inv_code', $code)
                                        ->get();

            foreach ($productTransfers as $product) {
                $locationStock = LocationStock::where('location_id', $product->from_location_id)
                                                ->where('product_id', $product->product_id)
                                                ->first();

                $locationStock->quantity += $product->transfer_qty;
                $locationStock->save();

                $availableStocks = DistributionTransaction::where('product_id', $product['product_id'])
                                                            ->where('location_id', $product['from_location_id'])
                                                            ->orderBy('created_at', 'desc')
                                                            ->get();

                if($availableStocks){
                    $retransfer_qty = $product->transfer_qty;
                    foreach ($availableStocks as $stock) {
                        
                        if($stock->quantity > $stock->remaining_quantity){
                            $restock_qty = $stock->quantity - $stock->remaining_quantity;
                            if($restock_qty <= $retransfer_qty){
                                $retransfer_qty -= $restock_qty;                           
                
                                $stock->remaining_quantity += $restock_qty;
                                $stock->save();
                            }else{
                                $stock->remaining_quantity += $retransfer_qty;
                                $stock->save();
                                
                                $retransfer_qty = 0;
                            }
                        }else{
                            continue;
                        }
    
                        if ($retransfer_qty == 0) {
                            break;
                        }
                    }
                }                
            }

            DB::commit();

            return redirect()->route('product-receive')->with('success', 'Success! Products are Rejected');
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
    public function receive(Request $request)
    {
        $code = $request->code;
        $products = $request->receiveAmmounts;

        try {
            DB::beginTransaction();

            foreach ($products as $key => $product) {
                $id = [$key];
                $productReceive = ProductTransfer::where('transfer_inv_code', $code)
                                                    ->where('status', 'pending')
                                                    ->where('id', $id)
                                                    ->first();

                if ($productReceive) {
                    $transferAmount = $productReceive->transfer_qty;
                    if($transferAmount != $product){
                        $productReceive->status = 'partial';
                        $productReceive->stock_qty = $product;
                        $productReceive->update();
                    }else{
                        $productReceive->status = 'active';
                        $productReceive->stock_qty = $product;
                        $productReceive->update();
                    }
                    
                }

                $retransfer_qty = $productReceive->transfer_qty - $product;

                $storeLocationStock = LocationStock::where('location_id', $productReceive->from_location_id)
                                                    ->where('product_id', $productReceive->product_id)
                                                    ->first();
                
                $storeLocationStock->quantity += $retransfer_qty;
                $storeLocationStock->update();

                $locationStockExist = LocationStock::firstOrNew([
                                                'location_id' => $productReceive->to_location_id,
                                                'product_id' => $productReceive->product_id,
                                            ]);
                $locationStockExist->quantity += $product;
                $locationStockExist->save();

                $productId = $productReceive->product_id;                
                
                $availableStocks = DistributionTransaction::where('product_id', $productId)
                                                            ->where('location_id', $productReceive->from_location_id)
                                                            ->orderBy('created_at', 'desc')
                                                            ->get();

                foreach ($availableStocks as $stock) {
                    if($stock->quantity > $stock->remaining_quantity){
                        $stock->remaining_quantity += $retransfer_qty;
                        $stock->save();
                        $retransfer_qty = 0;
                    }else{
                        continue;
                    }

                    if ($retransfer_qty == 0) {
                        break;
                    }
                }
            }
            DB::commit();

            return redirect()->route('product-receive')->with('success', 'Success! Products are Received');
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
    public function show(ProductTransfer $productTransfer, $product)
    {
        $ids = [];
        $productTran = ProductTransfer::where('transfer_inv_code', $product)->first();
        $products = ProductTransfer::where('transfer_inv_code', $product)->get();
        return view('product-receive.detail', compact('productTran', 'products'));
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
