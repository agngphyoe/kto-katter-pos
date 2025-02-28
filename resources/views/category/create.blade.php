@extends('layouts.master-without-nav')
@section('title', 'Create Category')
@section('css')

@endsection
@section('content')
    <section class="product-model-create">
        {{-- nav start  --}}
        @include('layouts.header-section', [
            'title' => 'Create A New Category',
            'subTitle' => 'Fill to create a new category',
        ])
        {{-- nav end  --}}
        
        {{-- box start  --}}
        <form id="categoryCreateForm" action="{{ route('category-store') }}" method="POST">
            @csrf
            <div class=" flex items-center font-jakarta justify-center mt-32">
                <div>
                    <div class="bg-white mb-5  p-10 shadow-xl rounded-[20px]">
                        <div class="flex items-center justify-center gap-10">
                            <div>
                                <label for=""
                                    class=" block mb-2 text-paraColor font-semibold text-sm">Category</label>
                                <input type="text" name="name" id="category_input" placeholder="Enter Data Name"
                                    class="outline w-[220px] outline-1 outline-primary px-4 py-2 rounded-2xl text-sm"
                                    value="{{ old('name') }}">
                                @error('name')
                                    <p class="text-red-600 text-xs mt-1">* {{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for=""
                                    class=" block mb-2 text-paraColor font-semibold text-sm">Prefix</label>
                                <input type="text" name="prefix" id="prefix_input" placeholder="Enter Prefix"
                                    class="outline w-[220px] outline-1 outline-primary px-4 py-2 rounded-2xl text-sm"
                                    value="{{ old('prefix') }}">
                                {{-- @error('prefix')
                                    <p class="text-red-600 text-xs mt-1">* {{ $message }}</p>
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
<script>
    // Disable the button immediately after submitting the form
    document.getElementById('categoryCreateForm').addEventListener('submit', function(event) { 
        event.preventDefault();

        const submitButton = document.getElementById('submitButton');
        submitButton.disabled = true;
        submitButton.innerHTML = "Processing...";
        submitButton.style.opacity = '0.5';

        this.submit();
    });

</script>
@endsection
