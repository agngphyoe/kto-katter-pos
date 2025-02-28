@extends('layouts.master-without-nav')
@section('title', 'Create Promotion')
@section('css')

@endsection
@section('content')
    <section class="create-second">
        {{-- nav start  --}}
        @include('layouts.header-section', [
            'title' => 'Select Products',
            'subTitle' => 'Choose Products',
        ])
        {{-- nav end  --}}

        {{-- main content start  --}}

        <div class="lg:mx-[30px] mx-[10px] my-[10px] lg:my-[20px] font-poppins ">
            <div class="grid grid-cols-1 xl:grid-cols-4  gap-3">
                <div class="col-span-1 xl:col-span-3 ">
                    <div class="h-[550px] rounded-2xl shadow-xl bg-white overflow-hidden overflow-y-auto py-5 ">

                        {{-- product cart start  --}}

                        <div class="flex items-center gap-4 px-12 mb-5">

                            <div class="flex items-center outline outline-1 outline-primary rounded-full px-4 py-[7px]">
                                <input type="search" class="outline-none outline-transparent" placeholder="Search..."
                                    id="searchInput">

                                <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 512 512">

                                    <path
                                        d="M416 208c0 45.9-14.9 88.3-40 122.7L502.6 457.4c12.5 12.5 12.5 32.8 0 45.3s-32.8 12.5-45.3 0L330.7 376c-34.4 25.2-76.8 40-122.7 40C93.1 416 0 322.9 0 208S93.1 0 208 0S416 93.1 416 208zM208 352a144 144 0 1 0 0-288 144 144 0 1 0 0 288z"
                                        fill="#00812C" />
                                </svg>
                            </div>

                            <div class="category_id_select">
                                <select name="category_id" id="category_id_select" class="select2 w-[220px]">
                                    <option value="" selected disabled>Choose Category</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                                @error('category_id')
                                    <p class="text-red-600 text-xs mt-2">* {{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <select name="brand_id" id="brand_id_select" class="select2 w-[220px]">
                                    <option value="" selected disabled>Choose Brand</option>
                                    @foreach ($brands as $brand)
                                        <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                                    @endforeach
                                </select>
                                @error('brand_id')
                                    <p class="text-red-600 text-xs mt-2">* {{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        {{-- cart start  --}}
                        <div class="flex relative items-center justify-start gap-2 flex-wrap ml-3 mr-3" id="cart_div">

                            @foreach ($products as $product)
                                <div class="w-64 relative border rounded-md shadow-xl bg-white overflow-hidden hover:scale-95 transition-all duration-300"
                                    style="height: 500px;">
                                    <div class="bg-[#FCFCFC] ">
                                        @if ($product->image !== null)
                                            <img src="{{ asset('products/image/' . $product->image) }}"
                                                class="mx-auto object-cover img-fluid" c alt="">
                                        @else
                                            <img src="{{ asset('images/no-image.png') }}"
                                                class="mx-auto object-cover img-fluid" c alt="">
                                        @endif
                                    </div>

                                    <div class="px-6 py-3" style="height: 120px;">
                                        <div class="mb-3  text-noti">
                                            <h1 class="font-extrabold font-jakarta text-sm">
                                                {{ $product->name ?? '-' }}({{ $product->code ?? '-' }})
                                            </h1>
                                            <input value="{{ $product->code ?? '-' }}" id="productCode{{ $product->id }}"
                                                hidden>
                                        </div>
                                        <div class="grid grid-cols-2 ">
                                            <div>
                                                <div class="flex items-center gap-1">
                                                    <svg xmlns="http://www.w3.org/2000/svg" height="0.9em"
                                                        viewBox="0 0 640 512">
                                                        <path
                                                            d="M58.9 42.1c3-6.1 9.6-9.6 16.3-8.7L320 64 564.8 33.4c6.7-.8 13.3 2.7 16.3 8.7l41.7 83.4c9 17.9-.6 39.6-19.8 45.1L439.6 217.3c-13.9 4-28.8-1.9-36.2-14.3L320 64 236.6 203c-7.4 12.4-22.3 18.3-36.2 14.3L37.1 170.6c-19.3-5.5-28.8-27.2-19.8-45.1L58.9 42.1zM321.1 128l54.9 91.4c14.9 24.8 44.6 36.6 72.5 28.6L576 211.6v167c0 22-15 41.2-36.4 46.6l-204.1 51c-10.2 2.6-20.9 2.6-31 0l-204.1-51C79 419.7 64 400.5 64 378.5v-167L191.6 248c27.8 8 57.6-3.8 72.5-28.6L318.9 128h2.2z"
                                                            fill="#00812C" />
                                                    </svg>
                                                    <h1 class=" text-xs  font-jakarta text-noti font-semibold"
                                                        id="product_brand{{ $product->id }}">
                                                        {{ $product->brand->name ?? '-' }}
                                                    </h1>
                                                </div>

                                            </div>

                                            <div>
                                                <div class="flex items-center  gap-1">
                                                    <svg xmlns="http://www.w3.org/2000/svg" height="1em"
                                                        viewBox="0 0 576 512">
                                                        <path
                                                            d="M48 115.8C38.2 107 32 94.2 32 80c0-26.5 21.5-48 48-48c14.2 0 27 6.2 35.8 16H460.2c8.8-9.8 21.6-16 35.8-16c26.5 0 48 21.5 48 48c0 14.2-6.2 27-16 35.8V396.2c9.8 8.8 16 21.6 16 35.8c0 26.5-21.5 48-48 48c-14.2 0-27-6.2-35.8-16H115.8c-8.8 9.8-21.6 16-35.8 16c-26.5 0-48-21.5-48-48c0-14.2 6.2-27 16-35.8V115.8zM125.3 96c-4.8 13.6-15.6 24.4-29.3 29.3V386.7c13.6 4.8 24.4 15.6 29.3 29.3H450.7c4.8-13.6 15.6-24.4 29.3-29.3V125.3c-13.6-4.8-24.4-15.6-29.3-29.3H125.3zm2.7 64c0-17.7 14.3-32 32-32H288c17.7 0 32 14.3 32 32v96c0 17.7-14.3 32-32 32H160c-17.7 0-32-14.3-32-32V160zM256 320h32c35.3 0 64-28.7 64-64V224h64c17.7 0 32 14.3 32 32v96c0 17.7-14.3 32-32 32H288c-17.7 0-32-14.3-32-32V320z"
                                                            fill="#00812C" />
                                                    </svg>
                                                    <h1 class=" text-xs  font-jakarta text-noti  font-semibold"
                                                        id="product_model{{ $product->id }}">
                                                        {{ $product->productModel->name ?? '-' }}
                                                    </h1>
                                                </div>

                                            </div>

                                        </div>

                                    </div>
                                    <div class="w-full h-[1px] bg-paraColor opacity-30 shadow-xl"></div>

                                    <div class="px-6 py-3">
                                        <div class="flex flex-row items-center justify-center mb-1 gap-3">
                                            <h1 class="font-medium text-sm text-gray-500">Retail Price</h1>
                                        </div>
                                        <div class="flex flex-row items-center justify-center gap-3">
                                            <h1 class="font-semibold text-sm text-gray-500">
                                                {{ number_format($product->retail_price) ?? '-' }}</h1>
                                        </div>

                                    </div>

                                    @if (session('variant') == 'time')
                                        <div class="px-6 py-4">
                                            <div class="flex items-center justify-between gap-2 mb-1">

                                                <input type="number" placeholder="Quantity"
                                                    class="w-28 px-4 text-xs py-1 rounded-full outline-none outline outline-1 outline-paraColor"
                                                    id="quantity{{ $product->id }}" min="0"
                                                    max="{{ $product->quantity }}" value="0" hidden>
                                                @if (session('promo_type') == 'cashback')
                                                    <input type="number" placeholder="Cashback Amt"
                                                        name="cashback_{{ $product->id }}"
                                                        class="w-28 px-1 text-xs py-1 rounded-full outline-none outline outline-1 outline-paraColor"
                                                        id="cashback_{{ $product->id }}" min="0">
                                                @endif

                                                <button
                                                    class="bg-primary hover:bg-transparent text-white font-jakarta text-sm font-bold py-1 px-4 w-41 rounded-full"
                                                    onclick="addToCard({{ $product->id }})">
                                                    Add
                                                </button>
                                            </div>
                                        </div>
                                    @else
                                        <div class="px-3 py-4">
                                            <div class="flex flex-row items-center justify-between mb-1 gap-1">

                                                <input type="number" placeholder="Quantity"
                                                    class="w-28 px-4 text-xs py-1 rounded-full  outline-none outline outline-1 outline-paraColor"
                                                    id="quantity{{ $product->id }}" min="0"
                                                    max="{{ $product->quantity }}" required>

                                                <button
                                                    class="bg-green-600 hover:bg-transparent text-white font-jakarta text-sm font-bold py-1 px-4 rounded-full"
                                                    onclick="addToCard({{ $product->id }})">
                                                    Add
                                                </button>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            @endforeach

                        </div>
                        {{-- cart end --}}

                        {{-- product cart end --}}
                    </div>
                </div>
                <div class="col-span-1 xl:col-span-1 ">
                    {{-- your cart start  --}}
                    <form action="{{ route('promotion-create-final') }}">
                        @csrf
                        {{-- <input type="hidden" name="data" value="{{ json_encode($data) }}"> --}}
                        <input type="hidden" name="selected_products" id="selectedProducts">
                        {{-- <input type="hidden" name="location" value="{{ $data['to_location_id'] }}" id="locationId"> --}}
                        <div class="col-span-1 xl:col-span-1">
                            <div class="bg-white rounded-[20px] h-[600px] relative   p-5 shadow-xl">

                                <h1 class="text-center font-semibold font-poppins text-noti mb-5">Product Information</h1>
                                <div class="px-3 ">
                                    <div class="flex flex-row items-center justify-between mb-1 gap-3">
                                        <h1 class="font-medium font-jarkarta text-sm text-gray-500">Promo Title</h1>
                                        <h1 class="font-medium font-jarkarta text-sm">{{ session('title') }}</h1>
                                    </div>

                                    <div class="w-full h-[1px] bg-paraColor opacity-30 shadow-xl"></div>

                                    <div class="flex flex-row items-center justify-between mb-2 mt-2 gap-3">
                                        <h1 class="font-medium font-jarkarta text-sm text-gray-500">Locations</h1>

                                        <div class="col-12">

                                            @php
                                                $locations = [];
                                                foreach (session('locations') as $location_id) {
                                                    $locations[] = \App\Models\Location::where(
                                                        'id',
                                                        $location_id,
                                                    )->value('location_name');
                                                }
                                            @endphp

                                            <button type="button" class="btn btn-secondary" data-toggle="tooltip"
                                                data-placement="top" title="{{ json_encode($locations) }}">
                                                {{ count(session('locations')) }}
                                            </button>
                                        </div>
                                    </div>

                                    <div class="w-full h-[1px] bg-paraColor opacity-30 shadow-xl mb-3"></div>

                                </div>
                                {{-- table start  --}}

                                <div
                                    class=" overflow-y-auto h-[300px] shadow-lg  scrollbar scrollbar-w-[2px] scrollbar-h-5 scrollbar-thumb-primary scrollbar-track-gray-100">
                                    <table class="w-full font-poppins">
                                        <thead class="border-b text-left sticky top-0 bg-gray-50 text-primary">
                                            <tr>
                                                <th class="px-3 py-2 font-medium whitespace-nowrap text-xs">Product ID</th>
                                                @if (session('variant') == 'time-quantity')
                                                    <th class="px-3 py-2 font-medium whitespace-nowrap text-xs">Quantity
                                                    </th>
                                                @endif
                                                @if (session('promo_type') == 'cashback')
                                                    <th class="px-3 py-2 font-medium whitespace-nowrap text-xs">Cashback
                                                    </th>
                                                @endif
                                                <th class="px-2 py-2 text-center font-medium whitespace-nowrap text-xs">
                                                    Action</th>
                                            </tr>
                                        </thead>
                                        <tbody class="text-[#5C5C5C]" id="selectedProduct">

                                        </tbody>
                                    </table>
                                </div>

                                {{-- table end --}}

                                <div class="bottom-5  right-3 left-3 absolute">

                                    {{-- <div class="flex items-center justify-between mb-5 text-sm">
                                        <h1 class="text-noti font-medium">Total Quantity</h1>
                                        <h1 class="text-paraColor font-medium" id="totalQuantity"></h1>
                                    </div> --}}

                                    <div class="flex items-center justify-center">
                                        <button type="submit"
                                            class="bg-noti text-white rounded-full float-right w-48 py-2"
                                            id="checkOutBtn">Check Out</button>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </form>

                    {{-- your cart end --}}
                </div>
            </div>
        </div>
        {{-- main content end --}}

    </section>
@endsection
@section('script')
    <script>
        function addToCard(productId) {
            var quantity = document.getElementById('quantity' + productId);
            var code = document.getElementById('productCode' + productId).value;
            var cashbackAmount = document.getElementById('cashback_' + productId);

            quantity.reportValidity();

            if ("{{ session('promo_type') }}" === 'cashback' && cashbackAmount) {
                cashbackAmount.reportValidity();
                if (!cashbackAmount.checkValidity()) {
                    return;
                }
            }

            if (quantity.checkValidity()) {
                quantity = quantity.value;
                let cashback = cashbackAmount ? cashbackAmount.value : 0;

                let cartItems = localStorage.getItem('productPromotionCart');
                let updatedCartItems = [];

                if (cartItems) {
                    updatedCartItems = JSON.parse(cartItems);
                    const existingIndex = updatedCartItems.findIndex(item => item.product_id === parseInt(productId));

                    if (existingIndex !== -1) {
                        updatedCartItems[existingIndex].quantity = parseInt(quantity);
                        updatedCartItems[existingIndex].cashback = parseInt(cashback);
                    } else {
                        updatedCartItems.push({
                            product_code: code,
                            product_id: parseInt(productId),
                            quantity: parseInt(quantity),
                            cashback: parseInt(cashback)
                        });
                    }
                } else {
                    updatedCartItems.push({
                        product_code: code,
                        product_id: parseInt(productId),
                        quantity: parseInt(quantity),
                        cashback: parseInt(cashback)
                    });
                }

                localStorage.setItem('productPromotionCart', JSON.stringify(updatedCartItems));
                updateTotalValue();
                displayCartItems();
            }
        }

        function displayCartItems() {
            const tableBody = document.getElementById('selectedProduct');
            const selectedProductsInput = document.getElementById('selectedProducts');
            var variantValue = "{{ session('variant') }}";
            var promoType = "{{ session('promo_type') }}";

            tableBody.innerHTML = '';

            const cartItems = localStorage.getItem('productPromotionCart');

            if (cartItems) {
                const items = JSON.parse(cartItems);

                items.forEach(function(item) {
                    const row = document.createElement('tr');

                    let cashbackColumn = '';
                    if (promoType === 'cashback') {
                        cashbackColumn = `<th class="px-3 py-2 font-normal text-[13px]">${item.cashback}</th>`;
                    }

                    row.innerHTML = `
                        <th class="px-3 py-2 text-left font-normal text-[13px]">${item.product_code}</th>
                        <th class="px-3 py-2 font-normal text-[13px] flex items-center gap-2 ${variantValue === 'time' ? 'hidden' : ''}">
                            <button type="button" class="quantity-button plus-button" onclick="increaseQuantity(this,${item.product_id})">
                                <i class="fa-solid fa-plus"></i>
                            </button>
                            <span class="quantity-value">${item.quantity}</span>
                            <button type="button" class="quantity-button minus-button" onclick="decreaseQuantity(this,${item.product_id})">
                                <i class="fa-solid fa-minus"></i>
                            </button>
                        </th>
                        ${cashbackColumn}
                        <th class="px-3 py-2 font-normal text-[13px]">
                            <button onclick="deleteItemFromCart(this,${item.product_id})">
                                <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 448 512">
                                    <path d="M135.2 17.7L128 32H32C14.3 32 0 46.3 0 64S14.3 96 32 96H416c17.7 0 32-14.3 32-32s-14.3-32-32-32H320l-7.2-14.3C307.4 6.8 296.3 0 284.2 0H163.8c-12.1 0-23.2 6.8-28.6 17.7zM416 128H32L53.2 467c1.6 25.3 22.6 45 47.9 45H346.9c25.3 0 46.3-19.7 47.9-45L416 128z" fill="#FF8A00"/>
                                </svg>
                            </button>
                        </th>
                    `;

                    tableBody.appendChild(row);
                });

                checkEnableCheckOut();
                selectedProductsInput.value = JSON.stringify(items);
            } else {
                selectedProductsInput.value = [];
            }
        }

        function checkEnableCheckOut() {
            var cartItems = localStorage.getItem('productPromotionCart');
            var checkoutButton = $('#checkOutBtn');

            if (cartItems && JSON.parse(cartItems).length > 0) {
                checkoutButton.prop('disabled', false);
            } else {
                checkoutButton.prop('disabled', true);
            }
        }

        function updateTotalValue() {
            var items = JSON.parse(localStorage.getItem('productPromotionCart')) || [];
            var totalQuantity = 0;

            items.forEach(function(item) {
                totalQuantity += parseInt(item.quantity) || 0;
            });

            $('#totalQuantity').text(Number(totalQuantity).toLocaleString());
        }

        function decreaseQuantity(button, index) {
            var quantityValue = button.parentNode.querySelector('.quantity-value');
            var currentQuantity = parseInt(quantityValue.textContent.replace(/,/g, ""));

            if (currentQuantity > 1) {
                quantityValue.textContent = currentQuantity - 1;
                updateLocalStorage(index, currentQuantity - 1);
                const decreaseQuantity = document.getElementById('quantity' + index);
                if (decreaseQuantity !== null) {
                    decreaseQuantity.value = currentQuantity - 1;
                }
            }
        }

        function increaseQuantity(button, index) {
            var quantityValue = button.parentNode.querySelector('.quantity-value');
            var currentQuantity = parseInt(quantityValue.textContent.replace(/,/g, ""));
            quantityValue.textContent = currentQuantity + 1;
            updateLocalStorage(index, currentQuantity + 1);
            const increaseQuantity = document.getElementById('quantity' + index);
            if (increaseQuantity !== null) {
                increaseQuantity.value = currentQuantity + 1;
            }
        }

        function updateLocalStorage(index, newQuantity) {
            var storeProducts = JSON.parse(localStorage.getItem('productPromotionCart'));
            if (storeProducts && Array.isArray(storeProducts)) {
                var productIndex = storeProducts.findIndex(function(product) {
                    return product.product_id === index;
                });
                if (productIndex !== -1) {
                    storeProducts[productIndex].quantity = newQuantity;
                    localStorage.setItem('productPromotionCart', JSON.stringify(storeProducts));
                    document.getElementById('selectedProducts').value = localStorage.getItem('productPromotionCart');
                    updateTotalValue();
                }
            }
        }

        function deleteItemFromCart(deleteButton, productId) {
            var cartItems = JSON.parse(localStorage.getItem('productPromotionCart'));
            if (cartItems && Array.isArray(cartItems)) {
                var updatedCartItems = cartItems.filter(function(item) {
                    return item.product_id !== productId;
                });
                localStorage.setItem('productPromotionCart', JSON.stringify(updatedCartItems));
            }
            var row = deleteButton.closest('tr');
            row.remove();
            const quantityElement = document.getElementById('quantity' + productId);
            if (quantityElement) {
                quantityElement.value = '';
            }
            updateTotalValue();
            checkEnableCheckOut();
        }

        function handleReload() {
            var selectedProducts = JSON.parse(localStorage.getItem('productPromotionCart'));
            if (selectedProducts) {
                selectedProducts.forEach(item => {
                    const quantityElement = document.getElementById('quantity' + item.product_id);
                    if (quantityElement) {
                        quantityElement.value = item.quantity;
                    }
                });
            }
            displayCartItems(); // Ensure cart is displayed on reload
        }

        $(document).ready(function() {
            // Initialize Select2 on both selects without clear icon
            $('#category_id_select').select2({
                placeholder: "Choose Category"
            });
            $('#brand_id_select').select2({
                placeholder: "Choose Brand"
            });

            // Category change handler with AJAX
            $('#category_id_select').on('change', function() {
                var categoryId = $(this).val();

                if (categoryId) {
                    $.ajax({
                        url: "{{ route('get.brands.by.category') }}",
                        method: 'GET',
                        data: {
                            category_id: categoryId,
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            if (response.success) {
                                var brandSelect = $('#brand_id_select');
                                brandSelect.empty();
                                brandSelect.append(
                                    '<option value="" selected disabled>Choose Brand</option>'
                                );

                                $.each(response.brands, function(index, brand) {
                                    brandSelect.append(
                                        $('<option>', {
                                            value: brand.id,
                                            text: brand.name
                                        })
                                    );
                                });

                                // Trigger Select2 update
                                brandSelect.trigger('change');
                                fetchFilteredProducts();
                            }
                        },
                        error: function(xhr, status, error) {
                            console.error("Error fetching brands:", error);
                        }
                    });
                } else {
                    var brandSelect = $('#brand_id_select');
                    brandSelect.empty();
                    brandSelect.append('<option value="" selected disabled>Choose Brand</option>');
                    brandSelect.trigger('change');
                    fetchFilteredProducts();
                }
            });

            // Fetch filtered products
            function fetchFilteredProducts() {
                var category_id = $('#category_id_select').val();
                var brand_id = $('#brand_id_select').val();
                var searchInput = $('#searchInput').val();
                var choose_by = new URLSearchParams(window.location.search).get('choose_by');

                $.ajax({
                    url: "{{ route('promotion-create-third') }}",
                    method: 'GET',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        category_id: category_id,
                        brand_id: brand_id,
                        search: searchInput,
                        choose_by: choose_by
                    },
                    success: function(response) {
                        if (response.success) {
                            $('#cart_div').html(response.html);
                            handleReload();
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error("Error fetching products:", error);
                    }
                });
            }

            // Event handlers
            $('#searchInput').on('input', debounce(function() {
                fetchFilteredProducts();
            }, 300));

            $('#brand_id_select').on('change', function() {
                fetchFilteredProducts();
            });

            // Debounce function for search input
            function debounce(func, wait) {
                let timeout;
                return function executedFunction(...args) {
                    const later = () => {
                        clearTimeout(timeout);
                        func(...args);
                    };
                    clearTimeout(timeout);
                    timeout = setTimeout(later, wait);
                };
            }

            // Initial setup
            handleReload();
        });
    </script>
@endsection
