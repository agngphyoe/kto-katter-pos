<?php

namespace App\Http\Controllers;

use App\Actions\HandleFilterQuery;
use App\Actions\HandlePagination;
use App\Http\Requests\Category\StoreCategoryRequest;
use App\Http\Requests\Category\UpdateCategoryRequest;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $total_count    = Category::count();

        if ($request->ajax()) {

            $categoryQuery = Category::query();
            $total_count  = $categoryQuery->count();

            $keyword    = $request->search;
            $start_date = $request->start_date;
            $end_date   = $request->end_date;

            $query = (new HandleFilterQuery(keyword: $keyword, start_date: $start_date, end_date: $end_date))->executeKeyDataForProductFilter(query: $categoryQuery);

            $search_count = $query->count();
            $categories = $query->paginate(10);

            $html = View::make('category.search', compact('categories'))->render();

            return response()->json([
                'success' => true,
                'html' => $html,
                'total_count' => $total_count,
                'search_count' => $search_count,
                'pagination' => (new HandlePagination(data: $categories))->pagination()
            ]);
        }

        $categories = Category::orderBy('id', 'desc')->paginate(10);

        return view('category.index', compact('categories', 'total_count'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('category.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCategoryRequest $request)
    {
        $request['slug'] = customSlug($request->name);

        $category = Category::create($request->all());
        if ($request->ajax()) {
            if ($category) {
                $categories = Category::orderByDesc('id')->get();
                $html = View::make('category.product-category-select', compact('categories'))->render();
                return response()->json([
                    'message' => 'The Category created successfully.',
                    'status' => 200,
                    'html'  => $html,
                ], 200);
            }
        }
        if ($category) {

            return redirect()->route('category')->with('success', 'Success! Category Created');
        }

        return back()->with('error', 'Failed! Category can\'t Created');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        return view('category.detail', compact('category'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        return view('category.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCategoryRequest $request, Category $category)
    {
        $category->update($request->all());

        if ($category) {

            return redirect('category')->with('success', 'Success! Category Updated');
        }

        return back()->with('failed', 'Failed! Category not updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        try {
            $category->delete();
    
            return response()->json([
                'message' => 'The record has been deleted successfully.',
                'status' => 200,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage(),
                'message' => $e->getMessage(),
                'status' => 500,
            ], 500);
        }
    }
}
