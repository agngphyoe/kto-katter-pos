@extends('layouts.master')
@section('title', 'Barcodes List')
@section('mainTitle', 'Barcodes List')

@section('css')
@endsection

@section('content')
<div class="">

    <div class="ml-[20px] bg-white px-4 py-3 rounded-[20px]  md:ml-[270px] my-5 mr-[20px] 2xl:ml-[320px]">

        <div class="flex items-center justify-between">
            <div class="flex items-center gap-3">
                <h1 class="text-lg font-semibold font-poppins">Number of Barcodes : <span class="text-primary">{{ $products->count() }}</span></h1>
            </div>

            @if (auth()->user()->hasPermissions('product-barcode-list'))
                <div class="flex items-center gap-3">               
                    <a href="{{ route('select-barcodes') }}" type="button" class="bg-primary text-white font-bold py-2 px-4 rounded">
                        <i class="fa-solid fa-print text-white"></i>
                        Print
                    </a>
                </div>  
            @endif
            
        </div>
        <div class="grid grid-cols-3 gap-2">
            @foreach ($products as $product)
                <div class="border border-double border-t-4 p-4">
                    <div class="flex items-center justify-center font-bold">
                        {{ $product->name }}
                    </div>
                    <div class="mt-1 flex items-center justify-center font-bold">
                        {{ number_format($product->retail_price) }} MMK
                    </div>
                    <div class=" mt-2 flex items-center justify-center">
                        <div style="overflow: hidden;">
                            {!! DNS1D::getBarcodeHTML($product->code, 'C128A', 2, 33) !!}
                        </div>
                    </div>
                    <div class="mt-1 flex items-center justify-center font-bold">
                        {{ $product->code }}
                    </div>                   
                </div>
            @endforeach             
        </div>

    </div>
</div>
@endsection

@section('script')
    
@endsection