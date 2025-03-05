@forelse($sales as $sale)
    <tr class="bg-white border-b text-left ">
        <td scope="row" class="px-6   py-4 whitespace-nowrap ">
            <h1 class="text-noti text-left">
                {{ $sale->order_number }}
            </h1>
        </td>

        <td class="px-6 py-4 whitespace-nowrap text-left">
            {{ $sale->shopper->name }}
        </td>

        <td class="px-6 py-4 whitespace-nowrap text-center">
            {{ number_format($sale->total_quantity) }}
        </td>

        <td class="px-6 py-4 whitespace-nowrap text-right">
            {{ number_format($sale->total_amount) }}
        </td>

        <td class="px-6 py-4 whitespace-nowrap text-right">
            {{ number_format($sale->discount_amount) }}
        </td>

        <td class="px-6 py-4 whitespace-nowrap text-right">
            {{ number_format($sale->net_amount) }}
        </td>

        <td class="px-6 py-4 whitespace-nowrap text-right">
            {{ number_format($sale->paid_amount) }}
        </td>

        <td class="px-6 py-4 whitespace-nowrap text-right">
            {{ number_format($sale->change_amount) }}
        </td>

        <td class="px-6 py-4 whitespace-nowrap">

            {{ $sale->paymentType->bank_name }}
        </td>

        <td class="px-6 py-4 text-center whitespace-nowrap">

            {{ dateFormat($sale->order_date) }}
        </td>

        <td class="px-6 py-4 whitespace-nowrap">

            {{ $sale->user->name }}
        </td>

        <td class="px-6 py-4 text-center text-primary">
            <a href="{{ route('export-sale-detail', ['saleId' => $sale->id]) }}">
                <i class="fa-solid fa-download"></i>
            </a>
        </td>

    </tr>
@empty

    @include('layouts.not-found', ['colSpan' => 12])
@endforelse
