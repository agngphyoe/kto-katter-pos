@extends('layouts.master-without-nav')
@section('title', 'Banks')
@section('css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endsection
@section('content')

    <section class="Bank__edit">
        @include('layouts.header-section', [
            'title' => 'Edit Bank Account',
            'subTitle' => 'Fill to edit bank account',
        ])
        <form id="bankEditForm" action="{{ route('bank-update', ['bank' => $bank->id]) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="data-serch font-poppins text-[15px] mt-5 flex items-center justify-center">
                <div class="bg-white px-10 py-8 rounded-[20px] shadow-lg">
                    <h1 class="text-primary font-semibold text-lg mb-8 text-center">Edit Bank Account</h1>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                        {{-- Bank name --}}
                        <div class="col-span-1 md:col-span-1">
                            <label for="bank_name" class="block mb-2 text-paraColor font-medium text-sm">Bank Name</label>
                            <input type="text" name="bank_name" id="bank_name" placeholder="Enter Bank Name"
                                class="outline w-[230px] text-sm outline-1 outline-primary px-4 py-2 rounded-2xl"
                                value="{{ old('bank_name', $bank->bank_name) }}" required>
                            @error('bank_name')
                                <p class="text-red-600 text-xs mt-1">* {{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Account name --}}
                        <div class="col-span-1 md:col-span-1">
                            <label for="account_name" class="block mb-2 text-paraColor font-medium text-sm">Account
                                Name</label>
                            <input type="text" name="account_name" id="account_name" placeholder="Enter Account Name"
                                class="outline w-[230px] text-sm outline-1 outline-primary px-4 py-2 rounded-2xl"
                                value="{{ old('account_name', $bank->account_name) }}" required>
                            @error('account_name')
                                <p class="text-red-600 text-xs mt-1">* {{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Account number --}}
                        <div class="col-span-2 md:col-span-2">
                            <label for="account_number" class="block mb-2 text-paraColor font-medium text-sm">Account
                                Number</label>
                            <input type="text" name="account_number" id="account_number"
                                placeholder="Enter Account Number"
                                class="outline w-full outline-1 outline-primary px-4 py-2 rounded-2xl text-sm"
                                value="{{ old('account_number', $bank->account_number) }}" required>
                            @error('account_number')
                                <p class="text-red-600 text-xs mt-1">* {{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Duplicate account error --}}
                        @if ($errors->has('duplicate_account'))
                            <p class="text-red-600 text-xs mt-2 text-center col-span-2">*
                                {{ $errors->first('duplicate_account') }}</p>
                        @endif
                    </div>

                    <div class="flex items-center justify-center mt-10 gap-10">
                        <a href="{{ route('bank') }}">
                            <button type="button"
                                class="outline outline-1 text-noti text-sm outline-noti w-full md:w-44 py-2 rounded-2xl">Cancel</button>
                        </a>
                        <button type="submit" id="submitButton"
                            class="text-sm bg-primary font-medium font-jakarta text-white w-32 py-2 rounded-2xl">Done</button>
                    </div>
                </div>
            </div>
        </form>
    </section>
@endsection
@section('script')
    <script src="{{ asset('js/alertModelCreate.js') }}"></script>
    <script>
        document.getElementById('bankEditForm').addEventListener('submit', function(event) {
            event.preventDefault();
            const submitButton = document.getElementById('submitButton');
            submitButton.disabled = true;
            submitButton.innerHTML = "Processing...";
            submitButton.style.opacity = '0.5';
            this.submit();
        });
    </script>
@endsection
