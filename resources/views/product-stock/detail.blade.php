@extends('layouts.master-without-nav')
@section('title', 'Product Adjustment')
@section('css')

@endsection

@section('content')
    <section class="Receive__Detail">
        {{-- nav start  --}}
        @include('layouts.header-section', [
            'title' => 'Adjustment Details',
            'subTitle' => 'Details of Product Adjustment',
        ])
        {{-- nav end  --}}


        {{-- ..........  --}}

        {{-- main start  --}}
        <div class="lg:mx-[30px] mx-[10px] my-[10px] lg:my-[20px]">

            {{-- purchase information start  --}}
            <div class="bg-white p-5 rounded-[20px] mt-5">
                <div class="data-table">
                    <div class="bg-white px-1 py-2 font-poppins rounded-[20px]  ">
                        <div>
                            <div class="relative overflow-x-auto mt-3 shadow-lg">
                                <table class="w-full text-sm text-center text-gray-500 ">
                                    <thead class="text-sm text-primary bg-gray-50 font-medium font-poppins">

                                        {{-- <x-table-head-component :columns="[
                                            'Product Name (ID)',
                                            'Categories',
                                            'Brand',
                                            'Model',
                                            'Design',
                                            'Type',
                                            'Status',
                                            'Quantity',
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
                                                Type
                                            </th>
                                            <th
                                                class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-left">
                                                Design
                                            </th>
                                            <th
                                                class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-left">
                                                Status
                                            </th>
                                            <th
                                                class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-center">
                                                Quantity
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody class="text-sm font-normal text-paraColor font-poppins">
                                        @forelse($products as $product)
                                            <tr class="bg-white border-b text-left">
                                                <th scope="row"
                                                    class="px-6 py-4 whitespace-nowrap font-medium  text-gray-900 ">
                                                    <div class="flex items-center gap-2">
                                                        @if ($product->product->image)
                                                            <img src="{{ asset('products/image/' . $product->product->image) }}"
                                                                class="w-10 h-10 object-cover">
                                                        @else
                                                            <img src="{{ asset('images/no-image.png') }}"
                                                                class="w-10 h-10 object-cover">
                                                        @endif
                                                        <h1 class="text-[#5C5C5C] font-medium  ">
                                                            {{ $product->product->name }} <span
                                                                class="text-noti ">({{ $product->product->code }})</span>
                                                        </h1>
                                                    </div>
                                                </th>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    {{ $product->product->category?->name }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-noti">
                                                    {{ $product->product->brand?->name }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    {{ $product->product->productModel?->name }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    {{ $product->product->type?->name ?? '-' }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    {{ $product->product->design?->name ?? '-' }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    @if ($product->status == 'add')
                                                        Added
                                                    @else
                                                        Removed
                                                    @endif
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                                    {{ $product->quantity }}
                                                </td>

                                            </tr>
                                        @empty
                                            @include('layouts.not-found', ['colSpan' => 9])
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                            <br>
                            <label for="remark" class="mr-3 text-sm text-primary bg-gray-50  font-medium font-poppins">
                                Remark
                            </label>
                            <span>{{ $stockAdjustment->remark }}</span>
                            <div class="flex items-center justify-end">
                                <a href="{{ route('product-stock') }}" type="button"
                                    class="bg-primary text-sm  text-white px-5 py-1 rounded-md">Back</a>
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
