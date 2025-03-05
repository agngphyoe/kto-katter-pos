@extends('layouts.master-without-nav')
@section('title', 'Create User')
@section('css')

@endsection
@section('content')
<section class="user__create">
    {{-- nav start  --}}
    @include('layouts.header-section', [
    'title' => 'Create New User',
    'subTitle' => '',
    ])
    {{-- nav end  --}}

    <div class="mt-5">

        <div class="grid grid-cols-1   lg:grid-cols-4 mx-4 sm:mx-10 gap-10 ">
            <div class="col-span-1 lg:col-span-1 ">

                <div class="flex items-center justify-center  ">

                    <img src="{{ asset('images/supplier1.png') }}" class="lg:mt-32" alt="">
                </div>

            </div>

            <div class="col-span-1  lg:col-span-3 rounded-[20px] bg-white font-jakarta ">
                <form id="submitForm" action="{{ route('user-create-final') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    {{-- user start  --}}
                    <h1 class="text-noti my-5 font-semibold text-center text-xl">User ID - <span class="bg-noti text-white px-4 py-1 text-sm rounded-full font-normal">{{ $user_number }}</span>
                    </h1>
                    <input value="{{ $user_number }}" name="user_number" hidden>
                    <div class="form grid  sm:grid-cols-2 xl:grid-cols-3 gap-0 sm:gap-7 px-5 md:px-10">
                        {{-- username --}}
                        <div class="mb-4">
                            <label for="" class=" block mb-2 text-paraColor font-medium text-sm">User
                                Name <span class="text-red-600">*</span></label>
                            <input type="text" name="name" placeholder="User Name" class="outline w-full  outline-1 outline-primary px-4 py-2 rounded-2xl text-sm" name="name" value="{{ old('name') }}">
                            @error('name')
                            <p class="text-red-600 text-xs mt-1">* {{ $message }}</p>
                            @enderror
                        </div>
                        {{-- Password --}}
                        <div class="mb-4">
                            <label for="" class=" block mb-2 text-paraColor font-medium text-sm">Password <span class="text-red-600">*</span></label>
                            <input type="password" name="password" placeholder="password" class="outline w-full  outline-1 outline-primary px-4 py-2 rounded-2xl text-sm">
                            @error('password')
                            <p class="text-red-600 text-xs mt-1">* {{ $message }}</p>
                            @enderror

                        </div>
                        {{-- Comfirm Password --}}
                            <div class="mb-4">
                                <label for="" class=" block mb-2 text-paraColor font-medium text-sm">Confirm
                                    Password <span class="text-red-600">*</span></label>
                                <input type="password" name="confirm_password" placeholder="confirm password" class="outline w-full  outline-1 outline-primary px-4 py-2 rounded-2xl text-sm" name="confirm_password">
                                @error('confirm_password')
                                <p class="text-red-600 text-xs mt-1">* {{ $message }}</p>
                                @enderror

                            </div>
                        {{-- phone number --}}
                        <div class="mb-4">
                            <label for="" class=" block mb-2 text-paraColor font-medium text-sm">Phone
                                Number <span class="text-red-600">*</span></label>
                            <input type="number" name="phone" placeholder="+95 9456639939" class="outline w-full  outline-1 outline-primary px-4 py-2 rounded-2xl text-sm" value="{{ old('phone') }}">
                            @error('phone')
                            <p class="text-red-600 text-xs mt-1">* {{ $message }}</p>
                            @enderror

                        </div>

                        {{-- role --}}
                        <div class="mb-4">
                            <label for="" class=" block mb-2 text-paraColor font-medium  text-sm">Role <span class="text-red-600">*</span></label>

                            <select name="role_id" class="outline-none  text-sm text-paraColor font-medium w-full   select2">
                                <option value="">| Select a Role</option>
                                @forelse($roles as $role)
                                <option value="{{ $role->id }}" {{ old('role_id') == $role->id ? 'selected' : '-' }}>{{ $role->name }}
                                </option>
                                @empty
                                <option value="" disabled>No Role</option>
                                @endforelse

                            </select>
                            @error('role_id')
                            <p class="text-red-600 text-xs mt-1">* {{ $message }}</p>
                            @enderror

                        </div>

                        {{-- photo --}}
                        <div class="mb-4">
                            <label for="" class=" block mb-2  text-paraColor font-medium text-sm">User Photo</label>
                            <div class="outline-1 outline-primary outline-dashed rounded-full relative   py-1 ">
                                <label class="cursor-pointer     text-primary rounded-full  ">
                                    <span class="flex items-center gap-3 absolute bottom-[22%] left-10">
                                        <div class="outline outline-1 outline-primary flex items-center justify-center text-primary rounded-full w-6 h-6">
                                            <i class="fa-solid fa-plus"></i>
                                        </div>
                                        <h1 class="text-sm font-jakarta" id="supplierLabel">Upload User Photo</h1>
                                    </span>
                                    <input type="file" name="image" onchange="updateSupplierLabel(this)" class="opacity-0 w-full inset-0    cursor-pointer" />
                                </label>
                            </div>

                            @error('image')
                            <p class="text-red-600 text-xs mt-1">* {{ $message }}</p>
                            @enderror
                        </div>

                        {{-- location --}}
                        <div class="mb-4 xl:col-span-3">
                            <label for="" class="block mb-2 text-paraColor font-medium text-sm ">Locations <span class="text-red-600">*</span></label>
                            <select name="location_id[]" id="location_select" class="w-full select2" required multiple>
                                <option value="" disabled>| Select </option>
                                <option value="select_all">Select All</option>
                                @forelse($locations as $location)
                                    <option value="{{ $location->id }}">{{ $location->location_name }}</option>
                                @empty
                                    <option placeholder=""  disabled selected>No Data</option>
                                @endforelse
                            </select>
                        </div>
                </div>
            <div class="flex items-center justify-center mt-5 pb-5">
                <x-button-component class="bg-noti text-white" type="submit" id="submitButton">
                    Next
                </x-button-component>
            </div>

            </form>

        </div>

    </div>
    </div>
    {{-- main end --}}

</section>
@endsection
@section('script')
{{-- <script>
    const addPhotoImg = document.getElementById('addPhoto');
    const photoInput = document.getElementById('photoInput');

    addPhotoImg.addEventListener('click', function() {
        photoInput.click();
    });
</script> --}}

<script>
    function updateSupplierLabel(input) {
        const supplierLabel = document.getElementById("supplierLabel");

        if (input.files.length > 0) {
            supplierLabel.textContent = input.files[0].name.substring(input.files[0].name.length - 20);
        } else {
            supplierLabel.textContent = "Upload Customer Photo";
        }
    }
</script>

<script>
    $(document).ready(function() {
        var isSelectAllTrigger = false;

        $('#location_select').change(function() {
            if (isSelectAllTrigger) {
                // Reset the flag and exit the function
                isSelectAllTrigger = false;
                return;
            }

            var selectedValue = $(this).val();
            if (selectedValue && selectedValue.includes('select_all')) {
                isSelectAllTrigger = true;  // Set the flag to prevent recursion
                $(this).find('option').not(':disabled').prop('selected', true);
                $(this).find('option[value="select_all"]').prop('selected', false);
                $(this).trigger('change');  // Trigger change event to refresh the UI
            } else {
                $(this).find('option[value="select_all"]').prop('selected', false);
            }
        });
    });
</script>
@endsection