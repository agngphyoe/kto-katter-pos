@extends('layouts.master-without-nav')
@section('title', 'Create Bank')
{{-- @section('css')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endsection --}}
@section('content')

    <section class="Bank__create ">
        {{-- nav start  --}}
        @include('layouts.header-section', [
            'title' => 'Create Bank Account ',
            'subTitle' => 'Fill to create bank account ',
        ])
        {{-- nav end  --}}
        <form id="bankCreateForm" action="{{ route('bank-store') }}" method="POST">
            @csrf
            {{-- search start --}}
            <div class="data-serch font-poppins text-[15px] mt-5   flex items-center justify-center">
                <div class="bg-white px-10 py-8 rounded-[20px] shadow-lg  ">
                    <h1 class="text-primary  font-semibold text-lg mb-8 text-center">Create Bank Account</h1>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                        {{-- Bank name start   --}}
                        <div class="col-span-1 md:col-span-1">
                            <label for="" class=" block mb-2 text-paraColor font-medium text-sm">Bank Name</label>
                            <input type="text" name="bank_name" placeholder="Enter Bank Name"
                                class="outline w-[230px] text-sm  outline-1 outline-primary px-4 py-2 rounded-2xl "
                                value="{{ old('bank_name') }}" required>
                            @error('bank_name')
                                <p class="text-red-600 text-xs mt-1">* {{ $message }}</p>
                            @enderror
                            @if ($errors->has('duplicate_account'))
                                <p class="text-red-600 text-xs mt-2 text-center">*
                                    {{ $errors->first('duplicate_account') }}</p>
                            @endif
                        </div>

                        {{-- Account name start   --}}
                        <div class="col-span-1 md:col-span-1">
                            <label for="" class=" block mb-2 text-paraColor font-medium text-sm">Account
                                Name</label>
                            <input type="text" name="account_name" placeholder="Enter Account Name"
                                class="outline w-[230px] text-sm  outline-1 outline-primary px-4 py-2 rounded-2xl "
                                value="{{ old('account_name') }}" required>
                            @error('account_name')
                                <p class="text-red-600 text-xs mt-1">* {{ $message }}</p>
                            @enderror
                            @if ($errors->has('duplicate_account'))
                                <p class="text-red-600 text-xs mt-2 text-center">*
                                    {{ $errors->first('duplicate_account') }}</p>
                            @endif
                        </div>

                        {{-- Account name start   --}}
                        <div class="col-span-2 md:col-span-2">
                            <label for="account_number" class="block mb-2 text-paraColor font-medium text-sm">Account
                                Number</label>
                            <input type="text" name="account_number" id="account_number"
                                placeholder="Enter Account Number"
                                class="outline w-full outline-1 outline-primary px-4 py-2 rounded-2xl text-sm"
                                value="{{ old('account_number') }}" required>
                            @error('account_number')
                                <p class="text-red-600 text-xs mt-1">* {{ $message }}</p>
                            @enderror
                            @if ($errors->has('duplicate_account'))
                                <p class="text-red-600 text-xs mt-2 text-center">* {{ $errors->first('duplicate_account') }}
                                </p>
                            @endif
                        </div>

                    </div>
                    <div class="flex items-center justify-center mt-10 gap-10">
                        <a href="{{ route('bank') }}">
                            <button type="button"
                                class="outline outline-1 text-noti text-sm  outline-noti w-full md:w-44 py-2 rounded-2xl">Cancel</button>
                        </a>
                        <button type="submit"
                            class="text-sm bg-primary  font-medium font-jakarta text-white  w-32  py-2 rounded-2xl"
                            id="submitButton">Done</button>
                    </div>
                </div>

            </div>

            {{-- search end --}}
        </form>

    </section>
@endsection
@section('script')
    <script src="{{ asset('js/alertModelCreate.js') }}"></script>

    <script>
        // Disable the button immediately after submitting the form
        document.getElementById('bankCreateForm').addEventListener('submit', function(event) {
            event.preventDefault();

            const submitButton = document.getElementById('submitButton');
            submitButton.disabled = true;
            submitButton.innerHTML = "Processing...";
            submitButton.style.opacity = '0.5';

            this.submit();
        });
    </script>
@endsection
