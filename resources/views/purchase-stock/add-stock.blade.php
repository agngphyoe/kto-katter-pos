@extends('layouts.master-without-nav')
@section('title', 'Add Purchase Stock')

@section('css')

@endsection

@section('content')
    <section class="Transfer__Detail">
        {{-- nav start  --}}
        @include('layouts.header-section', [
            'title' => 'Add Purchase Stock',
            'subTitle' => 'Add Product Stock',
        ])
        {{-- nav end  --}}


        {{-- ..........  --}}

        {{-- main start  --}}
        <div class="lg:mx-[30px] mx-[10px] my-[10px] lg:my-[20px]">

            <div class="bg-white rounded-[25px]">

                <br>
                @php
                    $purchaseView = \App\Models\Purchase::find($purchaseId);
                @endphp
                <h1 class="text-noti  font-jakarta font-semibold text-center mt-5">Purchase Details</h1>
                <div class="flex items-center justify-between flex-wrap gap-3 p-5">
                    <x-information title="Invoice Number" subtitle="{{ $purchaseView->invoice_number }}" />
                    <x-information title="Purchase Date" subtitle="{{ dateFormat($purchaseView->action_date) }}" />
                    <x-information title="Supplier" subtitle="{{ $purchaseView->supplier->name }}" />
                    @php
                        $purchaseProductCount = \App\Models\PurchaseProduct::where('purchase_id', $purchaseId)
                            ->distinct('product_id')
                            ->count();
                    @endphp
                    {{-- <x-information title="Products" subtitle="{{ $purchaseProductCount }}" /> --}}
                    <div>
                        <h1 class="text-primary font-poppins text-center text-sm mb-2 font-semibold">Products </h1>
                        <h1 class="text-paraColor font-poppins text-[13px] text-center whitespace-nowrap">
                            {{ $purchaseProductCount }}
                        </h1>
                    </div>
                    {{-- <x-information title="Quantity" subtitle="{{ $purchaseView->total_quantity }}" /> --}}
                    <div>
                        <h1 class="text-primary font-poppins text-center text-sm mb-2 font-semibold">Quantity </h1>
                        <h1 class="text-paraColor font-poppins text-[13px] text-center whitespace-nowrap">
                            {{ $purchaseView->total_quantity }}
                        </h1>
                    </div>
                </div>
                <br>
            </div>

            <div class="bg-white rounded-[25px] mt-5">

                <div>
                    <br>
                    <h1 class="text-noti  font-jakarta font-semibold text-center mt-5">Product Details</h1>
                    <h1 class="text-primary" style="padding-left: 17px;font-weight: 1000;">Store Name:
                        @foreach ($storeLocations as $location)
                            <input type="number" name="location[]" id="location_{{ $location->id }}"
                                value="{{ $location->id }}" hidden>
                            <input type="text" name="location_name_{{ $location->id }}"
                                id="location_name_{{ $location->id }}" value="{{ $location->location_name }}"
                                class="ml-2 custom_input text-md font-jakarta py-2" style="background-color: white"
                                disabled>
                        @endforeach
                    </h1>
                    <div class="flex items-center justify-between flex-wrap gap-3 p-5">
                        <table class="w-full text-sm text-center text-gray-500 ">
                            <thead class="text-sm text-primary bg-gray-50  font-medium font-poppins   ">
                                <tr class="text-left border-b ">
                                    <th class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap    py-3">
                                        Product Name
                                    </th>
                                    <th class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap    py-3">
                                        Category
                                    </th>
                                    <th class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap    py-3">
                                        Brand
                                    </th>
                                    <th class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap    py-3">
                                        Model
                                    </th>
                                    <th class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap    py-3">
                                        Type
                                    </th>
                                    <th class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap    py-3">
                                        Design
                                    </th>
                                    <th
                                        class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap text-center   py-3">
                                        Quantity
                                    </th>
                                </tr>

                            </thead>
                            <tbody class="text-sm font-normal text-paraColor font-poppins">
                                @foreach ($products as $product)
                                    <tr class="bg-white border-b ">
                                        <td class="px-6 py-4 text-left">
                                            {{ $product->name }} <span class="text-noti">({{ $product->code }})</span>
                                        </td>
                                        <td class="px-6 py-4 text-left">
                                            {{ $product->category->name }}
                                        </td>
                                        <td class="px-6 py-4 text-left">
                                            {{ $product->brand->name }}
                                        </td>
                                        <td class="px-6 py-4 text-left">
                                            {{ $product->productModel->name }}
                                        </td>
                                        <td class="px-6 py-4 text-left">
                                            {{ $product->type->name ?? '-' }}
                                        </td>
                                        <td class="px-6 py-4 text-left">
                                            {{ $product->design->name ?? '-' }}
                                        </td>
                                        <td class="px-6 py-4 text-center">
                                            {{ $purchases->firstWhere('product_id', $product->id)->quantity }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                    </div>
                    <br>
                </div>
            </div>
            {{-- ........  --}}

            {{--  --}}
            <div class="p-5 rounded-[20px">
                <div class="data-table">
                    <div class="px-1 py-2 font-poppins rounded-[20px]  ">
                        <div>
                            <div class="text-center">
                                <form id="addStockForm" action="{{ route('product-purchase-stock-store') }}"
                                    method="POST">
                                    @csrf
                                    <input type="hidden" name="purchase_id" value="{{ $purchaseId }}">
                                    @foreach ($products as $product)
                                        <input type="hidden" name="product_ids[]" value="{{ $product->id }}">
                                    @endforeach
                                    @foreach ($storeLocations as $location)
                                        <input type="hidden" name="locations[]" value="{{ $location->id }}">
                                    @endforeach
                                    <x-button-component id="addStockButton"
                                        class="bg-primary text-white w-[100px] text-center mt-3" type="submit">
                                        Add Stock
                                    </x-button-component>
                                </form>
                            </div>
                        </div>


                    </div>
                </div>
            </div>
            {{--  --}}
        </div>
        {{-- main end  --}}

    </section>
@endsection

@section('script')
    <script>
        function checkQuantity() {
            var quantityElements = document.getElementsByClassName('qty');
            var sum = 0;

            for (var i = 0; i < quantityElements.length; i++) {
                var inputValue = parseInt(quantityElements[i].value, 10) || 0;
                sum += inputValue;
            }

            var addQuantity = parseInt(sum);

            var totalQuantity = document.getElementById("total_quantity").innerHTML;

            if (totalQuantity == addQuantity) {
                document.getElementById('form').submit();
            } else {
                document.getElementById("check_error").style.display = "block";
            }

        }

        document.addEventListener('DOMContentLoaded', function() {
            const addStockButton = document.getElementById('addStockButton');
            addStockButton.addEventListener('click', function(event) {
                event.preventDefault();
                document.getElementById('addStockForm').submit();

            });
        });
    </script>

@endsection
