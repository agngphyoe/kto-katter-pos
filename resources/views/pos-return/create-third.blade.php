@extends('layouts.master-without-nav')
@section('title', 'POS Return Create')
@section('css')

@endsection
@section('content')
    <section class="pos_return_create">
        {{-- nav start  --}}
        @include('layouts.header-section', [
            'title' => 'Create A New POS Return',
            'subTitle' => 'Choose Products',
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
                                    'IMEI',
                                    'IMEI Numbers',
                                    ]" /> --}}
                                    <tr class="text-left border-b">
                                        <th></th>
                                        <th
                                            class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-left">
                                            Product Name</th>
                                        <th
                                            class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-left">
                                            Category</th>
                                        <th
                                            class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-left">
                                            Brand</th>
                                        <th
                                            class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-left">
                                            Model</th>
                                        <th
                                            class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-left">
                                            Design</th>
                                        <th
                                            class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-left">
                                            Type</th>
                                        <th
                                            class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-left">
                                            IMEI</th>
                                        <th
                                            class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-left">
                                            IMEI Numbers</th>
                                    </tr>
                                </thead>
                                <tbody class="font-poppins" id="productListContainer">
                                    @include('pos-return.search-product-list')

                                </tbody>
                            </table>
                        </div>

                    </div>


                </div>
            </div>
            {{-- table end --}}
            <form id="myForm" action="{{ route('pos-return-create-fourth') }}">
                @csrf
                <input type="hidden" name="purchase_id" id="purchase_id" value="{{ $purchase->id }}">
                <input type="hidden" name="selected_products" id="selectedProducts" />
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

            const storeLocalName = 'posReturnProducts';

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
                var purchase_id = document.getElementById('purchase_id').value;
                var selected_products = JSON.parse(localStorage.getItem(storeLocalName));

                $.ajax({
                    url: "{{ route('pos-return-create-third', ['id' => $purchase->id]) }}",
                    method: 'GET',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        search: inputText,
                        purchase_id: purchase_id,
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
