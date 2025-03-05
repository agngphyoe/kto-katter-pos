@forelse($purchase_products as $purchase_product)
    @php
        $product = \App\Models\Product::find($purchase_product->product_id);
    @endphp
    <span id="quantity{{ $product->id }}" hidden>{{ $purchase_product->quantity }}</span>
    <span id="code{{ $product->id }}" hidden>{{ $purchase_product->code }}</span>
    <span id="buy_price{{ $product->id }}" hidden>{{ $purchase_product->buying_price }}</span>
    <span id="is_imei{{ $product->id }}" hidden> {{ $product->is_imei }}</span>

    <tr class="bg-white border-b text-left">
        <th scope="row" class="px-6 py-4 font-medium  text-gray-900 whitespace-nowrap ">
            <input type="checkbox" class="mr-5 accent-primary" data-product-id="{{ $product->id }}">

        </th>
        <td class="px-6 py-4 whitespace-nowrap">
            <h1 id="name{{ $product->id }}">
                {{ $product->name }} <span class="text-noti">({{ $product->code }})</span>
            </h1>

        </td>
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
        <td class="px-6 py-4 whitespace-nowrap">
            @switch($product->is_imei)
                @case(1)
                    <x-badge class="bg-green-600 py-1 text-white px-2">
                        IMEI Product
                    </x-badge>
                @break

                @case(0)
                    <x-badge class="bg-gray-300 py-1 text-dark px-2">
                        Non-IMEI Product
                    </x-badge>
                @break

                @default
            @endswitch
        </td>
        <td class="px-6 py-4 whitespace-nowrap">
            @php
                $imeis = json_decode($purchase_product->imei, true); // Decode the JSON into an array
            @endphp

            @if (!empty($imeis) && is_array($imeis))
                @foreach ($imeis as $imei)
                    {{ $imei }} <br> <!-- Display each IMEI on a new line -->
                @endforeach
            @else
                No IMEI
            @endif
        </td>
        {{-- <td class="px-6 py-4 text-center" id="available_quantity{{$product->id}}">
            @php
                $totalReturnQty = 0;

                $returns = \App\Models\PosReturn::where('point_of_sale_id', $purchase_product->point_of_sale_id)
                                                ->get();


                foreach ($returns as $returnData) {
                    $returnQty = \App\Models\PosReturnProduct::where('product_id', $product->id)
                                                            ->where('pos_return_id', $returnData->id)
                                                            ->value('quantity') ?? 0;
                    $totalReturnQty += $returnQty;
                }

                $remaining_qty = $purchase_product->quantity - $totalReturnQty;
            @endphp
            {{ $remaining_qty }}
        </td> --}}
    </tr>
    @empty
        @include('layouts.not-found', ['colSpan' => 10])
    @endforelse
