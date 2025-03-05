<?php

namespace App\Http\Controllers;

use App\Actions\ExecuteReturnable;
use App\Actions\HandleFilterQuery;
use App\Actions\HandlePagination;
use App\Actions\HandleReturnable;
use App\Actions\UpdateProductQuantity;
use App\Constants\ProgressStatus;
use App\Constants\IMEIStatus;
use App\Constants\PurchaseType;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\PurchaseProduct;
use App\Models\PurchaseReturn;
use App\Models\PurchaseReturnProduct;
use App\Models\IMEIProduct;
use App\Models\Paymentable;
use App\Models\Returnable;
use App\Models\Supplier;
use App\Models\DistributionTransaction;
use App\Models\LocationStock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;
use Auth;

class PurchaseReturnController extends Controller
{
    use HandleReturnable;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if(auth()->user()->hasRole('Super Admin')){
            $purchase_return = PurchaseReturn::orderByDesc('id');
        }else{
            $purchase_return = PurchaseReturn::where('created_by', auth()->user()->id)
                                            ->orderByDesc('id');
        }      

        if ($request->ajax()) {

            $keyword    = $request->search;
            $start_date = $request->start_date;
            $end_date   = $request->end_date;

            $purchase_returns = (new HandleFilterQuery(keyword: $keyword, start_date: $start_date, end_date: $end_date))->executeProductPurchaseReturnFilter(query: $purchase_return)->paginate(10);

            $html = View::make('purchase-return.search', compact('purchase_returns'))->render();

            return response()->json([
                'success' => true,
                'html' => $html,
                'pagination' => (new HandlePagination(data: $purchase_returns))->pagination()
            ]);
        }

        if(auth()->user()->hasRole('Super Admin')){
            $purchase_returns = PurchaseReturn::orderBy('id', 'desc')
                                                ->paginate(10);
        }else{
            $purchase_returns = PurchaseReturn::where('created_by', auth()->user()->id)
                                            ->orderBy('id', 'desc')
                                            ->paginate(10);
        }

        $total_count      = $purchase_returns->count();

