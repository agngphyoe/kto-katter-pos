@extends('layouts.master-without-nav')
@section('title', 'Transfer Create')
@section('css')
<link href="{{ asset('css/imei.css') }}" rel="stylesheet">
@endsection
@section('content')
    <section class="create-second">
        {{-- nav start  --}}
        @include('layouts.header-section', [
            'title' => 'Create A New Transfer',
            'subTitle' => 'Fill to create a new transfer',
        ])
        {{-- nav end  --}}

        {{-- main content start  --}}

        <div class="lg:mx-[30px] mx-[10px] my-[10px] lg:my-[20px] font-poppins ">

            @if(session('error'))
            <div class="flex items-center justify-end mb-5">
                <div class="bg-red-50  rounded-md border-red-700 border-l-2 " id="error">
                    <div class="flex items-center justify-between gap-2 px-4 py-3">
                        <h1 class="text-red-600  text-sm">{{ session('error') }}</h1>
                        <i class="fa-solid fa-xmark  text-sm  cursor-pointer" id="close-btn" onclick="closeErrorMessage()"></i>
                    </div>
                </div>
            </div>
            @endif

            <div class="grid grid-cols-1 xl:grid-cols-4  gap-3">
                <div class="col-span-1 xl:col-span-3 ">
                    <div class="h-[550px] rounded-2xl shadow-xl bg-white overflow-hidden overflow-y-auto py-5 ">

                        {{-- product cart start  --}}

                        <div class="flex items-center gap-4 px-12 mb-5">

                            <div class="flex items-center outline outline-1 outline-primary rounded-full px-4 py-[7px]">
                                <input type="search" class="outline-none outline-transparent" placeholder="Search..." class="searchInput"
                                    id="searchInput">

                                <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 512 512">

                                    <path
                                        d="M416 208c0 45.9-14.9 88.3-40 122.7L502.6 457.4c12.5 12.5 12.5 32.8 0 45.3s-32.8 12.5-45.3 0L330.7 376c-34.4 25.2-76.8 40-122.7 40C93.1 416 0 322.9 0 208S93.1 0 208 0S416 93.1 416 208zM208 352a144 144 0 1 0 0-288 144 144 0 1 0 0 288z"
                                        fill="#00812C" />
                                </svg>
                            </div>
                        </div>
                        {{-- cart start  --}}
                        <div class="flex items-center relative justify-start pl-24 gap-10 flex-wrap" id="cart_div">

                            @foreach ($products as $product)

                                <div
                                    class="w-64   relative border rounded-md shadow-xl   bg-white  overflow-hidden hover:scale-95 transition-all duration-300">
                                    @if ($product->is_imei == 1)
                                        <div class="bg-primary text-white text-[16px] px-2">IMEI Product</div>
                                    @endif
                                    <div class="bg-[#FCFCFC] ">
                                        @if ($product->product->is_imei == 1)
                                            <div class="bg-primary text-white text-[16px] px-2">IMEI Product</div>
                                        @endif
                                        @if($product->product->image != null)
                                        <img src="{{ asset('products/image/' . $product->product->image) }}"
                                            class="mx-auto object-cover img-fluid" c alt="">
                                        @else
                                        <img src="{{ asset('images/no-image.png') }}"
                                            class="mx-auto object-cover img-fluid" c alt="">
                                        @endif
                                    </div>

                                    <div class="px-5 py-3">
                                        <div class="mb-3  text-noti">
                                            <h1 class="font-extrabold font-jakarta text-sm">
                                                {{$product->product->name ?? '-'}}({{$product->product->code ?? '-'}})
                                            </h1>
                                            <input value="{{$product->product->code ?? '-'}}" id="productCode{{$product->product->id}}" hidden>
                                            <input value="{{ $product->product->is_imei }}" id="isIMEI{{ $product->product->id }}" hidden>
                                            <input value="{{ $product->product->name }}" id="productName{{ $product->product->id }}" hidden>
                                            <input value="{{ $product->product->wholesale_price }}" id="productWSPrice{{ $product->product->id }}" hidden>
                                            <input value="{{ $product->product->retail_price }}" id="productRPrice{{ $product->product->id }}" hidden>
                                            <input value="{{ $product->quantity }}" id="maxStock{{ $product->product->id }}" hidden>
                                        </div>
                                        <div class="grid grid-cols-2">
                                            <div>
                                                <div class="flex items-center gap-2">
                                                    <svg xmlns="http://www.w3.org/2000/svg" height="0.9em"
                                                        viewBox="0 0 640 512">
                                                        <path
                                                            d="M58.9 42.1c3-6.1 9.6-9.6 16.3-8.7L320 64 564.8 33.4c6.7-.8 13.3 2.7 16.3 8.7l41.7 83.4c9 17.9-.6 39.6-19.8 45.1L439.6 217.3c-13.9 4-28.8-1.9-36.2-14.3L320 64 236.6 203c-7.4 12.4-22.3 18.3-36.2 14.3L37.1 170.6c-19.3-5.5-28.8-27.2-19.8-45.1L58.9 42.1zM321.1 128l54.9 91.4c14.9 24.8 44.6 36.6 72.5 28.6L576 211.6v167c0 22-15 41.2-36.4 46.6l-204.1 51c-10.2 2.6-20.9 2.6-31 0l-204.1-51C79 419.7 64 400.5 64 378.5v-167L191.6 248c27.8 8 57.6-3.8 72.5-28.6L318.9 128h2.2z"
                                                            fill="#00812C" />
                                                    </svg>
                                                    <h1 class=" text-xs  font-jakarta text-noti font-semibold"
                                                        id="product_brand{{$product->id}}">
                                                        {{ $product->product->brand->name ?? '-' }}
                                                    </h1>
                                                </div>

                                            </div>

                                            <div>
                                                <div class="flex items-center  gap-2">
                                                    <svg xmlns="http://www.w3.org/2000/svg" height="1em"
                                                        viewBox="0 0 576 512">
                                                        <path
                                                            d="M48 115.8C38.2 107 32 94.2 32 80c0-26.5 21.5-48 48-48c14.2 0 27 6.2 35.8 16H460.2c8.8-9.8 21.6-16 35.8-16c26.5 0 48 21.5 48 48c0 14.2-6.2 27-16 35.8V396.2c9.8 8.8 16 21.6 16 35.8c0 26.5-21.5 48-48 48c-14.2 0-27-6.2-35.8-16H115.8c-8.8 9.8-21.6 16-35.8 16c-26.5 0-48-21.5-48-48c0-14.2 6.2-27 16-35.8V115.8zM125.3 96c-4.8 13.6-15.6 24.4-29.3 29.3V386.7c13.6 4.8 24.4 15.6 29.3 29.3H450.7c4.8-13.6 15.6-24.4 29.3-29.3V125.3c-13.6-4.8-24.4-15.6-29.3-29.3H125.3zm2.7 64c0-17.7 14.3-32 32-32H288c17.7 0 32 14.3 32 32v96c0 17.7-14.3 32-32 32H160c-17.7 0-32-14.3-32-32V160zM256 320h32c35.3 0 64-28.7 64-64V224h64c17.7 0 32 14.3 32 32v96c0 17.7-14.3 32-32 32H288c-17.7 0-32-14.3-32-32V320z"
                                                            fill="#00812C" />
                                                    </svg>
                                                    <h1 class=" text-xs  font-jakarta text-noti  font-semibold"
                                                        id="product_model{{$product->id}}">
                                                        {{ $product->product->productModel->name ?? '-' }}
                                                    </h1>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="grid grid-cols-2 mt-2">
                                            <div>
                                                <div class="flex items-center  gap-2">
                                                    <svg xmlns="http://www.w3.org/2000/svg" height="1em"
                                                        viewBox="0 0 576 512">
                                                        <path
                                                            d="M48 115.8C38.2 107 32 94.2 32 80c0-26.5 21.5-48 48-48c14.2 0 27 6.2 35.8 16H460.2c8.8-9.8 21.6-16 35.8-16c26.5 0 48 21.5 48 48c0 14.2-6.2 27-16 35.8V396.2c9.8 8.8 16 21.6 16 35.8c0 26.5-21.5 48-48 48c-14.2 0-27-6.2-35.8-16H115.8c-8.8 9.8-21.6 16-35.8 16c-26.5 0-48-21.5-48-48c0-14.2 6.2-27 16-35.8V115.8zM125.3 96c-4.8 13.6-15.6 24.4-29.3 29.3V386.7c13.6 4.8 24.4 15.6 29.3 29.3H450.7c4.8-13.6 15.6-24.4 29.3-29.3V125.3c-13.6-4.8-24.4-15.6-29.3-29.3H125.3zm2.7 64c0-17.7 14.3-32 32-32H288c17.7 0 32 14.3 32 32v96c0 17.7-14.3 32-32 32H160c-17.7 0-32-14.3-32-32V160zM256 320h32c35.3 0 64-28.7 64-64V224h64c17.7 0 32 14.3 32 32v96c0 17.7-14.3 32-32 32H288c-17.7 0-32-14.3-32-32V320z"
                                                            fill="#00812C" />
                                                    </svg>
                                                    <h1 class=" text-xs  font-jakarta text-noti  font-semibold"
                                                        id="design{{$product->id}}">
                                                        {{ $product->product->design->name ?? '-' }}
                                                    </h1>
                                                </div>
                                            </div>

                                            <div>
                                                <div class="flex items-center  gap-2">
                                                    <svg xmlns="http://www.w3.org/2000/svg" height="1em"
                                                        viewBox="0 0 576 512">
                                                        <path
                                                            d="M48 115.8C38.2 107 32 94.2 32 80c0-26.5 21.5-48 48-48c14.2 0 27 6.2 35.8 16H460.2c8.8-9.8 21.6-16 35.8-16c26.5 0 48 21.5 48 48c0 14.2-6.2 27-16 35.8V396.2c9.8 8.8 16 21.6 16 35.8c0 26.5-21.5 48-48 48c-14.2 0-27-6.2-35.8-16H115.8c-8.8 9.8-21.6 16-35.8 16c-26.5 0-48-21.5-48-48c0-14.2 6.2-27 16-35.8V115.8zM125.3 96c-4.8 13.6-15.6 24.4-29.3 29.3V386.7c13.6 4.8 24.4 15.6 29.3 29.3H450.7c4.8-13.6 15.6-24.4 29.3-29.3V125.3c-13.6-4.8-24.4-15.6-29.3-29.3H125.3zm2.7 64c0-17.7 14.3-32 32-32H288c17.7 0 32 14.3 32 32v96c0 17.7-14.3 32-32 32H160c-17.7 0-32-14.3-32-32V160zM256 320h32c35.3 0 64-28.7 64-64V224h64c17.7 0 32 14.3 32 32v96c0 17.7-14.3 32-32 32H288c-17.7 0-32-14.3-32-32V320z"
                                                            fill="#00812C" />
                                                    </svg>
                                                    <h1 class=" text-xs  font-jakarta text-noti  font-semibold"
                                                        id="type{{$product->id}}">
                                                        {{ $product->product->type->name ?? '-' }}
                                                    </h1>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="w-full h-[1px] bg-paraColor opacity-30 shadow-xl"></div>
                                    <div class="px-3 py-4 ">
                                        <div class="flex flex-row items-center justify-between  mb-4 gap-3">
                                            <h1 class="text-xs font-jakarta text-noti font-semibold">qty - {{ $product->quantity }} /</h1>
                                            <input type="number" placeholder="Quantity"
                                                class="w-28 px-4 text-xs py-1 rounded-full  outline-none outline outline-1 outline-paraColor" id="quantity{{$product->product->id}}" min="0" max="{{ $product->quantity }}" required>

                                            <button type="button" onclick="validProductTransfer({{$product->product->id}})" class="pull">
                                                <i class="fa-solid fa-cart-plus text-xl text-primary  "></i>
                                            </button>
                                        </div>
                                        
                                        <span class="text-red-600 font-jarkarta text-sm hidden" id="errorMsg{{ $product->product->id }}" >Process Failed !!!</span>

                                    </div>

                                </div>
                            @endforeach

                        </div>
                        {{-- cart end --}}

                        {{-- product cart end --}}
                    </div>
                </div>
                <div class="col-span-1 xl:col-span-1 ">
                    {{-- your cart start  --}}
                    <form action="{{ route('product-transfer-create-third') }}" method="POST">
                    @csrf
                    <input type="hidden" name="data" value="{{ json_encode($data) }}">
                    <input type="hidden" name="selected_products" id="selectedProducts">
                    <input type="hidden" name="location" value="{{ $data['from_location_id'] }}" id="locationId">
                    <div class="col-span-1 xl:col-span-1">
                        <div class="bg-white rounded-[20px] h-[600px] relative   p-5 shadow-xl">

                            <h1 class="text-center font-semibold font-poppins text-noti mb-5">Your cart </h1>
                            {{-- table start  --}}
                            <div
                                class=" overflow-y-auto h-[300px] shadow-lg  scrollbar scrollbar-w-[2px] scrollbar-h-5 scrollbar-thumb-primary scrollbar-track-gray-100">
                                <table class="w-full font-poppins">
                                    <thead class="border-b text-left sticky top-0 bg-gray-50 text-primary">
                                        <tr>
                                            <th class="px-3 py-2 font-medium whitespace-nowrap  text-xs"></th>
                                            <th class="px-3 py-2 font-medium whitespace-nowrap  text-xs">Product ID</th>
                                            <th class="px-3 py-2 font-medium whitespace-nowrap text-xs">Quantity</th>
                                            <th class="px-3 py-2 font-medium whitespace-nowrap text-xs">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody class="text-[#5C5C5C]" id="selectedProduct">

                                    </tbody>
                                </table>
                            </div>

                            {{-- table end --}}

                            <div class="bottom-5  right-3 left-3 absolute">
                                <div class="border border-2 border-dashed my-4"></div>
                                <div class="flex items-center justify-between mb-5 text-sm">
                                    <h1 class="text-noti font-medium ">Location From</h1>
                                    <h1 class="text-paraColor font-medium">{{ $data['from_location_name'] }}</h1>
                                </div>
                                <div class="flex items-center justify-between mb-5 text-sm">
                                    <h1 class="text-noti font-medium ">Location to</h1>
                                    <h1 class="text-paraColor font-medium">{{ $data['to_location_name'] }}</h1>
                                </div>
                                <div class="flex items-center justify-between mb-5 text-sm">
                                    <h1 class="text-noti font-medium">Total Quantity</h1>
                                    <h1 class="text-paraColor font-medium" id="totalQuantity"></h1>
                                </div>

                                <div class="flex items-center justify-center gap-2 mb-2">
                                    <button type="button" class="outline outline-1 outline-noti text-sm w-32 py-2 rounded-full text-noti"
                                     id="checkButton">Check</button>
                                    <button type="submit" class="bg-noti text-white rounded-full float-right w-48 py-2 opacity-50"
                                    id="checkOutBtn" disabled>Check Out</button>
                                </div>
                                <span id="showInvalidMessage" class="px-7"></span>
                            </div>

                        </div>
                    </div>
                    </form>

                    {{-- your cart end --}}
                </div>
            </div>
        </div>
        {{-- main content end --}}

    </section>
