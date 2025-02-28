<?php

namespace App\Http\Controllers;

use App\Actions\HandleFilterQuery;
use App\Actions\HandlePagination;
use App\Actions\StoreActivityLog;
use App\Http\Requests\Position\UpdateRequest;
use App\Http\Requests\Position\StoreRequest;
use App\Models\Position;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Str;


class PositionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $total_count    = Position::count();

        if ($request->ajax()) {

            $query        = Position::query();

            $keyword    = $request->search;
            $start_date = $request->start_date;
            $end_date   = $request->end_date;

            $positions = (new HandleFilterQuery(keyword: $keyword, start_date: $start_date, end_date: $end_date))->executeKeyDataForProductFilter(query: $query)->paginate(10);

            $html = View::make('position.search', compact('positions'))->render();

            return response()->json([
                'success' => true,
                'html' => $html,
                'pagination' => (new HandlePagination(data: $positions))->pagination()
            ]);
        }

        $positions  = Position::orderByDesc('id')->paginate(10);

        return view('position.index', compact('positions', 'total_count'));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('position.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRequest $request)
    {
        $request['slug'] = Str::slug($request->name);
        $request['created_by'] = Auth::user()->id;

        $position = Position::create($request->all());

        if ($position) {

            return redirect()->route('position')->with('success', 'Success! Position Created');
        }

        return back()->with('error', 'Failed! Position can\'t Created');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Position  $position
     * @return \Illuminate\Http\Response
     */
    public function show(Position $position)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Position  $position
     * @return \Illuminate\Http\Response
     */
    public function edit(Position $position)
    {
        return view('position.edit', compact('position'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Position  $position
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRequest $request, Position $position)
    {
        $position->update($request->all());

        if ($position) {
            StoreActivityLog::store($position, title: 'Position Updated', activity: 'Update');
            return redirect()->route('position');
        }

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Position  $position
     * @return \Illuminate\Http\Response
     */
    public function destroy(Position $position)
    {
        $position->delete();

        if ($position) {

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
