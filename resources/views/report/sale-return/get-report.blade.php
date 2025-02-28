@forelse($returnables as $returnable)
    <tr class="bg-white border-b text-left ">
        <td scope="row" class="px-6   py-4 whitespace-nowrap ">
            <h1 class="text-noti text-left">
                {{ $returnable->pos_return_id ?? '-' }}
            </h1>
        </td>

        <td scope="row" class="px-6   py-4 whitespace-nowrap ">
            <h1 class="text-left">
                {{ $returnable->pointOfSale->order_number }}
            </h1>
        </td>

        <td class="px-6 py-4 whitespace-nowrap text-left">
            {{ $returnable->pointOfSale->shopper->name }}
        </td>

        <td class="px-6 py-4 whitespace-nowrap text-center">

            {{ number_format($returnable->pointOfSale->total_quantity) }}
        </td>

        <td class="px-6 py-4 whitespace-nowrap text-right">

            {{ number_format($returnable->pointOfSale->total_amount) }}
        </td>

        <td class="px-6 py-4 whitespace-nowrap text-right">

            {{ number_format($returnable->total_return_amount) }}
        </td>

        <td class="px-6 py-4 whitespace-nowrap text-center">

            {{ number_format($returnable->total_return_quantity) }}
        </td>

        <td class="px-6 py-4 whitespace-nowrap">

            {{ $returnable->remark }}
        </td>

        <td class="px-6 py-4 whitespace-nowrap">

            {{ dateFormat($returnable->return_date) }}
        </td>

        <td class="px-6 py-4 whitespace-nowrap">

            {{ $returnable->createdBy->name }}
        </td>

        <td class="px-6 py-4 text-center text-primary">
            <a href="{{ route('export-sale-return-detail', ['returnableId' => $returnable->id]) }}">
                <i class="fa-solid fa-download"></i>
            </a>
        </td>

    </tr>
@empty

    @include('layouts.not-found', ['colSpan' => 11])
@endforelse
