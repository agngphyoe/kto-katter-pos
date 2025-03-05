@extends('layouts.master-without-nav')
@section('title', 'Add Purchase Stock')

@section('css')
    <style>
        .btn {
            border: 2px solid green;
            border-radius: 30px;
            background-color: white;
            color: black;
            padding: 10px 20px;
            font-size: 12px;
            cursor: pointer;
        }

        .btn:hover {
            background-color: #04AA6D;
            color: white;
        }
    </style>
@endsection

@section('content')
    <section class="Transfer__Detail">
        {{-- nav start  --}}
        @include('layouts.header-section', [
            'title' => 'Add Purchase Stock',
            'subTitle' => 'Details of Purchase',
        ])
        {{-- nav end  --}}


        {{-- ..........  --}}

        {{-- main start  --}}
        <div class="lg:mx-[30px] mx-[10px] my-[10px] lg:my-[20px]">
            <div class="bg-white rounded-[25px]">
                <div>
                    <br>
                    <h1 class="text-noti  font-jakarta font-semibold text-center mt-5">Purchase Details</h1>
                    <div class="flex items-center justify-between flex-wrap gap-3 p-5">
                        <x-information title="Invoice Number" subtitle="{{ $purchase->invoice_number }}" />
                        <x-information title="Purchase Date" subtitle="{{ dateFormat($purchase->action_date) }}" />
                        <x-information title="Supplier" subtitle="{{ $purchase->supplier->name }}" />
                        @php
                            $purchaseProductCount = \App\Models\PurchaseProduct::where('purchase_id', $purchase->id)
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
                        {{-- <x-information title="Quantity" subtitle="{{ $purchase->total_quantity }}" /> --}}
                        <div>
                            <h1 class="text-primary font-poppins text-center text-sm mb-2 font-semibold">Quantity </h1>
                            <h1 class="text-paraColor font-poppins text-[13px] text-center whitespace-nowrap">
                                {{ $purchase->total_quantity }}
                            </h1>
                        </div>
                    </div>
                    <br>
                </div>
            </div>
            {{-- ........  --}}

            {{-- purchase information start  --}}
            <div class="bg-white p-5 rounded-[20px] mt-5">
                <div class="data-table">
                    <div class="bg-white px-1 py-2 font-poppins rounded-[20px]  ">
                        <div>
                            <h1 class="text-noti font-jakarta font-semibold text-center mt-2">Purchase Products</h1>
                            @php
                                $prevPurchase = \App\Models\Purchase::where('id', '<', $purchase->id)
                                    ->orderBy('id', 'desc')
                                    ->first();
                            @endphp
                            @if ($prevPurchase && $prevPurchase->stock_status == 'Remaining')
                                <span class="text-red-600 ml-3">No actions can be made !</span>
                            @else
                                <button id="addStockButton" type="button" class="btn">
                                    Add Stock
                                </button>
                            @endif
                            <div class="relative overflow-x-auto mt-3 shadow-lg">
                                <table class="w-full text-sm text-center text-gray-500 ">
                                    <thead class="text-sm text-primary bg-gray-50  font-medium font-poppins   ">
                                        <tr class="text-left border-b ">
                                            <th class="px-6 py-3 text-left">
                                                <input type="checkbox" id="select-all-checkbox">
                                            </th>
                                            <th
                                                class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap    py-3">
                                                Product Name (ID)
                                            </th>
                                            <th
                                                class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap    py-3">
                                                Categories
                                            </th>
                                            <th
                                                class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap    py-3">
                                                Brand
                                            </th>
                                            <th
                                                class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap    py-3">
                                                Model
                                            </th>
                                            <th
                                                class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap    py-3">
                                                Type
                                            </th>
                                            <th
                                                class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap    py-3">
                                                Design
                                            </th>
                                            <th
                                                class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap text-center   py-3">
                                                Quantity
                                            </th>
                                            <th
                                                class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap    py-3">
                                                Status
                                            </th>

                                        </tr>



                                    </thead>
                                    <tbody class="text-sm font-normal text-paraColor font-poppins">
                                        @php
                                            $purchaseProducts = \App\Models\PurchaseProduct::where(
                                                'purchase_id',
                                                $purchase->id,
                                            )
                                                ->where('status', 'remaining')
                                                ->get();
                                        @endphp
                                        @forelse($purchaseProducts as $data)
                                            @php
                                                $product = \App\Models\Product::find($data->product_id);
                                            @endphp
                                            <tr class="bg-white border-b ">
                                                <td class="px-6 py-4 text-left">
                                                    <input type="checkbox" class="product-checkbox"
                                                        data-product-id="{{ $product->id }}">
                                                </td>
                                                <th scope="row"
                                                    class="px-6 py-4 font-medium  text-gray-900 whitespace-nowrap ">
                                                    <div class="flex items-center gap-2">

                                                        @if ($product->image)
                                                            <img src="{{ asset('products/image/' . $product->image) }}"
                                                                class="w-10 h-10 object-cover">
                                                        @else
                                                            <img src="{{ asset('images/no-image.png') }}"
                                                                class="w-10 h-10 object-cover">
                                                        @endif


                                                        <h1 class="text-[#5C5C5C] font-medium  ">{{ $product->name }} <span
                                                                class="text-noti ">({{ $product->code }})</span></h1>
                                                    </div>
                                                </th>
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
                                                    {{ $data->quantity }}
                                                </td>
                                                @if ($data->status == 'added')
                                                    <td class="px-6 py-4 text-left text-success" style="color: #00812C">
                                                        {{ strtoUpper($data->status) }}
                                                    </td>
                                                @else
                                                    <td class="px-6 py-4 text-left">
                                                        {{ strtoUpper($data->status) }}
                                                    </td>
                                                @endif
                                            </tr>
                                        @empty
                                            @include('layouts.not-found', ['colSpan' => 9])
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>

                        </div>


                    </div>
                </div>
            </div>
            {{-- purchase information end --}}

        </div>
        {{-- main end  --}}

    </section>
@endsection

@section('script')
    <script>
        // Select All checkbox functionality
        document.addEventListener('DOMContentLoaded', function() {
            const selectAllCheckbox = document.getElementById('select-all-checkbox');
            const productCheckboxes = document.querySelectorAll('.product-checkbox');
            const addStockButton = document.getElementById('addStockButton');

            selectAllCheckbox.addEventListener('change', function() {
                const isChecked = this.checked;
                productCheckboxes.forEach(function(checkbox) {
                    checkbox.checked = isChecked;
                });
            });

            addStockButton.addEventListener('click', function(event) {
                event.preventDefault();
                const selectedProductIds = [];
                productCheckboxes.forEach(function(checkbox) {
                    if (checkbox.checked) {
                        selectedProductIds.push(checkbox.getAttribute('data-product-id'));
                    }
                });

                if (selectedProductIds.length > 0) {
                    const purchaseId = {{ $purchase->id }};
                    const queryString = selectedProductIds.map(id => `product_ids[]=${id}`).join('&');
                    const url =
                        `{{ route('product-purchase-stock-add') }}?purchase_id=${purchaseId}&${queryString}`;
                    window.location.href = url;
                } else {
                    alert('Please select at least one product.');
                }
            });
        });
    </script>
@endsection
