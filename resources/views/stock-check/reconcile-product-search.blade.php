@forelse($products as $product)
    <tr class="bg-white border-b text-left">
        <th scope="row" class="px-6 py-4 whitespace-nowrap font-medium  text-gray-900">
            <div class="flex items-center gap-2">

                @if ($product->image)
                    <img src="{{ asset('products/image/' . $product->image) }}" class="w-10 h-10 object-cover">
                @else
                    <img src="{{ asset('images/no-image.png') }}" class="w-10 h-10 object-cover">
                @endif

                <h1 class="text-[#5C5C5C] font-medium  ">{{ $product->name }}</h1>
            </div>
        </th>
        <td class="text-noti px-6 py-4 whitespace-nowrap">
            {{ $product->code }}
        </td>

        <td class="px-6 py-4 whitespace-nowrap text-center" id="softwareQuantity_{{ $product->id }}">
            {{ $product->quantity }}
        </td>
        <input type="hidden" name="inventoryQty_{{ $product->id }}" value="{{ $product->quantity }}">

        <td class="px-6 py-4 whitespace-nowrap text-noti text-center">
            <div class="flex flex-col items-center">
                <input type="number" name="realQty_{{ $product->id }}" id="realQty_{{ $product->id }}"
                    class="custom_input outline outline-1 text-sm font-jakarta text-paraColor w-[100px] outline-primary px-4 py-2 rounded-full text-right">
                <span id="error_msg_{{ $product->id }}" class="text-red-600 text-xs mt-2 hidden"> * Quantity
                    Required</span>
            </div>
        </td>

        <td class="px-6 py-4 whitespace-nowrap text-primary text-center" id="discrepancy_{{ $product->id }}">
            0
        </td>

        <td class="px-6 py-4 flex justify-start gap-2">
            <button class="bg-primary text-white font-semibold rounded px-2 py-2 font-jakarta md:w-200px" type="button"
                onclick="checkProduct({{ $product->id }})">
                Check
            </button>
            {{-- <a href="">
                <button class="bg-noti text-white font-semibold rounded px-2 py-2 font-jakarta md:w-200px" type="button">
                    Flag Issue
                </button>
            </a> --}}
        </td>

    </tr>
@empty
    @include('layouts.not-found', ['colSpan' => 10])
@endforelse
