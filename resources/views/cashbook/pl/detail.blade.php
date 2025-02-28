@extends('layouts.master-without-nav')
@section('title', 'Profit and Loss Details')

@section('css')
    <style>
        .bg-blue {
            background-color: #3b82f6;
        }
    </style>
@endsection

@section('content')
    <section class="profit-loss">
        <div>
            @include('layouts.header-section', [
                'title' => 'Profit and Loss Details',
                'subTitle' => 'Details for ' . $pl->profit_and_loss_number,
            ])

            <div class="mt-10 mx-5 xl:mx-10">
                <div class="bg-white rounded-[20px] p-6">
                    <!-- Date Range Display -->
                    <div class="text-center mb-4">
                        <p class="font-jakarta text-md text-gray-600">
                            From: <span class="font-semibold">{{ $pl->created_at->format('m/d/Y') }}</span>
                            To: <span class="font-semibold">{{ $pl->updated_at->format('m/d/Y') }}</span>
                        </p>
                    </div>

                    <h1 class="text-noti font-jakarta text-xl font-semibold mb-4 text-center">STATEMENT OF PROFIT OR LOSS AND
                        COMPREHENSIVE INCOME</h1>
                    <div class="overflow-x-auto">
                        {{-- Revenue --}}
                        <table class="w-full text-left border border-dashed border-collapse border-spacing-0"
                            style="border-color: black;">
                            <thead class="text-md sticky top-0 z-10 bg-gray-50 font-jakarta">
                                <tr class="border-b border-gray-300">
                                    <th class="px-6 py-4 w-1/2 border-r border-gray-300 font-extrabold">1. Revenue</th>
                                    <th class="px-6 py-4 w-1/2 border-l border-gray-300"></th>
                                </tr>
                            </thead>
                            <tbody class="font-normal font-poppins text-sm">
                                <tr class="border-b border-gray-300">
                                    <td class="px-6 py-4 w-1/2 border-r border-gray-300">Sales Income</td>
                                    <td class="px-6 py-4 w-1/2 text-right border-l border-gray-300">
                                        {{ number_format($pl->sale) }}</td>
                                </tr>
                                <tr class="border-b border-gray-300">
                                    <td class="px-6 py-4 w-1/2 border-r border-gray-300">Less: Sale Return</td>
                                    <td class="px-6 py-4 w-1/2 text-right border-l border-gray-300">
                                        {{ number_format($pl->sale_return) }}</td>
                                </tr>
                                <tr class="bg-blue font-extrabold border-b border-gray-300 text-black">
                                    <td class="px-6 py-4 w-1/2">Total Sales</td>
                                    <td class="px-6 py-4 w-1/2 text-right">{{ number_format($pl->total_sales) }}</td>
                                </tr>
                            </tbody>
                        </table>
                        {{-- End of Revenue --}}

                        {{-- Cost of Sales --}}
                        <table class="w-full text-left border border-dashed border-collapse border-spacing-0"
                            style="border-color: black;">
                            <thead class="text-md sticky top-0 z-10 bg-gray-50 font-jakarta">
                                <tr class="border-b border-gray-300">
                                    <th class="px-6 py-4 w-1/2 border-r border-gray-300 font-extrabold">2. Less: Cost of
                                        Sales</th>
                                    <th class="px-6 py-4 w-1/2 border-l border-gray-300"></th>
                                </tr>
                            </thead>
                            <tbody class="font-normal font-poppins text-sm">
                                <tr class="border-b border-gray-300">
                                    <td class="px-6 py-4 w-1/2 border-r border-gray-300">Opening Stock</td>
                                    <td class="px-6 py-4 w-1/2 text-right border-l border-gray-300">
                                        {{ number_format($pl->start_price) }}</td>
                                </tr>
                                <tr class="border-b border-gray-300">
                                    <td class="px-6 py-4 w-1/2 border-r border-gray-300">Purchase</td>
                                    <td class="px-6 py-4 w-1/2 text-right border-l border-gray-300">
                                        {{ number_format($pl->purchase_amount) }}</td>
                                </tr>
                                <tr class="border-b border-gray-300">
                                    <td class="px-6 py-4 w-1/2 border-r border-gray-300">Less: Purchase Return</td>
                                    <td class="px-6 py-4 w-1/2 text-right border-l border-gray-300">
                                        {{ number_format($pl->purchase_return_amount) }}</td>
                                </tr>
                                <tr class="border-b border-gray-300">
                                    <td class="px-6 py-4 w-1/2 border-r border-gray-300">Less: Closing Stock</td>
                                    <td class="px-6 py-4 w-1/2 text-right border-l border-gray-300">
                                        {{ number_format($pl->end_price) }}</td>
                                </tr>
                                <tr class="bg-blue font-extrabold border-b border-gray-300 text-black">
                                    <td class="px-6 py-4 w-1/2">Total Cost of Sales</td>
                                    <td class="px-6 py-4 w-1/2 text-right">{{ number_format($pl->total_cost_of_sales) }}
                                    </td>
                                </tr>
                                <tr class="bg-primary font-extrabold border-b border-gray-300 text-black">
                                    <td class="px-6 py-4 w-1/2">Gross Profit on Sales</td>
                                    <td class="px-6 py-4 w-1/2 text-right">{{ number_format($pl->gross_profit_on_sales) }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        {{-- End Cost of Sales --}}

                        {{-- Other Incomes --}}
                        <table class="w-full text-left border border-dashed border-collapse border-spacing-0"
                            style="border-color: black;">
                            <thead class="text-md sticky top-0 z-10 bg-gray-50 font-jakarta">
                                <tr class="border-b border-gray-300">
                                    <th class="px-6 py-4 w-1/2 border-r border-gray-300 font-extrabold">3. Add: Other
                                        Incomes</th>
                                    <th class="px-6 py-4 w-1/2 border-l border-gray-300"></th>
                                </tr>
                            </thead>
                            <tbody class="font-normal font-poppins text-sm">
                                @if (!empty($pl->incomes))
                                    @foreach ($pl->incomes as $income)
                                        <tr class="border-b border-gray-300">
                                            <td class="px-6 py-4 w-1/2 border-r border-gray-300">{{ $income['name'] }}</td>
                                            <td class="px-6 py-4 w-1/2 text-right border-l border-gray-300">
                                                {{ number_format($income['amount']) }}</td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td class="px-6 py-4 w-1/2 border-r border-gray-300">No Other Incomes</td>
                                        <td class="px-6 py-4 w-1/2 text-right border-l border-gray-300">0</td>
                                    </tr>
                                @endif
                                <tr class="bg-blue font-extrabold border-b border-gray-300 text-black">
                                    <td class="px-6 py-4 w-1/2">Total Other Income</td>
                                    <td class="px-6 py-4 w-1/2 text-right">{{ number_format($pl->total_other_income) }}
                                    </td>
                                </tr>
                                <tr class="bg-primary font-extrabold border-b border-gray-300 text-black">
                                    <td class="px-6 py-4 w-1/2">Total Gross Profit</td>
                                    <td class="px-6 py-4 w-1/2 text-right">{{ number_format($pl->total_gross_profit) }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        {{-- End Other Income --}}

                        {{-- Expenses --}}
                        <table class="w-full text-left border border-dashed border-collapse border-spacing-0"
                            style="border-color: black;">
                            <thead class="text-md sticky top-0 z-10 bg-gray-50 font-jakarta">
                                <tr class="border-b border-gray-300">
                                    <th class="px-6 py-4 w-1/2 border-r border-gray-300 font-extrabold">4. Less: Expenses
                                    </th>
                                    <th class="px-6 py-4 w-1/2 border-l border-gray-300"></th>
                                </tr>
                            </thead>
                            <tbody class="font-normal font-poppins text-sm">
                                @if (!empty($pl->expenses))
                                    @foreach ($pl->expenses as $expense)
                                        <tr class="border-b border-gray-300">
                                            <td class="px-6 py-4 w-1/2 border-r border-gray-300">{{ $expense['name'] }}
                                            </td>
                                            <td class="px-6 py-4 w-1/2 text-right border-l border-gray-300">
                                                {{ number_format($expense['amount']) }}</td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td class="px-6 py-4 w-1/2 border-r border-gray-300">No Expenses</td>
                                        <td class="px-6 py-4 w-1/2 text-right border-l border-gray-300">0</td>
                                    </tr>
                                @endif
                                <tr class="bg-blue font-extrabold border-b border-gray-300 text-black">
                                    <td class="px-6 py-4 w-1/2">Total Expenses</td>
                                    <td class="px-6 py-4 w-1/2 text-right">{{ number_format($pl->total_expenses) }}</td>
                                </tr>
                                <tr class="bg-primary font-semibold border-b border-dashed border-gray-300 text-left text-black"
                                    style="border-color: black;">
                                    <td class="px-6 py-4 w-1/2">Net Profit Before Tax</td>
                                    <td class="px-6 py-4 w-1/2 text-right">{{ number_format($pl->net_profit_before_tax) }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        {{-- End Expenses --}}
                    </div>
                </div>

                <div class="flex justify-center mt-5 mb-5 gap-5">
                    <a href="{{ route('pl-list') }}">
                        <button
                            class="text-noti outline outline-1 outline-noti mt-3 rounded-full text-sm font-semibold px-5 py-2 font-jakarta md:w-60">
                            Back
                        </button>
                    </a>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('script')
    <script src="{{ asset('js/Nav.js') }}"></script>
@endsection
