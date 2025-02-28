@extends('layouts.master-without-nav')

@section('title', 'Stock Adjustment')

@section('css')

@endsection

@section('content')
    <section class="purchase__return__Create__forth">
        {{-- nav start  --}}
        @include('layouts.header-section', [
            'title' => 'Create A New Stock Adjustment',
            'subTitle' => 'Choose the Products ',
        ])
        {{-- nav end  --}}

        <div class="m-5 ">

            <form action="{{ route('product-stock-create-second') }}" method="get">
                @csrf
                <input type="number" value="{{ $location_id }}" name="location_id" hidden>
                <input type="hidden" name="adjustment_products" id="adjustmentProducts">
                {{-- table start --}}
                <div class="data-table mt-5 mb-5">
                    <div class="  bg-white px-7 py-5 font-poppins rounded-[20px]  ">
                        <div class="flex items-center flex-wrap gap-5 justify-between ">
                            <h1 class="text-noti font-semibold  font-jakarta">Products List</h1>
                            <div class="flex items-center outline outline-1 outline-primary rounded-full px-4 py-[7px]">
                                <input type="search" class="outline-none outline-transparent" id="productSearchInput"
                                    placeholder="Search..." data-location-id="{{ $location_id }}">

                                <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 512 512">

                                    <path
                                        d="M416 208c0 45.9-14.9 88.3-40 122.7L502.6 457.4c12.5 12.5 12.5 32.8 0 45.3s-32.8 12.5-45.3 0L330.7 376c-34.4 25.2-76.8 40-122.7 40C93.1 416 0 322.9 0 208S93.1 0 208 0S416 93.1 416 208zM208 352a144 144 0 1 0 0-288 144 144 0 1 0 0 288z"
                                        fill="#00812C" />
                                </svg>
                            </div>
                            <div class="flex items-center gap-10">
                                <h1 class="text-noti font-medium text-sm">Selected Products</h1>
                                <h1 class="text-[#5C5C5C] text-sm" id="selectedCount">0</h1>
                            </div>
                        </div>
                        <div>
                            <div class="relative overflow-x-auto overflow-y-auto shadow-lg h-[250px] mt-3">
                                <table class="w-full text-sm  text-gray-500 ">
                                    <thead class="  border-b text-primary font-jakarta text-left bg-gray-50 ">
                                        {{-- <x-table-head-component :columns="[
                                                    'Product Name',
                                                    'Quantity',
                                                    'Action'
                                                    ]" /> --}}
                                        <tr class="text-center border-b">
                                            <th
                                                class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-left">
                                                Product Name
                                            </th>
                                            <th
                                                class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-center">
                                                Quantity
                                            </th>
                                            <th
                                                class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-left">
                                                Action
                                            </th>
                                        </tr>
                                    </thead>

                                    <tbody id="productListContainer">
                                        @forelse($products as $product)
                                            <tr class="bg-white border-b text-left">

                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <h1 id="name{{ $product->id }}">
                                                        {{ $product->name ?? '-' }}
                                                    </h1>

                                                </td>
                                                <td class="px-6 py-4 text-center" id="action_quantity{{ $product->id }}">
                                                    {{ number_format($product->quantity) }}
                                                </td>
                                                <td>
                                                    <button type="button"
                                                        class="bg-primary text-white rounded-full w-28 py-3 mt-3 btn"
                                                        data-id="{{ $product->id }}"
                                                        id="selectbtn{{ $product->id }}">Select</button>
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
                {{-- table end  --}}
                <button type="submit" class="bg-noti text-white rounded-full w-48 py-3 mt-3 float-right"
                    id="submitButton">Next</button>
            </form>
        </div>
    </section>
@endsection

@section('script')
    <script src="{{ asset('js/HandleLocalStorage.js') }}"></script>
    <script>
        var submitButton = document.getElementById('submitButton');
        submitButton.disabled = true;
        submitButton.style.opacity = 0.5;

        function handleCheckboxChange(checkbox) {
            var productId = checkbox.dataset.productId;
            productStates[productId] = checkbox.checked;

            updateSelectedCount();
        }

        var productStates = {};

        $('#productSearchInput').on('input', function() {
            var inputText = $(this).val().trim();
            var location_id = $(this).data('location-id');

            $.ajax({
                url: "{{ route('product-stock-product-search') }}",
                method: 'GET',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    search: inputText,
                    location_id: location_id
                },
                success: function(response) {
                    if (response.success) {
                        var productListContainer = $('#productListContainer');

                        productListContainer.html(response.html);

                        changeColorForStoredIDs();
                    } else {
                        console.error(response.error);
                    }
                },
                error: function(xhr, status, error) {
                    console.error(error);
                }
            });
        });

        var buttons = document.querySelectorAll('.btn');
        buttons.forEach(function(button) {
            button.addEventListener('click', function() {
                var itemId = button.getAttribute('data-id');
                var btn = document.getElementById('myButton'.itemId);

                var adjustmentProducts = JSON.parse(localStorage.getItem('adjustmentProducts')) || [];

                if (adjustmentProducts.includes(itemId)) {
                    var updatedProducts = adjustmentProducts.filter(function(product) {
                        return product !== itemId;
                    });
                    localStorage.setItem('adjustmentProducts', JSON.stringify(updatedProducts));

                    var stockAdjustmentProductsData = localStorage.getItem('adjustmentProducts');

                    var stockAdjustmentProductsArray = JSON.parse(stockAdjustmentProductsData);

                    if (stockAdjustmentProductsArray.length == 0) {
                        submitButton.disabled = true;
                        submitButton.style.opacity = 0.5;
                    }
                    button.style.backgroundColor = '';
                    button.textContent = 'Select';
                } else {
                    adjustmentProducts.push(itemId);
                    localStorage.setItem('adjustmentProducts', JSON.stringify(adjustmentProducts));

                    button.style.backgroundColor = 'red';
                    button.textContent = 'Unselect';

                    submitButton.disabled = false;
                    submitButton.style.opacity = 1;
                }


                const adjustment_products = document.getElementById('adjustmentProducts');

                adjustment_products.value = JSON.stringify(adjustmentProducts);

            });
        });

        window.addEventListener('beforeunload', function() {
            localStorage.clear();
        });

        function getStoredIDs() {
            var storedIDs = localStorage.getItem('adjustmentProducts');
            return storedIDs ? JSON.parse(storedIDs) : [];
        }

        function changeColorForStoredIDs() {
            var storedIDs = getStoredIDs();

            storedIDs.map(function(Id) {
                var id = parseInt(Id);
                // console.log(id);
                try {
                    var element = document.getElementById('selectBtn' + id);
                    element.style.backgroundColor = 'red';
                } catch (error) {
                    console.log(error.message);
                }


            });
        }
    </script>
@endsection
