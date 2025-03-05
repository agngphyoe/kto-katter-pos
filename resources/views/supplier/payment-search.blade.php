@forelse ($supplier->purchases->reverse() as $purchase)
    <tr class="bg-white border-b text-left">
        <td class="py-4 px-6 whitespace-nowrap text-paraColor font-poppins text-[13px] text-left">
            @php
                $payment_date = $purchase->paymentables->max('payment_date');
            @endphp
            {{ $payment_date ? dateFormat($payment_date) : '-' }}
        </td>
        <td class="py-4 px-6 whitespace-nowrap text-paraColor font-poppins text-[13px] text-right">
            {{ number_format($purchase->total_paid_amount) }}
        </td>
        <td class="py-4 px-6 whitespace-nowrap text-paraColor font-poppins text-[13px] text-left">
            @php
                $bank = $purchase->paymentables
                    ->map(function ($payment) {
                        return optional(\App\Models\Bank::find($payment->payment_type))
                            ->bank_name ?? '-';
                    })
                    ->toArray();
            @endphp
            {{ implode(', ', $bank) }}
        </td>
        <td class="py-4 px-6 whitespace-nowrap text-paraColor font-poppins text-[13px] text-left">
            {{ $purchase->user?->name ?? '-' }}
        </td>
        <td class="py-4 px-6 whitespace-nowrap text-paraColor font-poppins text-[13px] text-left">
            {{ dateFormat($purchase->created_at) }}
        </td>
    </tr>
@empty
    @include('layouts.not-found', ['colSpan' => 7])
@endforelse