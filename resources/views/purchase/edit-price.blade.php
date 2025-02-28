@extends('layouts.master-without-nav')
@section('title', 'Edit Purchase Price')
@section('css')

@endsection

@section('content')
    <section class="Purchase__Detail">
        {{-- nav start  --}}
        @include('layouts.header-section', [
            'title' => 'Edit Purchase Price',
            'subTitle' => 'Details of Purchase',
        ])
        {{-- nav end  --}}


        {{-- ..........  --}}

        {{-- main start  --}}
        <div class="lg:mx-[30px] mx-[10px] my-[10px] lg:my-[20px]">
            {{-- ........  --}}
            {{-- purchase information start  --}}
            <div class="bg-white px-5 rounded-[20px]">

                <div class="flex items-center justify-between pt-5">
                    <h1 class="text-noti font-semibold font-jakarta">Edit Product Buying Price</h1>
                </div>

                <div class="data-table">
                    <div class="bg-white px-1 py-2 font-poppins rounded-[20px]  ">
                        <div>
                            <div class="relative overflow-x-auto mt-3 shadow-lg">
                                <table class="w-full text-sm text-center text-gray-500 ">
                                    <thead class="text-sm text-primary bg-gray-50  font-medium font-poppins">

                                        {{-- <x-table-head-component :columns="[
                                            'Product Name (ID)',
                                            'Categories',
                                            'Brand',
                                            'Model',
                                            'Design',
                                            'Type',
                                            'New Buying Price',
                                        ]" /> --}}
                                        <tr class="text-left border-b">
                                            <th
                                                class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-left">
                                                Product Name (ID)
                                            </th>
                                            <th
                                                class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-left">
                                                Categories
                                            </th>
                                            <th
                                                class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-left">
                                                Brand
                                            </th>
                                            <th
                                                class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-left">
                                                Model
                                            </th>
                                            <th
                                                class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-left">
                                                Design
                                            </th>
                                            <th
                                                class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-left">
                                                Type
                                            </th>
                                            <th
                                                class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-left">
                                                Old Buying Price
                                            </th>
                                            <th
                                                class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-right">
                                                New Buying Price
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody class="text-sm font-normal text-paraColor font-poppins">
                                        @forelse($purchase->purchaseProducts as $purchaseData)
                                            @php
                                                $product = \App\Models\Product::find($purchaseData->product_id);
                                            @endphp
                                            <tr class="bg-white border-b text-left">
                                                <th scope="row"
                                                    class="px-6 py-4 whitespace-nowrap font-medium  text-gray-900">
                                                    <div class="flex items-center gap-2">

                                                        @if ($product->image)
                                                            <img src="{{ asset('products/image/' . $product->image) }}"
                                                                class="w-10 h-10 object-cover">
                                                        @else
                                                            <img src="{{ asset('images/no-image.png') }}"
                                                                class="w-10 h-10 object-cover">
                                                        @endif


                                                        <h1 class="text-[#5C5C5C] font-medium  ">{{ $product->name }} <span
                                                                class="text-noti ">({{ $product->code }})</span></h1>
                                                    </div>
                                                </th>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    {{ $product->category?->name }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-noti">
                                                    {{ $product->brand?->name }}

                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    {{ $product->productModel?->name }}

                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    {{ $product->design?->name ?? '-' }}


                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    {{ $product->type?->name ?? '-' }}

                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    {{ $purchaseData->buying_price ?? '-' }}

                                                </td>
                                                <form
                                                    action="{{ route('purchase-update', ['purchase' => $purchase->id]) }}"
                                                    method="post" id="submitForm">
                                                    @csrf
                                                    @method('PUT')
                                                    <input type="hidden" name="product_id[]" value="{{ $product->id }}">
                                                    <td class="px-6 py-4 whitespace-nowrap text-primary text-right">
                                                        <input type="number" placeholder="Buying Price"
                                                            class="w-28 px-2 py-2 text-md rounded-lg outline outline-2 text-right"
                                                            style="outline-color: black;"
                                                            id="buyingPrice{{ $product->id }}"
                                                            value="{{ $purchaseData->buying_price }}" name="buyingPrice[]"
                                                            required>

                                                    </td>

                                            </tr>
                                        @empty
                                            @include('layouts.not-found', ['colSpan' => 7])
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>

                        </div>


                    </div>
                </div>
            </div>
            {{-- purchase information end --}}


            <div class="flex justify-center gap-4">
                <button type="submit"
                    class="bg-green-600 text-white font-jakarta font-semibold mt-10 px-20 py-2 rounded-full" id="submitButton">Update
                    Price</button>
            </div>
            </form>
        </div>
        {{-- main end  --}}

    </section>
@endsection
@section('script')

@endsection
