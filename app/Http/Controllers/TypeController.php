<?php

namespace App\Http\Controllers;

use App\Actions\HandleFilterQuery;
use App\Actions\HandlePagination;
use App\Http\Requests\Type\StoreTypeRequest;
use App\Http\Requests\Type\UpdateTypeRequest;
use App\Models\Type;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Str;

class TypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $total_count    = Type::count();

        if ($request->ajax()) {

            $typeQuery        = Type::query();
            $total_count      = $typeQuery->count();

            $keyword    = $request->search;
            $start_date = $request->start_date;
            $end_date   = $request->end_date;

            $query = (new HandleFilterQuery(keyword: $keyword, start_date: $start_date, end_date: $end_date))->executeKeyDataForTypeDesignFilter(query: $typeQuery);

            $search_count = $query->count();
            $types = $query->paginate(10);

            $html = View::make('type.search', compact('types'))->render();

            return response()->json([
                'success' => true,
                'html' => $html,
                'total_count' => $total_count,
                'search_count' => $search_count,
                'pagination' => (new HandlePagination(data: $types))->pagination()
            ]);
        }

        $types       = Type::orderByDesc('id')->paginate(10);

        return view('type.index', compact('types', 'total_count'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('type.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTypeRequest $request)
    {
        $request['slug'] = customSlug($request->name);
        $request['created_by'] = auth()->user()->id;

        $type = Type::create($request->all());

        if ($request->ajax()) {
            if ($type) {
                $types = Type::orderByDesc('id')->get();
                $html = View::make('type.product-type-select', compact('types'))->render();

                return response()->json([
                    'message' => 'The Design created successfully.',
                    'status' => 200,
                    'html'  => $html,
                ], 200);
            }
        }

        if ($type) {

            return redirect()->route('type')->with('success', 'Success! Type Created');
        }

        return back()->with('error', 'Failed! Type can\'t Created');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Type  $type
     * @return \Illuminate\Http\Response
     */
    public function show(Type $type)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Type  $type
     * @return \Illuminate\Http\Response
     */
    public function edit(Type $type)
    {
        return view('type.edit', compact('type'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Type  $type
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTypeRequest $request, Type $type)
    {
        $type->update($request->all());

        if ($type) {

            return redirect('type')->with('success', 'Success! Type Updated');
        }

        return back()->with('failed', 'Failed! Type not updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Type  $type
     * @return \Illuminate\Http\Response
     */
    public function destroy(Type $type)
    {
        $type = $type->delete();
        if ($type) {

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
