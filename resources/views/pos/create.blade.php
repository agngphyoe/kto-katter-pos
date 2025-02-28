@extends('layouts.master-without-nav')
@section('title', 'Create POS Order')
@section('css')
    <link href="{{ asset('css/imei.css') }}" rel="stylesheet">
    <link href="{{ asset('css/toastr.css') }}" rel="stylesheet">
    <style>
        .cart-side-bar {
            position: fixed;
            top: 0;
            right: 0;
            /* Set this to 0 to make it visible by default */
            transition: right 0.5s ease-in-out;
        }

        .loading-spinner .spinner {
            border: 4px solid #EA7F03;
            border-left-color: #4CAF50;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            animation: spin 1s linear infinite;
            margin: 0 auto;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        /* Optional: Style the loading text */
        .loading-spinner p {
            font-weight: bold;
            margin-top: 50;
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

@endsection
@section('content')
    <section class="container-fluid" style="max-width: 77%";>

        {{-- <div class="lg:mx-[20px] my-7 mx-[10px]" style="max-width: 80%;"> --}}

        {{--  search start --}}
        <div class=" ">

            <div class="flex items-center px-12 mb-4 gap-3 mt-2">

                <a href="{{ route('pos-list') }}">
                    <button onclick="" class="outline shrink-0 outline-1 bg-primary text-white w-9 h-9 rounded-full"
                        id="back_btn">
                        <i class="fa-solid fa-arrow-left text-lg"></i>
                    </button>
                </a>

                <div
                    class="flex items-center outline outline-1 outline-primary bg-white w-[330px] rounded-full px-4 py-[7px]">
                    <input type="search" class="outline-none w-full font-poppins text-inter  outline-transparent"
                        placeholder="Search or Scan here" id="search_product_input">

                    <i class="fa-solid fa-magnifying-glass text-primary "></i>
                </div>

                {{-- <div class="fixed top-24 z-50 right-14">
                        <div class="bg-primary rounded-full w-12 h-12 outline outline-1 outline-primary flex items-center justify-center relative shadow-lg cursor-pointer"
                            id="cart-btn" onclick="toggleCart()">
                            <i class="fa-solid fa-cart-plus  text-white text-lg"></i>
                            <h1 class="w-5 h-5 font-poppins flex items-center justify-center absolute -top-2 -right-1 bg-red-600 text-white rounded-full text-[10px] font-medium"
                                id="cart_count">0</h1>
                        </div>
                    </div> --}}
                {{-- location select --}}
            </div>



        </div>

        {{--  search end  --}}


        {{-- product cart start  --}}
        <form action="{{ route('pos-create-final') }}" method="POST" id="myForm">
            @csrf
            <input name="order_products" id="selectedProductsInput" hidden>
            <input name="total_order_net_amount" id="total_order_net_amount_input" hidden>
            <input name="total_order_quantity" id="total_order_quantity_input" hidden>
            <input name="location_id" id="location_id" value="{{ $retailLocation_id }}" hidden>

        </form>

        {{-- cart start  --}}
        <div class="flex items-center relative justify-start pl-10 gap-10 flex-wrap" id="cart_div">

            @include('pos.search-product-create')

        </div>
        {{-- cart end --}}
        {{-- product cart end --}}

        {{-- </div> --}}

        <div class="cart-side-bar z-50" id="cartSidebar">
            <div
                class="bg-white relative h-screen md:max-h-screen shadow-2xl w-[350px] font-jakarta px-5 py-8 flex flex-col">
                <div class="flex items-center justify-center mb-5">
                    <h1 class="text-center font-semibold text-primary">Order Products</h1>
                </div>

                <!-- Make this section grow to fill available space -->
                <div class="overflow-x-auto flex-1 overflow-y-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="border-r bg-bgMain text-sm font-medium">
                                <td class="px-2 py-2">Name</td>
                                <td class="px-2 py-2">Quantity</td>
                                <td class="px-2 py-2">Actions</td>
                            </tr>
                        </thead>
                        <tbody id="orderCartContainer">
                            <!-- Product rows will be appended here -->
                        </tbody>
                    </table>
                </div>

                <div class="font-poppins pt-5">
                    <div class="outline-1 my-5 outline-noti outline-dashed"></div>
                    <div class="flex items-center justify-between pt-3 mb-3">
                        <h1 class="text-noti text-xs font-medium">Total Amount</h1>
                        <h1 class="text-paraColor text-xs font-medium" id="total_order_net_amount"></h1>
                    </div>
                    <div class="flex items-center justify-between mb-3">
                        <h1 class="text-noti text-xs font-medium">Total Quantity</h1>
                        <h1 class="text-paraColor text-xs font-medium" id="total_order_quantity"></h1>
                    </div>
                    <div>
                        <!-- Updated button styles -->
                        <button class="bg-noti text-white text-sm rounded-full font-semibold py-2 w-full sm:w-auto sm:px-10"
                            onclick="checkProductData()">Check Out</button>
                    </div>
                    <span id="showInvalidMessage" class="px-7"></span>
                </div>
            </div>
        </div>
        {{-- cart end --}}
        <!-- Bootstrap Modal -->

    </section>
@endsection

@section('script')
    <script src="{{ asset('js/toastr.js') }}"></script>

    <script>
        $(document).ready(function() {
            handleReload();
        });
    </script>
    <script>
        function updateCartCount() {
            var selectedProducts = JSON.parse(localStorage.getItem('selectedProductsForPOS'));
            if (selectedProducts) {
                $('#cart_count').text(selectedProducts.length);
            }

        }
    </script>

    <script>
        {{--  const handleScroll = () => {
            const scrolled = window.scrollY;
            // console.log(scrolled);
            const backButton = document.getElementById("back-button");
            const title = document.getElementById("title");
            if (scrolled === 0) {
                backButton.style.display = "none";
                title.style.display = "none";
            }
            if (scrolled > 110) {
                backButton.style.display = "block";
                title.style.display = "block";
            }

        }
        window.addEventListener("scroll", handleScroll);  --}}

        function handleReload() {

            updateCartCount();
            var selectedProducts = JSON.parse(localStorage.getItem('selectedProductsForPOS'));

            if (selectedProducts && selectedProducts.length > 0) {
                displaySelectedProducts();
                updateTotalAmountAndQuantity();
            }

            if (selectedProducts) {
                selectedProducts.forEach(item => {
                    const orderQuantityElement = document.getElementById('order_quantity' + item
                        .product_id);

                    if (orderQuantityElement) {
                        orderQuantityElement.value = item.order_quantity;
                    }
                });
            }

        }

        function updateTotalAmountAndQuantity() {

            var selectedProducts = JSON.parse(localStorage.getItem('selectedProductsForPOS'));
            var total_order_net_amount = 0;
            var total_order_quantity = 0;
            if (selectedProducts && selectedProducts.length > 0) {

                selectedProducts.forEach(product => {
                    total_order_net_amount += parseInt(product.unit_price * product.order_quantity);
                    total_order_quantity += parseInt(product.order_quantity);
                });
            }
            localStorage.setItem('totalAmountForPOSOrder', total_order_net_amount);
            localStorage.setItem('totalOrderQuantityForPOSOrder', total_order_quantity);
            localStorage.setItem('net_amount', total_order_net_amount);

            var total_order_net_amount = localStorage.getItem('totalAmountForPOSOrder');
            var total_order_quantity = localStorage.getItem('totalOrderQuantityForPOSOrder');

            document.getElementById('total_order_net_amount').textContent = Number(total_order_net_amount).toLocaleString();
            document.getElementById('total_order_quantity').textContent = Number(total_order_quantity).toLocaleString();

        };

        // product card
        function displaySelectedProducts() {
            var products = JSON.parse(localStorage.getItem('selectedProductsForPOS'));

            updateTotalAmountAndQuantity();
            var orderCartContainer = document.getElementById('orderCartContainer');
            orderCartContainer.innerHTML = '';

            if (products && products.length > 0) {
                products.forEach(function(product) {
                    var imeiDisplay = product.imei && product.imei.length > 0 ? product.imei.join('<br>') : '';

                    orderCartContainer.innerHTML += `
                <tr class="border-b">
                    <td class="text-paraColor px-2 py-2 text-sm ">
                        <h1 class="text-paraColor text-xs">${product.product_code}</h1>
                        <span class="text-noti text-xs">${imeiDisplay}</span>
                        ${product.isIMEI === 1 ? `
                                                                                <div class="imei-group font-poppins mt-1">
                                                                                    <div class="bg-primary text-white w-5 h-5 flex items-center justify-center rounded-full">
                                                                                        <a href="/pos/${product.product_id}/add-imei-manual" class="open-modal" data-product-id="${product.id}">
                                                                                            <i class="fa-solid fa-plus text-sm"></i>
                                                                                        </a>
                                                                                    </div>
                                                                                </div>` : ''}
                    </td>
                    <td class="px-2 py-2">
                        <div class="flex items-center">
                            <button class="text-noti" onclick="increaseQuantity(this, ${product.id})">
                                <i class="fa-solid fa-plus text-sm"></i>
                            </button>
                            <input type="number" class="outline-none text-sm w-16 text-center pl-2 text-noti py-[1px]"
                                name="order_quantity" id="order_quantity${product.id}" value='${product.order_quantity}' min="0" oninput="limitMaxValueForOrderCart(this, ${product.id}, ${product.total_stock_qty})">
                            <button class="text-noti" onclick="decreaseQuantity(this, ${product.id})">
                                <i class="fa-solid fa-minus text-sm"></i>
                            </button>
                        </div>
                    </td>
                    <td class="px-2 py-2">
                        <i class="fa-solid fa-trash text-sm text-red-600 px-4 py-2" onclick="deleteProductInCart('selectedProductsForOrder', ${product.id})" style="cursor:pointer"></i>
                    </td>
                </tr>
            `;
                });
            }
        }


        // limit max value for order cart
        function limitMaxValueForOrderCart(input, id, maxQuantity) {
            var order_quantity = input.value;

            if (order_quantity > maxQuantity) {
                // The entered quantity exceeds the purchased_quantity, show the default error message
                input.value = '';

                displaySelectedProducts();
            }

        }

        function decreaseQuantity(button, index) {
            var minQuantity = 1;
            var currentQuantityElement = document.getElementById('order_quantity' + index);
            var currentQuantity = parseInt(currentQuantityElement.value);

            if (currentQuantity > 1) {
                currentQuantityElement.value = currentQuantity - 1;
                localStorage.setItem(`productCount_${index}`, currentQuantityElement.value);
                updateLocalStorageQuantity(index, currentQuantityElement.value);
            } else {
                var deleteButton = document.getElementById("deleteButton" + index);
                deleteProductInCart('selectedProductsForOrder', index);
            }
        }

        function increaseQuantity(button, index) {
            var maxQuantity = document.getElementById('maxStock' + index).value;

            var currentQuantityElement = document.getElementById('order_quantity' + index);
            var currentQuantity = parseInt(currentQuantityElement.value);

            if (currentQuantity < maxQuantity) {
                currentQuantityElement.value = currentQuantity + 1;
                localStorage.setItem(`productCount_${index}`, currentQuantityElement.value);
                updateLocalStorageQuantity(index, currentQuantityElement.value);
            } else {
                button.classList.add("disabled");
            }
        }

        function addToCart(index) {
            var currentQuantity = parseInt(document.getElementById('order_quantity' + index).value);
            var isIMEI = parseInt(document.getElementById('isIMEI' + index).value);
            var imei_number = document.getElementById('search_product_input').value.trim();

            var selectedProducts = JSON.parse(localStorage.getItem('selectedProductsForPOS')) || [];

            var imeiValid = Number.isInteger(Number(imei_number)) && imei_number.length === 15;

            var existingProductIndex = selectedProducts.findIndex(function(product) {
                return product.product_id === index;
            });

            var imei_array = [];
            if (isIMEI === 1 && imeiValid) {
                if (existingProductIndex !== -1 && selectedProducts[existingProductIndex].imei) {
                    imei_array = selectedProducts[existingProductIndex].imei;
                }

                if (!imei_array.includes(imei_number)) {
                    imei_array.push(imei_number);
                }
            }

            if (currentQuantity > 0) {
                var unit_price = parseInt(document.getElementById('unit_price' + index).textContent.replace(/,/g, ""));
                var cashbackElement = document.getElementById('cashback_price' + index);
                if (cashbackElement) {
                    var cashback_price = parseInt(cashbackElement.textContent.replace(/[^0-9]/g, ''));
                    unit_price = unit_price - cashback_price;
                } 
                var total_amount = currentQuantity * unit_price;

                var product = {
                    id: index,
                    product_id: index,
                    product_code: document.getElementById('product_code' + index).textContent,
                    product_stock: document.getElementById('product_stock' + index).textContent,
                    order_quantity: currentQuantity,
                    unit_price: unit_price,
                    total_amount: total_amount,
                    is_promoted: parseInt(document.getElementById('is_promoted' + index).value),
                    promotion_id: parseInt(document.getElementById('promotion_id' + index).value),
                    cashback_price: cashback_price,
                    isIMEI: isIMEI,
                    imei: imei_array,
                };

                if (existingProductIndex === -1) {
                    selectedProducts.push(product);
                } else {
                    selectedProducts[existingProductIndex] = product;
                }

                localStorage.setItem('selectedProductsForPOS', JSON.stringify(selectedProducts));
                localStorage.setItem(`productCount_${index}`, currentQuantity);
            }

            displaySelectedProducts();
            updateTotalAmountAndQuantity();
            handleReload();
        }



        function updateLocalStorageQuantity(id, quantity) {
            var products = JSON.parse(localStorage.getItem('selectedProductsForPOS'));

            if (products && products.length > 0) {

                for (var i = 0; i < products.length; i++) {
                    if (products[i].id == id) {
                        products[i].order_quantity = quantity;
                    }
                }

            }

            localStorage.setItem('selectedProductsForPOS', JSON.stringify(products));


            displaySelectedProducts();
            updateTotalAmountAndQuantity();
        }
    </script>

    {{-- navigate to final view --}}
    <script>
        function navigateToFinalView() {
            const storedData = JSON.parse(localStorage.getItem('selectedProductsForPOS'));
            if (storedData && Array.isArray(storedData)) {
                var order_product = storedData.map(function(data) {
                    return {
                        product_id: data.id,
                        product_code: data.product_code,
                        order_quantity: data.order_quantity,
                        unit_price: data.unit_price,
                        cashback_price: data.cashback_price,
                        total_amount: data.total_amount
                    };
                });
            }
            document.getElementById('selectedProductsInput').value = JSON.stringify(order_product);

            var total_order_net_amount = localStorage.getItem('totalNetAmountForCreateOrder');
            var total_order_quantity = localStorage.getItem('totalOrderQuantityForCreateOrder');

            document.getElementById('total_order_net_amount_input').value = JSON.stringify(total_order_net_amount);
            document.getElementById('total_order_quantity_input').value = JSON.stringify(total_order_quantity);
            if (storedData.length > 0) {
                document.getElementById("myForm").submit();
            }
        }
    </script>

    {{-- limit the quantity input product stock quantity --}}
    <script>
        $('[name="order_quantity"]').on('input', function() {
            var product_id = $(this).data('product-id');

            var order_quantity_input_value = $(this).val();
            var max_stock_quantity = $(this).data('max-value');

            if (order_quantity_input_value > max_stock_quantity) {
                $(this).val('');
            }


        });
    </script>

    <script>
        $('#search_product_input').on('input', function() {
            var searchInput = $(this).val();
            $.ajax({
                url: "{{ route('pos-create-search') }}",
                method: "GET",
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                },
                data: {
                    search: searchInput,
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
    </script>

    <script>
        // function toggleCart() {
        //     const sidebar = document.getElementById("cartSidebar");
        //     if (sidebar.style.right === "0") {
        //         sidebar.style.right = "-350px";
        //     } else {
        //         sidebar.style.right = "0";
        //     }
        // }

        // function closeCart() {
        //     const sidebar = document.getElementById("cartSidebar");
        //     if (sidebar.style.right === "-350px") {
        //         sidebar.style.right = "0";
        //     } else {
        //         sidebar.style.right = "-350px";
        //     }
        // }
        {{--  const cartBtn=document.getElementById("cart-btn");
        document.addEventListener("click", function(event) {
            if (!cartBtn.contains(event.target)) {
             closeCart();
            }

          });  --}}
    </script>

    {{-- delete product in cart --}}
    <script>
        function deleteProductInCart(localStorageName, productId) {
            let productsArray = JSON.parse(localStorage.getItem('selectedProductsForPOS')) || [];

            productsArray = productsArray.filter(
                (item) => item.id !== productId
            );

            localStorage.setItem('selectedProductsForPOS', JSON.stringify(productsArray));

            displaySelectedProducts();
            $('#order_quantity' + productId).val(0);
            localStorage.removeItem(`productCount_${productId}`);
            updateCartCount();
        }
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var hostnameWithPort = window.location.hostname + (window.location.port ? ':' + window.location.port :
                '');
            var previousRoute = "{{ url()->previous() }}";

            var normalizedPreviousRoute = previousRoute.replace(/\/$/, '');

            if (normalizedPreviousRoute === 'http://' + hostnameWithPort + '/pos/create-final' ||
                normalizedPreviousRoute === 'https://' + hostnameWithPort + '/pos/create-final') {
                localStorage.clear();
            }
        });
    </script>

    <script>
        // Show the spinner when loading starts
        function showLoadingSpinner() {
            document.getElementById('loadingSpinner').style.display = 'block';
        }

        // Hide the spinner when loading is done
        function hideLoadingSpinner() {
            document.getElementById('loadingSpinner').style.display = 'none';
        }

        // Example usage when making an AJAX request or loading products
        showLoadingSpinner();

        // After products are loaded
        hideLoadingSpinner();
    </script>

    {{-- <script>
        document.getElementById('submitImei').addEventListener('click', function () {
            let imeiNumber = document.getElementById('imeiNumber').value;
            let productId = document.getElementById('productId').value;

            if (imeiNumber) {
                // Process IMEI number (you can modify this part to handle IMEI saving logic)
                console.log('IMEI:', imeiNumber, 'Product ID:', productId);

                // Add IMEI to product in localStorage (adjust logic as needed)
                let selectedProducts = JSON.parse(localStorage.getItem('selectedProductsForPOS')) || [];
                selectedProducts.forEach(function(product) {
                    if (product.id == productId) {
                        if (!product.imei) product.imei = [];
                        product.imei.push(imeiNumber);
                    }
                });
                localStorage.setItem('selectedProductsForPOS', JSON.stringify(selectedProducts));

                // Refresh cart display
                displaySelectedProducts();

                // Close modal
                let myModalEl = document.getElementById('addImeiModal');
                let modal = bootstrap.Modal.getInstance(myModalEl);
                modal.hide();
            } else {
                alert('Please enter a valid IMEI number.');
            }
        });
</script> --}}
    <script>
        function checkProductData() {
            let isValid = true;

            var items = localStorage.getItem('selectedProductsForPOS');
            console.log(items);
            var invalidMessage = document.getElementById("showInvalidMessage");

            if (items && JSON.parse(items).length > 0) {
                JSON.parse(items).forEach((item) => {
                    let {
                        order_quantity,
                        imei,
                        isIMEI
                    } = item;
                    order_quantity = parseInt(order_quantity);
                    if (isIMEI && order_quantity !== imei.length) {
                        isValid = false;

                    }
                });

                if (isValid) {
                    navigateToFinalView();
                } else {
                    invalidMessage.classList.add("text-red-600", "text-xs");
                    invalidMessage.textContent =
                        "* Must be same quantity and IMEI Count";
                }
            } else {
                invalidMessage.classList.add("text-red-600", "text-sm");
                invalidMessage.textContent =
                    "* Cart has No Products !";
            }
        }
    </script>
@endsection
