@extends('layouts.master-without-nav')
@section('title', 'Damage Details')
@section('css')

@endsection
@section('content')
    <section class="create__detail">
        {{-- nav start  --}}
        @include('layouts.header-section', [
            'title' => 'Damage Detail',
            'subTitle' => '',
        ])
        {{-- nav end  --}}
        <div class="lg:mx-[30px] mx-[10px] my-[10px] lg:my-[30px]" id="myContent">
            <div class="bg-white shadow-xl mb-[30px] rounded-[20px] px-4 py-4 font-poppins">


                <div class="flex items-center justify-around flex-wrap  gap-4">
                    <x-information title="Remarks" subtitle="{{ $damage->remark ?? '-' }}" />
                    <x-information title="Date" subtitle="{{ dateFormat($damage->damage_date) }}" />
                    <x-information title="Location" subtitle="{{ $damage->location->location_name }}" />
                    <x-information title="Created By" subtitle="{{ $damage->user?->name }}" />
                    {{-- <x-information title="Total Quantity" subtitle="{{ number_format($damage->total_quantity) }}" /> --}}
                    <div>
                        <h1 class="text-primary font-poppins text-center text-sm mb-2 font-semibold">Total Quantity </h1>
                        <h1 class="text-paraColor font-poppins text-[13px] text-center whitespace-nowrap">
                            {{ number_format($damage->total_quantity) }}
                        </h1>
                    </div>
                    {{-- <x-information title="Total Amount" subtitle="{{ number_format($damage->total_amount) }} " /> --}}

                </div>
            </div>

            {{-- table start  --}}
            <div class="data-table mt-5">
                <div class="  bg-white px-4 py-2 font-poppins rounded-[20px]  ">
                    <div>
                        <div class="relative overflow-y-auto mt-3 shadow-lg  overflow-x-auto  ">
                            <table class="w-full text-sm  text-gray-500 ">
                                <thead class="text-left  bg-gray-50 font-jakarta text-primary  ">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 ">
                                            Product Name
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            Categories
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            Brand
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            Model
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            Design
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            Type
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-center">
                                            Quantity
                                        </th>
                                        {{-- <th scope="col" class="px-6 py-3">
                                        Amount
                                    </th> --}}


                                    </tr>
                                </thead>
                                <tbody class="font-poppins text-[13px]">
                                    @forelse($damage->damageProducts as $damage_product)
                                        <tr class="bg-white border-b text-left">
                                            <th scope="row" class="px-6 py-2 font-medium    whitespace-nowrap ">

                                                <div class="flex items-center gap-3">
                                                    <div>
                                                        @if ($damage_product->product?->image)
                                                            <img src="{{ asset('products/image/' . $damage_product->product?->image) }}"
                                                                class="w-12 h-12 object-contain" alt="">
                                                        @else
                                                            <img src="{{ asset('images/no-image.png') }}" class="w-12 h-12 "
                                                                alt="">
                                                        @endif
                                                    </div>
                                                    <h1 class="text-paraColor">{{ $damage_product->product?->brand?->name }}
                                                        <span
                                                            class="text-noti">({{ $damage_product->product?->code }})</span>
                                                    </h1>
                                                </div>
                                            </th>
                                            <td class="px-6 py-2">
                                                {{ $damage_product->product?->category?->name }}
                                            </td>
                                            <td class="px-6 py-2 ">
                                                {{ $damage_product->product?->brand?->name }}

                                            </td>
                                            <td class="px-6 py-2">
                                                {{ $damage_product->product?->productModel?->name }}

                                            </td>
                                            <td class="px-6 py-2">
                                                {{ $damage_product->product?->design?->name ?? '-' }}

                                            </td>
                                            <td class="px-6 py-2">
                                                {{ $damage_product->product?->type?->name ?? '-' }}
                                            </td>

                                            <td class="px-6 py-2 text-center">
                                                {{ number_format($damage_product->quantity) }}

                                            </td>
                                            {{-- <td class="pl-6 pr-12 py-2 text-left">
                                        {{ number_format($damage_product->amount)}}
                                    </td> --}}


                                        </tr>
                                    @empty
                                        @include('layouts.not-found', ['colSpan' => 8])
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
                <div class=" mt-6 flex items-center justify-center flex-wrap gap-5">
                    <a href="{{ url()->previous() }}">
                        <x-button-component class="bg-noti text-white" type="button" id="">
                            Back
                        </x-button-component>
                    </a>
                </div>
            </div>

            {{-- table end --}}
        </div>
    </section>
@endsection

@section('script')
    <script>
        function handlePrint() {

            executeDetailPrint("myContent")

        }
    </script>
@endsection
