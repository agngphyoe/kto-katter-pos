@extends('layouts.master-without-nav')
@section('title', 'Damage Create')
@section('css')

@endsection
@section('content')
    <section class="damage__create__second">
        {{-- nav start  --}}
        @include('layouts.header-section', [
            'title' => 'Add New Damage',
            'subTitle' => '',
        ])
        {{-- nav end  --}}
        <form id="myForm" action="{{ route('damage-create-final') }}" method="GET">
            @csrf
            <div class="lg:mx-[150px] mx-[10px] my-[10px] lg:my-[30px]">
                {{-- remark start  --}}
                <div class="bg-white shadow-xl mb-[30px] rounded-[20px] p-4 sm:p-10 font-jakarta">
                    <div class="sm:flex sm:items-center sm:justify-between  gap-5">
                        <div class="flex flex-col mb-4 sm:mb-0">
                            <label for="" class="text-paraColor text-sm font-semibold mb-3">Remarks <span
                                    class="text-red-600">*</span></label>
                            <textarea name="remark" id="" cols="90" placeholder="Damage Error" rows="1"
                                class="outline rounded w-full p-3 sm:p-4 outline-1 outline-primary text-sm" required></textarea>
                        </div>
                        <div class="flex flex-col">
                            <label for="" class="text-paraColor text-sm font-semibold mb-3">Date</label>
                            <input type="text" name="damage_date" name="date"
                                class="dateInput outline outline-1 p-3 sm:p-4 outline-primary text-sm rounded "
                                id="">
                        </div>
                    </div>

                </div>
                {{-- remark end --}}

                <input type="hidden" name="damage_products" id="damageProductInput">
                <input type="hidden" name="location_id" value="{{ $location_id }}">
        </form>
        {{-- table start  --}}
        <div class="bg-white shadow-xl rounded-[20px]  font-jakarta">
            <div class="data-table ">
                <div class="  bg-white px-4 py-2 font-poppins rounded-[20px]  ">
                    <div>
                        <div class="relative overflow-y-auto shadow-lg overflow-x-auto  ">
                            <table class="w-full text-sm  text-gray-500 ">
                                <thead class="bg-gray-50  font-jakarta text-primary text-center">
                                    {{-- <x-table-head-component :columns="[
                                            'Product Name',
                                            'Quantity',
                                            'Damage Quantity',
                                            // 'Action'
                                            ]" /> --}}
                                    <tr class="text-left border-b">
                                        <th
                                            class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-left">
                                            Product Name
                                        </th>
                                        <th
                                            class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-center">
                                            Quantity
                                        </th>
                                        <th
                                            class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-center">
                                            Damage Quantity
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="font-poppins " id="productTableBody"></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- table end --}}

        <div class=" mt-6 flex items-center justify-center flex-wrap gap-5">

            <x-button-component class="bg-noti text-white" type="button" id="done">
                Done
            </x-button-component>
        </div>

        </div>


    </section>
@endsection
@section('script')
    <script src="{{ asset('js/HandleLocalStorage.js') }}"></script>

    <script>
        $(function() {
            $('.dateInput').daterangepicker({
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
        populateInputValues();

        function populateInputValues() {
            const productsArray = getStoredProducts('damageSelectedProducts');

            const tableBody = document.getElementById("productTableBody");
            tableBody.innerHTML = '';

            productsArray.forEach(product => {

                var tableRow = displayProductList(product);

                // tableRow += `<td class="pl-10"><button type="button" onclick="confirmDelete(${
            //     product.id
            // })"><i class="fa-solid fa-trash-can text-noti"></i></button></td>
            // </tr>`;

                tableBody.innerHTML += tableRow;

            });

            const elementId = document.getElementById('damageProductInput');

            elementId.value = JSON.stringify(productsArray);

            const doneButton = document.getElementById("done");

            if (doneButton) {

                doneButton.disabled = productsArray.length <= 0;
            }
        }

        //handle quanity input
        const quantityInputs = document.querySelectorAll('input.newQuantity');

        quantityInputs.forEach(input => {

            input.addEventListener("input", (event) => {

                handleInput(event, 'damageSelectedProducts', 'damageProductInput');

            });
        });


        function confirmDelete(productId) {

            deleteProduct('damageSelectedProducts', productId)
        }
    </script>
    <script>
        $('#done').on('click', function() {
            $('#myForm').submit();
        })
    </script>

@endsection
