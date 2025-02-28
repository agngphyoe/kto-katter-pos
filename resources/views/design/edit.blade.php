@extends('layouts.master-without-nav')
@section('title', 'Edit Design')
@section('css')


@endsection
@section('content')
    <section class="product-model-create">

        {{-- nav start  --}}
        @include('layouts.header-section', [
            'title' => 'Edit Design',
            'subTitle' => 'Fill to edit design',
        ])
        {{-- nav end  --}}

        {{-- box start  --}}
        <form id="designCreateForm" action="{{ route('design-update', ['design' => $design->id]) }}" method="POST">
            @csrf
            @method('PUT')
            <div class=" flex items-center font-jakarta justify-center h-screen">
                <div>
                    <div class="bg-white mb-5  p-10 shadow-xl rounded-[20px]">
                        <div class="flex items-center justify-center gap-10">
                            <div>
                                <div>
                                    <label for=""
                                        class=" block mb-2 text-sm font-semibold text-paraColor">Design</label>
                                    <input name="name" type="text" placeholder="Enter Data Name"
                                        class="outline w-[220px] outline-1 outline-primary px-4 py-2 rounded-2xl text-sm"
                                        value="{{ $design->name }}">
                                </div>

                                @error('name')
                                    <p class="custom_validation_error">* {{ $message }}</p>
                                @enderror
                            </div>


                        </div>
                        <div
                            class="flex flex-col md:items-center text-center md:text-left md:flex-row mt-10 md:justify-center gap-10">
                            <a href="{{ route('design') }}">
                                <button type="button"
                                    class="outline outline-1 text-noti text-sm outline-noti px-20 py-2 rounded-2xl">Cancel</button>
                            </a>
                            <button type="submit"
                                class="text-sm bg-noti outline text-white outline-1 outline-noti px-20 py-2 rounded-2xl"
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
        document.getElementById('designCreateForm').addEventListener('submit', function(event) {
            event.preventDefault();

            const submitButton = document.getElementById('submitButton');
            submitButton.disabled = true;
            submitButton.innerHTML = "Processing...";
            submitButton.style.opacity = '0.5';

            this.submit();
        });
    </script>

@endsection
