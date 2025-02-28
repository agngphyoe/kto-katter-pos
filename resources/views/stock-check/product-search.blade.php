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
