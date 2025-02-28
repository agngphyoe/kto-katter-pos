@forelse($damage_products as $damage_product)
    @php
        $product = \App\Models\Product::find($damage_product['id']);
    @endphp
    <input type="hidden" name="product_id[]" value="{{ $product->id }}">
    <tr class="bg-white border-b">

        <th scope="row" class="px-6 py-3 font-medium    whitespace-nowrap ">
            <h1 class="text-paraColor">
                <span id="name{{ $product->id }}">
                    {{ $product->name }}

                </span>
                <span class="text-noti" id="code{{ $product->id }}">
                    ({{ $product->code }})
                </span>
            </h1>

        </th>

        <td class="px-6 py-4 text-noti ">
            {{ $damage->location->location_name }}
        </td>

        <td class="px-6 py-4 text-center">
            @php
                $stocks = \App\Models\LocationStock::where('location_id', $damage->location_id)
                    ->where('product_id', $product->id)
                    ->value('quantity');
            @endphp
            {{ $stocks }}
        </td>

        <td class="px-6 py-4 text-center">
            {{ $damage_product['stock_quantity'] }}
        </td>

        <td class="px-6 py-4 text-primary text-center">
            <input type="number" id="newQuantity{{ $product->id }}"
                class="quantity outline-none px-4 py-2 text-center bg-bgMain rounded-xl w-40" min="1"
                name="new_quantity[]" required>

        </td>

    </tr>
@empty
@endforelse
