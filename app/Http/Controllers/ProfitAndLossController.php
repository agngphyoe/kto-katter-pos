<?php

namespace App\Http\Controllers;
use App\Models\PointOfSale;
use App\Models\PosReturn;
use App\Models\Purchase;
use App\Models\PurchaseReturn;
use App\Models\BusinessType;
use App\Models\Cashbook;
use App\Models\Account;
use App\Models\Product;
use App\Models\ProfitAndLoss;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use DB;
use Validator;

class ProfitAndLossController extends Controller
{
    public function index()
    {
        if (DB::table('pl_format')->count() == 0) {
            return redirect()->route('profit-and-loss-select-income-expense');
        } else {
            $pls = ProfitAndLoss::with('user')->latest()->paginate(10);
            return view('cashbook.pl.index', compact('pls'));
        }
    }

    public function details($id)
    {
        $pl = ProfitAndLoss::where('id', $id)->firstOrFail();
        return view('cashbook.pl.detail', compact('pl'));
    }

    public function chooseMonth()
    {
        return view('cashbook.pl.choose-month');
    }

    public function calculateData(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'start_date' => 'required|date_format:m/d/Y',
            'end_date' => 'required|date_format:m/d/Y',
        ]);

        $start_date = Carbon::createFromFormat('m/d/Y', $request->start_date)->format('Y-m-d');
        $end_date = Carbon::createFromFormat('m/d/Y', $request->end_date)->format('Y-m-d');
        $month = Carbon::createFromFormat('m/d/Y', $request->start_date)->format('Y-m');

        $sale = PointOfSale::whereBetween('order_date', [$start_date, $end_date])->sum('total_amount');
        $sale_return = PosReturn::whereBetween('return_date', [$start_date, $end_date])->sum('total_return_amount');
        $total_sales = $sale - $sale_return;

        $first_day_stocks = DB::table('monthly_stock')
                                ->where('month', $month)
                                ->where('date', function ($query) use ($month) {
                                    $query->selectRaw('MIN(date)')
                                        ->from('monthly_stock')
                                        ->where('month', $month);
                                })
                                ->get();

        $start_price = 0;
        foreach ($first_day_stocks as $stock) {
            $price = Product::where('id', $stock->product_id)->value('retail_price');
            $start_price += $price * $stock->quantity;
        }

        $last_day_stocks = DB::table('monthly_stock')
                            ->where('month', $month)
                            ->where('date', function ($query) use ($month) {
                                $query->selectRaw('MAX(date)')
                                    ->from('monthly_stock')
                                    ->where('month', $month);
                            })
                            ->get();

        $end_price = 0;
        foreach ($last_day_stocks as $stock) {
            $price = Product::where('id', $stock->product_id)->value('retail_price');
            $end_price += $price * $stock->quantity;
        }

        $purchase_amount = Purchase::whereBetween('action_date', [$start_date, $end_date])
            ->selectRaw('SUM(total_amount - discount_amount) as total_net_amount')
            ->value('total_net_amount');

        $purchase_return_amount = PurchaseReturn::whereBetween('return_date', [$start_date, $end_date])
                                                ->sum('return_amount');

        $total_cost_of_sales = ($purchase_amount + $start_price) - ($purchase_return_amount + $end_price);

        $gross_profit_on_sales = $total_sales - $total_cost_of_sales;

        $other_incomes = DB::table('pl_format')
                            ->where('type', 'other_incomes')
                            ->get();

        $incomes = collect();
        foreach ($other_incomes as $other_income) {
            $incomeData  = Cashbook::join('accounts', 'accounts.id', '=', 'cashbooks.account_id')
                                ->where('cashbooks.transaction_type', 'income')
                                ->where('accounts.name', $other_income->name)
                                ->whereBetween('cashbooks.issue_date', [$start_date, $end_date])
                                ->get();

            $incomes = $incomes->merge($incomeData);
        }

        $total_other_income = 0;
        foreach ($incomes as $income) {
            $total_other_income += $income->amount;
        }

        $total_gross_profit = $total_other_income + $gross_profit_on_sales;

        $other_expenses = DB::table('pl_format')
                            ->where('type', 'expenses')
                            ->get();

        $expenses = collect();
        foreach ($other_expenses as $expense) {
            $expenseData  = Cashbook::join('accounts', 'accounts.id', '=', 'cashbooks.account_id')
                                ->where('cashbooks.transaction_type', 'expense')
                                ->where('accounts.name', $expense->name)
                                ->whereBetween('cashbooks.issue_date', [$start_date, $end_date])
                                ->get();

            $expenses = $expenses->merge($expenseData);
        }

        $total_expenses = 0;
        foreach ($expenses as $expense) {
            $total_expenses += $expense->amount;
        }

        $net_profit_before_tax = $total_gross_profit - $total_expenses;

        return view('cashbook.pl.data', compact('sale', 'sale_return', 'total_sales', 'purchase_amount',
                                                'purchase_return_amount', 'start_price', 'end_price',
                                                'total_cost_of_sales', 'gross_profit_on_sales',
                                                'incomes','total_other_income', 'total_gross_profit',
                                                'expenses','total_expenses', 'net_profit_before_tax'));
    }

    public function selectIncomeExpense()
    {
        $incomeAccounts = Account::byAccountType('Income')->get();
        $expenseAccounts = Account::byAccountType('Expense')->get();

        $selectedOtherIncomes = DB::table('pl_format')->where('type', 'other_incomes')->pluck('name')->toArray();
        $selectedExpenses = DB::table('pl_format')->where('type', 'expenses')->pluck('name')->toArray();

        return view('cashbook.pl.select-income-expense', compact(
            'incomeAccounts',
            'expenseAccounts',
            'selectedOtherIncomes',
            'selectedExpenses'
        ));
    }

    public function storePLFormat(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'revenue_add' => 'required|array',
            'revenue_less' => 'required|array',
            'COGS_add' => 'required|array',
            'COGS_less' => 'required|array',
            'other_incomes' => 'nullable|array',
            'expenses' => 'nullable|array',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $dataMappings = [
            'revenue_add' => ['type' => 'revenue', 'status' => 'add', 'auto_match' => 'sale'],
            'revenue_less' => ['type' => 'revenue', 'status' => 'less', 'auto_match' => 'sale_return'],
            'COGS_add' => ['type' => 'cogs', 'status' => 'add', 'auto_match' => 'purchase'],
            'COGS_less' => ['type' => 'cogs', 'status' => 'less', 'auto_match' => 'purchase_return']
        ];

        $insertData = [];

        foreach ($dataMappings as $key => $config) {
            foreach ($request->$key as $name) {
                $insertData[] = [
                    'name' => $name,
                    'type' => $config['type'],
                    'status' => $config['status'],
                    'action_type' => ($name == $config['auto_match']) ? 'auto' : 'manual',
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }

        $otherIncomeAccounts = Account::whereIn('id', (array) $request->other_incomes)->pluck('name')->toArray();
        $expenseAccounts = Account::whereIn('id', (array) $request->expenses)->pluck('name')->toArray();

        foreach ($otherIncomeAccounts as $account_name) {
            $insertData[] = [
                'name' => $account_name,
                'type' => 'other_incomes',
                'status' => 'add',
                'action_type' => 'manual',
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        foreach ($expenseAccounts as $account_name) {
            $insertData[] = [
                'name' => $account_name,
                'type' => 'expenses',
                'status' => 'less',
                'action_type' => 'manual',
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        foreach ($insertData as $data) {
            DB::table('pl_format')->updateOrInsert(['name' => $data['name']], $data);
        }

        return redirect()->route('pl-list')->with('success', 'PL Format updated successfully.');
    }

    public function saveAndExport(Request $request)
    {
        $data = $request->only([
            'sale', 'sale_return', 'total_sales', 'purchase_amount', 'purchase_return_amount',
            'start_price', 'end_price', 'total_cost_of_sales', 'gross_profit_on_sales',
            'incomes', 'total_other_income', 'total_gross_profit', 'expenses', 'total_expenses',
            'net_profit_before_tax', 'start_date', 'end_date'
        ]);

        $profit_and_loss_number = 'PLID-' . date('YmdHis');

        $pl = ProfitAndLoss::create([
            'profit_and_loss_number' => $profit_and_loss_number,
            'month' => Carbon::createFromFormat('m/d/Y', $data['start_date'] ?? now()->format('m/d/Y'))->format('Y-m'),
            'sale' => $data['sale'] ?? 0,
            'sale_return' => $data['sale_return'] ?? 0,
            'sale_discount' => 0,
            'total_sales' => $data['total_sales'] ?? 0,
            'purchase_amount' => $data['purchase_amount'] ?? 0,
            'purchase_return_amount' => $data['purchase_return_amount'] ?? 0,
            'start_price' => $data['start_price'] ?? 0,
            'end_price' => $data['end_price'] ?? 0,
            'total_cost_of_sales' => $data['total_cost_of_sales'] ?? 0,
            'gross_profit_on_sales' => $data['gross_profit_on_sales'] ?? 0,
            'incomes' => $data['incomes'] ?? json_encode([]),
            'total_other_income' => $data['total_other_income'] ?? 0,
            'total_gross_profit' => $data['total_gross_profit'] ?? 0,
            'expenses' => $data['expenses'] ?? json_encode([]),
            'total_expenses' => $data['total_expenses'] ?? 0,
            'net_profit_before_tax' => $data['net_profit_before_tax'] ?? 0,
            'created_by' => auth()->id(),
        ]);

        return redirect()->route('export-type', ['list' => 'profit-and-loss', 'data' => json_encode($data)]);
    }
}
