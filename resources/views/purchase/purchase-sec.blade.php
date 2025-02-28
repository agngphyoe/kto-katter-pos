@extends('layouts.master-without-nav')
@section('title','Purchase Create')
@section('css')

@endsection
@section('content')
<section class="create-second">
    {{-- nav start  --}}
    @include('layouts.header-section', [
    'title' => 'Create A New Purchase',
    'subTitle' => 'Fill to create a new purchase',
    ])
    {{-- nav end  --}}

    {{-- main content start  --}}

    {{-- progress bar start  --}}
    <div class="lg:mx-[30px] mx-[10px] my-[10px] lg:my-[20px]">
        <div class="flex items-center block xl:hidden justify-between gap-3 ">
            <div class="flex items-center gap-3 w-full">
                <div class="w-12 h-12 shrink-0 flex items-center justify-center mb-3 bg-primary  rounded-full">
                    <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 448 512">
                        <path d="M438.6 105.4c12.5 12.5 12.5 32.8 0 45.3l-256 256c-12.5 12.5-32.8 12.5-45.3 0l-128-128c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0L160 338.7 393.4 105.4c12.5-12.5 32.8-12.5 45.3 0z" fill="#FFFFFF" />
                    </svg>
                </div>
                <div class="w-full h-[2px] flex-grow bg-primary "></div>
            </div>
            <div class="flex items-center gap-2 w-full">
                <div class="w-12 h-12 shrink-0 flex opacity-50 items-center justify-center mb-3 text-primary outline outline-1 outline-primary rounded-full">
                    2
                </div>
                <div class="w-full h-[2px] flex-grow bg-primary opacity-50 "></div>
            </div>
            <div class="flex items-center gap-3">
                <div class="w-12 h-12 flex opacity-50 items-center justify-center mb-3 text-primary outline outline-1 outline-primary rounded-full">
                    3
                </div>

            </div>

        </div>
        <div class="flex items-center block xl:hidden justify-between font-jakarta gap-3 ">
            <div>
                <h1 class="text-primary font-semibold mb-1 text-sm">Supplier</h1>
                <h1 class="text-paraColor text-xs text-left ">Supplier Information</h1>
            </div>
            <div>
                <h1 class="text-primary font-semibold ml-12 mb-1 text-sm text-center">Product</h1>
                <h1 class="text-paraColor text-xs ml-12 text-center">Products details to be ordered</h1>
            </div>
            <div>
                <h1 class="text-primary font-semibold mb-1 text-sm text-right">payment</h1>
                <h1 class="text-paraColor text-xs text-right">The final steps to be purchased</h1>
            </div>

        </div>
    </div>
    {{-- progress bar end --}}
   
    @if(session('message'))
    <div class="alert alert-success">
        {{ session('message') }}
    </div>
    @endif

    <div class="lg:mx-[30px] mx-[10px] my-[10px] lg:my-[20px] font-poppins ">
        <div class="grid grid-cols-1 xl:grid-cols-4 gap-5">
            <div class="col-span-1 xl:col-span-2">
                {{-- insert prodcut id start  --}}
                <div class="bg-white rounded-[20px] p-10 shadow-xl">
                    <div class="flex items-center justify-center gap-10">
                        <div>
                            <label for="productSelect" class="text-[#898989] mr-2">Select Product</label>
                            <select name="product_id" id="productSelect" class="flex items-center outline outline-1 outline-primary rounded-full px-4 w-[230px]  py-2 select2">
                                <option value="" disabled selected>Product</option>
                                @forelse($products as $product)
                                <option value="{{ $product->id }}">{{ $product->name }} ({{ $product->code}})</option>
                                @empty
                                <option value="" disabled>No Data</option>
                                @endforelse

                            </select>
                        </div>
                        <!-- <div>
                            <button class="outline outline-1 outline-primary font-semibold rounded-lg px-4 py-2 text-primary ">ADD</button>
                        </div> -->
                    </div>

                </div>
                {{-- insert prodcut id end --}}

                <div class="bg-white rounded-[20px] p-5 lg:p-10 shadow-xl my-[20px]" id="productDetail">
                    <div class="flex gap-20 mb-5 justify-center">
                        <span>No Selected Data</span>
                    </div>
                </div>
            </div>
            {{-- your cart start  --}}
            <form action="{{ route('purchase-create-third') }}">
                @csrf
                <input type="hidden" value="{{$supplier_id}}" name="supplier_id">
                <input type="hidden" name="selected_products" id="selectedProducts">
                <div class="col-span-1 xl:col-span-1">
                    <div class="bg-white rounded-[20px] h-[600px] relative   p-5 shadow-xl">

                        <h1 class="text-center font-semibold font-poppins text-noti mb-5">Your cart </h1>
                        {{-- table start  --}}
                        <div class=" overflow-y-auto h-[360px]  scrollbar scrollbar-w-[2px] scrollbar-h-5 scrollbar-thumb-primary scrollbar-track-gray-100">
                            <table class="w-full">
                                <thead class="border-b text-primary">
                                    <tr>

                                        <th class="px-6 py-2 font-medium text-xs">Product ID</th>
                                        <th class="px-6 py-2 font-medium text-xs">Quantity</th>
                                        <th class="px-6 py-2 font-medium text-xs">Buying Price</th>
                                        <th class="px-6 py-2 font-medium text-xs">Selling Price</th>
                                        <th class="px-6 py-2 font-medium text-xs">Action</th>
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
                                <h1 class="text-noti font-medium ">Total Buying Price</h1>
                                <h1 class="text-paraColor font-medium"><span id="totalBuyingPrice"></span> MMK</h1>
                            </div>
                            <div class="flex items-center justify-between mb-5 text-sm">
                                <h1 class="text-noti font-medium">Total Quantity</h1>
                                <h1 class="text-paraColor font-medium" id="totalQuantity"></h1>
                            </div>


                            <div class="flex items-center justify-center">
                                <button type="submit" class="bg-noti text-white rounded-full float-right w-48 py-2" id="checkOutBtn">Check Out</button>
                            </div>
                        </div>

                    </div>
                </div>
            </form>

            {{-- your cart end --}}

            {{-- progress start  --}}
            <div class="col-span-1 hidden xl:block xl:col-span-1">
                <div class="flex justify-between">
                    <div>
                        <h1 class="text-primary font-semibold mb-1 text-lg">Supplier</h1>
                        <h1 class="text-paraColor">Supplier Information</h1>
                    </div>
                    <div class="">
                        <div class="w-12 h-12 flex items-center justify-center mb-3 bg-primary  rounded-full">
                            <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 448 512">
                                <path d="M438.6 105.4c12.5 12.5 12.5 32.8 0 45.3l-256 256c-12.5 12.5-32.8 12.5-45.3 0l-128-128c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0L160 338.7 393.4 105.4c12.5-12.5 32.8-12.5 45.3 0z" fill="#FFFFFF" />
                            </svg>
                        </div>
                        <div class="w-[2px] h-36 bg-primary mx-auto"></div>
                    </div>
                </div>
                <div class="flex justify-between my-3">
                    <div>
                        <h1 class="text-primary font-semibold mb-1 opacity-50 text-lg">Product</h1>
                        <h1 class="text-paraColor">Products details to be ordered</h1>
                    </div>
                    <div class="">
                        <div class="w-12 h-12 flex items-center justify-center mb-3 outline outline-1 opacity-50  outline-primary rounded-full">2</div>
                        <div class="w-[2px] h-36 bg-primary mx-auto opacity-50"></div>
                    </div>
                </div>
                <div class="flex justify-between">
                    <div>
                        <h1 class="text-primary font-semibold mb-1 opacity-50 text-lg">Payment</h1>
                        <h1 class="text-paraColor">The final steps to be purchased</h1>
                    </div>
                    <div class="">
                        <div class="w-12 h-12 flex items-center justify-center mb-3 outline opacity-50 outline-1 outline-primary rounded-full">3</div>

                    </div>
                </div>
            </div>
            {{-- progress end --}}


        </div>

    </div>
    {{-- main content end --}}

