<table>
    <thead>
        <tr>
            <th>Paid Amount</th>
            <th>Paid Date</th>
            <th>Payment Type</th>
            <th>Status</th>
            <th>Created At</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($supplier->purchases->reverse() as $purchase)
            <tr>
                <td>
                    {{ number_format($purchase->total_paid_amount) }}
                </td>
                <td>
                    @php
                        $payment_date = $purchase->paymentables->max('payment_date');
                    @endphp
                    {{ $payment_date ? dateFormat($payment_date) : '-' }}
                </td>
                <td>
                    @php
                        $bank = $purchase->paymentables
                            ->map(function ($payment) {
                                return optional(\App\Models\Bank::find($payment->payment_type))->bank_name ?? '-';
                            })
                            ->toArray();
                    @endphp
                    {{ implode(', ', $bank) }}
                </td>
                <td>
                    <x-badge
                        class="{{ $purchase->purchase_status == 'Complete' ? 'bg-primary' : 'bg-noti' }} text-white px-3">
                        {{ $purchase->purchase_status }}
                    </x-badge>
                </td>
                <td>
                    {{ $purchase->user?->name ?? '-' }}
                </td>
            </tr>
        @empty
            @include('layouts.not-found', ['colSpan' => 5])
        @endforelse

    </tbody>
</table>
