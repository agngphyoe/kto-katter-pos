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
            <div class="bg-white rounded-[25px]">
                <div>
                    <div class="flex items-center justify-between font-poppins">
                        <h1 class="text-noti font-semibold font-jakarta ml-5 mt-2">Supplier Details</h1>
                    </div>
                    <div class="flex items-center justify-between flex-wrap gap-4 p-5">
                        <x-information title="Supplier Name" subtitle="{{ $purchase->supplier?->name ?? '-' }}" />
                        <x-information title="Supplier ID" subtitle="{{ $purchase->supplier?->user_number ?? '-' }}" />
                        <x-information title="Phone Number" subtitle="{{ $purchase->supplier?->phone ?? '-' }}" />
                        <x-information title="Country" subtitle="{{ $purchase->supplier?->country?->name ?? '-' }}" />
                        <x-information title="Address" subtitle="{{ $purchase->supplier?->address ?? '-' }}" />
                    </div>
                </div>
            </div>
            {{-- ........  --}}
            {{-- purchase information start  --}}
            <div class="bg-white p-5 rounded-[20px] mt-5">
                <x-infor-com title="Purchase Information" :data="$purchase" />

                <div class="flex items-center justify-between pt-5">
                    <h1 class="text-noti font-semibold font-jakarta">Purchased Products</h1>
                    <h1 class="text-[#5C5C5C] text-md font-semibold ">Total Quantity : <span
                            class="text-noti">{{ number_format($purchase->total_quantity) }}</span></h1>
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
                                            'Buying Price',
                                            'Quantity',
                                            'Amount'
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
                                                Buying Price
                                            </th>
                                            <th
                                                class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-center">
                                                Quantity
                                            </th>
                                            <th
                                                class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-left">
                                                Amount
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody class="text-sm font-normal text-paraColor font-poppins">
                                        @forelse($purchase->purchaseProducts as $purchaseData)
                                            @php
                                                $product = \App\Models\Product::find($purchaseData->product_id);
                                            @endphp
                                            <tr class="bg-white border-b ">
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
                                                <td class="px-6 py-4 whitespace-nowrap text-primary">
                                                    {{ number_format($purchaseData->buying_price) }}

                                                </td>

                                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                                    {{ number_format($purchaseData->purchase_quantity) }}

                                                </td>
                                                <td class="py-4 whitespace-nowrap text-primary">
                                                    {{ number_format($purchaseData->purchase_quantity * $purchaseData->buying_price) ?? '-' }}
                                                </td>

                                            </tr>
                                        @empty
                                            @include('layouts.not-found', ['colSpan' => 9])
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>

                        </div>


                    </div>
                </div>
            </div>
            {{-- purchase information end --}}


            {{-- .............  --}}


            <div class="flex justify-center gap-4">
                <a href="{{ route('purchase') }}"
                    class="bg-noti text-white font-jakarta font-semibold mt-10 px-20 py-2 rounded-full">Back</a>
            </div>

        </div>
        {{-- main end  --}}

    </section>
@endsection
@section('script')

@endsection
