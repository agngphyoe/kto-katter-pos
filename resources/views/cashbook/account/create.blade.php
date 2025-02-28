@extends('layouts.master-without-nav')
@section('title', 'Create Account')
@section('css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endsection
@section('content')

    <section class="account__type  font-poppins">

        {{-- nav start  --}}
        @include('layouts.header-section', [
            'title' => 'Create Account ',
            'subTitle' => 'Fill to create a Account ',
        ])
        {{-- nav end  --}}

        <form id="accountCreateForm" action="{{ route('account-store') }}" method="POST">
            @csrf
            {{-- box start  --}}
            <div class=" font-jakarta flex items-center justify-center mt-32">
                <div>
                    <div class="bg-white animate__animated animate__zoomIn mb-5  p-10 shadow-xl rounded-[20px]">
                        <div class="flex items-center justify-center gap-10">

                            <div class="flex items-center justify-center gap-10">
                                <div class="">
                                    <label for="" class=" block mb-2 text-paraColor font-semibold text-sm">Account
                                        Type</label>

                                    <select name="account_type_id" id="accountTypeContainer" class="select2 w-[220px]">

                                    </select>

                                    @error('account_type_id')
                                        <p class="text-red-600 text-xs mt-2">* {{ $message }}</p>
                                    @enderror
                                    @if ($errors->has('duplicate_account'))
                                        <p class="text-red-600 text-xs mt-2 text-center">*
                                            {{ $errors->first('duplicate_account') }}</p>
                                    @endif
                                </div>
                            </div>

                            <div class="flex items-center justify-center gap-10">
                                <div>
                                    <label for="" class=" block mb-2 text-paraColor font-semibold text-sm">Account
                                        Name</label>
                                    <input type="text" name="name" id="account_input" placeholder="Name"
                                        class="outline w-[220px] outline-1 outline-primary px-4 py-2 rounded-2xl text-sm"
                                        value="{{ old('name') }}">
                                    @error('name')
                                        <p class="text-red-600 text-xs mt-1">* {{ $message }}</p>
                                    @enderror
                                    @if ($errors->has('duplicate_account'))
                                        <p class="text-red-600 text-xs mt-2 text-center">*
                                            {{ $errors->first('duplicate_account') }}</p>
                                    @endif
                                </div>

                            </div>

                            <div class="flex items-center justify-center gap-10">
                                <div>
                                    <label for="" class=" block mb-2 text-paraColor font-semibold text-sm">Account
                                        Number</label>
                                    <input type="text" name="account_number" id="account_number"
                                        placeholder="Account Number"
                                        class="outline w-[220px] outline-1 outline-primary px-4 py-2 rounded-2xl text-sm"
                                        value="{{ old('account_number') }}">
                                    @error('account_number')
                                        <p class="text-red-600 text-xs mt-1">* {{ $message }}</p>
                                    @enderror
                                    @if ($errors->has('duplicate_account'))
                                        <p class="text-red-600 text-xs mt-2 text-center">*
                                            {{ $errors->first('duplicate_account') }}</p>
                                    @endif
                                </div>

                            </div>
                        </div>

                        <div
                            class="flex flex-col md:items-center text-center md:text-left md:flex-row mt-10 md:justify-center gap-10">
                            <a href="{{ route('account-list') }}">
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
    </section>



@endsection
@section('script')

    <script>
        $(document).ready(function() {
            function getAccountTypes() {

                $.ajax({
                    url: "{{ route('account-type-select-options') }}",
                    type: 'GET',
                    dataType: 'json',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {},
                    success: function(response) {
                        $('#accountTypeContainer').html(response.html);

                        $('.select2').select2();
                    },
                    error: function(xhr, status, error) {
                        console.log(error);
                    }
                });

            };

            getAccountTypes();
        });
    </script>

    <script>
        // Disable the button immediately after submitting the form
        document.getElementById('accountCreateForm').addEventListener('submit', function(event) {
            event.preventDefault();

            const submitButton = document.getElementById('submitButton');
            submitButton.disabled = true;
            submitButton.innerHTML = "Processing...";
            submitButton.style.opacity = '0.5';

            this.submit();
        });
    </script>
@endsection
