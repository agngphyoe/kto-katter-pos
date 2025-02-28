@forelse ($products as $product)
    <tr class="text-left border-b">
        <th scope="row" class="px-6 py-4 whitespace-nowrap">
            <input type="checkbox" class="w-4 h-5 accent-primary" data-product-id="{{ $product->id }}">
        </th>
        <td class="px-6 py-4 whitespace-nowrap" id="name{{ $product->id }}">{{ $product->name ?? '-' }}</td>
        <td class="px-6 py-4 whitespace-nowrap" id="code{{ $product->id }}">{{ $product->code ?? '-' }}</td>
        <td class="px-6 py-4 whitespace-nowrap text-right" id="retail_price{{ $product->id }}">
            {{ number_format($product->retail_price) }}</td>
        {{-- <td class="px-6 py-4 whitespace-nowrap">
        {{$product->user->name ?? '-' }}
    </td>
    <td class="px-6 py-4 whitespace-nowrap">
        {{ dateFormat($product->created_at) ?? '-' }}
    </td> --}}
    </tr>
@empty
    @include('layouts.not-found', ['colSpan' => 7])
@endforelse
