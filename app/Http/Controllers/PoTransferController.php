<?php

namespace App\Http\Controllers;

use App\Models\PoTransfer;
use Illuminate\Http\Request;
use App\Actions\HandleFilterQuery;
use App\Actions\HandlePagination;
use App\Models\Product;
use App\Models\Location;
use App\Models\LocationStock;
use App\Models\DistributionTransaction;
use App\Models\ProductTransfer;
use App\Models\ProductPrefix;
use App\Constants\PrefixCodeID;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;

use App\Traits\GetUserLocationTrait;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;
use Carbon\Carbon;

class PoTransferController extends Controller
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
            $start_date  = $request->input('start_date');
            $end_date    = $request->input('end_date');
            $query        = PoTransfer::query();

            $query = (new HandleFilterQuery(keyword: $keyword, start_date: $start_date, end_date: $end_date))->executeProductOrderRequestFilter(query: $query);

            $poTransfers = $query->whereIn('to_location_id', $this->validateLocation())
                                ->selectRaw('
                                    request_inv_code,
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
                                ->groupBy('request_inv_code', 'from_location_id', 'to_location_id', 'created_by', 'created_at', 'remark')
                                ->orderBy('id', 'desc')
                                ->paginate(10);

            $html = View::make('po-transfer.search', compact('poTransfers'))->render();

            return response()->json([
                'success' => true,
                'html' => $html,
                'pagination' => (new HandlePagination(data: $poTransfers))->pagination()
            ]);
        }

        $poTransfers = PoTransfer::whereIn('to_location_id', $this->validateLocation())
                                ->selectRaw('
                                    request_inv_code,
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
                                ->groupBy('request_inv_code', 'from_location_id', 'to_location_id', 'created_by', 'created_at', 'remark')
                                ->orderBy('id', 'desc')
                                ->paginate(10);
        
        $total_count    = PoTransfer::count();

        return view('po-transfer.index', compact('poTransfers', 'total_count'));
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
        $login_user = Auth()->user();
        // $invoice_number = getAutoGenerateID(PrefixCodeID::TRANSFER, $exist_record?->transfer_inv_code);

        $type = config('productStatus.productTransferType.po_transfer');

        $requestTrans = PoTransfer::where('request_inv_code', $code)->get();

        try {
            DB::beginTransaction();
            
            if ($requestTrans) {
                foreach ($requestTrans as $transfer) {

                    $productStock = LocationStock::where('location_id', $transfer->to_location_id)
                                                    ->where('product_id', $transfer->product_id)
                                                    ->first();

                    if($productStock->quantity < $transfer->request_qty){
                        return redirect()->route('po-transfer')->with('error', 'Not Enough Quantity');
                    }else{
                    
                        $transfer->quantity = $transfer->request_qty;
                        $transfer->update();
    
                        $productStock->quantity -= $transfer->quantity;
                        $productStock->save();
    
                        $productTran = new ProductTransfer();
                        $productTran->transfer_inv_code = 'PDT-'.date('YmdHis');
                        $productTran->from_location_id = $transfer->to_location_id;
                        $productTran->to_location_id = $transfer->from_location_id;
                        $productTran->product_id = $transfer->product_id;
                        $productTran->created_by = $login_user->id;
                        $productTran->transfer_qty = $transfer->quantity;
                        $productTran->stock_qty = $transfer->quantity;
                        $productTran->status = 'pending';
                        $productTran->transfer_type = $type;
                        $productTran->transfer_date = Carbon::now();
                        $productTran->save();
    
                        $availableStocks = DistributionTransaction::where('product_id', $productTran->product_id)
                                                    ->where('location_id', $productTran->from_location_id)
                                                    ->orderBy('created_at')
                                                    ->get();
    
                        $remainingQuantity = $productTran->transfer_qty;
                        foreach ($availableStocks as $stock) {
                            if($remainingQuantity > 0 && $stock->remaining_quantity > 0) {
                                if($stock->remaining_quantity >= $remainingQuantity){
                                    $stock->remaining_quantity -= $remainingQuantity;
                                    $stock->save();
        
                                    $remainingQuantity = 0;
                                }else{
                                    $remainingQuantity -= $stock->remaining_quantity;
                                    $stock->remaining_quantity = 0;
                                    $stock->save();
                                    
                                    continue;
                                }
                            }else{
                                continue;
                            }
        
                            if ($remainingQuantity == 0) {
                                break;
                            }
                        }
                    }

                    
                }
            }
            
            PoTransfer::where('request_inv_code', $code)->where('status', 'pending')->update(array('status' => 'transferred', 'product_transfer_id' => $productTran->id));
            
            DB::commit();

            return redirect()->route('po-transfer')->with('success', 'Success! Products are Received');
        } catch (\Exception $e) {
            DB::rollback();

            return back()->with('failed', 'Failed! Products cannot Receive!');
        }
    }

    public function rejectAll(Request $request)
    {
        $code = $request->code;

        try {
            DB::beginTransaction();

            PoTransfer::where('request_inv_code', $code)->where('status', 'pending')->update(array('status' => 'reject'));

            DB::commit();

            return redirect()->route('po-transfer')->with('success', 'Success! Po Request are Rejected');
        } catch (\Exception $e) {

            DB::rollback();
            // dd($e);
            return back()->with('failed', 'Failed! Po Request cannot reject!');
        }
    }

    public function poTransfer(Request $request)
    {
        $code = $request->code;
        $products = $request->receiveAmmounts;
        $type = config('productStatus.productTransferType.po_transfer');

        // $exist_record = ProductTransfer::latest()->first();
        // $product_prefix = ProductPrefix::first();
        // $product_prefix_code = $product_prefix?->prefix ?? PrefixCodeID::TRANSFER;
        // $product_prefix_length = $product_prefix?->prefix_length ?? PrefixCodeID::PREFIX_DEFAULT_LENGTH;
        // $product_code = getAutoGenerateID($product_prefix_code, $exist_record?->code, $product_prefix_length);
        // $invoice_number = getAutoGenerateID(PrefixCodeID::TRANSFER, $exist_record?->transfer_inv_code);

        try {
            DB::beginTransaction();

            foreach ($products as $key => $product) {
                $key = [$key];
                $productRequest = PoTransfer::where('request_inv_code', $code)
                                            ->where('status', 'pending')
                                            ->where('id', $key)
                                            ->first();

                if($productRequest){

                    $productTransfer = ProductTransfer::create([
                        'transfer_inv_code' => 'PDT-'.date('YmdHis'),
                        'from_location_id' => $productRequest->to_location_id,
                        'to_location_id' => $productRequest->from_location_id,
                        'product_id' => $productRequest->product_id,
                        'created_by' => Auth::user()->id,
                        'transfer_qty' => $product,
                        'stock_qty' => $product,
                        'status'=> 'pending',
                        'transfer_type' => $type,
                        'transfer_date' => Carbon::now(),
                    ]);

                    $requestAmount = $productRequest->request_qty;
                    if($requestAmount != $product){
                        $productRequest->quantity = $product;
                        $productRequest->status = 'partial';
                        $productRequest->product_transfer_id = $productTransfer->id;
                        $productRequest->update();
                    }else{
                        $productRequest->quantity = $product;
                        $productRequest->status = 'transferred';
                        $productRequest->product_transfer_id = $productTransfer->id;
                        $productRequest->update();
                    }
                }
                $productId = $productRequest->product_id;
                
                $productStock = LocationStock::where('location_id', $productTransfer->from_location_id)
                                                    ->where('product_id', $productId)
                                                    ->first();

                $productStock->quantity -= $product;
                $productStock->save();

                $availableStocks = DistributionTransaction::where('product_id', $productId)
                                                ->where('location_id', $productTransfer->from_location_id)
                                                ->orderBy('created_at')
                                                ->get();

                $remainingQuantity = $product;
                foreach ($availableStocks as $stock) {
                    if($remainingQuantity > 0 && $stock->remaining_quantity > 0) {
                        if($stock->remaining_quantity >= $remainingQuantity){
                            $stock->remaining_quantity -= $remainingQuantity;
                            $stock->save();

                            $remainingQuantity = 0;
                        }else{
                            $remainingQuantity -= $stock->remaining_quantity;
                            $stock->remaining_quantity = 0;
                            $stock->save();
                            
                            continue;
                        }
                    }else{
                        continue;
                    }

                    if ($remainingQuantity == 0) {
                        break;
                    }
                }
            }

            DB::commit();

            return redirect()->route('po-transfer')->with('success', 'Success! Products are Received');
        } catch (\Exception $e) {
            DB::rollback();
            dd($e);
            return back()->with('failed', 'Failed! Products cannot Receive!');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PoTransfer  $poTransfer
     * @return \Illuminate\Http\Response
     */
    public function show(PoTransfer $poTransfer, $product)
    {
        $ids = [];
        $poTransfer = PoTransfer::where('request_inv_code', $product)->first();
        $products = PoTransfer::where('request_inv_code', $product)->get();

        return view('po-transfer.detail', compact('poTransfer', 'products'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PoTransfer  $poTransfer
     * @return \Illuminate\Http\Response
     */
    public function edit(PoTransfer $poTransfer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PoTransfer  $poTransfer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PoTransfer $poTransfer)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PoTransfer  $poTransfer
     * @return \Illuminate\Http\Response
     */
    public function destroy(PoTransfer $poTransfer)
    {
        //
    }
}
