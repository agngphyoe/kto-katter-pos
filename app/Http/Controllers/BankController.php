<?php

namespace App\Http\Controllers;

use App\Actions\HandleFilterQuery;
use App\Actions\HandlePagination;
use App\Http\Requests\CashBook\Bank\StoreRequest;
use App\Http\Requests\CashBook\Bank\UpdateRequest;
use App\Models\Bank;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class BankController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $total_count    = Bank::count();

        if ($request->ajax()) {

            $query        = Bank::query();

            $keyword    = $request->search;
            $start_date = $request->start_date;
            $end_date   = $request->end_date;

            $banks = (new HandleFilterQuery(keyword: $keyword, start_date: $start_date, end_date: $end_date))->executeBankFilter(query: $query)->paginate(10);

            $html = View::make('cashbook.bank.search', compact('banks'))->render();

            return response()->json([
                'success' => true,
                'html' => $html,
                'pagination' => (new HandlePagination(data: $banks))->pagination()
            ]);
        }

        $banks          = Bank::orderByDesc('id')->paginate(10);

        return view('cashbook.bank.index', compact('banks', 'total_count'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('cashbook.bank.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRequest $request)
    {
        $bank = Bank::create($request->validated());

        if ($bank) {
            return redirect()->route('bank')->with('success', 'Success! Bank Created');
        }

        return back()->with('error', 'Failed! Bank can\'t Created');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Bank  $bank
     * @return \Illuminate\Http\Response
     */
    public function show(Bank $bank)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Bank  $bank
     * @return \Illuminate\Http\Response
     */
    public function edit(Bank $bank)
    {
        return view('cashbook.bank.edit', compact('bank'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Bank  $bank
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRequest $request, Bank $bank)
    {
        $updated = $bank->update($request->validated());

        if ($updated) {
            return redirect()->route('bank')->with('success', 'Success! Bank Updated');
        }

        return back()->withErrors($request->validator)->withInput()->with('failed', 'Failed! Bank not updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Bank  $bank
     * @return \Illuminate\Http\Response
     */
    public function destroy(Bank $bank)
    {
        $bank = $bank->delete();

        if ($bank) {

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
