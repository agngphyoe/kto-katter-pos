<?php

namespace App\Http\Controllers;

use App\Models\Location;
use Illuminate\Http\Request;
use App\Actions\HandleFilterQuery;
use App\Actions\HandlePagination;
use App\Models\Permission;
use App\Models\LocationType;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LocationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {

            $locationQuery = Location::query();
            $total_count = $locationQuery->count();

            $keyword    = $request->search;
            $start_date = $request->start_date;
            $end_date   = $request->end_date;

            $query = (new HandleFilterQuery(keyword: $keyword, start_date: $start_date, end_date: $end_date))->executeLocationFilter(query: $locationQuery);

            $locations = $query->paginate(10);
            $search_count = $query->count();

            $html = View::make('location.search', compact('locations'))->render();

            return response()->json([
                'success' => true,
                'html' => $html,
                'total_count' => $total_count,
                'search_count' => $search_count,
                'pagination' => (new HandlePagination(data: $locations))->pagination()
            ]);
        }

        $query = Location::orderByDesc('id');

        $locations = $query->paginate(10);
        $total_count = $query->count();

        return view('location.index', compact('locations', 'total_count'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $location_types = LocationType::all();
        return view('location.create', compact('location_types'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        DB::beginTransaction();
        try {
            $location = new Location;
            $location->location_name = $request->location_name;
            $location->address = $request->location_address;
            $location->location_type_id = $request->location_type_id;
            $location->created_by  = Auth::user()->id;
            $location->save();

            $type = LocationType::where('id', $request->location_type_id)->first();
            if ($type) {
                $type->location_counts = $type->location_counts + 1;
                $type->save();
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            
            return back()->with('failed', 'Failed! Location cannot Created');
        }
        
        return redirect()->route('location')->with('success', 'Success! Location Created');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Location  $location
     * @return \Illuminate\Http\Response
     */
    public function show(Location $location)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Location  $location
     * @return \Illuminate\Http\Response
     */
    public function edit(Location $location)
    {
        $location_types = LocationType::all();
        return view('location.edit', compact('location', 'location_types'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Location  $location
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Location $location)
    {
        $loginUserId = Auth::user()->id;
        DB::beginTransaction();
        try {
            if ($location->locationType->id !== (int)$request->location_type_id) {
                $reduceCount = LocationType::where('id', $location->location_type_id)->first();
                if ($reduceCount) {
                    $reduceCount->location_counts = $reduceCount->location_counts - 1;
                    $reduceCount->update();
                }

                $type = LocationType::where('id', $request->location_type_id)->first();
                if ($type) {
                    $type->location_counts = $type->location_counts + 1;
                    $type->update();
                }
            }

            $location->location_name = $request->location_name;
            $location->address = $request->location_address;
            $location->location_type_id = $request->location_type_id;
            $location->created_by  = $loginUserId;
            $location->update();

            DB::commit();
            // all good
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('failed', 'Failed! Location cannot Created');
        }
        
        return redirect()->route('location')->with('success', 'Success! Location Created');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Location  $location
     * @return \Illuminate\Http\Response
     */
    public function destroy(Location $location)
    {
        $location = $location->delete();
        if ($location) {

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
