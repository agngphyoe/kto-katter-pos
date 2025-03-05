@extends('layouts.master-without-nav')
@section('title', 'Payment Create')
@section('css')

@endsection
@section('content')
<section class="payment__create__first">
    {{-- nav start  --}}
    @include('layouts.header-section', [
    'title' => 'Payment Create',
    'subTitle' => 'Enter the customer to create a payment',
    ])
    {{-- nav end  --}}

    {{-- main start  --}}
    <div class="m-5 lg:m-7">

        <div class="bg-white rounded-[20px] mb-5 shadow-xl">
            <div class="grid grid-cols-1 xl:grid-cols-3 gap-10  p-5 lg:p-10">
                <div class="col-span-1 xl:col-span-1">
                    <div class="bg-bgMain p-5 rounded-[20px]  md:mx-0">

                        <img src="{{ asset('images/purchasecreate.png') }}" class="w-48 h-48 mx-auto" alt="">
                    </div>
                </div>

                <div class="col-span-1 xl:col-span-2 flex items-center justify-center">
                    <form id="myForm" action="{{ route('payment-create-second') }}">
                        @csrf
                        <div>

                            <div class="flex items-center justify-start mb-5 flex-wrap gap-10">
                                <div class="flex flex-col mb-5">
                                    <x-select-component label="Select Customer" name="customer_id" id="customerID" :data="$customers" />

                                </div>
                                <div class="flex flex-col mb-5">
                                    <x-input-field-component type="text" value="" label="Customer Name" name="name" id="customerName" text="Name..." readonly="true" />
                                </div>


                            </div>
                            <div class="flex justify-center ">
                                <div>
                                    <x-button-component class="bg-noti text-white" type="submit" id="done">
                                        Next
                                    </x-button-component>
                                </div>

                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>

    </div>
    {{-- main end --}}
</section>
@endsection
@section('script')
<script>
    $(document).ready(function() {
        $("#customerID").on("change", function() {
            var selectedValue = $(this).val();

            var selectedCustomerName = $(this).find(':selected').text();

            $('#customerName').val(selectedCustomerName);
        });
    })
</script>

@endsection