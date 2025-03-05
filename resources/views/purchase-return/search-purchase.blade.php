@forelse($purchases as $purchase)
    <tr class="bg-white border-b text-left text-[14px]">
        <th scope="row" class="px-6 py-4 font-medium  text-noti whitespace-nowrap text-[14px]">
            {{ $purchase->invoice_number ?? '-' }}
        </th>

        @if ($purchase->currency_type->value == 'mmk')
            <td class="px-6 py-4 py-4 text-right text-[14px]">
                {{ number_format($purchase->total_amount) ?? '-' }}
            </td>

            <td class="px-6 py-4 text-right text-[14px]">
                {{ number_format($purchase->discount_amount) ?? '-' }}
            </td>

            <td class="px-6 py-4 text-right text-[14px]">
                <span class="text-noti">{{ number_format($purchase->total_paid_amount) ?? '-' }}</span>
            </td>
        @else
            <td class="px-6 py-4 py-4 text-right text-[14px]">
                {{ number_format($purchase->currency_purchase_amount) ?? '-' }}
            </td>

            <td class="px-6 py-4 text-right text-[14px]">
                {{ number_format($purchase->currency_discount_amount) ?? '-' }}
            </td>

            <td class="px-6 py-4 text-right text-[14px]">
                <span class="text-noti">{{ number_format($purchase->total_paid_amount) ?? '-' }}</span>
            </td>
        @endif

        <td class="px-6 py-4 text-noti text-left text-[14px]">
            @php
                $buttonColor = $purchase->action_type == 'Credit' ? '#FF8A00' : '#00812C';
            @endphp

            <button
                class="text-noti cursor-default outline-noti text-[12px] px-3 font-semibold rounded-full text-[14px]"
                style="background-color: {{ $buttonColor }}; color: white;">
                {{ $purchase->action_type }}
            </button>
        </td>

        <td class="px-6 py-4 text-right text-[14px]">
            <span class="">{{ number_format($purchase->cash_down) ?? '-' }}</span>
        </td>

        <td class="px-6 py-4 text-center text-[14px]">
            {{ number_format($purchase->total_quantity) ?? '-' }}
        </td>
        <td class="px-6 py-4 text-center text-[14px]">
            {{ number_format($purchase->total_return_quantity) ?? '-' }}
        </td>
        <td class="px-6 py-4 whitespace-nowrap text-left text-[14px]">
            {{ dateFormat($purchase->created_at ?? '-') }}
        </td>

        <td class="px-6 py-4 text-center">
            <a href="{{ route('purchase-return-create-third', ['id' => $purchase->id]) }}"
                class="font-medium text-white px-3 rounded-full text-[14px] py-[1px]" style="background-color: #ea7f03">
                Return
            </a>
        </td>

    </tr>
@empty
    @include('layouts.not-found', ['colSpan' => 10])
@endforelse
