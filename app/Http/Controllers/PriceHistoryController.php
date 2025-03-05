<?php

namespace App\Http\Controllers;

use App\Actions\HandleFilterQuery;
use App\Actions\HandlePagination;
use App\Events\UpdateQuantity;
use App\Models\User;
use App\Models\Location;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Product;
use App\Models\ProductPriceHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;

class PriceHistoryController extends Controller
{
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
            $priceHistoryQuery = ProductPriceHistory::where('created_by', auth()->user()->id);
            $total_count = $priceHistoryQuery->count();

            $query = (new HandleFilterQuery(keyword: $keyword, start_date: $start_date, end_date: $end_date))->executeProductPriceChangeHistory(query: $priceHistoryQuery);

            $product_price_histories = $query->select(
                                                DB::raw('DATE_FORMAT(created_at, "%Y-%m-%d %H:%i") as date'),
                                                'created_by',
                                                DB::raw('GROUP_CONCAT(DISTINCT created_by SEPARATOR ", ") as data')
                                            )
                                            ->groupBy('created_by', DB::raw('DATE_FORMAT(created_at, "%Y-%m-%d %H:%i")')) // Group by user and second
                                            ->paginate(10);

            $search_count = $query->count();

            $html = View::make('price-history.search', compact('product_price_histories'))->render();

            return response()->json([
                'success' => true,
                'html' => $html,
                'total_count' => $total_count,
                'search_count' => $search_count,
                'pagination' => (new HandlePagination(data: $product_price_histories))->pagination()
            ]);
        }

        $product_price_histories = ProductPriceHistory::select(
                                                        DB::raw('DATE_FORMAT(created_at, "%Y-%m-%d %H:%i") as date'),
                                                        'created_by',
                                                        DB::raw('GROUP_CONCAT(DISTINCT created_by SEPARATOR ", ") as data')
                                                    )
                                                    ->where('created_by', auth()->user()->id)
                                                    ->groupBy('created_by', DB::raw('DATE_FORMAT(created_at, "%Y-%m-%d %H:%i")')) // Group by user and second
                                                    ->paginate(10);
                                                    // ->get();
                                                    // dd($product_price_histories);

        $total_count    = ProductPriceHistory::count();

        return view('price-history.index', compact('product_price_histories', 'total_count'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function createFirst(Request $request)
{
    $user = auth()->user();
    $purchasers = User::join('roles', 'roles.id', 'users.role_id')
                        ->where('roles.name', 'like', 'Purchaser')
                        ->select('users.*')
                        ->get();

    $categories = Category::all();
    $brands = Brand::all();

    if ($purchasers->count() === 1 || $user->hasRole('Super Admin')) {
        if ($request->ajax()) {
            $keyword = $request->input('search');
            $categoryId = $request->input('category_id');
            $brandId = $request->input('brand_id');

            $query = Product::where('is_foc', 'false')->orderByDesc('id');

            $query = (new HandleFilterQuery(keyword: $keyword))->executeProductFilter(query: $query);

            if ($categoryId) {
                $query->where('category_id', $categoryId);
            }
            if ($brandId) {
                $query->where('brand_id', $brandId);
            }

            $products = $query->get();

            $html = View::make('price-history.product-list', compact('products'))->render();

            return response()->json([
                'success' => true,
                'html' => $html,
            ]);
        }

        $products = Product::where('is_foc', 'false')->orderByDesc('id')->get();

        return view('price-history.create-first', compact('products', 'categories', 'brands'));
    } else {
        if ($request->ajax()) {
            $keyword = $request->input('search');
            $categoryId = $request->input('category_id');
            $brandId = $request->input('brand_id');

            $query = Product::where('is_foc', 'false')
                            ->where('created_by', $user->id)
                            ->orderByDesc('id');

            $query = (new HandleFilterQuery(keyword: $keyword))->executeProductFilter(query: $query);

            if ($categoryId) {
                $query->where('category_id', $categoryId);
            }
            if ($brandId) {
                $query->where('brand_id', $brandId);
            }

            $products = $query->paginate(10);

            $html = View::make('price-history.product-list', compact('products'))->render();

            return response()->json([
                'success' => true,
                'html' => $html,
                'pagination' => (new HandlePagination(data: $products))->pagination()
            ]);
        }

        $products = Product::where('is_foc', 'false')
                            ->where('created_by', $user->id)
                            ->orderByDesc('id')
                            ->paginate(10);

        return view('price-history.create-first', compact('products', 'categories', 'brands'));
    }
}


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function createFinal(Request $request)
    {
        $promoiton_product = json_decode($request->price_change_products, true);
        return view('price-history.create-final');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $price_change_products = json_decode($request->price_change_products, true);

        DB::beginTransaction();
        try {
            foreach ($price_change_products as $data) {
                $product = Product::find($data['id']);

                ProductPriceHistory::create([
                    'product_id' => $product->id,
                    'old_retail_price' => $product->retail_price,
                    'new_retail_price' => $data['new_retail_price'] === 0 ? $product->retail_price : $data['new_retail_price'],
                ]);

                $product->retail_price = $data['new_retail_price'] === 0 ? $product->retail_price : $data['new_retail_price'];
                $product->save();

                // event(new UpdateQuantity($product));
            }
            DB::commit();

            return redirect()->route('price-history')->with('success', 'Success! Product Price Updated');
        } catch (\Exception $e) {
            DB::rollback();

            return back()->with('error', 'Failed! Product Price Change can not Created');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $product = Product::find($request->product_id);

        ProductPriceHistory::create([
            'product_id' => $product->id,
            'old_price' => $product->price,
            'new_price' => $request->new_price,
        ]);

        $product->price = $request->new_price;
        $product->save();

        return redirect()->route('price-history')->with('success', 'Success! Product Price Updated');
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

    public function priceChange()
    {
        $products = Product::all();
        return view('price-history.price-change', compact('products'));
    }

    public function productHistoryDetail($date)
    {
        $product_price_histories = ProductPriceHistory::where(DB::raw('DATE_FORMAT(created_at, "%Y-%m-%d %H:%i")'), $date)
                                                    ->where('created_by', auth()->user()->id)
                                                    ->select('product_price_histories.*')
                                                    ->paginate(10);
        return view('price-history.detail', compact('product_price_histories'));
    }



    // public function searchProduct(Request $request)
    // {
    //     $keyword                = $request->input('search');
    //     $selected_products      = $request->input('selectedData');
    //     $selected_products      = $selected_products ?? [];
    //     $query        = Product::query();

    //     $query = (new HandleFilterQuery(keyword: $keyword))->executeProductFilter(query: $query);

    //     $products = $query->orderByDesc('id')->paginate(10);

    //     $html = view('price-history.product-list', compact('products'))->render();

    //     return response()->json([
    //         'success' => true,
    //         'html' => $html,
    //     ]);
    // }
}
