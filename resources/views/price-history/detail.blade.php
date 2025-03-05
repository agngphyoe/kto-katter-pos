@extends('layouts.master-without-nav')
@section('title', 'Product Price History Details')
@section('css')

@endsection

@section('content')
    <section class="Product_Price_History_Detail">
        {{-- nav start  --}}
        @include('layouts.header-section', [
            'title' => 'Product Price History Details',
            'subTitle' => 'Details of Product Price History',
        ])
        {{-- nav end  --}}


        {{-- ..........  --}}

        {{-- main start  --}}
        <div class="lg:mx-[30px] mx-[10px] my-[10px] lg:my-[20px]">
            {{-- ........  --}}
            {{-- purchase information start  --}}
            <div class="bg-white p-5 rounded-[20px] mt-5">
                {{-- <x-infor-com title="Purchase Information" :data="$purchase" /> --}}
                <x-title-com title="" count="Total Products : {{ $product_price_histories->count() }} " />

                <div class="data-table">
                    <div class="bg-white px-1 py-2 font-poppins rounded-[20px]  ">
                        <div>
                            <div class="relative overflow-x-auto mt-3 shadow-lg">
                                <table class="w-full text-sm text-center text-gray-500 ">
                                    <thead class="text-sm text-primary bg-gray-50  font-medium font-poppins   ">

                                        {{-- <x-table-head-component :columns="[
                                            'Product Name',
                                            'Product Code',
                                            'Old Retail Price',
                                            'New Retail Price',
                                            'Updated Time',
                                        ]" /> --}}
                                        <tr class="text-left border-b">
                                            <th
                                                class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-left">
                                                Product Name
                                            </th>
                                            <th
                                                class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-left">
                                                Product Code
                                            </th>
                                            <th
                                                class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-right">
                                                Old Retail Price
                                            </th>
                                            <th
                                                class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-right">
                                                New Retail Price
                                            </th>
                                            <th
                                                class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-left">
                                                Updated Time
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody class="text-sm font-normal text-paraColor font-poppins">
                                        @forelse ($product_price_histories as $product_price_history)
                                            <tr class="bg-white border-b  text-left font-poppins">
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    {{ $product_price_history->product->name ?? '-' }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    {{ $product_price_history->product->code ?? '-' }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap text-right" style="color: red">
                                                    {{ number_format($product_price_history->old_retail_price) ?? '-' }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-right" style="color: blue">
                                                    {{ number_format($product_price_history->new_retail_price) ?? '-' }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    {{ dateFormat($product_price_history->created_at) }}
                                                    {{ timeFormat($product_price_history->created_at) }}
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


            {{-- .............  --}}

        </div>
        {{-- main end  --}}

    </section>
@endsection
@section('script')

@endsection
