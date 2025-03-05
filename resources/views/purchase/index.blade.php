@extends('layouts.master')
@section('title', 'Purchases List')
@section('mainTitle', 'Purchases List')

@section('css')

@endsection

@php
    $total_cash_count = $purchase_counts['total_cash_count'];
    $total_credit_count = $purchase_counts['total_credit_count'];
    $total_purchase_count = $total_cash_count + $total_credit_count;

    $total_cash_amount = $purchase_amount['total_cash_amount'];
    $total_credit_amount = $purchase_amount['total_credit_amount'];
    $total_purchase_amount = $total_cash_amount + $total_credit_amount;

    $total_cash_count_percentage =
        $total_cash_count > 0 && $total_purchase_count > 0 ? ($total_cash_count / $total_purchase_count) * 100 : 0;
    $total_credit_count_percentage =
        $total_credit_count > 0 && $total_purchase_count > 0 ? ($total_credit_count / $total_purchase_count) * 100 : 0;

    $total_cash_amount_percentage =
        $total_cash_amount > 0 && $total_purchase_amount > 0 ? ($total_cash_amount / $total_purchase_amount) * 100 : 0;
    $total_credit_amount_percentage =
        $total_credit_amount > 0 && $total_purchase_amount > 0
            ? ($total_credit_amount / $total_purchase_amount) * 100
            : 0;
@endphp

