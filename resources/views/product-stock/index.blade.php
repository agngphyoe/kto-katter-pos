@extends('layouts.master')
@section('title', 'Product Stock Adjustments')
@section('mainTitle', 'Product Stock Adjustments List')

@section('css')
    <style>
        .icon-container {
            position: relative;
            /* display: inline-block; */
        }

        .hover-icons {
            position: absolute;
            top: 50%;
            left: 20px;
            transform: translateY(-50%);

            opacity: 0;
            transition: opacity 0.3s, left 0.3s;
        }

        .icon-container:hover .hover-icons {
            opacity: 1;
            left: 30px;
        }
    </style>
@endsection
@section('content')
    <section class="product__stock">
        <x-search-com routeName="product-stock-choose-location" exportName="product_stocks" name="Create Adjustment"
            permissionName="product-adjustment-create" />

        <div class="md:ml-[270px] ml-[20px] font-jakarta my-5 mr-[20px] 2xl:ml-[320px]">
            {{-- table start --}}
            <div class="data-table mt-5">
                <div class="  bg-white px-4 py-2 font-poppins rounded-[20px]  ">

                    <div>
                        <div class=" overflow-x-auto mt-3 shadow-lg">
                            <table class="w-full text-sm  text-gray-500 ">
                                <thead class="  bg-gray-50  font-jakarta text-primary  ">
                                    {{-- <x-table-head-component :columns="[
                                            'Remark',
                                            'Location',
                                            'Quantity',
                                            'Action By',
                                            'Adjustment Date',
                                            'Actions',
                                        ]" /> --}}
                                    <tr class="text-left border-b">
                                        <th
                                            class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-left">
                                            Location
                                        </th>
                                        <th
                                            class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-center">
                                            Quantity
                                        </th>
                                        <th
                                            class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-left">
                                            Action By
                                        </th>
                                        <th
                                            class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-left">
                                            Adjustment Date
                                        </th>
                                        <th
                                            class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-left">
                                            Actions
                                        </th>
                                        <th
                                            class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-left">
                                            Remark
                                        </th>
                                    </tr>
                                </thead>
                                <tbody id="searchResults" class="text-[13px]">
                                    @include('product-stock.search')
                                </tbody>
                            </table>
                        </div>
                        {{ $stockAdjustments->links('layouts.paginator') }}
                    </div>


                </div>
            </div>
            {{-- table end  --}}

        </div>

    </section>
@endsection
@section('script')
    <script>
        clearLocalStorage();

        $(document).ready(function() {
            var searchRoute = "{{ route('product-stock') }}";

            executeSearch(searchRoute)
        });
    </script>
@endsection
