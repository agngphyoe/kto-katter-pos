@extends('layouts.master-without-nav')
@section('title', 'Edit Product')
@section('css')
    <style>
        .toast {
            font-family: Poppins;
            top: 100px;

        }
    </style>
@endsection
@section('content')
    <section>

        {{-- nav start  --}}
        @include('layouts.header-section', [
            'title' => 'Edit Product',
            'subTitle' => 'Fill to edit product',
        ])
        {{-- nav end  --}}
        <form id="myForm" action="{{ route('product-update', ['product' => $product->id]) }}" method="POST"
            enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="create  2xl:h-screen ">
                <div class="mt-10   ">
                    <div class="xl:flex  xl:justify-center gap-3 ">
                        <div class="bg-white w-full  sm:mx-auto md:w-[600px] px-3  xl:mx-0 mb-5 lg:mb-0  rounded-[20px]">
                            <div class="px-10 md:px-12 py-10 ">

                                <div class="mb-10 flex items-center justify-center">
                                    <div
                                        class="outline outline-1 flex items-center text-sm font-jakarta text-paraColor w-[300px] outline-primary rounded-full ">
                                        <div class=" py-2 flex-grow rounded-r-full  px-3  outline-none">
                                            {{--  {{ $product_prefix?->prefix }} -  --}}
                                            {{ $product->code }}
                                        </div>

                                    </div>

                                </div>
                                <div>
                                    {{-- prodcut code  --}}
                                    <div class="mb-10 flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
                                        <label for=""
                                            class="font-jakarta text-paraColor font-semibold mb-3 ">Product
                                            Name</label>
                                        <input type="text"
                                            class="outline outline-1 font-jakarta text-paraColor  text-sm outline-primary px-4 py-2 rounded-full custom-input  font-semibold"
                                            placeholder="| Product Name" class="" name="name" id=""
                                            value="{{ $product->name }}">

                                        {{--  <button
                                            class="outline custom-input outline-1 font-jakarta text-paraColor  text-sm custom-input outline-primary px-16 py-2 rounded-full">
                                            {{ $product->code }}
                                        </button>  --}}
                                    </div>



                                    {{-- category --}}
                                    <div class="mb-10 flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
                                        <label for=""
                                            class="font-jakarta text-paraColor font-semibold mb-3">Categories</label>
                                        <div>
                                            <select name="category_id" class="custom-input select2">
                                                <option value="" class="px-10" selected disabled>Select Category
                                                </option>
                                                @forelse ($categories as $category)
                                                    <option value="{{ $category->id }}"
                                                        {{ $product->category_id == $category->id ? 'selected' : '' }}>
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

                                    </div>



                                    {{-- brand --}}
                                    <div class="mb-10 flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
                                        <label for=""
                                            class="font-jakarta text-paraColor font-semibold mb-3 ">Brand</label>
                                        <div>
                                            <select name="brand_id" id="brand_select" class="custom-input select2">
                                                <option value="" class="px-10" selected disabled>Select Brand
                                                </option>
                                                @forelse ($brands as $brand)
                                                    <option value="{{ $brand->id }}"
                                                        {{ $product->brand_id == $brand->id ? 'selected' : '' }}>
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

                                    </div>


                                    {{-- model --}}
                                    <div id="modelSelectContainer">
                                        <div
                                            class="mb-10 flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
                                            <label for=""
                                                class="font-jakarta text-paraColor font-semibold mb-3 ">Model</label>
                                            <div>
                                                <select name="model_id" class="custom-input select2" id="product_model_select">
                                                    <option value="" class="px-10" selected disabled>Select Model
                                                    </option>
                                                    @forelse ($product_models as $product_model)
                                                        <option value="{{ $product_model->id }}"
                                                            {{ $product->model_id == $product_model->id ? 'selected' : '' }}>
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

                                        </div>
                                    </div>


                                    {{-- design --}}
                                    <div class="mb-10 flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
                                        <label for=""
                                            class="font-jakarta text-paraColor font-semibold mb-3 ">Design</label>
                                        <div>
                                            <select name="design_id" class="custom-input select2">
                                                <option value="" class="px-10" selected disabled>Select Design
                                                </option>
                                                @forelse ($designs as $design)
                                                    <option value="{{ $design->id }}"
                                                        {{ $product->design_id == $design->id ? 'selected' : '' }}>
                                                        {{ $design->name }}
                                                    </option>
                                                @empty
                                                    <option value="" disabled>No Model</option>
                                                @endforelse
                                            </select>
                                            @error('design_id')
                                                <p class="text-red-600 text-xs mt-1">* {{ $message }}</p>
                                            @enderror
                                        </div>

                                    </div>


                                    {{-- type --}}
                                    <div class="mb-10 flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
                                        <label for=""
                                            class="font-jakarta text-paraColor font-semibold ">Type</label>
                                        <div>
                                            <select name="type_id" class="custom-input select2">
                                                <option value="" class="px-10" selected disabled>Select Type</option>
                                                @forelse ($types as $type)
                                                    <option value="{{ $type->id }}"
                                                        {{ $product->type_id == $type->id ? 'selected' : '' }}>
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

                                    </div>

                                    {{-- minimum quantity --}}
                                    <div class="mb-10 flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
                                        <label for="" class="font-jakarta text-paraColor font-semibold ">Minimum
                                            Quantity</label>
                                        <div>
                                            <input type="number" name="minimum_quantity"
                                                placeholder="Enter Minimum Quantity"
                                                class="outline outline-1 font-jakarta text-paraColor  text-sm custom-input outline-primary px-4 py-2 rounded-full"
                                                value="{{ $product->minimum_quantity }}" min="0">
                                            @error('minimum_quantity')
                                                <p class="text-red-600 text-xs mt-1">* {{ $message }}</p>
                                            @enderror
                                        </div>

                                    </div>


                                    {{-- product image --}}
                                    <div class="mb-10 flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
                                        <label for="" class="font-jakarta text-paraColor font-semibold ">Photo
                                        </label>
                                        <div
                                            class="outline-1 cursor-pointer outline-primary outline-dashed rounded-full relative   py-1 ">
                                            <label class="cursor-pointer     text-primary rounded-full  ">
                                                <span class="flex items-center gap-3 absolute bottom-[22%] left-10">
                                                    <div
                                                        class="outline outline-1 font-jakarta cursor-pointer outline-primary flex items-center justify-center text-primary rounded-full w-6 h-6">
                                                        <i class="fa-solid fa-plus cursor-pointer"></i>
                                                    </div>
                                                    <h1 class="text-sm font-jakarta" id="uploadLabel">Upload Product Photo
                                                    </h1>
                                                </span>
                                                <input type="file" value="{{ $product->image }}" id="file_input"
                                                    name="image" class="opacity-0 w-full inset-0    cursor-pointer"
                                                    onchange="updateUploadLabel(this)" />
                                            </label>
                                        </div>
                                        @error('image')
                                            <p class="text-red-600 text-xs mt-1">* {{ $message }}</p>
                                        @enderror


                                    </div>


                                </div>
                                <div class="w-full flex items-center justify-center gap-10">
                                    <a href="{{ route('product-list') }}">
                                        <button type="button"
                                            class="outline outline-1 text-noti font-semibold font-jakarta text-sm outline-noti w-32 py-2 rounded-2xl">Cancel</button>
                                    </a>
                                    <button type="submit"
                                        class="text-sm bg-primary  text-white font-semibold font-jakarta  w-32 py-2 rounded-2xl"
                                        id="done">Done</button>
                                </div>
                            </div>
                        </div>
                        {{-- <div
                            class="bg-white w-full font-poppins  sm:mx-auto md:w-[400px] p-5  xl:mx-0 mb-5 lg:mb-0  rounded-[20px]">
                            <div class="flex items-center justify-center">
                                <h1 class="mb-3 text-primary text-center font-semibold ">IMEI Code</h1>
                            </div>
                            <div class="overflow-y-auto h-[700px]">
                                <div class="grid grid-cols-2 gap-5 mt-5 ">
                                    <div class="border  shadow-md p-2">
                                        <img src="{{ asset('images/barcode.jpg') }}" alt="">
                                        <h1 class="text-center text-sm">123456789234</h1>
                                    </div>
                                    <div class="border shadow-md p-2">
                                        <img src="{{ asset('images/barcode.jpg') }}" alt="">
                                        <h1 class="text-center">123456789234</h1>
                                    </div>
                                    <div class="border shadow-md p-2">
                                        <img src="{{ asset('images/barcode.jpg') }}" alt="">
                                        <h1 class="text-center">123456789234</h1>
                                    </div>
                                    <div class="border shadow-md p-2">
                                        <img src="{{ asset('images/barcode.jpg') }}" alt="">
                                        <h1 class="text-center">123456789234</h1>
                                    </div>
                                    <div class="border shadow-md p-2">
                                        <img src="{{ asset('images/barcode.jpg') }}" alt="">
                                        <h1 class="text-center">123456789234</h1>
                                    </div>
                                    <div class="border shadow-md p-2">
                                        <img src="{{ asset('images/barcode.jpg') }}" alt="">
                                        <h1 class="text-center">123456789234</h1>
                                    </div>
                                    <div class="border shadow-md p-2">
                                        <img src="{{ asset('images/barcode.jpg') }}" alt="">
                                        <h1 class="text-center">123456789234</h1>
                                    </div>
                                    <div class="border shadow-md p-2">
                                        <img src="{{ asset('images/barcode.jpg') }}" alt="">
                                        <h1 class="text-center">123456789234</h1>
                                    </div>
                                    <div class="border shadow-md p-2">
                                        <img src="{{ asset('images/barcode.jpg') }}" alt="">
                                        <h1 class="text-center">123456789234</h1>
                                    </div>
                                    <div class="border shadow-md p-2">
                                        <img src="{{ asset('images/barcode.jpg') }}" alt="">
                                        <h1 class="text-center">123456789234</h1>
                                    </div>
                                    <div class="border shadow-md p-2">
                                        <img src="{{ asset('images/barcode.jpg') }}" alt="">
                                        <h1 class="text-center">123456789234</h1>
                                    </div>
                                    <div class="border shadow-md p-2">
                                        <img src="{{ asset('images/barcode.jpg') }}" alt="">
                                        <h1 class="text-center">123456789234</h1>
                                    </div>
                                    <div class="border  shadow-md p-2">
                                        <img src="{{ asset('images/barcode.jpg') }}" alt="">
                                        <h1 class="text-center">123456789234</h1>

                                    </div>
                                    <div class="border shadow-md p-2">
                                        <img src="{{ asset('images/barcode.jpg') }}" alt="">
                                        <h1 class="text-center">123456789234</h1>
                                    </div>
                                    <div class="border shadow-md p-2">
                                        <img src="{{ asset('images/barcode.jpg') }}" alt="">
                                        <h1 class="text-center">123456789234</h1>
                                    </div>
                                    <div class="border shadow-md p-2">
                                        <img src="{{ asset('images/barcode.jpg') }}" alt="">
                                        <h1 class="text-center">123456789234</h1>
                                    </div>
                                    <div class="border shadow-md p-2">
                                        <img src="{{ asset('images/barcode.jpg') }}" alt="">
                                        <h1 class="text-center">123456789234</h1>
                                    </div>
                                    <div class="border shadow-md p-2">
                                        <img src="{{ asset('images/barcode.jpg') }}" alt="">
                                        <h1 class="text-center">123456789234</h1>
                                    </div>
                                    <div class="border shadow-md p-2">
                                        <img src="{{ asset('images/barcode.jpg') }}" alt="">
                                        <h1 class="text-center">123456789234</h1>
                                    </div>
                                    <div class="border shadow-md p-2">
                                        <img src="{{ asset('images/barcode.jpg') }}" alt="">
                                        <h1 class="text-center">123456789234</h1>
                                    </div>
                                    <div class="border shadow-md p-2">
                                        <img src="{{ asset('images/barcode.jpg') }}" alt="">
                                        <h1 class="text-center">123456789234</h1>
                                    </div>
                                    <div class="border shadow-md p-2">
                                        <img src="{{ asset('images/barcode.jpg') }}" alt="">
                                        <h1 class="text-center">123456789234</h1>
                                    </div>
                                    <div class="border shadow-md p-2">
                                        <img src="{{ asset('images/barcode.jpg') }}" alt="">
                                        <h1 class="text-center">123456789234</h1>
                                    </div>
                                    <div class="border shadow-md p-2">
                                        <img src="{{ asset('images/barcode.jpg') }}" alt="">
                                        <h1 class="text-center">123456789234</h1>
                                    </div>

                                </div>
                            </div>


                        </div> --}}
                    </div>
                </div>
            </div>
            </div>
        </form>




    </section>

@endsection
@section('script')

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
        function updateUploadLabel(input) {
            const uploadLabel = document.getElementById("uploadLabel");

            if (input.files.length > 0) {
                uploadLabel.textContent = input.files[0].name.substring(input.files[0].name.length - 20);
            } else {
                uploadLabel.textContent = "Upload Customer Photo";
            }
        }
    </script>
    {{-- <script>
        setTimeout(function() {
            Toastify({
                text: "IMEI already added !",
                className: "toast",
                gravity: "top",
                position: 'center',
                close: true,
                style: {
                    background: "linear-gradient(to right, #ff5f6d, #ffc371)",
                }
            }).showToast();
        }, 3000);
    </script> --}}

@endsection
