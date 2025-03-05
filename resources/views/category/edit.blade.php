@extends('layouts.master-without-nav')
@section('title', 'Edit Category')
@section('css')

@endsection
@section('content')
    <section class="product-model-create">

        {{-- nav start  --}}
        @include('layouts.header-section', [
            'title' => 'Edit Category',
            'subTitle' => 'Fill to edit category',
        ])
        {{-- nav end  --}}

        {{-- box start  --}}
        <form id="categoryCreateForm" action="{{ route('category-update', ['category' => $category->id]) }}" method="POST">
            @csrf
            @method('PUT')
            <div class=" flex items-center font-jakarta justify-center mt-32">
                <div>
                    <div class="bg-white mb-5  p-10 shadow-xl rounded-[20px]">
                        <div class="flex items-center justify-center gap-10">
                            <div>
                                <label for=""
                                    class=" block mb-2 text-paraColor font-semibold text-sm">Category</label>
                                <input name="name" type="text" placeholder="Enter Data Name"
                                    class="outline w-[220px] outline-1 outline-primary px-4 py-2 rounded-2xl text-sm"
                                    value="{{ $category->name }}">
                                @error('name')
                                    <div class="custom_validation_error">* {{ $message }}</div>
                                @enderror
                            </div>

                            <div>
                                <label for=""
                                    class=" block mb-2 text-paraColor font-semibold text-sm">Prefix</label>
                                <input name="prefix" type="text"
                                    class="outline w-[220px] outline-1 outline-primary px-4 py-2 rounded-2xl text-sm"
                                    value="{{ $category->prefix }}">
                                {{-- @error('prefix')
                                    <div class="custom_validation_error">* {{ $message }}</div>
                                @enderror --}}
                            </div>

                        </div>

                        <div
                            class="flex flex-col md:items-center text-center md:text-left md:flex-row mt-10 md:justify-center gap-10">
                            <a href="{{ route('category') }}">
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
        </form>
        {{-- box end  --}}

    </section>

@endsection
@section('script')
@endsection
