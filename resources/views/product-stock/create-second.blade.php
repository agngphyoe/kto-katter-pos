@extends('layouts.master-without-nav')
@section('title', 'Product Adjustment')
@section('css')

@endsection

@section('content')
    <section class="Receive__Detail">
        @php
            $currentCounter = 1;
        @endphp
        {{-- nav start  --}}
        @include('layouts.header-section', [
            'title' => 'Adjustment Details',
            'subTitle' => 'Details of Product Adjustment',
        ])
        {{-- nav end  --}}


        {{-- ..........  --}}

        {{-- main start  --}}
        <div class="lg:mx-[30px] mx-[10px] my-[10px] lg:my-[20px]">

            {{-- purchase information start  --}}
            <div class="bg-white p-5 rounded-[20px] mt-5">
                <div class="data-table">
                    <div class="bg-white px-1 py-2 font-poppins rounded-[20px]  ">
                        <div>
                            <form method="POST" action="{{ route('product-stock-store') }}">
                                @csrf
                                <input type="number" name="location_id" value="{{ $location->id }}" hidden>

                                <div class="relative overflow-x-auto mt-3 shadow-lg">
                                    <table class="w-full text-sm text-center text-gray-500 ">
                                        <thead class="text-sm text-primary bg-gray-50 font-medium font-poppins">

                                            <tr class="border-b">
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
                                                <th
                                                    class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-left">
                                                    Status
                                                </th>
                                                <th
                                                    class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-left">
                                                    IMEI
                                                </th>
                                                <th
                                                    class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-left">
                                                    Action
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody class="text-sm font-normal text-paraColor font-poppins">
                                            @forelse($products as $product)
                                                <input type="text" name="products_id[]" value="{{ $product->id }}"
                                                    hidden>
                                                <tr class="bg-white border-b text-left">
                                                    <th scope="row"
                                                        class="px-6 py-4 whitespace-nowrap font-medium  text-gray-900">
                                                        <div class="flex items-center gap-2">
                                                            @if ($product->image)
                                                                <img src="{{ asset('products/image/' . $product->image) }}"
                                                                    class="w-10 h-10 object-cover">
                                                            @else
                                                                <img src="{{ asset('images/no-image.png') }}"
                                                                    class="w-10 h-10 object-cover">
                                                            @endif
                                                            <h1 class="text-[#5C5C5C] font-medium  ">{{ $product->name }}
                                                                <span class="text-noti ">({{ $product->code }})</span>
                                                            </h1>
                                                        </div>
                                                    </th>
                                                    <td class="px-6 py-4 whitespace-nowrap">
                                                        {{ $product->category?->name }}
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap">
                                                        {{ $product->brand?->name }}
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap">
                                                        {{ $product->productModel?->name }}
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap">
                                                        {{ $product->design?->name ?? '-' }}
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap">
                                                        {{ $product->type?->name ?? '-' }}
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-center">
                                                        {{ $product->quantity }}
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap">
                                                        <select
                                                            class="block mb-2 text-paraColor font-jakarta font-medium text-sm"
                                                            id="status" name="status[{{ $product->id }}]"
                                                            data-id="{{ $product->id }}" required>
                                                            <option value="" selected disabled>Select</option>
                                                            <option value="add" class="text-primary font-semibold">Add
                                                            </option>
                                                            <option value="remove" class="text-red-600 font-semibold">Remove
                                                            </option>
                                                        </select>
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap">
                                                        @if ($product->is_imei == 1)
                                                            <div id="inputContainer{{ $product->id }}">
                                                                <input type="number"
                                                                    class="outline-none px-4 py-2 bg-bgMain rounded-xl w-[200px] text-right"
                                                                    name="imeiList[{{ $product->id }}]"
                                                                    id="imei{{ $product->id }}_{{ $currentCounter }}">
                                                                <input type="hidden" name="imei_data[{{ $product->id }}]"
                                                                    id="imei_data{{ $product->id }}" value="">
                                                                <button type="button" id="addNewButton"
                                                                    class="bg-primary text-sm text-white px-3 py-1 rounded-lg ml-2"
                                                                    onclick="addInputBox({{ $product->id }})">+</button>
                                                            </div>
                                                        @else
                                                            No Action
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <input type="number" name="adjustAmount[{{ $product->id }}]"
                                                            min="1"
                                                            class="outline-none px-4 py-2 bg-bgMain rounded-xl w-20 text-right"
                                                            min="0" required />
                                                    </td>
                                                </tr>
                                            @empty
                                                @include('layouts.not-found', ['colSpan' => 9])
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                                <br>
                                <label for="remark"
                                    class="mr-3 text-sm text-primary bg-gray-50  font-medium font-poppins">
                                    Remark <span style="color: red">*</span>
                                </label>
                                <input type="textarea" name="remark" id="remark" placeholder="Remark"
                                    class="outline w-[220px] outline-1 outline-primary px-4 py-2 rounded-2xl text-sm"
                                    required>
                                <div class="flex items-center justify-end">
                                    <button class="bg-primary text-sm  text-white px-5 py-1 rounded-md"
                                        type="submit">Adjust</button>
                                </div>
                            </form>
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
        var imeiArray = {};
        var counters = {};

        function addInputBox(productId) {
            var container = document.getElementById("inputContainer" + productId);
            if (!container) return;

            var currentCounter = counters[productId] || 1;
            var inputValue = document.getElementById("imei" + productId + "_" + currentCounter)?.value;

            if (!imeiArray[productId]) imeiArray[productId] = [];
            if (inputValue && inputValue.trim() !== "") imeiArray[productId].push(inputValue);

            currentCounter++;
            counters[productId] = currentCounter;

            var inputWrapper = document.createElement("div");
            inputWrapper.classList.add("flex", "items-center", "gap-2", "mt-2");

            var newInput = document.createElement("input");
            newInput.type = "number";
            newInput.classList.add("outline-none", "px-4", "py-2", "bg-bgMain", "rounded-xl", "w-[200px]", "text-right");
            newInput.id = "imei" + productId + "_" + currentCounter;

            var addButton = document.createElement("button");
            addButton.type = "button";
            addButton.classList.add("bg-primary", "text-sm", "text-white", "px-3", "py-1", "rounded-lg", "ml-1");
            addButton.textContent = "+";
            addButton.onclick = function() {
                addInputBox(productId);
            };

            var removeButton = document.createElement("button");
            removeButton.type = "button";
            removeButton.classList.add("bg-red-600", "text-sm", "text-white", "px-3", "py-1", "rounded-lg");
            removeButton.textContent = "-";
            removeButton.onclick = function() {
                container.removeChild(inputWrapper);
                updateImeiData(productId);
                enableFirstButton(productId);
            };

            inputWrapper.appendChild(newInput);
            inputWrapper.appendChild(addButton);
            inputWrapper.appendChild(removeButton);
            container.appendChild(inputWrapper);

            updateImeiData(productId);
            enableFirstButton(productId);
        }

        function updateImeiData(productId) {
            var inputs = document.querySelectorAll(`#inputContainer${productId} input[type='number']`);
            imeiArray[productId] = Array.from(inputs).map(input => input.value);
            document.getElementById("imei_data" + productId).value = JSON.stringify(imeiArray[productId]);
        }

        function enableFirstButton(productId) {
            var container = document.getElementById("inputContainer" + productId);
            var allAddButtons = container.querySelectorAll("button.bg-primary");
            allAddButtons.forEach((button, index) => {
                button.disabled = index !== allAddButtons.length - 1;
            });
        }
    </script>
    <script>
        document.addEventListener("keydown", function(event) {
            if (event.key === "Enter") {
                event.preventDefault();
            }
        });
    </script>
@endsection
