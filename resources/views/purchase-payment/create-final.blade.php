@extends('layouts.master-without-nav')
@section('title', 'Create Payment')
@section('css')

@endsection
@section('content')
    <section class="purchase__payment__create__final">
        {{-- nav start  --}}
        @include('layouts.header-section', [
            'title' => 'Purchase Payment Create',
            'subTitle' => 'Check your inputs',
        ])
        {{-- nav end  --}}


        {{-- ...........  --}}
        {{-- create form start  --}}
        <div class="m-5 lg:m-7">
            <div class="bg-white rounded-[20px] p-7 md:p-14 mb-10">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-16 ">
                    <div class="col-span-1 md:col-span-1">
                        <div class="border-x border-b md:px-5 pb-10 rounded-b-[30px] shadow-xl">
                            <h1 class="mb-5 font-jakarta text-noti text-center font-semibold">Supplier Details</h1>
                            <div class="">
                                @if ($purchase->supplier->image)
                                    <img src="{{ asset('suppliers/image/' . $purchase->supplier->image) }}"
                                        class="w-24 h-24 rounded-full object-cover mx-auto" alt="">
                                @else
                                    <img src="{{ asset('images/no-image.png') }}"
                                        class="w-24 h-24 rounded-full object-cover mx-auto" alt="">
                                @endif
                            </div>
                            <div class="font-poppins flex items-center justify-center mt-10">
                                <div>
                                    <div class="mb-4">
                                        <h1 class="text-primary text-sm font-semibold mb-2">Supplier Name <span
                                                class="text-paraColor opacity-50">(ID)</span></h1>
                                        <h1 class="text-[13px] text-paraColor ">{{ $purchase->supplier->name }}<span
                                                class="text-noti">({{ $purchase->supplier->user_number }})</span></h1>
                                    </div>
                                    <div class="mb-4">
                                        <h1 class="text-primary text-sm font-semibold mb-2">Phone Number</h1>
                                        <h1 class="text-[13px] text-paraColor ">{{ $purchase->supplier->phone }}</h1>
                                    </div>
                                    <div>
                                        <h1 class="text-primary text-sm font-semibold mb-2">Address</h1>
                                        <h1 class="text-[13px] text-paraColor ">{{ $purchase->supplier->address ?? '-' }}
                                        </h1>
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
                                        <h1 class="text-[13px] text-paraColor ">{{ $purchase->invoice_number }}</h1>
                                    </div>

                                    <div class="mb-7">
                                        <h1 class="text-primary text-sm font-semibold mb-2">Net Amount</h1>
                                        <h1 class="text-sm text-noti ">
                                            {{ number_format($purchase->currency_net_amount) ?? '-' }}
                                        </h1>
                                    </div>
                                    @if ($new_remained_amount != 0)
                                        <div class="mb-7">
                                            <h1 class="text-primary text-sm font-semibold mb-2">Next Payment Date</h1>
                                            <h1 class="text-[13px] text-paraColor ">
                                                {{ dateFormat($data['next_purchase_payment_date']) }}
                                            </h1>
                                        </div>
                                    @endif

                                    <div class="mb-7">
                                        <h1 class="text-primary text-sm font-semibold mb-2">Paid Amount</h1>
                                        <h1 class="text-[13px] text-paraColor ">{{ number_format($amount) }}</h1>
                                    </div>

                                    <div class="mb-7">
                                        <h1 class="text-primary text-sm font-semibold mb-2">Payment</h1>
                                        <h1 class="text-[13px] text-paraColor ">{{ $bank->bank_name }}</h1>
                                    </div>

                                    {{-- <div class="mb-7">
                                    <h1 class="text-primary text-sm font-semibold mb-2">Total Return Amount</h1>
                                    <h1 class="text-[13px] text-paraColor ">{{ number_format( $purchase->total_return_buying_amount ) ?? '-' }} </h1>
                            </div> --}}

                                </div>
                                <div>

                                </div>
                                <div class="font-poppins ">
                                    {{-- <div class="mb-7">
                                <h1 class="text-primary text-sm font-semibold mb-2">Last Remaining Amount</h1>
                                <h1 class="text-[13px] text-paraColor ">
                                    {{ number_format( $purchase->remaining_amount - $purchase->total_return_buying_amount ) }}
                                </h1>
                            </div> --}}
                                    <div class="mb-7">
                                        <h1 class="text-primary text-sm font-semibold mb-2">Total Paid Amount</h1>
                                        <h1 class="text-[13px] text-paraColor ">
                                            {{ number_format($purchase->total_paid_amount + $amount) ?? '-' }}
                                        </h1>
                                    </div>
                                    <div class="mb-7">
                                        <h1 class="text-primary text-sm font-semibold mb-2">Total Remaining Amount</h1>
                                        <h1 class="text-sm text-noti ">{{ number_format($new_remained_amount) }}</h1>
                                    </div>


                                </div>
                            </div>
                            <form id="submitForm" action="{{ route('purchase-payment-store') }}" method="POST">
                                @csrf

                                <input type="hidden" name="data" value="{{ json_encode($data) }}">
                                <div class="flex items-center justify-center">
                                    <button class="bg-noti font-jakarta text-white rounded-full font-semibold py-2 w-52 "
                                        type="submit" id="submitButton">Confirm</button>
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
