<?php

namespace App\Http\Controllers;

use App\Actions\HandleFilterQuery;
use App\Actions\HandlePagination;
use App\Constants\PaymentType;
use App\Constants\ProgressStatus;
use App\Constants\PurchaseType;
use App\Http\Requests\PurchasePayment\SecondFormStoreRequest;
use App\Models\Bank;
use App\Models\Paymentable;
use App\Models\Purchase;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;


class PurchasePaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = Paymentable::where('paymentable_type', Purchase::class)
                                ->select('*')
                                ->whereIn('id', function($subquery) {
                                    $subquery->selectRaw('MAX(id)')
                                        ->from('paymentable')
                                        ->where('paymentable_type', Purchase::class)
                                        ->groupBy('paymentable_id');
                                })
                                ->orderByDesc('id');

        $total_count = $query->count();

        if ($request->ajax()) {
            $keyword    = $request->search;
            $start_date = $request->start_date;
            $end_date   = $request->end_date;

            $query = (new HandleFilterQuery(keyword: $keyword, start_date: $start_date, end_date: $end_date))
                ->executePaymentFilter(query: $query);

            $search_count = $query->count();
            $payments = $query->paginate(10);

            $html = View::make('purchase-payment.search', compact('payments'))->render();

            return response()->json([
                'success' => true,
                'html' => $html,
                'total_count' => $total_count,
                'search_count' => $search_count,
                'pagination' => (new HandlePagination(data: $payments))->pagination()
            ]);
        }

        $payments = $query->paginate(10);

        return view('purchase-payment.index', compact('payments', 'total_count'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function createFirst()
    {
        $suppliers = Supplier::whereHas('purchases', function ($query) {
                                    $query->wherePurchaseStatus(ProgressStatus::ONGOING);
                                })->get();

        return view('purchase-payment.create-first', compact('suppliers'));
    }

    public function createSecond(SecondFormStoreRequest $request)
    {
        $supplier = Supplier::find($request->supplier_id);

        $purchases = $supplier->purchases()->wherePurchaseStatus(ProgressStatus::ONGOING)
                                           ->whereActionType(PurchaseType::TYPES['Credit'])
                                           ->paginate(10);

        return view('purchase-payment.create-second', [
            'purchases' => $purchases,
            'supplier_id' => $supplier->id,
        ]);
    }

    public function searchPurchase(Request $request){
        $purchases = Purchase::where('supplier_id', $request->supplier_id)
                                ->where('invoice_number', 'like', '%'.$request->search.'%')
                                ->wherePurchaseStatus(ProgressStatus::ONGOING)
                                ->whereActionType(PurchaseType::TYPES['Credit'])
                                ->orderBy('id', 'desc')
                                ->get();

        $html = View::make('purchase-payment.search-purchase', compact('purchases'))->render();

        return response()->json([
            'success' => true,
            'html' => $html,
        ]);
    }

    public function createThird(Request $request)
    {
        $purchase = Purchase::find($request->purchase_id);

        $banks  = Bank::all();

        $refund_amount = $purchase->total_return_buying_amount > 0 ? $purchase->total_return_buying_amount : 0;

        return view('purchase-payment.create-third', compact('purchase', 'banks', 'refund_amount'));
    }

    public function createFinal(Request $request)
    {
        $data = $request->all();
        
        $purchase = Purchase::find($request->purchase_id);

        $amount = $request->amount;

        $new_remained_amount = $request->new_remained_amount;

        $bank = Bank::find($request->payment_type);

        return view('purchase-payment.create-final', compact('purchase', 'amount', 'new_remained_amount', 'data', 'bank'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = json_decode($request->data, true);
        $purchase   = Purchase::find($data['purchase_id']);
        $supplier = Supplier::find($purchase->supplier?->id);

        DB::beginTransaction();

        try {
            $amount = $data['amount'];
            $new_remained_amount = $data['new_remained_amount'];

            $payment   = new Paymentable();

            $payment->paymentable()->associate($purchase);

            $payment->paymentableBy()->associate($supplier);

            $payment->payment_type   = $data['payment_type'];
            $payment->payment_status = ProgressStatus::ONGOING;
            $payment->payment_date   = format_date($data['purchase_payment_date']);
            $payment->next_payment_date   = format_date($data['next_purchase_payment_date']);
            $payment->amount   = $amount;
            $payment->remaining_amount   = $new_remained_amount;
            $payment->total_paid_amount   = $purchase->total_paid_amount + $amount;
            $payment->save();

            $purchase->total_paid_amount = $purchase->total_paid_amount + $amount;
            $purchase->remaining_amount = $new_remained_amount;

            if ($payment->remaining_amount == 0) {
                $purchase->purchase_status = ProgressStatus::COMPLETE;

                $payment->payment_status = ProgressStatus::COMPLETE;
                $payment->save();
            }
            $purchase->save();

            DB::commit();

            return redirect()->route('purchase-payment')->with('success', 'Success! Payment Created');
        } catch (\Exception $e) {
            // dd($e);
            DB::rollback();

            return back()->with('error', 'Failed! Payment can not Created');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Paymentable $payment)
    {
        $purchase = Purchase::find($payment->paymentable_id);

        return view('purchase-payment.detail', compact('payment', 'purchase'));
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
}
