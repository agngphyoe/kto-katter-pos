@forelse ($purchases as $purchase)
    @php
        $latest_payment = $purchase->paymentables()->latest()->first();
        $progress = 0;

        if ($latest_payment) {
            if ($purchase->currency_type->value == 'kyat') {
                $progress = round(
                    (($latest_payment->total_paid_amount + $purchase->total_purchase_amount) /
                        $purchase->purchase_amount) *
                        100,
                );
            } else {
                $progress = round(
                    (($latest_payment->total_paid_amount + $purchase->total_purchase_amount) /
                        $purchase->currency_net_amount) *
                        100,
                );
            }
        }
    @endphp
    <tr class="bg-white border-b text-left">
        <td class="px-6 py-3 whitespace-nowrap">
            {{ $purchase->invoice_number }}
        </td>

        <td class="px-6 py-3 whitespace-nowrap">
            <x-badge class="bg-noti text-white px-3 text-center">
                {{ $purchase->action_type }}
            </x-badge>
        </td>

        <td class="px-6 py-3 whitespace-nowrap">
            {{ $purchase->currency_type->name }}
        </td>

        <td class="px-6 py-3 text-right text-noti">
            @if ($purchase->currency_type->value == 'kyat')
                {{ number_format($purchase->total_amount) ?? 0 }}
            @else
                {{ number_format($purchase->currency_purchase_amount) ?? 0 }}
            @endif
        </td>

        <td class="px-6 py-3 text-right">
            @if ($purchase->currency_type->value == 'kyat')
                {{ number_format($purchase->discount_amount) ?? 0 }}
            @else
                {{ number_format($purchase->currency_discount_amount) ?? 0 }}
            @endif
        </td>

        <td class="px-6 py-3 text-right">
            {{ number_format($purchase->cash_down) ?? 0 }}
        </td>

        <td class="px-6 py-3 text-right text-noti">
            @if ($purchase->currency_type->value == 'kyat')
                {{ number_format($purchase->purchase_amount) ?? 0 }}
            @else
                {{ number_format($purchase->currency_net_amount) ?? 0 }}
            @endif
        </td>

        <td class="px-6 py-3 text-right">
            {{ number_format($purchase->total_paid_amount) ?? 0 }}
        </td>

        @php
            $remaining_amount = $purchase->remaining_amount - $purchase->total_return_buying_amount;

            if ($purchase->paymentables->isNotEmpty()) {
                $payment = $purchase->paymentables->sortByDesc('created_at')->first();
                $remaining_amount = $payment->remaining_amount;
            }

        @endphp
        <td class="px-6 py-3 text-right text-noti">
            {{ number_format($remaining_amount) }}
        </td>

        <td class="px-6 py-3">
            <div class="flex items-center gap-3">
                <div class="bg-gray-200 w-20 h-1 rounded-full">
                    <div class="h-1 bg-primary  text-[6px] text-center  rounded-full text-white "
                        style="width: {{ round($progress) }}%"></div>
                </div>
                <h1 class="text-primary">{{ round($progress) }}%</h1>
            </div>
        </td>

        <td class="px-6 py-3 text-right">
            {{ dateFormat($purchase->created_at) }}
        </td>
        <td class="px-6 py-3">
            <x-badge class="selectBtn bg-primary text-white px-3 py-2 cursor-pointer text-xs"
                data-sale-id="{{ $purchase->id }}">
                Make Payment
            </x-badge>

        </td>
    </tr>
@empty
    @include('layouts.not-found', ['colSpan' => 10])
@endforelse
