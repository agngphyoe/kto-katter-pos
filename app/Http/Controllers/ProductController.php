<?php

namespace App\Http\Controllers;

use App\Actions\HandleFilterQuery;
use App\Actions\HandlePagination;
use App\Actions\ImageStoreInPublic;
use App\Constants\PrefixCodeID;
use App\Http\Requests\Product\StoreProductRequest;
use App\Http\Requests\Product\UpdateProductRequest;
use App\Imports\ProductImport;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Design;
use App\Models\Product;
use App\Models\Location;
use App\Models\ProductModel;
use App\Models\ProductPrefix;
use App\Models\ProductPriceHistory;
use App\Models\Type;
use App\Models\LocationStock;
use App\Models\DistributionTransaction;
use App\Models\PointOfSaleProduct;
use App\Models\IMEIProduct;
use App\Models\Purchase;
use App\Models\PurchaseReturn;
use App\Models\ProductTransfer;
use App\Models\PointOfSale;
use Carbon\Carbon;
use DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use App\Traits\GetUserLocationTrait;
use Illuminate\Support\Facades\Config;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use Mike42\Escpos\Printer;
use Mike42\Escpos\PrintConnectors\FilePrintConnector;
use Mike42\Escpos\PrintConnectors\NetworkPrintConnector;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Font;
use Illuminate\Database\QueryException;
use Maatwebsite\Excel\Validators\ValidationException;

class ProductController extends Controller
{

