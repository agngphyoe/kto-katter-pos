@extends('layouts.master-without-nav')
@section('title', 'Purchase Return Create')
@section('css')

@endsection
@section('content')
    <section class="purchase__return__Create__forth">
        {{-- nav start  --}}
        @include('layouts.header-section', [
            'title' => 'Create A New Purchase Return',
            'subTitle' => 'Choose the Products ',
        ])
        {{-- nav end  --}}

        <div class="m-5 ">
            <div class="bg-white px-7 py-5 rounded-[20px]">
                <div>
                    <h1 class="font-jakarta text-noti mb-3 font-noti font-semibold ">Purchase Information</h1>
                    <div class="text-inter flex items-center justify-between flex-wrap gap-10">
                        <x-information title="Purchase ID" subtitle="{{ $purchase->invoice_number ?? '-' }}" />
                        <x-information title="Total Buying Amount"
                            subtitle="{{ number_format($purchase->total_amount) ?? '-' }}" />
                        {{-- <x-information title="Total Wholesale Selling Amount" subtitle="{{ $purchase->total_wholesale_selling_amount ?? '-' }}" />
                    <x-information title="Total Retail Selling Amount" subtitle="{{ $purchase->total_retail_selling_amount ?? '-' }}" /> --}}
                        {{-- <x-information title="Payment Type" subtitle="{{ $purchase->payment_type ?? '-' }}" /> --}}
                        <x-information title="Purchased Type" subtitle="{{ $purchase->action_type ?? '-' }}" />
                        <x-information title="Purchased By" subtitle="{{ $purchase->user->name ?? '-' }}" />
                        <x-information title="Date" subtitle="{{ dateFormat($purchase->created_at) ?? '-' }}" />

                    </div>
                </div>
            </div>

            {{-- table start --}}
            <div class="data-table mt-5 mb-5">
                <div class="  bg-white px-7 py-5 font-poppins rounded-[20px]  ">
                    <div class="flex items-center flex-wrap gap-5 justify-between ">
                        <h1 class="text-noti font-semibold  font-jakarta">Purchase Information</h1>
                        <div class="flex items-center outline outline-1 outline-primary rounded-full px-4 py-[7px]">
                            <input type="search" class="outline-none outline-transparent" id="productSearchInput"
                                placeholder="Search..." data-purchase-id="{{ $purchase->id }}">

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
                                            '',
                                            'Product Name',
                                            'Category',
                                            'Brand',
                                            'Design',
                                            'Type',
                                            'Buying Price',
                                            // 'Wholesale Selling Price',
                                            // 'Retail Selling Price',
                                            'Available Quantity',
                                            'Returned Quantity',
                                            ]" /> --}}
                                    <tr class="text-left border-b">
                                        <th></th>
                                        <th
                                            class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-left">
                                            Product Name
                                        </th>
                                        <th
                                            class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-left">
                                            Category
                                        </th>
                                        <th
                                            class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-left">
                                            Brand
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
                                            class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-right">
                                            Buying Price
                                        </th>
                                        <th
                                            class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-left">
                                            Available Quantity
                                        </th>
                                        <th
                                            class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-center">
                                            Returned Quantity
                                        </th>
                                    </tr>
                                </thead>
                                <tbody id="productListContainer">
                                    @forelse($purchase->purchaseProducts as $purchase_product)
                                        @php
                                            $product = \App\Models\Product::find($purchase_product->product_id);
                                        @endphp
                                        <input id="is_imei{{ $product->id }}" value="{{ $product->is_imei }}" hidden>
                                        <span id="quantity{{ $product->id }}"
                                            hidden>{{ $purchase_product->quantity }}</span>

                                        <tr class="bg-white border-b text-left">
                                            <th scope="row"
                                                class="px-6 py-4 font-medium  text-gray-900 whitespace-nowrap ">
                                                <input type="checkbox" class="mr-5 accent-primary"
                                                    data-product-id="{{ $product->id }}">

                                            </th>
                                            <td class="px-6 py-4">
                                                <h1 id="name{{ $product->id }}">
                                                    {{ $product->name ?? '-' }} <span
                                                        class="text-noti">({{ $product->code }})</span>
                                                </h1>

                                            </td>
                                            <td class="px-6 py-4">
                                                {{ $product->category->name ?? '-' }}
                                            </td>
                                            <td class="px-6 py-4 " id="">{{ $product->brand->name ?? '-' }}</td>
                                            <td class="px-6 py-4">
                                                {{ $product->design->name ?? '-' }}
                                            </td>
                                            <td class="px-6 py-4">
                                                {{ $product->type->name ?? '-' }}
                                            </td>
                                            <td class="px-6 py-4 text-right" id="buy_price{{ $product->id }}">
                                                {{ number_format($purchase_product->buying_price) ?? '-' }}
                                            </td>
                                            {{-- <td class="px-6 py-4 text-right" id="wholesale_sell_price{{$purchase_product->product->id}}">
                                            {{ number_format($purchase_product->wholesale_sell_price) ?? '-'}}
                                        </td>
                                        <td class="px-6 py-4 text-right" id="retail_sell_price{{$purchase_product->product->id}}">
                                            {{ number_format($purchase_product->retail_sell_price) ?? '-'}}
                                        </td> --}}
                                            <td class="px-6 py-4 text-center" id="available_quantity{{ $product->id }}">
                                                {{-- {{ $purchase_product->after_quantity ?number_format($purchase_product->after_quantity) : number_format($purchase_product->quantity)}} --}}
                                                {{ number_format($purchase_product->quantity) }}
                                            </td>
                                            <td class="px-6 py-4 text-right" id="action_quantity{{ $product->id }}">
                                                0
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
            <form id="myForm" action="{{ route('purchase-return-create-fourth') }}">
                @csrf
                <div class="flex items-center justify-center gap-10 ">
                    <input value="{{ $purchase->id }}" name="purchase_id" hidden>
                    <a onclick="goBack()">
                        <x-button-component class="outline outline-1 outline-noti text-noti" type="button">
                            Back
                        </x-button-component>
                    </a>

                    <x-button-component class="bg-noti text-white cursor-pointer" type="submit" id="done">
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
        handlePageLoading('purchaseReturnProducts');

        // add to local storage
        const checkboxes = document.querySelectorAll('input[type="checkbox"]');

        checkboxes.forEach(checkbox => {

            checkbox.addEventListener('click', (event) => handleCheckboxClick(event, 'purchaseReturnProducts'));
        });


        function reattachCheckboxListeners() {
            const checkboxes = document.querySelectorAll('input[type="checkbox"]');

            checkboxes.forEach(checkbox => {
                checkbox.addEventListener('click', (event) => handleCheckboxClick(event, 'purchaseReturnProducts'));
            });
        }

        $('#productSearchInput').on('input', function() {
            var inputText = $(this).val().trim();
            var purchase_id = $(this).data('purchase-id');
            var selected_products = JSON.parse(localStorage.getItem('purchaseReturnProducts'));

            $.ajax({
                url: "{{ route('purchase-return-product-list-search') }}",
                method: 'GET',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    search: inputText,
                    selectedData: selected_products,
                    purchase_id: purchase_id
                },
                success: function(response) {
                    if (response.success) {
                        var productListContainer = $('#productListContainer');

                        productListContainer.html(response.html);

                        reattachCheckboxListeners();
                        handlePageLoading('purchaseReturnProducts');
                    } else {
                        console.error(response.error);
                    }
                },
                error: function(xhr, status, error) {
                    console.error(error);
                }
            });
        });
    </script>

    <script>
        function goBack() {
            history.back();
        }
    </script>
@endsection