@section('content')
    <section class="purchase">

        {{-- search start --}}
        <x-search-com routeName="purchase-create-first" exportName="purchases" name="Create a New Purchase"
            permissionName="purchase-create" />
        {{-- search end  --}}

        {{-- .......  --}}
        {{-- main start  --}}
        <div class=" md:ml-[270px] font-jakarta ml-[20px] my-5 mr-[20px] 2xl:ml-[320px]">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-10">
                {{-- purchase start  --}}
                <div>
                    <div class="bg-white px-5 py-2 rounded-[20px]">
                        <h1 class="border-b-2 text-center text-noti font-semibold p-2 ">Purchase</h1>
                        <div class="grid grid-cols-5  gap-5 ">
                            <div class="col-span-2 ">
                                {{-- radical bar chart start --}}
                                <div class="">
                                    {{-- <img src="{{ asset('images/Pie Chart.png') }}" class="mx-auto" alt=""> --}}
                                    <div id="chart"></div>

                                </div>
                                {{-- radical bar chart start --}}
                                {{-- <img src="{{ asset('images/piechart.png') }}" class="h-32 w-32" alt=""> --}}
                            </div>
                            <div class="col-span-3 flex flex-col mt-8 gap-3">
                                <input id="total_purchase_count" value="{{ $total_purchase_count }}" hidden>
                                <input id="total_purchase_amount" value="{{ $total_purchase_amount }}" hidden>

                                <input id="total_cash_count_percentage" value="{{ $total_cash_count_percentage }}" hidden>
                                <input id="total_credit_count_percentage" value="{{ $total_credit_count_percentage }}"
                                    hidden>

                                <input id="total_cash_amount_percentage" value="{{ $total_cash_amount_percentage }}" hidden>
                                <input id="total_credit_amount_percentage" value="{{ $total_credit_amount_percentage }}"
                                    hidden>

                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-3">
                                        <div class="w-4 h-4 bg-paraColor rounded-full "></div>
                                        <h1 class="text-paraColor text-sm font-semibold">Purchase</h1>
                                    </div>
                                    <div>
                                        <h1>{{ number_format(round($total_purchase_count)) }}</h1>

                                    </div>
                                </div>
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-3">
                                        <div class="w-4 h-4 bg-primary rounded-full "></div>
                                        <h1 class="text-paraColor text-sm font-semibold">Cash</h1>
                                    </div>
                                    <div>
                                        <h1 class="text-primary">{{ number_format(round($total_cash_count)) }}</h1>
                                        <input id="total_purchase_count" value="{{ $total_purchase_count }}" hidden>
                                    </div>
                                </div>
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-3">
                                        <div class="w-4 h-4 bg-noti rounded-full "></div>
                                        <h1 class="text-paraColor text-sm font-semibold">Credit</h1>
                                    </div>
                                    <div>
                                        <h1 class="text-noti">{{ number_format(round($total_credit_count)) }}</h1>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- purchase end --}}

                {{-- amount of purchase start  --}}
                <div>
                    <div class="bg-white px-5 py-2 rounded-[20px]">
                        <h1 class="border-b-2 text-center text-noti font-semibold p-2 ">Amount of Purchases</h1>
                        <div class="grid grid-cols-5  gap-5 ">
                            <div class="col-span-2">
                                {{-- radical bar chart start --}}
                                <div class="">
                                    {{-- <img src="{{ asset('images/Pie Chart.png') }}" class="mx-auto" alt=""> --}}
                                    <div id="chart1"></div>

                                </div>
                                {{-- radical bar chart start --}}
                                {{-- <img src="{{ asset('images/piechart.png') }}" class="h-32 w-32" alt=""> --}}
                            </div>
                            <div class="col-span-3 flex flex-col mt-8 gap-3">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-3">
                                        <div class="w-4 h-4 bg-paraColor rounded-full "></div>
                                        <h1 class="text-paraColor text-sm font-semibold">Purchase</h1>
                                    </div>
                                    <div>
                                        <h1 class="text-sm">{{ number_format($total_purchase_amount) }} </h1>
                                    </div>
                                </div>
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-3">
                                        <div class="w-4 h-4 bg-primary rounded-full "></div>
                                        <h1 class="text-paraColor text-sm font-semibold">Cash</h1>
                                    </div>
                                    <div>
                                        <h1 class="text-primary text-sm">{{ number_format($total_cash_amount) }} </h1>
                                    </div>
                                </div>
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-3">
                                        <div class="w-4 h-4 bg-noti rounded-full "></div>
                                        <h1 class="text-paraColor text-sm font-semibold">Credit</h1>
                                    </div>
                                    <div>
                                        <h1 class="text-noti text-sm">{{ number_format($total_credit_amount) }} </h1>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- amount of purchase end --}}

            </div>

            {{-- table start  --}}
            <div class="bg-white p-5 rounded-[20px] mt-5">
                <div class="flex items-center justify-between">
                    <h1 class="text-[#999999] font-poppins text-sm">Search Result : <span
                            class="showTotal text-primary">0</span></h1>
                    <h1 class="text-[#999999] font-poppins text-sm">Number of Purchases : <span
                            class="text-primary">{{ $purchases->count() }}</span></h1>
                </div>

                {{-- table start --}}
                <div class="data-table">
                    <div class="bg-white px-1 py-2 rounded-[20px]">

                        <div>

                            <div class=" overflow-x-auto  mt-3 h-[450px] shadow-lg">
                                <table class="w-full text-sm text-left       ">
                                    <thead class="text-sm sticky top-0  z-10   text-primary  bg-gray-50 font-jakarta  ">
                                        {{-- <x-table-head-component :columns="[
                                            'Purchase ID',
                                            'Supplier ID',
                                            'Supplier Name',
                                            'Purchase Type',
                                            'Currency Type',
                                            'Total Quantity',
                                            'Total Buying Amount',
                                            'Discount',
                                            'Net Amount',
                                            'Cash Down',
                                            'Paid Amount',
                                            'Remaining Amount',
                                            'Status',
                                            'Purchase Date',
                                            'Purchase By',
                                            'Action',
                                        ]" /> --}}
                                        <tr class="text-left border-b">
                                            <th
                                                class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-left">
                                                Purchase ID
                                            </th>
                                            <th
                                                class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-left">
                                                Supplier ID
                                            </th>
                                            <th
                                                class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-left">
                                                Supplier Name
                                            </th>
                                            <th
                                                class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-left">
                                                Purchase Type
                                            </th>
                                            <th
                                                class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-left">
                                                Currency Type
                                            </th>
                                            <th
                                                class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-center">
                                                Total Quantity
                                            </th>
                                            <th
                                                class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-left">
                                                Total Buying Amount
                                            </th>
                                            <th
                                                class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-left">
                                                Discount
                                            </th>
                                            <th
                                                class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-left">
                                                Net Amount
                                            </th>
                                            <th
                                                class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-left">
                                                Cash Down
                                            </th>
                                            <th
                                                class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-left">
                                                Paid Amount
                                            </th>
                                            <th
                                                class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-left">
                                                Remaining Amount
                                            </th>
                                            <th
                                                class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-left">
                                                Status
                                            </th>
                                            <th
                                                class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-left">
                                                Purchase Date
                                            </th>
                                            <th
                                                class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-left">
                                                Purchase By
                                            </th>
                                            <th
                                                class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-center">
                                                Action
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody id="searchResults"
                                        class="text-[13px] animate__animated animate__slideInUp font-normal text-paraColor font-poppins">

                                        @include('purchase.search')

                                    </tbody>
                                </table>
                            </div>
                            {{ $purchases->links('layouts.paginator') }}

                        </div>


                    </div>
                </div>
                {{-- table end  --}}
            </div>
            {{-- table end --}}
        </div>

        {{-- main end --}}


    </section>
@endsection
@section('script')
    <script>
        clearLocalStorage();

        $(document).ready(function() {
            var searchRoute = "{{ route('purchase') }}";

            executeSearch(searchRoute)
        });
    </script>
    <script>
        // apex chart start
        const total_purchase_count = $('#total_purchase_count').val();
        const total_cash_count_percentage = $('#total_cash_count_percentage').val();
        const total_credit_count_percentage = $('#total_credit_count_percentage').val();

        var options = {
            series: [100, Math.round(total_cash_count_percentage), Math.round(total_credit_count_percentage)],
            colors: ['#C7C7C7', '#00812C', '#FF8A00'],
            chart: {
                height: 180,
                type: 'radialBar',
            },
            plotOptions: {
                radialBar: {
                    dataLabels: {
                        name: {
                            fontSize: '16px',
                        },
                        value: {
                            fontSize: '12px',
                        },
                        total: {
                            show: true,
                            label: 'Total',
                            formatter: function(w) {
                                // By default this function returns the average of all series. The below is just an example to show the use of custom formatter function
                                return Number(Math.round(total_purchase_count)).toLocaleString();
                            }
                        }
                    }
                }
            },
            // colors:['#00812C','#00812C','#FEB62A']
            labels: ['Purchase', 'Cash', 'Credit'],
        };

        var chart = new ApexCharts(document.querySelector("#chart"), options);
        chart.render();

        const total_purchase_amount = $('#total_purchase_amount').val();
        const total_cash_amount_percentage = $('#total_cash_amount_percentage').val();
        const total_credit_amount_percentage = $('#total_credit_amount_percentage').val();

        // apex chart start
        var options1 = {
            series: [100, Math.round(total_cash_amount_percentage), Math.round(total_credit_amount_percentage)],
            colors: ['#C7C7C7', '#00812C', '#FF8A00'],
            chart: {
                height: 180,
                type: 'radialBar',
            },
            plotOptions: {
                radialBar: {
                    dataLabels: {
                        name: {
                            fontSize: '16px',
                        },
                        value: {
                            fontSize: '12px',
                        },
                        total: {
                            show: true,
                            label: 'Total',
                            formatter: function(w) {
                                // By default this function returns the average of all series. The below is just an example to show the use of custom formatter function
                                return Number(Math.round(total_purchase_amount)).toLocaleString()
                            }
                        }
                    }
                }
            },
            // colors:['#00812C','#00812C','#FEB62A']
            labels: ['Purchase', 'Cash', 'Credit'],
        };

        var chart = new ApexCharts(document.querySelector("#chart1"), options1);
        chart.render();
    </script>
@endsection
