<?php

namespace App\Http\Controllers;

use App\Actions\HandleFilterQuery;
use App\Actions\HandlePagination;
use App\Http\Requests\Design\StoreDesignRequest;
use App\Http\Requests\Design\UpdateDesignRequest;
use App\Models\Design;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Str;

class DesignController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $total_count    = Design::count();

        if ($request->ajax()) {

            $designQuery        = Design::query();
            $total_count        = $designQuery->count();

            $keyword    = $request->search;
            $start_date = $request->start_date;
            $end_date   = $request->end_date;

            $query = (new HandleFilterQuery(keyword: $keyword, start_date: $start_date, end_date: $end_date))->executeKeyDataForTypeDesignFilter(query: $designQuery);

            $search_count = $query->count();
            $designs = $query->paginate(10);

            $html = View::make('design.search', compact('designs'))->render();

            return response()->json([
                'success' => true,
                'html' => $html,
                'total_count' => $total_count,
                'search_count' => $search_count,
                'pagination' => (new HandlePagination(data: $designs))->pagination()
            ]);
        }

        $designs       = Design::orderByDesc('id')->paginate(10);

        return view('design.index', compact('designs', 'total_count'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('design.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreDesignRequest $request)
    {
        $request['slug'] = customSlug($request->name);
        $request['created_by'] = auth()->user()->id;

        $design = Design::create($request->all());

        if ($request->ajax()) {
            if ($design) {
                $designs = Design::orderByDesc('id')->get();
                $html = View::make('design.product-design-select', compact('designs'))->render();
                return response()->json([
                    'success' => true,
                    'message' => 'The Design created successfully.',
                    'status' => 200,
                    'html'  => $html,
                ], 200);
            }
        }

        if ($design) {

            return redirect('design')->with('success', 'Success! Design Created');
        }

        return back()->with('error', 'Failed! Design can\'t Created');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Design  $design
     * @return \Illuminate\Http\Response
     */
    public function show(Design $design)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Design  $design
     * @return \Illuminate\Http\Response
     */
    public function edit(Design $design)
    {
        return view('design.edit', compact('design'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Design  $design
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateDesignRequest $request, Design $design)
    {
        $design->update($request->all());

        if ($design) {

            return redirect('design')->with('success', 'Success! Design Updated');
        }

        return back()->with('failed', 'Failed! Design not updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Design  $design
     * @return \Illuminate\Http\Response
     */
    public function destroy(Design $design)
    {
        $design = $design->delete();
        if ($design) {

            return response()->json([
                'message' => 'The record has been deleted successfully.',
                'status' => 200,
            ], 200);
        } else {
            return response()->json([
                'error' => 'This record can\'t delete!',
                'status' => 500,
            ], 500);
        }
    }
}
