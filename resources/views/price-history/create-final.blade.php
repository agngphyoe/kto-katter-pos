@extends('layouts.master-without-nav')
@section('title', 'Price Change')
@section('css')

@endsection
@section('content')
    <section class="price__history__create__first">
        {{-- nav start  --}}
        @include('layouts.header-section', [
            'title' => 'Create A Price Change',
            'subTitle' => 'Fill to create a price change',
        ])
        {{-- nav end  --}}
        <form id="submitForm" method="POST" action="{{ route('product-price-change-store') }}">
            @csrf
            {{-- table start  --}}
            <div class="data-table mt-5 lg:mx-[30px] mx-[10px] my-[10px] lg:my-[20px]">
                <div class="  bg-white px-4 py-2 font-poppins rounded-[20px]  ">
                    <div>
                        <div class="relative overflow-y-auto shadow-lg  overflow-x-auto h-[420px]  ">
                            <table class="w-full text-sm  text-gray-500 ">
                                <thead class="sticky top-0   border-b text-primary bg-gray-50 font-jakarta  ">
                                    {{-- <x-table-head-component :columns="['Product Name', 'Product Code', 'Current Price', 'New Price', 'Action']" /> --}}
                                    <tr class="text-left border-b">
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
                                        <th
                                            class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-right">
                                            New Price
                                        </th>
                                        <th
                                            class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-left">
                                            Action
                                        </th>
                                    </tr>
                                </thead>

                                <tbody class="font-poppins" id="productListContainer">

                                </tbody>
                            </table>
                        </div>

                    </div>


                </div>
            </div>
            {{-- table end --}}

            <input type="hidden" name="price_change_products" id="price_change_products_input">
            <div class=" mt-6 bottom-6 left-[40%] flex justify-center">
                <x-button-component class="bg-noti text-white " type="submit" id="submitButton">
                    Next
                </x-button-component>
            </div>
        </form>

    </section>
@endsection

@section('script')
    <script src="{{ asset('js/HandleLocalStorage.js') }}"></script>
    <script>
        localStorage.setItem('refreshPageOne', 'true');
    </script>
    <script>
        populateInputValues();

        function populateInputValues() {
            const productsArray = getStoredProducts('priceChangeProducts');

            const tableBody = document.getElementById("productListContainer");
            tableBody.innerHTML = '';

            productsArray.forEach(product => {

                var tableRow = `
            <tr class="text-left border-b">
            <td class="px-6 py-4 whitespace-nowrap" id="name${product.id}">${product.name}</td>
            <td class="px-6 py-4 whitespace-nowrap" id="code${product.id}">${product.code}</td>
            <td class="px-6 py-4 text-right" id="retailPrice${product.id}">${product.retail_price}</td>
            <td class="px-6 py-4 text-right">
                <input type="number" value="${product.retail_price}" id="newRetailPrice${product.id}" min="1" class="promotionAmount outline-none px-4 py-2 text-right bg-bgMain rounded-xl w-40"
                onkeypress="return (event.charCode !=8 && event.charCode ==0 || (event.charCode >= 48 && event.charCode <= 57))" required />
            </td>
            <td class="px-10 py-4 flex justify-center items-center"><button type="button" onclick="confirmDelete(${
                product.id
            })"><i class="fa-solid fa-trash-can text-noti mx-auto"></i></button></td>
            </tr>`;


                tableBody.innerHTML += tableRow;

            });

            const elementId = document.getElementById('price_change_products_input');

            elementId.value = JSON.stringify(productsArray);

            const nextButton = document.getElementById("done");
            handleCheckboxClick
            if (nextButton) {

                nextButton.disabled = productsArray.length <= 0;
            }
        }

        function confirmDelete(productId) {
            deleteProduct('priceChangeProducts', productId)
        }

        //handle promotion amount
        const promotionInputs = document.querySelectorAll('input.promotionAmount');

        promotionInputs.forEach(input => {

            input.addEventListener("input", (event) => {

                handleInput(event, 'priceChangeProducts', 'price_change_products_input');

            });
        });
    </script>
@endsection
