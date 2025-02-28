<?php

namespace App\Http\Controllers;

use App\Actions\ExecuteIMEIProduct;
use App\Actions\GenerateAutoID;
use App\Actions\HandleFilterQuery;
use App\Actions\HandlePagination;
use App\Actions\UpdateProductQuantity;
use App\Actions\PurchaseStockStatus;
use App\Constants\PaymentType;
use App\Constants\PrefixCodeID;
use App\Constants\ProgressStatus;
use App\Constants\PurchaseType;
use App\Http\Requests\Purchase\FinalFormStoreRequest;
use App\Http\Requests\Purchase\SecondFormStoreRequest;
use App\Models\Paymentable;
use App\Models\Product;
use App\Models\ProductPriceHistory;
use App\Models\Purchase;
use App\Models\Supplier;
use App\Models\Location;
use App\Models\PurchaseProduct;
use App\Models\LocationStock;
use App\Models\DistributionTransaction;
use App\Models\IMEIProduct;
use App\Models\Bank;
use App\Models\PurchaseReturn;
use App\Models\PurchaseReturnProduct;
use App\Enums\CurrencyType;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use App\Traits\GetUserLocationTrait;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx\Rels;
use Maatwebsite\Excel\Facades\Excel;
use Auth;

class PurchaseController extends Controller
{
    use GetUserLocationTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->supplier_id){
            if ($request->ajax()) {
                $keyword     = $request->input('search');
                $start_date  = $request->input('start_date');
                $end_date    = $request->input('end_date');
                $query        = Purchase::where('supplier_id', $request->supplier_id)
                                        ->where('created_by', auth()->user()->id);
    
                $query = (new HandleFilterQuery(keyword: $keyword, start_date: $start_date, end_date: $end_date))->executePurchaseFilter(query: $query);
    
                $purchases = $query->paginate(10);
    
                $html = View::make('purchase.search', compact('purchases'))->render();
    
                return response()->json([
                    'success' => true,
                    'html' => $html,
                    'pagination' => (new HandlePagination(data: $purchases))->pagination()
                ]);
            }
    
            $total_count    = Purchase::where('supplier_id', $request->supplier_id)
                                        ->where('created_by', auth()->user()->id)
                                        ->count();
    
            $purchase_cash = Purchase::where('supplier_id', $request->supplier_id)
                                    ->where('created_by', auth()->user()->id)
                                    ->where('action_type', 'Cash')
                                    ->get();
    
            $purchase_credit = Purchase::where('supplier_id', $request->supplier_id)
                                        ->where('created_by', auth()->user()->id)
                                        ->where('action_type', 'Credit')
                                        ->get();
    
            $purchase_counts = [
                'total_cash_count'      => $purchase_cash->count(),
                'total_credit_count'    => $purchase_credit->count()
            ];
    
            $total_cash_amount = 0;
            foreach($purchase_cash as $data){
                $total_cash_amount += $data->purchase_amount;
            }
    
            $total_credit_amount = 0;
            foreach($purchase_credit as $data){
                $total_credit_amount += $data->purchase_amount;
            }
    
            $purchase_amount = [
                'total_cash_amount' => $total_cash_amount,
                'total_credit_amount' => $total_credit_amount
            ];
    
            $purchases = Purchase::where('supplier_id', $request->supplier_id)
                                ->where('created_by', auth()->user()->id)
                                ->orderByDesc('id')
                                ->paginate(10);
    
            return view('purchase.index', compact('purchases', 'total_count', 'purchase_counts', 'purchase_amount'));
        }
        if ($request->ajax()) {
            $keyword     = $request->input('search');
            $start_date  = $request->input('start_date');
            $end_date    = $request->input('end_date');
            $purchaseQuery = Purchase::where('created_by', auth()->user()->id);
            $total_count = $purchaseQuery->count();

            $query = (new HandleFilterQuery(keyword: $keyword, start_date: $start_date, end_date: $end_date))->executePurchaseFilter(query: $purchaseQuery);

            $purchases = $query->paginate(10);
            $search_count = $query->count();

            $html = View::make('purchase.search', compact('purchases'))->render();

            return response()->json([
                'success' => true,
                'html' => $html,
                'total_count' => $total_count,
                'search_count' => $search_count,
                'pagination' => (new HandlePagination(data: $purchases))->pagination()
            ]);
        }

        $user = auth()->user();
        if($user->hasRole('Super Admin')){
            $total_count = Purchase::count();

            $purchase_cash = Purchase::where('action_type', 'Cash')
                                    ->distinct()
                                    ->get();

            $purchase_credit = Purchase::where('action_type', 'Credit')
                                        ->distinct()
                                        ->get();

            $purchase_counts = [
            'total_cash_count'      => $purchase_cash->count(),
            'total_credit_count'    => $purchase_credit->count()
            ];

            $total_cash_amount = 0;
            foreach($purchase_cash as $data){
                $total_cash_amount += $data->purchase_amount;
            }

            $total_credit_amount = 0;
            foreach($purchase_credit as $data){
                $total_credit_amount += $data->purchase_amount;
            }

            $purchase_amount = [
                'total_cash_amount' => $total_cash_amount,
                'total_credit_amount' => $total_credit_amount
            ];

            $purchases = Purchase::orderByDesc('id')
                                    ->paginate(10);
        }else{
            $total_count = Purchase::where(function ($query) {
                            $query->where('location_id', $this->validateLocation())
                                ->orWhere('created_by', auth()->user()->id);
                        })->distinct()->count();

            $purchase_cash = Purchase::where(function ($query) {
                            $query->where('location_id', $this->validateLocation())
                                ->orWhere('created_by', auth()->user()->id);
                        })
                        ->where('action_type', 'Cash')
                        ->distinct()
                        ->get();

            $purchase_credit = Purchase::where(function ($query) {
                            $query->where('location_id', $this->validateLocation())
                                ->orWhere('created_by', auth()->user()->id);
                        })
                        ->where('action_type', 'Credit')
                        ->distinct()
                        ->get();

            $purchase_counts = [
            'total_cash_count'      => $purchase_cash->count(),
            'total_credit_count'    => $purchase_credit->count()
            ];

            $total_cash_amount = 0;
            foreach($purchase_cash as $data){
            $total_cash_amount += $data->purchase_amount;
            }

            $total_credit_amount = 0;
            foreach($purchase_credit as $data){
            $total_credit_amount += $data->purchase_amount;
            }

            $purchase_amount = [
            'total_cash_amount' => $total_cash_amount,
            'total_credit_amount' => $total_credit_amount
            ];

            $purchases = Purchase::where(function ($query) {
                            $query->where('location_id', $this->validateLocation())
                                ->orWhere('created_by', auth()->user()->id);
                        })
                        ->orderByDesc('id')
                        ->distinct()
                        ->paginate(10);
        }
        
        return view('purchase.index', compact('purchases', 'total_count', 'purchase_counts', 'purchase_amount'));
    }


    public function list(Request $request)
    {
        if ($request->ajax()) {
            $keyword     = $request->input('search');
            $start_date  = $request->input('start_date');
            $end_date    = $request->input('end_date');
            $query        = Purchase::query();

            $purchases = (new HandleFilterQuery(keyword: $keyword, start_date: $start_date, end_date: $end_date))->executePurchaseFilter(query: $query)->paginate(10);

            $html = View::make('purchase.search', compact('purchases'))->render();

            return response()->json([
                'success' => true,
                'html' => $html,
                'pagination' => (new HandlePagination(data: $purchases))->pagination()
            ]);
        }

        $total_count    = Purchase::count();

        $purchases = Purchase::orderByDesc('id')->paginate(10);

        return view('purchase.list', compact('purchases', 'total_count'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function createFirst()
    {
        $suppliers = Supplier::all();

        $types = CurrencyType::keyValuePairs();

        return view('purchase.create-first', compact('suppliers', 'types'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function createSecond(Request $request)
    {
        $user = Auth::user();
        if($user->hasRole('Super Admin')){
            $products = Product::orderByDesc('id')->get();
        }else{
            $products = Product::where('created_by', $user->id)
                                ->orWhereHas('location', function ($query) use ($user) {
                                    $query->whereIn('location_id', $this->validateLocation());
                                })
                                ->orderByDesc('id')
                                ->get();
        }

        $supplier_id = $request->supplier_id;
        $currency_type = $request->currency_type ?? 'kyat';
        $currency_value = $request->currency_value ?? 1;

        return view('purchase.create-second', compact('supplier_id', 'products', 'currency_type', 'currency_value'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function createThird(Request $request)
    {
        $products       = $request->selected_products;
        $supplier_id    = $request->supplier_id;
        $currency_type  = $request->currency_type;
        $currency_value = $request->currency_value;

        if (!$products) {

            return redirect()->route('purchase-create-second')->with('message', 'Fail. Empty Cart!');
        }

        $purchase_types = PurchaseType::TYPES;
        $payment_types = Bank::all();

        return view('purchase.create-third', compact('purchase_types', 'products', 'supplier_id', 'currency_type', 'currency_value', 'payment_types'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function createFinal(Request $request)
    {
        if($request->action_type == 'Credit'){
            if($request->cash_down == null){
                return back()->with('error', 'Cashdown Amount is required !');
            }
        }

        $payment_type = Bank::find($request->payment_type);

        $locations = $this->getStoreLocations();

        return view('purchase.create-final')->with([
            'data' => $request->all(),
            'payment_type' => $payment_type,
            'locations' => $locations,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = json_decode($request->data, true);
        // dd($data);
        $exist_record = Purchase::orderByDesc('id')->first();
        $invoice_number = 'PID-' . date('YmdHis');

        try {
            DB::beginTransaction();

            $products = json_decode($data['products'], true);
            $supplier = Supplier::find($data['supplier_id']);

            $currency_total_amount = $data['total_amount'];
            $total_amount = $data['total_amount'] * $data['currency_value'];

            $currency_discount_amount = $data['discount_amount'];
            $discount_amount = $data['discount_amount'] * $data['currency_value'];

            $currency_remaining_amount = $currency_total_amount - $currency_discount_amount;
            $remaining_amount = $currency_remaining_amount * $data['currency_value'];

            $purchase = Purchase::create([
                'invoice_number'       => $invoice_number,
                'supplier_id'           => $data['supplier_id'],
                'currency_type'         => $data['currency_type'],
                'currency_rate'         => $data['currency_value'],
                'total_amount'          => $total_amount,
                'total_retail_selling_amount'  => $data['total_selling_amount'],
                'total_quantity'        => $data['total_quantity'],
                'discount_amount'        => $discount_amount ?? 0,
                'action_type'           => $data['action_type'],
                'action_date'           => format_date($data['action_date']),
                'remaining_amount' => $remaining_amount,
                'purchase_amount' => $remaining_amount,
                'currency_purchase_amount' => $currency_total_amount,
                'currency_discount_amount' => $currency_discount_amount ?? 0,
                'currency_net_amount' => $currency_remaining_amount,
                'location_id' => $request->location_id === 'none' ? null : $request->location_id,
                'payment_type' => $data['payment_type']
            ]);

            if ($data['action_type'] == PurchaseType::TYPES['Credit']) {
                $purchase->remaining_amount = $purchase->currency_net_amount - $data['cash_down'];
                $purchase->cash_down = $data['cash_down'] ?? 0;
                $purchase->total_paid_amount = $data['cash_down'] ?? 0;
                $purchase->due_date = format_date($data['due_date']);
                $purchase->save();

                $payment = new Paymentable();
                $payment->paymentable()->associate($purchase);
                $payment->paymentableBy()->associate($supplier);
                $payment->payment_status = ProgressStatus::ONGOING;
                $payment->payment_type = 1; ////////discuss
                $payment->payment_date   = now();
                $payment->next_payment_date = format_date($data['due_date']) ?? null;
                $payment->amount   = $data['cash_down'];
                $payment->total_paid_amount = $data['cash_down'];
                $payment->remaining_amount = $purchase->remaining_amount;
                $payment->save();
            } else {
                $payment = new Paymentable();
                $payment->paymentable()->associate($purchase);
                $payment->paymentableBy()->associate($supplier);
                $payment->payment_status = ProgressStatus::COMPLETE;
                $payment->payment_type = 1;
                $payment->payment_date   = now();

                $payment->amount = $payment->total_paid_amount = ($data['currency_type'] == 'kyat') ? ($total_amount - $discount_amount) : $currency_remaining_amount;
                
                $payment->save();

                $purchase->purchase_status = 'Complete';
                $purchase->total_paid_amount = ($data['currency_type'] == 'kyat') ? $total_amount - $discount_amount : $currency_remaining_amount;
                $purchase->remaining_amount = 0;
                $purchase->save();
            }

            foreach ($products as $product) {
                $currency_buying_price = $product['buying_price'];
                $buying_price = $currency_buying_price * $data['currency_value'];

                $retail_price = $product['retail_price'];
                $quantity = $product['quantity'];
                $imei_products = $product['imei'];

                $product = Product::find($product['product_id']);

                $product->retail_price = $retail_price;
                $product->update(); 

                PurchaseProduct::create([
                    'purchase_id' => $purchase->id,
                    'product_id' => $product->id,
                    'currency_buying_price' => $currency_buying_price,
                    'buying_price' => $buying_price ?? null,
                    'quantity' => $quantity,
                    'status' => 'remaining',
                    'purchase_quantity' => $quantity
                ]);

                (new ExecuteIMEIProduct(product: $product, imei_products: $imei_products, purchase: $purchase))->store();
            }

            DB::commit();

            return redirect()->route('purchase')->with('success', 'Success! Purchase created');
        } catch (\Exception $e) {
            DB::rollback();
            
            return back()->with('error', 'Failed! Purchase can not Created');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Purchase  $purchase
     * @return \Illuminate\Http\Response
     */
    public function show(Purchase $purchase)
    {
        $purchase_date = Carbon::parse($purchase->action_date);
        $validEditDate = $purchase_date->copy()->addDays(7);

        $isEditValid = 0;
        $today = Carbon::today();
        if($today->between($purchase_date, $validEditDate)) {
            $isEditValid = 1;
        }

        return view('purchase.detail', compact('purchase', 'isEditValid'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Purchase  $purchase
     * @return \Illuminate\Http\Response
     */
    public function edit(Purchase $purchase)
    {
        return view('purchase.edit-price', compact('purchase'));
    }

    public function editFinal(Request $request, Purchase $purchase)
    {
        
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Purchase  $purchase
     * @return \Illuminate\Http\Response
     */
    
    public function update(Request $request, Purchase $purchase)
    {
        $productIds = $request->input('product_id');
        $newPrices = $request->input('buyingPrice');

        $index = 0;
        $count = count($productIds);

        try {
            DB::beginTransaction();
            
            $new_total_amount = 0;
            do {
                if($index < $count) {
                    $product_id = $productIds[$index];
                    $price = $newPrices[$index];
        
                    $purchaseProduct = PurchaseProduct::where('purchase_id', $purchase->id)
                                                        ->where('product_id', $product_id)
                                                        ->first();

                    if($purchase->currency_type->value == 'kyat'){
                        $purchaseProduct->buying_price = $price;
                        $purchaseProduct->currency_buying_price = $price;
                        $purchaseProduct->save();
                    }else{
                        ///
                    }

                    $new_total_amount += $purchaseProduct->buying_price * $purchaseProduct->purchase_quantity;

                    $dt_exist = DistributionTransaction::where('purchase_id', $purchase->id)
                                                        ->where('product_id', $product_id)
                                                        ->first();

                    if($dt_exist){
                        $dt_exist->buying_price = $price;
                        $dt_exist->save();
                    }

                    $purchaseReturns = PurchaseReturn::where('purchase_id', $purchase->id)
                                                    ->get();
                    if($purchaseReturns){
                        foreach ($purchaseReturns as $purchaseReturn) {
                            $total_return_amount = 0;
                            $purchaseReturnProduct = PurchaseReturnProduct::where('purchase_return_id', $purchaseReturn->id)
                                                                            ->where('product_id', $product_id)
                                                                            ->first();
    
                            if($purchaseReturnProduct){
                                $purchaseReturnProduct->unit_price = $price;
                                $purchaseReturnProduct->save();
                            }
    
                            $purchaseReturnProducts = PurchaseReturnProduct::where('purchase_return_id', $purchaseReturn->id)
                                                                            ->get();
    
                            foreach ($purchaseReturnProducts as $purchaseReturnProduct) {
                                $total_return_amount += $purchaseReturnProduct->unit_price * $purchaseReturnProduct->quantity;
                            }
    
                            $purchaseReturn->return_amount = $total_return_amount;
                            $purchaseReturn->new_purchase_amount = ($new_total_amount - $purchase->discount_amount) - $total_return_amount;
                            $purchaseReturn->old_purchase_amount = $new_total_amount - $purchase->discount_amount;
                            $purchaseReturn->save();
                        }
                    }
                    
                }
                $index++;
            } while ($index < $count);

            $purchaseReturns = PurchaseReturn::where('purchase_id', $purchase->id)
                                                    ->get();
            $return_amount = 0;
            if($purchaseReturns){
                foreach ($purchaseReturns as $purchaseReturn) {
                    $return_amount += $purchaseReturn->return_amount;
                }
            }
            
            if($purchase->currency_type->value == 'kyat'){
                $purchase->total_amount = $new_total_amount - $return_amount;
                $purchase->purchase_amount = $new_total_amount - $purchase->discount_amount;

                $purchase->currency_purchase_amount = $new_total_amount - $return_amount;
                $purchase->currency_net_amount = $new_total_amount - $purchase->currency_discount_amount;
            }
            

            if($purchase->action_type == 'Cash'){
                $purchase->total_paid_amount = ($new_total_amount - $purchase->currency_discount_amount) - $return_amount;

                $paymentable = Paymentable::where('paymentable_type', 'App\Models\Purchase')
                                        ->where('paymentable_id', $purchase->id)
                                        ->update([
                                            'amount' => $purchase->total_paid_amount,
                                            'total_paid_amount' => $purchase->total_paid_amount,
                                        ]);
            }else{
                ///////
            }
            $purchase->save();

            DB::commit();

            return redirect()->route('purchase')->with('success', 'Success! Purchase Price Updated');
        } catch (\Exception $e) {
            DB::rollback();
            dd($e);
            return back()->with('error', 'Failed! Buying Price is not Updated');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Purchase  $purchase
     * @return \Illuminate\Http\Response
     */
    public function destroy(Purchase $purchase)
    {
        if ($purchase->stock_status == 'Added') {
            return response()->json([
                'message' => 'The record cannot be Deleted.',
                'status' => 500,
            ], 500);
        } 

        DB::beginTransaction();
        try {
            $purchase->delete();

            Paymentable::where('paymentable_type', 'App\Models\Purchase')
                    ->where('paymentable_id', $purchase->id)
                    ->delete();

            IMEIProduct::where('purchase_id', $purchase->id)
                    ->delete();

            DB::commit();

            return response()->json([
                'message' => 'The record has been deleted successfully.',
                'status' => 200,
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'message' => 'An error occurred while deleting the record.',
                'status' => 500,
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function getSelectedSupplier($id)
    {
        $supplier = Supplier::find($id);

        $html = View::make('purchase.selected-supplier', compact('supplier'))->render();

        return response()->json([
            'success' => true,
            'user_number' => $supplier->user_number,
            'html' => $html,
        ]);
    }

    public function getSearchProduct(Request $request)
    {
        $keyword = $request->input('search');
        $keyword = "%{$keyword}%";
                         
        $products = Product::where(function ($q) use ($keyword) {
                                $q->where('code', 'like', $keyword)
                                  ->orWhere('name', 'like', $keyword)
                                    ->orWhereHas('brand', function ($q) use ($keyword) {
                                        $q->where('name', 'like', $keyword);
                                })
                                ->orWhereHas('productModel', function ($q) use ($keyword) {
                                    $q->where('name', 'like', '%' . $keyword . '%');
                                });
                            })
                            ->get();


        $html = View::make('purchase.selected-product', compact('products'))->render();

        return response()->json([
            'success' => true,
            'html' => $html,
        ]);
    }

    public function addIMEIScanner($id, $supplier_id)
    {  
        return view('purchase.add-imei-scanner', compact('id', 'supplier_id'));
    }

    public function chooseLocation(Request $request){
        $supplier_id = $request->supplier_id;
        $locations = $this->getStoreLocations();

        return view('purchase.choose-location', compact('supplier_id','locations'));
    }

    public function chooseType($id, $supplier_id){
        return view('purchase.choose-type', compact('id', 'supplier_id'));
    }

    public function addImeiManual($id, $supplier_id){
        return view('purchase.add-imei-manual', compact('id', 'supplier_id'));
    }

    public function fetchExcelData(Request $request){
        $request->validate([
            'excel_file' => 'required|file|mimes:xlsx,xls',
        ]);

        $file = $request->file('excel_file');
        $filePath = $file->storeAs('uploads', 'excel-file.xlsx');

        $data = Excel::toArray([], storage_path("app/{$filePath}"));

        $data = array_unique(array_filter(array_column($data[0], 0), function($value) {
            return !empty($value);
        }));

        return response()->json(['data' => $data]);
    }

    public function addExpireDate($id, $supplier_id){
        $date = \Carbon\Carbon::today()->addYears(2);
        $date = $date->format('Y-m-d');

        return view('purchase.add-expire-date', compact('id', 'supplier_id', 'date'));
    }

    public function purchaseStockList(Request $request){

        if ($request->ajax()) {
            $keyword     = $request->input('search');
            $query        = Purchase::where('created_by', auth()->user()->id)->where('stock_status', 'Remaining');

            $query = (new HandleFilterQuery(keyword: $keyword))->executePurchaseStockFilter(query: $query);

            $purchases = $query->paginate(10);

            $html = View::make('purchase-stock.search', compact('purchases'))->render();

            return response()->json([
                'success' => true,
                'html' => $html,
                'pagination' => (new HandlePagination(data: $purchases))->pagination()
            ]);
        }

        $total_count = Purchase::where('stock_status', 'Remaining')
                                ->count();

        $purchases = Purchase::where('stock_status', 'Remaining')
                                ->paginate(10);


        return view('purchase-stock.index', compact('purchases', 'total_count'));
    }

    public function choosePurchase(Request $request){
        $purchase = Purchase::find($request->id);
        $products = Product::all();
        
        return view('purchase-stock.add', compact('products', 'purchase'));
    }

    public function addPurchase(Request $request){
        $productIds = $request->input('product_ids', []);
        $purchaseId = $request->input('purchase_id');
    
        $products = Product::whereIn('id', $productIds)->get();
    
        $purchases = PurchaseProduct::where('purchase_id', $purchaseId)
                                     ->whereIn('product_id', $productIds)
                                     ->get();
    
        $purchase = Purchase::find($purchaseId);

        if ($purchase->location_id) {
            $locationIds = explode(',', $purchase->location_id);
            $storeLocations = Location::whereIn('id', $locationIds)->get();
        }else{
            $storeLocations = $this->getStoreLocations();
        }
                 
        return view('purchase-stock.add-stock', compact('purchases', 'products', 'storeLocations', 'purchaseId'));
    }

    public function storePurchaseStock(Request $request)
    {
        try {
            DB::beginTransaction();

            foreach ($request->product_ids as $productId) {
                $purchase_product = PurchaseProduct::where('purchase_id', $request->purchase_id)
                                                    ->where('product_id', $productId)
                                                    ->first();

                $product = Product::find($productId);

                if (!$purchase_product) {
                    continue;
                }

                $purchase = Purchase::find($request->purchase_id);

                $i = 0;
                $count = count($request->locations);
                while ($i < $count) {
                    $location_id = $request->locations[$i];
                    $quantity = $purchase_product->quantity;

                    if ($quantity != 0) {
                        $stockTransaction = DistributionTransaction::create([
                            'purchase_id' => $request->purchase_id,
                            'product_id' => $productId,
                            'location_id' => $location_id,
                            'buying_price' => $purchase_product->buying_price,
                            'is_imei' => $product->is_imei,
                            'expire_date' => $purchase_product->expire_date,
                            'added_date' => Carbon::now(),
                            'quantity' => $quantity,
                            'remaining_quantity' => $quantity
                        ]);

                        $exitStock = LocationStock::firstOrNew([
                            'location_id' => $location_id,
                            'product_id' => $productId,
                        ]);
                        $exitStock->quantity += $quantity;
                        $exitStock->save();
                    }
                    if($product->is_imei == 1){
                        IMEIProduct::where('purchase_id', $request->purchase_id)
                                    ->where('product_id', $productId)
                                    ->update(['location_id' => $location_id]);
                    }
                    $i++;
                }

                $purchase_product->status = 'added';
                $purchase_product->save();
            }

            $purchase->checkPurchaseStatus();

            DB::commit();

            return redirect()->route('product-purchase-stock-list')->with('success', 'Success! Stock Added Successfully');
            
        } catch (\Exception $e) {
            DB::rollback();

            return back()->with('error', 'Failed! Something is Wrong!');
        }
    }


    public function stockAddHistories(Request $request){

        if ($request->ajax()) {
            $keyword     = $request->input('search');
            $query        = DistributionTransaction::query();

            $query = (new HandleFilterQuery(keyword: $keyword))->executeDistributionTransactionProductFilter(query: $query);

            $transfers = $query->paginate(10);

            $html = View::make('purchase-stock.history-search', compact('transfers'))->render();

            return response()->json([
                'success' => true,
                'html' => $html,
                'pagination' => (new HandlePagination(data: $transfers))->pagination()
            ]);
        }

        $total_count = DistributionTransaction::join('purchases', 'purchases.id', 'distribution_transactions.purchase_id')
                                                ->count();

        $transfers = DistributionTransaction::join('purchases', 'purchases.id', 'distribution_transactions.purchase_id')
                                            ->orderBy('distribution_transactions.id', 'desc')
                                            ->select('distribution_transactions.*')
                                            ->paginate(10);
                                            

        return view('purchase-stock.history', compact('total_count', 'transfers'));
    }

    public function historyDetails(Request $request){
        $transfer = DistributionTransaction::find($request->id);
        $purchase = Purchase::find($transfer->purchase_id);
        
        return view('purchase-stock.history-details', compact('transfer', 'purchase'));

    }
}
