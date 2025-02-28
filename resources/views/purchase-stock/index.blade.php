@extends('layouts.master')
@section('title', 'Add Purchase Stock')
@section('mainTitle', 'Add Purchase Stock')

@section('css')
@endsection

@section('content')
    <div class=" ">

        <div class="">
            {{-- search start --}}
            {{-- <x-search-com routeName="product-purchase-stock-histories" name="Histories" permissionName="product-purchase-stock-histories" /> --}}
            <x-search-com routeName="product-purchase-stock-histories" name="Histories List"
                permissionName="product-purchase-stock-histories" />
            {{-- search end  --}}

        </div>


        {{-- table start --}}
        <div class="data-table">
            <div class=" ml-[20px] bg-white px-4 py-3 rounded-[20px]  md:ml-[270px] my-5 mr-[20px] 2xl:ml-[320px]">
                <div class="flex items-center justify-between">
                    <h1 class="text-[#999999] font-poppins text-sm">Number of Purchases needed to be added :
                        <span class="showTotal text-primary">
                            {{ $purchases->count() }}
                        </span>

                    </h1>
                </div>
                <div>

                    <div class="relative overflow-x-auto h-[400px] shadow-lg  mt-3">
                        <table class="w-full    ">
                            <thead class="text-sm sticky top-0 z-10 font-jakarta  text-primary  bg-gray-50 ">
                                {{-- <x-table-head-component :columns="[
                                        'Invoice Number',
                                        'Purchase Date',
                                        'Products',
                                        'Quantity',
                                        'Action',
                                ]" /> --}}
                                <tr class="text-left border-b">
                                    <th
                                        class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-left">
                                        Invoice Number
                                    </th>
                                    <th
                                        class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-left">
                                        Purchase Date
                                    </th>
                                    <th
                                        class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-center">
                                        Products
                                    </th>
                                    <th
                                        class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-center">
                                        Quantity
                                    </th>
                                    <th
                                        class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-center">
                                        Action
                                    </th>
                                </tr>
                            </thead>
                            <tbody id="searchResults"
                                class="font-normal animate__animated animate__slideInUp font-poppins text-[13px] text-paraColor">
                                @include('purchase-stock.search')
                            </tbody>
                        </table>
                    </div>
                    {{ $purchases->links('layouts.paginator') }}

                </div>
            </div>
        </div>
        {{-- table end  --}}
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            var searchRoute = "{{ route('product-purchase-stock-list') }}";
            executeSearch(searchRoute)
        });

        // function changeStatus(id) {
        //     alert(id)
        // }
    </script>
@endsection
