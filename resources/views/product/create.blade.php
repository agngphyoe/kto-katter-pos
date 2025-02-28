@extends('layouts.master-without-nav')
@section('title', 'Create Product')
@section('css')
<style>
    .imei_switch {
        position: relative;
        width: 150px;
        height: 35px;
        text-align: center;

        background: #00812C;
        transition: all 0.2s ease;
        border-radius: 25px;
    }

    .imei_switch span {
        position: absolute;
        width: 20px;
        height: 4px;
        top: 50%;
        left: 50%;
        margin: -2px 0px 0px -4px;
        background: #fff;
        display: block;
        transform: rotate(-45deg);
        transition: all 0.2s ease;
    }

    .imei_switch span:after {
        content: "";
        display: block;
        position: absolute;
        width: 4px;
        height: 12px;
        margin-top: -8px;
        background: #fff;
        transition: all 0.2s ease;
    }

    input[type=radio] {
        display: none;
    }

    .imei_switch label {
        cursor: pointer;
        color: rgba(0, 0, 0, 0.6);
        width: 60px;
        line-height: 35px;
        transition: all 0.2s ease;
    }

    label[for=imei_yes] {
        position: absolute;
        left: 0px;
        height: 20px;
    }

    label[for=imei_no] {
        position: absolute;
        right: 0px;
    }

    #imei_no:checked~.imei_switch {
        background: #c30010;
    }

    #imei_no:checked~.imei_switch span {
        background: #fff;
        margin-left: -8px;
    }

    #imei_no:checked~.imei_switch span:after {
        background: #fff;
        height: 20px;
        margin-top: -8px;
        margin-left: 8px;
    }

    #imei_yes:checked~.imei_switch label[for=imei_yes] {
        color: #fff;
    }

    #imei_no:checked~.imei_switch label[for=imei_no] {
        color: #fff;
    }

    input[type=radio] {
        display: none;
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
    'title' => 'Create A New Product',
    'subTitle' => 'Fill to build a new product',
    ])
    {{-- nav end  --}}

    {{-- category  modal box  --}}
    <x-just-modal modal="myCategoryModal" class="lg:w-[600px] " cancelBtnId="category_cancel_btn" doneBtnId="category_done_btn">
        <div class="flex items-center justify-center gap-10">

            <div>
                <label for="" class=" block mb-2 text-paraColor font-semibold text-sm">Category</label>
                <input type="text" name="name" id="category_input" placeholder="Enter Data Name" class="outline w-[220px] outline-1 outline-primary px-4 py-2 rounded-2xl text-sm">
                <div><span id="category_error_msg" style="color: red"></span></div>
                @error('name')
                <p class="text-red-600 text-xs mt-1">* {{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="" class=" block mb-2 text-paraColor font-semibold text-sm">Prefix</label>
                <input type="text" name="prefix" id="category_prefix_input" placeholder="Enter Prefix" class="outline w-[220px] outline-1 outline-primary px-4 py-2 rounded-2xl text-sm">
                <div><span id="category_prefix_error_msg" style="color: red"></span></div>
                @error('prefix')
                <p class="text-red-600 text-xs mt-1">* {{ $message }}</p>
                @enderror
            </div>

        </div>
    </x-just-modal>

    {{-- brand modal box  --}}
    <x-just-modal modal="myBrandModal" class="lg:w-[700px]" cancelBtnId="brand_cancel_btn" doneBtnId="brand_done_btn">
        <form action="{{ route('brand-store') }}" method="post">
            <div class="flex md:flex-row justify-center flex-col   gap-10">
                {{-- category --}}
                <div>
                    <label for="" class=" block mb-2 text-paraColor font-semibold text-sm">Category</label>
                    <select name="category_id" id="category_id_select" class="select2 w-[220px]">
                        <option value="" selected disabled>Choose Category</option>
                        @foreach ($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                    @error('brand_id')
                    <p class="text-red-600 text-xs mt-2">* {{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="" class=" block mb-2 text-paraColor font-semibold text-sm">Brand</label>
                    <input type="text" name="name" id="brand_input" placeholder="Enter Data Name" class="outline w-[220px] outline-1 outline-primary px-4 py-2 rounded-2xl text-sm">
                    <div><span id="brand_error_msg" style="color: red"></span></div>
                    @error('name')
                    <p class="text-red-600 text-xs mt-1">* {{ $message }}</p>
                    @enderror
                </div>

            </div>
            <div class="flex md:flex-row justify-center flex-col mt-5  gap-10">
                <div>
                    <label for="" class=" block mb-2 text-paraColor font-semibold text-sm">Prefix</label>
                    <input type="text" name="prefix" id="brand_prefix_input" placeholder="Enter Prefix" class="outline w-[220px] outline-1 outline-primary px-4 py-2 rounded-2xl text-sm">
                    <div><span id="brand_prefix_error_msg" style="color: red"></span></div>
                    @error('prefix')
                    <p class="text-red-600 text-xs mt-1">* {{ $message }}</p>
                    @enderror
                </div>
            </div>
        </form>
    </x-just-modal>

    {{-- Product modal box  --}}
    <x-just-modal modal="myModelModal" class="lg:w-[700px]" cancelBtnId="product_model_cancel_btn" doneBtnId="product_model_done_btn">
        {{-- <form action="{{ route('product-model-store') }}" method="post"> --}}
            <div class="flex md:flex-row justify-center flex-col gap-10">

                {{-- category --}}
                <div>
                    <label for="" class=" block mb-2 text-paraColor font-semibold text-sm">Category</label>
                    <select name="category_id" id="category_id_select2" class="select2 w-[220px]">
                        <option value="" selected disabled>Choose Category</option>
                        @foreach ($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                    @error('category_id')
                    <p class="text-red-600 text-xs mt-2">* {{ $message }}</p>
                    @enderror
                </div>

                {{--  brand --}}
                <div>
                    <label for="" class=" block mb-2 text-paraColor font-semibold text-sm">Brand</label>
                    <select name="brand_id" id="brand_id_select" class="select2 w-[220px]">
                        <option value="" selected disabled>Choose Brand</option>
                        
                    </select>
                    @error('brand_id')
                    <p class="text-red-600 text-xs mt-2">* {{ $message }}</p>
                    @enderror
                </div>

            </div>
            <div class="flex md:flex-row justify-center flex-col gap-10 mt-2">
                <div>
                    <label for="" class=" block mb-2 text-paraColor font-semibold text-sm">Model</label>
                    <input type="text" name="name" id="product_model_input" placeholder="Enter Data Name" class="outline w-[220px] outline-1 outline-primary px-4 py-2 rounded-2xl text-sm">
                    <div><span id="brand_error_msg" style="color: red"></span></div>
                    @error('name')
                    <p class="text-red-600 text-xs mt-1">* {{ $message }}</p>
                    @enderror
                </div>
            </div>
        {{-- </form> --}}
    </x-just-modal>

    {{-- Design modal box  --}}
    <x-just-modal modal="myDesignModal" class="md:max-w-md" cancelBtnId="design_cancel_btn" doneBtnId="design_done_btn">
        <div class="flex items-center justify-center gap-10">
            <div>
                <label for="" class=" block mb-2 text-paraColor font-semibold text-sm">Design</label>
                <input type="text" name="name" id="design_input" placeholder="Enter Data Name" class="outline w-[220px] outline-1 outline-primary px-4 py-2 rounded-2xl text-sm">
                <input type="hidden" name="prefix" id="design_prefix_input">
                <div><span id="design_error_msg" style="color: red"></span></div>
                @error('name')
                    <p class="text-red-600 text-xs mt-1">* {{ $message }}</p>
                @enderror
            </div>

        </div>
    </x-just-modal>

    {{-- Type modal box  --}}
    <x-just-modal modal="myTypeModal" class="md:max-w-md" cancelBtnId="type_cancel_btn" doneBtnId="type_done_btn">
        <div class="flex items-center justify-center gap-10">
            <div>
                <label for="" class=" block mb-2 text-paraColor font-semibold text-sm">Type</label>
                <input type="text" name="name" id="type_input" placeholder="Enter Data Name" class="outline w-[220px] outline-1 outline-primary px-4 py-2 rounded-2xl text-sm">
                <input type="hidden" name="prefix" id="type_prefix_input">
                <div><span id="type_error_msg" style="color: red"></span></div>
                @error('name')
                <p class="text-red-600 text-xs mt-1">* {{ $message }}</p>
                @enderror
            </div>
        </div>
    </x-just-modal>

    {{-- main form   --}}


    <div class="my-7 mx-5">
        <div class="lg:flex  lg:justify-around gap-10">
            <div class="mb-5">
                <img src="{{ asset('images/createSupplier.png') }}" class="w-1/2 lg:w-full mx-auto  animate__animated animate__jackInTheBox object-contain lg:mt-32 " alt="">
            </div>

            <div class="bg-white w-full md:w-[800px] mx-auto lg:mx-0 mb-5 lg:mb-0  rounded-[20px]">
                <div class="px-5 md:px-14 py-10 ">

                    <form action="{{ route('product-store') }}" method="POST" enctype="multipart/form-data" id="productForm">
                        @csrf

                        <div class="text-center mb-10 ">
                            <x-input-field-component type="text" value="" label="" name="name" id="" text="| Product Name" />
                        </div>
                        <div>

                            {{-- category --}}
                            <div class="mb-10 flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
                                <div class="flex items-center gap-5 ">
                                    <label for="" class="font-jakarta text-paraColor font-semibold ">Categories <span class="text-red-600">*</span></label>
                                    {{-- mobile view plus button   --}}
                                    <div class="md:hidden">
                                        <x-just-create-button modal="myCategoryModal" />
                                    </div>
                                </div>
                                <div class="flex items-center gap-5">
                                    <div>
                                        <select name="category_id" class="outline outline-1 font-jakarta text-paraColor  text-[16px] outline-paraColor px-14 py-2 rounded-full product-select select2" id="category_select">
                                            <option value="" class="px-10" selected disabled>Select
                                                Category
                                            </option>
                                            @forelse ($categories as $category)
                                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                                {{ $category->name }}
                                            </option>
                                            @empty
                                            <option value="" disabled>No Category</option>
                                            @endforelse
                                        </select>
                                        @error('category_id')
                                        <p class="text-red-600 text-xs mt-1">* {{ $message }}</p>
                                        @enderror
                                    </div>
                                    {{-- deskop view plus button   --}}
                                    <div class="hidden md:block">
                                        <x-just-create-button modal="myCategoryModal" />
                                    </div>
                                </div>
                            </div>

                            {{-- brand --}}
                            <div class="mb-10 flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
                                <div class="flex items-center gap-5">
                                    <label for="" class="font-jakarta text-paraColor font-semibold ">Brand <span class="text-red-600">*</span></label>
                                    <div class="md:hidden">
                                        <x-just-create-button modal="myBrandModal" />
                                    </div>
                                </div>

                                <div class="flex items-center gap-5">
                                    <div>
                                        <select name="brand_id" id="brand_select" class="outline outline-1 font-jakarta text-paraColor  text-[16px] outline-paraColor px-14 py-2 rounded-full product-select select2" id="brand_select">
                                            <option value="" class="px-10" selected disabled>Select
                                                Brand
                                            </option>
                                            @forelse ($brands as $brand)
                                            <option value="{{ $brand->id }}" {{ old('brand_id') == $brand->id ? 'selected' : '' }}>
                                                {{ $brand->name }}
                                            </option>
                                            @empty
                                            <option value="" disabled>No Brand</option>
                                            @endforelse
                                        </select>
                                        @error('brand_id')
                                        <p class="text-red-600 text-xs mt-1">* {{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="hidden md:block">
                                        <x-just-create-button modal="myBrandModal" />

                                    </div>

                                </div>


                            </div>

                            {{-- model --}}
                            <div class="mb-10 flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
                                <div class="flex items-center gap-5">
                                    <label for="" class="font-jakarta text-paraColor font-semibold ">Model <span class="text-red-600">*</span></label>
                                    <div class="md:hidden">
                                        <x-just-create-button modal="myModelModal" />
                                    </div>

                            </div>
                                <div class="flex items-center gap-5">
                                    <div>
                                        <select name="model_id" class="w-[300px] product-select select2" id="product_model_select">
                                            <option value="" class="px-10" selected disabled>Select
                                                Model
                                            </option>
                                            @forelse ($product_models as $product_model)
                                            <option value="{{ $product_model->id }}" {{ old('model_id') == $product_model->id ? 'selected' : '' }}>
                                                {{ $product_model->name }}
                                            </option>
                                            @empty
                                            <option value="" disabled>No Model</option>
                                            @endforelse
                                        </select>
                                        @error('model_id')
                                        <p class="text-red-600 text-xs mt-1">* {{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="hidden md:block">
                                        <x-just-create-button modal="myModelModal" />

                                    </div>

                                </div>
                            </div>

                            {{-- design --}}
                            <div class="mb-10 flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
                                <div class="flex items-center gap-5">
                                    <label for="" class="font-jakarta text-paraColor font-semibold ">Design</label>
                                    <div class="md:hidden">
                                        <x-just-create-button modal="myDesignModal" />
                                    </div>
                                </div>
                                <div class="flex items-center gap-5">
                                    <div>
                                        <select name="design_id" class="outline outline-1 font-jakarta text-paraColor  text-[16px] outline-paraColor px-14 py-2 rounded-full product-select select2" id="design_select2">
                                            <option value="" class="px-10" selected disabled>Select
                                                Design
                                            </option>
                                            @forelse ($designs as $design)
                                            <option value="{{ $design->id }}" {{ old('design_id') == $design->id ? 'selected' : '' }}>
                                                {{ $design->name }}
                                            </option>
                                            @empty
                                            <option value="" disabled>No Designs</option>
                                            @endforelse
                                        </select>
                                        @error('design_id')
                                        <p class="text-red-600 text-xs mt-1">* {{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="hidden md:block">
                                        <x-just-create-button modal="myDesignModal" />

                                    </div>

                                </div>
                            </div>

                            {{-- type --}}
                            <div class="mb-10 flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
                                <div class="flex items-center gap-5">
                                    <label for="" class="font-jakarta text-paraColor font-semibold ">Type</label>
                                    <div class="md:hidden ">
                                        <x-just-create-button modal="myTypeModal" />
                                    </div>

                                </div>

                                <div class="flex items-center gap-5">
                                    <div>
                                        <select name="type_id" class="outline outline-1 font-jakarta text-paraColor  text-[16px] outline-paraColor px-14 py-2 rounded-full product-select select2" id="type_select2">
                                            <option value="" class="px-10" selected disabled>Select
                                                Type
                                            </option>
                                            @forelse ($types as $type)
                                            <option value="{{ $type->id }}" {{ old('type_id') == $type->id ? 'selected' : '' }}>
                                                {{ $type->name }}
                                            </option>
                                            @empty
                                            <option value="" disabled>No Type</option>
                                            @endforelse
                                        </select>
                                        @error('type_id')
                                        <p class="text-red-600 text-xs mt-1">* {{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="hidden md:block">
                                        <x-just-create-button modal="myTypeModal" />
                                    </div>

                                </div>

                            </div>

                            {{-- minimum quantity --}}
                            <div class="mb-10 flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
                                <label for="" class="font-jakarta text-paraColor font-semibold ">Minimum
                                    Quantity <span class="text-red-600">*</span></label>
                                <div class="mr-[50px]">
                                    <x-input-field-component type="number" value="" label="" name="minimum_quantity" id="" text="Enter Minimum Quantity" max="" />

                                </div>

                            </div>

                            {{-- product image --}}
                            <div class="mb-10 flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
                                <label for="" class="font-jakarta text-paraColor font-semibold">Photo
                                </label>
                                <div class="mr-[50px] w-full md:w-[300px]">
                                    <div class="outline-1 outline-primary outline-dashed rounded-full relative py-1 ">
                                        <label class="cursor-pointer block text-primary rounded-full">
                                            <span class="flex gap-3 absolute bottom-[22%] left-10">
                                                <div class="outline outline-1 outline-primary flex items-center justify-center text-primary rounded-full w-6 h-6">
                                                    <i class="fa-solid fa-plus"></i>
                                                </div>
                                                <h1 class="text-sm font-jakarta" id="uploadLabel">Upload
                                                    Product
                                                    Photo
                                                </h1>
                                            </span>
                                            <input type="file" value="" id="photoInput" name="image" class="opacity-0 w-full inset-0 cursor-pointer" onchange="updateUploadLabel(this)" />
                                        </label>
                                    </div>
                                    @error('image')
                                    <p class="text-red-600 text-xs mt-1">* {{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            {{-- imei --}}
                            <div class="mb-10 flex md:items-center flex-col gap-3 md:flex-row md:justify-between md:mr-[200px]  ">
                                <label for="" class="font-jakarta text-paraColor font-semibold ">IMEI Product <span class="text-red-600">*</span>
                                </label>
                                <div class="font-jakarta text-sm">
                                    <div class="toggle-radio">
                                        <input type="radio" name="is_imei" id="imei_yes" value="1">
                                        <input type="radio" name="is_imei" id="imei_no" value="0" checked>
                                        <div class="imei_switch">
                                            <label for="imei_yes">Yes</label>
                                            <label for="imei_no">No</label>
                                            <span></span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="w-full flex items-center gap-10 justify-center">
                            <a href="{{ route('product-list') }}">
                                <button type="button" class="outline outline-1 text-noti font-semibold font-jakarta text-sm outline-noti  w-32 py-2 rounded-2xl">Cancel</button>
                            </a>
                            <button type="submit" class="text-sm bg-primary  font-semibold font-jakarta text-white  w-32  py-2 rounded-2xl" id="done">Done</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
@section('script')

{{-- get product model data --}}
<script>
    $(document).ready(function() {
        $('select[name="brand_id"]').change(function() {
            var brand_id = $(this).val();

            $.ajax({
                url: "{{ route('get-product-model') }}",
                type: 'GET',
                dataType: 'json',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    brand_id: brand_id
                },
                success: function(response) {

                    $('#product_model_select').html(response.html);

                    $('.select2').select2();
                },
                error: function(xhr, status, error) {
                    console.log(error);
                }
            });
        });
    });
</script>

<script>
    $(document).ready(function() {
        $('select[name="category_id"]').change(function() {
            var category_id = $(this).val();

            $.ajax({
                url: "{{ route('get-product-brand') }}",
                type: 'GET',
                dataType: 'json',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    category_id: category_id
                },
                success: function(response) {

                    $('#brand_select').html(response.html);
                    $('#product_model_select').empty();
                    $('#product_model_select').append('<option value="">Select Model</option>');

                    $('.select2').select2();
                },
                error: function(xhr, status, error) {
                    console.log(error);
                }
            });
        });
    });
</script>

{{-- <script>
    const addPhotoImg = document.getElementById('addPhoto');
    const photoInput = document.getElementById('photoInput');

    addPhotoImg.addEventListener('click', function() {
        photoInput.click();
    });
</script> --}}
<script>
    function updateUploadLabel(input) {
        const uploadLabel = document.getElementById("uploadLabel");

        if (input.files.length > 0) {
            uploadLabel.textContent = input.files[0].name.substring(input.files[0].name.length - 20);
        } else {
            uploadLabel.textContent = "Upload Customer Photo";
        }
    }
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const modalTriggers = document.querySelectorAll('.modal-trigger');
        const modalCloses = document.querySelectorAll('.modal-close');

        modalTriggers.forEach(trigger => {
            trigger.addEventListener('click', function() {
                const targetId = this.getAttribute('data-modal-target');
                const targetModal = document.getElementById(targetId);
                targetModal.classList.remove('hidden');
            });
        });

        modalCloses.forEach(closeButton => {
            closeButton.addEventListener('click', function() {
                const modal = this.closest('.modal');
                modal.classList.add('hidden');
            });
        });
    });
</script>

{{-- modal boxes start --}}

<script>
    function handleAjaxRequest(routeName, doneBtn, inputElementId, inputPrefixId, cancelButtonId, selectElement, errorMsgId, brandId =null, categoryId = null) {
        $(doneBtn).hide();
        setTimeout(() => {
            $(doneBtn).show();
        }, 3000);
        var inputValue = $(inputElementId).val();
        var inputPrefixValue = $(inputPrefixId).val();
        var brand_id = $(brandId).val();
        var category_id = $(categoryId).val();
        $.ajax({
            url: routeName,
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                name: inputValue,
                prefix: inputPrefixValue,
                brand_id: brand_id,
                category_id: category_id,
            },
            success: function(response) {
                console.log(response.html);
                $(cancelButtonId).click();
                $(selectElement).html(response.html);

                if (routeName == "{{route('category-store')}}") {
                    $('#category_id_select').html(response.html);
                    $('#category_id_select2').html(response.html);
                }
                
                if (routeName == "{{route('brand-store')}}") {
                    $('#brand_id_select').html(response.html);
                    $('#category_select').html(response.selected_category);
                }
                if (routeName == "{{ route('product-model-store') }}") {
                    $('#brand_select').html(response.selected_brand);
                }

                if (routeName == "{{ route('design-store') }}") {
                    $('#design_select2').empty();
                    $('#design_select2').html(response.html);
                }

                if (routeName == "{{ route('type-store') }}") {
                    $('#type_select2').empty();
                    $('#type_select2').html(response.html);
                }
                // $(inputElementId).val('');
                // $('#product_model_select').html(response.html);
                // $(errorMsgId).text('');
                // $('#brand_id_error_msg').css('display', 'none');
            },
            error: function(xhr, status, error) {
                try {
                    var response = JSON.parse(xhr.responseText);
                    console.log(response);
                    var errorMessage = response.errors.name[0];
                    $(errorMsgId).text('*' + errorMessage);
                    $('#brand_id_error_msg').css('display', 'block');
                } catch (e) {
                    console.error('An error occurred:', e);
                }
            }
        });
    }

    // category modal box
    $('#category_done_btn').on('click', function() {
        handleAjaxRequest("{{ route('category-store') }}", '#category_done_btn', '#category_input', '#category_prefix_input',
            '#category_cancel_btn', '#category_select', '#category_error_msg');
    });

    // brand modal box
    $('#brand_done_btn').on('click', function() {
        handleAjaxRequest("{{ route('brand-store') }}", '#brand_done_btn', '#brand_input', '#brand_prefix_input', '#brand_cancel_btn',
            '#brand_select', '#brand_error_msg', null, '#category_id_select');
    });

    // design modal box
    $('#design_done_btn').on('click', function() {
        handleAjaxRequest("{{ route('design-store') }}", '#design_done_btn', '#design_input', '#design_prefix_input',
            '#design_cancel_btn', '#design_select2', '#design_error_msg');
    });

    // type modal box
    $('#type_done_btn').on('click', function() {
        handleAjaxRequest("{{ route('type-store') }}", '#type_done_btn', '#type_input','#type_prefix_input', '#type_cancel_btn',
            '#type_select2', '#type_error_msg');
    });

    // product model modal box
    $('#product_model_done_btn').on('click', function() {
        handleAjaxRequest("{{ route('product-model-store') }}", '#product_model_done_btn',
            '#product_model_input', '#product_model_prefix_input', '#product_model_cancel_btn', '#product_model_select',
            '#product_model_error_msg', '#brand_id_select', '#category_id_select2');
        
    });
</script>

<script>
    toggleInputDateBox();
    function toggleInputDateBox () 
    {
        var noRadio = $(".no");
        if (noRadio.is(":checked")) {
            $("#dateBox").show();
        } else {
            // $("#imeiBox").hide();
            $("#dateBox").hide();
        }

    }

    $(".toggle-radio input[name='is_imei']").change(toggleInputDateBox);
    toggleInputDateBox();

</script>

<script>
       
    $('select[name="category_id"]').change(function() {
         var category_id = $(this).val();
         $.ajax({
             url: "{{ route('get-category-brands') }}",
             type: 'GET',
             dataType: 'json',
             headers: {
                 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
             },
             data: {
                 id : category_id
             },
             success: function(response) {
                 $('#brand_id_select').html(response.html);

                 $('.select2').select2();
             },
             error: function(xhr, status, error) {
                 console.log(error);
             }
         });
     });
 

  </script>

@endsection
