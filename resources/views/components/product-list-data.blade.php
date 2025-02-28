@forelse($products as $product)
<tr class="bg-white border-b ">
    <th scope="row" class="px-6 py-4 font-medium  text-gray-900 whitespace-nowrap ">
        <div class="flex items-center gap-2">
            <div>
                @if($product->product?->image)
                <img src="{{ asset('products/image/'.$product->product->image) }}" class="w-20">
                @else
                <img src="https://images.unsplash.com/photo-1661956602868-6ae368943878?ixlib=rb-4.0.3&ixid=M3wxMjA3fDF8MHxlZGl0b3JpYWwtZmVlZHwyNXx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=500&q=60" class="w-20">
                @endif

            </div>
            <h1 class="text-[#5C5C5C] font-medium  ">{{ $product->product?->brand?->name }} <span class="text-noti ">({{$product->product?->code}})</span></h1>
        </div>
    </th>
    <td class="px-6 py-4">
        {{ $product->product?->category?->name }}
    </td>
    <td class="px-6 py-4 text-noti">
        {{$product->product?->brand?->name}}

    </td>
    <td class="px-6 py-4">
        {{$product->product?->model?->name}}

    </td>
    <td class="px-6 py-4">
        {{$product->product?->design?->name}}


    </td>
    <td class="px-6 py-4">
        {{$product->product?->type?->name}}

    </td>
    <td class="px-6 py-4">
        {{$product->buying_price}} 

    </td>
    <td class="px-6 py-4 text-noti">
        {{$product->selling_price}} 

    </td>
    <td class="px-6 py-4">
        {{$product->quantity}}
    </td>

</tr>
@empty
@endforelse