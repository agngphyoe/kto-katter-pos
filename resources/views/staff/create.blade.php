@extends('layouts.master-without-nav')
@section('title', 'Create Staff')
@section('css')

@endsection
@section('content')

    <section class="staff__create">


        {{-- nav start  --}}
        @include('layouts.header-section', [
            'title' => 'Create A New Staff',
            'subTitle' => 'Fill to build a new staff',
        ])
        {{-- nav end  --}}

        {{-- ............  --}}
        {{-- create form start  --}}
        <div class="mt-5">
            <form action="{{ route('staff-store') }}" method="POST">
                @csrf
                <div class="grid grid-cols-1   lg:grid-cols-5 mx-4 sm:mx-10 gap-3">
                    <div class="col-span-1 lg:col-span-2 ">
                        <img src="{{ asset('images/createCustomer.png') }}" class="w-96 mx-auto lg:mt-20" alt="">

                    </div>

                    <div class="col-span-1  lg:col-span-3 rounded-[20px] bg-white py-7 font-jakarta ">
                        <form action="{{ route('customer-store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <h1 class="text-noti mb-8   font-semibold text-center text-2xl">Staff</h1>
                            <div class="flex items-center  justify-center flex-wrap gap-5">

                                {{-- name --}}
                                <div>
                                    <label for=""
                                        class="block mb-2 text-sm text-paraColor font-semibold">Name</label>
                                    <input type="text" name="name" placeholder="Staff Name"
                                        class="outline w-[300px] outline-1 outline-primary px-4  py-2 rounded-2xl text-sm"
                                        value="{{ old('name') }}">
                                    @error('name')
                                        <p class="text-red-600 text-xs mt-2">* {{ $message }}</p>
                                    @enderror

                                </div>

                                {{-- position id --}}
                                <div>
                                    <label for=""
                                        class="block mb-2 text-sm text-paraColor font-semibold">Position</label>
                                    <select name="position_id" class="select2 w-[300px]">
                                        <option value="" selected disabled>Choose Position</option>
                                        @forelse ($positions as $position)
                                            <option value="{{ $position->id }}"
                                                {{ old('position_id') == $position->id ? 'selected' : '' }}>
                                                {{ $position->name }}</option>
                                        @empty
                                            <option value="" disabled>No Position</option>
                                        @endforelse
                                    </select>

                                    @error('position_id')
                                        <p class="text-red-600 text-xs mt-2">* {{ $message }}</p>
                                    @enderror

                                </div>

                                {{-- phone --}}
                                <div>
                                    <label for="" class="block mb-2 text-sm text-paraColor font-semibold">Phone
                                        Number</label>
                                    <input type="number" name="phone" placeholder="Enter Phone Number"
                                        class="outline w-[300px] outline-1 outline-primary px-4  py-2 rounded-2xl text-sm"
                                        value="{{ old('phone') }}">
                                    @error('phone')
                                        <p class="text-red-600 text-xs mt-2">* {{ $message }}</p>
                                    @enderror
                                </div>

                                {{-- division --}}
                                <!-- <div class="">
                                    <label for=""
                                        class=" block mb-2  text-paraColor font-semibold   text-sm">Division</label>
                                    <div class="">
                                        <select id="myselect5" name="division_id" class="w-[300px] select2">
                                            <option value="" disabled selected>Division</option>
                                            @forelse($divisions as $division)
                                                <option value="{{ $division->id }}"
                                                    {{ old('division_id') == $division->id ? 'selected' : '' }}>
                                                    {{ $division->name }}</option>
                                            @empty
                                                <option value="" disabled>No Division</option>
                                            @endforelse
                                        </select>
                                        @error('division_id')
                                            <p class="text-red-600 text-xs mt-1">* {{ $message }}</p>
                                        @enderror
                                    </div>

                                </div> -->

                                {{-- township --}}
                                <!-- <div id="townshipSelectContainer">
                                    <div class="">
                                        <label for=""
                                            class=" block mb-2 text-paraColor font-semibold font-semibold  text-sm">Township</label>
                                        <div class="">
                                            <select id="myselect6" name="township_id" class="w-[300px] select2">
                                                <option value="" disabled selected>Township</option>
                                                @forelse($townships as $township)
                                                    <option value="{{ $township->id }}"
                                                        {{ old('township_id') == $township->id ? 'selected' : '' }}>
                                                        {{ $township->name }}</option>
                                                @empty
                                                    <option value="" disabled>No Township</option>
                                                @endforelse
                                            </select>
                                            @error('township_id')
                                                <p class="text-red-600 text-xs mt-1">* {{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                </div> -->

                                {{-- password --}}
                                <div>
                                    <label for="" class="block mb-2 text-paraColor text-sm font-semibold ">Password</label>
                                    <input type="password" name="password" placeholder="Password"
                                        class="outline w-[300px] outline-1 outline-primary px-4  py-2 rounded-2xl text-sm">
                                    @error('password')
                                        <p class="text-red-600 text-xs mt-2">* {{ $message }}</p>
                                    @enderror
                                </div>

                                {{-- confirm password --}}
                                <div>
                                    <label for="" class="block mb-2 text-sm text-paraColor font-semibold">Confirmed
                                        Password</label>
                                    <input type="password" name="confirm_password" placeholder="Password"
                                        class="outline w-[300px] outline-1 outline-primary px-4  py-2 rounded-2xl text-sm">
                                    @error('confirm_password')
                                        <p class="text-red-600 text-xs mt-2">* {{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div
                                class="mt-10 flex flex-col sm:flex-row sm:items-center sm:justify-center gap-3 sm:gap-10 px-5 md:px-10 lg:mx-20">
                                <a href="{{ route('staff') }}"
                                    class="outline outline-1 outline-noti w-full md:w-52 mb-2 rounded-full py-2  text-noti text-center">Cancel</a>
                                <button type="submit"
                                    class="outline outline-1 outline-primary w-full md:w-52 mb-4 rounded-full py-2 text-white bg-primary"
                                    id="done">Done</button>
                            </div>

                        </form>
                    </div>


                </div>
            </form>
        </div>
        </div>
        {{-- create form end  --}}




    </section>

@endsection
@section('script')
    {{-- get township data  --}}
    <script>
        $(document).ready(function() {
            $('select[name="division_id"]').change(function() {
                var division_id = $(this).val();

                $.ajax({
                    url: "{{ route('get-township-data') }}",
                    type: 'GET',
                    dataType: 'json',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        division_id: division_id
                    },
                    success: function(response) {

                        $('#townshipSelectContainer').html(response.html);

                        $('.select2').select2();
                    },
                    error: function(xhr, status, error) {
                        console.log(error);
                    }
                });
            });
        });
    </script>

@endsection
