<?php

namespace App\Http\Controllers;

use App\Models\ProductTransfer;
use Illuminate\Http\Request;
use App\Actions\HandleFilterQuery;
use App\Actions\HandlePagination;
use App\Models\Product;
use App\Models\Location;
use App\Models\LocationStock;
use App\Models\ProductPrefix;
use App\Models\DistributionTransaction;
use App\Models\IMEIProduct;
use App\Constants\PrefixCodeID;
use Illuminate\Support\Facades\View;

use App\Traits\GetUserLocationTrait;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ProductTransferController extends Controller
{
    use GetUserLocationTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $product_transfers = ProductTransfer::whereIn('from_location_id', $this->validateLocation())
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

        $total_count = $product_transfers->total();

        if ($request->ajax()) {
            $keyword     = $request->input('search');
            $start_date  = $request->input('start_date');
            $end_date    = $request->input('end_date');
            $query        = ProductTransfer::query();

            $query = (new HandleFilterQuery(keyword: $keyword, start_date: $start_date, end_date: $end_date))->executeProductTransferFilter(query: $query);

            $query->whereIn('from_location_id', $this->validateLocation())
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
                                        ->orderByDesc('id');

            $product_transfers = $query->paginate(10);

            $html = View::make('product-transfer.search', compact('product_transfers'))->render();

            return response()->json([
                'success' => true,
                'html' => $html,
                'total_count' => $total_count,
                'search_count' => $product_transfers->total(),
                'pagination' => (new HandlePagination(data: $product_transfers))->pagination()
            ]);
        }


        return view('product-transfer.index', compact('product_transfers', 'total_count'));
    }

    /**
     * Show the from for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $transfer_code = 'PDT-'. date('YmdHis');

        $from_locations = $this->getStoreLocations();
        $to_locations = $this->getDissminationLocations();

        $products = Product::all();

        return view('product-transfer.create', compact('products', 'from_locations', 'to_locations', 'transfer_code'));
    }

    public function createSecond(Request $request)
    {
        $data = [];
        $data['transfer_code'] = $request->transfer_code;
        $data['from_location_id'] = $request->from_location_id;
        $data['to_location_id'] = $request->to_location_id;
        $data['date'] = $request->single_date;
        $data['remark'] = $request->remark;

        $data['from_location_name'] = Location::where('id',$request->from_location_id)->value('location_name');
        $data['to_location_name'] = Location::where('id',$request->to_location_id)->value('location_name');

        $products = LocationStock::where('location_id', $request->from_location_id)
                                    ->where('quantity' , '!=', 0)
                                    ->get();

        $product_prefix = PrefixCodeID::TRANSFER;

        $prefix_code = $product_prefix . '-' . $request->transfer_code;

        $data['prefix_code'] = $prefix_code;

        return view('product-transfer.create-second', compact('data', 'products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function createThird(Request $request)
    {
        $data = json_decode($request->data, true);
        $products = $request->selected_products;

        $data['prefix_code'] = $request->prefix_code;
        $data['from_location_id'] = $data['from_location_id'];
        $data['to_location_id'] = $data['to_location_id'];

        $from_location_name = Location::where('id', $data['from_location_id'])->first();
        $to_location_name = Location::where('id', $data['to_location_id'])->first();
        $data['from_location_name'] = $from_location_name->location_name;
        $data['to_location_name'] = $to_location_name->location_name;

        $data['products'] = $products;
        if (!$products) {
            return redirect()->route('product-transfer-create-second')->with('message', 'Fail. Empty Cart!');
        }

        return view('product-transfer.create-final', compact('data', 'products'));
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
        $type = config('productStatus.productTransferType.new_transfer');
        $data = json_decode($request->data, true);
        $exist_record = ProductTransfer::orderByDesc('id')->first();
        $code = 'PDT-'. $data['transfer_code'];
        // $invoice_number = getAutoGenerateID(PrefixCodeID::TRANSFER, $exist_record?->transfer_inv_code);

        try {
            DB::beginTransaction();

            $products = json_decode($data['products'], true);

            foreach ($products as $product) {
                $productTran = new ProductTransfer();
                $productTran->transfer_inv_code = $code;
                $productTran->remark = $data['remark'];
                $productTran->from_location_id = $data['from_location_id'];
                $productTran->to_location_id = $data['to_location_id'];
                $productTran->product_id = $product['product_id'];
                $productTran->transfer_qty = $product['quantity'];
                $productTran->stock_qty = $product['quantity'];
                $productTran->status = $status;
                $productTran->transfer_type = $type;
                $productTran->created_by = $login_user->id;
                $productTran->transfer_date = Carbon::createFromFormat('m/d/Y', $data['date'])->format('Y-m-d');
                $productTran->save();

                // Handle IMEI numbers if present
                if ($product['isIMEI'] == 1) {
                    $productTran->imei_numbers = json_encode($product['imei']);
                    $productTran->save();
                }

                // Update stock quantity from the distribution transactions
                $availableStocks = DistributionTransaction::where('product_id', $product['product_id'])
                                            ->where('location_id', $data['from_location_id'])
                                            ->orderBy('created_at')
                                            ->get();

                if($availableStocks){
                    $remainingQuantity = $product['quantity'];
                    foreach ($availableStocks as $stock) {
                        if($remainingQuantity > 0 && $stock->remaining_quantity > 0) {
                            if($stock->remaining_quantity >= $remainingQuantity) {
                                $stock->remaining_quantity -= $remainingQuantity;
                                $stock->save();
    
                                $remainingQuantity = 0;
                            } else {
                                $remainingQuantity -= $stock->remaining_quantity;
                                $stock->remaining_quantity = 0;
                                $stock->save();
    
                                continue;
                            }
                        }
    
                        if ($remainingQuantity == 0) {
                            break;
                        }
                    }
                }

                $storeLocationStock = LocationStock::where('location_id', $data['from_location_id'])
                                                ->where('product_id', $product['product_id'])
                                                ->first();
                if ($storeLocationStock) {
                    $storeLocationStock->quantity -= $product['quantity'];
                    $storeLocationStock->save();
                }
            }

            DB::commit();

            return redirect()->route('product-transfer')->with('success', 'Success! Product Transfer Created');
        } catch (\Exception $e) {
            // dd($e);
            DB::rollback();
            return back()->with('error', 'Failed! Product Transfer cannot be created');
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ProductTransfer  $productTransfer
     * @return \Illuminate\Http\Response
     */
    public function show(ProductTransfer $productTransfer, $product)
    {
        $productTran = ProductTransfer::where('transfer_inv_code', $product)->first();
        $products = ProductTransfer::where('transfer_inv_code', $product)->get();
        return view('product-transfer.detail', compact('productTran', 'products'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ProductTransfer  $productTransfer
     * @return \Illuminate\Http\Response
     */
    public function edit(ProductTransfer $productTransfer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ProductTransfer  $productTransfer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ProductTransfer $productTransfer)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ProductTransfer  $productTransfer
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProductTransfer $productTransfer)
    {
        //
    }

    public function getSearchProduct(Request $request)
    {
        $keyword = $request->input('search');
        $keyword = "%{$keyword}%";
        $location_id = $request->location_id;

        $locationProducts = LocationStock::where('location_id', $location_id)
                                            ->where('quantity', '!=', 0)
                                            ->select('product_id')
                                            ->get();

        $products = Product::whereIn('id', $locationProducts)
                            ->where(function ($query) use ($keyword) {
                                $query->where('name', 'like', $keyword)
                                    ->orWhere('code', 'like', $keyword)
                                    ->orWhereHas('brand', function ($query) use ($keyword) {
                                        $query->where('name', 'like', $keyword);
                                    })
                                    ->orWhereHas('design', function ($query) use ($keyword) {
                                        $query->where('name', 'like', $keyword);
                                    })
                                    ->orWhereHas('category', function ($query) use ($keyword) {
                                        $query->where('name', 'like', $keyword);
                                    })
                                    ->orWhereHas('productModel', function ($query) use ($keyword) {
                                        $query->where('name', 'like', $keyword);
                                    })
                                    ->orWhereHas('type', function ($query) use ($keyword) {
                                        $query->where('name', 'like', $keyword);
                                    });
                            })
                            ->get();

        $html = View::make('product-transfer.selected-product', compact('products', 'location_id'))->render();

        return response()->json([
            'success' => true,
            'html' => $html,
        ]);
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

        return view('product-transfer.add-imei', compact('product', 'imei_product_arr'));
    }

    public function validateIMEI($id, Request $request) {
        $imeiNumbers = $request->input('imei');
        $productId = $request->input('product_id');

        $errors = [];
        foreach ($imeiNumbers as $index => $imei) {
            if (! $this->isValidIMEI($productId, $imei)) {
                $errors[$index] = "Invalid.";
            }
        }

        if (count($errors) > 0) {
            return response()->json([
                'success' => false,
                'errors' => $errors
            ]);
        }

        return response()->json(['success' => true, 'imeis' => $imeiNumbers]);
    }

    private function isValidIMEI($product_id, $imei) {
        $imei_exist = IMEIProduct::whereIn('location_id', $this->validateLocation())
                                    ->where('product_id', $product_id)
                                    ->where('imei_number', $imei)
                                    ->where('status', 'Available')
                                    ->first();

        if($imei_exist){
            return true;
        }else{
            return false;
        }

    }

}
