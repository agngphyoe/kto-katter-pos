@extends('layouts.master-without-nav')
@section('title', 'Create Income')
@section('css')
@endsection
@section('content')

    <section class="Income ">

        {{-- nav start  --}}
        @include('layouts.header-section', [
            'title' => 'Create Income ',
            'subTitle' => 'Fill to create income ',
        ])
        {{-- nav end  --}}
        <form id="createIncomeForm" action="{{ route('income-store') }}" method="POST">
            @csrf
            {{-- search start --}}

            <div class="data-serch font-poppins text-[15px] mt-10   flex items-center justify-center ">
                <div class="bg-white px-10 py-8 rounded-[20px]  ">
                    <h1 class="text-primary  font-semibold text-lg mb-8 text-center">Create Income</h1>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                        <div class="col-span-1 md:col-span-1">
                            <label for="" class=" block mb-2 text-paraColor font-semibold text-sm">Business
                                Name <span class="text-red-600">*</span></label>
                            <select name="business_type_id" id="businessTypeContainer" class="select2 w-[230px]">
                                <option value="" selected disabled>Select Business</option>
                                @forelse($business_types as $business_type)
                                    <option value="{{ $business_type->id }}"
                                        {{ old('business_type_id') == $business_type->id ? 'selected' : '' }}>
                                        {{ $business_type->name }}</option>
                                @empty
                                    <option value="">No Record</option>
                                @endforelse
                            </select>
                            @error('business_type_id')
                                <p class="text-red-600 text-xs mt-1">* {{ $message }}</p>
                            @enderror
                        </div>

                        <div class="col-span-1 md:col-span-1">
                            <label for="" class=" block mb-2 text-paraColor font-semibold text-sm">Bank
                                Accounts <span class="text-red-600">*</span></label>
                            <select name="bank_id" class="select2 w-[230px]">
                                <option value="" selected disabled>Select Bank</option>

                                @forelse($banks as $bank)
                                    <option value="{{ $bank->id }}" {{ old('bank_id') == $bank->id ? 'selected' : '' }}>
                                        {{ $bank->bank_name }}</option>
                                @empty
                                    <option value="">No Record</option>
                                @endforelse
                            </select>
                            @error('bank_id')
                                <p class="text-red-600 text-xs mt-1">* {{ $message }}</p>
                            @enderror
                        </div>

                        <div class="col-span-1 md:col-span-1">
                            <label for="" class=" block mb-2 text-paraColor font-semibold text-sm">Account
                                Type <span class="text-red-600">*</span></label>
                            <select name="transaction_type" id="" class="select2 w-[230px]">
                                <option value="income">Income</option>
                            </select>
                            @error('transaction_type')
                                <p class="text-red-600 text-xs mt-1">* {{ $message }}</p>
                            @enderror
                        </div>

                        <div class="col-span-1 md:col-span-1">
                            <label for="" class=" block mb-2 text-paraColor font-semibold text-sm">Account
                                Name <span class="text-red-600">*</span></label>
                            <select name="account_id" id="accountContainer" class="select2 w-[230px]">

                                @forelse($accounts as $account)
                                    <option value="{{ $account->id }}"
                                        {{ old('account_id') == $account->id ? 'selected' : '' }}>{{ $account->name }}
                                    </option>
                                @empty
                                    <option value="">No Record</option>
                                @endforelse

                            </select>
                            @error('account_id')
                                <p class="text-red-600 text-xs mt-1">* {{ $message }}</p>
                            @enderror
                        </div>

                        <div class="col-span-1 md:col-span-1">
                            <label for="" class=" block mb-2 text-paraColor font-semibold text-sm">Amount <span
                                    class="text-red-600">*</span></label>
                            <input type="text" name="amount" id="brand_input" placeholder="Amount"
                                class="outline w-[230px] outline-1 outline-primary px-4 py-2 rounded-2xl text-sm"
                                value="{{ old('amount') }}">

                            @error('amount')
                                <p class="text-red-600 text-xs mt-1">* {{ $message }}</p>
                            @enderror

                        </div>

                        <div class="col-span-1 md:col-span-1">
                            <label for="" class=" block mb-2 text-paraColor font-semibold text-sm">Invoice
                                Number</label>
                            <input type="text" name="invoice_number" placeholder="Invoice Number"
                                class="outline w-[230px] outline-1 outline-primary px-4 py-2 rounded-2xl text-sm"
                                value="{{ old('invoice_number') }}">
                            @error('invoice_number')
                                <p class="text-red-600 text-xs mt-1">* {{ $message }}</p>
                            @enderror
                        </div>

                        <div class="col-span-1 md:col-span-1">
                            <label for="" class=" block mb-2 text-paraColor font-semibold text-sm">Name By</label>
                            <input type="text" name="employee_name" placeholder="Name By"
                                class="outline w-[230px] outline-1 outline-primary px-4 py-2 rounded-2xl text-sm"
                                value="{{ old('employee_name') }}">
                            @error('employee_name')
                                <p class="text-red-600 text-xs mt-1">* {{ $message }}</p>
                            @enderror
                        </div>

                        <div class="col-span-1 md:col-span-1">
                            <label for="" class=" block mb-2 text-paraColor font-semibold text-sm">Date By <span
                                    class="text-red-600">*</span></label>
                            <input type="text" name="issue_date" id="datepickerrange"
                                class="outline w-[230px] outline-1 outline-primary px-4 py-2 rounded-2xl text-sm"
                                placeholder="YYYY-MM-DD" value="{{ old('issue_date') }}">
                            @error('issue_date')
                                <p class="text-red-600 text-xs mt-1">* {{ $message }}</p>
                            @enderror
                        </div>

                        <div class="col-span-1 md:col-span-2">
                            <div>
                                <label for="" class=" block mb-2  text-paraColor font-semibold text-sm">Description
                                    <span class="text-red-600">*</span></label>
                                <textarea name="description" value="{{ old('description') }}" id=""
                                    class="outline-none w-full  outline-1 outline-primary rounded-lg text-sm px-2 py-2" rows="2"
                                    placeholder="Description">{{ old('description') }}</textarea>
                                @error('description')
                                    <p class="text-red-600 text-xs mt-1">* {{ $message }}</p>
                                @enderror
                            </div>

                        </div>
                    </div>
                    <div class="flex items-center justify-center mt-10 gap-10">
                        <a href="{{ route('income-list') }}" type="button"
                            class="outline outline-1 text-noti font-semibold font-jakarta text-sm outline-noti  w-32 py-2 rounded-2xl flex justify-center">Cancel</a>
                        <button type="submit"
                            class="text-sm bg-primary  font-semibold font-jakarta text-white  w-32  py-2 rounded-2xl"
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
        $(document).ready(function() {
            function getSelectOptions() {

                $.ajax({
                    url: "{{ route('account-select-options') }}",
                    type: 'GET',
                    dataType: 'json',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {},
                    success: function(response) {
                        $('#accountContainer').html(response.html);

                        $('.select2').select2();
                    },
                    error: function(xhr, status, error) {
                        console.log(error);
                    }
                });

                $.ajax({
                    url: "{{ route('business-type-select-options') }}",
                    type: 'GET',
                    dataType: 'json',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {},
                    success: function(response) {
                        $('#businessTypeContainer').html(response.html);

                        $('.select2').select2();
                    },
                    error: function(xhr, status, error) {
                        console.log(error);
                    }
                });

            };

            // getSelectOptions();
        });
    </script>

    <script>
        // Disable the button immediately after submitting the form
        document.getElementById('createIncomeForm').addEventListener('submit', function(event) {
            event.preventDefault();

            const submitButton = document.getElementById('submitButton');
            submitButton.disabled = true;
            submitButton.innerHTML = "Processing...";
            submitButton.style.opacity = '0.5';

            this.submit();
        });
    </script>
@endsection
