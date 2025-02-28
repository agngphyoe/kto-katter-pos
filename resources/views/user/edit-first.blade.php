    @extends('layouts.master-without-nav')
    @section('title', 'Edit User')
    @section('css')

    @endsection
    @section('content')
        <section class="user__create">
            {{-- nav start  --}}
            @include('layouts.header-section', [
                'title' => 'Edit User',
                'subTitle' => '',
            ])
            {{-- nav end  --}}

            {{-- main start  --}}

            <div class="mt-5">

                <div class="grid grid-cols-1   lg:grid-cols-4 mx-4 sm:mx-10 gap-10 ">
                    <div class="col-span-1 lg:col-span-1 ">

                        <div class="flex items-center justify-center  ">

                            <img src="{{ asset('images/createSupplier.png') }}" class="w-full lg:mt-32" alt="">
                        </div>

                    </div>

                    <div class="col-span-1  lg:col-span-3 rounded-[20px] bg-white font-jakarta ">
                        <form id="myForm" action="{{ route('user-edit-final') }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            <input name="user_id" value="{{ $user->id }}" hidden>
                            {{-- user start  --}}
                            <h1 class="text-noti my-5 font-semibold text-center text-xl">User ID - <span
                                    class="bg-noti text-white px-4 py-1 text-sm rounded-full font-normal">{{ $user->user_number }}</span>
                            </h1>

                            <div class="form grid  sm:grid-cols-2 xl:grid-cols-3 gap-0 sm:gap-7 px-5 md:px-10">
                                {{-- username --}}
                                <div class="flex flex-col mb-5 ">
                                    <label for=""
                                        class="font-jakarta text-[15px] text-paraColor font-semibold mb-2">User Name
                                    </label>
                                    <input type="text" placeholder="Name"
                                        class="outline outline-1  text-sm font-jakarta text-paraColor w-[250px]  text-[13px] outline-primary px-8 py-2 rounded-full"
                                        name="name" value="{{ old('name') ? old('name') : $user->name }}">
                                    @error('name')
                                        <p class="text-red-600 text-xs mt-1">* {{ $message }}</p>
                                    @enderror
                                </div>

                                {{-- Password --}}
                                <div class="flex flex-col mb-5">
                                    <label for=""
                                        class="font-jakarta text-[15px] text-paraColor font-semibold mb-2">Password</label>
                                    <input type="password" name="password" placeholder="password"
                                        class="outline outline-1 text-sm font-jakarta text-paraColor w-[250px]  text-[13px] outline-primary px-8 py-2 rounded-full">
                                    @error('password')
                                        <p class="text-red-600 text-xs mt-1">* {{ $message }}</p>
                                    @enderror
                                </div>

                                {{-- Comfirm Password --}}
                                <div class="flex flex-col mb-5">
                                    <label for=""
                                        class="font-jakarta text-[15px] text-paraColor font-semibold mb-2">Confirm
                                        Password</label>
                                    <input type="password" placeholder="password"
                                        class="outline outline-1 text-sm font-jakarta text-paraColor w-[250px]  text-[13px] outline-primary px-8 py-2 rounded-full"
                                        name="confirm_password">
                                    @error('confirm_password')
                                        <p class="text-red-600 text-xs mt-1">* {{ $message }}</p>
                                    @enderror
                                </div>

                                {{-- phone number --}}
                                <div class="flex flex-col mb-5">
                                    <label for=""
                                        class="font-jakarta text-[15px] text-paraColor font-semibold mb-2">Phone
                                        Number</label>
                                    <input type="text" name="phone" placeholder="+95 9456639939"
                                        class="outline outline-1 text-sm font-jakarta text-paraColor w-[250px]  text-[13px] outline-primary px-8 py-2 rounded-full"
                                        value="{{ old('phone') ? old('phone') : $user->phone }}">
                                    @error('phone')
                                        <p class="text-red-600 text-xs mt-1">* {{ $message }}</p>
                                    @enderror
                                </div>
                                
                                {{-- role --}}
                                <div class="flex flex-col mb-4 ">
                                    <label for=""
                                        class="font-jakarta text-[15px] text-paraColor font-semibold mb-2">Role </label>
                                    <select name="role_id" id="" class="select2 w-[250px]">
                                        <option value="" selected disabled>Select A Role</option>
                                        @forelse($roles as $role)
                                            <option value="{{ $role->id }}"
                                                {{ $user->role->id == $role->id ? 'selected' : '-' }}>{{ $role->name }}
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
                                    <label for="" class="block mb-2 text-paraColor font-medium text-sm ">Locations</label>
                                    <select name="location_id[]" class="w-full select2" required multiple>
                                    <option value="" disabled>| Select </option>
                                    @forelse($locations as $location)
                                        <option value="{{ $location->id }}" class="outline-none font-Pop"
                                            {{ in_array($location->id, $user->getLocationIdsAttribute()) ? 'selected' : '' }}>
                                            {{ $location->location_name }}</option>
                                    @empty
                                        <option value="" class="outline-none font-Pop" disabled selected>No Data
                                        </option>
                                    @endforelse
                                    </select>
                                </div>
                            </div>
                            <div class="flex items-center justify-center mt-5 pb-5">
                                <x-button-component class="bg-noti text-white" type="submit" id="done">
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
        <script>
            const addPhotoImg = document.getElementById('addPhoto');
            const photoInput = document.getElementById('photoInput');

            addPhotoImg.addEventListener('click', function() {
                photoInput.click();
            });
        </script>

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
    @endsection
