@extends('layouts.master-without-nav')
@section('title', 'Location Type Edit')
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
<section class="user__create">
    {{-- nav start  --}}
    @include('layouts.header-section', [
    'title' => 'Edit Location Type',
    'subTitle' => '',
    ])
    {{-- nav end  --}}

    {{-- main start  --}}
    <form id="myForm" action="{{ route('location-type-update', ['location_type'=>$locationType->id]) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mx-[30px] my-[10px] lg:my-[20px] xl:mx-[300px]">

            <div class="grid grid-cols-1  gap-5">
                <div class="col-span-1 lg:col-span-1">
                    <div class="rounded-b-[20px] shadow-xl bg-white rounded-[20px]">
                        <div class="py-5">
                            <div>
                                <div style="padding:50px;">
                                    {{-- Location Name --}}
                                    <div class="mb-10 flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
                                        <label for="" class="font-jakarta text-paraColor font-semibold ">Location Type *</label>
                                        <div class="">
                                            <x-input-field-component type="text" value="{{ $locationType->location_type_name }}" label="" name="location_type_name" id="locationTypeName" text="| Location Type Name" required/>
                                        </div>
                                    </div>
                        
                                    <div class="col-span-1 pb-4 mb-6 xl:mb-0 ">
                                        <div>
                                            <div class="flex items-center justify-between pb-4 border border-b border-x-0 border-t-0 border-primary">
                                                <h1 class="font-jakarta text-sm text-paraColor">Sale Type *</h1>
                                                <ul class="">
                                                    <li class="check-box">
                                                        <input type="radio" id="css" name="sale_type" value="Retail" {{ $locationType->sale_type == 'Retail' ? 'checked' : '' }} required>
                                                        <label for="retail">Retail</label><br>
                                                        <input type="radio" id="css" name="sale_type" value="Wholesale" {{ $locationType->sale_type == 'Wholesale' ? 'checked' : '' }} required>
                                                        <label for="wholesale ">Wholesale</label><br>
                                                        <input type="radio" id="javascript" name="sale_type" value="Store" {{ $locationType->sale_type == 'Store' ? 'checked' : '' }} required>
                                                        <label for="store">Store</label>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                        
                                </div>
                                <div class="w-full flex items-center gap-10 justify-center">
                                    <a href="#">
                                        <button type="button" class="outline outline-1 text-noti font-semibold font-jakarta text-sm outline-noti  w-32 py-2 rounded-2xl">Cancel</button>
                                    </a>
                                    <button type="submit" class="text-sm bg-primary  font-semibold font-jakarta text-white  w-32  py-2 rounded-2xl" id="done">Done</button>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- main end --}}
    </form>

</section>
@endsection