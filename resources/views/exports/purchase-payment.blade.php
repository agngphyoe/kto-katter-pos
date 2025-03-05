<table>
    <thead>
        <tr>
            <td>Supplier Name</td>
            <td>Purchase Invoice</td>
            <td>Total Amount</td>
            <td>Discount</td>
            <td>Cash Down</td>
            <td>Balance Amount</td>
            <td>Total Paid Amount</td>
            <td>Remaining Amount</td>
            <td>Progress</td>
            <td>Payment Date</td>
            <td>Created By</td>
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
                <div class="flex items-center gap-3 ">
                    {{ $payment->paymentableBy->name }}( {{ $payment->paymentableBy->user_number}} )
                </div>

            </th>
            <td>
                {{ $payment->paymentable?->invoice_number}}
            </td>

            <td>
                {{ $payment->paymentable?->total_amount }}
            </td>
            <td>
                {{ $payment->paymentable?->discount_amount }}
            </td>
            <td>
                {{ $payment->paymentable?->cash_down }}
            </td>
            <td>
                {{ $payment->paymentable?->purchase_amount }}
            </td>
            <td>
                {{ $payment->paymentable->total_paid_amount }}
            </td>
            
            <td>
                {{ $payment->paymentable?->remaining_amount }}
            </td>
            <td>
                @php
                    $purchase = $payment->paymentable;
                    $progress = round((($payment->total_paid_amount + $purchase->total_purchase_return_amount) / $purchase->purchase_amount) * 100);
                @endphp
                {{ $progress }}
            </td>
            <td>
                {{ dateFormat($payment->payment_date)}}

            </td>
            <td>
                {{ $payment->user?->name }}

            </td>
        </tr>
        @empty
        @include('layouts.not-found', ['colSpan' => 10])
        @endforelse


    </tbody>
</table>