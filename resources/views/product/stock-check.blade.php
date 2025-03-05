@extends('layouts.master')
@section('title', 'Product Stocks')
@section('mainTitle', 'Product Stocks')
@section('css')

@endsection

@section('content')
    <section class="stock-check">
        <div>
            {{-- search start --}}
            {{-- <x-search-com routeName=""  name="" /> --}}
            {{-- search end  --}}

            {{-- table --}}
            <div class="dat-table font-jakarta md:ml-[270px] my-5 mr-[20px] 2xl:ml-[320px] ml-[20px] ">
                <div class="  bg-white px-4 py-3 rounded-[20px] my-5 ">

                    <div class="flex items-center justify-between">
                        <h1 class="text-[#999999] font-poppins text-sm">Number of Locations : <span
                                class="showTotal text-primary">{{ $stocks->count() }}</span></h1>
                        <h1 class="text-noti font-poppins font-semibold text-md">{{ $product->name }} Stocks</h1>
                    </div>

                    <div>

                        <div class=" -z-10 overflow-x-auto shadow-xl mt-3">
                            <table class="w-full text-center text-md text-gray-500 ">
                                <thead class="text-sm text-primary text-center bg-gray-50 ">
                                    {{-- <x-table-head-component :columns="[
                                            'Location Name',
                                            'Quantity',
                                            ]" /> --}}
                                    <tr class="text-left border-b">
                                        <th
                                            class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-left">
                                            Location Name
                                        </th>
                                        <th
                                            class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-center">
                                            Quantity
                                        </th>
                                    </tr>
                                </thead>
                                <tbody id="searchResults"
                                    class="text-sm animate__animated animate__slideInUp font-normal text-paraColor font-poppins">
                                    @include('product.location-search')
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="flex justify-center">
                    <a href="{{ route('product-detail', ['product' => $product->id]) }}"
                        class="bg-noti text-white font-jakarta px-7 py-3 text-md rounded-full mt-3">Back</a>
                </div>
            </div>

            {{-- table end  --}}

        </div>
    </section>
@endsection

@section('script')
    {{-- search --}}
    <script>
        // $(document).ready(function() {
        //     var searchRoute = "{{ route('stock-check-list') }}";

        //     executeSearch(searchRoute)
        // });
    </script>
@endsection
