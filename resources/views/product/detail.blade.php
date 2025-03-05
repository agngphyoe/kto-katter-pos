@extends('layouts.master-without-nav')
@section('title', 'Product Detail')
@section('css')

    <style>
        .my-title {
            font-family: 'Plus Jakarta Sans', sans-serif;
            color: black;
            font-size: 20px;

        }

        .confirm-Button {
            color: #00812C;
            border: 1px solid #00812C;
            padding: 7px 40px;
            border-radius: 20px;
            margin-left: 10px;
            font-weight: 600;
            font-size: 20px;
        }

        .cancel-Button {
            color: #ff4c4a;
            border: 1px solid #ff4c4a;
            padding: 7px 40px;
            border-radius: 20px;

            font-weight: 600;
            font-size: 20px;
        }

        .confirm-Button:hover {
            background-color: #00812C;
            color: white;
        }

        .cancel-Button:hover {
            background-color: #ff4c4a;
            color: white;
        }
    </style>

@endsection
@section('content')
    <section class="detail">
        <div class="">

            @include('layouts.header-section', [
                'title' => 'Product Details View',
                'subTitle' => 'The details of product',
            ])
            {{-- nav end  --}}
            <div class="grid grid-cols-1 xl:grid-cols-2 mt-10 mx-5 xl:mx-10 ">
                <div class="col-span-1 xl:col-span-1 mb-10 xl:mb-4  flex items-center justify-center ">
                    <div class="mt-5">
                        <div class="">

                            @if ($product->image)
                                <img src="{{ asset('products/image/' . $product->image) }}"
                                    class="w-full object-contain h-96 " alt="x">
                            @else
                                <img src="{{ asset('images/no-image.png') }}" class="w-96 object-contain h-96 ">
                            @endif
                        </div>

                    </div>

                </div>
                <div class="col-span-1 xl:col-span-1 bg-white rounded-[20px] px-4 xl:px-14  py-8">
                    <div class="xl:flex xl:items-center xl:justify-between mb-8">
                        <h1 class="text-noti mb-3 xl:mb-0 font-jakarta text-lg font-semibold">{{ $product->name }}</h1>
                        <div class="flex items-center gap-6">
                            <a href="{{ route('product-list') }}"
                                class="text-noti outline outline-1 outline-noti font-jakarta font-semibold mt-3 px-10 py-2 rounded-full text-sm">Back</a>
                        </div>
                    </div>
                    <div class="grid grid-cols-2 font-jakarta text-sm">
                        <div class="font-semibold">
                            <h1 class="text-paraColor mb-7">Product Code</h1>
                            <h1 class="text-paraColor mb-7">Categories</h1>
                            <h1 class="text-paraColor mb-7">Brand</h1>
                            <h1 class="text-paraColor mb-7">Model</h1>
                            <h1 class="text-paraColor mb-7">Design</h1>
                            <h1 class="text-paraColor mb-7">Type</h1>
                            <h1 class="text-paraColor mb-7">Selling Price</h1>
                            <h1 class="text-paraColor mb-7">Stock Quantity</h1>
                            <h1 class="text-paraColor mb-7">Minimum Quantity Alert</h1>
                            <h1 class="text-paraColor mb-7">Created By</h1>
                            <h1 class="text-paraColor mb-7">Created At</h1>

                        </div>
                        <div class="font-medium ">
                            <h1 class="text-noti mb-7">{{ $product->code }}</h1>
                            <h1 class="mb-7">{{ $product->category->name ?? '-' }}</h1>
                            <h1 class="mb-7">{{ $product->brand->name ?? '-' }}</h1>
                            <h1 class="mb-7">{{ $product->productModel->name ?? '-' }}</h1>
                            <h1 class="mb-7">{{ $product->design->name ?? '-' }}</h1>
                            <h1 class="mb-7">{{ $product->type->name ?? '-' }}</h1>
                            <h1 class="mb-7">{{ number_format($product->retail_price) ?? '-' }}</h1>
                            <h1 class="mb-7">{{ number_format($product->quantity) ?? '-' }}</h1>
                            <h1 class="mb-7">{{ number_format($product->minimum_quantity) ?? '-' }}</h1>
                            <h1 class="mb-7">{{ $product->user->name ?? '-' }}</h1>
                            <h1 class="mb-7">{{ dateFormat($product->created_at) }}</h1>


                        </div>
                    </div>
                    <div class="flex justify-evenly items-center">
                        <a href="{{ route('product-stock-check', ['product_id' => $product->id]) }}"
                            class="bg-noti text-white font-jakarta px-7 py-3 text-md rounded-full">Check Stocks</a>
                        <a href="{{ route('product-price-log', ['product_id' => $product->id]) }}"
                            class="bg-primary text-white font-jakarta px-7 py-3 text-md rounded-full">Product Price Log</a>
                    </div>
                </div>
            </div>
        </div>

    </section>
@endsection
@section('script')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('js/Sweetalert.js') }}"></script>
    <script src="{{ asset('js/Nav.js') }}"></script>
@endsection
