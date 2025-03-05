<?php

namespace App\Http\Controllers\CashBook;

use App\Actions\HandleFilterQuery;
use App\Actions\HandlePagination;
use App\Http\Controllers\Controller;
use App\Http\Requests\CashBook\AccountType\StoreAccountTypeRequest;
use App\Http\Requests\CashBook\AccountType\UpdateAccountTypeRequest;
use App\Models\AccountType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Cache;

class AccountTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {

            $query = AccountType::query();

            $keyword = $request->search;

            $account_types = (new HandleFilterQuery(keyword: $keyword))->accountTypeFilter(query: $query)->paginate(10);

            $html = View::make('cashbook.account_type.search', compact('account_types'))->render();

            return response()->json([
                'success' => true,
                'html' => $html,
                'pagination' => (new HandlePagination(data: $account_types))->pagination()
            ]);
        }

        $page = request()->get('page', 1); // Get the current page or default to 1

        $account_types = Cache::rememberForever("account_types_page_{$page}", function () {
            return AccountType::orderByDesc('id')->paginate(10);
        });

        return view('cashbook.account_type.index', compact('account_types'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('cashbook.account_type.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreAccountTypeRequest $request)
    {
        $accountType = AccountType::create($request->all());

        if ($request->ajax()) {
            if ($accountType) {
                $accountTypes = AccountType::all();
                $html = View::make('cashbook.account_type.cashbook-account-type-select', compact('accountTypes'))->render();
                return response()->json([
                    'message' => 'The Account created successfully.',
                    'status' => 200,
                    'html'  => $html,
                ], 200);
            }
        }

        if ($accountType) {

            return redirect()->route('account-type-list')->with('success', 'Success! Account Created');
        }

        return back()->with('error', 'Failed! Account can\'t Created');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(AccountType $accountType)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(AccountType $accountType)
    {
        return view('cashbook.account_type.edit', compact('accountType'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateAccountTypeRequest $request, AccountType $accountType)
    {
        $accountType->update($request->all());

        if ($accountType) {

            return redirect()->route('account-type-list')->with('success', 'Success! Account Type Updated');
        }

        return back()->with('failed', 'Failed! Account Type not updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(AccountType $accountType)
    {
        $accountType = $accountType->delete();

        if ($accountType) {

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
        $accountTypes = AccountType::all();
        $html = View::make('cashbook.account_type.cashbook-account-type-select', compact('accountTypes'))->render();
        return response()->json([
            'message' => 'Successfully Fetched!',
            'status' => 200,
            'html'  => $html,
        ], 200);
    }
}