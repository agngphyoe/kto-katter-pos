@extends('layouts.master-without-nav')
@section('title', 'Create Promotion')
@section('css')

@endsection
@section('content')

<section class="promotion_create">
    {{-- nav start  --}}
    @include('layouts.header-section', [
    'title' => 'Create A New Promotion',
    'subTitle' => 'Fill to create a new Promotion',
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

                    <form action="{{ route('promotion-create-second') }}" method="GET">
                        @csrf
                        <div>                            
                            <div class="mb-10 flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
                                <label for="" class="font-jakarta text-paraColor font-semibold">Promo Code </label>
                                <div class="mr-[50px]">
                                    <div class="outline outline-1 flex items-center text-sm font-jakarta text-paraColor w-[300px] outline-primary rounded-full ">
                                        {{-- <div class=" py-2 px-3 bg-bgMain text-primary border-r border-primary rounded-l-full">
                                            
                                        </div> --}}
                                        <input type="text" placeholder="Enter Promo Code" name="promo_code" value="{{ $promo_code }}" class=" py-2 flex-grow rounded-r-full  px-3  outline-none" required readonly>
                                    </div>
                                    {{-- @error('code')
                                    <p class="text-red-600 text-xs mt-1">* {{ $message }}</p>
                                    @enderror --}}
                                </div>
                            </div>

                            <div class="mb-10 flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
                                <label for="" class="font-jakarta text-paraColor font-semibold">Title<span class="text-red-600 ml-1">*</span></label>
                                <div class="mr-[50px]">
                                    <div class="outline outline-1 flex items-center text-sm font-jakarta text-paraColor w-[300px] outline-primary rounded-full ">
                                        <input type="text" placeholder="Enter Title" name="title" class=" py-2 flex-grow rounded-r-full  px-3  outline-none" required>
                                    </div>
                                    {{-- @error('code')
                                    <p class="text-red-600 text-xs mt-1">* {{ $message }}</p>
                                    @enderror --}}
                                </div>
                                
                            </div>

                            <div class="mb-10 flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
                                <label for="" class="font-jakarta text-paraColor font-semibold">At Location<span class="text-red-600 ml-1">*</span></label>

                                <div class="mr-[50px]">
                                    <select name="locations[]" class="product-select select2" id="location_select" multiple required>
                                        <option value="all">All Locations</option>
                                        @forelse ($locations as $location)
                                            <option value="{{ $location->id }}" class="outline-none font-Pop">{{ $location->location_name }}</option>
                                        @empty
                                            <option value="" class="outline-none font-Pop" disabled selected>No Data</option>
                                        @endforelse            
                                    </select>
                                </div>
                            </div>

                            {{-- quantity --}}
                            <div class="mb-10 flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
                                <label for="" class="font-jakarta text-paraColor font-semibold">Promo Type<span class="text-red-600 ml-1">*</span></label>

                                <div class="mr-[50px]">
                                    <select name="promo_type" class="product-select select2" id="" required>
                                        <option value="dis_percentage" class="outline-none font-Pop" >Discount (%)</option>
                                        <option value="dis_price" class="outline-none font-Pop" >Discount (Price)</option>
                                        <option value="cashback" class="outline-none font-Pop" >Cashback</option>         
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="w-full flex items-center gap-10 justify-center">
                            <a href="{{ route('promotion') }}">
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

{{-- get product model data --}}

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

<script>
    $(document).ready(function() {
        $('#location_select').change(function() {
            var selectedValue = $(this).val();
            console.log(selectedValue);
            if (selectedValue && selectedValue.length === 1 && selectedValue[0] === 'all') {
                $(this).find('option:not(:selected)').prop('disabled', true); // Keep only 'all' selected
            }else{
                $(this).find('option').prop('disabled', false);
            }
        });
    });
</script>

@endsection
