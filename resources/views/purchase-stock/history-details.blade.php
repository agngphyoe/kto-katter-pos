@extends('layouts.master-without-nav')
@section('title', 'Purchase Details')

@section('css')

@endsection

@section('content')
    <section class="Transfer__Detail">
        {{-- nav start  --}}
        @include('layouts.header-section', [
            'title' => 'Transfer Details',
            'subTitle' => 'Details of Transfer',
        ])
        {{-- nav end  --}}


        {{-- ..........  --}}

        {{-- main start  --}}
        <div class="lg:mx-[30px] mx-[10px] my-[10px] lg:my-[20px]">
            <div class="bg-white rounded-[25px]">
                <div>
                    <br>
                    <h1 class="text-noti  font-jakarta font-semibold text-center mt-5">Transfer Details</h1>
                    <div class="flex items-center justify-between flex-wrap gap-2 p-5">
                        <x-information title="Purchase No." subtitle="{{ $purchase->invoice_number ?? '-' }}" />
                        <x-information title="Transfer To" subtitle="{{ $transfer->location->location_name ?? '-' }}" />
                        {{-- <x-information title="Quantity" subtitle="{{$transfer->quantity ?? '-'}}" /> --}}
                        <div>
                            <h1 class="text-primary font-poppins text-center text-sm mb-2 font-semibold">Quantity </h1>
                            <h1 class="text-paraColor font-poppins text-[13px] text-center whitespace-nowrap">
                                {{ $transfer->quantity ?? '-' }}
                            </h1>
                        </div>
                        <x-information title="Date" subtitle="{{ dateFormat($transfer->added_date) ?? '-' }}" />

                    </div>
                    <br>
                </div>
            </div>
            {{-- ........  --}}
            {{-- purchase information start  --}}
            <div class="bg-white p-5 rounded-[20px] mt-5">
                <div class="data-table">
                    <div class="bg-white px-1 py-2 font-poppins rounded-[20px]  ">
                        <div>
                            <div class="relative overflow-x-auto mt-3 shadow-lg">
                                <table class="w-full text-sm text-center text-gray-500 ">
                                    <thead class="text-sm text-primary bg-gray-50  font-medium font-poppins   ">

                                        {{-- <x-table-head-component :columns="[
                                            'Product Name (ID)',
                                            'Categories',
                                            'Brand',
                                            'Model',
                                            'Design',
                                            'Type',
                                        ]" /> --}}
                                        <tr class="text-left border-b">
                                            <th
                                                class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap    py-3">
                                                Product Name (ID)
                                            </th>
                                            <th
                                                class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap    py-3">
                                                Categories
                                            </th>
                                            <th
                                                class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap    py-3">
                                                Brand
                                            </th>
                                            <th
                                                class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap    py-3">
                                                Model
                                            </th>
                                            <th
                                                class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap    py-3">
                                                Type
                                            </th>
                                            <th
                                                class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap    py-3">
                                                Design
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody class="text-sm font-normal text-paraColor font-poppins">
                                        @forelse($purchase->purchaseProducts as $product)
                                            <tr class="bg-white border-b text-left">
                                                <th scope="row"
                                                    class="px-6 py-4 whitespace-nowrap font-medium  text-gray-900 whitespace-nowrap ">
                                                    <div class="flex items-center gap-2">

                                                        @if ($transfer->product?->image)
                                                            <img src="{{ asset('products/image/' . $transfer->product->image) }}"
                                                                class="w-10 h-10 object-cover">
                                                        @else
                                                            <img src="{{ asset('images/no-image.png') }}"
                                                                class="w-10 h-10 object-cover">
                                                        @endif


                                                        <h1 class="text-[#5C5C5C] font-medium  ">
                                                            {{ $transfer->product?->name }} <span
                                                                class="text-noti ">({{ $transfer->product?->code }})</span>
                                                        </h1>
                                                    </div>
                                                </th>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    {{ $transfer->product?->category?->name }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-noti">
                                                    {{ $transfer->product?->brand?->name }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    {{ $transfer->product?->productModel?->name }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    {{ $transfer->product->type->name ?? '-' }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    {{ $transfer->product->design->name ?? '-' }}
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
            </div>
            {{-- purchase information end --}}

        </div>
        {{-- main end  --}}

    </section>
@endsection

@section('script')

@endsection
