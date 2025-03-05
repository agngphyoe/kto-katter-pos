@extends('layouts.master-without-nav')
@section('title', 'Edit Brand')
@section('css')
    <style>
        .my-title {
            font-family: 'Plus Jakarta Sans', sans-serif;
            color: #00812C;
            margin-bottom: 0;

        }

        .my-text {
            font-family: 'Plus Jakarta Sans', sans-serif;
            color: blue;
        }

        .confirm-Button {
            color: #00812C;
            border: 1px solid #00812C;
            padding: 7px 40px;
            border-radius: 20px;
            margin-left: 10px;
            font-weight: 600;
            font-size: 20px;
        }

        .confirm-Button:hover {
            background-color: #00812C;
            color: white;
        }
    </style>

@endsection
@section('content')
    <section class="product-model-create">

        {{-- nav start  --}}
        @include('layouts.header-section', [
            'title' => 'Edit Brand',
            'subTitle' => 'Fill to edit brand',
        ])
        {{-- nav end  --}}

        {{-- box start  --}}
        <form id="brandCreateForm" action="{{ route('brand-update', ['brand' => $brand->id]) }}" method="POST">
            @csrf
            @method('PUT')
            {{-- <div class=" flex items-center font-jakarta justify-center h-screen">
            <div>
                <div class="bg-white mb-5  p-10 shadow-xl rounded-[20px]">
                    <div class="flex items-center gap-10">
                    <div>
                        <label for="" class=" block mb-2 text-sm">Brand</label>
                        <input name="name" type="text" placeholder="Enter Data Name" class="outline w-[220px] outline-1 outline-primary px-4 py-2 rounded-2xl text-sm" value="{{ $brand->name }}">
        </div>
        @error('name')
        <div class="custom_validation_error">* {{ $message }}</div>
        @enderror
        </div>
        </div>
        <div class="flex items-center justify-center gap-10">
            <a href="{{route('brand')}}">
                <button type="button" class="outline outline-1 text-noti text-sm outline-noti px-20 py-2 rounded-2xl">Cancel</button>
            </a>
            <button type="submit" class="text-sm bg-noti outline text-white outline-1 outline-noti px-20 py-2 rounded-2xl" id="done">Done</button>
        </div>

        </div>

        </div> --}}
            {{-- box start  --}}
            <div class=" font-jakarta flex items-center justify-center mt-32">
                <div>
                    <div class="bg-white animate__animated animate__zoomIn mb-5  p-10 shadow-xl rounded-[20px]">
                        <div class="flex items-center justify-center gap-10">
                            {{-- category --}}
                            <div>
                                <label for=""
                                    class=" block mb-2 text-paraColor font-semibold text-sm">Category</label>
                                <select name="category_id" class="select2 w-[220px]">
                                    <option value="" selected disabled>Choose Category</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}"
                                            {{ $category->id == $brand->category_id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('brand_id')
                                    <p class="text-red-600 text-xs mt-2">* {{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="" class=" block mb-2 text-paraColor font-semibold text-sm">Brand</label>
                                <input type="text" name="name" id="brand_input" placeholder="Enter Data Name"
                                    class="outline w-[220px] outline-1 outline-primary px-4 py-2 rounded-2xl text-sm"
                                    value="{{ $brand->name }}">
                                @error('name')
                                    <p class="text-red-600 text-xs mt-1">* {{ $message }}</p>
                                @enderror
                            </div>


                            <div>
                                <label for=""
                                    class=" block mb-2 text-paraColor font-semibold text-sm">Prefix</label>
                                <input type="text" name="prefix" id="prefix_input" value="{{ $brand->prefix }}"
                                    class="outline w-[220px] outline-1 outline-primary px-4 py-2 rounded-2xl text-sm"
                                    value="{{ old('prefix') }}">
                                {{-- @error('prefix')
                                    <p class="text-red-600 text-xs mt-1">* {{ $message }}</p>
                                @enderror --}}
                            </div>

                        </div>
                        <div
                            class="flex flex-col md:items-center text-center md:text-left md:flex-row mt-10 md:justify-center gap-10">
                            <a href="{{ route('brand') }}">
                                <button type="button"
                                    class="outline outline-1 text-noti text-sm  outline-noti w-full md:w-44 py-2 rounded-2xl">Cancel</button>
                            </a>
                            <button type="submit"
                                class="text-sm bg-noti outline mx-auto md:mx-0 text-white outline-1 w-full outline-noti md:w-44 py-2 rounded-2xl"
                                id="submitButton">Done</button>
                        </div>


                    </div>


                </div>

            </div>
            {{-- box end  --}}
        </form>
        {{-- box end  --}}

    </section>

@endsection
@section('script')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    {{-- <script src="{{ asset('js/alertModelCreate.js') }}"></script> --}}
    <script>
        document.getElementById('brandCreateForm').addEventListener('submit', function(event) {
            event.preventDefault();

            const submitButton = document.getElementById('submitButton');
            submitButton.disabled = true;
            submitButton.innerHTML = "Processing...";
            submitButton.style.opacity = '0.5';

            this.submit();
        });
    </script>

@endsection
