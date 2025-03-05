@extends('layouts.master')
@section('title', 'COA')
@section('mainTitle', 'COA Lists')

@section('css')
@endsection

@section('content')

    <section class="master__list ">

        <div class="data-table md:ml-[270px] my-5 mr-[20px] 2xl:ml-[320px] ml-[20px] ">

            <div class="  bg-white px-4 py-3 rounded-[20px] my-5">
                <div class=" overflow-x-auto shadow-xl mt-3 h-[500px]">
                    <table class="w-full  text-sm text-center text-gray-500 ">
                        <thead class="font-poppins sticky text-black ">
                            <tr class="border font-semibold text-primary bg-gray-50">
                                <th colspan="3" class="text-left px-6 py-4 border-r whitespace-nowrap"></th>
                                @php
                                    // Define an array of colors to alternate between
                                    $colors = [
                                        'rgba(0, 129, 44, 0.2)',
                                        'rgba(76, 175, 80, 0.2)',
                                        'rgba(255, 87, 51, 0.2)',
                                        'rgba(255, 182, 193, 0.2)',
                                        'rgba(70, 130, 180, 0.2)',
                                    ];
                                @endphp
                                @foreach ($business_types as $business_type)
                                    @php
                                        // Use modulo to cycle through the colors array
                                        $color = $colors[$loop->iteration % count($colors)];

                                    @endphp
                                    <td class="text-center px-6 py-8 border-r whitespace-nowrap" colspan="2"
                                        style="background-color: {{ $color }};">
                                        {{ $business_type->name }}
                                    </td>
                                @endforeach
                            </tr>
                            <tr class="border bg-gray-50 text-primary text-sm font-semibold">
                                <td class="text-left px-6 py-4 whitespace-nowrap border-r">Account Type</td>
                                <td class="text-left px-6 py-4 whitespace-nowrap border-r">Account No.</td>
                                <td class="text-left px-6 py-4 whitespace-nowrap border-r">Account Name</td>
                                @foreach ($business_types as $business_type)
                                    @php
                                        // Use the same color cycling for Cash In / Cash Out
                                        $color = $colors[$loop->iteration % count($colors)];
                                    @endphp
                                    <td class="text-center px-6 py-4 whitespace-nowrap border-r"
                                        style="background-color: {{ $color }};">
                                        Cash In
                                    </td>
                                    <td class="text-center px-6 py-4 whitespace-nowrap border-r"
                                        style="background-color: {{ $color }};">
                                        Cash Out
                                    </td>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody class="font-poppins">

                            @forelse($account_types as $account_type)
                                @php
                                    $total_amount = [];
                                @endphp
                                <tr>
                                    <th class="text-left px-6 py-4 border whitespace-nowrap"
                                        @if (!count($account_type->accounts) > 0) colspan="{{ count($business_types) * 2 + 3 }}" @endif
                                        rowspan="{{ count($account_type->accounts) + 1 }}">

                                        {{ $account_type->name }}
                                    </th>
                                </tr>
                                @forelse($account_type->accounts as $account)
                                    <tr>
                                        <td class="text-left px-6 py-4 border-b border-r whitespace-nowrap">
                                            {{ $account->account_number ?? '-' }}</td>
                                        <td class="text-left px-6 py-4 border-b border-r whitespace-nowrap">
                                            {{ $account->name }}</td>
                                        @forelse ($business_types as $business_type)
                                            @php
                                                $color = $colors[$loop->iteration % count($colors)];
                                                $cash_in =
                                                    $data[$account_type->name][$account->name][$business_type->name][
                                                        'cash_in'
                                                    ];
                                                $cash_out =
                                                    $data[$account_type->name][$account->name][$business_type->name][
                                                        'cash_out'
                                                    ];

                                                if (!isset($total_amount[$business_type->name])) {
                                                    $total_amount[$business_type->name] = [
                                                        'total_cash_in' => 0,
                                                        'total_cash_out' => 0,
                                                    ];
                                                }

                                                $total_amount[$business_type->name]['total_cash_in'] += $cash_in;
                                                $total_amount[$business_type->name]['total_cash_out'] += $cash_out;
                                            @endphp

                                            <td class="text-right px-6 py-4 border-b border-r whitespace-nowrap"
                                                style="background-color: {{ $color }};">
                                                {{ $cash_in > 0 ? number_format($cash_in) : '-' }}</td>

                                            <td class="text-right px-6 py-4 border-b border-r whitespace-nowrap"
                                                style="background-color: {{ $color }};">
                                                {{ $cash_out > 0 ? number_format($cash_out) : '-' }}</td>

                                        @empty
                                        @endforelse
                                    </tr>
                                @empty
                                @endforelse

                                <tr>
                                    <td colspan="3" class="px-6 py-4 border-r  font-semibold">Total</td>

                                    @forelse($business_types as $business_type)
                                        @php
                                            $color = $colors[$loop->iteration % count($colors)];
                                        @endphp
                                        <td class="px-6 py-4 border-r text-right"
                                            style="background-color: {{ $color }};">
                                            {{ isset($total_amount[$business_type->name]) && $total_amount[$business_type->name]['total_cash_in'] > 0 ? number_format($total_amount[$business_type->name]['total_cash_in']) : '-' }}
                                        </td>

                                        <td class="px-6 py-4 border-r text-right"
                                            style="background-color: {{ $color }};">
                                            {{ isset($total_amount[$business_type->name]) && $total_amount[$business_type->name]['total_cash_out'] > 0 ? number_format($total_amount[$business_type->name]['total_cash_out']) : '-' }}
                                        </td>
                                    @empty
                                    @endforelse

                                </tr>

                                <tr>
                                    <td class="text-left px-6 py-4 border whitespace-nowrap"
                                        colspan="{{ count($business_types) * 2 + 3 }}">
                                    </td>
                                </tr>
                            @empty
                            @endforelse
                        </tbody>
                    </table>
                </div>
    </section>
@endsection
@section('script')


@endsection