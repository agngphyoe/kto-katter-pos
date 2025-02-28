@extends('layouts.master-without-nav')
@section('title', 'Payment Create')
@section('css')

@endsection
@section('content')
<section class="payment__create__first">
    {{-- nav start  --}}
    @include('layouts.header-section', [
    'title' => 'Purchase Payment Create',
    'subTitle' => 'Enter the customer to create a payment',
    ])
    {{-- nav end  --}}

    {{-- main start  --}}
    <div class="m-5 lg:m-7">

        <div class="bg-white rounded-[20px] mb-5 shadow-xl">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-10 p-5 lg:p-10">
                <div class="col-span-1">
                    <div class="bg-bgMain p-5 rounded-[20px]  md:mx-0">

                        <img src="{{ asset('images/paymentCreate.png') }}" class="w-48 animate__animated animate__bounce h-48 mx-auto" alt="">
                    </div>
                </div>

                <div class="col-span-1 flex items-center justify-center">
                    <form id="myForm" action="{{ route('purchase-payment-create-second') }}">
                        @csrf
                        <div>

                            <div class="flex items-center justify-center mb-5 flex-wrap gap-10">
                                <div class="flex flex-col mb-5">
                                    <x-select-component label="Select Supplier" name="supplier_id" id="supplierID" :data="$suppliers" required/>
                                </div>
                            </div>
                            <div class="flex justify-center ">
                                <div>
                                    <x-button-component class="bg-noti text-white w-[300px]" type="submit" id="done">
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
        $("#supplierID").on("change", function() {
            var selectedValue = $(this).val();

            var selectedSupplierName = $(this).find(':selected').text();

            $('#supplierName').val(selectedSupplierName);
        });
    })
</script>

@endsection