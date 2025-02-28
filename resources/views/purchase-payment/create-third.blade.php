@extends('layouts.master-without-nav')
@section('title', 'Create Payment')
@section('css')

@endsection
@section('content')
<section class="purchase__payment__create__final">
    {{-- nav start  --}}
    @include('layouts.header-section', [
    'title' => 'Purchase Payment Create',
    'subTitle' => '',
    ])
    {{-- nav end  --}}

    {{-- ...........  --}}
    {{-- create form start  --}}
    <form id="submitForm" action="{{ route('purchase-payment-create-final') }}">
        @csrf
        <input name="purchase_id" value="{{ $purchase->id }}" hidden>
        {{--<input value="{{ $max_amount }}" id="max_amount" hidden>--}}
        <div class="m-5 lg:m-7">
            <div class="bg-white rounded-[20px] mb-5 shadow-xl">
                <div class="grid grid-cols-1 xl:grid-cols-3 gap-10 p-5 lg:p-10">
                    <div class="col-span-1 xl:col-span-1 flex items-center justify-center">

                        <div class="bg-bgMain p-10 rounded-[20px] ">

                            <img src="{{ asset('images/paymentcreate.png') }}" class="w-48 h-48 mx-auto" alt="">
                        </div>


                    </div>
                    <div class="col-span-1 xl:col-span-2 flex items-center justify-center">
                        <div>
                            <div class="">
                                <div>
                                    <div>
                                        <h1 class="font-semibold font-jakarta text-[18px] text-center mb-7">
                                            {{ $purchase->invoice_number }}
                                        </h1>
                                    </div>
                                    <div class="flex items-center justify-center flex-wrap gap-10">

                                        {{-- Customer Name --}}
                                        <div class="flex flex-col mb-5">
                                            <x-input-field-component type="text" value="{{ $purchase->supplier?->name }}" label="Supplier Name" name="name" id="customerName" text="Name..." readonly="true" />
                                        </div>

                                        {{-- Payment Type --}}
                                        <div class="flex flex-col mb-5">
                                            <label for="" class="block mb-2 text-paraColor font-jakarta font-medium text-sm">Payment Type <span class="text-red-600">*</span></label>
                                            <select name="payment_type" id="paymentType" class="select2 w-[300px]" required>
                                                <option value="" selected disabled>Select...</option>
                                                @forelse ($banks as $bank)
                                                <option value="{{$bank->id}}" @if(old('payment_type')==$bank->id) selected @endif>{{$bank->bank_name}}</option>
                                                @empty

                                                @endforelse
                                            </select>
                                            @error('payment_type')
                                            <p class="text-red-600 text-xs mt-1">* {{ $message }}</p>
                                            @enderror

                                        </div>
                                        @php
                                        $remaining_amount = $purchase->remaining_amount - $purchase->total_return_buying_amount;

                                        if ($purchase->paymentables->isNotEmpty()) 
                                        {
                                        $payment = $purchase->paymentables->sortByDesc('created_at')->first();
                                        $remaining_amount = $payment->remaining_amount;
                                        }

                                        @endphp
                                        {{-- Total Remaining Amount --}}
                                        <div class="flex flex-col mb-5">
                                            <label for="" class="font-jakarta text-sm text-paraColor font-semibold mb-2">Remaining Amount</label>

                                            <input type="number" class=" outline outline-1 text-sm font-jakarta text-paraColor w-[300px]     outline-primary px-4 py-2 rounded-full" name="total_remained_amount" id="remainingAmount" placeholder="Remaining Amount" value="{{ $remaining_amount }}" readonly>
                                    </div>

                                    {{-- Amount --}}
                                    <div class="flex flex-col mb-5">
                                        {{-- <x-input-field-component type="number" value="" label="Amount" name="amount" id="paidAmount" text="Amount..." max="{{ $purchase->remaining_amount }}" required="true" /> --}}
                                        <label for="amount" class="font-jakarta text-paraColor text-sm font-semibold mb-2">Amount <span class="text-red-600">*</span></label>
                                        <input type="number" name="amount" id="paidAmount" placeholder="Amount..."min="0" max="{{$purchase->remaining_amount}}"
                                                class="custom_input outline outline-1 text-sm font-jakarta text-paraColor w-[300px] outline-primary px-4 py-2 rounded-full"
                                            required>
                                    </div>

                                    {{-- Paid At --}}
                                    <div class="flex flex-col mb-5">
                                        <label for="" class="font-jakarta text-sm text-paraColor font-semibold mb-2">Paid
                                            At <span class="text-red-600">*</span></label>
                                        <input type="text" name="purchase_payment_date" class="custom_input outline outline-1 text-sm font-jakarta text-paraColor w-[300px]   outline-primary px-8 py-2 rounded-full" value="{{ \Carbon\Carbon::now()->format('d/m/Y') }}" required>
                                    </div>

                                    {{-- Due Date --}}
                                    <div class="flex flex-col mb-5">
                                        <label for="" class="font-jakarta text-sm text-paraColor font-semibold mb-2">
                                            Due Date
                                        </label>
                                        <input type="text" name="due_date" 
                                               class="custom_input outline outline-1 text-sm font-jakarta text-paraColor w-[300px] outline-primary px-8 py-2 rounded-full" 
                                               value="{{  \Carbon\Carbon::parse($payment->next_payment_date)->format('m/d/Y') }}" 
                                               readonly>
                                    </div>

                                    {{-- Next Payment Date --}}
                                    <div class="flex flex-col mb-5">
                                        <label for="" class="font-jakarta text-sm text-paraColor font-semibold mb-2">Next
                                            Payment Date <span class="text-red-600">*</span></label>
                                        <input type="text" name="next_purchase_payment_date" class=" custom_input outline outline-1 text-sm font-jakarta text-paraColor w-[300px]   outline-primary px-8 py-2 rounded-full" placeholder="17/7/2023" required>
                                    </div>

                                    {{-- Remaining Amount --}}
                                    <div class="flex flex-col mb-5">
                                        <x-input-field-component type="number" value="" label="New Remaining Amount" name="new_remained_amount" id="newRemainedAmount" text="Amount..." readonly="true" />
                                    </div>

                                </div>

                            </div>



                        </div>
                        <div class="flex justify-center mt-5 ">
                            <div>
                                <x-button-component class="bg-noti text-white" type="submit" id="submitButton">
                                    Done
                                </x-button-component>
                            </div>

                        </div>
                    </div>

                </div>
            </div>

        </div>
        </div>
    </form>
    {{-- create form end --}}
