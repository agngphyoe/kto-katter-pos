<?php

namespace App\Http\Controllers;

use App\Actions\HandleDashboard;
use App\Constants\ProgressStatus;
use App\Models\ActivityLog;
use App\Models\Customer;
use App\Models\Damage;
use App\Models\Order;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\PurchaseReturn;
use App\Models\Returnable;
use App\Models\Sale;
use App\Models\SaleReturn;
use App\Models\LocationStock;
use App\Models\PointOfSale;
use App\Models\Location;
use App\Models\Paymentable;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $products = Product::all();

        $productsBelowMinQty = LocationStock::whereColumn('quantity', '<', 'products.minimum_quantity')
        ->join('products', 'location_stocks.product_id', '=', 'products.id')
        ->select('location_stocks.*', 'products.name as product_name', 'products.minimum_quantity')
        ->get();

        $today = Carbon::today();
        $yesterday = Carbon::yesterday();
        $currentMonth = Carbon::now()->month;
        $lastMonth = Carbon::now()->subMonth()->month;

        $todayTotalPurchase = Purchase::whereDate('created_at', $today)
                                        ->sum('purchase_amount');

        // Get the current month's total purchase
        $currentMonth = Carbon::now()->month;
        $totalPurchaseThisMonth = Purchase::whereMonth('created_at', $currentMonth)
                                          ->sum('purchase_amount');

        // Calculate today's total sales
        $todayTotalSales = PointOfSale::whereDate('created_at', $today)
                                      ->sum('net_amount');

        $yesterdayTotalSales = PointOfSale::whereDate('created_at', $yesterday)
                                      ->sum('net_amount');

        if ($todayTotalSales == 0 && $yesterdayTotalSales == 0) {
            $daySalePercentage = null; // Or some other logic to signify no percentage
        } else {
            $daySalePercentage = $yesterdayTotalSales > 0
                ? number_format((($todayTotalSales - $yesterdayTotalSales) / $yesterdayTotalSales) * 100)
                : 100;
        }

        $thisMonthTotalSales = PointOfSale::whereMonth('created_at', $currentMonth)
                                            ->sum('net_amount');

        $lastMonthTotalSales = PointOfSale::whereMonth('created_at', $lastMonth)
                                            ->sum('net_amount');

        if ($thisMonthTotalSales == 0 && $lastMonthTotalSales == 0) {
            $monthSalePercentage = null;
        } else {
            $monthSalePercentage = $lastMonthTotalSales > 0
                ? number_format((($thisMonthTotalSales - $lastMonthTotalSales) / $lastMonthTotalSales) * 100)
                : 100;
        }

        // $daySalePercentage = number_format($percentageChange, 2);

        $todaySalesByLocation = PointOfSale::whereDate('created_at', $today)
        ->select('location_id', DB::raw('SUM(net_amount) as total_amount'))
        ->groupBy('location_id')
        ->with('location') // Assuming you have a relationship set up
        ->get();

        // Calculate total sales for all branches
        $totalSalesAllBranches = PointOfSale::sum('net_amount');

        $totalSalesAllBranchesByLocation = PointOfSale::select('location_id', DB::raw('SUM(net_amount) as total_amount'))
        ->groupBy('location_id')
        ->with('location')
        ->get();

        $shops = Location::where('location_type_id', 2)->get();

        // Calculate top sales for all shops
        $salesData = DB::table('point_of_sale_products')
        ->join('products', 'point_of_sale_products.product_id', '=', 'products.id')
        ->join('point_of_sales', 'point_of_sale_products.point_of_sale_id', '=', 'point_of_sales.id')
        ->select(
            'products.category_id',
            'products.brand_id',
            'products.model_id',
            DB::raw('SUM(point_of_sale_products.quantity) as total_quantity')
        )
        ->groupBy('products.category_id', 'products.brand_id', 'products.model_id')
        ->get();

        // Get top-selling category, brand, model
        $topSaleCategoryCollection = $salesData->groupBy('category_id')->sortByDesc(function ($category) {
            return $category->sum('total_quantity');
        })->take(5);

        $topSaleBrandCollection = $salesData->groupBy('brand_id')->sortByDesc(function ($brand) {
            return $brand->sum('total_quantity');
        })->take(5);

        $topSaleModelCollection = $salesData->groupBy('model_id')->sortByDesc(function ($model) {
            return $model->sum('total_quantity');
        })->take(5);

        // Fetch the names using the IDs
        $topSaleCategory = $topSaleCategoryCollection->map(function ($category) {
            $categoryModel = \App\Models\Category::find($category->first()->category_id);
            $categoryModel->total_quantity = $category->sum('total_quantity');
            return $categoryModel;
        });

        $topSaleBrand = $topSaleBrandCollection->map(function ($brand) {
            $brandModel = \App\Models\Brand::find($brand->first()->brand_id);
            $brandModel->total_quantity = $brand->sum('total_quantity');
            return $brandModel;
        });

        $topSaleModel = $topSaleModelCollection->map(function ($model) {
            $productModel = \App\Models\ProductModel::find($model->first()->model_id);
            $productModel->total_quantity = $model->sum('total_quantity');
            return $productModel;
        });

        $sevenDaysFromNow = $today->copy()->addDays(7);
        $upcomingPurchases = Purchase::whereBetween('due_date', [$today, $sevenDaysFromNow])
                            ->with('supplier')
                            ->get();

        $productsWithQuantities = Product::whereHas('location')
                                        ->withSum('location as total_quantity', 'quantity')
                                        ->get(['id', 'name']);

        $productQuantityChartData = [
            'labels' => $productsWithQuantities->pluck('name')->toArray(),
            'data' => $productsWithQuantities->pluck('total_quantity')->toArray()
        ];

        return view('dashboard.index', compact('products', 'productsBelowMinQty', 'todayTotalPurchase',
                                               'totalPurchaseThisMonth', 'todayTotalSales', 'yesterdayTotalSales',
                                               'daySalePercentage', 'thisMonthTotalSales', 'lastMonthTotalSales',
                                               'monthSalePercentage', 'totalSalesAllBranches', 'shops', 'topSaleCategory',
                                               'topSaleBrand', 'topSaleModel', 'todaySalesByLocation', 'totalSalesAllBranchesByLocation',
                                               'upcomingPurchases', 'productQuantityChartData'));
    }

    public function locationData($location)
    {
        if ($location == 'all') {
            return redirect()->route('dashboard');
        }

        $total_products = Product::join('location_stocks as ls','ls.product_id', 'products.id')
                                    ->where('ls.location_id', $location)
                                    ->select('products.*')
                                    ->get();

        $today = Carbon::today();
        $yesterday = Carbon::yesterday();
        $currentMonth = Carbon::now()->month;
        $lastMonth = Carbon::now()->subMonth()->month;

        $todayTotalPurchase = Purchase::whereDate('created_at', $today)
                                        ->sum('purchase_amount');

        // Get the current month's total purchase
        $totalPurchaseThisMonth = Purchase::whereMonth('created_at', $currentMonth)
                                          ->sum('purchase_amount');

        // Calculate today's total sales
        $todayTotalSales = PointOfSale::where('location_id', $location)
                                      ->whereDate('created_at', $today)
                                      ->sum('net_amount');

        $yesterdayTotalSales = PointOfSale::where('location_id', $location)
                                      ->whereDate('created_at', $yesterday)
                                      ->sum('net_amount');

        $thisMonthTotalSales = PointOfSale::where('location_id', $location)
                                      ->whereMonth('created_at', $currentMonth)
                                      ->sum('net_amount');

        $lastMonthTotalSales = PointOfSale::where('location_id', $location)
                                      ->whereMonth('created_at', $lastMonth)
                                      ->sum('net_amount');

        if ($todayTotalSales == 0 && $yesterdayTotalSales == 0) {
            $daySalePercentage = null;
        } else {
            $daySalePercentage = $yesterdayTotalSales > 0
                ? number_format((($todayTotalSales - $yesterdayTotalSales) / $yesterdayTotalSales) * 100)
                : 100;
        }

        if ($thisMonthTotalSales == 0 && $lastMonthTotalSales == 0) {
            $monthSalePercentage = null;
        } else {
            $monthSalePercentage = $lastMonthTotalSales > 0
                ? number_format((($thisMonthTotalSales - $lastMonthTotalSales) / $lastMonthTotalSales) * 100)
                : 100;
        };

        $todaySalesByLocation = 0;

        // Calculate total sales for all branches
        $totalSalesAllBranches = PointOfSale::sum('net_amount');

        $totalSalesAllBranchesByLocation = 0;

        $shops = Location::where('location_type_id', 2)->get();

        // Calculate top sales for all shops
        $salesData = DB::table('point_of_sale_products')
                        ->join('products', 'point_of_sale_products.product_id', '=', 'products.id')
                        ->join('point_of_sales', 'point_of_sale_products.point_of_sale_id', '=', 'point_of_sales.id')
                        ->select(
                            'products.category_id',
                            'products.brand_id',
                            'products.model_id',
                            DB::raw('SUM(point_of_sale_products.quantity) as total_quantity')
                        )
                        ->groupBy('products.category_id', 'products.brand_id', 'products.model_id')
                        ->get();

        // Get top-selling category
        $topSaleCategoryCollection = $salesData->groupBy('category_id')->sortByDesc(function ($category) {
            return $category->sum('total_quantity');
        })->take(10);

        // Get top-selling brand
        $topSaleBrandCollection = $salesData->groupBy('brand_id')->sortByDesc(function ($brand) {
            return $brand->sum('total_quantity');
        })->take(10);

        // Get top-selling model
        $topSaleModelCollection = $salesData->groupBy('model_id')->sortByDesc(function ($model) {
            return $model->sum('total_quantity');
        })->take(10);

        // Fetch the names using the IDs
        $topSaleCategory = $topSaleCategoryCollection->map(function ($category) {
            return \App\Models\Category::find($category->first()->category_id);
        });
        $topSaleBrand = $topSaleBrandCollection->map(function ($brand) {
            return \App\Models\Brand::find($brand->first()->brand_id);
        });
        $topSaleModel = $topSaleModelCollection->map(function ($model) {
            return \App\Models\ProductModel::find($model->first()->model_id);
        });

        $sevenDaysFromNow = $today->copy()->addDays(7);
        $upcomingPurchases = Purchase::whereBetween('due_date', [$today, $sevenDaysFromNow])
                            ->with('supplier')
                            ->get();

        $productsWithQuantities = Product::whereHas('location', function ($query) use ($location) {
                                    $query->where('location_id', $location);
                                })
                                ->withSum(['location as total_quantity' => function ($query) use ($location) {
                                    $query->where('location_id', $location);
                                }], 'quantity')
                                ->get(['id', 'name']);

        $productQuantityChartData = [
                        'labels' => $productsWithQuantities->pluck('name')->toArray(),
                        'data' => $productsWithQuantities->pluck('total_quantity')->toArray()
        ];

        $data = [
            'total_products' => $total_products,
            // 'productsBelowMinQty' => $productsBelowMinQty,
            'todayTotalPurchase' => $todayTotalPurchase,
            'totalPurchaseThisMonth' => $totalPurchaseThisMonth,
            'todayTotalSales' => $todayTotalSales,
            'yesterdayTotalSales' => $yesterdayTotalSales,
            'daySalePercentage' => $daySalePercentage,
            'thisMonthTotalSales' => $thisMonthTotalSales,
            'lastMonthTotalSales' => $lastMonthTotalSales,
            'monthSalePercentage' => $monthSalePercentage,
            'totalSalesAllBranches' => $totalSalesAllBranches,
            'shops' => $shops,
            'topSaleCategory' => $topSaleCategory,
            'topSaleBrand' => $topSaleBrand,
            'topSaleModel' => $topSaleModel,
            'todaySalesByLocation' => $todaySalesByLocation,
            'totalSalesAllBranchesByLocation' => $totalSalesAllBranchesByLocation,
            'upcomingPurchases' => $upcomingPurchases,
            'location_id' => $location,
            'productQuantityChartData' => $productQuantityChartData,
        ];

        return response()->json($data);
    }

    public function productChartData(Request $request){
        $product_id = intval($request->search);
        $chartLabel = [];
        $chartStock = [];

        $product = Product::find($product_id);

        $locations = LocationStock::where('product_id', $product_id)
                                    ->where('quantity', '!=', 0)
                                    ->get();

        foreach ($locations as $location) {
            $chartLabel[] = $location->location->location_name;
            $chartStock[] = $location->quantity;
        }

        $formattedData = [
            'labels' => $chartLabel,
            'data' => $chartStock,
            'product_name' => $product->name,
        ];

        return response()->json(['data' => $formattedData]);
    }

    public function filterShopData(Request $request)
    {
        $shopId = $request->input('shop_id');

        $salesQuery = DB::table('point_of_sale_products')
            ->join('products', 'point_of_sale_products.product_id', '=', 'products.id')
            ->join('point_of_sales', 'point_of_sale_products.point_of_sale_id', '=', 'point_of_sales.id')
            ->select(
                'products.category_id',
                'products.brand_id',
                'products.model_id',
                DB::raw('SUM(point_of_sale_products.quantity) as total_quantity')
            );

        if ($shopId) {
            $salesQuery->where('point_of_sales.location_id', $shopId);
        }

        $salesData = $salesQuery->groupBy('products.category_id', 'products.brand_id', 'products.model_id')->get();

        $topSaleCategory = $salesData->groupBy('category_id')->sortByDesc(function ($category) {
            return $category->sum('total_quantity');
        })->first();

        $topSaleBrand = $salesData->groupBy('brand_id')->sortByDesc(function ($brand) {
            return $brand->sum('total_quantity');
        })->first();

        $topSaleModel = $salesData->groupBy('model_id')->sortByDesc(function ($model) {
            return $model->sum('total_quantity');
        })->first();

        return response()->json([
            'top_sales_category' => $topSaleCategory ? $topSaleCategory->first()->category->name : 'N/A',
            'top_sales_brand' => $topSaleBrand ? $topSaleBrand->first()->brand->name : 'N/A',
            'top_sales_model' => $topSaleModel ? $topSaleModel->first()->model->name : 'N/A',
        ]);
    }
}
