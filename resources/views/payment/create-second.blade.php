@extends('layouts.master-without-nav')
@section('title', 'Payment Create')
@section('css')
@php

use App\Constants\ExchangeCashType;

@endphp
<style>
    /* Style for the progress bar container */
    .progress {
        width: 100%;
        background-color: #f0f0f0;
        border-radius: 4px;
        height: 20px;
        overflow: hidden;
    }

    /* Style for the progress bar itself */
    .progress-bar {
        height: 100%;
        color: #fff;
        text-align: center;
        line-height: 20px;
        /* To center the percentage text vertically */
        background-color: #007bff;
        /* Change this to your desired color */
        transition: width 0.3s ease-in-out;
        /* Animation for smooth width transition */
    }
</style>

@endsection
@section('content')
<section class="payment__create__second">
    {{-- nav start  --}}
    @include('layouts.header-section', [
    'title' => 'Payment Create',
    'subTitle' => 'Enter the customer to create a payment',
    ])
    {{-- nav end  --}}

    {{-- main start  --}}
    {{-- table start --}}


    <div class="m-5 lg:m-7">
        <div class="data-table mt-5">
            <div class="  bg-white px-4 py-2 font-jakarta rounded-[20px]  ">
                <div>
                    <div class="relative overflow-x-auto mt-4  ">
                        <table class="w-full text-sm text-left text-gray-500 ">
                            <thead class="text-sm  bg-gray-50  text-primary  ">

                                <x-table-head-component :columns="[
                                    'Customer Name',
                                    'Sale Invoice',
                                    'Sale Type',
                                    'Total Amount',
                                    'Total Paid Amount',
                                    'Return(+) / Refund(-)',
                                    'Cash Down',
                                    'Remaining Amount',
                                    'Progress',
                                    'Received At',
                                    'Action']" />
                            </thead>
                            {{-- form start --}}
                            <form action="{{ route('payment-create-third') }}" id="myForm">
                                @csrf
                                <input id="sale_id" name="sale_id" hidden>
                            </form>

                            <tbody class="font-poppins text=sm">
                                @forelse ($sales as $sale)

                                <tr class="bg-white border-b ">
                                    <th scope="row" class="px-3 py-3 whitespace-nowrap font-medium  text-gray-900  ">
                                        <div class="flex items-center gap-3 ">
                                            <div class="">
                                                @if($sale->saleableBy?->image)
                                                <img src="{{ asset('customers/image/'. $sale->saleableBy->image) }}" class="w-10 h-10 object-contain " alt="">
                                                @else
                                                <img src="{{ asset('images/no-image.png') }}" class="w-10 h-10 object-contain" alt="">
                                                @endif
                                            </div>
                                            <h1>{{ $sale->saleableBy?->name }}<span class="text-noti">({{ $sale->saleableBy?->user_number }})</span></h1>
                                        </div>

                                    </th>
                                    <td class="px-6 py-3 whitespace-nowrap">
                                        {{ $sale->invoice_number }}
                                    </td>

                                    <td class="px-6 py-3 whitespace-nowrap">
                                        <x-badge class="bg-noti text-white px-3">
                                            {{ $sale->action_type }}
                                        </x-badge>

                                    </td>

                                    <td class=" px-6 text-right py-3 whitespace-nowrap">
                                        {{ $sale->total_amount}}
                                    </td>

                                    @php
                                        if($sale->paymentables->first())
                                        {
                                        $latest_sale_payment = $sale->paymentables->last();
                                        $total_paid_amount = $latest_sale_payment->total_paid_amount;
                                        }else{
                                            $total_paid_amount = 0;
                                        }

                                        $latest_sale_return = $sale->returnable->last();

                                        $return_refund_amount = $latest_sale_return?->latest_cash_back_amount;
                                        $total_amount = $sale->total_amount;
                                        if($return_refund_amount){

                                            if($latest_sale_return?->latest_cash_back_type == ExchangeCashType::REFUND){
                                                $total_amount -= $return_refund_amount;
                                                $return_refund_amount = -$return_refund_amount;
                                            }else{
                                                $total_amount += $return_refund_amount;
                                                $return_refund_amount = $return_refund_amount;
                                            }
                                        }else{

                                            $return_refund_amount = 0;

                                        }

                                    @endphp
                                    <td class=" px-6 text-right py-3 whitespace-nowrap">
                                        {{ number_format($total_paid_amount) ?? 0 }}
                                    </td>
                                    <td class=" px-6 text-right py-3 whitespace-nowrap text-noti">
                                        {{ number_format($return_refund_amount) ?? 0 }}
                                    </td>
                                    <td class=" px-6 text-right py-3 whitespace-nowrap text-noti">
                                        {{ number_format($sale->cash_down) ?? '-'}}
                                    </td>
                                    <td class=" px-6 text-right py-3 whitespace-nowrap text-noti">
                                        {{ number_format($total_amount - ( $sale->cash_down + $total_paid_amount ) )?? '-'}}
                                    </td>
                                    <td class="px-6 py-3 whitespace-nowrap">

                                        <div class="flex items-center gap-3">
                                            <div class="bg-gray-200 w-20 h-1 rounded-full">
                                                <div class="h-1 bg-primary  text-[6px] text-center  rounded-full text-white " style="width: {{ getLatestAndPaymentRecord($sale) }}%"></div>
                                            </div>
                                            <h1 class="text-primary">{{ getLatestAndPaymentRecord($sale) }}%</h1>
                                        </div>
                                    </td>
                                    <td class="px-6 py-3 whitespace-nowrap">
                                        {{ dateFormat($sale->created_at) }}
                                    </td>
                                    <td class="px-6 py-3 whitespace-nowrap text-[11px]">
                                        <x-badge class="px-3 selectBtn cursor-pointer bg-primary text-white " data-sale-id="{{ $sale->id }}">
                                            Go Payment
                                        </x-badge>
                                      
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
    </div>

    {{-- table end  --}}

    {{-- main end --}}
</section>
@endsection
@section('script')
<script>
    $('.selectBtn').on('click', function() {
        var sale_id = $(this).data('sale-id');
        console.log(sale_id)
        $('#sale_id').val(sale_id);
        $('#myForm').submit();
    });
</script>

@endsection
