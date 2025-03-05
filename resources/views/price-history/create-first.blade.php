@extends('layouts.master-without-nav')
@section('title', 'Price Change')
@section('css')
    {{-- <style>
        .hidden_next_btn{
            display: block;
        }
    </style> --}}
@endsection
@section('content')
    <section class="price__history__create__first">
        {{-- nav start  --}}
        @include('layouts.header-section', [
            'title' => 'Create A Price Change',
            'subTitle' => 'Fill to create a price change',
        ])
        {{-- nav end  --}}

        {{-- table start  --}}
        <div class="data-table mt-5 lg:mx-[30px] mx-[10px] my-[10px] lg:my-[20px]">
            {{-- search start --}}
            <x-product-search search="true" text="Selected Products :" />
            {{-- search end  --}}

            <div class="bg-white px-4 py-4 rounded-[20px] my-5">
                <div class="flex justify-start items-center gap-4">
                    <div class="category_id_select">
                        <label for="category_id_select"
                            class="block mb-2 text-paraColor font-semibold text-sm">Category</label>
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
                        <label for="brand_id_select" class="block mb-2 text-paraColor font-semibold text-sm">Brand</label>
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
            </div>

            <div class="  bg-white px-4 py-2 font-poppins rounded-[20px]  ">
                <div>
                    <div class="relative overflow-y-auto shadow-lg  overflow-x-auto h-[400px]  ">
                        <table class="w-full text-sm  text-gray-500 ">
                            <thead class="sticky top-0   border-b text-primary bg-gray-50 font-jakarta  ">
                                {{-- <x-table-head-component :columns="['', 'Product Name', 'Product Code', 'Current Price']" />
                                 --}}
                                <tr class="text-center border-b ">
                                    <th></th> {{-- don't remove this tab --}}
                                    <th
                                        class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-left">
                                        Product Name
                                    </th>
                                    <th
                                        class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-left">
                                        Product Code
                                    </th>
                                    <th
                                        class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-right">
                                        Current Price
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="font-poppins text-[13px]" id="searchResults">
                                @include('price-history.product-list')
                            </tbody>
                        </table>
                    </div>
                    {{-- {{ $products->links('layouts.paginator') }} --}}
                </div>


            </div>
        </div>
        {{-- table end --}}
        <form id="myForm" method="GET" action="{{ route('price-history-create-final') }}">
            @csrf
            <input type="hidden" name="price_change_products" id="price_change_products_input">
            <div class=" mt-6 bottom-6 left-[40%] flex justify-center">
                <x-button-component class="bg-noti text-white hidden" type="submit" id="done">
                    Next
                </x-button-component>
            </div>
        </form>

    </section>
@endsection

@section('script')
    <script src="{{ asset('js/HandleLocalStorage.js') }}"></script>
    <script src="{{ asset('js/SearchFilter.js') }}"></script>

    <script>
        $(document).ready(function() {
            var reattach = 'priceChangeProducts';
            var searchRoute = "{{ route('price-history-create-first') }}";

            executeSearch(searchRoute, reattach);

            $('.select2').select2();

            $('#category_id_select, #brand_id_select').change(function() {
                fetchFilteredProducts();
            });

            function fetchFilteredProducts() {
                var category_id = $('#category_id_select').val();
                var brand_id = $('#brand_id_select').val();

                $.ajax({
                    url: "{{ route('price-history-create-first') }}",
                    type: 'GET',
                    data: {
                        category_id: category_id,
                        brand_id: brand_id
                    },
                    success: function(response) {
                        $('#searchResults').html(response.html);

                        reattachCheckboxListeners();

                        $('.select2').select2();

                        hideAndShowNextBtn();
                    },
                    error: function(xhr, status, error) {
                        console.error("Error fetching products:", error);
                    }
                });
            }
        });

        function reattachCheckboxListeners() {
            const checkboxes = document.querySelectorAll('input[type="checkbox"]');

            checkboxes.forEach(checkbox => {
                checkbox.addEventListener('click', (event) => {
                    handleCheckboxClick(event, 'priceChangeProducts');
                    let productsArray = getStoredProducts('priceChangeProducts');
                    const elementId = document.getElementById('price_change_products_input');
                    elementId.value = JSON.stringify(productsArray);
                    hideAndShowNextBtn();
                });
            });
        }

        function executeOnce() {
            if (localStorage.getItem('refreshPageOne') === 'true') {
                localStorage.removeItem('refreshPageOne');
                location.reload();
            }
        }
        setTimeout(executeOnce, 500);

        function hideAndShowNextBtn() {
            let productsArray = getStoredProducts('priceChangeProducts');
            if (productsArray.length > 0) {
                $('#done').removeClass('hidden');
            } else {
                $('#done').addClass('hidden');
            }
        }

        handlePageLoading('priceChangeProducts');
        hideAndShowNextBtn();

        const checkboxes = document.querySelectorAll('input[type="checkbox"]');

        checkboxes.forEach(checkbox => {
            checkbox.addEventListener('click', (event) => {
                handleCheckboxClick(event, 'priceChangeProducts');
                let productsArray = getStoredProducts('priceChangeProducts');
                const elementId = document.getElementById('price_change_products_input');
                elementId.value = JSON.stringify(productsArray);
                hideAndShowNextBtn();
            });
        });
    </script>
@endsection
