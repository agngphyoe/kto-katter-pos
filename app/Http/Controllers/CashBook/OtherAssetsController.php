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

class OtherAssetsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = Cashbook::others();

        if ($request->ajax()) {
            $keyword = $request->search;
            $start_date = $request->start_date;
            $end_date = $request->end_date;

            $others = (new HandleFilterQuery(keyword: $keyword, start_date: $start_date, end_date: $end_date))
                ->executeCOAFilter(query: $query)
                ->paginate(10);

            $html = View::make('cashbook.others.search', compact('others'))->render();

            return response()->json([
                'success' => true,
                'html' => $html,
                'pagination' => (new HandlePagination(data: $others))->pagination(),
            ]);
        }

        $total_count = $query->count();

        $others = $query->orderByDesc('id')->paginate(10);

        $total_income = Cashbook::others()->where('transaction_type', 'income')->sum('amount');

        $total_expense = Cashbook::others()->where('transaction_type', 'expense')->sum('amount');

        return view('cashbook.others.index', compact('others', 'total_count', 'total_income', 'total_expense'));
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

        $account_types = AccountType::whereNotIn('name', ['Income', 'Expense'])->pluck('id')->toArray();

        $accounts = Account::whereIn('account_type_id', $account_types)->get();

        return view('cashbook.others.create', compact('banks', 'business_types', 'accounts'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreIncomeExpenseRequest $request)
    {
        $transaction = Cashbook::create($request->all());

        if ($transaction) {

            return redirect()->route('others-list')->with('success', 'Success! Transaction Created');
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
    public function edit(Cashbook $other)
    {
        $banks = Bank::all();

        $business_types = BusinessType::all();

        $account_types = AccountType::whereNotIn('name', ['Income', 'Expense'])->pluck('id')->toArray();

        $accounts = Account::whereIn('account_type_id', $account_types)->get();

        return view('cashbook.others.edit', compact('other', 'account_types', 'accounts', 'business_types', 'banks'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateIncomeExpenseRequest $request, Cashbook $other)
    {
        $other->update($request->all());

        if ($other) {

            return redirect()->route('others-list')->with('success', 'Success! Transaction Updated');
        }

        return back()->with('failed', 'Failed! Transaction not updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Cashbook $other)
    {
        $other = $other->delete();

        if ($other) {

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
