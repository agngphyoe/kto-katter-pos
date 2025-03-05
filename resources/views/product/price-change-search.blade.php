@forelse ($product_price_histories as $product_price_history)
    <tr class="bg-white border-b text-left">
        <td class="px-6 py-4 whitespace-nowrap">{{ $product_price_history->product->name ?? '-' }}</td>
        <td class="px-6 py-4 whitespace-nowrap">{{ $product_price_history->product->code ?? '-' }}</td>
        <td class="px-6 py-4 whitespace-nowrap" style="color: red">{{ $product_price_history->old_price ?? '-' }}</td>
        <td class="px-6 py-4 text-right " style="color: blue">{{ $product_price_history->new_price ?? '-' }}</td>
        <td class="px-6 py-4 text-right ">{{ $product_price_history->user->name ?? '-' }}</td>
        <td class="px-6 py-4 whitespace-nowrap">{{ dateFormat($product_price_history->created_at) }}</td>
    </tr>
@empty
    @include('layouts.not-found', ['colSpan' => 6])
@endforelse
