@extends('layouts.master-without-nav')
@section('title', 'Damage Edit')
@section('css')

@endsection
@section('content')
    <section class="damage__create__first">
        {{-- nav start  --}}
        @include('layouts.header-section', [
            'title' => 'Edit Damage',
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
                                    'Damage Quantity',
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
                                            Damage Quantity
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
            <form id="myForm" action="{{ route('damage-edit-final') }}">
                @csrf
                <input type="hidden" name="selected_products" id="selectedProducts" />
                <input type="hidden" name="location_id" id="location_id" value="{{ $damage->location_id }}">
                <input type="hidden" name="damage_id" id="damage_id" value="{{ $damage->id }}">
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

            const storeLocalName = 'editDamageSelectedProducts';

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
                var damage_id = document.getElementById('damage_id').value;
                var selected_products = JSON.parse(localStorage.getItem(storeLocalName));

                $.ajax({
                    url: "{{ route('damage-edit-first') }}",
                    method: 'GET',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        search: inputText,
                        damage_id: damage_id,
                        // location_id : location_id,
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
