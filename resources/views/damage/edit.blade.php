@extends('layouts.master-without-nav')
@section('title', 'Damage Edit')
@section('css')

@endsection
@section('content')
    <section class="damage__edit">
        {{-- nav start  --}}
        @include('layouts.header-section', [
            'title' => 'Edit Damage',
            'subTitle' => 'Fill to edit damage',
        ])
        {{-- nav end  --}}

        {{-- main start  --}}
        <div class=" lg:mx-[160px] mx-[20px] my-[20px] lg:my-[50px]">
            {{-- search start --}}
            <x-product-search search="true" text="Damaged Products :" />

            {{-- search end  --}}


            <form id="myForm" method="POST" action="{{ route('damage-update', ['damage' => $damage->id]) }}">
                @csrf
                @method('PUT')

                <input type="hidden" name="selected_products" id="selectedProducts" />

                {{-- table start  --}}
                <div class="bg-white shadow-xl rounded-[20px]  font-jakarta">
                    <div class="data-table ">
                        <div class="  bg-white px-4 py-2 font-poppins rounded-[20px]  ">
                            <div>
                                <div class="relative overflow-y-auto mt-3  overflow-x-auto  ">
                                    <table class="w-full text-left text-gray-500 ">
                                        <thead class="   border-b bg-gray-50 font-jakarta  text-primary  ">
                                            {{-- <x-table-head-component :columns="['',
                                                                           'Product Name',
                                                                           'Location',
                                                                           'Stock Quantity',
                                                                        //    'Price',
                                                                           'Old Quantity',
                                                                           'New Quantity']" /> --}}
                                            <tr class="text-left border-b">
                                                <th
                                                    class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-left">
                                                    Product Name
                                                </th>
                                                <th
                                                    class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-left">
                                                    Location
                                                </th>
                                                <th
                                                    class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-center">
                                                    Stock Quantity
                                                </th>
                                                <th
                                                    class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-center">
                                                    Old Quantity
                                                </th>
                                                <th
                                                    class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-center">
                                                    New Quantity
                                                </th>
                                            </tr>

                                        </thead>
                                        <tbody class="font-poppins" id="productTableBody">
                                            @include('damage.edit-product-list')
                                        </tbody>
                                    </table>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                {{-- table end --}}

                <div class="flex justify-center mt-5 gap-5">
                    <a href="{{ route('damage-create-first') }}">
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
        const checkboxes = document.querySelectorAll('input[type="checkbox"]');

        handlePageLoading();

        function handlePageLoading() {
            const products = getStoredProducts('damageEditProducts');

            const productIds = products.map(product => product.id);

            checkboxes.forEach(checkbox => {
                const productId = parseInt(checkbox.dataset.productId);
                checkbox.checked = productIds.includes(productId);

                const quantityInput = document.getElementById('newQuantity' + productId);

                const product = products.find(product => product.id === productId);

                if (product) {

                    quantityInput.value = product.new_quantity;
                }
            });

            updateSelectedCount('damageEditProducts')
        }

        checkboxes.forEach(checkbox => {

            checkbox.addEventListener('click', handleCheckboxClick);
        });


        function handleCheckboxClick(event) {
            const checkbox = event.target;
            var productId = checkbox.dataset.productId;
            var products = getStoredProducts('damageEditProducts');
            const originaleQuantity = document.getElementById('originalQuantity' + productId);
            const quantity = document.getElementById('newQuantity' + productId);
            const price = document.getElementById('sell_price' + productId);

            if (checkbox.checked) {

                if (!quantity.checkValidity()) {

                    quantity.reportValidity();

                    checkbox.checked = false;
                    return;
                }

                var existingProductIndex = products.findIndex(function(product) {
                    return product.id === parseInt(productId);
                });

                const productData = {
                    id: parseInt(productId),
                    original_quantity: parseInt(originaleQuantity.textContent),
                    new_quantity: parseInt(quantity.value),
                    sell_price: parseInt(price.textContent),
                };

                if (existingProductIndex === -1) {

                    products.push(productData);
                } else {

                    products[existingProductIndex] = productData;
                }

            } else {

                products = products.filter(product => product.id !== parseInt(productId));

            }

            setStoredProducts('damageEditProducts', products)

            updateSelectedCount('damageEditProducts');

        }

        //handle quanity input
        const quantityInputs = document.querySelectorAll('input.quantity');

        quantityInputs.forEach(input => {

            input.addEventListener("input", (event) => {

                handleInput(event, 'damageEditProducts', 'selectedProducts');

            });
        });

        function reattachCheckboxListeners() {
            const checkboxes = document.querySelectorAll('input[type="checkbox"]');

            checkboxes.forEach(checkbox => {
                checkbox.addEventListener('click', handleCheckboxClick);
            });
        }


        $('#searchInput').on('input', function() {
            var inputText = $(this).val().trim();
            var selected_products = JSON.parse(localStorage.getItem('damageSelectedProducts'));

            $.ajax({
                url: "{{ route('product-list-search') }}",
                method: 'GET',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    search: inputText,
                    selectedData: selected_products
                },
                success: function(response) {
                    if (response.success) {
                        var productListContainer = $('#productListContainer');

                        productListContainer.html(response.html);

                        reattachCheckboxListeners();
                    } else {
                        console.error(response.error);
                    }
                },
                error: function(xhr, status, error) {
                    console.error(error);
                }
            });
        });
    </script>

@endsection
