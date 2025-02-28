@extends('layouts.master-without-nav')
@section('title', 'Promotion Edit')
@section('css')

@endsection
@section('content')
    <section class="promotion__edit">
        {{-- nav start  --}}
        @include('layouts.header-section', [
            'title' => 'Edit Promotion',
            'subTitle' => '',
        ])
        {{-- nav end  --}}

        {{-- main start  --}}
        <div class=" lg:mx-[150px] mx-[10px] my-[10px] lg:my-[30px]">
            {{-- search start --}}
            <x-product-search search="" text="Promotion Products :" />

            {{-- search end  --}}
            <form id="myForm" action="{{ route('promotion-update', ['promotion' => $promotion->id]) }}" method="POST">
                @csrf
                @method('PUT')

                <input type="hidden" name="selected_products" id="selectedProducts" />

                {{-- table start  --}}
                <div class="bg-white shadow-xl rounded-[20px]  font-jakarta">
                    <div class="flex items-center justify-between px-8 py-3">


                        <div class="flex flex-col">
                            <x-input-field-component type="text" value="{{ $promotion->code }}" label="Promo Code"
                                name="code" id="promoCode" text="Code..." readonly />
                        </div>

                        <div class="flex flex-col">
                            <x-input-field-component type="text" value="{{ $promotion->name }}" label="Promo Name"
                                name="name" id="promoName" text="Name..." />
                        </div>
                        <div>
                            <label for="" class=" block mb-2 text-paraColor font-medium text-sm">Promo
                                Duration</label>
                            <div class="flex items-center outline outline-1 outline-primary rounded-full px-4 py-2">

                                <input type="text" name="daterange" class="outline-none w-[250px]" placeholder="From To"
                                    id="date_range_input" value="<?php echo $promotion->start_date . ' to ' . $promotion->end_date; ?>">
                                <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 448 512">
                                    <path
                                        d="M128 0c17.7 0 32 14.3 32 32V64H288V32c0-17.7 14.3-32 32-32s32 14.3 32 32V64h48c26.5 0 48 21.5 48 48v48H0V112C0 85.5 21.5 64 48 64H96V32c0-17.7 14.3-32 32-32zM0 192H448V464c0 26.5-21.5 48-48 48H48c-26.5 0-48-21.5-48-48V192zm64 80v32c0 8.8 7.2 16 16 16h32c8.8 0 16-7.2 16-16V272c0-8.8-7.2-16-16-16H80c-8.8 0-16 7.2-16 16zm128 0v32c0 8.8 7.2 16 16 16h32c8.8 0 16-7.2 16-16V272c0-8.8-7.2-16-16-16H208c-8.8 0-16 7.2-16 16zm144-16c-8.8 0-16 7.2-16 16v32c0 8.8 7.2 16 16 16h32c8.8 0 16-7.2 16-16V272c0-8.8-7.2-16-16-16H336zM64 400v32c0 8.8 7.2 16 16 16h32c8.8 0 16-7.2 16-16V400c0-8.8-7.2-16-16-16H80c-8.8 0-16 7.2-16 16zm144-16c-8.8 0-16 7.2-16 16v32c0 8.8 7.2 16 16 16h32c8.8 0 16-7.2 16-16V400c0-8.8-7.2-16-16-16H208zm112 16v32c0 8.8 7.2 16 16 16h32c8.8 0 16-7.2 16-16V400c0-8.8-7.2-16-16-16H336c-8.8 0-16 7.2-16 16z"
                                        fill="#00812C" />
                                </svg>
                            </div>
                        </div>
                    </div>

                    <div class="data-table ">
                        <div class="bg-white px-4 py-2 font-poppins rounded-[20px]  ">
                            <div>
                                <div class="relative overflow-y-auto  overflow-x-auto shadow-lg  ">
                                    <table class="w-full text-sm text-left text-gray-500 ">
                                        <thead class="bg-gray-50 font-jakarta text-primary text-center">
                                            {{-- <x-table-head-component :columns="[
                                            '',
                                            'Product Name',
                                            'Stock Quantity',
                                            'Price',
                                            'Promotion Qty/Amount',
                                            'New Amount',
                                        ]" /> --}}
                                            <tr class="text-left border-b">
                                                <th
                                                    class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-left">
                                                    Product Name
                                                </th>
                                                <th
                                                    class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-center">
                                                    Stock Quantity
                                                </th>
                                                <th
                                                    class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-right">
                                                    Price
                                                </th>
                                                <th
                                                    class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-right">
                                                    Promotion Qty/Amount
                                                </th>
                                                <th
                                                    class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-right">
                                                    New Amount
                                                </th>
                                            </tr>

                                        </thead>
                                        <tbody class="font-poppins" id="productTableBody">
                                            @forelse($promotion->promotionProducts as $product)
                                                <tr class="border-b text-left">
                                                    <td scope="row" class="px-6 py-4 accent-primary ">
                                                        <input type="checkbox" value="{{ $product->id }}"
                                                            class="w-4 h-5  focus:accent-primary"
                                                            data-product-id="{{ $product->id }}">
                                                    </td>
                                                    <td class="px-6 py-4 ">
                                                        <h1 class="text-paraColor"><span
                                                                id="name{{ $product->product?->id }}">{{ $product->product?->brand?->name }}</span>
                                                            <span class="text-noti"
                                                                id="code${product.id}">({{ $product->product?->code }})</span>
                                                        </h1>
                                                    </td>
                                                    <td class="pl-6 pr-10 py-4 text-center  ">
                                                        {{ number_format($product->product?->quantity) }}
                                                    </td>
                                                    <td class="pl-6 pr-12 py-4 text-right "
                                                        id="originalPrice{{ $product->product?->id }}">
                                                        {{ number_format($product->product?->price) }}
                                                    </td>

                                                    <td class="pl-6 pr-10 py-4 text-right  ">
                                                        <span
                                                            id="originalQuantity{{ $product->product?->id }}">{{ number_format($product->quantity) }}
                                                        </span>/ {{ number_format($product->price) }}
                                                    </td>

                                                    <td class="px-6 py-2 ">
                                                        <input type="number" id="newPrice{{ $product->product?->id }}"
                                                            min="1" max="{{ $product->product?->price }}"
                                                            class="promotionAmount outline-none px-4 py-2 bg-bgMain rounded-xl w-40" />
                                                    </td>
                                                </tr>
                                            @empty
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                {{-- table end --}}

                <div class="flex justify-center mt-5 gap-5">
                    <a href="{{ route('promotion') }}">
                        <x-button-component class="outline outline-1 outline-noti text-noti" type="button">
                            Back
                        </x-button-component>
                    </a>

                    <x-button-component class="bg-noti text-white " type="submit" id="done">
                        Done
                    </x-button-component>
                </div>
            </form>

        </div>

        {{-- main end --}}

    </section>
@endsection
@section('script')
    <script src="{{ asset('js/HandleLocalStorage.js') }}"></script>

    <script>
        $(function() {
            var dateRangeInput = $('input[name="daterange"]');
            var dateRangeValues = dateRangeInput.val().split(' to ');
            var startDate = moment(dateRangeValues[0], 'YYYY-MM-DD');
            var endDate = moment(dateRangeValues[1], 'YYYY-MM-DD');

            dateRangeInput.daterangepicker({
                opens: 'left',
                startDate: startDate,
                endDate: endDate,
            });


        });

        const checkboxes = document.querySelectorAll('input[type="checkbox"]');

        handlePageLoading();

        function handlePageLoading() {
            const products = getStoredProducts('promotionEditProducts');

            const productIds = products.map(product => product.id);

            checkboxes.forEach(checkbox => {
                const productId = parseInt(checkbox.dataset.productId);
                checkbox.checked = productIds.includes(productId);

                const quantityInput = document.getElementById('newQuantity' + productId);
                const amountInput = document.getElementById('newPrice' + productId);

                const product = products.find(product => product.id === productId);

                if (product) {

                    quantityInput.value = product.new_quantity;
                    amountInput.value = product.new_price;
                }
            });

            updateSelectedCount('promotionEditProducts')
        }


        checkboxes.forEach(checkbox => {

            checkbox.addEventListener('click', handleCheckboxClick);
        });

        function handleCheckboxClick(event) {
            const checkbox = event.target;
            var productId = checkbox.dataset.productId;
            var products = getStoredProducts('promotionEditProducts');

            const newQuantity = document.getElementById('newQuantity' + productId);
            const newPrice = document.getElementById('newPrice' + productId);
            const originaleQuantity = document.getElementById('originalQuantity' + productId);
            const originalePrice = document.getElementById('originalPrice' + productId);

            if (checkbox.checked) {

                newQuantity.setAttribute("required", "true");
                newPrice.setAttribute("required", "true");

                if (!newQuantity.checkValidity() || !newPrice.checkValidity()) {

                    newPrice.reportValidity();

                    newQuantity.reportValidity();

                    checkbox.checked = false;

                    return;
                }

                var existingProductIndex = products.findIndex(function(product) {
                    return product.id === parseInt(productId);
                });

                const productData = {
                    id: parseInt(productId),
                    original_quantity: parseInt(originaleQuantity.textContent),
                    original_price: parseInt(originalePrice.textContent),
                    new_quantity: parseInt(newQuantity.value),
                    new_price: parseInt(newPrice.value),
                };

                if (existingProductIndex === -1) {

                    products.push(productData);
                } else {

                    products[existingProductIndex] = productData;
                }

            } else {

                products = products.filter(product => product.id !== parseInt(productId));

            }

            setStoredProducts('promotionEditProducts', products)

            updateSelectedCount('promotionEditProducts');

        }

        //handle quanity input
        const quantityInputs = document.querySelectorAll('input.promotionQuantity');

        quantityInputs.forEach(input => {

            input.addEventListener("input", (event) => {

                handleInput(event, 'promotionEditProducts', 'selectedProducts');

            });
        });

        //handle promotion amount
        const promotionInputs = document.querySelectorAll('input.promotionAmount');

        promotionInputs.forEach(input => {

            input.addEventListener("input", (event) => {

                handleInput(event, 'promotionEditProducts', 'selectedProducts');

            });
        });
    </script>

@endsection
