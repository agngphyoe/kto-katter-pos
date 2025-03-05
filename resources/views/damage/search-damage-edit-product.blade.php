@forelse($products as $product)
    <tr class="bg-white border-b text-left">
        <th scope="row" class="px-6 py-4">
            <input type="checkbox" class="w-4 h-5  accent-primary" data-product-id="{{ $product->id }}">
        </th>
        <th scope="row" class="px-6 py-3 font-medium whitespace-nowrap text-left">
            <h1 class="text-paraColor"><span id="name{{ $product->id }}">{{ $product->name ?? '-' }}</span> <span
                    class="text-noti" id="code{{ $product->id }}">({{ $product->code ?? '-' }})</span></h1>
            </div>
        </th>
        <td class="px-6 py-3">
            {{ $product->category?->name ?? '-' }}
        </td>
        <td class="px-6 py-3">
            {{ $product->brand?->name ?? '-' }}

        </td>
        <td class="px-6 py-3">
            {{ $product->productModel?->name ?? '-' }}

        </td>

        <td class="px-6 py-3">
            {{ $product->design?->name ?? '-' }}

        </td>

        <td class="px-6 py-3">
            {{ $product->type?->name ?? '-' }}

        </td>

        <td class="pl-6 pr-10 py-3 text-center" id="quantity{{ $product->id }}">
            {{ $product->quantity }}

        </td>

    </tr>
@empty
    @include('layouts.not-found', ['colSpan' => 9])
@endforelse
