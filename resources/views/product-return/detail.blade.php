@extends('layouts.master-without-nav')
@section('title', 'Product Return')
@section('css')

@endsection

@section('content')
    <section class="Transfer__Detail">
        {{-- nav start  --}}
        @include('layouts.header-section', [
            'title' => 'Return Details',
            'subTitle' => 'Details of Return',
        ])
        {{-- nav end  --}}


        {{-- ..........  --}}

        {{-- main start  --}}
        <div class="lg:mx-[30px] mx-[10px] my-[10px] lg:my-[20px]">
            <div class="bg-white rounded-[25px]">
                <div>
                    <br>
                    <h1 class="text-noti  font-jakarta font-semibold text-center mt-5">Return Details</h1>
                    <div class="flex items-center justify-between flex-wrap gap-3 p-5">
                        <x-information title="Return Code" subtitle="{{ $productReturn->return_inv_code ?? '-' }}" />
                        <x-information title="Remark" subtitle="{{ $productReturn->remark ?? '-' }}" />
                        <x-information title="From"
                            subtitle="{{ $productReturn->fromLocationName->location_name ?? '-' }}" />
                        <x-information title="To"
                            subtitle="{{ $productReturn->toLocationName->location_name ?? '-' }}" />
                        <x-information title="Returned By" subtitle="{{ $productReturn->user->name ?? '-' }}" />
                        <x-information title="Return Date" subtitle="{{ dateFormat($productReturn->created_at) ?? '-' }}" />
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
                                            'Returned',
                                            'Restored',
                                            'Status'
                                        ]" /> --}}
                                        <tr class="text-left border-b">
                                            <th
                                                class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-left">
                                                Product Name (ID)
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
                                                Design
                                            </th>
                                            <th
                                                class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-left">
                                                Type
                                            </th>
                                            <th
                                                class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-left">
                                                Returned
                                            </th>
                                            <th
                                                class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-left">
                                                Restored
                                            </th>
                                            <th
                                                class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-left">
                                                Status
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody class="text-sm font-normal text-paraColor font-poppins">
                                        @forelse($products as $product)
                                            <tr class="bg-white border-b text-left">
                                                <th scope="row"
                                                    class="px-6 py-4 whitespace-nowrap font-medium  text-gray-900">
                                                    <div class="flex items-center gap-2">

                                                        @if ($product->product?->image)
                                                            <img src="{{ asset('products/image/' . $product->product->image) }}"
                                                                class="w-10 h-10 object-cover">
                                                        @else
                                                            <img src="{{ asset('images/no-image.png') }}"
                                                                class="w-10 h-10 object-cover">
                                                        @endif


                                                        <h1 class="text-[#5C5C5C] font-medium  ">
                                                            {{ $product->product?->name }} <span
                                                                class="text-noti ">({{ $product->product?->code }})</span>
                                                        </h1>
                                                    </div>
                                                </th>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    {{ $product->product?->category?->name }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-noti">
                                                    {{ $product->product?->brand?->name }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    {{ $product->product?->productModel?->name }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    {{ $product->product?->design?->name ?? '-' }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    {{ $product->product?->type?->name ?? '-' }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    {{ number_format($product->quantity) }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    {{ number_format($product->stock_qty) }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    {{-- {{ $product->status }} --}}
                                                    @switch($product->status)
                                                        @case('active')
                                                            <x-badge class="bg-green-600 text-white px-2">
                                                                Received
                                                            </x-badge>
                                                        @break

                                                        @case('reject')
                                                            <x-badge class="bg-red-600 text-white px-2">
                                                                Rejected
                                                            </x-badge>
                                                        @break

                                                        @case('pending')
                                                            <x-badge class="bg-yellow-400 text-white px-2">
                                                                Pending
                                                            </x-badge>
                                                        @break

                                                        @case('partial')
                                                            <x-badge class="bg-gray-300 text-dark px-2">
                                                                Partial
                                                            </x-badge>
                                                        @break

                                                        @default
                                                    @endswitch
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