        return view('purchase-return.index', compact('purchase_returns', 'total_count'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function createFirst()
    {
        $suppliers = Supplier::whereHas('purchases', function ($query) {
                                    $query->where('created_by', auth()->user()->id);
                                })->get();

        return view('purchase-return.create-first', compact('suppliers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function createSecond($supplier_id)
    {
        $purchases = Purchase::where('supplier_id', $supplier_id)
                                ->orderBy('id', 'desc')
                                ->paginate(20);

        return view('purchase-return.create-second', [
            'purchases' => $purchases,
            'supplier_id' => $supplier_id,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function createThird($id, Request $request)
    {
        $purchase = Purchase::find($id);

        if($request->ajax()){
            $keyword                = $request->input('search');
            $selected_products      = $request->input('selectedData');
            $selected_products      = $selected_products ?? [];
            
            $query = Product::join('purchase_products as pp', 'pp.product_id', 'products.id')
                            ->where('pp.purchase_id', $id)
                            ->select('products.*', 'products.id as product_id', 'pp.quantity as quantity');

            $query = (new HandleFilterQuery(keyword: $keyword))->executeProductFilter(query: $query);

            $purchase_products = $query->orderByDesc('id')
                                        ->paginate(10);

            $html = View::make('purchase-return.search-product-list', compact('purchase_products', 'selected_products'))->render();

            return response()->json([
                'success' => true,
                'html' => $html,
            ]);
        }

        $purchase_products = $purchase->purchaseProducts;

        return view('purchase-return.create-third', compact('purchase_products', 'purchase'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function createFourth(Request $request)
    {
        $purchase = Purchase::find($request->purchase_id);
        $products = json_decode($request->selected_products, true);
        
        if(!$products){
            return back()->with('error', 'No Product is Selected !');
        }

        return view('purchase-return.create-fourth', compact('purchase', 'products' ));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function createFinal(Request $request)
    {
        $purchase = Purchase::find($request->purchase_id);
        $purchase_return_products = json_decode($request->purchase_return_products);
        
        $purchase_return_total_quantity = 0;
        $purchase_return_total_amount = 0;

        foreach ($purchase_return_products as $purchase_return_product) {
            
            $purchase_return_total_quantity += $purchase_return_product->returned_quantity;
            $purchase_return_total_amount += $purchase_return_product->buy_price * $purchase_return_product->returned_quantity;

            $product = Product::find($purchase_return_product->id);
            $purchase_return_product->name = $product->name;
            $purchase_return_product->image = $product->image;
            $purchase_return_product->code = $product->code;
            $purchase_return_product->isIMEI = $product->is_imei;
        }

        $purchase_return_remark = $request->purchase_return_remark;
        $purchase_return_date = $request->purchase_return_date;

        $purchase_new_amount = ($purchase->currency_type->value == 'mmk') 
                            ? $purchase->total_amount - $purchase_return_total_amount 
                            : $purchase->currency_purchase_amount - $purchase_return_total_amount;
     
        $purchase_new_paid_amount = ($purchase->currency_type->value == 'mmk')
                                    ? ($purchase->total_amount - $purchase->discount_amount) - $purchase_return_total_amount
                                    : ($purchase->currency_purchase_amount - $purchase->currency_discount_amount) - $purchase_return_total_amount;

        return view('purchase-return.create-final', compact('purchase', 'purchase_return_products', 
                                                            'purchase_return_remark', 'purchase_return_date', 
                                                            'purchase_return_total_quantity', 'purchase_return_total_amount',
                                                            'purchase_new_amount', 'purchase_new_paid_amount'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $purchase_return_products = json_decode($request->purchase_return_products);

        $purchase = Purchase::find($request->purchase_id);

        $total_return_quantity      = 0;
        $total_return_amount        = 0;
        
        DB::beginTransaction();

        try {

            $purchase_return = PurchaseReturn::create([
                'purchase_return_number' => 'PRID-' . date('YmdHis'),
                'remark' => $request->purchase_return_remark,
                'purchase_id' => $purchase->id,
                'return_date' => date('Y-m-d', strtotime($request->purchase_return_date)),
                'return_quantity' => $request->purchase_return_total_quantity,
                'return_amount' => $request->purchase_return_total_amount,
                'old_purchase_amount' => ($purchase->currency_type->value == 'mmk') ? $purchase->total_amount - $purchase->discount_amount : $purchase->currency_purchase_amount - $purchase->currency_discount_amount,
                'new_purchase_amount' => ($purchase->currency_type->value == 'mmk') ? $request->purchase_new_amount - $purchase->discount_amount : $request->purchase_new_amount - $purchase->currency_discount_amount,
                'created_by' => auth()->user()->id,
                'created_at' => Carbon::createFromFormat('m/d/Y', $request->purchase_return_date),
            ]);

            $purchase->return_count += 1;
            if($purchase->currency_type->value !== 'mmk'){
                $purchase->currency_purchase_amount = $request->purchase_new_amount;
                $purchase->total_amount = $request->purchase_new_amount * $purchase->currency_rate;
            }else{
                $purchase->total_amount = $request->purchase_new_amount;
                $purchase->currency_purchase_amount = intval($request->purchase_new_amount / $purchase->currency_rate);

            }
            
            if($purchase->action_type === PurchaseType::TYPES['Cash']){
                $purchase->total_paid_amount = $request->purchase_new_paid_amount;
            }else{
                if($purchase->total_paid_amount == $request->purchase_new_paid_amount){
                    $purchase->remaining_amount = 0;
                    $purchase->purchase_status = 'Complete';
                }elseif($purchase->total_paid_amount > $request->purchase_new_paid_amount){
                    $purchase->cash_down = $request->purchase_new_paid_amount;
                    $purchase->remaining_amount = 0;
                    $purchase->purchase_status = 'Complete';
                }else{
                    $purchase->remaining_amount = ($purchase->currency_type->value == 'mmk') 
                                                    ?($purchase->total_amount + $purchase->discount_amount) - $purchase->cash_down
                                                    : ($purchase->currency_purchase_amount + $purchase->currency_discount_amount) - $purchase->cash_down;
                }              
            }
            
            $purchase->total_quantity -= $request->purchase_return_total_quantity;
            $purchase->total_return_quantity += $request->purchase_return_total_quantity;
            $purchase->save();


            foreach ($purchase_return_products as $data) {
                $purchase_return_product = PurchaseReturnProduct::create([
                    'purchase_return_id' => $purchase_return->id,
                    'product_id' => $data->id,
                    'quantity' => $data->returned_quantity,
                    'unit_price' => $data->buy_price,
                ]);

                if ($data->isIMEI == 1) {
                    $purchase_return_product->imei = json_encode($data->imei);
                    $purchase_return_product->save();

                    IMEIProduct::where('purchase_id', $purchase->id)
                                ->where('product_id', $data->id)
                                ->whereIn('imei_number', $data->imei)
                                ->delete();
                }

                $purchase_product = PurchaseProduct::where('purchase_id', $purchase->id)
                                                ->where('product_id', $data->id)
                                                ->first();

                $purchase_product->quantity -= $data->returned_quantity;
                $purchase_product->save();

                $availableStock = DistributionTransaction::where('purchase_id', $purchase->id)
                                                            ->where('product_id', $data->id)
                                                            ->first();

                if($availableStock){
                    $availableStock->quantity -= $data->returned_quantity;
                    $availableStock->remaining_quantity -= $data->returned_quantity;
                    $availableStock->save();

                    $locationStock = LocationStock::where('product_id', $data->id)
                                                    ->where('location_id', $availableStock->location_id)
                                                    ->first();

                    $locationStock->quantity -= $data->returned_quantity;
                    $locationStock->save();
                }

            }

            switch ($purchase->action_type) {
                case PurchaseType::TYPES['Cash']:
                    DB::table('paymentable')
                        ->where('paymentable_type', 'App\Models\Purchase')
                        ->where('paymentable_id', $purchase->id)
                        ->update([
                            'amount' => ($purchase->currency_type->value === 'mmk') ? $request->purchase_new_amount - $purchase->discount_amount : $request->purchase_new_amount - $purchase->currency_discount_amount,
                            'total_paid_amount' => ($purchase->currency_type->value === 'mmk') ? $request->purchase_new_amount - $purchase->discount_amount : $request->purchase_new_amount - $purchase->currency_discount_amount,
                        ]);
                    break;

                case PurchaseType::TYPES['Credit']:
                    
                    $payment = Paymentable::where('paymentable_type', 'App\Models\Purchase')
                                                ->where('paymentable_id', $purchase->id)
                                                ->orderBy('id', 'desc')
                                                ->first();
                    if ($request->purchase_new_paid_amount == $purchase->total_paid_amount) {
                        $payment->payment_status = 'Complete';
                        $payment->remaining_amount = 0;
                        $payment->save();
                    }elseif($purchase->total_paid_amount > $request->purchase_new_paid_amount){
                        
                    }else{
                        $payment->remaining_amount = $purchase->remaining_amount;
                        $payment->save();
                    }
                    break;
            }                

            DB::commit();

            return redirect()->route('purchase-return')->with('success', 'Success! Purchase Return created');
        } catch (\Exception $e) {

            DB::rollback();
            dd($e);
            return back()->with('error', 'Failed! Purchase Return can not Created');
        }
    }
    // supplier
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PurchaseReturn  $purchaseReturn
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $purchase_return = PurchaseReturn::find($id);

        return view('purchase-return.detail', compact('purchase_return'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PurchaseReturn  $purchaseReturn
     * @return \Illuminate\Http\Response
     */
    public function edit(PurchaseReturn $purchaseReturn)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PurchaseReturn  $purchaseReturn
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PurchaseReturn $purchaseReturn)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PurchaseReturn  $purchaseReturn
     * @return \Illuminate\Http\Response
     */
    public function destroy(Returnable $purchase_return)
    {
        DB::beginTransaction();
        try {
            $purchase_return->delete();

            // update purchase table
            $purchase = $purchase_return->returnable;
            $purchase->total_return_quantity = $purchase->total_return_quantity - $purchase_return->total_return_quantity;
            $purchase->total_return_buying_amount = $purchase->total_return_buying_amount - $purchase_return->total_return_amount;
            $purchase->return_status = 0;
            $purchase->save();

            foreach ($purchase_return->productable as $product) {

                $product_id = $product->product_id;
                $quantity   = $product->quantity;

                $product_return = $purchase->productReturnables()->where('product_id', $product_id)->first();
                if ($product_return) {

                    $return_quantity = $product_return->return_quantity - $quantity;

                    $product_return->after_quantity = $product_return->quantity - $return_quantity;
                    $product_return->return_quantity = $return_quantity;
                    $product_return->save();
                }

                (new UpdateProductQuantity(id: $product_id, quantity: $quantity))->increaseProductQuantity();
            }



            $purchase_return->productable()->delete();
            DB::commit();

            return response()->json([
                'message' => 'The record has been deleted successfully.',
                'status' => 200,
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            // dd($e);
        }
    }

    public function getSupplierDetail($id)
    {
        $supplier = Supplier::find($id);

        $html = View::make('purchase-return.supplier-detail', compact('supplier'))->render();

        return response()->json([
            'success' => true,
            'user_number' => $supplier->user_number,
            'html' => $html,
        ]);
    }

    public function searchProduct(Request $request)
    {
        $keyword                = $request->input('search');
        $selected_products      = $request->input('selectedData');
        $purchase = Purchase::find($request->input('purchase_id'));
        $purchase_products = $purchase->productable;

        $purchase_products = Product::join('purchase_products as pp', 'pp.product_id', 'products.id')
                                    ->where('pp.purchase_id', $purchase->id)
                                    ->where(function ($query) use ($keyword) {
                                        $query->where('products.name', 'like', '%' . $keyword . '%')
                                            ->orWhere('products.code', 'like', '%' . $keyword . '%');
                                    })
                                    ->select('pp.product_id as product_id', 'pp.quantity as quantity')
                                    ->get();

        $selected_products      = $selected_products ?? [];

        $html = View::make('purchase-return.search-product-list', compact('purchase_products', 'selected_products'))->render();

        return response()->json([
            'success' => true,
            'html' => $html,
        ]);
    }

    public function addIMEI(Product $product, Purchase $purchase)
    {

        $purchased_product = $purchase->purchaseProducts()->where('product_id', $product->id)->first();

        $imei_product_arr = IMEIProduct::where('product_id', $purchased_product->product_id)
                                        ->where('purchase_id', $purchase->id)
                                        ->where('status', 'Available')
                                        ->pluck('imei_number')
                                        ->toArray();
                            
        return view('purchase-return.add-imei', compact('product', 'imei_product_arr'));
    }

    public function searchPurchase(Request $request){
        $keyword = '%'.$request->search.'%';

        $purchases = Purchase::where('supplier_id', $request->supplier_id)
                                ->where('invoice_number', 'like', $keyword)
                                ->orWhereHas('purchaseProducts.product', function($query) use ($keyword) {
                                    $query->where('name', 'like', $keyword);
                                })
                                ->orderBy('id', 'desc')
                                ->get();

        $html = View::make('purchase-return.search-purchase', compact('purchases'))->render();

        return response()->json([
            'success' => true,
            'html' => $html,
        ]);
    }
}
