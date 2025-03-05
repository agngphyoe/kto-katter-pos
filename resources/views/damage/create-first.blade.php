@extends('layouts.master-without-nav')
@section('title', 'Damage Create')
@section('css')

@endsection
@section('content')
    <section class="damage__create__first">
        {{-- nav start  --}}
        @include('layouts.header-section', [
            'title' => 'Add New Damage',
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
                                    <tr class="text-left border-b">
                                        <th></th> {{-- don't remove this tab --}}
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
            <form id="myForm" action="{{ route('damage-create-second', ['location_id' => $location_id]) }}">
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

            const storeLocalName = 'damageSelectedProducts';

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
                    url: "{{ route('damage-create-first') }}",
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

@endsection
