@extends('layouts.master-without-nav')
@section('title', 'Select Income & Expense')

@section('content')
    <section class="select-income-expense">
        @include('layouts.header-section', [
            'title' => 'Profit and Loss',
            'subTitle' => 'Select Income & Expense',
        ])

        <form action="{{ route('profit-and-loss-store-pl-format') }}" method="POST" id="submitForm">
            @csrf
            <div class="w-full font-jakarta flex items-center justify-center">
                <div>
                    <div class="animate__animated animate__zoomIn mb-5 p-5">
                        <h1 class="text-center font-semibold text-2xl">Select Profit & Loss Format</h1>

                    </div>
                </div>
            </div>

            <div class="font-jakarta flex items-center justify-center mt-1">
                <div>
                    <div class="bg-white animate__animated animate__zoomIn mb-5 p-10 shadow-xl rounded-[20px]">

                        <!-- Revenue -->
                        <h1 class="text-center font-semibold text-xl text-md mb-1">1. Revenue</h1>

                        <div class="text-left font-medium text-primary text-md text-md mb-2">Add :</div>
                        <div class="mb-2 xl:col-span-3">
                            <select name="revenue_add[]" class="w-full select2" multiple required>
                                <option value="sale" selected>Sale</option>
                            </select>
                        </div>

                        <div class="text-left font-medium text-red-600 text-md text-md mb-1">Less :</div>
                        <div class="mb-2 xl:col-span-3">
                            <select name="revenue_less[]" class="w-full select2" style="background-color: red !important;"
                                multiple required>
                                <option value="sale_return" selected>Sale Return</option>
                                <option value="sale_discount">Sale Discount</option>
                            </select>
                        </div>

                        <!-- Less of Good Sale -->
                        <h1 class="text-center font-semibold text-xl text-md mb-1 mt-5">2. Cost of Goods Sold</h1>

                        <div class="text-left font-medium text-primary text-md text-md mb-2">Add :</div>
                        <div class="mb-2 xl:col-span-3">
                            <select name="COGS_add[]" class="w-full select2" multiple required>
                                <option value="purchase" selected>Purchase</option>
                                <option value="open_stock">Opening Stock</option>
                            </select>
                        </div>

                        <div class="text-left font-medium text-red-600 text-md text-md mb-1">Less :</div>
                        <div class="mb-2 xl:col-span-3">
                            <select name="COGS_less[]" class="w-full select2" style="background-color: red !important;"
                                multiple required>
                                <option value="purchase_return" selected>Purchase Return</option>
                                <option value="close_stock">Closing Stock</option>
                            </select>
                        </div>

                        <!-- Other Incomes -->
                        <h1 class="text-center font-semibold text-xl text-md mb-1 mt-5">3. Other Incomes</h1>

                        <div class="text-left font-medium text-primary text-md text-md mb-2">Add :</div>
                        <div class="mb-2 xl:col-span-3">
                            <select name="other_incomes[]" class="w-full select2" multiple>
                                @foreach ($incomeAccounts as $incomeAccount)
                                    <option value="{{ $incomeAccount->id }}"
                                        {{ in_array($incomeAccount->name, $selectedOtherIncomes) ? 'selected' : '' }}>
                                        {{ $incomeAccount->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Expenses -->
                        <h1 class="text-center font-semibold text-xl text-md mb-1 mt-5">4. Expenses</h1>

                        <div class="text-left font-medium text-red-600 text-md text-md mb-1">Less :</div>
                        <div class="mb-2 xl:col-span-3">
                            <select name="expenses[]" class="w-full select2" multiple>
                                @foreach ($expenseAccounts as $expenseAccount)
                                    <option value="{{ $expenseAccount->id }}"
                                        {{ in_array($expenseAccount->name, $selectedExpenses) ? 'selected' : '' }}>
                                        {{ $expenseAccount->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Buttons -->
                        <div
                            class="flex flex-col md:items-center text-center md:text-left md:flex-row mt-10 md:justify-center gap-10">
                            <a href="{{ route('pl-list') }}">
                                <button type="button"
                                    class="outline outline-1 text-noti text-sm outline-noti w-full md:w-44 py-2 rounded-2xl">Back</button>
                            </a>
                            @if (DB::table('pl_format')->count() == 0)
                                <button type="submit"
                                    class="text-sm bg-primary outline mx-auto md:mx-0 text-white outline-1 w-full md:w-44 py-2 rounded-2xl"
                                    id="submitButton">Create</button>
                            @else
                                <button type="submit"
                                    class="text-sm bg-primary outline mx-auto md:mx-0 text-white outline-1 w-full md:w-44 py-2 rounded-2xl"
                                    id="submitButton">Update</button>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </section>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            $('.select2').select2();

            $('#income_select, #expense_select').change(function() {
                var selected = $(this).val();
                if (selected.includes('select_all')) {
                    $(this).find('option').prop('selected', true);
                    $(this).find('option[value="select_all"]').prop('selected', false);
                    $(this).trigger('change');
                }
            });
        });
    </script>
@endsection
