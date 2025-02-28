@extends('layouts.master-without-nav')
@section('title', 'POS Return Details')
@section('css')

@endsection
@section('content')
    <section class="damage__create__final">
        {{-- nav start  --}}
        {{-- @include('layouts.header-section', [
    'title' => 'Create A New POS Return',
    'subTitle' => '',
    ]) --}}
        {{-- nav end  --}}

        <div class="lg:mx-[30px] m-5 lg:my-[30px]">
            <div class="bg-white shadow-xl mb-[30px] rounded-[20px] p-4 sm:p-10 font-poppins">
                <h1 class="text-center mb-3 text-primary">POS Return Details</h1>
                <div class="flex items-center justify-around flex-wrap gap-4">
                    <x-information title="Remarks" subtitle="{{ $return->remark }}" />
                    {{-- <x-information title="Total Quantity" subtitle="{{ $return->total_return_quantity }}" /> --}}
                    <div>
                        <h1 class="text-primary font-poppins text-left text-sm mb-2 font-semibold">Total Quantity</h1>
                        <h1 class="text-paraColor font-poppins text-[13px] text-center whitespace-nowrap">
                            {{ $return->total_return_quantity }}
                        </h1>
                    </div>
                    <x-information title="Location" subtitle="{{ $return->pointOfSale->location->location_name }}" />
                    <x-information title="Returned By" subtitle="{{ $return->createdBy->name }}" />
                    <x-information title="Returned At" subtitle="{{ dateFormat($return->return_date) }}" />
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
                                        'Category',
                                        'Brand',
                                        'Model',
                                        'Design',
                                        'Type',
                                        'Return Type',
                                        'Quantity',
                                    ]" /> --}}
                                    <tr class="text-left border-b">
                                        <th
                                            class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-left">
                                            Product Name</th>
                                        <th
                                            class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-left">
                                            Category</th>
                                        <th
                                            class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-left">
                                            Brand</th>
                                        <th
                                            class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-left">
                                            Model</th>
                                        <th
                                            class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-left">
                                            Design</th>
                                        <th
                                            class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-left">
                                            Type</th>
                                        <th
                                            class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-left">
                                            Return Type</th>
                                        <th
                                            class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-center">
                                            Quantity</th>
                                    </tr>
                                </thead>
                                <tbody class="font-poppins text-[13px]">
                                    @forelse($return->posReturnProducts as $data)
                                        @php
                                            $product = App\Models\Product::find($data['product_id']);
                                        @endphp
                                        <tr class="bg-white border-b text-left">
                                            <th scope="row" class="px-6 py-2 font-medium  whitespace-nowrap ">

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
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                {{ $product->category?->name }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                {{ $product->brand?->name }}

                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                {{ $product->productModel?->name }}

                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                {{ $product->design?->name ?? '-' }}

                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                {{ $product->type?->name ?? '-' }}
                                            </td>

                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <x-badge class="bg-green-600 text-white px-2">
                                                    {{ $data['return_type'] == 'product' ? 'Exchange' : 'Cash' }}
                                                </x-badge>
                                            </td>

                                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                                {{ number_format($data['quantity']) }}
                                            </td>

                                        </tr>
                                    @empty
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                    </div>


                </div>
            </div>

            <div class=" mt-6 flex items-center justify-center flex-wrap gap-5">
                <a href="{{ route('pos-return-list') }}">
                    <x-button-component class="outline outline-1 outline-noti text-noti" type="button">
                        Back
                    </x-button-component>
                </a>

            </div>
            </form>
        </div>
    </section>
@endsection
@section('script')

@endsection
