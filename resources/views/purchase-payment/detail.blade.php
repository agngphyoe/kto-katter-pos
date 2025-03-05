@extends('layouts.master-without-nav')
@section('title', 'Payment Details')

@section('content')

    <section class="payment__create__final">
        {{-- nav start  --}}
        @include('layouts.header-section', [
            'title' => 'Purchase Payment Details',
            'subTitle' => 'Payments of Credit Purchase',
        ])
        {{-- nav end  --}}


        {{-- ...........  --}}
        {{-- create form start  --}}
        <div class="m-5 lg:m-7" id="myContent">

            <div class="bg-white rounded-[20px] p-5 lg:p-14">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-16 ">
                    <div class="col-span-1 md:col-span-1">
                        <div class="border-x border-b md:px-5 pb-10 rounded-b-[30px] shadow-xl">
                            <h1 class="mb-5 font-jakarta text-noti  text-center font-semibold">Supplier Details</h1>
                            @if ($payment->paymentableBy?->image)
                                <img src="{{ asset('suppliers/image/' . $payment->paymentableBy?->image) }}"
                                    class="w-24 h-24 object-cover mx-auto rounded-full mx-auto  " alt="">
                            @else
                                <img src="{{ asset('images/no-image.png') }}"
                                    class="  w-24 h-24 object-cover rounded-full mx-auto" alt="">
                            @endif
                            {{-- </div> --}}
                            <div class="font-poppins flex items-center justify-center mt-10">
                                <div>
                                    <div class="mb-4">
                                        <h1 class="text-primary text-sm font-semibold mb-2">Supplier Name <span
                                                class="text-paraColor opacity-50">(ID)</span></h1>
                                        <h1 class="text-[13px] text-paraColor ">{{ $payment->paymentableBy?->name }}<span
                                                class="text-noti     "> ({{ $payment->paymentableBy?->user_number }})</span>
                                        </h1>
                                    </div>
                                    <div class="mb-4">
                                        <h1 class="text-primary text-sm font-semibold mb-2">Phone Number</h1>
                                        <h1 class="text-[13px] text-paraColor ">{{ $payment->paymentableBy?->phone }}</h1>
                                    </div>
                                    <div>
                                        <h1 class="text-primary text-sm font-semibold mb-2">Address</h1>
                                        <h1 class="text-[13px] text-paraColor ">
                                            {{ $payment->paymentableBy?->address ?? '-' }}
                                        </h1>
                                    </div>
                                </div>


                            </div>
                        </div>
                    </div>
                    <div class="col-span-1 md:col-span-2 ">
                        <div class="mb-10">
                            <h1 class="text-noti font-semibold mb-6 text-center font-poppins">Payment Details
                            </h1>
                            <div class="flex items-center font-poppins justify-between flex-wrap gap-3 pt-4">
                                <div class="text-left">
                                    <h1 class="text-primary text-sm font-semibold mb-2">Invoice Number</h1>
                                    <h1 class="text-[13px] text-center text-paraColor ">
                                        {{ $purchase->invoice_number }}</h1>
                                </div>
                                <div class="text-right">
                                    <h1 class="text-primary text-sm font-semibold mb-2">Net Amount</h1>
                                    <h1 class="text-[13px] text-right text-primary">
                                        @if ($purchase->currency_type->value == 'kyat')
                                            {{ number_format($purchase->purchase_amount) }}
                                    </h1>
                                @else
                                    {{ number_format($purchase->currency_net_amount) }} </h1>
                                    @endif

                                </div>
                                <div class="text-right">
                                    <h1 class="text-primary text-sm font-semibold mb-2">Discount/Cashdown</h1>
                                    <h1 class="text-[13px] text-right text-primary">
                                        @if ($purchase->currency_type->value == 'kyat')
                                            {{ number_format($purchase->dicount_amount) }}
                                        @else
                                            {{ number_format($purchase->currency_discount_amount) }}
                                        @endif
                                        / {{ number_format($purchase->cash_down) }}
                                    </h1>
                                </div>
                                <div class="text-right">
                                    <h1 class="text-primary text-sm font-semibold mb-2">Total Paid Amount</h1>
                                    <h1 class="text-[13px] text-right text-primary">
                                        {{ number_format($purchase->total_paid_amount) }}</h1>
                                </div>
                                <div class="text-right">
                                    <h1 class="text-primary text-sm font-semibold mb-2">Remaining Amount</h1>
                                    <h1 class="text-[13px] text-right text-noti ">
                                        {{ number_format($purchase->remaining_amount) }} </h1>
                                </div>
                                <div class="text-left">
                                    <h1 class="text-primary text-sm font-semibold mb-2">Progress</h1>
                                    <x-badge
                                        class="{{ $payment->payment_status == 'Complete' ? 'bg-[#00812C]' : 'bg-[#FF8A00]' }} text-white px-3 text-left">
                                        {{ $payment->payment_status }}
                                    </x-badge>
                                </div>
                            </div>
                        </div>
                        <div>
                            <h1 class="text-noti font-semibold font-jakarta mb-6 font-poppins text-center ">
                                Payment Records</h1>
                            {{-- table start --}}
                            <div class="data-table">
                                <div class="  bg-white  font-poppins rounded-[20px]  ">

                                    <div>
                                        <div class="relative overflow-x-auto">
                                            <table class="w-full text-sm text-center text-gray-500 ">
                                                <thead class=" border-y text-primary   ">
                                                    <tr class="border-b text-left">
                                                        <th scope="col" class="px-6 py-3 font-medium text-right">
                                                            Paid Amount
                                                        </th>
                                                        <th scope="col" class="px-6 py-3 font-medium text-right">
                                                            Remaining Amount
                                                        </th>
                                                        <th scope="col" class="px-6 py-3 font-medium">
                                                            Paid Date
                                                        </th>
                                                        <th scope="col" class="px-6 py-3 font-medium">
                                                            Payment Type
                                                        </th>
                                                        <th scope="col" class="px-6 py-3 font-medium">
                                                            Created By
                                                        </th>

                                                    </tr>
                                                </thead>
                                                <tbody class="text-[13px]">
                                                    @forelse($payment->paymentable?->paymentables()->orderByDesc('id')->get() as $payment)
                                                        <tr class="bg-white border-b text-left">
                                                            <td scope="row"
                                                                class="px-6 py-3   whitespace-nowrap text-right">
                                                                {{ number_format($payment->amount) }}


                                                            </td>
                                                            <td class="px-6 py-3 text-right">
                                                                {{ number_format($payment->remaining_amount) }}
                                                            </td>
                                                            <td class="px-4 py-3 ">
                                                                {{ dateFormat($payment->payment_date) }}

                                                            </td>
                                                            <td class="px-6 py-3 ">
                                                                @php
                                                                    $bank = \App\Models\Bank::find(
                                                                        $payment->payment_type,
                                                                    );
                                                                @endphp
                                                                {{ $bank->bank_name }}
                                                            </td>
                                                            <td class="px-6 py-3">
                                                                {{ $payment->user?->name }}

                                                            </td>


                                                        </tr>
                                                    @empty
                                                    @endforelse
                                                </tbody>
                                            </table>
                                        </div>

                                    </div>


                                </div>
                            </div>
                            {{-- table end  --}}

                            <div class="flex justify-center">
                                <a href="{{ route('purchase-payment') }}"
                                    class="bg-noti text-white font-jakarta font-semibold mt-10 px-20 py-2 rounded-full">Back</a>
                            </div>
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
        function handlePrint() {

            executeDetailPrint("myContent")

        }
    </script>
@endsection
