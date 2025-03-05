<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Location;
use App\Models\LocationStock;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use App\Models\IMEIProduct;
use App\Models\StockReconciliation;
use App\Models\StockReconciliationProduct;
use App\Traits\GetUserLocationTrait;
use App\Actions\HandleFilterQuery;
use App\Actions\HandlePagination;
use Auth;
use View;
use DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ReconcileExport;

class StockCheckController extends Controller
{

    use GetUserLocationTrait;


    public function index(Request $request){

        $user = Auth::user();

        if($request->ajax()){
            $keyword     = $request->input('search');

            if($user->hasRole('Super Admin')){
                $query = Location::query();
            }else{
                $query = Location::whereIn('id', $this->validateLocation());
            }

            $total_count = $query->count();

            $locations = (new HandleFilterQuery(keyword: $keyword))->executeLocationFilter(query: $query)->paginate(10);

            $html = View::make('stock-check.location-search', compact('locations'))->render();

            return response()->json([
                'success' => true,
                'html' => $html,
                'total_count' => $total_count,
                'search_count' => $locations->total(),
                'pagination' => (new HandlePagination(data: $locations))->pagination()
            ]);

        }

        if($user->hasRole('Super Admin')){
            $locations = Location::paginate(10);
        }else{
            $locations = Location::whereIn('id', $this->validateLocation())
                                    ->paginate(10);
        }

        return view('stock-check.index', compact('locations'));
    }

    public function stockDetails(Request $request){
        $location = Location::find($request->id);

        $products = Product::join('location_stocks as ls', 'ls.product_id', 'products.id')
                            ->where('ls.location_id', $location->id)
                            ->select('products.*', 'ls.quantity as quantity')
                            ->get();

        foreach ($products as $product) {
            $product->total_retail_selling_price = $product->retail_price * $product->quantity;
        }

        return view('stock-check.detail', compact('location', 'products'));
    }

    public function searchLocationProduct(Request $request){
        $location = Location::find($request->location_id);
        $search = '%'.$request->search.'%';

        $products = Product::join('location_stocks as ls', 'ls.product_id', 'products.id')
                            ->where('ls.location_id', $location->id)
                            ->where(function($query) use ($search) {
                                $query->where('products.name', 'like', $search)
                                    ->orWhere('products.code', 'like', $search);
                            })
                            ->select('products.*', 'ls.quantity as quantity')
                            ->get();

        foreach ($products as $product) {
            $product->total_retail_selling_price = $product->retail_price * $product->quantity;
        }

        $html = View::make('stock-check.product-search', compact('products', 'location'))->render();

        return response()->json([
            'success' => true,
            'html' => $html,
        ]);
    }

    public function imeiStock(Request $request)
    {
        $product = Product::find($request->product_id);
        $location = Location::find($request->location_id);

        $imei_numbers = IMEIProduct::where('product_id', $product->id)
                                    ->where('location_id', $location->id)
                                    ->where('status', '!=', 'Sold')
                                    ->get();

        $quantity = $imei_numbers->count();

        return view('stock-check.imei-stock', compact('product', 'location', 'imei_numbers', 'quantity'));
    }

    public function locationReconcile(Request $request)
    {
        $location = Location::find($request->location_id);

        $products = Product::join('location_stocks as ls', 'ls.product_id', 'products.id')
                           ->where('ls.location_id', $location->id)
                           ->select('products.*', 'ls.quantity as quantity')
                           ->get();

        $categories = Category::all();
        $brands = Brand::all();

        return view('stock-check.reconcile', compact('location', 'products', 'categories', 'brands'));
    }

    public function getBrandsByCategory(Request $request)
    {
        $categoryId = $request->category_id;

        $brands = Brand::whereHas('products', function ($query) use ($categoryId) {
            $query->where('category_id', $categoryId);
        })->get();

        return response()->json([
            'success' => true,
            'brands' => $brands
        ]);
    }

    public function searchReconcileProduct(Request $request)
    {
        $location = Location::find($request->location_id);
        $search = '%' . $request->search . '%';

        $query = Product::join('location_stocks as ls', 'ls.product_id', 'products.id')
            ->where('ls.location_id', $location->id)
            ->where(function ($query) use ($search) {
                $query->where('products.name', 'like', $search)
                      ->orWhere('products.code', 'like', $search);
            });

        if ($request->filled('category_id')) {
            $query->where('products.category_id', $request->category_id);
        }

        if ($request->filled('brand_id')) {
            $query->where('products.brand_id', $request->brand_id);
        }

        $products = $query->select('products.*', 'ls.quantity as quantity')->get();

        $html = View::make('stock-check.reconcile-product-search', compact('products', 'location'))->render();

        return response()->json([
            'success' => true,
            'html' => $html,
        ]);
    }

    public function saveReconcile(Request $request)
    {
        $data = $request->all();
        $products = [];

        foreach ($data as $key => $value) {
            if (preg_match('/^(inventoryQty|realQty)_(\d+)$/', $key, $matches)) {
                $type = $matches[1];
                $productId = $matches[2];

                if (!isset($products[$productId])) {
                    $products[$productId] = [
                        'inventoryQty' => 0,
                        'realQty' => 0,
                        'difference' => 0,
                    ];
                }

                $products[$productId][$type] = (int)$value;
            }
        }

        foreach ($products as $productId => &$product) {
            $product['difference'] = $product['realQty'] - $product['inventoryQty'];
        }

        try {
            DB::beginTransaction();
            $reconcile = StockReconciliation::create([
                'reconciliation_id' => 'STR-'. date('YmdHis'),
                'location_id' => $request->location_id,
                'reconciliation_date' => date('Y-m-d'),
                'created_by' => auth()->user()->id,
            ]);

            foreach ($products as $product_id => $data) {
                StockReconciliationProduct::create([
                    'stock_reconciliation_id' => $reconcile->id,
                    'product_id' => $product_id,
                    'inv_qty' => $data['inventoryQty'],
                    'real_qty' => $data['realQty'],
                    'diff' => $data['difference']
                ]);
            }

            DB::commit();

            return redirect()->route('reconciliation-detail', ['id' => $reconcile->id])
                ->with('success', 'Reconciliation saved successfully');

        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()
                ->with('error', 'Failed to save reconciliation: ' . $e->getMessage());
        }
    }

    public function reconciliationDetail($id)
    {
        $reconciliation = StockReconciliation::with(['products', 'location', 'createdBy'])
            ->findOrFail($id);

        return view('stock-check.reconciliation-detail', compact('reconciliation'));
    }

    public function exportReconcile($id)
    {
        $reconciliation = StockReconciliation::findOrFail($id);

        // Format the file name with parentheses around the date
        $fileName = 'reconcile(' . $reconciliation->reconciliation_date->format('Ymd') . ').xlsx';

        return Excel::download(new ReconcileExport($reconciliation->id), $fileName);
    }

}
