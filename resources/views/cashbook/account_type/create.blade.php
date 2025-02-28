@extends('layouts.master-without-nav')
@section('title', 'Create Account Type')
@section('css')
@endsection
@section('content')

<section class="account__type  font-poppins">

    {{-- nav start  --}}
    @include('layouts.header-section', [
    'title' => 'Create Account Type',
    'subTitle' => 'Fill to create a Account Type',
    ])
    {{-- nav end  --}}

    <form id="accountTypeCreateForm" action="{{ route('account-type-store') }}" method="POST">
        @csrf
        {{-- box start  --}}
        <div class=" font-jakarta flex items-center justify-center mt-32">
            <div>
                <div class="bg-white animate__animated animate__zoomIn mb-5  p-10 shadow-xl rounded-[20px]">
                    <div class="flex items-center justify-center gap-10">
                        <div>
                            <label for="" class=" block mb-2 text-paraColor font-semibold text-sm">Account
                                Type</label>
                            <input type="text" name="name" id="account_type_input" placeholder="Name" class="outline w-[220px] outline-1 outline-primary px-4 py-2 rounded-2xl text-sm" value="" required>
                            @error('name')
                            <p class="text-red-600 text-xs mt-1">* {{ $message }}</p>
                            @enderror
                        </div>

                    </div>

                    <div class="flex flex-col md:items-center text-center md:text-left md:flex-row mt-10 md:justify-center gap-10">
                        <a href="{{ route('settings-create') }}">
                            <button type="button" class="outline outline-1 text-noti text-sm  outline-noti w-full md:w-44 py-2 rounded-2xl">Cancel</button>
                        </a>
                        <button type="submit" class="text-sm bg-noti outline mx-auto md:mx-0 text-white outline-1 w-full outline-noti md:w-44 py-2 rounded-2xl" id="submitButton">Done</button>
                    </div>
                </div>


            </div>

        </div>
        {{-- box end  --}}
    </form>
</section>
@endsection
@section('script')
<script src="{{ asset('js/alertModelCreate.js') }}"></script>
<script>
    // Disable the button immediately after submitting the form
    document.getElementById('accountTypeCreateForm').addEventListener('submit', function(event) { 
        event.preventDefault();

        const submitButton = document.getElementById('submitButton');
        submitButton.disabled = true;
        submitButton.innerHTML = "Processing...";
        submitButton.style.opacity = '0.5';

        this.submit();
    });

</script>

@endsection