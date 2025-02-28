<?php

namespace App\Http\Controllers\CashBook;

use App\Actions\HandleFilterQuery;
use App\Actions\HandlePagination;
use App\Http\Controllers\Controller;
use App\Http\Requests\CashBook\AccountType\StoreAccountRequest;
use App\Http\Requests\CashBook\AccountType\UpdateAccountRequest;
use App\Models\Account;
use App\Models\AccountType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class AccountController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {

            $accountQuery = Account::query();
            $total_count = $accountQuery->count();
            $keyword = $request->search;

            $query = (new HandleFilterQuery(keyword: $keyword))->executeAccountFilter(query: $accountQuery);
            $accounts = $query->paginate(10);
            $search_count = $query->count();

            $html = View::make('cashbook.account.search', compact('accounts'))->render();

            return response()->json([
                'success' => true,
                'html' => $html,
                'total_count' => $total_count,
                'search_count' => $search_count,
                'pagination' => (new HandlePagination(data: $accounts))->pagination()
            ]);
        }

        $accounts = Account::orderByDesc('id')->paginate(10);

        return view('cashbook.account.index', compact('accounts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('cashbook.account.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreAccountRequest $request)
    {
        $account = Account::create($request->all());

        if ($request->ajax()) {
            if ($account) {
                $accounts = Account::with('accountType')->all();
                $html = View::make('cashbook.account.cashbook-account-select', compact('accounts'))->render();
                return response()->json([
                    'message' => 'The Account created successfully.',
                    'status' => 200,
                    'html'  => $html,
                ], 200);
            }
        }

        if ($account) {

            return redirect()->route('account-list')->with('success', 'Success! Account Created');
        }

        return back()->with('error', 'Failed! Account can\'t Created');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return view('cashbook.account.detail');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function edit(Account $account)
    {
        $accountTypes = AccountType::all();
        return view('cashbook.account.edit', compact('account', 'accountTypes'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateAccountRequest $request, Account $account)
    {
        $account->update($request->all());

        if ($account) {

            return redirect()->route('account-list')->with('success', 'Success! Account Updated');
        }

        return back()->with('failed', 'Failed! Account not updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function destroy(Account $account)
    {
        $account = $account->delete();

        if ($account) {

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
        $accounts = Account::with('accountType')->get();
        $html = View::make('cashbook.account.cashbook-account-select', compact('accounts'))->render();
        return response()->json([
            'message' => 'Successfully Fetched!',
            'status' => 200,
            'html'  => $html,
        ], 200);
    }

    public function getAccountFromSelectedAccountType(Request $request)
    {
        $accounts = Account::where('account_type_id', $request->account_type_id)->get();
        $html = View::make('cashbook.account.account-from-selected-account-type', compact('accounts'))->render();
        return response()->json([
            'message' => 'Successfully Fetched!',
            'status' => 200,
            'html'  => $html,
        ], 200);
    }
}