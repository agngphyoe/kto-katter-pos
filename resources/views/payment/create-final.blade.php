@extends('layouts.master-without-nav')
@section('title', 'Create Payment')
@section('css')

@endsection
@section('content')
<section class="payment__create__final">
    {{-- nav start  --}}
    @include('layouts.header-section', [
    'title' => 'Payment Create',
    'subTitle' => 'Check your inputs',
    ])
    {{-- nav end  --}}


    {{-- ...........  --}}
    {{-- create form start  --}}
    <div class="m-5 lg:m-7">
        <div class="bg-white rounded-[20px] p-5 lg:p-14 mb-10">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-16 ">
                <div class="col-span-1 md:col-span-1">
                    <div class="border-x border-b md:px-5 pb-10 rounded-b-[30px] shadow-xl">
                        <h1 class="mb-5 font-jakarta text-noti text-center font-semibold">Customer Details</h1>
                        <div class="">
                            <img src="{{ asset('customers/image/' . $sale->saleableBy->image) }}" class="w-24 h-24 object-cover mx-auto rounded-full   " alt="">
                        </div>
                        <div class="font-poppins flex items-center justify-center mt-10">
                            <div>
                                <div class="mb-4">

                                    <h1 class="text-primary text-sm font-semibold mb-2">Customer Name <span class="text-paraColor opacity-50">(ID)</span></h1>
                                    <h1 class="text-[13px] text-paraColor ">{{ $sale->saleableBy->name }}<span class="text-noti">({{ $sale->saleableBy->user_number }})</span></h1>
                                </div>
                                <div class="mb-4">


                                    <h1 class="text-primary text-sm font-semibold mb-2">Phone Number</h1>
                                    <h1 class="text-[13px] text-paraColor ">{{ $sale->saleableBy->phone }}</h1>
                                </div>
                                <div>
                                    <h1 class="text-primary text-sm font-semibold mb-2">Address</h1>
                                    <h1 class="text-[13px] text-paraColor ">{{ $sale->saleableBy->address ?? '-' }}</h1>
                                </div>
                            </div>


                        </div>
                    </div>
                </div>
                <div class="col-span-1 md:col-span-2 ">
                    <div>
                        <h1 class="text-noti font-semibold mb-10 font-poppins text-center ">Payment Details
                        </h1>
                        <div class="grid grid-cols-1 md:grid-cols-3">
                            <div class="font-poppins">
                                <div class="mb-7">
                                    <h1 class="text-primary text-sm font-semibold mb-2">Sale Invoice</h1>
                                    <h1 class="text-[13px] text-paraColor ">{{ $sale->invoice_number }}</h1>
                                </div>
                                <div class="mb-7">
                                    <h1 class="text-primary text-sm font-semibold mb-2">Payment Date</h1>
                                    <h1 class="text-[13px] text-paraColor ">{{ dateFormat($data['payment_date']) }}</h1>
                                </div>
                                <div class="mb-7">
                                    <h1 class="text-primary text-sm font-semibold mb-2">Total Paid Amount</h1>
                                    <h1 class="text-sm text-noti ">{{ number_format($sale->total_amount) }}</h1>
                                </div>
                                <div class="mb-7">
                                    <h1 class="text-primary text-sm font-semibold mb-2">Total Paid Amount</h1>
                                    <h1 class="text-[13px] text-paraColor ">
                                        {{ number_format($amount + $sale->total_paid_amount) }}
                                    </h1>
                                </div>
                            </div>
                            <div>

                            </div>
                            <div class="font-poppins ">
                                <div class="mb-7">
                                    <h1 class="text-primary text-sm font-semibold mb-2">Remain Amount</h1>
                                    <h1 class="text-[13px] text-paraColor ">
                                        {{ number_format($amount + $new_remained_amount) }}
                                    </h1>
                                </div>
                                <div class="mb-7">
                                    <h1 class="text-primary text-sm font-semibold mb-2">Amount</h1>
                                    <h1 class="text-[13px] text-paraColor ">{{ number_format($amount) }} </h1>
                                </div>
                                <div class="mb-7">
                                    <h1 class="text-primary text-sm font-semibold mb-2">New Remaining Amount</h1>
                                    <h1 class="text-sm text-noti ">{{ number_format($new_remained_amount) }}</h1>
                                </div>
                            </div>
                        </div>
                        <form id="myForm" action="{{ route('payment-store') }}" method="POST">
                            @csrf

                            <input type="hidden" name="data" value="{{ json_encode($data) }}">

                            <div class="flex items-center justify-center">
                                <button class="bg-noti font-jakarta text-white rounded-full font-semibold py-2 w-52 " type="submit" id="done">Confirm</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- create form end --}}
</section>
@endsection
@section('script')
<script>
    $(function() {
        $('input[name="code"]').daterangepicker({
            singleDatePicker: true,
            showDropdowns: true,
            minYear: 1901,
            maxYear: parseInt(moment().format('YYYY'), 10)
        }, function(start, end, label) {
            var years = moment().diff(start, 'years');

        });
    });
</script>
@endsection