</section>
@endsection
@section('script')


<script>
    $(document).ready(function() {
        $('#productSelect').change(function() {
            var selectedValue = $(this).val();

            var cartItems = localStorage.getItem('productPurchaseCart');
            var existingItem = [];

            if (cartItems) {

                var existingCartItems = JSON.parse(cartItems);

                existingItem = existingCartItems.find(item => item.product_id === parseInt(selectedValue));
            }

            $.ajax({
                url: `/purchase/product/${selectedValue}`,
                method: 'GET',
                data: {
                    id: selectedValue,
                    existItem: existingItem
                },
                success: function(response) {
                    $('#productDetail').html(response.html);
                },
                error: function(xhr, status, error) {
                    console.error(error);
                }
            });
        });

        checkEnableCheckOut()
    });
</script>
<script>
    function checkEnableCheckOut() {
        var cartItems = localStorage.getItem('productPurchaseCart');
        var checkoutButton = $('#checkOutBtn');

        if (cartItems && JSON.parse(cartItems).length > 0) {
            checkoutButton.prop('disabled', false);
        } else {
            checkoutButton.prop('disabled', true);
        }
    }

    function addToCard(productId) {
        var quantity = document.getElementById('quantity');
        var buyingPrice = document.getElementById('buyingPrice');
        var sellingPrice = document.getElementById('sellingPrice');
        var code = document.getElementById('productCode').value;

        quantity.reportValidity();
        sellingPrice.reportValidity();
        buyingPrice.reportValidity();

        if (quantity.checkValidity() && buyingPrice.checkValidity() && sellingPrice.checkValidity()) {

            quantity = quantity.value;
            buyingPrice = buyingPrice.value;
            sellingPrice = sellingPrice.value;


            let cartItems = localStorage.getItem('productPurchaseCart');
            let updatedCartItems = [];

            if (cartItems) {

                updatedCartItems = JSON.parse(cartItems);

                const existingIndex = updatedCartItems.findIndex(item => item.product_id === parseInt(productId));
                // have existing index
                if (existingIndex !== -1) {

                    updatedCartItems[existingIndex].quantity = parseInt(quantity);
                    updatedCartItems[existingIndex].buying_price = parseInt(buyingPrice);
                    updatedCartItems[existingIndex].selling_price = parseInt(sellingPrice);
                } else {

                    updatedCartItems.push({
                        product_code: code,
                        product_id: parseInt(productId),
                        quantity: parseInt(quantity),
                        buying_price: parseInt(buyingPrice),
                        selling_price: parseInt(sellingPrice)
                    });
                }
            } else {

                updatedCartItems.push({
                    product_code: code,
                    product_id: parseInt(productId),
                    quantity: parseInt(quantity),
                    buying_price: parseInt(buyingPrice),
                    selling_price: parseInt(sellingPrice)
                });
            }

            localStorage.setItem('productPurchaseCart', JSON.stringify(updatedCartItems));
        }

        displayCartItems();
    }

    function displayCartItems() {
        const tableBody = document.getElementById('selectedProduct');
        const selectedProductsInput = document.getElementById('selectedProducts');

        tableBody.innerHTML = '';

        const cartItems = localStorage.getItem('productPurchaseCart');

        if (cartItems) {
            const items = JSON.parse(cartItems);

            items.forEach(function(item) {
                const row = document.createElement('tr');
                row.innerHTML = `
          <th class="px-1 py-3 font-normal text-[13px]">${item.product_code}</th>
          <th class="px-1 py-3 font-normal text-[13px]"><button type="button" class="quantity-button plus-button" onclick="increaseQuantity(this,${item.product_id})">+</button>
                <span class="quantity-value">${item.quantity}</span>
                <button type="button" class="quantity-button minus-button" onclick="decreaseQuantity(this,${item.product_id})">-</button></th>
                <th class="px-1 py-3 font-normal text-[13px]">${item.buying_price}</th>
                <th class="px-1 py-3 font-normal text-[13px]">${item.selling_price}</th>
          <th class="px-1 py-3 font-normal text-[13px] flex items-center justify-center">
            <div class="flex items-center gap-3">
            <button onclick="deleteItemFromCart(this,${item.product_id})"><svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 448 512"><!--! Font Awesome Free 6.4.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M135.2 17.7L128 32H32C14.3 32 0 46.3 0 64S14.3 96 32 96H416c17.7 0 32-14.3 32-32s-14.3-32-32-32H320l-7.2-14.3C307.4 6.8 296.3 0 284.2 0H163.8c-12.1 0-23.2 6.8-28.6 17.7zM416 128H32L53.2 467c1.6 25.3 22.6 45 47.9 45H346.9c25.3 0 46.3-19.7 47.9-45L416 128z" fill="#FF8A00"/></svg></button>
            </div>
          </th>
        `;

                tableBody.appendChild(row);
            });

            updateTotalValue();
            checkEnableCheckOut();
            selectedProductsInput.value = JSON.stringify(items);
        } else {
            selectedProductsInput.value = [];
        }


    }

    function decreaseQuantity(button, index) {
        var quantityValue = button.parentNode.querySelector('.quantity-value');
        var currentQuantity = parseInt(quantityValue.textContent.replace(/,/g, ""));


        if (currentQuantity > 1) {

            quantityValue.textContent = currentQuantity - 1;

            updateLocalStorage(index, currentQuantity - 1);

            const decreaseQuantity = document.getElementById('quantity');

            if (decreaseQuantity !== null) {

                decreaseQuantity.value = currentQuantity - 1;
            }
        }
    }

    function increaseQuantity(button, index) {

        var quantityValue = button.parentNode.querySelector('.quantity-value');
        var currentQuantity = parseInt(quantityValue.textContent.replace(/,/g, ""));

        quantityValue.textContent = currentQuantity + 1;

        updateLocalStorage(index, currentQuantity + 1);

        const increaseQuantity = document.getElementById('quantity');

        if (increaseQuantity !== null) {

            increaseQuantity.value = currentQuantity + 1;
        }

    }

    function updateLocalStorage(index, newQuantity) {

        var storeProducts = JSON.parse(localStorage.getItem('productPurchaseCart'));

        if (storeProducts && Array.isArray(storeProducts)) {

            var productIndex = storeProducts.findIndex(function(product) {
                return product.product_id === index;
            });

            if (productIndex !== -1) {

                storeProducts[productIndex].quantity = newQuantity;

                localStorage.setItem('productPurchaseCart', JSON.stringify(storeProducts));

                updateTotalValue();
            }
        }
    }

    function updateTotalValue() {
        var items = JSON.parse(localStorage.getItem('productPurchaseCart')) || [];
        var totalBuyingPrice = 0;
        var totalQuantity = 0;

        items.forEach(function(item) {
            totalQuantity += item.quantity;
            totalBuyingPrice += item.buying_price * item.quantity;
        });

        $('#totalBuyingPrice').text(totalBuyingPrice);
        $('#totalQuantity').text(totalQuantity);
    }

    function deleteItemFromCart(deleteButton, productId) {

        var cartItems = JSON.parse(localStorage.getItem('productPurchaseCart'));

        if (cartItems && Array.isArray(cartItems)) {
            var updatedCartItems = cartItems.filter(function(item) {
                return item.product_id !== productId;
            });

            localStorage.setItem('productPurchaseCart', JSON.stringify(updatedCartItems));
        }

        var row = deleteButton.closest('tr');
        row.remove();

        updateTotalValue();
        checkEnableCheckOut()

    }

    displayCartItems();
</script>
@endsection