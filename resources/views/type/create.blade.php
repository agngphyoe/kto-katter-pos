@extends('layouts.master-without-nav')
@section('title', 'Create Type')
@section('css')

@endsection
@section('content')
    <section class="type-create">

        {{-- nav start  --}}
        @include('layouts.header-section', [
            'title' => 'Create A New Type',
            'subTitle' => 'Fill to create a new type',
        ])
        {{-- nav end  --}}

        {{-- box start  --}}
        <form id="typeCreateForm" action="{{ route('type-store') }}" method="POST">
            @csrf
            <div class=" flex items-center font-jakarta justify-center mt-32">
                <div>
                    <div class="bg-white mb-5  p-10 shadow-2xl rounded-[20px]">
                        <div class="flex items-center justify-center gap-10">
                            <div>
                                <label for="" class=" block mb-2 text-paraColor font-semibold text-sm ">Type</label>
                                <input type="text" name="name" id="type_input" placeholder="Enter Data Name"
                                    class="outline w-[220px] outline-1 outline-primary px-4 py-2 rounded-2xl text-sm">
                                @error('name')
                                    <p class="text-red-600 text-xs mt-1">* {{ $message }}</p>
                                @enderror
                            </div>

                        </div>
                        <div
                            class="flex flex-col md:items-center text-center md:text-left md:flex-row mt-10 md:justify-center gap-10">
                            <a href="{{ route('type') }}">
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
        document.getElementById('typeCreateForm').addEventListener('submit', function(event) {
            event.preventDefault();

            const submitButton = document.getElementById('submitButton');
            submitButton.disabled = true;
            submitButton.innerHTML = "Processing...";
            submitButton.style.opacity = '0.5';

            this.submit();
        });
    </script>

@endsection
