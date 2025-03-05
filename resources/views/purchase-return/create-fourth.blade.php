@extends('layouts.master-without-nav')
@section('title', 'Purchase Return Create')
@section('css')

@endsection
@section('content')
    <section class="purchase__return__create__final">
        {{-- nav start  --}}
        @include('layouts.header-section', [
            'title' => 'Create A New Purchase Return',
            'subTitle' => 'Choose the Products ',
        ])
        {{-- nav end  --}}

        {{-- ...............  --}}
        {{-- main start  --}}
        <div class="m-5">
            <form id="myForm" action="{{ route('purchase-return-create-final') }}">
                @csrf

                <input type="hidden" name="purchase_return_products" id="purchase_return_products">
                <input value="{{ $purchase->id }}" name="purchase_id" hidden>

                <div class="flex items-center justify-center">
                    <div class="bg-white p-7 rounded-[20px] w-full ">
                        <div class="md:flex md:items-center md:justify-between md:gap-3 mb-2 md:mb-0">
                            <div class="flex flex-col mb-2 md:mb-0">
                                <label for=""
                                    class="text-paraColor text-sm font-semibold font-jakarta mb-2">Remarks</label>
                                <textarea name="purchase_return_remark" id="" placeholder="Remarks" cols="20" rows="1"
                                    class="outline md:w-[450px] font-jakarta text-sm outline-1 px-5 py-2 outline-primary rounded" required></textarea>
                            </div>
                            <div class="flex flex-col">
                                <label for=""
                                    class="text-paraColor text-sm font-semibold font-jakarta mb-2">Date</label>
                                <input type="text" name="purchase_return_date" placeholder="07/15/2023" id=""
                                    class="outline outline-1 outline-primary py-2 px-5 rounded">
                            </div>
                        </div>

                    </div>
                </div>



                {{-- table start --}}
                <div class="data-table mt-5 mb-5">
                    <div class="  bg-white px-4 py-2 font-poppins rounded-[20px]  ">

                        <div>
                            <div class="relative overflow-x-auto shadow-lg overflow-y-auto h-[250px] mt-3">
                                <table class="w-full text-sm  text-gray-500 ">
                                    <thead class="   border-b text-primary bg-gray-50 font-jakarta  ">
                                        {{-- <x-table-head-component :columns="[
                                            'Product Name',
                                            'Unit Buying Price',
                                            'Total Buying Price',
                                            'Available Quantity',
                                            'Action',
                                            // 'Total Wholesale Selling Price',
                                            // 'Total Retail Selling Price',
                                        ]" /> --}}
                                        <tr class="text-left border-b">
                                            <th
                                                class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-left">
                                                Product Name
                                            </th>
                                            <th
                                                class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-right">
                                                Unit Buying Price
                                            </th>
                                            <th
                                                class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-right">
                                                Total Buying Price
                                            </th>
                                            <th
                                                class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-center">
                                                Available Quantity
                                            </th>
                                            <th
                                                class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-center">
                                                Action
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody id="productTableBody">

                                    </tbody>
                                </table>
                            </div>

                        </div>


                    </div>
                </div>
                {{-- table end  --}}

                <div class="flex items-center justify-center gap-10">
                    <a onclick="goBack()">
                        <x-button-component class="outline outline-1 outline-noti text-noti" type="button">
                            Back
                        </x-button-component>
                    </a>
                    <x-button-component class="bg-noti text-white" type="submit" id="done">
                        Next
                    </x-button-component>
                </div>
        </div>
        </form>
        {{-- main end --}}

    </section>
@endsection
@section('script')
    <script src="{{ asset('js/HandleLocalStorage.js') }}"></script>

    <script>
        $(function() {
            $('input[name="purchase_return_date"]').daterangepicker({
                singleDatePicker: true,
                showDropdowns: true,
                minYear: 1901,
                maxYear: parseInt(moment().format('YYYY'), 10)
            }, function(start, end, label) {
                var years = moment().diff(start, 'years');

            });
        });
    </script>
    <script>
        $(document).ready(function() {});
    </script>
    <script>
        populateInputValues();

        // display product list
        function populateInputValues() {
            const productsArray = getStoredProducts('purchaseReturnProducts');
            const tableBody = document.getElementById("productTableBody");
            tableBody.innerHTML = '';

            productsArray.forEach(product => {

                const totalAmountValue = product.new_amount > 0 ? product.new_amount : '';

                var tableRow = displayPurchaseReturnProductList(product);

                tableRow +=
                    `
            <input id="buy_price_input${product.id}" value="${product.buy_price}"  hidden />
            <input id="wholesale_sell_price_input${product.id}" value="${product.wholesale_sell_price}" hidden/>
            <input id="retail_sell_price_input${product.id}" value="${product.retail_sell_price}" hidden/>`;

                tableBody.innerHTML += tableRow;

            });

            const doneButton = document.getElementById("done");

            if (doneButton) {

                doneButton.disabled = productsArray.length <= 0;
            }
        }

        document.addEventListener('input', function (event) {
            // Check if the event target is the input with the class "newQuantity"
            if (event.target.classList.contains('newQuantity')) {
                const productId = event.target.id.replace('returned_quantity', ''); // Extract product ID
                const quantity = parseInt(event.target.value); // Get the entered value as a number
                
                // Ensure the quantity is valid before saving to local storage
                if (!isNaN(quantity) && quantity >= 1) {
                    localStorage.setItem(`productCount_${productId}`, quantity);
                }
            }
        });

        //handle quanity input
        const quantityInputs = document.querySelectorAll('input.newQuantity');

        quantityInputs.forEach(input => {

            input.addEventListener("input", (event) => {

                const productId = event.target.id.replace(/returned_quantity/, "");
                // console.log(productId);
                const value = event.target.value.trim();
                let productsArray = getStoredProducts('purchaseReturnProducts');
                // console.log(productsArray);
                const productIndex = productsArray.findIndex(
                    (item) => item.id === parseInt(productId)
                );
                // console.log(productIndex);
                if (productIndex !== -1) {
                    productsArray[productIndex].returned_quantity = parseInt(value);
                }
                setStoredProducts('purchaseReturnProducts', productsArray);
                // addValueHiddenFields(hiddenInput, productsArray);
                const elementId = document.getElementById('purchase_return_products');

                elementId.value = JSON.stringify(productsArray);

                // calculate Total Selling Price and Total Buying Price
                // calculateTotalBuySellPrice(event);
                // checkQuantityInputBox(event);

            });
        });

        // protect the max value with sold quantity
        function checkQuantityInputBox(event) {
            const productId = event.target.id.replace("newQuantity", "");
            const quantity = event.target.value.trim();

            let productsArray = JSON.parse(localStorage.getItem('purchaseReturnProducts'));
            const productIndex = productsArray.findIndex(
                (item) => item.id === parseInt(productId)
            );
            const purchased_quantity = productsArray[productIndex]['action_quantity'];
            if (quantity > purchased_quantity) {
                // The entered quantity exceeds the purchased_quantity, show the default error message
                event.target.setCustomValidity(`The maximum allowed quantity is ${purchased_quantity}.`);
            } else {
                // The entered quantity is valid, clear any previous error message
                event.target.setCustomValidity('');
            }

        }

        // calculate Total Selling Price and Total Buying Price
        function calculateTotalBuySellPrice(event) {
            const productId = event.target.id.replace("newQuantity", "");
            const quantity = event.target.value.trim();
            let productsArray = JSON.parse(localStorage.getItem('purchaseReturnProducts'));
            // finding existing product index
            const productIndex = productsArray.findIndex(
                (item) => item.id === parseInt(productId)
            );
            let buy_price_element = document.getElementById('buy_price_input' + productId);
            let wholesale_sell_price_element = document.getElementById('wholesale_sell_price_input' + productId);
            let retail_sell_price_element = document.getElementById('retail_sell_price_input' + productId);

            let buy_price = buy_price_element.value;
            let wholesale_sell_price = wholesale_sell_price_element.value;
            let retail_sell_price = retail_sell_price_element.value;

            let total_buy_price = buy_price * quantity;
            let total_wholesale_sell_price = wholesale_sell_price * quantity;
            let total_retail_sell_price = retail_sell_price * quantity;


            document.getElementById('buy_price' + productId).textContent = Number(total_buy_price).toLocaleString();
            document.getElementById('sell_wholesale_price' + productId).textContent = Number(total_wholesale_sell_price)
                .toLocaleString();
            document.getElementById('sell_retail_price' + productId).textContent = Number(total_retail_sell_price)
                .toLocaleString();
        }

        // delete
        function confirmDelete(productId) {
            deleteProduct('purchaseReturnProducts', productId);
        }
    </script>
    <script>
        function goBack() {
            history.back();
        }
    </script>
@endsection
