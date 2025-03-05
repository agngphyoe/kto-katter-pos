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

                    <form action="{{ route('promotion-choose-method') }}" method="GET">
                        @csrf
                        
                        <div>
                            @if(session()->get('promo_type') !== 'cashback')                        
                                <div class="mb-10 flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
                                    <label for="" class="font-jakarta text-paraColor font-semibold">Discount Value<span class="text-red-600 ml-1">*</span></label>
                                    <div class="mr-[50px]">
                                        <div class="relative outline outline-1 flex items-center text-sm font-jakarta text-paraColor w-[300px] outline-primary rounded-full">
                                            <input type="number" placeholder="20" name="value" class="py-2 flex-grow rounded-r-full px-3 outline-none">
                                            @if (session()->get('promo_type') == 'dis_percentage')
                                                <span class="absolute inset-y-0 right-3 flex items-center pointer-events-none">%</span>                                               
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endif

                            {{-- variant --}}
                            <div class="mb-10 flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
                                <label for="" class="font-jakarta text-paraColor font-semibold">Variant<span class="text-red-600 ml-1">*</span></label>

                                <div class="mr-[50px]">
                                    <select name="variant" class="product-select select2" id="variant" required>
                                        <option value="time" class="outline-none font-Pop" >Time</option>
                                        {{-- <option value="quantity" class="outline-none font-Pop" >Quantity</option> --}}
                                        {{-- <option value="time-quantity" class="outline-none font-Pop" >Time + Quantity</option>          --}}
                                    </select>
                                </div>
                            </div>

                            <div class="mb-10 flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
                                <label for="" class="font-jakarta text-paraColor font-semibold">Start Date<span class="text-red-600 ml-1">*</span></label>
                                <div class="mr-[50px]">
                                    <div class="outline outline-1 flex items-center text-sm font-jakarta text-paraColor w-[300px] outline-primary rounded-full ">
                                        <input type="date" name="start_date" class="py-2 flex-grow rounded-r-full px-3 outline-none" required>
                                    </div>
                                    {{-- @error('code')
                                    <p class="text-red-600 text-xs mt-1">* {{ $message }}</p>
                                    @enderror --}}
                                </div>
                                
                            </div>

                            {{-- quantity --}}
                            <div class="mb-10 flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
                                <label for="" class="font-jakarta text-paraColor font-semibold">End Date<span class="text-red-600 ml-1">*</span></label>

                                <div class="mr-[50px]">
                                    <div class="outline outline-1 flex items-center text-sm font-jakarta text-paraColor w-[300px] outline-primary rounded-full ">
                                        <input type="date" name="end_date" class="py-2 flex-grow rounded-r-full px-3 outline-none" required>
                                    </div>
                                    {{-- @error('code')
                                    <p class="text-red-600 text-xs mt-1">* {{ $message }}</p>
                                    @enderror --}}
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

{{-- modal boxes start --}}

{{-- <script>
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
    </script> --}}

@endsection
