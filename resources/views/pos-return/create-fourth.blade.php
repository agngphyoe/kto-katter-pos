@extends('layouts.master-without-nav')
@section('title', 'POS Return Create')
@section('css')

@endsection
@section('content')
    <section class="damage__create__second">
        {{-- nav start  --}}
        @include('layouts.header-section', [
            'title' => 'Create A New POS Return',
            'subTitle' => '',
        ])
        {{-- nav end  --}}
        <form id="myForm" action="{{ route('pos-return-create-final') }}" method="GET">
            @csrf
            <div class="lg:mx-[150px] mx-[10px] my-[10px] lg:my-[30px]">
                {{-- remark start  --}}
                <div class="bg-white shadow-xl mb-[30px] rounded-[20px] p-4 sm:p-10 font-jakarta">
                    <div class="sm:flex sm:items-center sm:justify-between  gap-5">
                        <div class="flex flex-col mb-4 sm:mb-0">
                            <label for="" class="text-paraColor text-sm font-semibold mb-3">Remarks <span
                                    class="text-red-600">*</span></label>
                            <textarea name="remark" id="" cols="90" placeholder="" rows="1"
                                class="outline rounded w-full p-3 sm:p-4 outline-1 outline-primary text-sm"></textarea>
                        </div>
                        <div class="flex flex-col">
                            <label for="" class="text-paraColor text-sm font-semibold mb-3">Date</label>
                            <input type="text" name="return_date"
                                class="dateInput outline outline-1 p-3 sm:p-4 outline-primary text-sm rounded "
                                id="">
                        </div>
                    </div>

                </div>
                {{-- remark end --}}

                <input type="hidden" name="purchase_id" value="{{ $purchase->id }}">
                {{-- <input type="hidden" name="damage_products" id="damageProductInput"> --}}

                {{-- table start  --}}
                <div class="bg-white shadow-xl rounded-[20px]  font-jakarta">
                    <div class="data-table ">
                        <div class="  bg-white px-4 py-2 font-poppins rounded-[20px]  ">
                            <div>
                                <div class="relative overflow-y-auto shadow-lg overflow-x-auto  ">
                                    <table class="w-full text-sm  text-gray-500 ">
                                        <thead class="   bg-gray-50  font-jakarta text-primary  ">
                                            {{-- <x-table-head-component :columns="[
                                                'Product Name',
                                                'Quantity',
                                                'Return Type',
                                                'Return Quantity',
                                                'IMEI',
                                                // 'Action'
                                            ]" /> --}}
                                            <tr class="text-left border-b">
                                                <th
                                                    class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-left">
                                                    Product Name</th>
                                                <th
                                                    class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-center">
                                                    Quantity</th>
                                                <th
                                                    class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-left">
                                                    Return Type</th>
                                                <th
                                                    class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-center">
                                                    Return Quantity</th>
                                                <th
                                                    class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-left">
                                                    IMEI</th>
                                            </tr>

                                        </thead>
                                        <tbody class="font-poppins"></tbody>

                                        @foreach ($purchaseProducts as $data)
                                            <input type="hidden" name="product_id[]" value="{{ $data['id'] }}">
                                            @php
                                                $product = \App\Models\Product::find($data['id']);
                                            @endphp
                                            <tr class="bg-white border-b text-left">
                                                <th scope="row" class="px-6 py-3  font-medium whitespace-nowrap">
                                                    <h1 class="text-paraColor text-left">{{ $product->name }}</h1>
                                                </th>
                                                <td class="px-6 py-3 text-center">
                                                    {{ $data['stock_quantity'] }}
                                                </td>
                                                <td class="px-6 py-3 text-left">
                                                    <select class="select2 px-2 py-2" name="return_type[]" required>
                                                        {{-- <option value="" selected disabled>Select</option> --}}
                                                        <option value="cash">Cash</option>
                                                        <option value="product" selected>Exchange</option>
                                                    </select>
                                                </td>
                                                <td class="text-center">
                                                    <input type="number" name="action_quantity[]"
                                                        class="outline-none px-4 py-3 bg-bgMain rounded-xl w-20"
                                                        name="action_quantity[]" min="0"
                                                        max="{{ $data['stock_quantity'] }}" required>
                                                </td>
                                                <td class="px-6 py-4 text-left">
                                                    @if ($product->is_imei == 1)
                                                        <div
                                                            class="bg-primary text-white w-5 h-5 ml-5 flex items-center justify-center rounded-full ">
                                                            <a
                                                                href="{{ url('pos/pos-return/' . $purchase->id . '/' . $product->id . '/add-imei') }}">
                                                                <i class="fa-solid fa-plus  text-sm "></i></a>
                                                        </div>
                                                    @else
                                                        No Actions
                                                    @endif

                                                </td>
                                            </tr>
                                        @endforeach

                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
        </form>
        {{-- table end --}}

        <div class=" mt-6 flex items-center justify-center flex-wrap gap-5">
            <a href="{{ route('pos-return-create-third', ['id' => $purchase->id]) }}">
                <x-button-component class="outline outline-1 outline-noti text-noti" type="button">
                    Back
                </x-button-component>
            </a>

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
            const productsArray = getStoredProducts('posReturnProducts');

            const tableBody = document.getElementById("productTableBody");
            tableBody.innerHTML = '';

            productsArray.forEach(product => {

                var tableRow = displayPosReturnProductList(product);

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
