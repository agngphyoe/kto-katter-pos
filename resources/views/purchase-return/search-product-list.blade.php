@forelse($purchase_products as $purchase_product)
    @php
        $product = \App\Models\Product::find($purchase_product->product_id);
    @endphp
    <span id="quantity{{ $product->id }}" hidden>{{ $purchase_product->quantity }}</span>
    <span id="code{{ $product->id }}" hidden>{{ $purchase_product->code }}</span>
    <span id="buy_price{{ $product->id }}" hidden>
        @if ($purchase_product->purchase->currency_type->value == 'mmk')
            {{ $purchase_product->buying_price }}
        @else
            {{ $purchase_product->currency_buying_price }}
        @endif
    </span>
    {{-- <span id="is_imei{{ $product->id }}" hidden> {{ $product->is_imei }}</span> --}}
    <input type="hidden" name="is_imei{{ $product->id }}" id="is_imei{{ $product->id }}" value="{{ $product->is_imei }}">

    <tr class="bg-white border-b text-left">
        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
            <input type="checkbox" class=" accent-primary" data-product-id="{{ $product->id }}"><span
                id="name{{ $product->id }}">
                {{ $product->name }} <span class="text-noti">({{ $product->code }})</span></span>
        </th>

        <td class="px-6 py-4 whitespace-nowrap">
            <h1>
                {{ $product->category->name ?? '-' }}
            </h1>

        </td>
        <td class="px-6 py-4 whitespace-nowrap" id="">
            {{ $product->brand->name ?? '-' }}
        </td>
        <td class="px-6 py-4 whitespace-nowrap" id="">
            {{ $product->productModel->name ?? '-' }}
        </td>
        <td class="px-6 py-4 whitespace-nowrap">
            {{ $product->design->name ?? '-' }}
        </td>
        <td class="px-6 py-4 whitespace-nowrap">
            {{ $product->type->name ?? '-' }}
        </td>
        <td class="px-6 py-4 whitespace-nowrap text-center" id="available_quantity{{ $product->id }}">
            {{-- {{ $purchase_product->after_quantity ?number_format($purchase_product->after_quantity) : number_format($purchase_product->quantity)}} --}}
            {{ number_format($purchase_product->quantity) }}
        </td>
        {{-- <td class="px-6 py-4 text-right" id="action_quantity{{$product->id}}">
            -
        </td> --}}
    </tr>
@empty
    @include('layouts.not-found', ['colSpan' => 9])
@endforelse
