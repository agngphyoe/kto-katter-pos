@extends('layouts.master-without-nav')
@section('title', 'Product Price Log')

@section('css')

@endsection

@section('content')
    <section class="price-log">
        <div class="">
            @include('layouts.header-section', [
                'title' => 'Product Price History',
                'subTitle' => 'The details of product price history',
            ])

            <div class="mt-10 mx-5 xl:mx-10">
                <div class="bg-white rounded-[20px] p-6">
                    <div class="mb-6 flex justify-between items-center">
                        <h2 class="text-noti font-jakarta text-lg font-semibold">Product Details</h2>
                        <a href="{{ route('product-detail', ['product' => $product]) }}"
                            class="text-noti outline outline-1 outline-noti font-jakarta font-semibold px-10 py-2 rounded-full text-sm">
                            Back
                        </a>
                    </div>

                    <div class="overflow-x-auto mt-10 mx-5 xl:mx-10">
                        <table class="w-full text-center">
                            <thead class=" text-sm sticky top-0 z-10 text-primary bg-gray-50 font-jakarta">
                                <tr class="text-left border-b">
                                    <th
                                        class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-left">
                                        Product Name
                                    </th>
                                    <th
                                        class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-left">
                                        Product Code
                                    </th>
                                    <th
                                        class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-left">
                                        Category
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
                                        class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-right">
                                        Buying Price
                                    </th>
                                    <th
                                        class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-right">
                                        Selling Price
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="font-normal font-poppins text-sm text-paraColor">
                                <tr class="bg-white border-b text-left ">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                        {{ $product->name }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-noti">
                                        {{ $product->code }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                        {{ $product->category->name ?? '-' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                        {{ $product->brand->name ?? '-' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                        {{ $product->productModel->name ?? '-' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                        {{ $product->design->name ?? '-' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                        {{ $product->type->name ?? '-' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-right">
                                        {{ $product->DistributionTransaction ? number_format($product->DistributionTransaction->buying_price) : '-' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-right">
                                        {{ number_format($product->retail_price) ?? '-' }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="mt-10 mx-5 xl:mx-10 grid grid-cols-1 xl:grid-cols-2 gap-10">
                <!-- Buying Price History -->
                <div class="bg-white rounded-[20px] p-6">
                    <div class="mb-6">
                        <h2 class="text-noti font-jakarta text-lg font-semibold">Buying Price History</h2>
                    </div>
                    <div class="relative">
                        <div style="max-height: 200px;" class="overflow-y-auto">
                            <table class="w-full text-center">
                                <thead class="text-sm text-primary bg-gray-50 font-jakarta sticky top-0">
                                    <tr class="text-left border-b">
                                        <th class="px-24 whitespace-nowrap py-3 text-right bg-gray-50">
                                            Buying Price</th>
                                        <th class="px-24 whitespace-nowrap py-3 text-left bg-gray-50">
                                            Date</th>
                                    </tr>
                                </thead>
                                <tbody class="font-normal font-poppins text-sm text-paraColor">
                                    @if ($priceHistory->isEmpty())
                                        <tr class="bg-white border-b text-left">
                                            <td class="px-24 py-4 text-sm whitespace-nowrap text-right">
                                                {{ $product->DistributionTransaction ? number_format($product->DistributionTransaction->buying_price) : '-' }}
                                            </td>
                                            <td class="px-24 py-4 text-sm whitespace-nowrap">
                                                {{ dateFormat($product->created_at) }}
                                            </td>
                                        </tr>
                                    @else
                                        @foreach ($priceHistory as $history)
                                            <tr class="bg-white border-b text-left">
                                                <td class="px-24 py-4 text-sm whitespace-nowrap text-right">
                                                    {{ number_format($history->buying_price) }}
                                                </td>
                                                <td class="px-24 py-4 text-sm whitespace-nowrap">
                                                    {{ dateFormat($history->created_at) }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Selling Price History -->
                <div class="bg-white rounded-[20px] p-6">
                    <div class="mb-6">
                        <h2 class="text-noti font-jakarta text-lg font-semibold">Selling Price History</h2>
                    </div>
                    <div class="relative">
                        <div style="max-height: 200px;" class="overflow-y-auto">
                            <table class="w-full text-center">
                                <thead class="text-sm text-primary bg-gray-50 font-jakarta sticky top-0">
                                    <tr class="text-left border-b">
                                        <th class="px-24 whitespace-nowrap py-3 text-right bg-gray-50">
                                            Selling Price</th>
                                        <th class="px-24 whitespace-nowrap py-3 text-left bg-gray-50">
                                            Date</th>
                                    </tr>
                                </thead>
                                <tbody class="font-normal font-poppins text-sm text-paraColor">
                                    @if ($retailPriceHistory->isEmpty())
                                        <tr class="bg-white border-b text-left">
                                            <td class="px-24 py-4 text-sm whitespace-nowrap text-right">
                                                {{ number_format($product->retail_price) ?? '-' }}
                                            </td>
                                            <td class="px-24 py-4 text-sm whitespace-nowrap">
                                                {{ dateFormat($product->created_at) }}
                                            </td>
                                        </tr>
                                    @else
                                        @foreach ($retailPriceHistory as $history)
                                            <tr class="bg-white border-b text-left">
                                                <td class="px-24 py-4 text-sm whitespace-nowrap text-right">
                                                    {{ number_format($history->new_retail_price) }}
                                                </td>
                                                <td class="px-24 py-4 text-sm whitespace-nowrap">
                                                    {{ dateFormat($history->created_at) }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>
@endsection

@section('script')
    <script src="{{ asset('js/Nav.js') }}"></script>
@endsection
