@extends('layouts.master-without-nav')
@section('title', 'Purchase Return Create')
@section('css')
    {{-- <link href="{{ asset('css/imei.css') }}" rel="stylesheet"> --}}

    <style>
        .hover-imei {
            display: none; /* Hide by default */
            position: absolute;
        }

        .bg-primary:hover + .hover-imei {
            display: block; /* Show when hovering on the primary div */
        }
    </style>
@endsection
@php
    use App\Models\Product;

@endphp

@section('content')
    <section class="purchase__return__final">
        {{-- nav start  --}}
        @include('layouts.header-section', [
            'title' => 'Create A New Purchase Return',
            'subTitle' => 'Fill these to know the supplier you want to return',
        ])
        {{-- nav end  --}}

        <main class="m-5">

            @if (session('error'))
                <div class="flex items-center justify-end mb-5 font-poppins">
                    <div class="bg-red-600 rounded-md border-red-700 border-l-2 " id="error">
                        <div class="flex items-center justify-between gap-2 px-4 py-3">
                            <h1 class="text-white  text-sm">{{ session('error') }}</h1>
                            <i class="fa-solid fa-xmark  text-sm text-white   cursor-pointer" id="close-btn"
                                onclick="closeErrorMessage()"></i>
                        </div>
                    </div>
                </div>
            @endif

            <div class="bg-white rounded-[38px] ">
                {{-- <div>
                <img src="{{ asset('images/PurchaseDetail.png') }}" class="w-full " alt="">
            </div> --}}
                <div class="p-5">
                    <h1 class="text-noti  font-jakarta font-semibold mb-3 ">Supplier Detail</h1>

                    <div class="flex items-center justify-between flex-wrap gap-5">
                        <x-information title="Supplier Name" subtitle="{{ $purchase->supplier->name ?? '-' }}" />
                        <x-information title="Phone Number" subtitle="{{ $purchase->supplier->phone ?? '-' }}" />
                        {{-- <x-information title="City" subtitle="{{ $purchase->supplier->city->name ?? '-' }}" /> --}}
                        <x-information title="Country" subtitle="{{ $purchase->supplier->country->name ?? '-' }}" />
                        <x-information title="Address" subtitle="{{ $purchase->supplier->address ?? '-' }}" />
                    </div>
                </div>
            </div>

            <div class="bg-white p-5 rounded-[20px] mt-5">
                <h1 class="font-jakarta text-noti  font-semibold">Return Purchase Information</h1>
                <div class="relative overflow-x-auto shadow-lg mt-3">
                    <table class="w-full text-sm text-left text-gray-500 ">

                        <thead class="text-sm text-primary font-jakarta bg-gray-50 font-medium   ">
                            <tr>
                                <th scope="col" class="px-6 py-3 whitespace-nowrap text-left">
                                    Purchase ID
                                </th>
                                <th scope="col" class="px-6 py-3 whitespace-nowrap text-left">
                                    Remarks
                                </th>
                                <th scope="col" class="px-6 py-3 whitespace-nowrap text-right ">
                                    Buying Amount
                                </th>
                                <th scope="col" class="px-6 py-3 whitespace-nowrap text-right ">
                                    Return Amount
                                </th>
                                <th scope="col" class="px-6 py-3 whitespace-nowrap text-right ">
                                    New Buying Amount
                                </th>
                                <th scope="col" class="px-6 py-3 whitespace-nowrap text-right ">
                                    Discount Amount
                                </th>
                                <th scope="col" class="px-6 py-3 whitespace-nowrap text-right ">
                                    New Net Amount
                                </th>
                                <th scope="col" class="px-6 py-3 whitespace-nowrap text-left">
                                    Returned By
                                </th>
                                <th scope="col" class="px-6 py-3 whitespace-nowrap text-left">
                                    Returned At
                                </th>


                            </tr>
                        </thead>
                        <tbody class="text-sm font-normal text-paraColor font-poppins">
                            <tr class="bg-white border-b text-left">
                                <th scope="row"
                                    class="px-6 py-4 font-medium flex items-center gap-2 text-gray-900 whitespace-nowrap ">
                                    <h1 class="text-noti">
                                        {{ $purchase->invoice_number ?? '-' }}
                                    </h1>
                                </th>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    {{ $purchase_return_remark ?? '-' }}
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap text-right">
                                    {{ number_format($purchase->currency_type == 'mmk' ? $purchase->total_amount : $purchase->currency_purchase_amount) ?? '-' }}
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap text-right text-red-600">
                                    - {{ number_format($purchase_return_total_amount) }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right">
                                    {{ number_format($purchase_new_amount) }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right">
                                    {{ number_format($purchase->currency_type == 'mmk' ? $purchase->discount_amount : $purchase->currency_discount_amount) ?? '-' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right">
                                    {{ number_format($purchase_new_paid_amount) }}
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap">
                                    {{ auth()->user()->name ?? '-' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    {{ dateFormat($purchase_return_date) }}
                                </td>

                            </tr>


                        </tbody>
                    </table>
                </div>
                <div class="border-1 border-dashed my-5"></div>
                <div class="flex items-center justify-between mt-5">

                    <h1 class="font-jakarta text-noti font-semibold ">Return Product</h1>
                    <h1 class="font-poppins text-md mr-5">Total Return Quantity : <span
                            class="text-noti">{{ $purchase_return_total_quantity ?? 0 }}</span></h1>
                </div>
                <div class="relative overflow-x-auto mt-3 shadow-lg">
                    <table class="w-full text-sm text-left text-gray-500 ">
                        <thead class="text-sm  text-primary font-jakarta bg-gray-50 ">
                            <tr class="text-left border-b">
                                {{-- <th></th> --}}
                                <th scope="col" class="px-6 py-3 whitespace-nowrap">
                                    Product Name <span class="text-paraColor">(ID)</span>
                                </th>

                                <th scope="col" class="px-6 py-3 whitespace-nowrap text-right">
                                    Buying Price
                                </th>
                                <th scope="col" class="px-6 py-3 whitespace-nowrap text-center">
                                    Quantity
                                </th>
                                <th scope="col" class="px-6 py-3 whitespace-nowrap text-right">
                                    Amount
                                </th>
                            </tr>
                        </thead>
                        <tbody class="text-[13px] font-normal text-paraColor font-poppins">
                            @forelse($purchase_return_products as $purchase_return_product)
                                <tr class="bg-white border-b text-left">
                                    <th scope="row" class="px-6 py-4 font-medium flex items-center gap-4 text-gray-900 whitespace-nowrap">
                                        <div class="flex items-center gap-4 group relative">
                                            <!-- IMEI Trigger and Dropdown -->
                                            <div class="imei-group flex flex-col items-center">
                                                @if ($purchase_return_product->isIMEI)
                                                    <div class="bg-primary text-white w-6 h-6 rounded-full flex items-center justify-center">
                                                        <a href="{{ route('purchase-return-add-imei', ['product' => $purchase_return_product->id, 'purchase' => $purchase->id]) }}"
                                                           data-product-id="{{ $purchase_return_product->id }}">
                                                            <i class="fa-solid fa-plus"></i>
                                                        </a>
                                                    </div>
                                                    <!-- IMEI List (Initially hidden) -->
                                                    <div class="imei-list hover-imei absolute left-7 -top-2 z-50 w-52 bg-white border border-gray-300 rounded-md shadow-lg mt-2 hidden group-hover:block"
                                                         data-product-id="{{ $purchase_return_product->id }}">
                                                        <div class="bg-primary flex items-center justify-between rounded-t-md overflow-hidden py-2 px-4 text-white">
                                                            <h1>{{ $purchase_return_product?->name }}</h1>
                                                            <h1 id="imeiCount{{ $purchase_return_product->id }}"></h1>
                                                        </div>
                                                        <div class="overflow-scroll overflow-y-auto h-32">
                                                            <div class="px-4 py-2">
                                                                <ul class="flex flex-col gap-1"></ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>
                                    
                                            <!-- Product Image -->
                                            <div class="image-container flex items-center">
                                                @if ($purchase_return_product->image == '')
                                                    <img src="{{ asset('images/no-image.png') }}" class="w-10 object-contain" alt="">
                                                @else
                                                    <img src="{{ asset('products/image/' . $purchase_return_product->image) }}" class="w-10 h-10">
                                                @endif
                                            </div>
                                        </div>
                                    
                                        <!-- Product Name and Code -->
                                        <div>
                                            <h1>
                                                {{ $purchase_return_product->name }}
                                                <span class="text-noti">({{ $purchase_return_product->code }})</span>
                                            </h1>
                                            @if ($purchase_return_product->isIMEI)
                                                <div class="text-noti" id="imeiList"></div>
                                            @endif
                                        </div>
                                    </th>
                                                                    

                                    <td class="px-6 py-4 text-right">
                                        {{ number_format($purchase_return_product->buy_price) ?? '-' }}
                                    </td>
                                    
                                    <td class="px-6 py-4 text-center">
                                        {{ number_format($purchase_return_product->returned_quantity) ?? '-' }}
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        {{ number_format($purchase_return_product->returned_quantity * $purchase_return_product->buy_price) ?? '-' }}
                                    </td>

                                </tr>

                            @empty
                            @endforelse
                        </tbody>
                    </table>
                </div>

            </div>
            <form id="myForm" action="{{ route('purchase-return-store') }}" method="POST">
                @csrf
                <input name="purchase_id" value="{{ $purchase->id }}" type="hidden">
                <input type="hidden" name="purchase_return_products" id="purchase_return_products_input">
                <input type="hidden" name="purchase_return_remark" value="{{ $purchase_return_remark }}">
                <input type="hidden" name="purchase_return_date" value="{{ $purchase_return_date }}">
                <input type="hidden" name="purchase_return_total_quantity"
                    value="{{ $purchase_return_total_quantity }}">
                <input type="hidden" name="purchase_return_total_amount" value="{{ $purchase_return_total_amount }}">
                <input type="hidden" name="purchase_new_amount" value="{{ $purchase_new_amount }}">
                <input type="hidden" name="purchase_new_paid_amount" value="{{ $purchase_new_paid_amount }}">

                <div class="flex justify-center items-start gap-10 mt-4">
                    <div>
                        <x-button-component class="outline outline-1 outline-noti rounded-full text-noti" type="button"
                            id="checkButton">
                            Check
                        </x-button-component>

                        <h1 id="showInvalidMessage" class="mt-2 font-poppins text-sm text-left"></h1>

                    </div>

                    <x-button-component class="bg-noti outline-1 outline-noti outline text-white" type="submit"
                        id="done">
                        Confirm
                    </x-button-component>

                </div>
            </form>
        </main>
    </section>
@endsection
@section('script')
    <script src="{{ asset('js/HandleLocalStorage.js') }}"></script>

    {{-- <script>
    // Parse the JSON data from localStorage
    const productsArray = JSON.parse(localStorage.getItem('purchaseReturnProducts'));

    // Convert the array back to a JSON string
    const productsJSONString = JSON.stringify(productsArray);

    // Assuming 'purchase_return_products_input' is the ID of the target input element
    const elementId = document.getElementById('purchase_return_products_input');

    // Set the value of the input element with the JSON data
    elementId.value = productsJSONString;
</script> --}}

    <script>
        const localStorageName = 'purchaseReturnProducts';
        var checkOutButton = document.getElementById('done');

        checkOutButton.setAttribute('disabled', 'disabled');
        checkOutButton.classList.add('opacity-50');

        document.getElementById('checkButton').addEventListener('click', function() {
            checkEnableCheckOut(localStorageName, checkOutButton);
        });

        showIMEI(localStorageName);

        // Parse the JSON data from localStorage
        const productsArray = JSON.parse(localStorage.getItem(localStorageName));

        // Convert the array back to a JSON string
        const productsJSONString = JSON.stringify(productsArray);

        // Assuming 'purchase_return_products_input' is the ID of the target input element
        const elementId = document.getElementById('purchase_return_products_input');

        // Set the value of the input element with the JSON data
        elementId.value = productsJSONString;

        function closeErrorMessage() {
            error.classList.add("hidden");
        }
    </script>

    <script>
        function checkEnableCheckOut(localStorageName, nextButton) {
            let isValid = true;
            var items = localStorage.getItem(localStorageName);
            
            nextButton.setAttribute("disabled", "disabled");
            var invalidMessage = document.getElementById("showInvalidMessage");
            
            if (items && JSON.parse(items).length > 0) {
                JSON.parse(items).forEach((item) => {
                    
                    const { returned_quantity, imei, isIMEI } = item;
                    
                    if (isIMEI && returned_quantity !== imei.length) {
                        isValid = false;
                    }
                    
                });
                
                if (isValid) {
                    enableDoneBtn(nextButton, invalidMessage);
                } else {
                    nextButton.setAttribute("disabled", "disabled");
                    nextButton.classList.add("opacity-50");
                    invalidMessage.classList.add("text-red-600", "text-xs");
                    invalidMessage.textContent =
                        "* Must be same quantity and IMEI Count";
                }
            } else {
                // enableDoneBtn(nextButton, invalidMessage);
                nextButton.setAttribute("disabled", "disabled");
                nextButton.classList.add("opacity-50");
                invalidMessage.classList.add("text-red-600", "text-sm");
                invalidMessage.textContent =
                    "* Cart has No Products !";
            }
        }
    </script>

@endsection
