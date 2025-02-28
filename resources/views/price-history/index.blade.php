@extends('layouts.master')
@section('title', 'Product Price History')
@section('mainTitle', 'Product Price Histories List')

@section('css')

@endsection
@section('content')

    <section class="product-model  ">
        <div>
            {{-- search start --}}
            <x-search-com routeName="price-history-create-first" name="Create a Price Change"
                permissionName="product-price-history-create" />
            {{-- search end  --}}

        </div>

        {{-- table --}}
        <div class="dat-table font-jakarta md:ml-[270px] my-5 mr-[20px] 2xl:ml-[320px] ml-[20px] ">
            <div class="  bg-white px-4 py-3 rounded-[20px]     my-5 ">

                <div class="flex items-center justify-between">
                    <h1 class="text-[#999999] font-poppins text-sm">Search Result: <span
                            class="showTotal text-primary">0</span></h1>
                    <h1 class="text-[#999999] font-poppins text-sm">Number of Records : <span
                            class="text-primary">{{ $product_price_histories->count() }}</span></h1>
                </div>

                <div>

                    <div class=" -z-10 overflow-x-auto shadow-lg  mt-3">
                        <table class="w-full   text-gray-500 ">
                            <thead class="text-sm   text-primary  bg-gray-50 ">
                                {{-- <x-table-head-component :columns="['Created By', 'Created At', 'Action']" /> --}}
                                <tr class="text-left border-b">
                                    <th
                                        class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-left">
                                        Create By
                                    </th>
                                    <th
                                        class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-left">
                                        Create At
                                    </th>
                                    <th
                                        class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-center">
                                        Action
                                    </th>
                                </tr>
                            </thead>
                            <tbody id="searchResults" class="text-[13px]">
                                @include('price-history.search')
                            </tbody>
                        </table>
                        {{ $product_price_histories->links('layouts.paginator') }}
                    </div>

                </div>

            </div>
        </div>

        {{-- table end  --}}



    </section>
@endsection
@section('script')
    <script src="{{ asset('js/alertModelCreate.js') }}"></script>

    {{-- search --}}
    <script>
        $(document).ready(function() {
            clearLocalStorage();
            var searchRoute = "{{ route('price-history') }}";

            executeSearch(searchRoute);
        });
    </script>
@endsection
