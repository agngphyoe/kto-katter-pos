@extends('layouts.master-without-nav')
@section('title', 'Position Edit')
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
    'title' => 'Create A New Brand',
    'subTitle' => 'Fill Edit Position',
    ])
    {{-- nav end  --}}


    <form id="myForm" action="{{ route('position-update', $position->id) }}" method="POST">
        @csrf
        @method('PUT')
        {{-- box start  --}}
        <div class=" font-jakarta flex items-center justify-center mt-32">
            <div>
                <div class="bg-white mb-5  p-10 shadow-xl rounded-[20px]">
                    <div class="flex items-center justify-center gap-10">
                        <div>
                            <label for="" class=" block mb-2 text-paraColor font-semibold text-sm">Position</label>
                            <input type="text" name="name" id="brand_input" placeholder="Enter Data Name" class="outline w-[220px] outline-1 outline-primary px-4 py-2 rounded-2xl text-sm" value="{{ old('name') ? old('name') : $position->name}}">
                        </div>
                        @error('name')
                        <p class="text-red-600 text-xs mt-1">* {{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex flex-col md:items-center text-center md:text-left md:flex-row mt-10 md:justify-center gap-10">
                        <a href="{{ route('position') }}">
                            <button type="button" class="outline outline-1 text-noti text-sm  outline-noti w-full md:w-44 py-2 rounded-2xl">Cancel</button>
                        </a>
                        <button type="submit" class="text-sm bg-noti outline mx-auto md:mx-0 text-white outline-1 w-full outline-noti md:w-44 py-2 rounded-2xl" id="done">Done</button>
                    </div>
                </div>


            </div>

        </div>
        {{-- box end  --}}
    </form>

</section>

@endsection
