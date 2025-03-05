<?php

namespace App\Http\Controllers;

use App\Actions\HandleFilterQuery;
use App\Actions\HandlePagination;
use App\Http\Requests\ProductModel\StoreProductModelRequest;
use App\Http\Requests\ProductModel\UpdateProductModelRequest;
use App\Models\Brand;
use App\Models\Category;
use App\Models\ProductModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Str;

class ProductModelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $total_count    = ProductModel::count();

        if ($request->ajax()) {

            $product_modelQuery       = ProductModel::query();
            $total_count              = $product_modelQuery->count();

            $keyword    = $request->search;
            $start_date = $request->start_date;
            $end_date   = $request->end_date;

            $query = (new HandleFilterQuery(keyword: $keyword, start_date: $start_date, end_date: $end_date))->executeKeyDataForProductFilter(query: $product_modelQuery);

            $search_count = $query->count();
            $product_models = $query->paginate(10);

            $html = View::make('product-model.search', compact('product_models'))->render();

            return response()->json([
                'success' => true,
                'html' => $html,
                'total_count' => $total_count,
                'search_count' => $search_count,
                'pagination' => (new HandlePagination(data: $product_models))->pagination()
            ]);
        }

        $product_models          = ProductModel::orderByDesc('id')->paginate(10);
        return view('product-model.index', compact('product_models', 'total_count'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $brands = Brand::all();
        $categories = Category::where('name', '!=', 'FOC')->get();

        return view('product-model.create', compact('brands', 'categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProductModelRequest $request)
    {
        $request['slug'] = customSlug($request->name);
        $request['created_by'] = auth()->user()->id;
        $data = $request->except(['category_id']);

        $modelExist = ProductModel::where('brand_id', $data['brand_id'])
                                    ->where('slug', $data['slug'])
                                    ->first();

        if (!$modelExist) {
            $productModel = ProductModel::create($data);
        } else {
            return redirect()->route('product-model')->with('error', 'Product Already Exists');
        }

        if ($request->ajax()) {
            if ($productModel) {
                $brand_id = $request->input('brand_id');
                $brand = Brand::find($brand_id);
                $brands = Brand::all();
                $product_models = $brand->productModel;
                $html = View::make('product-model.product-model-select', compact('product_models'))->render();
                $selected_brand = View::make('product.selected-brand', compact('brands', 'brand_id'))->render();

                return response()->json([
                    'message' => 'The Design created successfully.',
                    'status' => 200,
                    'html'  => $html,
                    'selected_brand'  => $selected_brand,
                ], 200);
            }
        }

        if ($productModel) {
            return redirect()->route('product-model')->with('success', 'Success! Product Model Created');
        }

        return back()->with('error', 'Failed! Product Model can\'t Created');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ProductModel  $productModel
     * @return \Illuminate\Http\Response
     */
    public function show(ProductModel $productModel)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ProductModel  $productModel
     * @return \Illuminate\Http\Response
     */
    public function edit(ProductModel $product_model)
    {
        $brands = Brand::all();
        $categories = Category::all();
        return view('product-model.edit', compact('product_model', 'brands' , 'categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ProductModel  $productModel
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProductModelRequest $request, ProductModel $product_model)
    {
        $data = $request->except(['category_id']); // Ensure 'prefix' is not included
        $data['slug'] = Str::slug($request->name);

        $modelExist = ProductModel::where('brand_id', $data['brand_id'])
                                    ->where('slug', $data['slug'])
                                    ->first();

        if ($modelExist) {
            return redirect()->route('product-model')->with('error', 'Product Already Exists');
        } else {
            $product_model->name = $data['name'];
            $product_model->brand_id = $data['brand_id'];
            $product_model->slug = $data['slug'];
            $product_model->save();

            return redirect()->route('product-model')->with('success', 'Success! Product Model Updated');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ProductModel  $productModel
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProductModel $productModel)
    {
        try {
            $productModel->delete();

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

    public function getCategoryBrands(Request $request)
    {
        $categories_id = $request->input('id');
        $categories = Category::find($categories_id);
        $brands = $categories->brands;
        $html = View::make('brand.product-brand-select', compact('brands'))->render();
        return response()->json([
            'success' => true,
            'html' => $html,
        ]);
    }
}
