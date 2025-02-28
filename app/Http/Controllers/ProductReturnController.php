<?php

namespace App\Http\Controllers;

use App\Models\ProductReturn;
use Illuminate\Http\Request;
use App\Actions\HandleFilterQuery;
use App\Actions\HandlePagination;
use App\Models\Product;
use App\Models\ProductTransfer;
use App\Models\Location;
use App\Models\ProductPrefix;
use App\Models\LocationStock;
use App\Constants\PrefixCodeID;
use Illuminate\Support\Facades\View;

use App\Traits\GetUserLocationTrait;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ProductReturnController extends Controller
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
            $query        = ProductReturn::query();

            $query = (new HandleFilterQuery(keyword: $keyword))->executeProductReturnRestoreFilter(query: $query);

            $product_returns = $query->whereIn('from_location_id', $this->validateLocation())
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

            $html = View::make('product-return.search', compact('product_returns'))->render();

            return response()->json([
                'success' => true,
                'html' => $html,
                'pagination' => (new HandlePagination(data: $product_returns))->pagination()
            ]);
        }

        $product_returns = ProductReturn::whereIn('from_location_id', $this->validateLocation())
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

    return view('product-return.index', compact('product_returns', 'total_count'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $product_code = 'PRT-'.date('YmdHis');
        $from_locations = $this->POLocations();
        $to_locations = $this->getAllStoreLocations();
        $products = Product::all();

        return view('product-return.create', compact('products', 'from_locations', 'to_locations', 'product_code'));
    }

    public function createSecond(Request $request)
    {
        $data = [];
        $data['return_code'] = $request->return_code;
        $data['from_location_id'] = $request->from_location_id;
                                            
        $data['to_location_id'] = $request->to_location_id;
    
        $data['from_location_name'] = Location::where('id', $request->from_location_id)
                                                ->value('location_name');
        

        $data['to_location_name'] = Location::where('id', $request->to_location_id)
                                                ->value('location_name');

        $data['remark'] = $request->remark;
     
        $products = LocationStock::join('products', 'products.id', 'location_stocks.product_id')
                                    ->select('products.*', 'location_stocks.quantity as count')
                                    ->where('location_stocks.location_id', $request->from_location_id)
                                    ->get();
       
        $product_prefix = PrefixCodeID::RETURN;

        $prefix_code = $product_prefix . '-' . $request->return_code;
        
        $data['prefix_code'] = $prefix_code;
        
        return view('product-return.create-second', compact('data', 'products'));
    }

    public function createThird(Request $request)
    {
        $data = json_decode($request->data, true);

        $products = $request->selected_products;
        
        $data['prefix_code'] = $request->prefix_code;
      
        $from_location_name = Location::where('id', $data['from_location_id'])->first();
        $to_location_name = Location::where('id', $data['to_location_id'])->first();

        $data['from_location_name'] = $from_location_name->location_name;
        $data['to_location_name'] = $to_location_name->location_name;
        
        $data['products'] = $products;
        if (!$products) {
            return redirect()->route('product-return-create-second')->with('message', 'Fail. Empty Cart!');
        }

        return view('product-return.create-final', compact('data', 'products'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $login_user = Auth()->user();
        $status = 'pending';
        $type = config('productStatus.productTransferType.return');
        $data = json_decode($request->data, true);
        $return_inv_code = 'PRT-'.date('YmdHis');
        
        $exist_record = ProductReturn::orderByDesc('id')->first();

        $invoice_number = getAutoGenerateID(PrefixCodeID::RETURN, $exist_record?->return_inv_code);
        
        DB::beginTransaction();
       
        try {

            $products = json_decode($data['products'], true);
            foreach ($products as $product) {

                $location_stock_check = LocationStock::where('location_id', $data['to_location_id'])
                                                        ->where('product_id', $product['product_id'])
                                                        ->first();

                if(!$location_stock_check){
                    return redirect()->route('product-return')->with('error', 'Failed! Product Not Exist');
                }

                $productRtn = new ProductReturn();
                $productRtn->return_inv_code = $return_inv_code;
                $productRtn->from_location_id = $data['from_location_id'];
                $productRtn->to_location_id = $data['to_location_id'];
                $productRtn->product_id = $product['product_id'];
                $productRtn->quantity = $product['quantity'];
                $productRtn->stock_qty = $product['quantity'];
                $productRtn->status = $status;
                $productRtn->created_by = $login_user->id;
                $productRtn->remark = $data['remark'];
                $productRtn->save();

                // Handle IMEI numbers if present
                if ($product['isIMEI'] == 1) {
                    $productRtn->imei_numbers = json_encode($product['imei']);
                    $productRtn->save();
                }

                $stockExist = LocationStock::where('location_id', $productRtn->from_location_id)
                                            ->where('product_id', $productRtn->product_id)
                                            ->first();

                $stockExist->quantity -= $productRtn->quantity;
                $stockExist->save();
    
            }

            DB::commit();

            return redirect()->route('product-return')->with('success', 'Success! Product Return Created');
        } catch (\Exception $e) {

            DB::rollback();
            // dd($e);
            return back()->with('failed', 'Failed! Product Return cannot Created');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ProductReturn  $productReturn
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $product)
    {
        $productReturn = ProductReturn::where('return_inv_code', $product)->first();
        $products = ProductReturn::where('return_inv_code', $product)->get();
        return view('product-return.detail', compact('productReturn', 'products'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ProductReturn  $productReturn
     * @return \Illuminate\Http\Response
     */
    public function edit(ProductReturn $productReturn)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ProductReturn  $productReturn
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ProductReturn $productReturn)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ProductReturn  $productReturn
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProductReturn $productReturn)
    {
        //
    }

    public function addIMEI(Product $product)
    {
        $product_imeis = Product::find($product->id)->imei_products;
        $imei_arr = [];
        for($i = 0; $i < count($product_imeis); $i++){
            $imei_arr[] = $product_imeis[$i]['imei_number'];
        }
        $commaSeparatedString = implode(',', $imei_arr);
        $imei_product_arr = "[$commaSeparatedString]";
 
        return view('product-return.add-imei', compact('product', 'imei_product_arr'));
    }
}