    use GetUserLocationTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
    }

    public function list(Request $request)
    {
        $user = Auth::user();
        if ($request->ajax()) {

            $keyword = $request->input('search');

            if ($user->hasRole('Super Admin')) {
                // Query for Super Admin
                $productQuery = Product::orderByDesc('id');
                $total_count = Product::count();
            } else {
                $productQuery = Product::leftJoin('location_stocks as ls', 'ls.product_id', '=', 'products.id')
                                    ->where(function ($query) use ($user) {
                                        $query->where('products.created_by', $user->id)
                                            ->orWhereIn('ls.location_id', $this->validateLocation());
                                    })
                                    ->distinct()
                                    ->select('products.*', 'ls.quantity as quantity');

                $total_count = $productQuery->get()->count(); // Ensures groupings are respected

            }

            $query = (new HandleFilterQuery(keyword: $keyword))->executeProductFilter(query: $productQuery);

            $products = $query->paginate(10);

            $search_count = $products->total();

            $validateLocation = $this->validateLocation();

            $html = View::make('product.search', compact('products','validateLocation'))->render();

            return response()->json([
                'success' => true,
                'html' => $html,
                'search_count' => $search_count,
                'total_count' => $total_count,
                'pagination' => (new HandlePagination(data: $products))->pagination()
            ]);
        }

        if($user->hasRole('Super Admin')){
            $productQuery = Product::orderByDesc('id');

            $total_count = $productQuery->count();
            $products = $productQuery->paginate(10);
        }else{
            $productQuery = Product::leftJoin('location_stocks as ls', 'ls.product_id', '=', 'products.id')
                                    ->where(function ($query) use ($user) {
                                        $query->where('products.created_by', $user->id)
                                            ->orWhereIn('ls.location_id', $this->validateLocation());
                                    })
                                    ->distinct()
                                    ->select('products.*', 'ls.quantity as quantity');

            $products = $productQuery->select('products.*')
                    ->groupBy('products.id')
                    ->paginate(10);

            // Get total count of distinct products
            $total_count = $productQuery->select('products.id')->groupBy('products.id')->get()->count();

        }

        $validateLocation = $this->validateLocation();

        return view('product.list', compact('products', 'total_count', 'validateLocation'));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $exist_record = Product::latest()->first();
        $product_prefix = ProductPrefix::first();

        $product_prefix_code = $product_prefix?->prefix;
        $product_prefix_length = $product_prefix?->prefix_length ?? PrefixCodeID::PREFIX_DEFAULT_LENGTH;

        $product_code = getAutoGenerateID($product_prefix_code ? $product_prefix_code : '' , $exist_record?->code, $product_prefix_length);
        $prefix_code = null;
        if ($exist_record?->code) {
            $prefix =  explode("-", $exist_record->code);
            $prefix_code = $prefix[0];
        }

        $categories = Category::all();

        $brands = Brand::orderByDesc('id')->get();
        $product_models = ProductModel::all();
        $categories = Category::all();
        $types = Type::all();
        $designs = Design::all();

        return view('product.create', compact('categories', 'brands', 'product_models', 'types', 'designs', 'product_code', 'categories', 'prefix_code'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProductRequest $request)
    {
        $product_prefix = ProductPrefix::first();
        $standardPrefix = '';

        if ($product_prefix && $product_prefix->status === 'enable') {
            $standardPrefix = $product_prefix->prefix;
        } else {
            switch ($product_prefix->prefix_type) {
                case 'Category':
                    $category_prefix = Category::where('id', $request->category_id)->value('prefix') ?? '';
                    $standardPrefix = $category_prefix;
                    break;

                case 'Brand':
                    $brand_prefix = Brand::where('id', $request->brand_id)->value('prefix') ?? '';
                    $standardPrefix = $brand_prefix;
                    break;

                case 'All':
                    $category_prefix = Category::where('id', $request->category_id)->value('prefix') ?? '';
                    $brand_prefix = Brand::where('id', $request->brand_id)->value('prefix') ?? '';
                    $standardPrefix = $category_prefix . $brand_prefix;
                    break;

            }
        }

        $lastCode = Product::where('code', 'like', $standardPrefix . '%')
                            ->orderBy('code', 'desc')
                            ->value('code');

        $nextNumber = $lastCode
                        ? str_pad(
                            (int) substr($lastCode, strlen($standardPrefix)) + 1,
                            $product_prefix->prefix_length,
                            '0',
                            STR_PAD_LEFT
                        )
                        : str_pad(1, $product_prefix->prefix_length, '0', STR_PAD_LEFT);


        $prefix_code = $standardPrefix . $nextNumber;

        DB::beginTransaction();
        try {

            $image = $request->image ? (new ImageStoreInPublic())->storePublic(destination: 'products/image', image: $request->image) : null;

            $request = $request->all();
            $request['code'] = $prefix_code;
            $request['image'] = $image;
            $request['created_by'] = auth()->user()->id;
            $brand_name = Brand::where('id', $request['brand_id'])->value('name');
            if($brand_name == 'FOC'){
                $request['is_foc'] = 1;
            }
            $product = Product::create($request);

            DB::commit();

            return redirect()->route('product-list')->with('success', 'Success! Product Created');
        } catch (\Exception $e) {
            DB::rollback();
            // dd($e);
            return back()->with('error', 'Failed! Product cannot Created');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function detail(Product $product)
    {
        $locations = $this->validateLocation();

        $product->quantity = LocationStock::whereIn('location_id', $locations)
                                            ->where('product_id', $product->id)
                                            ->sum('quantity');

        return view('product.detail', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product, Request $request)
    {
        $categories = Category::all();
        $brands = Brand::all();
        $product_models = ProductModel::all();
        $types = Type::all();
        $designs = Design::all();
        $locations = $this->getStoreLocations();
        $page = $request->query('page', 1);
        // dd($page);

        return view('product.edit', compact('product', 'categories', 'brands', 'product_models', 'types', 'designs', 'locations', 'page'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        $image  = $product->image;
        $page = $request->input('page', 1);

        try {
            DB::beginTransaction();

            if ($request->hasFile('image')) {

                File::delete(public_path('products/image/' . $product->image));

                $image = (new ImageStoreInPublic())->storePublic(destination: 'products/image', image: $request->image);
            }

            // Get all request data into an array
            $data = $request->all();
            $data['image'] = $image; // Update the image field in the array
            $product->update($data);

            DB::commit();

            return redirect()->route('product-list', ['page' => $page])->with('success', 'Success! Product Updated');

        } catch (\Exception $e) {
            DB::rollback();

            return back()->with('failed', 'Failed! Product not updated');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        try {
            $image  = $product->image;
            if ($image) {
                File::delete(public_path('products/image/' . $image));
            }
            $product->delete();

            return response()->json([
                'message' => 'The record has been deleted successfully.',
                'status' => 200,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'error',
                'message' => $e->getMessage(),
                'status' => 500,
            ], 500);
        }
    }

    public function getProductModel(Request $request)
    {
        $brand_id = $request->input('brand_id');
        $brand = Brand::find($brand_id);
        $product_models = $brand->productModel;

        $html = View::make('product.product-model-data', compact('product_models'))->render();
        return response()->json([
            'success' => true,
            'html' => $html,
        ]);
    }

    public function getProductBrand(Request $request)
    {
        $category_id = $request->input('category_id');
        $category = Category::find($category_id);
        $brands = $category->brands;
        $html = View::make('product.brand-select-data-for-product-create', compact('brands'))->render();
        return response()->json([
            'success' => true,
            'html' => $html,
        ]);
    }

    public function searchProduct(Request $request)
    {
        $keyword                = $request->input('search');
        $selected_products      = $request->input('selectedData');
        $selected_products      = $selected_products ?? [];
        $query        = Product::query();

        $query = (new HandleFilterQuery(keyword: $keyword))->executeProductFilter(query: $query, limitQty: true);

        $products = $query->orderByDesc('id')->paginate(20);

        $html = View::make('product.search-product-list', compact('products', 'selected_products'))->render();

        return response()->json([
            'success' => true,
            'html' => $html,
        ]);
    }

    public function importExcel(Request $request)
    {
        $request->validate([
            'excel_file' => 'required|mimes:xlsx,xls',
        ]);

        try {
            Excel::import(new ProductImport(), $request->file('excel_file'));

            return redirect()->back()->with('success', 'Data imported successfully');
        } catch (ValidationException $e) {
            $failures = $e->failures();
            $errorMessages = [];
            $missingColumns = [];

            foreach ($failures as $failure) {
                $errorMessages[] = "Row {$failure->row()}: {$failure->errors()[0]}";
                $missingColumns = array_merge($missingColumns, $failure->values());
            }

            $missingColumns = array_unique($missingColumns);
            return redirect()->back()
                ->withErrors($errorMessages)
                ->with('missing_columns', $missingColumns)
                ->withInput();
        } catch (QueryException $e) {
            if ($e->getCode() == 23000) {
                return redirect()->back()->with('error', 'Duplicate entry found. Please check your Excel file.');
            }
            return redirect()->back()->with('error', 'Database error occurred. Please try again.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to import data. Please try again.');
        }
    }

    public function priceUpdate(Product $product, Request $request)
    {
    }

    public function productPriceHistory(Request $request)
    {
    }

    public function getBarcodes(){
        $user = auth()->user();
        if($user->hasRole('Super Admin')){
            $products = Product::select('code', 'name', 'retail_price')
                                ->get();
        }else{
            $products = Product::join('location_stocks as ls', 'ls.product_id', 'products.id')
                                ->whereIn('ls.location_id', $this->validateLocation())
                                ->select('products.*')
                                ->get();
        }


        return view('product.barcode-list', compact('products'));
    }

    public function selectBarcodes(){
        $products = Product::select('id', 'code', 'name')
                            ->get();

        return view('product.barcode-select', compact('products'));
    }

    public function printBarcodes(Request $request){

        $product_data = Product::where('id', $request->product_id)
                                ->select('code', 'name', 'retail_price')
                                ->first();

        $data['product'] = $product_data;
        $data['quantity'] = $request->quantity;

        return view('product.barcode_pdf', compact('data'));

        // Printer setup
        // $connector = new WindowsPrintConnector("COM2"); // Adjust the path based on your system
        // $printer = new Printer($connector);

        // Print logic
        // try {
        //     for ($i = 0; $i < $data['quantity']; $i++) {
        //         $printer->setJustification(Printer::JUSTIFY_CENTER);
        //         $printer->text($data['product']->name . "\n");
        //         $printer->setJustification(Printer::JUSTIFY_LEFT);
        //         $printer->text("Code: " . $data['product']->code . "\n");
        //         $printer->text("Price: " . number_format($data['product']->retail_price) . "MMK\n");

        //         // Barcode printing (example for a simple barcode)
        //         $printer->setBarcodeHeight(50);
        //         $printer->setBarcodeWidth(2);
        //         $printer->barcode($data['product']->code, Printer::BARCODE_CODE128);

        //         $printer->feed(2); // Feed a few lines to separate the labels
        //     }
        // } catch (Exception $e) {
        //     // Handle exception or log error
        // } finally {
        //     $printer->close();
        // }

        // return response()->json(['success' => true]);
    }

    public function stockCheck(Request $request){
        $locations = $this->validateLocation();

        $stocks = LocationStock::where('product_id', $request->product_id)
                                    ->whereIn('location_id', $locations)
                                    ->get();

        $product = Product::find($request->product_id);

        return view('product.stock-check', compact('stocks', 'product'));
    }

    public function priceLog($product_id)
    {
        $product = Product::findOrFail($product_id);

        $priceHistory = DB::table('distribution_transactions')
                            ->where('product_id', $product_id)
                            ->select('created_at', 'buying_price', 'quantity')
                            ->orderBy('created_at', 'desc')
                            ->get();

        $retailPriceHistory = DB::table('product_price_histories')
                                    ->where('product_id', $product_id)
                                    ->select('created_at', 'old_retail_price', 'new_retail_price')
                                    ->orderBy('created_at', 'desc')
                                    ->get();

        return view('product.price-log', compact('product', 'priceHistory', 'retailPriceHistory'));
    }

    public function imeiHistorySearch()
    {
        return view('imei_history.index');
    }

    public function checkIMEIProduct(Request $request)
    {
        $imei_code = $request->input('imei');

        $productExist = IMEIProduct::where('imei_number', $imei_code)->first();

        if($productExist){
            return response()->json(['success' => true]);
        }
    }

    public function imeiHistoryData($imei)
    {
        $product = Product::join('imei_products as ip', 'ip.product_id', 'products.id')
                            ->where('ip.imei_number', $imei)
                            ->select('products.*')
                            ->first();

        $productLocation = IMEIProduct::where('product_id', $product->id)
                                        ->where('imei_number', $imei)
                                        ->first();

        $purchase = Purchase::join('imei_products as ip', 'ip.purchase_id', 'purchases.id')
                            ->where('ip.imei_number', $imei)
                            ->select('purchases.id', 'purchases.action_date as date', 'purchases.invoice_number as reference_number', 'purchases.supplier_id as from', DB::raw("'Purchase' as type"))
                            ->get();

        $purchaseReturn = PurchaseReturn::join('purchase_return_products as prp', 'prp.purchase_return_id', 'purchase_returns.id')
                                        ->whereJsonContains('prp.imei', $imei)
                                        ->select('purchase_returns.return_date as date', 'purchase_returns.purchase_return_number as reference_number', 'purchase_returns.remark', DB::raw("'Purchase Return' as type"))
                                        ->get();

        $productTransfers = ProductTransfer::whereJsonContains('imei_numbers', $imei)
                                        ->select('transfer_date as date', 'transfer_inv_code as reference_number', 'remark', 'from_location_id as from',
                                        'to_location_id as to', DB::raw("'Product Transfer' as type"))
                                        ->get();

        $productReceives = ProductTransfer::where('status', 'active')
                                        ->whereJsonContains('imei_numbers', $imei)
                                        ->select('updated_at as date', 'transfer_inv_code as reference_number', 'remark','from_location_id as from',
                                        'to_location_id as to', DB::raw("'Product Receive' as type"))
                                        ->get();

        $pointOfSale = PointOfSale::join('point_of_sale_products as posp', 'posp.point_of_sale_id', 'point_of_sales.id')
                                    ->whereJsonContains('imei', $imei)
                                    ->select('point_of_sales.id','point_of_sales.order_number as reference_number', 'order_date as date', 'point_of_sales.location_id',
                                    'point_of_sales.location_id as from', 'point_of_sales.shopper_id as to', DB::raw("'Point Of Sale' as type"))
                                    ->get();

        $history = collect()
                    ->merge($purchase)
                    ->merge($purchaseReturn)
                    ->merge($productTransfers)
                    ->merge($productReceives)
                    ->merge($pointOfSale)
                    ->sortBy('date')
                    ->values();

        return view('imei_history.history', compact('imei', 'product','productLocation', 'history'));
    }


    // public function generateImportFormat()
    // {
    //     // Create new Spreadsheet object
    //     $spreadsheet = new Spreadsheet();
    //     $sheet = $spreadsheet->getActiveSheet();

    //     // Add headers
    //     $headers = [
    //         'no', 'name', 'code', 'category', 'category_prefix',
    //         'brand', 'brand_prefix', 'model', 'type', 'design',
    //         'min_quantity', 'is_imei', 'selling_price', 'location'
    //     ];

    //     foreach ($headers as $index => $header) {
    //         $column = $index + 1;
    //         $sheet->setCellValueByColumnAndRow($column, 1, $header);

    //         // Apply bold styling to headers
    //         $sheet->getStyleByColumnAndRow($column, 1)->getFont()->setBold(true);
    //     }

    //     // Add sample data
    //     $sampleData = [
    //         ['1', 'Xiaomi Redmi Note 13 Pro', 'PD-00001', 'Phone', 'ph', 'Xiaomi Global', 'mi', 'Note 13', '16/256GB', 'Navy Blue', '1', '1', '600000', 'Yangon Store'],
    //         ['2', 'Xiaomi Mi Note 13Pro 4G 3D Cover', 'CV-00002', 'Accessories', '03', 'Xiaomi', 'mi', 'Y19S', '-', '3D Cover', '3', '0', '5000', 'Hledan Store'],
    //         ['3', 'Xiaomi Mi Pad 6', 'TB-00003', 'Tablet', '02', 'Xiaomi Official Global', 'mi', 'A3', '8/128GB', 'Gold', '2', '1', '1200000', 'Yangon Store'],
    //         ['4', 'Scanner A', 'SC-00004', 'Scanner', 'sc', 'Scanner Brand', 'sc', 'Scanner Model', '-', '-', '2', '0', '130000', 'Hledan Store'],
    //     ];

    //     // Add the sample data starting from row 2
    //     $row = 2;
    //     foreach ($sampleData as $rowData) {
    //         foreach ($rowData as $col => $value) {
    //             $sheet->setCellValueByColumnAndRow($col + 1, $row, $value);
    //         }
    //         $row++;
    //     }

    //     // Auto-size columns
    //     foreach (range('A', 'N') as $col) { // Adjusted range to include all columns
    //         $sheet->getColumnDimension($col)->setAutoSize(true);
    //     }

    //     // Create the file in the public directory
    //     $writer = new Xlsx($spreadsheet);
    //     $filePath = public_path('product_import_format.xlsx');
    //     $writer->save($filePath);

    //     return response()->download($filePath);
    // }

}
