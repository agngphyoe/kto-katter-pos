@extends('layouts.master-without-nav')
@section('title', 'Stock Adjustment')
@section('css')

@endsection
@section('content')
    <section class="damage__create__first">
        {{-- nav start  --}}
        @include('layouts.header-section', [
            'title' => 'Stock Adjustment',
            'subTitle' => '',
        ])
        {{-- nav end  --}}

        <div class="lg:mx-[30px] mx-[10px] my-[10px] lg:my-[20px]">
            {{-- search start --}}
            <x-product-search search="true" text="Selected Products :" />
            {{-- search end  --}}


            {{-- table start  --}}
            <div class="data-table mt-5">
                <div class="  bg-white px-4 py-2 font-poppins rounded-[20px]  ">
                    <div>
                        <div class="relative overflow-y-auto shadow-lg  overflow-x-auto  ">
                            <table class="w-full text-sm  text-gray-500 ">
                                <thead class="  bg-gray-100 font-jakarta text-primary  ">
                                    {{-- <x-table-head-component :columns="[
                                    '',
                                    'Product Name',
                                    'Categories',
                                    'Brand',
                                    'Model',
                                    'Design',
                                    'Type',
                                    'Quantity',
                                    ]" /> --}}
                                    <tr class="text-center border-b">
                                        <th class="px-6 py-3 text-left">
                                            <input type="checkbox" id="select-all-checkbox" class="w-4 h-5  accent-primary">
                                        </th>
                                        <th
                                            class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-left">
                                            Product Name
                                        </th>
                                        <th
                                            class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-left">
                                            Categories
                                        </th>
                                        <th
                                            class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-left">
                                            Brand
                                        </th>
                                        <th
                                            class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-left">
                                            Model
                                        </th>
                                        <th
                                            class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-left">
                                            Design
                                        </th>
                                        <th
                                            class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-left">
                                            Type
                                        </th>
                                        <th
                                            class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-center">
                                            Quantity
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="font-poppins" id="productListContainer">
                                    @include('product.search-product-list')

                                </tbody>
                            </table>
                        </div>

                    </div>


                </div>
            </div>
            {{-- table end --}}
            <form id="myForm" action="{{ route('product-stock-create-second') }}">
                @csrf
                <input type="hidden" name="selected_products" id="selectedProducts" />
                <input type="hidden" name="location_id" id="location_id" value="{{ $location_id }}">
                <div class="flex justify-center mt-5">
                    <x-button-component class="bg-noti text-white " type="submit" id="done">
                        Next
                    </x-button-component>
                </div>
            </form>
        </div>
    </section>
@endsection
@section('script')
    <script src="{{ asset('js/HandleLocalStorage.js') }}"></script>

    <script>
        $(document).ready(function() {

            const storeLocalName = 'StockAdjustmentProducts';

            handlePageLoading(storeLocalName);

            handleCheckBoxClick()

            function handleCheckBoxClick() {

                const checkboxes = document.querySelectorAll('input[type="checkbox"]');

                checkboxes.forEach(checkbox => {

                    checkbox.addEventListener('click', (event) => handleCheckboxClick(event,
                        storeLocalName));
                });
            }

            function reattachCheckboxListeners() {

                handleCheckBoxClick()
            }

            $('#searchInput').on('input', function() {
                var inputText = $(this).val().trim();
                var location_id = document.getElementById('location_id').value;
                var selected_products = JSON.parse(localStorage.getItem(storeLocalName));

                $.ajax({
                    url: "{{ route('product-stock-create-first') }}",
                    method: 'GET',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        search: inputText,
                        location_id: location_id,
                        selectedData: selected_products
                    },
                    success: function(response) {

                        if (response.success) {
                            var productListContainer = $('#productListContainer');

                            productListContainer.html(response.html);

                            reattachCheckboxListeners();

                            handlePageLoading(storeLocalName);

                        } else {
                            console.error(response.error);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error(error);
                    }
                });
            });
        });
    </script>

    <script>
        // Select All checkbox functionality
        document.addEventListener('DOMContentLoaded', function() {
            const selectAllCheckbox = document.getElementById('select-all-checkbox');
            const productCheckboxes = document.querySelectorAll('.product-checkbox');
            const storeLocalName = 'StockAdjustmentProducts';

            selectAllCheckbox.addEventListener('change', function() {
                const isChecked = this.checked;

                // Clear existing stored products
                localStorage.removeItem(storeLocalName);
                let selectedProducts = [];

                productCheckboxes.forEach(function(checkbox) {
                    checkbox.checked = isChecked;

                    if (isChecked) {
                        // Get product details when checked
                        const productId = checkbox.getAttribute('data-product-id');
                        const nameElement = document.getElementById('name' + productId);
                        const codeElement = document.getElementById('code' + productId);
                        const quantityElement = document.getElementById('quantity' + productId);

                        selectedProducts.push({
                            id: productId,
                            name: nameElement ? nameElement.textContent : '',
                            code: codeElement ? codeElement.textContent.replace(/[()]/g,
                                '') : '',
                            quantity: quantityElement ? quantityElement.textContent.trim() :
                                '0'
                        });
                    }
                });

                if (isChecked && selectedProducts.length > 0) {
                    localStorage.setItem(storeLocalName, JSON.stringify(selectedProducts));
                }

                // Update hidden input
                document.getElementById('selectedProducts').value = localStorage.getItem(storeLocalName);
            });
        });
    </script>
@endsection
