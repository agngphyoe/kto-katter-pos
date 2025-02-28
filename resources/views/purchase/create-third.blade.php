@extends('layouts.master-without-nav')
@section('title', 'Create Purchase')
@section('css')

@endsection
@section('content')
    <section class="create-third">
        {{-- nav start  --}}
        @include('layouts.header-section', [
            'title' => 'Create A New Purchase',
            'subTitle' => 'Fill to create a new purchase',
        ])
        {{-- nav end  --}}

        {{-- ............  --}}

        {{-- progress bar start  --}}
        <div class="lg:mx-[30px] mx-[10px] my-[10px] lg:my-[20px]">
            <div class="flex items-center block md:hidden justify-between gap-3 ">
                <div class="flex items-center gap-3 w-full">
                    <div class="w-12 h-12 flex shrink-0 items-center justify-center mb-3 bg-primary  rounded-full">
                        <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 448 512">
                            <path
                                d="M438.6 105.4c12.5 12.5 12.5 32.8 0 45.3l-256 256c-12.5 12.5-32.8 12.5-45.3 0l-128-128c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0L160 338.7 393.4 105.4c12.5-12.5 32.8-12.5 45.3 0z"
                                fill="#FFFFFF" />
                        </svg>
                    </div>
                    <div class="w-full h-[2px] flex-glow bg-primary "></div>
                </div>
                <div class="flex items-center gap-2 w-full">
                    <div class="w-12 h-12 flex shrink-0  items-center justify-center mb-3 bg-primary  rounded-full">
                        <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 448 512">
                            <path
                                d="M438.6 105.4c12.5 12.5 12.5 32.8 0 45.3l-256 256c-12.5 12.5-32.8 12.5-45.3 0l-128-128c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0L160 338.7 393.4 105.4c12.5-12.5 32.8-12.5 45.3 0z"
                                fill="#FFFFFF" />
                        </svg>
                    </div>
                    <div class="w-full h-[2px] flex-glow bg-primary "></div>
                </div>
                <div class="flex items-center gap-3">
                    <div
                        class="w-12 h-12 flex opacity-50 items-center justify-center mb-3 text-primary outline outline-1 outline-primary rounded-full">
                        3
                    </div>

                </div>

            </div>
            <div class="flex items-center block font-jakarta md:hidden justify-between gap-3 ">
                <div>
                    <h1 class="text-primary font-semibold mb-1 text-sm">Supplier</h1>
                    <h1 class="text-paraColor text-sm text-xs">Supplier Information</h1>
                </div>
                <div>
                    <h1 class="text-primary font-semibold  mb-1 ml-14 text-sm text-center">Product</h1>
                    <h1 class="text-paraColor text-xs ml-14 text-center">Products details to be ordered</h1>
                </div>
                <div>
                    <h1 class="text-primary font-semibold mb-1 text-sm text-right opacity-50">payment</h1>
                    <h1 class="text-paraColor text-xs text-right">The final steps to be purchased</h1>
                </div>

            </div>
        </div>
        {{-- progress bar end --}}

        {{-- main start  --}}
        <div class="">
            <div
                class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 md:gap-10 lg:mx-[30px] mx-[20px] my-[20px] lg:my-[20px]">
                {{-- payment start  --}}
                <div class="md:col-span-1 lg:col-span-3 mb-5 flex items-center justify-center">

                    <form id="submitForm" action="{{ route('purchase-create-final') }}" method="POST">
                        @csrf
                        <input type="hidden" value="{{ $supplier_id }}" name="supplier_id">
                        <input type="hidden" value="{{ $currency_type }}" name="currency_type">
                        <input type="hidden" value="{{ $currency_value }}" name="currency_value">
                        <input type="hidden" name="products" value="{{ $products }}">

                        <div class="w-[360px]">
                            <div class="bg-white h-[800px] outline outline-1 outline-primary  relative  rounded-[20px]">
                                <div>
                                    <h1 class="font-jakarta font-semibold text-noti text-center p-2">Payment</h1>
                                </div>
                                <div class="flex items-center absolute -left-2 -right-2  ">
                                    <div
                                        class="w-4 h-4 bg-bgMain rounded-full border-r-2 border-r-primary border-t-primary">
                                    </div>
                                    <div class=" outline-1 outline-dashed  text-paraColor opacity-50 w-full"></div>
                                    <div class="w-4 h-4 bg-bgMain rounded-full border border-l-primary"></div>

                                </div>
                                <div class="px-5 py-8 font-poppins">
                                    <div>

                                        {{-- Purchase Type --}}
                                        <div class="flex flex-col mb-4">
                                            <label for="" class="mb-2 text-paraColor text-sm font-semibold">Purchase
                                                Type <span class="text-red-600">*</span> </label>
                                            <select name="action_type" id="purchaseType" class="w-full select2" required>
                                                <option value="" disabled selected>Select...</option>
                                                @forelse($purchase_types as $key=>$purchase_type)
                                                    <option value="{{ $key }}"
                                                        {{ old('action_type') == $key ? 'selected' : '' }}>
                                                        {{ $purchase_type }}
                                                    </option>
                                                @empty
                                                @endforelse
                                            </select>
                                            @error('action_type')
                                                <p class="text-red-600 text-xs mt-1">* {{ $message }}</p>
                                            @enderror
                                        </div>

                                        {{-- Payment Type --}}
                                        <div class="flex flex-col mb-4">
                                            <label for="" class="mb-2 text-paraColor text-sm font-semibold">Payment
                                                Type <span class="text-red-600">*</span> </label>
                                            <select name="payment_type" id="paymentType" class="w-full select2" required>
                                                <option value="" disabled selected>Select...</option>
                                                @forelse($payment_types as $key=>$payment_type)
                                                    <option value="{{ $payment_type->id }}">
                                                        {{ $payment_type->bank_name }}
                                                    </option>
                                                @empty
                                                @endforelse
                                            </select>
                                            @error('payment_type')
                                                <p class="text-red-600 text-xs mt-1">* {{ $message }}</p>
                                            @enderror
                                        </div>

                                        {{-- Discount Input --}}
                                        <div class="flex flex-col mb-4">
                                            <label for="" class="mb-2 text-paraColor font-semibold text-sm "
                                                id="labelAmount">Discount Amount</label>
                                            <input type="number" name="discount_amount" id="discount_amount"
                                                placeholder="Discount"
                                                class="outline outline-1 text-sm font-jakarta text-paraColor w-full  text-[16px] outline-primary px-8 py-2 rounded-full"
                                                min="0" max="" value="{{ old('discount') }}">
                                            @error('discount')
                                                <p class="text-red-600 text-xs mt-1">* {{ $message }}</p>
                                            @enderror
                                        </div>

                                        {{-- Purchase Date Input --}}
                                        <div class="flex flex-col mt-0 mb-2">
                                            <label for=""
                                                class="mb-2 text-paraColor font-semibold text-sm ">Purchase Date <span
                                                    class="text-red-600">*</span></label>
                                            <input type="text" name="action_date" value="10/24/1984"
                                                class="outline outline-1 text-sm font-jakarta text-paraColor w-full text-[16px] outline-primary px-8 py-2 rounded-full"
                                                required />
                                            @error('action_date')
                                                <p class="text-red-600 text-xs mt-1">* {{ $message }}</p>
                                            @enderror
                                        </div>

                                        {{-- Due Date Input --}}
                                        <div class="flex flex-col mt-0 mb-2 credit">
                                            <label for="" class="mb-2 text-paraColor font-semibold text-sm ">Due
                                                Date <span class="text-red-600">*</span></label>
                                            <input type="text" name="due_date" value="10/24/1984"
                                                class="outline outline-1 text-sm font-jakarta text-paraColor w-full  text-[16px] outline-primary px-8 py-2 rounded-full" />
                                            @error('due_date')
                                                <p class="text-red-600 text-xs mt-1">* {{ $message }}</p>
                                            @enderror
                                        </div>

                                        {{-- Cash Down Input --}}
                                        <div class="flex flex-col mt-0 mb-2 credit">
                                            <label for="" class="mb-2 text-paraColor font-semibold text-sm ">Cash
                                                Down <span class="text-red-600">*</span></label>
                                            <input type="number" name="cash_down" value="{{ old('cash_down') }}"
                                                class="outline outline-1 text-sm font-jakarta text-paraColor w-full  text-[16px] outline-primary px-8 py-2 rounded-full"
                                                id="cash_down_input" min="0" />
                                            {{-- @if (session('error')) --}}
                                            <div class="text-red-600 text-sm mt-2 ml-1 hidden" id="cashdownErrorMsg">
                                                Cash Down Amount is Required !
                                            </div>
                                            {{-- @endif --}}
                                        </div>
                                    </div>

                                    <div class="bottom-7  right-5 left-5 absolute">
                                        {{-- <div class="border border-2 border-dashed my-20"></div> --}}

                                        {{-- total quantity --}}
                                        <div class="flex items-center justify-between mb-5 text-sm">
                                            <h1 class="text-noti font-medium">Total Quantity</h1>
                                            <h1 class="text-paraColor font-medium" id="totalQuantity"></h1>
                                            <input type="hidden" name="total_quantity" id="totalQuantityInput">
                                        </div>

                                        {{-- Total Retail Selling Price --}}
                                        {{-- <div class="flex items-center justify-between mb-5 text-sm"> --}}
                                        {{-- <h1 class="text-noti font-medium ">Total Retail Amount</h1>
                                        <h1 class="text-paraColor font-medium"><span id="totalRetailPrice"></span></h1> --}}
                                        <input type="hidden" name="total_selling_amount" id="totalRetailInput">
                                        {{-- </div> --}}

                                        {{-- Total Selling Price --}}
                                        {{-- <div class="flex items-center justify-between mb-5 text-sm">
                                        <h1 class="text-noti font-medium ">Total Wholesale Amount</h1>
                                        <h1 class="text-paraColor font-medium"><span id="totalWholesalePrice"></span></h1> --}}
                                        <input type="hidden" name="total_wholesale_amount" id="totalWholesaleInput">
                                        {{-- </div> --}}

                                        {{-- Total Buying Price --}}
                                        <div class="flex items-center justify-between mb-5 text-sm">
                                            <h1 class="text-noti font-medium ">Total Buying Amount</h1>
                                            <h1 class="text-paraColor font-medium"><span id="totalBuyingPrice"></span>
                                            </h1>
                                            <input type="hidden" name="total_amount" id="totalBuyingInput">
                                        </div>

                                        {{-- Discount Amount  --}}
                                        <div class="flex items-center justify-between mb-5 text-sm">
                                            <h1 class="text-noti font-medium ">Discount Amount</h1>
                                            <h1 class="text-paraColor font-medium"><span
                                                    id="discount_amount_label">0</span>
                                            </h1>
                                        </div>

                                        {{-- Cashdown Amount  --}}
                                        <div class="flex items-center justify-between mb-5 text-sm" id="cash_down">
                                            <h1 class="text-noti font-medium">Cashdown Amount</h1>
                                            <h1 class="text-paraColor font-medium"><span
                                                    id="cash_down_amount_label">0</span>
                                            </h1>
                                        </div>

                                        {{-- Balance Amount  --}}
                                        <div class="flex items-center justify-between mb-5 text-sm">
                                            <h1 class="text-noti font-medium ">Net Amount</h1>
                                            <h1 class="text-paraColor font-medium"><span id="net_amount"></span>
                                            </h1>
                                        </div>

                                        <div class="text-center">
                                            <button id="submitButton"
                                                class="bg-noti text-white rounded-full w-52 text-lg font-semibold py-2"
                                                type="submit" id="done">Next</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </form>
                </div>
                {{-- payment end --}}


                {{-- progress start  --}}
                <div class="col-span-1 font-jakarta hidden md:block lg:col-span-1">
                    <div class="flex justify-between">
                        <div>
                            <h1 class="text-primary font-semibold mb-1">Supplier</h1>
                            <h1 class="text-paraColor text-sm">Supplier Information</h1>
                        </div>
                        <div class="">
                            <div class="w-12 h-12 flex items-center justify-center mb-3 bg-primary  rounded-full">
                                <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 448 512">
                                    <path
                                        d="M438.6 105.4c12.5 12.5 12.5 32.8 0 45.3l-256 256c-12.5 12.5-32.8 12.5-45.3 0l-128-128c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0L160 338.7 393.4 105.4c12.5-12.5 32.8-12.5 45.3 0z"
                                        fill="#FFFFFF" />
                                </svg>
                            </div>
                            <div class="w-[2px] h-36 bg-primary mx-auto"></div>
                        </div>
                    </div>
                    <div class="flex justify-between my-3">
                        <div>
                            <h1 class="text-primary font-semibold mb-1 ">Product</h1>
                            <h1 class="text-paraColor text-sm">Products details to be ordered</h1>
                        </div>
                        <div class="">
                            <div class="w-12 h-12 flex items-center justify-center mb-3 bg-primary  rounded-full">
                                <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 448 512">
                                    <path
                                        d="M438.6 105.4c12.5 12.5 12.5 32.8 0 45.3l-256 256c-12.5 12.5-32.8 12.5-45.3 0l-128-128c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0L160 338.7 393.4 105.4c12.5-12.5 32.8-12.5 45.3 0z"
                                        fill="#FFFFFF" />
                                </svg>
                            </div>
                            <div class="w-[2px] h-36 bg-primary mx-auto"></div>
                        </div>
                    </div>
                    <div class="flex justify-between">
                        <div>
                            <h1 class="text-primary font-semibold mb-1 opacity-50">Payment</h1>
                            <h1 class="text-paraColor text-sm">The final steps to be purchased</h1>
                        </div>
                        <div class="">
                            <div
                                class="w-12 h-12 flex items-center justify-center mb-3 outline opacity-50 outline-1 outline-primary rounded-full">
                                3</div>

                        </div>
                    </div>
                </div>
                {{-- progress end --}}

            </div>
        </div>
        {{-- main end --}}


    </section>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            handlePageLoading();
        });
    </script>

    <script>
        // Disable the button immediately after submitting the form
        document.getElementById('submitForm').addEventListener('submit', function(event) {
            event.preventDefault();

            const submitButton = document.getElementById('submitButton');
            submitButton.disabled = true;
            submitButton.innerHTML = "Processing...";
            submitButton.style.opacity = '0.5';

            this.submit();
        });
    </script>

    <script>
        $(function() {
            $('input[name="action_date"]').daterangepicker({
                singleDatePicker: true,
                showDropdowns: true,
                minYear: 2000,
                maxYear: new Date().getFullYear(),
                startDate: moment().format('MM/DD/YYYY')
            }, function(start, end, label) {});
        });

        $(function() {
            $('input[name="due_date"]').daterangepicker({
                singleDatePicker: true,
                showDropdowns: true,
                minYear: 2000,
                maxYear: new Date().getFullYear(),
                startDate: moment().format('MM/DD/YYYY')
            }, function(start, end, label) {
                $('#selectDueDate').text(start.format('MM/DD/YYYY'));
            });
        });

        $(document).ready(function() {
            var discountAmount = $('#discount_amount');
            var labelAmount = $('#labelAmount');

            var selectElement = document.getElementById('purchaseType');

            var items = JSON.parse(localStorage.getItem('productPurchaseCart')) || [];
            var totalBuyingPrice = 0;
            var totalQuantity = 0;
            var totalRetailPrice = 0;
            var totalWholesalePrice = 0;

            items.forEach(function(item) {
                totalQuantity += item.quantity;
                totalBuyingPrice += item.buying_price * item.quantity;
                totalRetailPrice += item.retail_price * item.quantity;
                totalWholesalePrice += item.wholesale_price * item.quantity;
            });


            $('#totalBuyingPrice').text(Number(totalBuyingPrice).toLocaleString());
            $('#totalBuyingInput').val(totalBuyingPrice);
            $('#net_amount').text(Number(totalBuyingPrice).toLocaleString());
            $('#net_amount').val(totalBuyingPrice);
            // $('#totalRetailPrice').text(Number(totalRetailPrice).toLocaleString());
            $('#totalRetailInput').val(totalRetailPrice);
            // $('#totalWholesalePrice').text(Number(totalWholesalePrice).toLocaleString());
            $('#totalWholesaleInput').val(totalWholesalePrice);
            $('#totalQuantity').text(Number(totalQuantity).toLocaleString());
            $('#totalQuantityInput').val(totalQuantity);

            discountAmount.attr('max', parseInt(totalBuyingPrice));


        });
    </script>

    <script>
        $('.credit').hide();
        $('#purchaseType').change(function() {

            var selectedValue = $(this).val();

            if (selectedValue === 'Credit') {
                $('.credit').show();
                $('#cash_down').show();
                $('#cash_down_input').val(localStorage.getItem('cash_down_amount'));
                $('#cash_down_input').attr('required', 'required');
            } else {
                $('.credit').hide();
                $('#cash_down').hide();
                $('#cash_down_input').val(0);
                $('cash_down_input').removeAttr('required');
            }

        });
    </script>
    <script>
        function handlePageLoading() {
            $('#net_amount').text(Number(localStorage.getItem('net_amount')).toLocaleString() ?? 0);
            $('#discount_amount_label').text(Number(localStorage.getItem('discount_amount')).toLocaleString() ?? 0);
            $('#cash_down_amount_label').text(Number(localStorage.getItem('cash_down_amount')).toLocaleString() ?? 0);
            $('#discount_amount').val(localStorage.getItem('discount_amount'));
            var selectedKey = localStorage.getItem('purchase_type');
            $('#purchaseType').val(selectedKey).trigger('change');
        }
    </script>
    <script>
        $('#discount_amount').on('input', function() {
            const total_buying_price = $('#totalBuyingInput').val();
            const discount_amount = $(this).val();
            const cash_down_amount = localStorage.getItem('cash_down_amount');
            $('#discount_amount_label').text(Number(discount_amount).toLocaleString());
            net_amount = total_buying_price - discount_amount - cash_down_amount;
            $('#net_amount').text(Number(net_amount).toLocaleString());
            localStorage.setItem('net_amount', net_amount);
            localStorage.setItem('discount_amount', discount_amount);
            $('#discount_amount').attr('max', parseInt(total_buying_price - cash_down_amount));
        })
    </script>

    <script>
        $('#cash_down_input').on('input', function() {
            const total_buying_price = $('#totalBuyingInput').val();
            const cash_down_amount = $(this).val();
            const discount_amount = localStorage.getItem('discount_amount');
            $('#cash_down_amount_label').text(Number(cash_down_amount).toLocaleString());
            net_amount = total_buying_price - cash_down_amount - discount_amount;
            $('#net_amount').text(Number(net_amount).toLocaleString());
            localStorage.setItem('net_amount', net_amount);
            localStorage.setItem('cash_down_amount', cash_down_amount);
            $('#cash_down_input').attr('max', parseInt(total_buying_price - discount_amount));
        })
    </script>

    <script>
        $('select[name="action_type"]').change(function() {
            var selectedOption = $(this).find(":selected");
            var selectedKey = selectedOption.val();
            localStorage.setItem('purchase_type', selectedKey);
        });
    </script>


@endsection
