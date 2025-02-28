<?php

namespace App\Http\Controllers;

use App\Models\LocationType;
use Illuminate\Http\Request;
use App\Actions\HandleFilterQuery;
use App\Actions\HandlePagination;
use App\Models\Permission;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LocationTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query        = LocationType::query();

            $keyword    = $request->search;
            $start_date = $request->start_date;
            $end_date   = $request->end_date;
            $page       = $request->page;

            $query = (new HandleFilterQuery(keyword: $keyword, start_date: $start_date, end_date: $end_date))->executeLocationTypeFilter(query: $query);

            $locationTypes = $query->paginate(10);

            $html = View::make('location-type.search', compact('locationTypes'))->render();

            return response()->json([
                'success' => true,
                'html' => $html,
                'pagination' => (new HandlePagination(data: $locationTypes))->pagination()
            ]);
        }

        $locationTypes = LocationType::orderByDesc('id')->paginate(10);

        $total_count    = LocationType::count();

        $permission_count   = Permission::count();

        $total_count    = LocationType::count();
        $permission_count   = LocationType::count();

        return view('location-type.index', compact('locationTypes', 'permission_count', 'total_count'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('location-type.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $loginUserId = Auth::user()->id;
        $permissions = [];

        DB::beginTransaction();
        try {
            $locationType = new LocationType;
            $locationType->location_type_name = $request->location_type_name;
            $locationType->created_by = $loginUserId;
            $locationType->sale_type  = $request->sale_type;
            $locationType->save();

            if ($locationType && $request->permissions) {
                $permissions = $request->permissions;
                foreach ($permissions as $permission) {
                    DB::table('location_type_stock_permission')->insert([
                        'location_type_id' => $locationType->id,
                        'stock_permission_id' => $permission
                    ]);
                }
            }

            DB::commit();
            // all good
            return redirect()->route('location-type')->with('success', 'Success! Location Type Created');

        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('failed', 'Failed! Location Type cannot Created');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\LocationType  $locationType
     * @return \Illuminate\Http\Response
     */
    public function show(LocationType $locationType)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\LocationType  $locationType
     * @return \Illuminate\Http\Response
     */
    public function edit(LocationType $locationType)
    {
        return view('location-type.edit', compact('locationType'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\LocationType  $locationType
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, LocationType $locationType)
    {
        $loginUserId = Auth::user()->id;

        DB::beginTransaction();
        try {
            $locationType->location_type_name = $request->location_type_name;
            $locationType->created_by = $loginUserId;
            $locationType->sale_type  = $request->sale_type;
            $locationType->update();

            DB::commit();
            // all good
            return redirect()->route('location-type')->with('success', 'Success! Location Type Updated!');

        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('failed', 'Failed! Location Type cannot Updated!');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\LocationType  $locationType
     * @return \Illuminate\Http\Response
     */
    public function destroy(LocationType $locationType)
    {
        //
    }
}
