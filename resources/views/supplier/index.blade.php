@extends('layouts.master')
@section('title', 'Supplier List')
@section('mainTitle', 'Supplier Lists')

@section('css')


@endsection

@section('content')

    <section class="supplier">


        {{-- card start  --}}
        <div class="card ml-[20px]   md:ml-[270px] my-5 mr-[20px] grid grid-cols-1 xl:grid-cols-5 gap-5 2xl:ml-   [320px]">

            <!-- first card -->
            <div class="bg-white rounded-[20px] col-span-1 xl:col-span-3 grid grid-cols-1 lg:grid-cols-7 ">
                <div class="col-span-1 lg:col-span-2 text-center mt-4 ml-2">
                    <h1 class="font-medium text-base mb-2 font-jakarta text-primary text-center">Popular Supplier</h1>
                    <div>
                        <img src="{{ asset('images/supplier1.png') }}" class="mx-auto " alt="">
                    </div>
                </div>
                <div class="col-span-1  lg:col-span-5 mb-4 px-4 mt-6">
                    <div class="supplier-table  font-jakarta border-l">
                        <table class="w-full">
                            <thead class="border-b">
                                <tr>
                                    <th class="px-2 py-3 font-medium text-sm">Name</th>
                                    <th class="px-2 py-3 font-medium text-sm">Phone Number</th>
                                    <th class="px-2 py-3 font-medium text-sm">Action</th>
                                </tr>
                            </thead>
                            <tbody class="text-[#5C5C5C]">
                                @forelse($popular_suppliers as $p_supplier)
                                    <tr class="border-b ">
                                        <th class="px-1 py-3 font-normal text-[13px] ">{{ $p_supplier->name }}</th>
                                        <th class="px-1 py-3 font-normal text-[13px]">{{ $p_supplier->phone }}</th>
                                        <th>
                                            <button
                                                class="bg-primary text-white px-3 rounded-full py-1 text-[13px]">Purchase
                                                Now</button>
                                        </th>
                                    </tr>
                                @empty
                                    <tr class="border-b ">
                                        <th class="px-1 py-3 font-normal text-[13px]" colspan="3">No Data</th>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- second card -->
            <div class="bg-white rounded-[20px] col-span-1 xl:col-span-2 px-4 py-2 gap-3  ">
                <h1 class="font-medium text-base mb-2 font-jakarta text-primary ">New Suppliers</h1>
                <div class="supplier-table  font-jakarta ">
                    <table class="w-full">
                        <thead class="border-y">
                            <tr>

                                <th class="px-2 py-3 font-medium text-sm">Name</th>
                                <th class="px-2 py-3 font-medium text-sm">Phone Number</th>
                                <th class="px-2 py-3 font-medium text-sm">Country</th>
                            </tr>
                        </thead>
                        <tbody class="text-[#5C5C5C]">
                            @forelse($new_suppliers as $n_supplier)
                                <tr class="border-b ">
                                    <th class="px-1 py-3 font-normal text-[13px] ">{{ $n_supplier->name }}</th>
                                    <th class="px-1 py-3 font-normal text-[13px]">{{ $n_supplier->phone }}</th>
                                    <th class="px-1 py-3 font-normal text-[13px]">{{ $n_supplier->country?->name }}</th>
                                </tr>
                            @empty
                                <tr class="border-b ">
                                    <th class="px-1 py-3 font-normal text-[13px]" colspan="3"> No Data</th>

                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
        {{-- card end --}}

        {{-- .............. --}}

        {{-- table start --}}
        <div class="data-table">
            <div class=" ml-[20px] bg-white px-4 py-3 rounded-[20px]  md:ml-[270px] my-5 mr-[20px] 2xl:ml-[320px]">
                <div class="flex items-center  justify-between">
                    <div class="flex items-center gap-3">

                        <h1 class="text-[#999999] font-poppins text-sm">{{ $total_count }} suppliers are found</h1>

                        <x-add-button routeName="supplier-create" text="Supplier" permissionName="supplier-create" />

                    </div>
                    <a href="{{ route('supplier-list') }}">
                        <h1 class="text-xs py-[2px] font-jakarta bg-noti text-white px-3 rounded-full">See More</h1>

                        {{-- <h1 class="text-noti font-poppins font-medium text-xs">See more</h1> --}}
                    </a>
                </div>
                <div>

                    <div class="relative overflow-x-auto h-[450px]  shadow-lg mt-3">
                        <table class="w-full  text-center  ">

                            <thead class="text-sm sticky top-0  z-10  text-primary font-jakarta  bg-gray-50  ">

                                {{-- <x-table-head-component :columns="[
                                            'Supplier Name',
                                            'Country',
                                            'Phone Number',
                                            'Date',
                                            'Action',
                                        ]" /> --}}
                                <tr class="text-left border-b">
                                    <th
                                        class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-left">
                                        Supplier Name
                                    </th>
                                    <th
                                        class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-left">
                                        Country
                                    </th>
                                    <th
                                        class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-left">
                                        Phone Number
                                    </th>
                                    <th
                                        class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-left">
                                        Date
                                    </th>
                                    <th
                                        class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-center">
                                        Action
                                    </th>
                                </tr>
                            </thead>
                            <tbody id="searchResults" class="text-sm  text-paraColor font-poppins">
                                @include('supplier.search')
                        </table>
                    </div>

                </div>

    </section>

@endsection

@section('script')

@endsection
