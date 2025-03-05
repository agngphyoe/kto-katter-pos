@extends('layouts.master-without-nav')
@section('title', 'Profit and Loss Statement')

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
                'title' => 'Profit and Loss Statement',
                'subTitle' => 'The statement of profit and loss',
            ])

            <div class="mt-10 mx-5 xl:mx-10">
                <div class="bg-white rounded-[20px] p-6">
                    <div class="text-center mb-4">
                        <p class="font-jakarta text-md text-gray-600">
                            From: <span class="font-semibold">{{ request('start_date') }}</span>
                            To: <span class="font-semibold">{{ request('end_date') }}</span>
                        </p>
                    </div>

                    <h1 class="text-noti font-jakarta text-xl font-semibold mb-4 text-center">STATEMENT OF PROFIT OR LOSS AND
                        COMPREHENSIVE INCOME</h1>
                    <form action="{{ route('profit-and-loss-save-and-export') }}" method="POST" id="submitForm">
                        @csrf
                        <input type="hidden" name="sale" value="{{ $sale ?? 0 }}">
                        <input type="hidden" name="sale_return" value="{{ $sale_return ?? 0 }}">
                        <input type="hidden" name="total_sales" value="{{ $total_sales ?? 0 }}">
                        <input type="hidden" name="start_price" value="{{ $start_price ?? 0 }}">
                        <input type="hidden" name="end_price" value="{{ $end_price ?? 0 }}">
                        <input type="hidden" name="purchase_amount" value="{{ $purchase_amount ?? 0 }}">
                        <input type="hidden" name="purchase_return_amount" value="{{ $purchase_return_amount ?? 0 }}">
                        <input type="hidden" name="total_cost_of_sales" value="{{ $total_cost_of_sales ?? 0 }}">
                        <input type="hidden" name="gross_profit_on_sales" value="{{ $gross_profit_on_sales ?? 0 }}">
                        <input type="hidden" name="incomes" value="{{ json_encode($incomes ?? []) }}">
                        <input type="hidden" name="total_other_income" value="{{ $total_other_income ?? 0 }}">
                        <input type="hidden" name="total_gross_profit" value="{{ $total_gross_profit ?? 0 }}">
                        <input type="hidden" name="expenses" value="{{ json_encode($expenses ?? []) }}">
                        <input type="hidden" name="total_expenses" value="{{ $total_expenses ?? 0 }}">
                        <input type="hidden" name="net_profit_before_tax" value="{{ $net_profit_before_tax ?? 0 }}">
                        <input type="hidden" name="start_date" value="{{ request('start_date') }}">
                        <input type="hidden" name="end_date" value="{{ request('end_date') }}">

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
                                            {{ number_format($sale) }}</td>
                                    </tr>
                                    <tr class="border-b border-gray-300">
                                        <td class="px-6 py-4 w-1/2 border-r border-gray-300">Less: Sale Return</td>
                                        <td class="px-6 py-4 w-1/2 text-right border-l border-gray-300">
                                            {{ number_format($sale_return) }}</td>
                                    </tr>
                                    <tr class="bg-blue font-extrabold border-b border-gray-300 text-black">
                                        <td class="px-6 py-4 w-1/2">Total Sales</td>
                                        <td class="px-6 py-4 w-1/2 text-right">{{ number_format($total_sales) }}</td>
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
                                            {{ number_format($start_price) }}</td>
                                    </tr>
                                    <tr class="border-b border-gray-300">
                                        <td class="px-6 py-4 w-1/2 border-r border-gray-300">Purchase</td>
                                        <td class="px-6 py-4 w-1/2 text-right border-l border-gray-300">
                                            {{ number_format($purchase_amount) }}</td>
                                    </tr>
                                    <tr class="border-b border-gray-300">
                                        <td class="px-6 py-4 w-1/2 border-r border-gray-300">Less: Purchase Return</td>
                                        <td class="px-6 py-4 w-1/2 text-right border-l border-gray-300">
                                            {{ number_format($purchase_return_amount) }}</td>
                                    </tr>
                                    <tr class="border-b border-gray-300">
                                        <td class="px-6 py-4 w-1/2 border-r border-gray-300">Less: Closing Stock</td>
                                        <td class="px-6 py-4 w-1/2 text-right border-l border-gray-300">
                                            {{ number_format($end_price) }}</td>
                                    </tr>
                                    <tr class="bg-blue font-extrabold border-b border-gray-300 text-black">
                                        <td class="px-6 py-4 w-1/2">Total Cost of Sales</td>
                                        <td class="px-6 py-4 w-1/2 text-right">{{ number_format($total_cost_of_sales) }}
                                        </td>
                                    </tr>
                                    <tr class="bg-primary font-extrabold border-b border-gray-300 text-black">
                                        <td class="px-6 py-4 w-1/2">Gross Profit on Sales</td>
                                        <td class="px-6 py-4 w-1/2 text-right">{{ number_format($gross_profit_on_sales) }}
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
                                    @foreach ($incomes as $income)
                                        <tr class="border-b border-gray-300">
                                            <td class="px-6 py-4 w-1/2 border-r border-gray-300">{{ $income->name }}</td>
                                            <td class="px-6 py-4 w-1/2 text-right border-l border-gray-300">
                                                {{ number_format($income->amount) }}</td>
                                        </tr>
                                    @endforeach
                                    <tr class="bg-blue font-extrabold border-b border-gray-300 text-black">
                                        <td class="px-6 py-4 w-1/2">Total Other Income</td>
                                        <td class="px-6 py-4 w-1/2 text-right">{{ number_format($total_other_income) }}
                                        </td>
                                    </tr>
                                    <tr class="bg-primary font-extrabold border-b border-gray-300 text-black">
                                        <td class="px-6 py-4 w-1/2">Total Gross Profit</td>
                                        <td class="px-6 py-4 w-1/2 text-right">{{ number_format($total_gross_profit) }}
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
                                        <th class="px-6 py-4 w-1/2 border-r border-gray-300 font-extrabold">4. Less:
                                            Expenses</th>
                                        <th class="px-6 py-4 w-1/2 border-l border-gray-300"></th>
                                    </tr>
                                </thead>
                                <tbody class="font-normal font-poppins text-sm">
                                    @foreach ($expenses as $expense)
                                        <tr class="border-b border-gray-300">
                                            <td class="px-6 py-4 w-1/2 border-r border-gray-300">{{ $expense->name }}</td>
                                            <td class="px-6 py-4 w-1/2 text-right border-l border-gray-300">
                                                {{ number_format($expense->amount) }}</td>
                                        </tr>
                                    @endforeach
                                    <tr class="bg-blue font-extrabold border-b border-gray-300 text-black">
                                        <td class="px-6 py-4 w-1/2">Total Expenses</td>
                                        <td class="px-6 py-4 w-1/2 text-right">{{ number_format($total_expenses) }}</td>
                                    </tr>
                                    <tr class="bg-primary font-semibold border-b border-dashed border-gray-300 text-left text-black"
                                        style="border-color: black;">
                                        <td class="px-6 py-4 w-1/2">Net Profit Before Tax</td>
                                        <td class="px-6 py-4 w-1/2 text-right">{{ number_format($net_profit_before_tax) }}
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            {{-- End Expenses --}}
                        </div>

                        <div
                            class="flex flex-col md:items-center text-center md:text-left md:flex-row mt-10 md:justify-center gap-10">
                            <a href="{{ route('profit-and-loss-choose-month') }}">
                                <button type="button"
                                    class="outline outline-1 text-noti text-md font-medium  outline-noti w-full md:w-44 py-2 rounded-full">Back</button>
                            </a>
                            <button
                                class="text-md bg-primary outline mx-auto md:mx-0 font-medium text-white outline-1 w-full outline-primary md:w-44 py-2 rounded-full"
                                type="submit" id="submitButton">
                                Save
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('script')
    <script src="{{ asset('js/Nav.js') }}"></script>
@endsection
