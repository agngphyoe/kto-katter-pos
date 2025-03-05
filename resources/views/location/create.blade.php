@extends('layouts.master-without-nav')
@section('title', 'Create Location')
@section('css')
<style>
    .check-box {
        display: flex;
        align-items: center;
        gap: 10px;
        cursor: pointer;
        padding-right: 20px;
    }

    .check-box .check-item {
        padding: 4px 19px;
        color: #5D5A88;
        border-radius: 20px;
        font-size: 14px;
        border: 1px solid #5D5A88;
    }

    .check-box .check-item.active {
        background-color: #93AAFD;
        border: none;
        color: white;
    }

    .buttonCheck {
        background: #8d8686;
        width: 50px;
        height: 23px;
        border-radius: 200px;
        cursor: pointer;
        position: relative;
        transition: all 0.4s ease-in-out;
    }

    .buttonCheck::before {
        position: absolute;
        content: '';
        background-color: #fff;
        width: 20px;
        height: 19px;
        border-radius: 200px;
        top: 0;
        left: 0;
        margin: 2px;
        transition: all 0.2s ease-in-out;
    }

    input:checked+.buttonCheck {
        background-color: #28a745;
    }

    input:checked+.buttonCheck::before {
        transform: translateX(26px);
    }
</style>
@endsection
@section('content')
@php
use App\Constants\PrefixCodeID;
@endphp
<section class="product__create">
    {{-- nav start  --}}
    @include('layouts.header-section', [
    'title' => 'Create A New Location',
    'subTitle' => 'Fill to build a new location',
    ])
    {{-- nav end  --}}

    {{-- main form   --}}
    <div class="my-7 mx-5">
        <div class="lg:flex  lg:justify-around gap-10">
            <div class="mb-5">
                <img src="{{ asset('images/location.png') }}" class="w-1/2 mx-auto  animate__animated animate__jackInTheBox object-contain lg:mt-32" alt="">
            </div>

            <div class="bg-white w-full md:w-[800px] mx-auto lg:mx-0 mb-5 lg:mb-0 rounded-[20px]">
                <div class="px-5 md:px-14 py-10 ">

                    <form id="submitForm" action="{{ route('location-store') }}" method="POST">
                        @csrf
                        <div>
                            {{-- Location Name --}}
                            <div class="mb-10 flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
                                <label for="" class="font-jakarta text-paraColor font-semibold ">Location Name <span class="text-red-600">*</span></label>
                                <div class="">
                                    <x-input-field-component type="text" value="" label="" name="location_name" id="" text="| Location Name" required/>
                                </div>
                            </div>

                            {{-- Address --}}
                            <div class="mb-10 flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
                                <label for="" class="font-jakarta text-paraColor font-semibold ">Address <span class="text-red-600">*</span></label>
                                <div class="">
                                    <x-input-field-component type="text" value="" label="" name="location_address" id="" text="| Location Address" required/>
                                </div>
                            </div>

                            {{-- Phone --}}
                            {{-- <div class="mb-10 flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
                                <label for="" class="font-jakarta text-paraColor font-semibold">Phone <span class="text-red-600">*</span></label>
                                <div class="">
                                    <x-input-field-component type="number" value="" label="" name="phone" id="" text="Enter Phone"
                                    onkeypress="return (event.charCode !=8 && event.charCode ==0 || (event.charCode >= 48 && event.charCode <= 57))"  required/>
                                </div>
                            </div> --}}

                            {{-- model --}}
                            <div class="mb-10 flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
                                <label for="" class="font-jakarta text-paraColor font-semibold">Location Type <span class="text-red-600">*</span></label>

                                <select name="location_type_id" class=" product-select select2" id="product_model_select" required>
                                    @forelse($location_types as $location_type)
                                        <option value="{{ $location_type->id }}" class="outline-none font-Pop">{{ $location_type->location_type_name }}</option>
                                    @empty
                                        <option value="" class="outline-none font-Pop" disabled selected>No Data</option>
                                    @endforelse
                                </select>
                            </div>

                        </div>
                        <div class="w-full flex items-center gap-10 justify-center">
                            <a href="{{ route('location') }}">
                                <button type="button" class="outline outline-1 text-noti font-semibold font-jakarta text-sm outline-noti  w-32 py-2 rounded-2xl">Cancel</button>
                            </a>
                            <button type="submit" class="text-sm bg-primary  font-semibold font-jakarta text-white  w-32  py-2 rounded-2xl" id="submitButton">Done</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection

@section('script')

@endsection