@endsection
@section('script')

<script>
    const localStorageName = 'productTransferCart';
    var checkOutButton = document.getElementById('checkOutBtn');

    var error=document.getElementById('error');
    var closeBtn=document.getElementById('close-btn');

    function closeErrorMessage(){
        error.classList.add("hidden");
    }

    handleReload();

    window.addEventListener('pageshow', function(event) {
        if (event.persisted || (window.performance && window.performance.navigation.type === 2)) {
            displayCartItems()
        }
    });

    document.addEventListener("DOMContentLoaded", function() {

        displayCartItems();
        $('#checkOutBtn').prop('disabled', true);

        document.getElementById('checkButton').addEventListener('click', function() {
            checkEnableCheckOut(localStorageName, checkOutButton);
            });
        });
        $('#searchInput').on('input', function() 
            {
            var searchInput = $(this).val();
            var location = $('#locationId').val();

            $.ajax({
                url: "{{ route('transfer-product-create-search') }}",
                method: "GET",
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                },
                data: {
                    search: searchInput,
                    location_id: location,
                },
                success: function(response) {
                    $("#cart_div").html(response.html);
                    handleReload();
                },
                error: function(xhr, status, error) {
                    console.log(error);
                },
            });
    });

    $(document).on('click', '.btn-add-tide', function(e) {
        e.preventDefault();

        var controlFormTides = $('#d-outer .outer:first').clone(false);

        controlFormTides.find('td').empty();

        var cloneButton = controlFormTides.find('button.btn-add-tide');
        cloneButton.removeClass('btn-add-tide btn-ym-success').addClass('btn-remove-tide btn-ym-danger')
            .html('<i class="fa fa-minus"></i>');

        var originalHeight = $('#d-outer .outer:first').height();
        controlFormTides.height(originalHeight);

        $("#d-outer").before(controlFormTides);
    }).on('click', '.btn-remove-tide', function(e) {
        e.preventDefault();
        $(this).parents('.outer').remove();
        return false;
    });

    function validProductTransfer(productId){
        var quantity = document.getElementById('quantity'+productId).value;
        var error = document.getElementById('errorMsg'+productId);
        if(quantity == 0){
            error.classList.remove("hidden");
        }else{
            error.classList.add("hidden");
            addToCard(productId);
        }
    }

    function addToCard(productId) {
        var quantity = document.getElementById('quantity'+productId);
        var code = document.getElementById('productCode'+productId).value;
        var isIMEI = document.getElementById('isIMEI'+productId).value;
        var name = document.getElementById('productName'+productId).value;
        var wholesale_price = document.getElementById('productWSPrice'+productId).value;
        var retail_price = document.getElementById('productRPrice'+productId).value;

        quantity.reportValidity();

        if (quantity.checkValidity()) {

            quantity = quantity.value;

            let cartItems = localStorage.getItem(localStorageName);
            let updatedCartItems = [];

            if (cartItems) {

                updatedCartItems = JSON.parse(cartItems);

                const existingIndex = updatedCartItems.findIndex(item => item.product_id === parseInt(productId));

                if (existingIndex !== -1) {

                    updatedCartItems[existingIndex].quantity = parseInt(quantity);
                } else {

                    updatedCartItems.push({
                        product_code: code,
                        product_name: name,
                        product_id: parseInt(productId),
                        wholesale_sell_price: parseInt(wholesale_price),
                        retail_sell_price: parseInt(retail_price),
                        quantity: parseInt(quantity),
                        isIMEI: parseInt(isIMEI),
                        imei: [],
                    });
                }
            } else {

                updatedCartItems.push({
                    product_code: code,
                    product_name: name,
                    product_id: parseInt(productId),
                    wholesale_sell_price: parseInt(wholesale_price),
                    retail_sell_price: parseInt(retail_price),
                    quantity: parseInt(quantity),
                    isIMEI: parseInt(isIMEI),
                    imei: [],
                });
            }

            localStorage.setItem(localStorageName, JSON.stringify(updatedCartItems));
        }

            displayCartItems();
    }

    function displayCartItems() {
        const tableBody = document.getElementById('selectedProduct');
        const selectedProductsInput = document.getElementById('selectedProducts');

        tableBody.innerHTML = '';

        const cartItems = localStorage.getItem(localStorageName);

        if (cartItems) {
            const items = JSON.parse(cartItems);

            items.forEach(function(item) {
                var row = document.createElement('tr');
                row.classList.add('border-b');
                if (item.isIMEI) {

                    row.innerHTML = `
                    <th class="px-3 py-2 imei-container flex items-center">

                        <div class="imei-group  font-poppins ">
                            <div class="bg-primary text-white w-5 h-5 flex items-center justify-center rounded-full ">
                                <a href="/product-transfer/add-imei/${item.product_id}"  data-product-id="${item.product_id}"> <i class="fa-solid fa-plus  text-sm "></i>
                                </a>
                            </div>
                            <div class="imei-list overflow-scroll overflow-y-auto  bg-white  h-44 w-52 shadow-md hover-imei" data-product-id="${item.product_id}">
                                <div class="bg-primary flex items-center justify-between rounded-t-md overflow-hidden py-2 px-4 text-white">
                                        <h1 class="font-light text-sm">${item.product_code}</h1>
                                        <h1 class="font-light text-sm" id="imeiCount${item.product_id}"></h1>
                                </div>
                                <div class="">
                                    <div class="px-4 py-2">
                                        <ul class="flex flex-col gap-1">

                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>


                </th>`;
                } else {
                    row.innerHTML = `<th class="px-3 py-2 imei-container flex items-center"></th>`;
                }


                row.innerHTML += ` <th class="px-3 py-2 text-left font-normal text-[13px] whitespace-nowrap">

                        ${item.product_code}
                           </th>
                        <th class="px-3 py-2 font-normal text-[13px] flex items-center gap-2">
                            <button type="button" class="quantity-button plus-button" onclick="increaseQuantity(this,${item.product_id})">
                                <i class="fa-solid fa-plus"></i>
                            </button>
                            <span class="quantity-value">${item.quantity}</span>
                            <button type="button" class="quantity-button minus-button" onclick="decreaseQuantity(this,${item.product_id})">
                                <i class="fa-solid fa-minus"></i>
                            </button>
                        </th>
                        <th class="px-6 font-normal  text-[13px] ">
                            <div class="">
                                <button class="flex items-center justify-center" id="deleteButton${item.product_id}" onclick="deleteItemFromCart(this,${item.product_id})"><svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 448 512"><path d="M135.2 17.7L128 32H32C14.3 32 0 46.3 0 64S14.3 96 32 96H416c17.7 0 32-14.3 32-32s-14.3-32-32-32H320l-7.2-14.3C307.4 6.8 296.3 0 284.2 0H163.8c-12.1 0-23.2 6.8-28.6 17.7zM416 128H32L53.2 467c1.6 25.3 22.6 45 47.9 45H346.9c25.3 0 46.3-19.7 47.9-45L416 128z" fill="#FF8A00"/></svg></button>
                            </div>
                        </th>
                    `;

                tableBody.appendChild(row);
            });

            showIMEI(localStorageName);
            updateTotalValue();
            // checkEnableCheckOut(localStorageName, checkOutButton);
            selectedProductsInput.value = JSON.stringify(items);
        } else {
            selectedProductsInput.value = [];
        }

    }

    function updateTotalValue() {
            var items = JSON.parse(localStorage.getItem(localStorageName)) || [];
            var totalBuyingPrice = 0;
            var totalQuantity = 0;

            items.forEach(function(item) {
                totalQuantity += item.quantity;
                totalBuyingPrice += item.buying_price * item.quantity;
            });

            $('#totalBuyingPrice').text(Number(totalBuyingPrice).toLocaleString());
            $('#totalQuantity').text(Number(totalQuantity).toLocaleString());

    }

    function decreaseQuantity(button, index) {
        var minQuantity = 1;
        var quantityValue = button.parentNode.querySelector('.quantity-value');
        var currentQuantity = parseInt(quantityValue.textContent.replace(/,/g, ""));

        if (currentQuantity >= 1) {
            quantityValue.textContent = currentQuantity - 1;
            updateLocalStorage(index, currentQuantity - 1);

            const decreaseQuantity = document.getElementById('quantity'+index);
            if (decreaseQuantity !== null) {
                decreaseQuantity.value = currentQuantity - 1;
            }
        }else{
            var deleteButton = document.getElementById("deleteButton"+index);
            deleteItemFromCart(deleteButton, index);
        }
    }

    function increaseQuantity(button, index) {
        var maxQuantity = document.getElementById('maxStock'+ index).value;
    
        var quantityValue = button.parentNode.querySelector('.quantity-value');
        var currentQuantity = parseInt(quantityValue.textContent.replace(/,/g, ""));
        
        if (currentQuantity < maxQuantity) {
            quantityValue.textContent = currentQuantity + 1;
            updateLocalStorage(index, currentQuantity + 1);

            const increaseQuantity = document.getElementById('quantity'+index);
            if (increaseQuantity !== null) {
                increaseQuantity.value = currentQuantity + 1;
            }
        } else {
            button.classList.add("disabled");
        }
    }

    function updateLocalStorage(index, newQuantity) {

        var storeProducts = JSON.parse(localStorage.getItem(localStorageName));

        if (storeProducts && Array.isArray(storeProducts)) {

            var productIndex = storeProducts.findIndex(function(product) {
                return product.product_id === index;
            });

            if (productIndex !== -1) {

                storeProducts[productIndex].quantity = newQuantity;

                localStorage.setItem('productTransferCart', JSON.stringify(storeProducts));

                document.getElementById('selectedProducts').value = localStorage.getItem(localStorageName);

                updateTotalValue();
            }
        }
    }

    function deleteItemFromCart(deleteButton, productId) {

        var cartItems = JSON.parse(localStorage.getItem(localStorageName));

        if (cartItems && Array.isArray(cartItems)) {
            var updatedCartItems = cartItems.filter(function(item) {
                return item.product_id !== productId;
            });

            localStorage.setItem('productTransferCart', JSON.stringify(updatedCartItems));
        }

        var row = deleteButton.closest('tr');
        row.remove();

        const quantityElement = document.getElementById('quantity' + productId);

        if (quantityElement) {
            quantityElement.value = '';
        }

        updateTotalValue();
        // checkEnableCheckOut(localStorageName, checkOutButton);

    }

    function handleReload(){
        var selectedProducts = JSON.parse(localStorage.getItem(localStorageName));
        if (selectedProducts) {
            selectedProducts.forEach(item => {
                const quantityElement = document.getElementById('quantity' + item
                    .product_id);
                const buyingPriceElement = document.getElementById('buyingPrice' + item
                    .product_id);
                const retailPriceElement = document.getElementById('retailPrice' + item
                .product_id);
                const wholesalePriceElement = document.getElementById('wholesalePrice' + item
                .product_id);

                if (quantityElement && buyingPriceElement && retailPriceElement && wholesalePriceElement) {
                    quantityElement.value = item.quantity;
                    buyingPriceElement.value = item.buying_price;
                    retailPriceElement.value = item.retail_price;
                    wholesalePriceElement.value = item.wholesale_price;
                }
            });
        }
    }
    handleReload();
</script>
@endsection
