@extends('layouts.master-without-nav')
@section('title', 'Create Supplier')
@section('css')

@endsection
@section('content')

<section class="supplier-create ">
    {{-- nav start  --}}
    @include('layouts.header-section', [
    'title' => 'Create A New Supplier',
    'subTitle' => 'Fill to create a new supplier',
    ])
    {{-- nav end  --}}

    {{-- main start --}}
    <div class="mt-5">

        <div class="grid grid-cols-1   lg:grid-cols-4 mx-4 sm:mx-10 gap-10 ">
            <div class="col-span-1 lg:col-span-1 ">

                <div class="flex items-center justify-center  ">

                    <img src="{{ asset('images/createSupplier.png') }}" class="w-1/2 lg:w-full mx-auto animate__animated animate__zoomInLeft object-contain lg:mt-32" alt="">
                </div>

            </div>

            <div class="col-span-1  lg:col-span-3 rounded-[20px] bg-white font-jakarta ">
                <form id="submitForm" action="{{ route('supplier-store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    {{-- supplier start  --}}
                    <h1 class="text-noti my-5 font-semibold text-center ">Supplier</h1>
                    <div class="form grid  sm:grid-cols-2 xl:grid-cols-3 gap-0 sm:gap-7 px-5 md:px-10">
                        <div class="mb-4">
                            <label for="" class=" block mb-2 text-paraColor font-medium text-sm">Supplier
                                Name</label>
                            <input type="text" name="name" placeholder="Supplier Name" class="outline w-full  outline-1 outline-primary px-4 py-2 rounded-2xl text-sm" value="{{ old('name') ?? '' }}">
                            @error('name')
                            <p class="text-red-600 text-xs mt-1">* {{ $message }}</p>
                            @enderror
                        </div>
                        <div class="mb-4">

                            <div class="outline-1 outline-primary outline-dashed rounded-full relative  mt-6 py-1 ">
                                <label class="cursor-pointer     text-primary rounded-full  ">
                                    <span class="flex items-center gap-3 absolute bottom-[22%] left-10">
                                        <div class="outline outline-1 outline-primary flex items-center justify-center text-primary rounded-full w-6 h-6">
                                            <i class="fa-solid fa-plus"></i>
                                        </div>
                                        <h1 class="text-sm font-jakarta" id="supplierLabel">Upload Supplier Photo</h1>
                                    </span>
                                    <input type="file" name="image" onchange="updateSupplierLabel(this)" class="opacity-0 w-full inset-0    cursor-pointer" />
                                </label>
                            </div>
                            @error('image')
                            <p class="text-red-600 text-xs mt-1">* {{ $message }}</p>
                            @enderror
                        </div>
                        <div class="mb-4 ">
                            <label for="" class=" block mb-2 text-paraColor font-medium text-sm">Supplier
                                ID</label>
                            <input type="text" name="user_number" value="{{ $supplier_id }}" placeholder="Supplier ID" class="outline w-full outline-1 outline-primary px-4 py-2 rounded-2xl text-sm" readonly>
                            @error('user_number')
                            <p class="text-red-600 text-xs mt-1">* {{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="" class=" block mb-2 text-paraColor font-medium text-sm">Phone
                                Number</label>
                            <input type="number" name="phone" placeholder="| Phone Number" class="outline w-full outline-1 outline-primary px-4 py-2 rounded-2xl text-sm" value="{{ old('phone') ?? '' }}">
                            @error('phone')
                            <p class="text-red-600 text-xs mt-1">* {{ $message }}</p>
                            @enderror
                        </div>

                        {{-- country --}}
                        <div class="mb-4">
                            <label for="" class=" block mb-2 text-paraColor font-medium  text-sm">Country</label>
                            <div>
                                <select name="country_id" class="outline-none  text-sm text-paraColor font-medium w-full   select2">
                                    <option value="">| Country</option>
                                    @forelse($countries as $country)
                                    <option value="{{ $country->id }}" {{ old('country_id') == $country->id ? 'selected' : '' }}>
                                        {{ $country->name }}
                                    </option>
                                    @empty
                                    <option value="" disabled>No Country</option>
                                    @endforelse
                                </select>
                            </div>
                            @error('country_id')
                            <p class="text-red-600 text-xs mt-1">* {{ $message }}</p>
                            @enderror
                        </div>




                    </div>

                    <div class="mb-4 px-5 md:px-10 w-full ">
                        <label for="" class=" block mb-2 text-paraColor font-medium text-sm">Address</label>
                        <textarea name="address" placeholder="Enter Address" id="" cols="" rows="3" class="outline outline-1 rounded-lg p-3 text-sm w-full outline-primary">{{ old('address') ?? '' }}</textarea>
                        @error('address')
                        <p class="text-red-600 text-xs mt-1">* {{ $message }}</p>
                        @enderror
                        {{-- supplier end  --}}

                        {{-- supplier contact person start  --}}

                        <h1 class="text-noti my-5 font-semibold text-center ">Supplier Contact Person</h1>
                        <div class="form grid  sm:grid-cols-2 lg:grid-cols-3 gap-0 sm:gap-7 ">
                            <div class="mb-4">
                                <label for="" class=" block mb-2 text-paraColor font-medium text-sm">Supplier's
                                    Contact Name</label>
                                <input type="text" name="contact_name" placeholder="Contact Person Name" class="outline w-full outline-1 outline-primary px-4 py-2 rounded-2xl text-sm" value="{{ old('contact_name') ?? '' }}">
                                @error('contact_name')
                                <p class="text-red-600 text-xs mt-1">* {{ $message }}</p>
                                @enderror
                            </div>
                            <div class="mb-4">
                                <label for="" class=" block mb-2 text-paraColor font-medium text-sm">Phone
                                    Number</label>
                                <input type="text" name="contact_phone" placeholder="| Phone Number" class="outline w-full outline-1 outline-primary px-4 py-2 rounded-2xl text-sm" value="{{ old('contact_phone') ?? '' }}">
                                @error('contact_phone')
                                <p class="text-red-600 text-xs mt-1">* {{ $message }}</p>
                                @enderror
                            </div>
                            <div class="mb-4">
                                <label for="" class=" block mb-2 text-paraColor font-medium text-sm">Work
                                    Position</label>
                                <input type="text" name="contact_position" placeholder="| Contact Position" class="outline w-full outline-1 outline-primary px-4 py-2 rounded-2xl text-sm" value="{{ old('contact_position') ?? '' }}">
                                @error('contact_position')
                                <p class="text-red-600 text-xs mt-1">* {{ $message }}</p>
                                @enderror
                            </div>

                        </div>
                        {{-- supplier contact person end --}}
                        <div class="mt-5 flex flex-col sm:flex-row sm:items-center sm:justify-center gap-3 sm:gap -10 lg:mx-20">
                            <a href="{{ route('supplier-list') }}" class="outline outline-1 outline-noti w-full sm:w-80 mb-2 rounded-full py-2  text-noti text-center">Cancel</a>
                            <button class="outline outline-1 outline-primary w-full sm:w-80 mb-4 rounded-full py-2 text-white bg-primary" id="submitButton">Done</button>
                        </div>

                    </div>
                </form>

            </div>

        </div>
    </div>

    {{-- main end --}}
</section>

@endsection

@section('script')

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="{{ asset('js/Sweetalert2.js') }}"></script>
<script src="{{ asset('js/mySelect.js') }}"></script>


{{-- get city data --}}
<script>
    // $(document).ready(function() {
    //     $('select[name="country_id"]').change(function() {
    //         var country_id = $(this).val();
    //         console.log(country_id);
    //         $.ajax({
    //             url: "{{ route('get-city-data') }}",
    //             type: 'GET',
    //             dataType: 'json',
    //             headers: {
    //                 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    //             },
    //             data: {
    //                 country_id : country_id
    //             },
    //             success: function(response) {

    //                 $('#citySelectContainer').html(response.html);

    //                 $('.select2').select2();
    //             },
    //             error: function(xhr, status, error) {
    //                 console.log(error);
    //             }
    //         });
    //     });
    // });
</script>
<script>
    function updateSupplierLabel(input) {
        const supplierLabel = document.getElementById("supplierLabel");

        if (input.files.length > 0) {
            supplierLabel.textContent = input.files[0].name.substring(input.files[0].name.length - 20);
        } else {
            supplierLabel.textContent = "Upload Bar Code";
        }
    }
</script>
@endsection