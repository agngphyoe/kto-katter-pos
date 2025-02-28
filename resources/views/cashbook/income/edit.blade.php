@extends('layouts.master-without-nav')
@section('title', 'Income')
@section('css')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endsection
@section('content')

{{-- nav start  --}}
@include('layouts.header-section', [
'title' => 'Create Income ',
'subTitle' => 'Fill to create income ',
])
{{-- nav end  --}}

<section class="Income ">
    <form id="incomeEditForm" action="{{ route('income-update', ['income' => $income->id]) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="data-serch font-poppins text-[15px] mt-10   flex items-center justify-center ">
            <div class="bg-white px-10 py-8 rounded-[20px]  ">
                <h1 class="text-primary  font-semibold text-lg mb-8 text-center">Edit Income</h1>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                    <div class="col-span-1 md:col-span-1">
                        <label for="" class=" block mb-2 text-paraColor font-semibold text-sm">Business
                            Name</label>
                        <select name="business_type_id" id="businessTypeContainer" class="select2 w-[230px]">
                            <option value="" class="px-10" selected disabled>Select Business
                            </option>
                            @forelse ($businessTypes as $businessType)
                            <option value="{{ $businessType->id }}" {{ $income->business_type_id == $businessType->id ? 'selected' : '' }}>
                                {{ $businessType->name }}
                            </option>
                            @endforeach
                        </select>
                        @error('name')
                        <p class="text-red-600 text-xs mt-1">* {{ $message }}</p>
                        @enderror
                    </div>

                    <div class="col-span-1 md:col-span-1">
                        <label for="" class=" block mb-2 text-paraColor font-semibold text-sm">Bank Accounts</label>
                        <select name="bank_id" class="select2 w-[230px]">
                            <option value="" selected disabled>Select Bank Account</option>

                            @forelse($banks as $bank)
                            <option value="{{ $bank->id}}" {{ $income->bank_id == $bank->id ? 'selected' : '' }}>{{ $bank->bank_name }}</option>
                            @empty
                            <option value="">No Record</option>
                            @endforelse
                        </select>
                        @error('bank_id')
                        <p class="text-red-600 text-xs mt-1">* {{ $message }}</p>
                        @enderror
                    </div>

                    <div class="col-span-1 md:col-span-1">
                        <label for="" class=" block mb-2 text-paraColor font-semibold text-sm">Account Type</label>
                        <select name="transaction_type" id="" class="select2 w-[230px]">
                            <option value="income" {{ $income->transaction_type == 'income' ? 'selected' : '' }}>Income
                            </option>
                        </select>
                        @error('transaction_type')
                        <p class="text-red-600 text-xs mt-1">* {{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="" class=" block mb-2 text-paraColor font-semibold text-sm">Account
                            Name</label>
                        <select name="account_id" id="accountContainer" class="select2 w-[230px]">
                            <option value="" class="px-10" selected disabled>Select Account Type
                            </option>
                            @foreach ($accounts as $account)
                            <option value="{{ $account->id }}" {{ $income->account_id == $account->id ? 'selected' : '' }}>
                                {{ $account->name }}
                            </option>
                            @endforeach
                        </select>
                        @error('account_id')
                        <p class="text-red-600 text-xs mt-1">* {{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="" class=" block mb-2 text-paraColor font-semibold text-sm">Amount</label>
                        <input type="text" name="amount" id="brand_input" placeholder="Amount" class="outline w-[230px] outline-1 outline-primary px-4 py-2 rounded-2xl text-sm" value="{{ $income->amount }}">
                        @error('amount')
                        <p class="text-red-600 text-xs mt-1">* {{ $message }}</p>
                        @enderror
                    </div>

                    <div class="col-span-1 md:col-span-1">
                        <label for="" class=" block mb-2 text-paraColor font-semibold text-sm">Invoice Number</label>
                        <input type="text" name="invoice_number" placeholder="Invoice Number" class="outline w-[230px] outline-1 outline-primary px-4 py-2 rounded-2xl text-sm" value="{{ $income->invoice_number }}">
                        @error('invoice_number')
                        <p class="text-red-600 text-xs mt-1">* {{ $message }}</p>
                        @enderror
                    </div>

                    <div class="col-span-1 md:col-span-1">
                        <label for="" class=" block mb-2 text-paraColor font-semibold text-sm">Name By</label>
                        <input type="text" name="employee_name" placeholder="Issue Name" class="outline w-[230px] outline-1 outline-primary px-4 py-2 rounded-2xl text-sm" value="{{ $income->employee_name }}">
                        @error('employee_name')
                        <p class="text-red-600 text-xs mt-1">* {{ $message }}</p>
                        @enderror
                    </div>

                    <div class="col-span-1 md:col-span-1">
                        <label for="" class=" block mb-2 text-paraColor font-semibold text-sm">Date By</label>
                        <input type="text" name="issue_date" id="datepickerrange" class="outline w-[230px] outline-1 outline-primary px-4 py-2 rounded-2xl text-sm" placeholder="YYYY-MM-DD"  value="{{ $income->issue_date }}">
                        @error('issue_date')
                        <p class="text-red-600 text-xs mt-1">* {{ $message }}</p>
                        @enderror
                    </div>

                    <div class="col-span-1 md:col-span-2">
                        <label for="" class=" block mb-2  text-paraColor font-semibold text-sm">Description</label>
                        <textarea name="description" id="" class="outline-none w-full outline-1 outline-primary rounded-lg text-sm px-2 py-2" rows="2" placeholder="type">{{ $income->description }}</textarea>
                        @error('description')
                        <p class="text-red-600 text-xs mt-1">* {{ $message }}</p>
                        @enderror
                    </div>
                </div>
                <div class="flex items-center justify-center mt-10 gap-10">
                    <button type="button" class="outline outline-1 text-noti font-semibold font-jakarta text-sm outline-noti  w-32 py-2 rounded-2xl">Cancel</button>
                    <button type="submit" class="text-sm bg-primary  font-semibold font-jakarta text-white  w-32  py-2 rounded-2xl" id="submitButton">Update</button>
                </div>
            </div>
        </div>

        {{-- search end --}}
    </form>

</section>
@endsection
@section('script')
{{-- <script src="{{ asset('js/alertModelCreate.js') }}"></script> --}}

<script>
    $(document).ready(function() {


        $('.select2').select2();

    });
</script>

<script>
    // Disable the button immediately after submitting the form
    document.getElementById('incomeEditForm').addEventListener('submit', function(event) { 
        event.preventDefault();

        const submitButton = document.getElementById('submitButton');
        submitButton.disabled = true;
        submitButton.innerHTML = "Processing...";
        submitButton.style.opacity = '0.5';

        this.submit();
    });

</script>
@endsection