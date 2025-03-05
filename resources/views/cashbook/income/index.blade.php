@extends('layouts.master')
@section('title', 'Incomes')
@section('mainTitle', 'Incomes List')

@section('css')
@endsection
@section('content')

    <section class="master__list ">
        <div>
            {{-- search start --}}
            <x-search-com routeName="income-create" name="Create Income" permissionName="income-create" />

            {{-- search end --}}
        </div>
        <div class="data-table md:ml-[270px] my-5 mr-[20px] 2xl:ml-[320px] ml-[20px] ">

            <div class="  bg-white px-4 py-3 rounded-[20px] my-5">
                <h1 class="font-poppins text-paraColor font-semibold">
                    @php
                        $total = $incomes->sum('amount');
                    @endphp
                    Total Income Amount : <span class="text-primary">{{ number_format($total_income) }}</span>
                </h1>
                <div class=" overflow-x-auto shadow-xl mt-3">
                    <table class="w-full text-sm text-center text-gray-500 ">
                        <thead class="text-sm   font-jakarta text-primary  bg-gray-50 ">
                            {{-- <x-table-head-component :columns="[

                        // 'Employee',
                        'Business',
                        'Description',
                        'Account',
                        'Amount(MMK)',
                        'Invoice Number',
                        'Name By',
                        'Date By',
                        'Bank',
                        'Action'
                        ]" /> --}}
                            <tr class="text-center border-b ">
                                <th class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-left">
                                    Business
                                </th>
                                <th class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-left">
                                    Description
                                </th>
                                <th class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-left">
                                    Account
                                </th>
                                <th class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-right">
                                    Amount(MMK)
                                </th>
                                <th class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-left">
                                    Invoice Number
                                </th>
                                <th class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-left">
                                    Name By
                                </th>
                                <th class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-left">
                                    Date By
                                </th>
                                <th class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-left">
                                    Bank
                                </th>
                                <th class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3">
                                    Action
                                </th>
                            </tr>
                        </thead>
                        <tbody id="searchResults"
                            class="text-sm text-left animate__animated animate__slideInUp font-normal text-paraColor font-poppins">
                            @include('cashbook.income.search')
                        </tbody>
                    </table>
                </div>
                {{ $incomes->links('layouts.paginator') }}
            </div>
        </div>
    </section>
@endsection
@section('script')
    <script>
        $(document).ready(function() {
            var searchRoute = "{{ route('income-list') }}";

            executeSearch(searchRoute)
        });
    </script>
@endsection
