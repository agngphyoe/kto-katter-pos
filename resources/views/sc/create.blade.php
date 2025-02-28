@extends('layouts.master-without-nav')
@section('title', 'Sale Staff Create')
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

        .custom_validation_error {
            color: red;
            font-size: 12px !important;
            margin-top: 3px;
        }
    </style>

@endsection
@section('content')
    <section class="product-model-create">

        {{-- nav start  --}}
        @include('layouts.header-section', [
            'title' => 'Create A New Sale Staff',
            'subTitle' => 'Fill to create a new sale staff',
        ])
        {{-- nav end  --}}


        <form id="myForm" action="{{ route('sc-store') }}" method="POST">
            @csrf
            {{-- box start  --}}
            <div class=" font-jakarta flex items-center justify-center mt-32">
                <div>
                    <div class="bg-white animate__animated animate__zoomIn mb-5  p-10 shadow-xl rounded-[20px]">
                        <div class="flex items-center justify-center gap-10">
                            
                            {{-- locations --}}
                            <div>
                                <label for="" class=" block mb-2 text-paraColor font-semibold text-sm">Location </label>
                                <select name="location_id" class="select2 w-[220px]" required>
                                    <option value="" selected disabled>Choose Location</option>
                                    @foreach ($locations as $location)
                                    <option value="{{ $location->id }}">{{ $location->location_name }}</option>
                                    @endforeach
                                </select>
                                @error('location_id')
                                <p class="text-red-600 text-xs mt-2">* {{ $message }}</p>
                                @enderror
                            </div>

                            {{-- name --}}
                            <div>
                                <label for="" class=" block mb-2 text-paraColor font-semibold text-sm">Name</label>
                                <input type="text" name="name" id="brand_input" placeholder="Enter Name"
                                    class="outline w-[220px] outline-1 outline-primary px-4 py-2 rounded-2xl text-sm"
                                    value="{{ old('name') }}" required>
                                    @error('name')
                                    <p class="text-red-600 text-xs mt-1">* {{ $message }}</p>
                                @enderror
                            </div>

                        </div>

                        <div class="flex flex-col md:items-center text-center md:text-left md:flex-row mt-10 md:justify-center gap-10">
                            <a href="{{ route('sc-list') }}">
                                <button type="button"
                                    class="outline outline-1 text-noti text-sm  outline-noti w-full md:w-44 py-2 rounded-2xl">Cancel</button>
                            </a>
                            <button type="submit"
                                class="text-sm bg-noti outline mx-auto md:mx-0 text-white outline-1 w-full outline-noti md:w-44 py-2 rounded-2xl"
                                id="done">Done</button>
                        </div>
                    </div>

                </div>

            </div>
            {{-- box end  --}}
        </form>

    </section>

@endsection
@section('script')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('js/alertModelCreate.js') }}"></script>

@endsection
