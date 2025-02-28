<?php

namespace App\Http\Controllers\CashBook;

use App\Constants\TransactionType;
use App\Http\Controllers\Controller;
use App\Models\AccountType;
use App\Models\BusinessType;
use App\Models\Cashbook;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class COAController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $business_types = BusinessType::all();

        $account_types = AccountType::all();
        $data = [];

        foreach ($account_types as $account_type) {

            foreach ($account_type->accounts as $account) {

                foreach ($business_types as $business_type) {

                    $data[$account_type->name][$account->name][$business_type->name] = [
                        'cash_in' => $this->getSumIncomeAndExpense($account, $business_type, TransactionType::INCOME),
                        'cash_out' => $this->getSumIncomeAndExpense($account, $business_type, TransactionType::EXPENSE),
                    ];
                }
            }
        }
        return view('cashbook.COA.index', compact('business_types', 'account_types', 'data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('cashbook.COA.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function getSumIncomeAndExpense($account, $business_type, $transaction_type)
    {
        return Cashbook::whereBusinessTypeId($business_type->id)->whereAccountId($account->id)->whereTransactionType($transaction_type)->sum('amount');
    }

}
