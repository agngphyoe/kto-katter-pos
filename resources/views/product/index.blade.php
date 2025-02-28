    @extends('layouts.master')
    @section('title', 'Product')
    @section('mainTitle', 'Product Lists')

    @section('css')

    @endsection
    @section('content')


        {{-- card start  --}}
        <div class="card ml-[20px]   md:ml-[270px] my-5 mr-[20px] grid grid-cols-1 xl:grid-cols-2 gap-5 2xl:ml-[320px]">

            <!-- first card -->
            <div class="bg-white -z-10 shadow-lg rounded-[20px] grid grid-cols-1 lg:grid-cols-7 gap-2">
                <div class="col-span-1 lg:col-span-2">
                    <div class="mt-5">
                        <img src="{{ asset('images/girl-shop.png') }}" class="mx-auto h-full lg:mx-0" alt="">
                    </div>
                </div>
                <div class="col-span-1 lg:col-span-5 mb-4 px-4">
                    <h1 class="text-headColor text-center font-poppins font-semibold text-[16px] my-5">Your Popular Products
                    </h1>
                    <div class="grid grid-cols-3 gap-3 ">
                        {{-- --}}
                        @foreach ($popular_products as $popular_product)
                            <div class=" relative xl:h-32  shadow-md rounded-2xl overflow-hidden ">
                                <div>
                                    <img src="{{ asset('products/image/' . $popular_product->image) }}"
                                        class="h-32 object-contain mx-auto" alt="">
                                </div>
                                <h1
                                    class="w-full bg-white text-center text-primary absolute h-10 2xl:h-14 bottom-0 overflow-hidden rounded-b-[15px] 2xl:rounded-b-[20px] font-jakarta font-normal text-[13px] flex items-center justify-center">
                                    {{ $popular_product->code }}
                                </h1>
                            </div>
                        @endforeach

                    </div>
                </div>
            </div>
            <!-- second card -->
            <div class="bg-white shadow-lg rounded-[20px] px-4 gap-3  ">
                <div class="flex items-center justify-between mt-5 mb-2">
                    <h1 class="text-headColor  font-poppins font-semibold text-base  ">Your Popular Products</h1>
                    <h1 class="text-noti font-poppins font-medium text-xs cursor-pointer">See More</h1>
                </div>
                @foreach ($popular_products as $popular_product)
                    <div class="flex items-center justify-between mb-2 2xl:mb-3">
                        <div class="flex items-center gap-2">
                            <img src="{{ asset('products/image/' . $popular_product->image) }}"
                                class="w-14 h-14 object-contain " alt="">
                            <h1 class="text-[#5C5C5C] font-medium font-poppins text-sm "><span
                                    class="text-noti ">{{ $popular_product->code }}</span>
                            </h1>
                        </div>
                        <h1 class="text-[#5C5C5C] font-poppins text-sm font-medium ">{{ $popular_product->category->name }}
                        </h1>
                        <button
                            class="border font-poppins cursor-default border-primary text-primary  rounded-full px-3 font-semibold   text-xs ">{{ $popular_product->quantity }}</button>
                    </div>
                @endforeach
            </div>
        </div>
        {{-- card end  --}}



        {{-- table start --}}
        <div class="data-table md:ml-[270px] my-5 mr-[20px] 2xl:ml-[320px] ml-[20px] ">
            <div class=" bg-white px-4 py-3 rounded-[20px]  ">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">

                        <h1 class="text-[#999999] font-poppins text-sm">{{ $products->count() }} products are found</h1>

                        <x-add-button routeName="product-create" text="Product" permissionName="product-create" 5 />
                    </div>
                    <a href="{{ route('product-list') }}">
                        <h1 class="text-xs py-[2px] bg-noti text-white font-jakarta px-3 rounded-full">See More</h1>

                        {{-- <h1 class="text-noti font-poppins font-medium text-xs">See more</h1> --}}
                    </a>
                </div>
                <div>

                    <div class=" overflow-x-auto mt-3 h-[450px] shadow-lg">
                        <table class="w-full    text-center ">
                            <thead class=" text-sm sticky top-0 z-10     text-primary  bg-gray-50 font-jakarta   ">

                                {{-- <x-table-head-component :columns="[
                                    'Product Code',
                                    'Product Name',
                                    'Categories',
                                    'Brand',
                                    'Model',
                                    'Type',
                                    'Design',
                                    'Quantity',
                                    'Retail Price',
                                    'Wholesale Price',
                                    'Created By',
                                    'Created At',
                                    'Action',
                                    ]" /> --}}
                                <tr class="text-left border-b">
                                    <th
                                        class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-left">
                                        Product Code
                                    </th>
                                    <th
                                        class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-left">
                                        Product Name
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
                                        Type
                                    </th>
                                    <th
                                        class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-left">
                                        Design
                                    </th>
                                    <th
                                        class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-center">
                                        Quantity
                                    </th>
                                    <th
                                        class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-right">
                                        Retail Price
                                    </th>
                                    <th
                                        class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-right">
                                        Wholesale Price
                                    </th>
                                    <th
                                        class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-left">
                                        Created By
                                    </th>
                                    <th
                                        class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-left">
                                        Created At
                                    </th>
                                    <th
                                        class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-center">
                                        Action
                                    </th>
                                </tr>
                            </thead>
                            <tbody id="searchResults" class="font-normal font-poppins text-sm text-paraColor">
                                @include('product.search')
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
        {{-- table end  --}}




    @endsection
    @section('script')

        {{-- <script src="{{ asset('js/mySelect.js') }}"></script> --}}
        {{-- <script src="{{ asset('js/dateRangePicker.js') }}"></script> --}}

        {{-- search --}}
        <script>
            $(document).ready(function() {
                var searchRoute = "{{ route('product') }}";

                executeSearch(searchRoute)
            });
        </script>

    @endsection
