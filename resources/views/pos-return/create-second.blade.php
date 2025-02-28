@extends('layouts.master-without-nav')
@section('title', 'POS Return Create')
@section('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.8/css/dataTables.dataTables.css" />


@endsection
@section('content')
    <section class="purchase__return__create__third">
        {{-- nav start  --}}
        @include('layouts.header-section', [
            'title' => 'Create A New POS Return',
            'subTitle' => 'Choose the purchase',
        ])
        {{-- nav end  --}}


        {{-- ........  --}}
        {{-- main start  --}}
        <div class="m-5 lg:m-10">

            {{-- table start --}}
            <div class="data-table mt-5">
                <div class="  bg-white px-4 py-2 font-poppins rounded-[20px]  ">

                    <div>
                        <div class="relative shadow-lg overflow-x-auto mt-3">
                            <table class="w-full text-sm  text-gray-500 " id="saleTable">
                                <thead class="font-jakarta bg-gray-50 text-primary ">

                                    {{-- <x-table-head-component :columns="[
                                        'Purchase (ID)',
                                        'Total Buying Amount',
                                        'Discount',
                                        'Paid Amount',
                                        'Quantity',
                                        'Purchased At',
                                        'Action',
                                    ]" /> --}}
                                    <tr class="text-left border-b">
                                        <th
                                            class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-left">
                                            Purchase (ID)</th>
                                        <th
                                            class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-right">
                                            Total buying Amount</th>
                                        <th
                                            class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-right">
                                            Discount</th>
                                        <th
                                            class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-right">
                                            Paid Amount</th>
                                        <th
                                            class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-center">
                                            Quantity</th>
                                        <th
                                            class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-left">
                                            Purchased At</th>
                                        <th
                                            class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-left">
                                            Action</th>
                                    </tr>

                                </thead>
                                <tbody
                                    class="font-normal animate__animated animate__slideInUp font-poppins text-[13px] text-paraColor">
                                    @foreach ($purchases as $purchase)
                                        <tr class="bg-white border-b text-center">
                                            <td class="px-6 py-4 whitespace-nowrap text-left">
                                                {{ $purchase->order_number ?? '-' }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-right ">
                                                {{ number_format($purchase->total_amount) ?? '-' }}
                                            </td>

                                            <td class="px-6 py-4 whitespace-nowrap text-right ">
                                                {{ number_format($purchase->discount_amount) ?? '-' }}
                                            </td>

                                            <td class="px-6 py-4 whitespace-nowrap text-right ">
                                                <span
                                                    class="text-noti">{{ number_format($purchase->net_amount) ?? '-' }}</span>
                                            </td>

                                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                                {{ number_format($purchase->total_quantity) ?? '-' }}
                                            </td>

                                            <td class="px-6 py-4 whitespace-nowrap text-left">
                                                {{ dateFormat($purchase->order_date ?? '-') }}
                                            </td>

                                            <td class="px-6 py-4 text-left">
                                                <a href="{{ route('pos-return-create-third', ['id' => $purchase->id]) }}"
                                                    class="bg-red-600 font-medium text-white px-3 rounded-full text-[12px] py-2">Return
                                                </a>
                                            </td>

                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>

            </div>

            <div class="flex justify-center mt-5">
                <a href="{{ url()->previous() }}">
                    <x-button-component class="outline outline-1 outline-noti text-noti" type="button">
                        Back
                    </x-button-component>
                </a>

            </div>
            {{-- table end  --}}
        </div>
        {{-- main end --}}



    </section>
@endsection
@section('script')
    <script src="https://cdn.datatables.net/2.0.8/js/dataTables.js"></script>
    <script>
        $(document).ready(function() {
            $('#saleTable').DataTable({
                ordering: false // Disables sorting entirely
            });
        });
    </script>
@endsection
