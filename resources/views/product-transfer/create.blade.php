@extends('layouts.master-without-nav')
@section('title', 'Create Product Transfer')
@section('css')

@endsection
@section('content')
@php
use App\Constants\PrefixCodeID;
@endphp
<section class="product_transfer_create">
    {{-- nav start  --}}
    @include('layouts.header-section', [
    'title' => 'Create A New Product Transfer',
    'subTitle' => 'Fill to build a new Transfer',
    ])
    {{-- nav end  --}}

    {{-- main form   --}}
    <div class="my-7 mx-5">
        <div class="lg:flex  lg:justify-around gap-10">
            <div class="mb-5">
                <img src="{{ asset('images/createSupplier.png') }}" class="w-1/2 lg:w-full mx-auto  animate__animated animate__jackInTheBox object-contain lg:mt-32 " alt="">
            </div>

            <div class="bg-white w-full md:w-[800px] mx-auto lg:mx-0 mb-5 lg:mb-0  rounded-[20px]">
                <div class="px-5 md:px-14 py-10 ">

                    <form action="{{ route('product-transfer-create-second') }}" enctype="multipart/form-data">
                        @csrf
                        <div>
                            {{-- product code  --}}
                            @php
                            $transfer_code = explode("-", $transfer_code);
                            @endphp
                            <div class="mb-10 flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
                                <label for="" class="font-jakarta text-paraColor font-semibold">Transfer ID </label>
                                <div class="mr-[50px]">
                                    <div class="outline outline-1 flex items-center text-sm font-jakarta text-paraColor w-[300px] outline-primary rounded-full ">
                                        <div class=" py-2 px-3 bg-bgMain text-primary border-r border-primary rounded-l-full">
                                            {{ PrefixCodeID::TRANSFER }} -
                                        </div>
                                        <input type="number" placeholder="Enter Product Code" name="transfer_code" value="{{ $transfer_code[1] }}" class=" py-2 flex-grow rounded-r-full  px-3  outline-none">
                                    </div>
                                    @error('code')
                                    <p class="text-red-600 text-xs mt-1">* {{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-10 flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
                                <label for="" class="font-jakarta text-paraColor font-semibold">Transfer From *</label>

                                <div class="mr-[50px]">
                                    <select name="from_location_id" class="product-select select2" id="from_location_id_select" required>
                                        @forelse($from_locations as $from)
                                            <option value="{{ $from->id }}" class="outline-none font-Pop">{{ $from->location_name }}</option>
                                        @empty
                                            <option value="" class="outline-none font-Pop" disabled selected>No Data</option>
                                        @endforelse
                                    </select>
                                </div>
                            </div>

                            <div class="mb-10 flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
                                <label for="" class="font-jakarta text-paraColor font-semibold">Transfer To *</label>

                                <div class="mr-[50px]">
                                    <select name="to_location_id" class="product-select select2" id="to_location_id_select" required>
                                        @forelse($to_locations as $to)
                                            <option value="{{ $to->id }}" class="outline-none font-Pop">{{ $to->location_name }}</option>
                                        @empty
                                            <option value="" class="outline-none font-Pop" disabled selected>No Data</option>
                                        @endforelse
                                    </select>
                                </div>
                            </div>

                            {{-- quantity --}}
                            <div class="mb-10 flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
                                <label for="" class="font-jakarta text-paraColor font-semibold ">Transfer Date</label>
                                <div class="mr-[50px]">
                                    <div class="flex items-center outline outline-1 outline-primary rounded-full px-4 py-2 w-[300px]">
                                        <input type="text" name="single_date" class="outline-none w-full " id="date_range_input" value="">
                                        <i class="fa-solid fa-calendar-days text-primary"></i>
                                    </div>
                                </div>
                            </div>

                            {{-- remark --}}
                            <div class="mb-10 flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
                                <label for="" class="font-jakarta text-paraColor font-semibold ">Remark</label>
                                <div class="mr-[50px]">
                                    <x-input-field-component type="text" value="" label="" name="remark" id="" text="Enter remark" max="" />
                                </div>
                            </div>

                        </div>
                        <div class="w-full flex items-center gap-10 justify-center">
                            <a href="{{ route('product-list') }}">
                                <button type="button" class="outline outline-1 text-noti font-semibold font-jakarta text-sm outline-noti  w-32 py-2 rounded-2xl">Cancel</button>
                            </a>
                            <a href="{{ route('product-transfer-create-second') }}">
                                <button type="submit" class="text-sm bg-primary  font-semibold font-jakarta text-white  w-32  py-2 rounded-2xl" id="done">Next</button>
                            </a>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
@section('script')

<script>
    $(function() {
      $('input[name="single_date"]').daterangepicker({
        singleDatePicker: true,
        showDropdowns: true,
        minYear: 1901,
        maxYear: parseInt(moment().format('YYYY'),10)
      }, function(start, end, label) {
        var years = moment().diff(start, 'years');
        
      });
    });
    </script>

@endsection
