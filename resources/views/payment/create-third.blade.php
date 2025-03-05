@extends('layouts.master-without-nav')
@section('title', 'Create Payment')
@section('css')

@endsection
@section('content')
<section class="payment__create__final">
    {{-- nav start  --}}
    @include('layouts.header-section', [
    'title' => 'Payment Create',
    'subTitle' => '',
    ])
    {{-- nav end  --}}

    {{-- ...........  --}}
    {{-- create form start  --}}
    <form id="myForm" action="{{ route('payment-create-final') }}">
        @csrf
        <input name="sale_id" value="{{ $sale->id }}" hidden>
        <input value="{{ $max_amount }}" id="max_amount" hidden>
        <div class="m-5 lg:m-7">
            <div class="bg-white rounded-[20px] mb-5 shadow-xl">
                <div class="grid grid-cols-1 xl:grid-cols-3 gap-10 p-10">
                    <div class="col-span-1 xl:col-span-1 flex items-center justify-center">

                        <div class="bg-bgMain p-5 rounded-[20px] ">

                            <img src="{{ asset('images/paymentcreate.png') }}" class="w-48 h-48 mx-auto" alt="">
                        </div>


                    </div>
                    <div class="col-span-1 xl:col-span-2 flex items-center justify-center">
                        <div>
                            <div class="">
                                <div>
                                    <div>
                                        <h1 class="font-semibold font-jakarta text-[18px] text-center mb-7">
                                            {{ $sale->invoice_number }}
                                        </h1>
                                    </div>
                                    <div class="flex items-center justify-center flex-wrap gap-10">

                                        {{-- Customer Name --}}
                                        <div class="flex flex-col mb-5">
                                            <x-input-field-component type="text" value="{{ $sale->saleableBy?->name }}" label="Customer Name" name="name" id="customerName" text="Name..." readonly="true" />
                                        </div>

                                        {{-- Payment Type --}}
                                        <div class="flex flex-col mb-5">
                                            <label for="" class="block mb-2 text-paraColor font-jakarta font-medium text-sm">Payment Type</label>
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

                                        {{-- Total Remaining Amount --}}
                                        <div class="flex flex-col mb-5">
                                            <div class="mb-2">
                                                <label for="remainingAmount" class="font-jakarta text-paraColor mr-8 text-sm font-semibold mb-2">Remaining
                                                    Amount</label>
                                                <label for="" class="font-jakarta text-paraColor text-sm font-semibold mb-2">Return/Refund</label>
                                            </div>

                                            <div>
                                                <input type="text" value="{{$remaining_amount}}" name="total_remained_amount" id="remainingAmount" class="custom_input outline outline-1 text-sm font-jakarta text-paraColor w-[150px] -mr-2    outline-primary px-4 py-2 rounded-l-full" placeholder="Remaining Amount" readonly>
                                                <input type="text" name="" class="custom_input outline outline-1 text-sm font-jakarta text-paraColor w-[150px]    outline-primary px-3 py-2 rounded-r-full" placeholder="Return/Refund" id="" value="{{$return_refund_amount}}" readonly>
                                            </div>

                                        </div>

                                        {{-- Amount --}}
                                        <div class="flex flex-col mb-5">
                                            <x-input-field-component type="number" value="" label="Amount" name="amount" id="paidAmount" text="Amount..." max="{{ $max_amount }}" required="true" />
                                        </div>

                                        {{-- Paid At --}}
                                        <div class="flex flex-col mb-5">
                                            <label for="" class="font-jakarta text-sm text-paraColor font-semibold mb-2">Paid
                                                At</label>
                                            <input type="text" name="payment_date" class="custom_input outline outline-1 text-sm font-jakarta text-paraColor w-[300px]   outline-primary px-8 py-2 rounded-full" placeholder="17/7/2023" required>
                                        </div>

                                        {{-- Due Date --}}
                                        <div class="flex flex-col mb-5">
                                            <label for="" class="font-jakarta text-sm text-paraColor font-semibold mb-2">Due
                                                Date</label>
                                            <input type="text" name="due_date" class="custom_input outline outline-1 text-sm font-jakarta text-paraColor w-[300px]   outline-primary px-8 py-2 rounded-full" value="{{ dateFormat($sale->due_date) }}" readonly>
                                        </div>

                                        {{-- Next Payment Date --}}
                                        <div class="flex flex-col mb-5">
                                            <label for="" class="font-jakarta text-sm text-paraColor font-semibold mb-2">Next
                                                Payment Date</label>
                                            <input type="text" name="next_payment_date" class=" custom_input outline outline-1 text-sm font-jakarta text-paraColor w-[300px]   outline-primary px-8 py-2 rounded-full" placeholder="17/7/2023" required>
                                        </div>

                                        {{-- Remaining Amount --}}
                                        <div class="flex flex-col mb-5">
                                            <x-input-field-component type="number" value="" label="New Remained Amount" name="new_remained_amount" id="newRemainedAmount" text="Amount..." readonly="true" />
                                        </div>

                                    </div>

                                </div>



                            </div>
                            <div class="flex justify-center mt-5 ">
                                <div>
                                    <x-button-component class="bg-noti text-white" type="submit" id="done">
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
        $('input[name="payment_date"]').daterangepicker({
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
        $('input[name="next_payment_date"]').daterangepicker({
            singleDatePicker: true,
            showDropdowns: true,
            minYear: 2000,
            maxYear: new Date().getFullYear(),
            startDate: moment().format('MM/DD/YYYY')
        }, function(start, end, label) {
            $('#selectDueDate').text(start.format('MM/DD/YYYY'));
        });
    });

    $('input[name="due_date"]').daterangepicker({
        singleDatePicker: true,
        showDropdowns: true,
        minYear: 2000,
        maxYear: new Date().getFullYear(),
        startDate: moment().format('MM/DD/YYYY')
    }, function(start, end, label) {
        $('#selectDueDate').text(start.format('MM/DD/YYYY'));
    });

    $('#paidAmount').on('input', function() {
        var paidAmount = $(this).val().length !== 0 ? $(this).val() : 0;

        // if (this.checkValidity()) {

        var remainingAmount = parseInt($('#max_amount').val());
        var newRemainAmount = remainingAmount - paidAmount;
        console.log('-----');
        console.log(remainingAmount);
        console.log(parseInt(paidAmount));
        console.log(newRemainAmount);

        $('#newRemainedAmount').val(newRemainAmount);
        // } else {
        // this.reportValidity();
        // }

    });
</script>
@endsection