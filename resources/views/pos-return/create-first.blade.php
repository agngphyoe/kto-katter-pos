@extends('layouts.master-without-nav')
@section('title', 'POS Return Create')
@section('css')

@endsection
@section('content')
<section class="pos_return_create_first">
    {{-- nav start  --}}
    @include('layouts.header-section', [
    'title' => 'Purchase A New POS Return',
    'subTitle' => 'Fill these to know the customer you want to return',
    ])
    {{-- nav end  --}}

    {{-- ........  --}}
    {{-- main start  --}}
    <div>

        {{-- form start  --}}
        <div class="m-5 lg:m-10">
            <div class="bg-white rounded-[20px] mb-5 shadow-xl">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-10 p-5 lg:p-10">
                    <div class="col-span-1">
                        <div class="bg-bgMain p-5 rounded-[20px]  md:mx-0">

                            <img src="{{ asset('images/createCustomer.png') }}" class="w-48 animate__animated animate__bounce h-48 mx-auto" alt="">
                        </div>
                    </div>
                    <div class="col-span-1">
                        <form id="myForm" action="{{ route('pos-return-create-second') }}">
                            @csrf
                            <div class="flex  flex-col mb-5">

                                <label for="" class="block mb-2 font-jakarta text-paraColor font-medium text-sm">Select
                                    Shopper</label>
                                <select name="shopper_id" id="shopperSelect" class="select2 outline-none w-full" required>
                                    <option value="" selected disabled>Customer</option>
                                    @forelse ($shoppers as $shopper)
                                    <option value="{{ $shopper->id }}">{{ $shopper->name }}
                                        ({{ $shopper->code }})</option>
                                    @empty
                                    @endforelse
                                </select>
                                @error('shopper_id')
                                <p class="text-red-600 text-xs mt-1">* {{ $message }}</p>
                                @enderror

                            </div>

                            
                            
                            <div>
                                <button class="bg-noti font-jakarta text-white rounded-full px-5 py-2 w-full " type="submit" id="done">Done</button>
                            </div>



                        </form>
                    </div>
                </div>

            </div>
        </div>
        {{-- form end --}}

        {{-- .........  --}}
        {{-- detail start  --}}
        <div class="mx-5 lg:mx-10">
            <div class="bg-white rounded-[20px]">
                <div class="p-5 ">
                    <h1 class="text-noti font-semibold font-jakarta text-center mb-4">Shopper Details</h1>
                    <div id="shopperDetail"></div>
                </div>
            </div>
        </div>
        {{-- detail end --}}
    </div>
    {{-- main end --}}
</section>
@endsection
@section('script')

{{-- get customer ID --}}
<script>
    $(document).ready(function() {
        $('#shopperSelect').change(function() {
            var selectedValue = $(this).val();

            $.ajax({
                url: "{{ route('get-selected-shopper-detail') }}",
                type: 'GET',
                dataType: 'json',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    shopperId: selectedValue
                },
                success: function(response) {
                    $('#code').val(response.code);
                    $('#shopperDetail').html(response.html);
                },
                error: function(xhr, status, error) {
                    console.error(error);
                }
            });
        });
    });
</script>


@endsection