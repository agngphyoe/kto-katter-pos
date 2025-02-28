@extends('layouts.master')
@section('title', 'Add Purchase Stock Histories')
@section('mainTitle', 'Add Purchase Stock Histories')

@section('css')
@endsection

@section('content')
    <div class=" ">

        <div class="">
            {{-- search start --}}
            <x-search-com routeName="product-purchase-stock-histories" name="Histories" />
            {{-- <x-search-com routeName="" name="" permissionName="" /> --}}
            {{-- search end  --}}

        </div>


        {{-- table start --}}
        <div class="data-table">
            <div class=" ml-[20px] bg-white px-4 py-3 rounded-[20px]  md:ml-[270px] my-5 mr-[20px] 2xl:ml-[320px]">
                <div class="flex items-center justify-between">
                    <h1 class="text-[#999999] font-poppins text-sm">Number of Distributions :
                        <span class="showTotal text-primary">
                            {{ $total_count }}
                        </span>

                    </h1>
                </div>
                <div>

                    <div class="relative overflow-x-auto h-[400px] shadow-lg  mt-3">
                        <table class="w-full    ">
                            <thead class="text-sm sticky top-0 z-10 font-jakarta  text-primary  bg-gray-50 ">
                                {{-- <x-table-head-component :columns="[
                    'Product',
                    'Purchase Number',
                    'Store',
                    'Quantity',
                    'Date',
                    // 'Action',
                ]" /> --}}
                                <tr class="text-left border-b">
                                    <th class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap    py-3">
                                        Product
                                    </th>
                                    <th class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap    py-3">
                                        Purchase Number
                                    </th>
                                    <th class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap    py-3">
                                        Store
                                    </th>
                                    <th
                                        class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap text-center   py-3">
                                        Quantity
                                    </th>
                                    <th class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap    py-3">
                                        Date
                                    </th>
                                </tr>
                            </thead>
                            <tbody id="searchResults"
                                class="font-normal animate__animated animate__slideInUp font-poppins text-[13px] text-paraColor">
                                @include('purchase-stock.history-search')
                            </tbody>
                        </table>
                    </div>
                    {{ $transfers->links('layouts.paginator') }}

                </div>
            </div>
        </div>
        {{-- table end  --}}
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            var searchRoute = "{{ route('product-purchase-stock-histories') }}";
            executeSearch(searchRoute)
        });
    </script>
@endsection
