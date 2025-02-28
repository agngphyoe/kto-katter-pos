<?php

namespace App\Http\Controllers\CashBook;

use App\Actions\HandleFilterQuery;
use App\Actions\HandlePagination;
use App\Http\Controllers\Controller;
use App\Http\Requests\CashBook\BusinessType\StoreBusinessTypeRequest;
use App\Http\Requests\CashBook\BusinessType\UpdateBusinessTypeRequest;
use App\Models\BusinessType;
use Illuminate\Support\Facades\View;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BusinessTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $total_count    = BusinessType::count();

        if ($request->ajax()) {

            $query = BusinessType::query();

            $keyword = $request->search;

            $business_types = (new HandleFilterQuery(keyword: $keyword))->executebusinessTypeFilter(query: $query)->paginate(10);

            $html = View::make('cashbook.business_type.search', compact('business_types'))->render();

            return response()->json([
                'success' => true,
                'html' => $html,
                'pagination' => (new HandlePagination(data: $business_types))->pagination()
            ]);
        }

        $business_types = BusinessType::orderByDesc('id')->paginate(10);

        return view('cashbook.business_type.index', compact('business_types', 'total_count'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('cashbook.business_type.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreBusinessTypeRequest $request)
    {
        $request['slug'] = Str::slug($request->name);

        $business = BusinessType::create($request->all());

        if ($business) {

            return redirect()->route('business-type-list')->with('success', 'Success! Business Type Created');
        }

        return back()->with('error', 'Failed! Business can\'t Created');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(BusinessType $businessType)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(BusinessType $businessType)
    {
        return view('cashbook.business_type.edit', compact('businessType'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateBusinessTypeRequest $request, BusinessType $businessType)
    {
        $businessType->update($request->all());

        if ($businessType) {

            return redirect()->route('business-type-list')->with('success', 'Success! Business Type Updated');
        }

        return back()->with('failed', 'Failed! Business Type not updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(BusinessType $businessType)
    {
        $businessType = $businessType->delete();

        if ($businessType) {

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

    public function selectOptions()
    {
        $businessTypes = BusinessType::all();
        $html = View::make('cashbook.business_type.cashbook-business-select', compact('businessTypes'))->render();
        return response()->json([
            'message' => 'Successfully Fetched!',
            'status' => 200,
            'html'  => $html,
        ], 200);
    }
}