<?php

namespace App\Http\Controllers;

use App\Actions\ExecuteSaleAndPaymentableStore;
use App\Actions\HandleFilterQuery;
use App\Actions\HandlePagination;
use App\Constants\ExchangeCashType;
use App\Constants\PaymentType;
use App\Constants\ProgressStatus;
use App\Constants\SaleType;
use App\Http\Requests\Payment\StoreSecondFormRequest;
use App\Models\Bank;
use App\Models\Customer;
use App\Models\Payment;
use App\Models\Paymentable;
use App\Models\Sale;
use App\Models\Purchase;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $paymentable = $query = Paymentable::where('paymentable_type', Sale::class)->select('paymentable_id', DB::raw('MAX(id) as id'))->groupBy('paymentable_id')->orderByDesc('id');

        if ($request->ajax()) {

            $keyword    = $request->search;
            $start_date = $request->start_date;
            $end_date   = $request->end_date;

            $query = (new HandleFilterQuery(keyword: $keyword, start_date: $start_date, end_date: $end_date))->executePaymentFilter(query: $paymentable);

            $payments = $query->paginate(10);

            $html = View::make('payment.search', compact('payments'))->render();

            return response()->json([
                'success' => true,
                'html' => $html,
                'pagination' => (new HandlePagination(data: $payments))->pagination()
            ]);
        }

        $payments = $paymentable->paginate(10);

        $total_count    = $paymentable->get()->count();

        return view('payment.index', compact('payments', 'total_count'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function createFirst()
    {
        $customers = Customer::whereHas('sales', function ($query) {
                                    $query->whereSaleStatus(ProgressStatus::ONGOING);
                                })->get();

        return view('payment.create-first', compact('customers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function createSecond(StoreSecondFormRequest $request)
    {
        $customer = Customer::find($request->customer_id);

        $sales = $customer->sales()->whereSaleStatus(ProgressStatus::ONGOING)->whereActionType(SaleType::TYPES['Credit'])->get();

        return view('payment.create-second',  compact('sales'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function createThird(Request $request)
    {
        $sale = Sale::find($request->sale_id);
        $return_refund_amount = 0;
        $remaining_amount = $sale->remaining_amount;
        $max_amount = $sale->remaining_amount;
        if ($sale->paymentables->isNotEmpty()) {
            $payment = $sale->paymentables()->latest()->first();
            $max_amount = $payment->remaining_amount;
            $remaining_amount = $payment->remaining_amount;
        } else {
            if ($sale->total_refund_by_return > 0) {
                // dd($sale->total_refund_by_return);
                $max_amount = $sale->total_amount - $sale->total_refund_by_return;
                $remaining_amount = $max_amount;
            } elseif ($sale->returnable->first()) {
                $last_sale_returnable = $sale->returnable->sortByDesc('created_at')->first();
                $latest_cash_back_amount = $last_sale_returnable->latest_cash_back_amount;
                $latest_cash_back_type = $last_sale_returnable->latest_cash_back_type;
                if ($latest_cash_back_type == ExchangeCashType::REFUND) {
                    $return_refund_amount = -$latest_cash_back_amount;
                } elseif ($latest_cash_back_type == ExchangeCashType::RETURN) {
                    $return_refund_amount = $latest_cash_back_amount;
                }
                $max_amount = $sale->remaining_amount + $return_refund_amount;
                $remaining_amount = $sale->remaining_amount;
            }
            // remaining amount

        }

        $banks  = Bank::all();

        return view('payment.create-third', compact('sale', 'banks', 'return_refund_amount', 'max_amount', 'remaining_amount'));
    }

    public function createFinal(Request $request)
    {
        $data = $request->all();

        $sale = Sale::find($request->sale_id);

        $amount = $request->amount;

        $new_remained_amount = $request->new_remained_amount;

        return view('payment.create-final', compact('sale', 'amount', 'new_remained_amount', 'data'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $data = json_decode($request->data, true);

        $sale   = Sale::find($data['sale_id']);

        // $last_payment = $sale->paymentables()->latest()->first();

        $customer = Customer::find($sale->saleableBy?->id);

        DB::beginTransaction();

        try {
            $amount = $data['amount'];
            $new_remained_amount = $data['new_remained_amount'];

            // less than 0
            if ($new_remained_amount < 0) {

                $sale->update([
                    'sale_status' => ProgressStatus::COMPLETE,
                    'return_status' => 0
                ]);
            }

            $sale->update([
                'total_paid_amount' => $sale->total_paid_amount + $amount,
                'remaining_amount' => $new_remained_amount
            ]);

            $payment_info = [
                'paymentable' => $sale,
                'paymentableby' => $customer,
                'payment_type' => $data['payment_type'],
                'status' => ProgressStatus::ONGOING,
                'payment_date' => format_date($data['payment_date']),
                'next_payment_date' => $data['next_payment_date'],
                'amount' => $data['amount'],
                'remaining_amount' => $new_remained_amount,
            ];

            if ($sale->paymentables->isNotEmpty()) {
                $latest_payment = $sale->paymentables()->latest()->first();
                $latest_payment_remaining_amount = $latest_payment->remaining_amount ?? 0;
            }

            $payment = (new ExecuteSaleAndPaymentableStore())->executePaymentStore(payment_info: $payment_info);

            DB::commit();

            return redirect()->route('payment')->with('success', 'Success! Payment Created');
        } catch (\Exception $e) {
            dd($e);
            DB::rollback();

            return back()->with('error', 'Failed! Payment can not Created');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function show(Paymentable $payment)
    {
        $purchase = Purchase::find($payment->paymentable_id);
        return view('payment.detail', compact('payment', 'purchase'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function edit(Paymentable $payment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Paymentable $payment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Paymentable $payment)
    {
        // $payment->delete();

        // return response()->json([
        //     'message' => 'The record has been deleted successfully.',
        //     'status' => 200,
        // ], 200);
    }

    public function search(Request $request)
    {
        $keyword     = $request->input('search');
        $start_date  = $request->input('start_date');
        $end_date    = $request->input('end_date');
    }
}
