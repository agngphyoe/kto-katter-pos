@extends('layouts.master')
@section('title', 'Stocks Check')
@section('mainTitle', 'Stocks Check')
@section('css')

@endsection

@section('content')
    <section class="stock-check">
        <div>
            {{-- search start --}}
            <x-search-com routeName="" name="" />
            {{-- search end  --}}

            {{-- table --}}
            <div class="dat-table font-jakarta md:ml-[270px] my-5 mr-[20px] 2xl:ml-[320px] ml-[20px] ">
                <div class="  bg-white px-4 py-3 rounded-[20px]     my-5 ">

                    <div class="flex items-center justify-between">
                        <h1 class="text-[#999999] font-poppins text-sm">Search Result: <span
                                class="showTotal text-primary">0</span></h1>
                        <h1 class="text-[#999999] font-poppins text-sm">Number of Locations : <span
                                class="text-primary">{{ $locations->count() }}</span></h1>
                    </div>

                    <div>

                        <div class=" -z-10 overflow-x-auto shadow-xl mt-3">
                            <table class="w-full text-center text-md text-gray-500 ">
                                <thead class="text-sm text-primary text-center bg-gray-50 ">
                                    {{-- <x-table-head-component :columns="['Location Name', 'Products', 'Total Quantities', 'Action']" /> --}}
                                    <tr class="text-left border-b">
                                        <th
                                            class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-left">
                                            Location Name
                                        </th>
                                        <th
                                            class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-center">
                                            Products
                                        </th>
                                        <th
                                            class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-center">
                                            Total Quantity
                                        </th>
                                        <th
                                            class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-right">
                                            Total Selling Price
                                        </th>
                                        <th
                                            class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-center">
                                            Action
                                        </th>
                                    </tr>
                                </thead>
                                <tbody id="searchResults"
                                    class="text-sm animate__animated animate__slideInUp font-normal text-paraColor font-poppins">
                                    @include('stock-check.location-search')
                                </tbody>
                            </table>
                        </div>
                        {{ $locations->links('layouts.paginator') }}
                    </div>

                </div>
            </div>

            {{-- table end  --}}

        </div>
    </section>
@endsection

@section('script')
    {{-- search --}}
    <script>
        $(document).ready(function() {
            var searchRoute = "{{ route('stock-check-list') }}";

            executeSearch(searchRoute)
        });
    </script>
@endsection
