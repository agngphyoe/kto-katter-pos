@extends('layouts.master-without-nav')
@section('title','Stock Adjustment')
@section('css')

@endsection
@php
use App\Constants\AdjustmentType;
$current_stock = 0;

if($data['action_type'] == AdjustmentType::TYPES['Increase']){
$current_stock = $product->quantity + $data['quantity'];
}elseif($data['action_type'] == AdjustmentType::TYPES['Decrease']){
$current_stock = $product->quantity - $data['quantity'];
}

@endphp
@section('content')
<section class="product__stock__update3">
    {{-- nav start  --}}
    @include('layouts.header-section', [
    'title' => 'Create Product Stock',
    'subTitle' => '',
    ])
    {{-- nav end  --}}

    {{-- main start  --}}
    <div>
        <div class="xl:flex xl:items-center xl:justify-center gap-10 mx-5 xl:mx-10 my-5 xl:my-10">
            <div>
                @if($product->image)
                <img src="{{ asset('products/image/' . $product?->image) }}" class="mx-auto w-72 h-72 object-cover mb-3" alt="">
                @else
                <img src="{{ asset('images/no-image.png') }}" class="w-72 h-72 rounded-full mx-auto mb-5" alt="">
                @endif
            </div>
            <div class="bg-white  px-5 lg:px-20 py-10 rounded-[20px]">
                <h1 class="text-noti text-center font-jakarta font-semibold text-lg mb-5">{{ $product->name }} ({{ $product->code }}) </h1>
                <div class="grid grid-cols-2 gap-5 lg:gap-32 text-sm">
                    <div class="font-jakarta flex flex-col gap-4 text-paraColor font-semibold">
                        <h1>Product ID</h1>
                        <h1>Categories</h1>
                        <h1>Brand</h1>
                        <h1>Model</h1>
                        <h1>Design</h1>
                        <h1>Type</h1>
                        <h1>Last Stocks</h1>
                        <h1>Current Stocks</h1>
                        <h1>Remarks</h1>
                        <h1>Date</h1>
                    </div>
                    <div class="font-jakarta flex flex-col gap-4 font-semibold">
                        <h1>{{ $product->code }}</h1>
                        <h1>{{ $product->category?->name }}</h1>
                        <h1>{{ $product->brand?->name }}</h1>
                        <h1>{{ $product->productModel?->name }}</h1>
                        <h1>{{ $product->design?->name }}</h1>
                        <h1>{{ $product->type?->name }}</h1>
                        <h1>{{ number_format($product->quantity )}}</h1>
                        <h1>{{ number_format($current_stock) }}</h1>
                        <h1>{{ $data['remark'] ?? '-' }}</h1>
                        <h1>{{ dateFormat($data['adjustment_date']) }}</h1>
                    </div>
                </div>

                <form id="myForm" action="{{ route('product-stock-store') }}" method="POST">
                    @csrf
                    <input type="hidden" value="{{$product->id}}" name="product_id" />
                    <input type="hidden" value="{{json_encode($data)}}" name="stock_info" />

                    <div class="mt-10 flex items-center justify-center gap-5">
                        <x-button-component class="outline outline-1 outline-noti text-noti " type="button" onclick="window.history.back()">
                            Back
                        </x-button-component>
                        <x-button-component class="bg-primary  text-white" type="submit" id="done">
                            Next
                        </x-button-component>
                    </div>
                </form>

            </div>
        </div>
    </div>
    {{-- main send --}}
</section>
@endsection
@section('script')

@endsection