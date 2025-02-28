<?php

namespace App\Http\Controllers;

use App\Actions\HandleFilterQuery;
use App\Actions\HandlePagination;
use App\Actions\ImageStoreInPublic;
use App\Actions\StoreActivityLog;
use App\Constants\PrefixCodeID;
use App\Http\Requests\Staff\StoreRequest;
use App\Http\Requests\Staff\UpdateRequest;
use App\Models\Division;
use App\Models\Position;
use App\Models\Staff;
use App\Models\Township;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\View;


class StaffController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $total_count    = Staff::count();

        if ($request->ajax()) {

            $query        = Staff::query();

            $keyword    = $request->search;
            $start_date = $request->start_date;
            $end_date   = $request->end_date;

            $staffs = (new HandleFilterQuery(keyword: $keyword, start_date: $start_date, end_date: $end_date))->executeKeyDataForStaffFilter(query: $query)->paginate(10);

            $html = View::make('staff.search', compact('staffs'))->render();

            return response()->json([
                'success' => true,
                'html' => $html,
                'pagination' => (new HandlePagination(data: $staffs))->pagination()
            ]);
        }

        $staffs          = Staff::orderByDesc('id')->paginate(10);

        return view('staff.index', compact('staffs', 'total_count'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $positions = Position::all();
        $divisions = Division::all();
        $townships = Township::all();
        return view('staff.create', compact('positions', 'divisions', 'townships'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRequest $request)
    {
        $image = $request->image ? (new ImageStoreInPublic())->storePublic(destination: 'staffs/image', image: $request->image) : null;
        $exist_record = Staff::latest()->first();

        $request['password'] = Hash::make($request->password);
        $request['user_number'] = getAutoGenerateID(PrefixCodeID::STAFF, $exist_record?->user_number);

        $request = $request->all();
        $request['image'] = $image;
        $request['company_id'] = auth()->user()->company?->id;
        $request['created_by'] = auth()->user()->id;

        $staff = Staff::create($request);

        if ($staff) {

            StoreActivityLog::store($staff, title: 'Staff Created', activity: 'Create');

            return redirect()->route('staff')->with('success', 'Success! Staff created');
        }

        return redirect()->route('staff-create')->with('error', 'Failed! Staff can not Created');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Staff  $staff
     * @return \Illuminate\Http\Response
     */
    public function show(Staff $staff)
    {
        return view('staff.detail');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Staff  $staff
     * @return \Illuminate\Http\Response
     */
    public function edit(Staff $staff)
    {
        $positions = Position::all();
        $divisions = Division::all();
        $townships = Township::all();
        return view('staff.edit', compact('staff', 'positions', 'divisions', 'townships'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Staff  $staff
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRequest $request, Staff $staff)
    {
        $image  = $staff->image;

        if ($request->hasFile('image')) {

            File::delete(public_path('staffs/image/' . $staff->image));

            $image = (new ImageStoreInPublic())->storePublic(destination: 'staffs/image', image: $request->image);
        }

        $request['password'] = $request->password ? Hash::make($request->password) : $staff->password;
        $request = $request->all();
        $request['image'] = $image;

        $staff->update($request);

        if ($staff) {

            StoreActivityLog::store($staff, title: 'Staff Updated', activity: 'Update');
            
            return redirect()->route('staff')->with('success', 'Success! Staff updated');
        }

        return redirect()->back()->with('success', 'Success! Staff can not Update');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Staff  $staff
     * @return \Illuminate\Http\Response
     */
    public function destroy(Staff $staff)
    {
        $staff = $staff->delete();

        if ($staff) {

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