</section>
@endsection
@section('script')
<script>
    // payment date
    $(function() {
        $('input[name="purchase_payment_date"]').daterangepicker({
            singleDatePicker: true,
            showDropdowns: true,
            minYear: 2000,
            maxYear: new Date().getFullYear(),
            startDate: moment().format('MM/DD/YYYY')
        }, function(start, end, label) {
            $('#selectDueDate').text(start.format('MM/DD/YYYY'));
        });
    });

    //next payment date
    $(function() {
        $('input[name="next_purchase_payment_date"]').daterangepicker({
            singleDatePicker: true,
            showDropdowns: true,
            minYear: 2000,
            maxYear: new Date().getFullYear() + 3,
            startDate: moment().format('MM/DD/YYYY')
        }, function(start, end, label) {
            $('#selectDueDate').text(start.format('MM/DD/YYYY'));
        });
    });

    // $('input[name="due_date"]').daterangepicker({
    //     singleDatePicker: true,
    //     showDropdowns: true,
    //     minYear: 2000,
    //     maxYear: new Date().getFullYear(),
    //     startDate: moment().format('MM/DD/YYYY')
    // }, function(start, end, label) {
    //     $('#selectDueDate').text(start.format('MM/DD/YYYY'));
    // });

    $('#paidAmount').on('input', function() {
        var paidAmount = $(this).val().length !== 0 ? $(this).val() : 0;


        var remainingAmount = parseInt($('#remainingAmount').val());

        // var total_return_amount = parseInt($('#total_return_amount').val());

        // var total_remaining_amount = remainingAmount - total_return_amount;
        var newRemainAmount = remainingAmount - paidAmount;

        $('#newRemainedAmount').val(newRemainAmount);

    });
</script>
@endsection