@forelse($products as $product)
    <tr class="bg-white border-b text-left">
        <th scope="row" class="px-6 py-4 whitespace-nowrap font-medium  text-gray-900">
            <div class="flex items-center gap-2">

                @if ($product->image)
                    <img src="{{ asset('products/image/' . $product->image) }}" class="w-10 h-10 object-cover">
                @else
                    <img src="{{ asset('images/no-image.png') }}" class="w-10 h-10 object-cover">
                @endif


                <h1 class="text-[#5C5C5C] font-medium  ">{{ $product->name }} <span
                        class="text-noti ">({{ $product->code }})</span></h1>
            </div>
        </th>
        <td class="px-6 py-4 whitespace-nowrap">
            {{ $product->category->name }}
        </td>
        <td class="px-6 py-4 whitespace-nowrap">
            {{ $product->brand->name }}
        </td>
        <td class="px-6 py-4 whitespace-nowrap">
            {{ $product->productModel->name }}
        </td>
        <td class="px-6 py-4 whitespace-nowrap">
            {{ $product->design?->name ?? '-' }}
        </td>
        <td class="px-6 py-4 whitespace-nowrap">
            {{ $product->type?->name ?? '-' }}
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
        <td class="px-6 py-4 text-center">
            @php
                $imei_numbers = \App\Models\IMEIProduct::where('product_id', $product->id)
                    ->where('location_id', $location->id)
                    ->where('status', '!=', 'Sold')
                    ->get();
            @endphp
            @if ($product->is_imei == 1)
                {{-- @if ($imei_numbers->isNotEmpty()) --}}
                <a href="{{ route('imei-stock', ['product_id' => $product->id, 'location_id' => $location->id]) }}"
                    class="bg-noti py-1 text-white px-2 rounded-full font-jakarta font-medium  text-[12px]">
                    IMEI List
                </a>
                <br>
                {{-- @else
                    No IMEI is Found
                @endif --}}
            @else
                No IMEI
            @endif

        </td>
        <td class="px-6 py-4 whitespace-nowrap text-noti text-center">
            {{ $product->quantity }}
        </td>
        <td class="px-6 py-4 whitespace-nowrap text-noti text-right">
            {{ number_format($product->total_retail_selling_price) ?? '-' }}
        </td>

    </tr>
    @empty
        @include('layouts.not-found', ['colSpan' => 10])
    @endforelse
