@extends('layouts.master-without-nav')
@section('title', 'POS Order Details')
@section('css')

@endsection

@section('content')
    <section class="Purchase__Detail">
        {{-- nav start  --}}
        @include('layouts.header-section', [
            'title' => 'POS Order Details',
            'subTitle' => 'Details of POS Order',
        ])
        {{-- nav end  --}}


        {{-- ..........  --}}

        {{-- main start  --}}
        <div class="lg:mx-[30px] mx-[10px] my-[10px] lg:my-[20px]">
            <div class="bg-white rounded-[25px]">
                <div>
                    <img src="{{ asset('images/PurchaseDetail.png') }}" class="w-full " alt="">
                </div>
                <div>
                    <h1 class="text-noti font-jakarta font-semibold text-center mt-5">Customer Details</h1>
                    <div class="flex items-center justify-evenly flex-wrap gap-4 p-5">
                        <x-information title="Customer Name" subtitle="{{ $sale->shopper->name }}" />
                        <x-information title="Phone Number" subtitle="{{ $sale->shopper->phone }}" />
                        <x-information title="Address" subtitle="{{ $sale->shopper->address }}" />

                    </div>
                </div>
            </div>

            {{-- purchase information start  --}}
            <div class="bg-white p-5 rounded-[20px] mt-5">
                <x-infopos-com title="Sales Information" :data="$sale" />

                <x-title-com title="Products Information"
                    count="Total Quantity : {{ number_format($sale->origin_quantity) }} " />

                <div class="data-table">
                    <div class="bg-white px-1 py-2 font-poppins rounded-[20px]">
                        <div>
                            <div class="relative overflow-x-auto mt-3 shadow-lg">
                                <table class="w-full text-sm text-center text-gray-500">
                                    <thead class="text-sm text-primary bg-gray-50  font-medium font-poppins">

                                        {{-- <x-table-head-component :columns="[
                                            'Product Name (Code)',
                                            'Category',
                                            'Brand',
                                            'Model',
                                            'Design',
                                            'Type',
                                            'Unit Price',
                                            'Quantity',
                                            'Total Amount',
                                        ]" /> --}}
                                        <tr class="text-left border-b">
                                            <th
                                                class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-left">
                                                Product Name (Code)
                                            </th>
                                            <th
                                                class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-left">
                                                Category
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
                                                class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-right">
                                                Unit Price
                                            </th>
                                            <th
                                                class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-center">
                                                Quantity
                                            </th>
                                            <th
                                                class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-right">
                                                Total Amount
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody class="text-sm font-normal text-paraColor font-poppins text-center">
                                        @forelse($sale->pointOfSaleProducts as $data)
                                            @php
                                                $product = \App\Models\Product::find($data->product_id);
                                            @endphp
                                            <tr class="bg-white border-b text-left">
                                                <th scope="row"
                                                    class="px-6 py-4 whitespace-nowrap font-medium text-gray-900">
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
                                                    @if ($product->is_imei == 1)
                                                        <span class="text-[#5C5C5C] ml-5">{{ $data->imei }}</span>
                                                    @endif
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
                                                <td class="px-6 py-4 whitespace-nowrap text-right">
                                                    {{ number_format($data->unit_price) }}
                                                    @if ($data->is_promote == 1)
                                                        <span class="text-red-600 text-md"> *</span>
                                                    @endif
                                                </td>

                                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                                    {{ number_format($data->origin_quantity) }}

                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-right">
                                                    {{ number_format($data->origin_price) }}
                                                </td>

                                            </tr>
                                        @empty
                                            @include('layouts.not-found', ['colSpan' => 9])
                                        @endforelse
                                    </tbody>
                                </table>

                                <div class="mt-2 ml-3 mb-2 text-red-600">
                                    (*) Promotion Price
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @if ($saleReturn)
                    @php
                        $total_return_quantity = \App\Models\PosReturn::where('point_of_sale_id', $sale->id)->sum(
                            'total_return_quantity',
                        );
                    @endphp
                    <x-title-com title="Returns" count="Total Quantity : {{ $total_return_quantity }} " />

                    <div class="data-table">
                        <div class="bg-white px-1 py-2 font-poppins rounded-[20px]">
                            <div>
                                <div class="relative overflow-x-auto mt-3 shadow-lg">
                                    <table class="w-full text-sm text-center text-gray-500 ">
                                        <thead class="text-sm text-primary bg-gray-50  font-medium font-poppins">
                                            <tr class="text-left border-b">
                                                <th
                                                    class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-left">
                                                    Product Name (Code)
                                                </th>
                                                <th
                                                    class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-right">
                                                    Category
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
                                                    Return Type
                                                </th>
                                                <th
                                                    class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-center">
                                                    Returned Quantity
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody class="text-sm font-normal text-paraColor font-poppins">
                                            @forelse($saleReturn->posReturnProducts as $data)
                                                @php
                                                    $product = \App\Models\Product::find($data->product_id);
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


                                                            <h1 class="text-[#5C5C5C] font-medium  ">{{ $product->name }}
                                                                <span class="text-noti ">({{ $product->code }})</span>
                                                            </h1>
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
                                                        {{ ucfirst($data->return_type) }}

                                                    </td>

                                                    <td class="px-6 py-4 whitespace-nowrap">
                                                        {{ number_format($data->quantity) }}
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
                @endif

            </div>
            <div class=" mt-6 flex items-center justify-center flex-wrap gap-5">
                <a href="{{ url()->previous() }}">
                    <x-button-component class="outline outline-1 outline-noti text-noti" type="button">
                        Back
                    </x-button-component>
                </a>

            </div>
        </div>
        {{-- main end  --}}

    </section>
@endsection

@section('script')

@endsection
