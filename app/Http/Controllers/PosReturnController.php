<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Actions\HandleFilterQuery;
use App\Actions\HandlePagination;
use App\Models\PosReturn;
use App\Models\PosReturnProduct;
use App\Models\Shopper;
use App\Models\PointOfSale;
use App\Models\PointOfSaleProduct;
use App\Models\Product;
use App\Models\LocationStock;
use Illuminate\Support\Facades\View;
use Carbon\Carbon;
use DB;

class PosReturnController extends Controller
{
    public function index(Request $request){
        if ($request->ajax()) {
            $keyword     = $request->input('search');
           
            $query       = PosReturn::where('created_by', auth()->user()->id);

            $query = (new HandleFilterQuery(keyword: $keyword))->executePOSReturnFilter(query: $query);

            $returns = $query->paginate(10);

            $html = View::make('pos-return.search', compact('returns'))->render();

            return response()->json([
                'success' => true,
                'html' => $html,
                'pagination' => (new HandlePagination(data: $returns))->pagination()
            ]);
        }
        $returns = PosReturn::where('created_by', auth()->user()->id)->orderBy('id', 'desc')->paginate(10);

        return view('pos-return.index', compact('returns'));
    }

    public function createFirst(){
        $shoppers = Shopper::all();

        return view('pos-return.create-first', compact('shoppers'));
    }

    public function createSecond(Request $request)
    {
        $purchases = PointOfSale::with(['posReturns.posReturnProducts' => function ($query) {
                                    $query->where('return_type', 'cash');
                                }])
                                ->where('shopper_id', $request->shopper_id)
                                ->orderByDesc('id')
                                ->get();

        foreach ($purchases as $data) {
            $data->remaining_qty = 0;

            foreach ($data->posReturns as $return) {
                $data->remaining_qty += $return->posReturnProducts->sum('quantity');
            }
        }
        // dd($purchases);

        return view('pos-return.create-second', compact('purchases'));
    }

    public function createThird($id, Request $request){
       $purchase = PointOfSale::find($request->id);

       if($request->ajax()){
            $keyword                = $request->input('search');
            $selected_products      = $request->input('selectedData');
            $selected_products      = $selected_products ?? [];
            
            $query = Product::join('point_of_sale_products as posp', 'posp.product_id', 'products.id')
                            ->where('posp.point_of_sale_id', $purchase->id)
                            ->select('products.*', 'products.id as product_id', 'posp.quantity as quantity');

            $query = (new HandleFilterQuery(keyword: $keyword))->executeProductFilter(query: $query);

            $purchase_products = $query->orderByDesc('id')
                                        ->paginate(10);

            $html = View::make('pos-return.search-product-list', compact('purchase_products', 'selected_products'))->render();

            return response()->json([
                'success' => true,
                'html' => $html,
            ]);
        }

        $purchase_products = $purchase->pointOfSaleProducts;

        return view('pos-return.create-third', compact('purchase', 'purchase_products'));
    }

    public function createFourth(Request $request){
        $purchase = PointOfSale::find($request->purchase_id);
        $purchaseProducts = json_decode($request->selected_products, true);
        if(!$purchaseProducts){
            return back()->with('error', 'No Product is Selected !');
        }

        return view('pos-return.create-fourth', compact('purchase', 'purchaseProducts'));
    }

    public function createFinal(Request $request){
        $purchase = PointOfSale::find($request->purchase_id);
        $remark = $request->remark;
        $return_date = $request->return_date;
        $quantity_count = 0;
        $total_return_amount = 0;
        
        if($request->remark == null){
            return back()->with('error', 'Remark is Required !');
        }
        $i = 0;
        $count = count($request->product_id);

        $productData = [];
        while($i < $count){            
            $product = PointOfSaleProduct::where('point_of_sale_id', $purchase->id)
                                            ->where('product_id', $request->product_id[$i])
                                            ->first();

            if($request->action_quantity[$i] == null || $request->return_type[$i] == null || !$request->return_type || $product->quantity < $request->action_quantity[$i]){
                return back()->with('error', 'Something Went Wrong !');
            }
            $productData[] = [
                'product_id' => $request->product_id[$i],
                'return_type' => $request->return_type[$i],
                'quantity' => $request->action_quantity[$i],
                'unit_price' => $product->unit_price,
            ];

            $quantity_count += $request->action_quantity[$i];
            if($request->return_type[$i] == 'cash'){
                $total_return_amount += $product->unit_price * $request->action_quantity[$i];
            }
            $i++;
        }

        $new_purchase_amount = $purchase->net_amount - $total_return_amount;

        return view('pos-return.create-final', compact('purchase', 'remark', 'return_date',
                                                        'quantity_count', 'productData',
                                                         'total_return_amount', 'new_purchase_amount'));
    }

