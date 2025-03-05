@extends('layouts.master-without-nav')
@section('title', 'Purchase Create')

@section('css')
{{-- <link href="{{ asset('css/imei.css') }}" rel="stylesheet"> --}}

@endsection

@section('content')

<section class="add_imei">
    {{-- nav start  --}}
    @include('layouts.header-section', [
    'title' => 'Add IMEI Numbers',
    'subTitle' => 'Fill to add IMEI Number',
    ])
    {{-- nav end  --}}


    <div class="flex justify-center mt-10 font-poppins">
        <div class="bg-white relative rounded shadow-lg w-3/4">
            <div id="alert-container" class="  font-poppins text-sm font-semibold"> </div>
            <div class="px-8 py-6">
                <div class="flex items-center justify-between mb-5">
                    <h1 class="text-primary x  text-xl font-semibold">Add IMEI Numbers </h1>
                    <h1 class="text-sm text-white py-1 rounded-md bg-primary px-4">Remaining to Add : <span id="productCount"></span></h1>
                </div>
                <table class="w-full border d-outer text-center">
                    <thead class="">
                        <tr class="bg-bgMain text-[13px]">
                            <td class="px-4 py-2 border-r">Product Name</td>
                            <td class="px-4 py-2 border-r">Price</td>
                            <td class="px-4 py-2 border-r">IMEI Code</td>
                            <td class="px-4 py-2 border-r"></td>
                        </tr>
                    </thead>
                    <tbody class="text-[13px] text-center " id="d-outer">
                        {{-- <tr>

                        </tr> --}}
                    </tbody>
                </table>
                <button id="add-imei" class=" text-sm mt-5 font-light bg-primary text-white px-2 py-1 rounded-md" type="button">
                    <i class="fa-solid fa-plus"></i> Add
                </button>
            </div>
        </div>
    </div>


</section>

@endsection
@section('script')
<script>
    const localStorageName = 'productPurchaseCart';
    var imeiCounter = 1;
    const productID = @json($id);
    var product = getLocalStorageData(localStorageName, productID);
    product = product ? product[0] : [];

    // Retrieve the product count from localStorage, or use the initial quantity
    var storedProductCount = localStorage.getItem(`productCount_${productID}`);
    var productCount = storedProductCount !== null ? parseInt(storedProductCount) : product.quantity;
    $('#productCount').text(productCount);

    const storeProducts = localStorage.getItem(localStorageName);

    const products = JSON.parse(storeProducts);

    document.addEventListener("DOMContentLoaded", function() {
        var tbody = document.getElementById("d-outer");
        var addBtn = document.getElementById("add-imei");
        
        // Initial button state check
        toggleAddButton(productCount);

        addBtn.addEventListener("keydown", function(event) {
            if (event.key === "Enter") {
                event.preventDefault();
            }
        });
        
        //for page reload
        if (products && Array.isArray(products) && products.length > 0) {
            product.imei.forEach(function(item) {
                tbody.appendChild(addRow(product, item, imeiCounter, localStorageName));

                imeiCounter++;
            });
        }

        //for add button click event
        addBtn.addEventListener("click", function() {
            tbody.appendChild(addRow(product, null, imeiCounter, localStorageName));
            imeiCounter++;

        });

        //for scan imei number event
        addIMEI(product);

    });

    function toggleAddButton(count) {
        var addBtn = document.getElementById("add-imei");
        if (count === 0) {
            addBtn.classList.add('disabled');
            addBtn.setAttribute('disabled', true);
            addBtn.classList.add('opacity-50');
        } else {
            addBtn.classList.remove('disabled');
            addBtn.removeAttribute('disabled');
            addBtn.classList.remove('opacity-50');
        }
    }

    function addIMEI(product) {
        var scannedCode = '';

        document.addEventListener('keydown', function(event) {
            var isNumber = /^\d$/;

            if (isNumber.test(event.key)) {
                scannedCode += event.key;
            } else if (event.key === "Enter") {
                product = getLocalStorageData(localStorageName, productID);
                product = product ? product[0] : [];

                if (scannedCode !== '') {
                    if (getAllIMEINumbers(localStorageName).includes(parseInt(scannedCode))) {
                        alert('Already Added!.');
                    } else {
                        var currentInputElement = document.getElementById(`imeiNumber${imeiCounter - 1}`);

                        if (currentInputElement && (currentInputElement.textContent == null || currentInputElement.textContent == '')) {
                            currentInputElement.textContent = scannedCode;
                            product.imei.push(parseInt(scannedCode));

                            // Decrement the product count and update the display
                            productCount--;
                            $('#productCount').text(productCount);

                            // Store the updated product count in localStorage
                            localStorage.setItem(`productCount_${productID}`, productCount);

                            const index = products.findIndex(p => p.product_id === parseInt(productID));

                            if (index !== -1) {
                                products[index] = product;
                                localStorage.setItem(localStorageName, JSON.stringify(products));
                            }

                            // Re-check the button state after updating the count
                            toggleAddButton(productCount);
                        } else {
                            alert('Please Add One New !');
                        }
                    }
                    scannedCode = '';
                    return;
                }
            }
        });

    }
</script>

@endsection