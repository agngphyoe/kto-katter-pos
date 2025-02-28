<?php

namespace App\Http\Controllers;

use App\Actions\HandleFilterQuery;
use App\Actions\HandlePagination;
use App\Http\Requests\Brand\StoreBrandRequest;
use App\Http\Requests\Brand\UpdateBrandRequest;
use App\Models\Brand;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Str;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $total_count    = Brand::count();

        if ($request->ajax()) {

            $brandQuery        = Brand::query();
            $total_count       = $brandQuery->count();

            $keyword    = $request->search;
            $start_date = $request->start_date;
            $end_date   = $request->end_date;

            $query = (new HandleFilterQuery(keyword: $keyword, start_date: $start_date, end_date: $end_date))->executeKeyDataForProductFilter(query: $brandQuery);

            $search_count = $query->count();
            $brands = $query->paginate(10);

            $html = View::make('brand.search', compact('brands'))->render();

            return response()->json([
                'success' => true,
                'html' => $html,
                'total_count' => $total_count,
                'search_count' => $search_count,
                'pagination' => (new HandlePagination(data: $brands))->pagination()
            ]);
        }

        $brands  = Brand::orderByDesc('id')->paginate(10);

        return view('brand.index', compact('brands', 'total_count'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::where('name', '!=', 'FOC')->get();
        return view('brand.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreBrandRequest $request)
    {
        $request['slug'] = customSlug($request->name);
        $request['created_by'] = auth()->user()->id;

        $brand = Brand::create($request->all());
        if ($request->ajax()) {
            if ($brand) {
                $category_id = $request->input('category_id');
                $category = Category::find($category_id);
                $categories = Category::all();
                $brands = $category->brands;
                $html = View::make('brand.product-brand-select', compact('brands'))->render();
                $selected_category = View::make('product.selected-category', compact('categories', 'category_id'))->render();
                return response()->json([
                    'message' => 'The Brand created successfully.',
                    'status' => 200,
                    'html'  => $html,
                    'selected_category'  => $selected_category,
                ], 200);
            }
        }

        if ($brand) {

            return redirect()->route('brand')->with('success', 'Success! Brand Created');
        }

        return back()->with('error', 'Failed! Brand can\'t Created');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function show(Brand $brand)
    {
        return view('brand.detail', compact('brand'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function edit(Brand $brand)
    {
        $categories = Category::all();
        return view('brand.edit', compact('brand', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateBrandRequest $request, Brand $brand)
    {
        $brand->update($request->all());

        if ($brand) {

            return redirect('brand')->with('success', 'Success! Brand Updated');
        }

        return back()->with('failed', 'Failed! Brand not updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function destroy(Brand $brand)
    {
        try {
            $brand->delete();

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
}
