@extends('layouts.master-without-nav')
@section('title', 'Create Promotion')
@section('css')

@endsection
@section('content')

<section class="promotion_create">
    {{-- nav start  --}}
    @include('layouts.header-section', [
    'title' => 'Create A New Promotion',
    'subTitle' => 'Fill Data',
    ])
    {{-- nav end  --}}

    {{-- main form   --}}
    <div class="my-7 mx-5">
        <div class="lg:flex  lg:justify-around gap-10">
            <div class="mb-5">
                <img src="{{ asset('images/promotion_create.png') }}" class="w-1/2 lg:w-full mx-auto  animate__animated animate__jackInTheBox object-contain" alt="">
            </div>

            <div class="bg-white w-full md:w-[800px] mx-auto lg:mx-0 mb-5 lg:mb-0  rounded-[20px]">
                <div class="px-5 md:px-14 py-10 ">

                    <form action="{{ route('promotion-create-third') }}" method="GET">
                        @csrf
                        
                        <div>
                    
                            {{-- choose method --}}
                            <div class="mb-10 flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
                                <label for="" class="font-jakarta text-paraColor font-semibold">Choose By :<span class="text-red-600 ml-1">*</span></label>

                                <div class="mr-[50px]">
                                    <select name="choose_by" class="product-select select2" id="choose_by" required>
                                        <option value="brands" class="outline-none font-Pop" >By Brands</option>
                                        <option value="products" class="outline-none font-Pop" >By Products</option>
                                    </select>
                                </div>
                            </div>


                            {{-- category --}}
                            <div class="mb-10 flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
                                <label for="" class="font-jakarta text-paraColor font-semibold">Category</label>
                                <div class="mr-[50px]">
                                    <select name="category_id" class="product-select select2" id="category_id" required>
                                        @forelse ($categories as $category)
                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @empty
                                            
                                        @endforelse
                                        
                                    </select>
                                </div>
                            </div>

                            <div class="mb-10 flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
                                <label for="" class="font-jakarta text-paraColor font-semibold">Brand</label>
                                <div class="mr-[50px]">
                                    <select name="brand_id" class="product-select select2" id="brand_id" required>
                                        <option value="" disabled selected>Choose Brand</option>                            
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="w-full flex items-center gap-10 justify-center">
                            <a href="{{ route('promotion-create-first') }}">
                                <button type="button" class="outline outline-1 text-noti font-semibold font-jakarta text-sm outline-noti  w-32 py-2 rounded-2xl">Cancel</button>
                            </a>
                                <button type="submit" class="text-sm bg-primary  font-semibold font-jakarta text-white  w-32  py-2 rounded-2xl" id="done">Next</button>

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
    $(document).ready(function () {
        $('#choose_by').on('change', function () {
            var selectedValue = $(this).val();
            
            if (selectedValue === 'products') {
                $('#category_id, #brand_id').prop('disabled', true);
            } else {
                $('#category_id, #brand_id').prop('disabled', false);
            }
        });
    });
</script>

<script>
    $(document).ready(function () {
        $('#category_id').on('change', function () {
            var categoryId = $(this).val();
            
            if (categoryId) {
                $.ajax({
                    url: '{{ route("promotion-get-brands") }}',
                    type: 'GET',
                    data: { category_id: categoryId },
                    success: function (response) {
                        $('#brand_id').empty().append('<option value="" disabled>Select Brand</option>');
                        $.each(response.brands, function (key, value) {
                            $('#brand_id').append('<option value="' + value.id + '">' + value.name + '</option>');
                        });
                    }
                });
            } else {
                $('#brand_id').empty().append('<option value="" disabled>Select Brand</option>');
            }
        });
    });
</script>

@endsection
