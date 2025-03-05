@extends('layouts.master-without-nav')
@section('title','Product Purchase')
@section('css')

@endsection
@section('content')
<section class="product__stock__update1">
    {{-- nav start  --}}
    @include('layouts.header-section', [
    'title' => 'Choose Type',
    'subTitle' => '',
    ])
    {{-- nav end  --}}

        {{-- box start  --}}
        <div class=" font-jakarta flex items-center justify-center mt-32">
            <div>
                <div class="bg-white animate__animated animate__zoomIn mb-5  p-10 shadow-xl rounded-[20px]">
                    <h3 class="block mb-4 font-jakarta text-center text-paraColor font-semibold text-sm">Choose Type</h3>
                    <div class="flex items-center justify-center gap-10">
                        <div class="flex flex-col">
                            <a href="{{ url('/purchase/'.$id .'/add-imei-scanner/'.$supplier_id) }}">
                                <button type="button" class="text-sm bg-noti outline mx-auto md:mx-0 text-white outline-1 w-full outline-noti md:w-44 py-2 rounded-2xl">Scanner</button>
                            </a>
                        </div>
                        <div class="flex flex-col">
                            <a href="{{ url('/purchase/'.$id.'/add-imei-manual/'.$supplier_id) }}">
                                <button type="button" class="text-sm bg-noti outline mx-auto md:mx-0 text-white outline-1 w-full outline-noti md:w-44 py-2 rounded-2xl">Manually</button>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- box end  --}}


</section>
@endsection
@section('script')

@endsection