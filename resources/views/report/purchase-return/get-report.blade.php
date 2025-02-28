@forelse($returnables as $returnable)
    <tr class="bg-white border-b text-left">
        <td scope="row" class="px-6 py-4 whitespace-nowrap">
            <h1 class="text-noti text-left">
                {{ $returnable->purchase_return_number ?? '-' }}
            </h1>
        </td>

        <td scope="row" class="px-6 py-4 whitespace-nowrap">
            <h1 class="text-left">
                {{ $returnable->purchase->invoice_number ?? '-' }}
            </h1>
        </td>

        <td scope="row" class="px-6 py-4 whitespace-nowrap">
            <h1 class="text-left">
                {{ $returnable->purchase->supplier->user_number ?? '-' }}
            </h1>
        </td>

        <td class="px-6 py-4 whitespace-nowrap">
            {{ $returnable->purchase->supplier->name ?? '-' }}
        </td>

        <td class="px-6 py-4 whiteshape-nowrap font-medium">
            {{ $returnable->purchase->action_type ?? '-' }}
        </td>

        <td class="px-6 py-4 font-medium text-center">
            {{ number_format($returnable->purchase->total_quantity) }}
        </td>

        <td class="px-6 py-4 font-medium text-center">
            {{ number_format($returnable->return_quantity) }}
        </td>

        <td class="px-6 py-4 whitespace-nowrap">
            {{ $returnable->remark ?? '-' }}
        </td>

        <td class="px-6 py-4 whitespace-nowrap">
            {{ dateFormat($returnable->return_date) }}
        </td>

        <td class="px-6 py-4 whitespace-nowrap">
            {{ $returnable->user->name ?? '-' }}
        </td>

        <td class="px-6 py-4 text-center text-primary">
            <a href="{{ route('export-purchase-return-detail', ['returnableId' => $returnable->id]) }}">
                <i class="fa-solid fa-download"></i>
            </a>
        </td>

    </tr>
@empty

    @include('layouts.not-found', ['colSpan' => 11])
@endforelse
