<?php

namespace App\Http\Controllers;

use App\Actions\HandleFilterQuery;
use App\Actions\HandlePagination;
use App\Actions\UpdateProductQuantity;
use App\Constants\PrefixCodeID;
use App\Constants\PromotionType;
use App\Http\Requests\Promotion\StorePromotionRequest;
use App\Http\Requests\Promotion\UpdatePromotionRequest;
use App\Models\Order;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Promotion;
use App\Models\PromotionProduct;
use App\Models\Location;
use App\Traits\GetUserLocationTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;

class PromotionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    use GetuserLocationTrait;

    public function index(Request $request)
    {

        if ($request->ajax()) {

            $query        = Promotion::where('created_by', auth()->user()->id);

            $keyword    = $request->search;
            $start_date = $request->start_date;
            $end_date   = $request->end_date;

            $query = (new HandleFilterQuery(keyword: $keyword, start_date: $start_date, end_date: $end_date))->executePromotionFilter(query: $query);

            $promotions = $query->paginate(10);

            $html = View::make('promotion.search', compact('promotions'))->render();

            return response()->json([
                'success' => true,
                'html' => $html,
                'pagination' => (new HandlePagination(data: $promotions))->pagination()
            ]);
        }
        $promotions = Promotion::where('created_by', auth()->user()->id)
                                        ->orderByDesc('id')
                                        ->paginate(10);

        $total_count = $promotions->count();

        return view('promotion.index', compact('promotions', 'total_count'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function createFirst(Request $request)
    {
        $locations = $this->getDissminationLocations();

        $promo_code = 'PROMO-' . date('YmdHis');

        return view('promotion.create-first', compact('locations', 'promo_code'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function createSecond(Request $request)
    {
        $check_all_locations = array_search('all', $request->locations);
        if($check_all_locations !== false){
            $locations = Location::join('location_types as lt', 'lt.id', 'locations.location_type_id')
                                    ->where('lt.location_type_name', 'Branch')
                                    ->select('locations.id')
                                    ->pluck('locations.id')
                                    ->toArray();
        }else{
            $locations = array_map('intval', $request->locations);
        }

        $sessionData = [
            'promo_code' => $request->promo_code,
            'title' => $request->title,
            'locations' => $locations,
            'promo_type' => $request->promo_type,
        ];

        session($sessionData);

        $locations = Location::whereIn('id', session('locations'))->select('location_name')->get();

        return view('promotion.create-second', compact('locations'));
    }

    public function createThird(Request $request)
    {
        if ($request->ajax()) {
            $query = Product::query();

            $promotedProductIds = PromotionProduct::pluck('buy_product_id')->toArray();
            $query->whereNotIn('id', $promotedProductIds);

            if ($request->category_id) {
                $query->where('category_id', $request->category_id);
            }

            if ($request->brand_id) {
                $query->where('brand_id', $request->brand_id);
            }

            if ($request->search) {
                $keyword = "%{$request->search}%";
                $query->where(function ($query) use ($keyword) {
                    $query->where('name', 'like', $keyword)
                        ->orWhere('code', 'like', $keyword)
                        ->orWhereHas('brand', function ($query) use ($keyword) {
                            $query->where('name', 'like', $keyword);
                        })
                        ->orWhereHas('category', function ($query) use ($keyword) {
                            $query->where('name', 'like', $keyword);
                        })
                        ->orWhereHas('productModel', function ($query) use ($keyword) {
                            $query->where('name', 'like', $keyword);
                        });
                });
            }

            $products = $query->get();

            $html = View::make('promotion.selected-product', [
                'products' => $products,
                'promo_type' => session('promo_type')
            ])->render();

            return response()->json([
                'success' => true,
                'html' => $html,
            ]);
        }

        $promotedProductIds = PromotionProduct::pluck('buy_product_id')->toArray();

        if ($request->choose_by == 'brands') {
            if ($request->category_id && $request->brand_id) {
                $products = Product::where('category_id', $request->category_id)
                                 ->where('brand_id', $request->brand_id)
                                 ->whereNotIn('id', $promotedProductIds)
                                 ->get();
            } else {
                $products = collect();
            }
        } else if ($request->choose_by == 'products') {
            $products = Product::whereNotIn('id', $promotedProductIds)->get();
        } else {
            $products = collect();
        }

        $categories = Category::all();
        $brands = Brand::with('products')->get();

        $brandCategoryMap = [];
        foreach ($brands as $brand) {
            $categoryIds = $brand->products->pluck('category_id')->unique()->toArray();
            $brandCategoryMap[$brand->id] = $categoryIds;
        }

        return view('promotion.create-third', compact('products', 'categories', 'brands', 'brandCategoryMap'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function createFinal(Request $request)
    {
        $promotion_products = json_decode($request->selected_products, true);
        $value = session()->get('value');
        $promo_type = session()->get('promo_type');

        if (is_array($promotion_products)) {
            foreach ($promotion_products as &$data) {
                $product_data = Product::find($data['product_id']);
                switch ($promo_type) {
                    case 'dis_percentage':
                        $promo_price = intval($product_data->retail_price - ($product_data->retail_price * ($value/100)));
                        break;

                    case 'dis_price':
                        $promo_price = intval($product_data->retail_price - $value);
                        break;

                    case 'cashback':
                        $promo_price = 0;
                        break;
                }

                $data['normal_price'] = $product_data->retail_price;
                $data['promo_price'] = $promo_price;

                if (isset($data['cashback'])) {
                    $data['cashback'] = $data['cashback'];
                }
            }
        }

        $all_location_ids = $this->getDissminationLocations()->pluck('id')->toArray();
        $missingIds = array_diff(session('locations'), $all_location_ids);
        $locationData = empty($missingIds) ? "All Locations" : Location::whereIn('id', session('locations'))->pluck('location_name')->join(', ');

        return view('promotion.create-final', compact('locationData', 'promotion_products'));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $promotion_products = json_decode($request->promotion_products, true);

        $title = session()->get('title');
        $code = session()->get('promo_code');
        $locations = session()->get('locations');
        $promo_type = session()->get('promo_type');
        $value = session()->get('value');
        $variant = session()->get('variant');
        $start_date = date('Y-m-d', strtotime(session()->get('start_date')));
        $end_date = date('Y-m-d', strtotime(session()->get('end_date')));

        DB::beginTransaction();

        try {

            $promotion = Promotion::create([
                'title' => $title,
                'code' => $code,
                'locations' => json_encode($locations),
                'promo_type' => $promo_type,
                'value' => $value,
                'start_date' => $start_date,
                'end_date' => $end_date,
                'status' => 'inactive',
                'created_by' => auth()->user()->id,
                'variant' => $variant
            ]);

            foreach ($promotion_products as $key => $data) {
                $product = Product::find($data['product_id']);

                PromotionProduct::create([
                    'promotion_id' => $promotion->id,
                    'buy_product_id' => $data['product_id'],
                    'buy_quantity' => $data['quantity'],
                    'cashback_value' => $data['cashback']
                ]);
            }

            DB::commit();

            $request->session()->forget('title');
            $request->session()->forget('promo_code');
            $request->session()->forget('locations');
            $request->session()->forget('promo_type');
            $request->session()->forget('value');
            $request->session()->forget('start_date');
            $request->session()->forget('end_date');
            $request->session()->forget('variant');

            return redirect()->route('promotion')->with('success', 'Success! Promotion Created');
        } catch (\Exception $e) {
            // dd($e);
            DB::rollback();

            return back()->with('error', 'Failed! Promotion can not Created');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Promotion  $promotion
     * @return \Illuminate\Http\Response
     */
    public function show(Promotion $promotion)
    {
        $location_count = Location::join('location_types as lt', 'lt.id', 'locations.location_type_id')
                                ->where('lt.location_type_name', 'Branch')
                                ->count();

        $promo_locations = json_decode($promotion->locations);

        if($location_count == count($promo_locations)){
            $locations = 'All Branches';
        }else{
            $locations = Location::whereIn('id', $promo_locations)->pluck('location_name');
            $locations = $locations->join(', ');
        }

        return view('promotion.detail', compact('promotion', 'locations'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Promotion  $promotion
     * @return \Illuminate\Http\Response
     */
    public function edit(Promotion $promotion)
    {
        $product_count = PromotionProduct::where('promotion_id', $promotion->id)->count();

        return view('promotion.edit', compact('promotion', 'product_count'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Promotion  $promotion
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePromotionRequest $request, Promotion $promotion)
    {
        $promotion_name  = $request->name;

        list($start_date, $end_date) = explode(' - ', $request->daterange);

        $promoiton_products = json_decode($request->selected_products, true);
        $selected_products = [];

        DB::beginTransaction();

        try {

            $promotion->update([
                'name' => $promotion_name,
                'start_date' => format_date($start_date),
                'end_date' => format_date($end_date),
            ]);

            if (count($promoiton_products) > 0) {

                foreach ($promoiton_products as $product) {

                    $product_id     = $product['id'];
                    $sell_price     = $product['original_price'];
                    $new_price      = $product['new_price'];

                    $selected_products[] = $this->executeProductUpdateAndGet($product_id, $new_price, $sell_price);
                }

                $promotion->productable()->delete();

                $promotion->productable()->createMany($selected_products);
            }


            DB::commit();

            return redirect()->route('promotion')->with('success', 'Success! Promotion Updated');
        } catch (\Exception $e) {

            DB::rollback();

            return back()->with('error', 'Failed! Promotion can not Created');
        }
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Promotion  $promotion
     * @return \Illuminate\Http\Response
     */
    public function destroy(Promotion $promotion)
    {
        $promotion->delete();

        return response()->json([
            'message' => 'The record has been deleted successfully.',
            'status' => 200,
        ], 200);
    }

    public function executeProductUpdateAndGet($product_id, $new_price, $sell_price)
    {

        $product = Product::find($product_id);

        $product->promotion_price = $new_price;
        $product->promotion_status = 1;
        $product->save();

        $selected_products = [
            'product_id' => $product_id,
            'price' => $new_price,
            'sell_price' => $sell_price,
            'amount' => $new_price,
            'latest_quantity' => $product->quantity
        ];

        return $selected_products;
    }

    public function changeStatus(Request $request, Promotion $promotion)
    {
        try {
            $promotion->status = $request->status;
            $promotion->update();

            return [
                'message' => 'Promotion Status Changed',
            ];

        } catch (\Throwable $th) {
            throw $th;
            return [
                'message' => 'error'
            ];
        }
    }

    public function chooseProductSearch(Request $request){
        $keyword = $request->input('search');
        $keyword = "%{$keyword}%";

        $products = Product::where(function ($query) use ($keyword) {
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

        $html = View::make('promotion.selected-product', compact('products'))->render();

        return response()->json([
            'success' => true,
            'html' => $html,
        ]);
    }

    public function chooseMethod(Request $request)
    {
        if(session()->get('promo_type') !== 'cashback'){
            if($request->value == null){
                return back()->with('error', 'Failed! Something Went Wrong');
            }
        }

        $categories = Category::where('slug','!=', 'foc')->get();

        $sessionData = [
            'value' => $request->value,
            'variant' => $request->variant,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
        ];

        session($sessionData);

        return view('promotion.choose-method', compact('categories'));
    }

    public function getBrands(Request $request)
    {
        $brands = Brand::where('category_id', $request->category_id)->get();
        return response()->json(['brands' => $brands]);
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
}
