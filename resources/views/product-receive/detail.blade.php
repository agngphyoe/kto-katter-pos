@extends('layouts.master-without-nav')
@section('title', 'Receive Details')
@section('css')

@endsection

@section('content')
    <section class="Receive__Detail">
        {{-- nav start  --}}
        @include('layouts.header-section', [
            'title' => 'Receive Details',
            'subTitle' => 'Details of Receive',
        ])
        {{-- nav end  --}}
        @php
            $currentCounter = 1;
        @endphp

        {{-- ..........  --}}

        {{-- main start  --}}
        <div class="lg:mx-[30px] mx-[10px] my-[10px] lg:my-[20px]">
            <div class="bg-white rounded-[25px]">
                <div>
                    <br>
                    <h1 class="text-noti  font-jakarta font-semibold text-center mt-5">Receive Details</h1>
                    <div class="flex items-center justify-between flex-wrap gap-3 p-5">
                        <x-information title="Transfer Code" subtitle="{{ $productTran->transfer_inv_code ?? '-' }}" />
                        <x-information title="From" subtitle="{{ $productTran->fromLocationName->location_name ?? '-' }}" />
                        <x-information title="To" subtitle="{{ $productTran->toLocationName->location_name ?? '-' }}" />
                        <x-information title="Transfer By" subtitle="{{ $productTran->user->name ?? '-' }}" />
                        <x-information title="Transfer Date"
                            subtitle="{{ dateFormat($productTran->transfer_date) ?? '-' }}" />
                        <x-information title="Transfer Type" subtitle="{{ $productTran->transfer_type ?? '-' }}" />
                    </div>
                    <br>
                </div>
            </div>
            {{-- ........  --}}
            {{-- purchase information start  --}}
            <div class="bg-white p-5 rounded-[20px] mt-5">
                <div class="data-table">
                    <div class="bg-white px-1 py-2 font-poppins rounded-[20px]  ">
                        @if ($productTran->status == 'pending')
                            <div>
                                <div class="flex items-center justify-end">
                                    @if (auth()->user()->hasPermissions('product-receive-edit'))
                                        <form method="POST" action="{{ route('product-all-receive') }}" id="receiveForm">
                                            @csrf
                                            <input type="hidden" name="code"
                                                value="{{ $productTran->transfer_inv_code }}">
                                            <div>
                                                <button id="submitButton"
                                                    class="bg-primary text-sm  text-white px-5 py-1 rounded-md"
                                                    type="submit">Receive All</button>
                                            </div>
                                        </form>
                                        <div class="w-5"></div>
                                        <form method="POST" action="{{ route('product-all-reject') }}" id="rejectForm">
                                            @csrf
                                            <input type="hidden" name="code"
                                                value="{{ $productTran->transfer_inv_code }}">
                                            <div>
                                                <button id="rejectButton"
                                                    class="bg-primary text-sm  text-white px-5 py-1 rounded-md"
                                                    type="submit">Reject All</button>
                                            </div>
                                        </form>
                                </div>
                        @endif
                        <form method="POST" action="{{ route('receive') }}" onsubmit="return handleSubmit(event)">
                            @csrf
                            <div class="relative overflow-x-auto mt-3 shadow-lg">
                                <table class="w-full text-sm text-center text-gray-500 ">
                                    <thead class="text-sm text-primary bg-gray-50  font-medium font-poppins   ">

                                        {{-- <x-table-head-component :columns="[
                                                    'Product Name (ID)',
                                                    'Categories',
                                                    'Brand',
                                                    'Model',
                                                    'Design',
                                                    'Type',
                                                    'IMEI',
                                                    'IMEI Numbers',
                                                    'Quantity',
                                                    // 'Action'
                                                    // 'IMEI'
                                                ]" /> --}}
                                        <tr class="text-left border-b">
                                            <th
                                                class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-left">
                                                Product Name (ID)
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
                                    <tbody class="text-sm font-normal text-paraColor font-poppins">

                                        @forelse($products as $product)
                                            <tr class="bg-white border-b text-left">
                                                <th scope="row"
                                                    class="px-6 py-4 whitespace-nowrap font-medium  text-gray-900">
                                                    <div class="flex items-center gap-2">

                                                        @if ($product->product?->image)
                                                            <img src="{{ asset('products/image/' . $product->product->image) }}"
                                                                class="w-10 h-10 object-cover">
                                                        @else
                                                            <img src="{{ asset('images/no-image.png') }}"
                                                                class="w-10 h-10 object-cover">
                                                        @endif


                                                        <h1 class="text-[#5C5C5C] font-medium  ">
                                                            {{ $product->product?->name }} <span
                                                                class="text-noti ">({{ $product->product?->code }})</span>
                                                        </h1>
                                                    </div>
                                                </th>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    {{ $product->product?->category?->name }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-noti">
                                                    {{ $product->product?->brand?->name }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    {{ $product->product?->productModel?->name }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    {{ $product->product?->design?->name ?? '-' }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    {{ $product->product?->type?->name ?? '-' }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                                    {{ number_format($product->transfer_qty) }}
                                                </td>
                                                {{-- <td>
                                                    <input type="number" value="{{ $product->transfer_qty }}" name="receiveAmmounts[{{ $product->id }}]" min="0" class="promotionAmount outline-none px-4 py-2 bg-bgMain rounded-xl w-20" required />
                                                </td> --}}
                                                {{-- <td class="px-6 py-4 whitespace-nowrap">
                                                    @if ($product->product->is_imei == 1)
                                                    <div id="inputContainer{{ $product->id }}">
                                                        <input type="number" class="outline outline-1 px-4 py-2 text-sm mb-2" style="width: 80px; border-radius:10%" name="imeiList[{{ $product->id }}]" id="imei{{ $product->id }}_{{ $currentCounter }}">
                                                        <input type="hidden" name="imei_data[{{ $product->id }}]" id="imei_data{{ $product->id }}" value="">
                                                        <button type="button" id="addNewButton" class="bg-primary text-sm text-white px-3 py-1 rounded-lg ml-2" onclick="addInputBox({{ $product->id }})">+</button>
                                                    </div>

                                                    @else
                                                        No Action
                                                    @endif
                                                </td> --}}
                                            </tr>
                                            @empty
                                                @include('layouts.not-found', ['colSpan' => 9])
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                                <br>


                                <input type="hidden" name="code" value="{{ $productTran->transfer_inv_code }}">
                                <div class="flex items-center justify-end">
                                    {{-- <button class="bg-primary text-sm  text-white px-5 py-1 rounded-md" type="submit">Receive</button> --}}
                                </div>

                            </form>
                        </div>
                    @else
                        <div>
                            <div class="relative overflow-x-auto mt-3 shadow-lg">
                                <table class="w-full text-sm text-center text-gray-500 ">
                                    <thead class="text-sm text-primary bg-gray-50  font-medium font-poppins   ">

                                        {{-- <x-table-head-component :columns="[
                                            'Product Name (ID)',
                                            'Categories',
                                            'Brand',
                                            'Model',
                                            'Design',
                                            'Type',
                                            'IMEI',
                                            'IMEI Numbers',
                                            'Transferred Quantity',
                                            'Received Quantity',
                                        ]" /> --}}
                                        <tr class="text-left border-b">
                                            <th
                                                class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-left">
                                                Product Name (ID)
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
                                                class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-left">
                                                IMEI
                                            </th>
                                            <th
                                                class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-left">
                                                IMEI Numbers
                                            </th>
                                            <th
                                                class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-center">
                                                Transferred Quantity
                                            </th>
                                            <th
                                                class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-center">
                                                Received Quantity
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody class="text-sm font-normal text-paraColor font-poppins">

                                        @forelse($products as $product)
                                            <tr class="bg-white border-b text-left">
                                                <th scope="row"
                                                    class="px-6 py-4 whitespace-nowrap font-medium  text-gray-900">
                                                    <div class="flex items-center gap-2">

                                                        @if ($product->product?->image)
                                                            <img src="{{ asset('products/image/' . $product->product->image) }}"
                                                                class="w-10 h-10 object-cover">
                                                        @else
                                                            <img src="{{ asset('images/no-image.png') }}"
                                                                class="w-10 h-10 object-cover">
                                                        @endif


                                                        <h1 class="text-[#5C5C5C] font-medium  ">
                                                            {{ $product->product?->name }}
                                                            <span class="text-noti ">({{ $product->product?->code }})</span>
                                                        </h1>
                                                    </div>
                                                </th>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    {{ $product->product?->category?->name }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-noti">
                                                    {{ $product->product?->brand?->name }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    {{ $product->product?->productModel?->name }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    {{ $product->product?->design?->name ?? '-' }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    {{ $product->product?->type?->name ?? '-' }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    @switch($product->product?->is_imei)
                                                        @case(1)
                                                            <x-badge class="bg-green-600 py-1 text-white px-2">
                                                                IMEI Product
                                                            </x-badge>
                                                        @break

                                                        @case(0)
                                                            <x-badge class="bg-gray-300 py-1 text-dark px-2">
                                                                Non-IMEI Product
                                                            </x-badge>
                                                        @break

                                                        @default
                                                    @endswitch
                                                </td>
                                                <td class="px-6 py-4 text-left">
                                                    @php
                                                        $imeis = json_decode($product->imei_numbers, true); // Decode the JSON into an array
                                                    @endphp

                                                    @if (!empty($imeis) && is_array($imeis))
                                                        @foreach ($imeis as $imei)
                                                            {{ $imei }} <br> <!-- Display each IMEI on a new line -->
                                                        @endforeach
                                                    @else
                                                        No IMEI
                                                    @endif
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                                    {{ number_format($product->transfer_qty) }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                                    {{ number_format($product->stock_qty) }}
                                                </td>
                                            </tr>
                                            @empty
                                                @include('layouts.not-found', ['colSpan' => 9])
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            @endif

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
                var imeiArray = {};
                var counters = {};

                function addInputBox(productId) {
                    var container = document.getElementById("inputContainer" + productId);

                    if (!container) {
                        console.error("Container not found for product ID " + productId);
                        return;
                    }
                    var currentCounter = counters[productId] || 1;

                    var inputValue = document.getElementById("imei" + productId + "_" + currentCounter)?.value;

                    if (!imeiArray[productId]) {
                        imeiArray[productId] = [];
                    }

                    if (inputValue && inputValue.trim() !== "") {
                        imeiArray[productId].push(inputValue);
                        // console.log(imeiArray[productId]);
                    }

                    currentCounter = currentCounter + 1;
                    counters[productId] = currentCounter;

                    var newInput = document.createElement("input");
                    var br = document.createElement("br");

                    newInput.type = "number";
                    newInput.placeholder = "";
                    newInput.className = "outline outline-1 px-4 py-2 text-sm mb-2";
                    // outline outline-1 px-4 py-2 text-sm mb-2
                    newInput.id = "imei" + productId + "_" + currentCounter;
                    // newInput.name = "imeiList[" + productId + "]";

                    var btn = document.createElement("button");
                    btn.type = "button";
                    btn.id = "addNewButton" + productId;
                    btn.className = "bg-primary text-sm text-white px-3 py-1 rounded-lg ml-2";
                    btn.textContent = "+";


                    container.appendChild(br);
                    container.appendChild(newInput);
                    container.appendChild(btn);

                    // Update the button's onclick event using a global event listener
                    document.getElementById("addNewButton" + productId).addEventListener("click", function() {
                        addInputBox(productId);
                    });

                    document.getElementById("imei_data" + productId).value = JSON.stringify(imeiArray[productId]);


                }
            </script>


            <script>
                // Disable the button immediately after submitting the form
                document.getElementById('receiveForm').addEventListener('submit', function(event) {
                    const submitButton = document.getElementById('submitButton');
                    submitButton.disabled = true;
                    submitButton.innerHTML = "Processing...";
                    submitButton.style.opacity = '0.5';
                });

                document.getElementById('rejectForm').addEventListener('submit', function(event) {
                    const rejectButton = document.getElementById('rejectButton');
                    rejectButton.disabled = true;
                    rejectButton.innerHTML = "Processing...";
                    rejectButton.style.opacity = '0.5';
                });
            </script>

        @endsection
