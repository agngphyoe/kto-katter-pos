@extends('layouts.master-without-nav')
@section('title','Barcode Print')
@section('css')

@endsection
@section('content')
<section class="product__stock__update1">
    {{-- nav start  --}}
    @include('layouts.header-section', [
    'title' => 'Choose Product to Print Barcode',
    'subTitle' => '',
    ])
    {{-- nav end  --}}

    <form id="myForm" action="{{ route('print-barcodes') }}" method="POST">
        @csrf
        {{-- box start  --}}
        <div class=" font-jakarta flex items-center justify-center mt-32">
            <div>
                <div class="bg-white animate__animated animate__zoomIn mb-5  p-10 shadow-xl rounded-[20px]">
                    <div class="flex items-center justify-center gap-10">
                        <div class="flex flex-col ">

                            <label for="" class="block mb-2 font-jakarta text-left text-paraColor font-semibold text-sm">Select Product <span class="text-red-600">*</span></label>
                            <select name="product_id" id="" class="select2 w-[220px]" required>                               
                                <option value="" disabled selected>Choose Product</option>
                                @foreach ($products as $product)                                    
                                    <option value="{{ $product->id }}">{{ $product->name }} ({{ $product->code }})</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="flex flex-col ">

                            <label for="" class=" font-jakarta text-left text-paraColor font-semibold text-sm">Enter Quantity <span class="text-red-600">*</span></label>
                            <x-input-field-component type="number" value="" label="" name="quantity" id="" text="Enter Quantity" max="" required />
                        </div>
                    </div>

                    <div class="flex flex-col md:items-center text-center md:text-left md:flex-row mt-10 md:justify-center gap-10">

                        <a href="{{ route('get-product-barcodes') }}">
                            <button type="button" class="outline outline-1 text-noti text-sm  outline-noti w-full md:w-44 py-2 rounded-2xl">Cancel</button>
                        </a>
                        <button type="submit" class="text-sm bg-primary outline mx-auto md:mx-0 text-white outline-1 w-full outline-noti md:w-44 py-2 rounded-2xl" id="done">Print</button>
                    </div>
                </div>
            </div>
            

        </div>
        {{-- box end  --}}
    </form>


</section>
@endsection
@section('script')

@endsection