    public function store(Request $request){
        $purchase = PointOfSale::find($request->purchase_id);
        $date = Carbon::createFromFormat('m/d/Y', $request->return_date);
        $return_date = $date->format('Y-m-d');
        $return_number = 'POSRTN-' . date('YmdHis');

        DB::beginTransaction();
        try {
            $pos_return = PosReturn::create([
                'pos_return_id' => $return_number,
                'point_of_sale_id' => $purchase->id,
                'remark' => $request->remark,
                'return_date' => $return_date,
                'total_return_quantity' => array_sum($request->quantity),
                'created_by' => auth()->user()->id,
            ]);

            $total_return_amount = 0;
            $i = 0;
            $count = count($request->product_id);

            while($i < $count){
                $returnProduct = PosReturnProduct::create([
                                                'pos_return_id' => $pos_return->id,
                                                'product_id' => $request->product_id[$i],
                                                'return_type' => $request->return_type[$i],
                                                'quantity' => $request->quantity[$i]
                                            ]);
    
                if($returnProduct->return_type == 'cash'){
                    $sell_price = PointOfSaleProduct::where('point_of_sale_id', $purchase->id)
                                                    ->where('product_id', $returnProduct->product_id)
                                                    ->value('unit_price');

                    $total_return_amount += $sell_price * $returnProduct->quantity;
                    $returnProduct->return_amount = $sell_price * $returnProduct->quantity;
                    $returnProduct->save();
                                            
                    $posProduct = PointOfSaleProduct::where('point_of_sale_id', $purchase->id)
                                                    ->where('product_id', $returnProduct->product_id)
                                                    ->first();

                    $posProduct->quantity -= $returnProduct->quantity;
                    $posProduct->price = $posProduct->quantity * $posProduct->unit_price;
                    $posProduct->save();

                    $locationStock = LocationStock::where('location_id', $purchase->location_id)
                                                    ->where('product_id', $returnProduct->product_id)
                                                    ->first();

                    $locationStock->quantity += $returnProduct->quantity;
                    $locationStock->save();
                }
                $i++;
            }

            $pos_return->total_return_amount = $total_return_amount;
            $pos_return->save();

            $purchase->total_amount -= $total_return_amount;
            $purchase->net_amount -= $total_return_amount;
            $purchase->total_quantity -= array_sum($request->quantity);
            $purchase->save();

            DB::commit();

            return redirect()->route('pos-return-list')->with('success', 'Success! Sale Return created');
        } catch (\Exception $e) {
            DB::rollback();
            // dd($e);
            return back()->with('error', 'Failed! Sale Return can not Created');
        }     
    }

    public function getShopperDetail(Request $request)
    {
        $shopper = Shopper::find($request->shopperId);
    
        $html = View::make('pos-return.shopper-detail', compact('shopper'))->render();

        return response()->json([
            'success' => true,
            'user_number' => $shopper->code,
            'html' => $html,
        ]);
    }

    public function details(Request $request){
        $return = PosReturn::find($request->id);

        return view('pos-return.detail', compact('return'));
    }

    public function addIMEI(PointOfSale $purchase, Product $product){
        $product_imeis = Product::join('point_of_sale_products as posp', 'posp.product_id', 'products.id')
                                ->where('posp.product_id', $product->id)
                                ->select('products.*')
                                ->imei_products;
        $imei_arr = [];
        for($i = 0; $i < count($product_imeis); $i++){
            $imei_arr[] = $product_imeis[$i]['imei_number'];
        }
        $commaSeparatedString = implode(',', $imei_arr);
        $imei_product_arr = "[$commaSeparatedString]";

        return view('pos-return.return-imei', compact('purchase', 'id'));
    }
}
