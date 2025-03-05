@extends('layouts.master-without-nav')
@section('title', 'Create Product Return')
@section('css')

@endsection
@section('content')
@php
use App\Constants\PrefixCodeID;
@endphp
<section class="product_return_create">
    {{-- nav start  --}}
    @include('layouts.header-section', [
    'title' => 'Create A New Product Return',
    'subTitle' => 'Fill to build a new Return',
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

                    <form action="{{ route('product-return-create-second') }}" enctype="multipart/form-data">
                        @csrf
                        <div>
                            {{-- product code  --}}
                            @php
                            $product_code = explode("-", $product_code);
                            @endphp
                            <div class="mb-10 flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
                                <label for="" class="font-jakarta text-paraColor font-semibold">Return ID </label>
                                <div class="mr-[50px]">
                                    <div class="outline outline-1 flex items-center text-sm font-jakarta text-paraColor w-[300px] outline-primary rounded-full ">
                                        <div class=" py-2 px-3 bg-bgMain text-primary border-r border-primary rounded-l-full">
                                            {{ PrefixCodeID::RETURN }} -
                                        </div>
                                        <input type="number" placeholder="Enter Return Code" name="return_code" value="{{ $product_code[1] }}" class=" py-2 flex-grow rounded-r-full  px-3  outline-none">
                                    </div>
                                    @error('code')
                                    <p class="text-red-600 text-xs mt-1">* {{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-10 flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
                                <label for="" class="font-jakarta text-paraColor font-semibold">Return From <span class="text-red-600">*</span></label>

                                <div class="mr-[50px]">
                                    <select name="from_location_id" class="product-select select2" id="from_location_id_select" required>
                                        @forelse($from_locations as $from)
                                            <option value="{{ $from->location_id ?? $from->id }}" class="outline-none font-Pop">{{ $from->location_name }}</option>
                                        @empty
                                            <option value="" class="outline-none font-Pop" selected>No Data</option>
                                        @endforelse
                                    </select>
                                </div>
                            </div>

                            <div class="mb-10 flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
                                <label for="" class="font-jakarta text-paraColor font-semibold">Return To <span class="text-red-600">*</span></label>

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
    const addPhotoImg = document.getElementById('addPhoto');
    const photoInput = document.getElementById('photoInput');

    addPhotoImg.addEventListener('click', function() {
        photoInput.click();
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
    function handleAjaxRequest(routeName, doneBtn, inputElementId, cancelButtonId, selectElement, errorMsgId, brandId =
        null) {
        $(doneBtn).hide();
        setTimeout(() => {
            $(doneBtn).show();
        }, 3000);
        var inputValue = $(inputElementId).val();
        var brand_id = $(brandId).val();
        $.ajax({
            url: routeName,
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                name: inputValue,
                brand_id: brand_id,
            },
            success: function(response) {
                $(cancelButtonId).click();
                $(selectElement).html(response.html);
                if (routeName == "{{route('brand-store')}}") {
                    $('#brand_id_select').html(response.html);
                }
                if (routeName == "{{ route('product-model-store') }}") {
                    $('#brand_select').html(response.selected_brand);
                }
                $(inputElementId).val('');
                $('#product_model_select').html(response.html);
                $(errorMsgId).text('');
                $('#brand_id_error_msg').css('display', 'none');
            },
            error: function(xhr, status, error) {
                try {
                    var response = JSON.parse(xhr.responseText);
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
        handleAjaxRequest("{{ route('category-store') }}", '#category_done_btn', '#category_input',
            '#category_cancel_btn', '#category_select', '#category_error_msg');
    });

    // brand modal box
    $('#brand_done_btn').on('click', function() {
        handleAjaxRequest("{{ route('brand-store') }}", '#brand_done_btn', '#brand_input', '#brand_cancel_btn',
            '#brand_select', '#brand_error_msg');
    });

    // design modal box
    $('#design_done_btn').on('click', function() {
        handleAjaxRequest("{{ route('design-store') }}", '#design_done_btn', '#design_input',
            '#design_cancel_btn', '#design_select', '#design_error_msg');
    });

    // type modal box
    $('#type_done_btn').on('click', function() {
        handleAjaxRequest("{{ route('type-store') }}", '#type_done_btn', '#type_input', '#type_cancel_btn',
            '#type_select', '#type_error_msg');
    });

    // product model modal box
    $('#product_model_done_btn').on('click', function() {
        handleAjaxRequest("{{ route('product-model-store') }}", '#product_model_done_btn',
            '#product_model_input', '#product_model_cancel_btn', '#product_model_select',
            '#product_model_error_msg', '#brand_id_select');
        // var brand_id = $('#brand_id_select').val();
        // var product_model_name = $('#product_model_input').val();

        // $.ajax({
        //     url: "{{ route('product-model-store') }}",
        //     method: 'POST',
        //     headers: {
        //         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        //     },
        //     data: {
        //         name: product_model_name,
        //         brand_id: brand_id,
        //     },
        //     success: function(response) {
        //         $('#product_model_cancel_btn').click();
        //         $('#product_model_select').html(response.html);
        //         $('#product_model_input').val(' ');
        //         $('#brand_id_select').val('Choose Brand');
        //     },
        //     error: function(xhr, status, error) {
        //         console.error(error);
        //     }
        // });

    });
</script>

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
