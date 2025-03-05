@extends('layouts.master-without-nav')
@section('title', 'Purchase Return Details')
@section('css')

@endsection
@php
    use App\Models\Product;

@endphp

@section('content')
    <section class="purchase__return__final">
        {{-- nav start  --}}
        @include('layouts.header-section', [
            'title' => 'Purchase Return Details',
            'subTitle' => 'Fill these to know the supplier you want to return',
        ])
        {{-- nav end  --}}

        <main class="m-5">
            <div class="bg-white rounded-[25px]">
                <div class="p-5">
                    <h1 class="text-noti  font-jakarta font-semibold   mb-2">Supplier Detail</h1>
                    <div class="flex items-center justify-between flex-wrap  gap-2 ">
                        <x-information title="Supplier Name"
                            subtitle="{{ $purchase_return->purchase->supplier->name ?? '-' }}" />
                        <x-information title="Phone Number"
                            subtitle="{{ $purchase_return->purchase->supplier->phone ?? '-' }}" />
                        <x-information title="Country"
                            subtitle="{{ $purchase_return->purchase->supplier->country->name ?? '-' }}" />
                        <x-information title="Address"
                            subtitle="{{ $purchase_return->purchase->supplier->address ?? '-' }}" />

                    </div>
                </div>
            </div>

            <div class="bg-white p-5 rounded-[20px] mt-5">
                <h1 class="font-jakarta text-noti  font-semibold">Purchase Return Information</h1>
                <div class="relative overflow-x-auto shadow-lg mt-3">
                    <table class="w-full text-sm text-left text-gray-500 ">
                        <thead class="text-sm text-primary border-b font-jakarta font-medium bg-gray-50">
                            {{-- <x-table-head-component :columns="[
                                'Purchase ID',
                                'Total Return Quantity',
                                'Total Return Amount',
                                'Remarks',
                                'Returned By',
                                'Returned At',
                            ]" /> --}}
                            <tr class="text-left border-b">
                                <th class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-left">
                                    Purchase ID
                                </th>
                                <th
                                    class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-center">
                                    Total Return Quantity
                                </th>
                                <th class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-right">
                                    Total Return Amount
                                </th>
                                <th class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-left">
                                    Remarks
                                </th>
                                <th class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-left">
                                    Returned By
                                </th>
                                <th class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-left">
                                    Returned At
                                </th>
                            </tr>
                        </thead>
                        <tbody class="text-[14px] font-normal text-paraColor font-poppins text-left">
                            <tr class="bg-white border-b  ">
                                <th scope="row"
                                    class="px-6 py-4 font-medium flex items-center gap-2 text-gray-900 whitespace-nowrap">
                                    {{ $purchase_return->purchase->invoice_number ?? '-' }}
                                </th>
                                <td class="px-6 py-4 text-center">
                                    <span class="text-red-600">{{ $purchase_return->return_quantity }}</span>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <span class="text-noti">{{ number_format($purchase_return->return_amount) }}</span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    {{ $purchase_return->remark ?? '-' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    {{ $purchase_return->user->name ?? '-' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    {{ dateFormat($purchase_return->created_at) }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="border-1 border-dashed my-7"></div>
                <div class="flex items-center justify-between">

                    <h1 class="font-jakarta text-noti  font-semibold ">Return Products</h1>
                    <h1 class="font-poppins text-[13px] font-semibold mr-5">Total Return Quantity : <span
                            class="text-noti">{{ $purchase_return->return_quantity }}</span> </h1>
                </div>

                <div class="relative overflow-x-auto mt-3 shadow-lg">
                    <table class="w-full text-sm text-left text-gray-500 ">
                        <thead class="text-sm  text-primary font-jakarta  bg-gray-50 ">

                            {{-- <x-table-head-component :columns="[
                                'Product Name (ID)',
                                'Category',
                                'Brand',
                                'Model',
                                'Design',
                                'Type',
                                'Buy Price',
                                'Quantity',
                                'Amount',
                            ]" /> --}}
                            <tr class="text-left border-b">
                                <th class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-left">
                                    Product Name (ID)
                                </th>
                                <th class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-left">
                                    Category
                                </th>
                                <th class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-left">
                                    Brand
                                </th>
                                <th class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-left">
                                    Model
                                </th>
                                <th class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-left">
                                    Design
                                </th>
                                <th class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-left">
                                    Type
                                </th>
                                <th class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-right">
                                    Buy Price
                                </th>
                                <th
                                    class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-center">
                                    Quantity
                                </th>
                                <th class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-right">
                                    Amount
                                </th>
                            </tr>
                        </thead>
                        <tbody class="text-[13px] font-normal text-paraColor font-poppins">
                            @forelse($purchase_return->purchaseReturnProducts as $return_product)
                                <tr class="bg-white border-b text-left">
                                    <th scope="row"
                                        class="px-6 py-4 font-medium flex items-center gap-2 text-gray-900 whitespace-nowrap ">
                                        <div class="flex items-center gap-3">
                                            @if ($return_product->product->image)
                                                <img src="{{ asset('products/image/' . $return_product->product->image) }}"
                                                    class="w-10 object-cover h-10 " alt="x">
                                            @else
                                                <img src="{{ asset('images/no-image.png') }}" class="w-10 h-10 ">
                                            @endif

                                            <h1>
                                                {{ $return_product->product->name ?? '-' }}
                                                <span class="text-noti">
                                                    ({{ $return_product->product->code ?? '-' }})
                                                </span>
                                            </h1>
                                        </div>
                                    </th>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        {{ $return_product->product?->category?->name ?? '-' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        {{ $return_product->product?->brand?->name ?? '-' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        {{ $return_product->product?->productModel?->name ?? '-' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        {{ $return_product->product?->design?->name ?? '-' }}

                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        {{ $return_product->product?->type?->name ?? '-' }}
                                    </td>
                                    <td class="px-6 py-4 text-right text-primary">
                                        {{ number_format($return_product->unit_price) ?? '-' }}
                                    </td>
                                    <td class="px-6 py-4 text-primary text-center">
                                        {{ $return_product->quantity ?? '-' }}
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        {{ number_format($return_product->unit_price * $return_product->quantity) ?? '-' }}
                                    </td>
                                </tr>
                            @empty
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="flex justify-center items-start gap-10 mt-6">
                    <a href="{{ route('purchase-return') }}" type="button"
                        class="bg-noti text-white text-center rounded-full px-5 py-2 font-jakarta w-60">
                        Back
                    </a>

                </div>

            </div>

        </main>
    </section>
@endsection
@section('script')


@endsection
