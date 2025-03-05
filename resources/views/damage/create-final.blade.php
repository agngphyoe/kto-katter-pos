@extends('layouts.master-without-nav')
@section('title', 'Damage Create')
@section('css')

@endsection
@section('content')
    <section class="damage__create__final">
        {{-- nav start  --}}
        @include('layouts.header-section', [
            'title' => 'Add New Damage',
            'subTitle' => '',
        ])
        {{-- nav end  --}}

        <div class="lg:mx-[30px] m-5 lg:my-[30px]">
            <div class="bg-white shadow-xl mb-[30px] rounded-[20px] p-4 sm:p-10 font-poppins">
                <div class="flex items-center justify-around flex-wrap gap-4">
                    <x-information title="Remarks" subtitle="{{ $damage_details['remark'] ?? '-' }}" />
                    <x-information title="Date" subtitle="{{ dateFormat($damage_details['damage_date']) }}" />
                    <x-information title="Location" subtitle="{{ $location->location_name }}" />
                    <x-information title="Created By" subtitle="{{ $damage_details['created_by'] }}" />
                    <x-information title="Total Quantity"
                        subtitle="{{ number_format($damage_details['total_quantity']) }}" />
                    {{-- <x-information title="Total Amount" subtitle="{{ number_format($damage_details['total_amount']) }}" /> --}}

                </div>
            </div>

            {{-- table start  --}}
            <div class="data-table mt-5">
                <div class="  bg-white px-4 py-2 font-poppins rounded-[20px]  ">
                    <div>
                        <div class="relative overflow-y-auto  overflow-x-auto  shadow-lg ">
                            <table class="w-full text-sm   text-gray-500 ">
                                <thead class="  bg-gray-50  font-jakarta text-primary  ">
                                    {{-- <x-table-head-component :columns="[
                                        'Product Name',
                                        'Categories',
                                        'Brand',
                                        'Model',
                                        'Design',
                                        'Type',
                                        'Damage Quantity',
                                        // 'Damage Amount'
                                    ]" /> --}}
                                    <tr class="text-left border-b">
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
                                            Design
                                        </th>
                                        <th
                                            class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-left">
                                            Type
                                        </th>
                                        <th
                                            class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-left">
                                            Damage Quantity
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="font-poppins text-[13px]">
                                    @forelse($damage_products as $damage_product)
                                        @php
                                            $product = App\Models\Product::find($damage_product['id']);
                                        @endphp
                                        <tr class="bg-white border-b text-left ">
                                            <th scope="row" class="pl-6 py-2 font-medium  whitespace-nowrap ">

                                                <div class="flex items-center gap-3">
                                                    <div>
                                                        @if ($product->image)
                                                            <img src="{{ asset('products/image/' . $product->image) }}"
                                                                class="w-12 h-12  object-contain" alt="">
                                                        @else
                                                            <img src="{{ asset('images/no-image.png') }}" class="w-12 h-12 "
                                                                alt="">
                                                        @endif
                                                    </div>
                                                    <h1 class="text-paraColor">{{ $product->name }} <span
                                                            class="text-noti">({{ $product->code }})</span></h1>
                                                </div>
                                            </th>
                                            <td class="px-6 py-3 whitespace-nowrap">
                                                {{ $product->category?->name }}
                                            </td>
                                            <td class="px-6 py-3 whitespace-nowrap">
                                                {{ $product->brand?->name }}

                                            </td>
                                            <td class="px-6 py-3 whitespace-nowrap">
                                                {{ $product->productModel?->name }}

                                            </td>
                                            <td class="px-6 py-3 whitespace-nowrap">
                                                {{ $product->design?->name ?? '-' }}

                                            </td>
                                            <td class="px-6 py-3 whitespace-nowrap">
                                                {{ $product->type?->name ?? '-' }}
                                            </td>

                                            {{-- <td class="pl-6 pr-6  py-3 whitespace-nowrap text-right  ">
                                        {{ number_format($product->quantity) }}

                                    </td>
                                    <td class="pl-6 pr-6  py-3 whitespace-nowrap  text-right ">
                                        {{ number_format($product->price) }}
                                    </td> --}}

                                            <td class="px-6 py-3 whitespace-nowrap text-center">
                                                {{ number_format($damage_product['new_quantity']) }}
                                            </td>
                                            {{-- <td class="pl-6 pr-6  py-3 whitespace-nowrap text-right">
                                        {{ number_format($damage_product['wholesale_sell_price'] * $damage_product['new_quantity']) }}
                                    </td> --}}
                                        </tr>
                                    @empty
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                    </div>


                </div>
            </div>

            <form method="post" action="{{ route('damage-product-store') }}">
                @csrf
                <input type="hidden" name="damage_info" value="{{ json_encode($damage_details) }}">
                <input type="hidden" name="damage_products" value="{{ json_encode($damage_products) }}">
                <input type="hidden" name="location_id" value="{{ $location->id }}">

                <div class=" mt-6 flex items-center justify-center flex-wrap gap-5">
                    <a href="{{ url()->previous() }}">
                        <x-button-component class="outline outline-1 outline-noti text-noti" type="button">
                            Cancel
                        </x-button-component>
                    </a>

                    <x-button-component class="bg-noti text-white" type="submit">
                        Done
                    </x-button-component>

                </div>
            </form>
        </div>
    </section>
@endsection
@section('script')

@endsection
