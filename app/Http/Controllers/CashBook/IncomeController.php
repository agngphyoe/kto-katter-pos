<?php

namespace App\Http\Controllers\CashBook;

use App\Actions\HandleFilterQuery;
use App\Actions\HandlePagination;
use App\Http\Controllers\Controller;
use App\Http\Requests\CashBook\IncomeExpense\StoreIncomeExpenseRequest;
use App\Http\Requests\CashBook\IncomeExpense\UpdateIncomeExpenseRequest;
use App\Models\Account;
use App\Models\AccountType;
use App\Models\Bank;
use App\Models\BusinessType;
use App\Models\Cashbook;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class IncomeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = Cashbook::income();

        if ($request->ajax()) {

            $keyword = $request->search;
            $start_date = $request->start_date;
            $end_date = $request->end_date;

            $incomes = (new HandleFilterQuery(keyword: $keyword, start_date: $start_date, end_date: $end_date))
                ->executeCOAFilter(query: $query)
                ->paginate(10);

            $html = View::make('cashbook.income.search', compact('incomes'))->render();

            return response()->json([
                'success' => true,
                'html' => $html,
                'pagination' => (new HandlePagination(data: $incomes))->pagination()
            ]);
        }

        $total_count = $query->count();

        $total_income = $query->sum('amount');

        $incomes = $query->orderByDesc('id')->paginate(10);

        return view('cashbook.income.index', compact('incomes', 'total_count', 'total_income'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $banks = Bank::all();

        $business_types = BusinessType::all();

        // $accounts = Account::all();

        $accounts = AccountType::whereName('Income')->first()->accounts ?? [];

        return view('cashbook.income.create', compact('business_types', 'accounts', 'banks'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreIncomeExpenseRequest $request)
    {
        $income = Cashbook::create($request->all());

        if ($income) {

            return redirect()->route('income-list')->with('success', 'Success! Transaction Created');
        }

        return back()->with('error', 'Failed! Transaction can\'t Created');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Cashbook $income)
    {
        $banks = Bank::all();

        // $accounts = Account::all();
        $accounts = AccountType::whereName('Income')->first()->accounts ?? [];

        $businessTypes = BusinessType::all();

        return view('cashbook.income.edit', compact('income', 'accounts', 'businessTypes', 'banks'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateIncomeExpenseRequest $request, Cashbook $income)
    {
        $income->update($request->all());

        if ($income) {

            return redirect()->route('income-list')->with('success', 'Success! Transaction Updated');
        }

        return back()->with('failed', 'Failed! Transaction not updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Cashbook $income)
    {
        $income = $income->delete();

        if ($income) {

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
