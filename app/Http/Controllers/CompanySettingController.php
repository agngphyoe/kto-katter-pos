<?php

namespace App\Http\Controllers;

use App\Actions\HandleFilterQuery;
use App\Actions\HandlePagination;
use App\Http\Requests\CompanySettings\StoreRequest;
use App\Http\Requests\CompanySettings\UpdateRequest;
use App\Models\CompanySetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class CompanySettingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {

            $query        = CompanySetting::query();

            $keyword    = $request->search;
            $start_date = $request->start_date;
            $end_date   = $request->end_date;

            $company_settings = (new HandleFilterQuery(keyword: $keyword, start_date: $start_date, end_date: $end_date))->executeKeyDataFilter(query: $query)->paginate(10);

            $html = View::make('company-settings.search', compact('company_settings'))->render();

            return response()->json([
                'success' => true,
                'html' => $html,
                'pagination' => (new HandlePagination(data: $company_settings))->pagination()
            ]);
        }

        $company_settings      = CompanySetting::orderByDesc('id')->paginate(10);

        $total_count    = CompanySetting::count();

        return view('company-settings.index', compact('company_settings', 'total_count'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('company-settings.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRequest $request)
    {
        $company = CompanySetting::create($request->all());

        if ($company) {

            return redirect()->route('company-settings-list')->with('success', 'Success! Company Settings Created');
        }

        return back()->with('error', 'Failed! Company Settings can\'t Created');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\CompanySetting  $companySetting
     * @return \Illuminate\Http\Response
     */
    public function show(CompanySetting $companySetting)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\CompanySetting  $companySetting
     * @return \Illuminate\Http\Response
     */
    public function edit(CompanySetting $company_settings)
    {
        return view('company-settings.edit', compact('company_settings'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\CompanySetting  $companySetting
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRequest $request, CompanySetting $company_settings)
    {
        $company = $company_settings->update($request->all());

        if ($company) {

            return redirect()->route('company-settings-list')->with('success', 'Success! Company Created');
        }

        return back()->with('error', 'Failed! Company Setting can\'t Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CompanySetting  $companySetting
     * @return \Illuminate\Http\Response
     */
    public function destroy(CompanySetting $company_settings)
    {
        $company_settings->delete();

        return response()->json([
            'message' => 'The record has been deleted successfully.',
            'status' => 200,
        ], 200);
    }
}
