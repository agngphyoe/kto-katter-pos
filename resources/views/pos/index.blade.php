@extends('layouts.master')
@section('title', 'Point of Sales List')
@section('mainTitle', 'Point of Sales List')

@section('css')

@endsection

@section('content')
    <section class="purchase">

        {{-- search start --}}
        <x-search-com routeName="purchase-create-first" exportName="pos" />
        {{-- search end  --}}

        {{-- .......  --}}
        {{-- main start  --}}
        <div class=" md:ml-[270px] font-jakarta ml-[20px] my-5 mr-[20px] 2xl:ml-[320px]">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-10">
                {{-- purchase start  --}}
                <div>
                    <div class="bg-white px-5 py-2 rounded-[20px]">
                        <h1 class="border-b-2 text-center text-noti font-semibold p-2 ">Sale Quantity</h1>
                        <div class="grid grid-cols-5  gap-5 ">
                            <div class="col-span-2 ">

                                <div class="">

                                    <div id="chart"></div>

                                </div>

                            </div>
                            <div class="col-span-3 flex flex-col mt-8 gap-3">
                                <input id="total_sale_quantity" value="{{ $sale_data['total_sale_count'] }}" hidden>
                                <input id="total_sale_amount" value="{{ $sale_data['total_sale_amount'] }}" hidden>

                                <input id="today_sale_quantity_percentage"
                                    value="{{ $sale_data['today_sale_quantity_percentage'] }}" hidden>
                                <input id="total_sale_quantity_percentage" value="100" hidden>

                                <input id="today_sale_amount_percentage"
                                    value="{{ $sale_data['today_sale_amount_percentage'] }}" hidden>
                                <input id="total_sale_amount_percentage" value="100" hidden>

                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-3">
                                        <div class="w-4 h-4 bg-paraColor rounded-full "></div>
                                        <h1 class="text-paraColor text-sm font-semibold">Total Sales</h1>
                                    </div>
                                    <div>
                                        <h1>{{ number_format(round($sale_data['total_sale_count'])) }}</h1>

                                    </div>
                                </div>
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-3">
                                        <div class="w-4 h-4 bg-primary rounded-full "></div>
                                        <h1 class="text-paraColor text-sm font-semibold">Today Sales</h1>
                                    </div>
                                    <div>
                                        <h1 class="text-primary">
                                            {{ number_format(round($sale_data['today_sale_quantity'])) }}</h1>
                                        {{-- <input id="total_sale_count" value="{{ $sale_data['total_sale_count'] }}" hidden> --}}
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
                        <h1 class="border-b-2 text-center text-noti font-semibold p-2 ">Sale Amount</h1>
                        <div class="grid grid-cols-5  gap-5 ">
                            <div class="col-span-2">

                                <div class="">

                                    <div id="chart1"></div>

                                </div>

                            </div>
                            <div class="col-span-3 flex flex-col mt-8 gap-3">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-3">
                                        <div class="w-4 h-4 bg-paraColor rounded-full "></div>
                                        <h1 class="text-paraColor text-sm font-semibold">Total Sales</h1>
                                    </div>
                                    <div>
                                        <h1 class="text-sm">{{ number_format($sale_data['total_sale_amount']) }} </h1>
                                    </div>
                                </div>
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-3">
                                        <div class="w-4 h-4 bg-primary rounded-full "></div>
                                        <h1 class="text-paraColor text-sm font-semibold">Today Sales</h1>
                                    </div>
                                    <div>
                                        <h1 class="text-primary text-sm">
                                            {{ number_format($sale_data['today_sale_amount']) }} </h1>
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
                    <div class="flex items-center gap-3">

                        <h1 class="text-[#999999] font-poppins text-sm">Number of Sales Today :
                            <span class="showTotal text-primary">{{ $today_sale_count }}</span>

                        </h1>

                    </div>
                </div>

                {{-- table start --}}
                <div class="data-table">
                    <div class="bg-white px-1 py-2 rounded-[20px]">

                        <div>

                            <div class=" overflow-x-auto  mt-3 h-[450px] shadow-lg">
                                <table class="w-full text-sm text-center">
                                    <thead
                                        class="text-sm sticky top-0 text-center z-10 text-primary bg-gray-50 font-jakarta">
                                        {{-- <x-table-head-component :columns="[
                                            'Sale ID',
                                            'Customer Name',
                                            'Total Quantity',
                                            'Total Amount',
                                            'Discount Amount',
                                            'Net Total Amount',
                                            'Paid Amount',
                                            'Change Amount',
                                            'Payment Type',
                                            'Sell Date',
                                            'Sell By',
                                            'Action',
                                        ]" /> --}}
                                        <tr class="text-left border-b">
                                            <th
                                                class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-left">
                                                Sale ID
                                            </th>
                                            <th
                                                class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-left">
                                                Customer Name
                                            </th>
                                            <th
                                                class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-center">
                                                Total Quantity
                                            </th>
                                            <th
                                                class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-right">
                                                Total Amount
                                            </th>
                                            <th
                                                class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-right">
                                                Discount Amount
                                            </th>
                                            <th
                                                class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-right">
                                                Net Total Amount
                                            </th>
                                            <th
                                                class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-right">
                                                Paid Amount
                                            </th>
                                            <th
                                                class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-right">
                                                Change Amount
                                            </th>
                                            <th
                                                class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-left">
                                                Payment Type
                                            </th>
                                            <th
                                                class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-left">
                                                Sell Date
                                            </th>
                                            <th
                                                class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-left">
                                                Sell By
                                            </th>
                                            <th
                                                class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-center">
                                                Action
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody id="searchResults"
                                        class="text-[13px] animate__animated animate__slideInUp font-normal text-paraColor font-poppins">

                                        @include('pos.search-order')

                                    </tbody>
                                </table>
                            </div>
                            {{ $today_sales->links('layouts.paginator') }}
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
        $(document).ready(function() {
            var searchRoute = "{{ route('pos-list') }}";

            executeSearch(searchRoute)
        });
    </script>

    <script>
        // apex chart start
        const total_sale_quantity = Number($('#total_sale_quantity').val());
        
        const today_sale_quantity_percentage = $('#today_sale_quantity_percentage').val();

        var options = {
            series: [100, Math.round(today_sale_quantity_percentage)],
            colors: ['#C7C7C7', '#00812C'],
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
                                return total_sale_quantity.toLocaleString();
                            }
                        }
                    }
                }
            },
            labels: ['Total', 'Today'],
        };

        var chart = new ApexCharts(document.querySelector("#chart"), options);
        chart.render();

        const total_sale_amount = Number($('#total_sale_amount').val());
        const today_sale_amount_percentage = $('#today_sale_amount_percentage').val();

        // apex chart start
        var options1 = {
            series: [100, Math.round(today_sale_amount_percentage)],
            colors: ['#C7C7C7', '#00812C'],
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
                                return Number(Math.round(total_sale_amount)).toLocaleString()
                            }
                        }
                    }
                }
            },
            // colors:['#00812C','#00812C','#FEB62A']
            labels: ['Total', 'Today'],
        };

        var chart = new ApexCharts(document.querySelector("#chart1"), options1);
        chart.render();
    </script>

@endsection
