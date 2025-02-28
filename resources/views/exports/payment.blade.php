<table>
    <thead>
        <tr>
            <td>Customer Name</td>
            <td>Sale Invoice</td>
            <td>Total Amount</td>
            <td>Amount</td>
            <td>Total Paid Amount</td>
            <td>Return(+) / Refund(-)</td>
            <td>Cash Down</td>
            <td>Remain Amount</td>
            <td>Created By</td>
            <td>Payment Date</td>
        </tr>
    </thead>
    <tbody>
        @php
        use App\Constants\ExchangeCashType;
        use App\Models\Paymentable;
        @endphp

        @forelse($payments as $payment)

        @php
        $payment = Paymentable::find($payment->id);
        @endphp
        <tr>
            <th>
                {{ $payment->paymentableBy?->name ?? '-' }}( {{ $payment->paymentableBy?->user_number ?? '-' }} )
            </th>
            <td>
                {{ $payment->paymentable?->invoice_number ?? '-' }}
            </td>

            <td>
                {{ $payment->paymentable->total_amount ?? '-'}}
            </td>

            <td>
                {{ $payment->amount ?? '-' }}
            </td>
            <td>
                {{ $payment->paymentable->total_paid_amount ?? '-'}}
            </td>
            @php
                $sale = $payment->paymentable;
                $latest_sale_return = $sale->returnable->last();

                $return_refund_amount = $latest_sale_return?->latest_cash_back_amount;
                $total_amount = $sale->total_amount;
                if($return_refund_amount){

                    if($latest_sale_return?->latest_cash_back_type == 'Refund'){
                        $return_refund_amount = -$return_refund_amount;
                    }else{
                        $return_refund_amount = $return_refund_amount;
                    }
                }else{

                    $return_refund_amount = 0;

                }
            @endphp
            <td>
                {{number_format($return_refund_amount) ?? '-'}}
            </td>
            <td>
                {{number_format($sale->cash_down) ?? '-'}}
            </td>
            <td>
                {{ $payment->paymentable->total_refund_by_return > 0 ? '-'.$payment->paymentable->total_refund_by_return : number_format($payment->paymentable->remaining_amount)  }}
            </td>

            <td>
                {{ dateFormat($payment->payment_date)}}

            </td>

            <td>
                {{ $payment->user?->name ?? '-' }}
            </td>
        </tr>
        @empty
        @include('layouts.not-found', ['colSpan' => 9])
        @endforelse

    </tbody>
</table>