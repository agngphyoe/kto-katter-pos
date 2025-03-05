@forelse($purchases as $purchase)
    <tr class="bg-white border-b text-left ">

        <td scope="row" class="px-6   py-4 whitespace-nowrap ">
            <h1 class="text-noti text-left">
                {{ $purchase->invoice_number }}
            </h1>
        </td>

        <td scope="row" class="px-6   py-4 whitespace-nowrap ">
            <h1 class="text-left">
                {{ $purchase->supplier?->user_number }}
            </h1>
        </td>

        <td class="px-6 py-4 whitespace-nowrap">

            {{ $purchase->supplier?->name ?? '-' }}
        </td>

        <td class="px-6 py-4 whitespace-nowrap">

            {{ $purchase->action_type }}
        </td>

        <td class="px-6 py-4 whitespace-nowrap">

            {{ $purchase->currency_type->name }}
        </td>

        <td class="px-6 py-4  text-center font-medium ">

            {{ number_format($purchase->total_quantity) }}
        </td>

        <td class="px-6 py-4  text-right font-medium text-right ">

            {{ number_format($purchase->currency_purchase_amount) }}
        </td>

        <td class="px-6 py-4  text-right font-medium text-right ">

            {{ number_format($purchase->currency_discount_amount) }}
        </td>

        <td class="px-6 py-4  text-right font-medium text-right ">

            {{ number_format($purchase->currency_purchase_amount - $purchase->currency_discount_amount) }}
        </td>

        <td class="px-6 py-4  text-right font-medium text-right ">

            {{ number_format($purchase->cash_down) }}
        </td>

        <td class="px-6 py-4  text-right font-medium text-right ">

            {{ number_format($purchase->total_paid_amount) }}
        </td>

        <td class="px-6 py-4  text-right font-medium text-right ">

            @php
                $remaining = \App\Models\Paymentable::where('paymentable_type', 'App\Models\Purchase')
                    ->where('paymentable_id', $purchase->id)
                    ->orderByDesc('id')
                    ->first();
            @endphp
            {{ number_format($remaining->remaining_amount) }}
        </td>

        <td class="px-6 py-4   ">

            <x-badge class="{{ $purchase->purchase_status == 'Complete' ? 'bg-primary' : 'bg-noti' }} text-white px-3">
                {{ $purchase->purchase_status }}
            </x-badge>


        </td>

        <td class="px-6 py-4 whitespace-nowrap">

            {{ dateFormat($purchase->action_date) }}
        </td>

        <td class="px-6 py-4 whitespace-nowrap">

            {{ $purchase->user?->name ?? '-' }}
        </td>

        <td class="px-6 py-4 text-center text-primary">
            <a href="{{ route('export-purchase-detail', ['purchaseId' => $purchase->id]) }}">
                <i class="fa-solid fa-download"></i>
            </a>
        </td>
    </tr>
@empty

    @include('layouts.not-found', ['colSpan' => 16])
@endforelse
