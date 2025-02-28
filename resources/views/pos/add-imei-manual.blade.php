@extends('layouts.master-without-nav')
@section('title', 'Purchase Create')

@section('css')
<link href="{{ asset('css/imei.css') }}" rel="stylesheet">
<style>
    .error-message {
        color: red;
        font-size: 12px;
        margin-top: 5px;
    }

    input.border-red-500 {
        border-color: red;
    }
</style>
@endsection

@section('content')

<section class="add_imei">
    <div class="flex justify-center mt-10 font-poppins">
        <div class="bg-white relative rounded shadow-lg w-3/4">
            <div id="alert-container" class="  font-poppins text-sm font-semibold"> </div>
            <div class="px-8 py-6">
                <div class="flex items-center justify-between mb-5">
                    <h1 class="text-primary x  text-xl font-semibold">Add IMEI Numbers With Manual</h1>
                    <h1 class="text-sm text-white py-1 rounded-md bg-primary px-4">Total Purchases : <span id="productCount"></span></h1>
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
                <button id="checkBtn" class="text-sm mt-5 font-light bg-primary text-white px-2 py-1 rounded-md" type="button">
                    <i class="fa-solid fa-check"></i> Check
                </button>
                <a href="{{ url()->previous() }}">
                    <button id="goBackBtn" class=" text-sm mt-5 font-light bg-noti text-white px-2 py-1 rounded-md opacity-50 cursor-not-allowed" type="button" disabled>
                        Done
                    </button>
                </a>
                
            </div>
        </div>
    </div>

</section>

@endsection

@section('script')
{{-- <script>
    document.getElementById("goBackBtn").addEventListener("click", function() {
        window.history.back();
    });
</script> --}}

<script>
    document.getElementById("checkBtn").addEventListener("click", function() {
    
    const productID = @json($id);
    var imeiData = [];
    var imeiInputs = document.querySelectorAll('input[name="imei_number[]"]');
    
    imeiInputs.forEach(function(input) {
        if (input.value.trim() !== "") {
            imeiData.push(input.value.trim());
        }
    });

    imeiInputs.forEach(function(input) {
        const errorSpan = input.parentElement.querySelector('.error-message');
        if (errorSpan) errorSpan.remove(); // Remove the previous error message
        input.classList.remove('border-red-500'); // Remove error highlight
    });

    fetch(`/pos/${productID}/pos-validate-imei`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({ 
            imei: imeiData,
            product_id: productID
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('All IMEI numbers are valid!');
            const doneBtn = document.getElementById('goBackBtn');
            doneBtn.disabled = false;   
            doneBtn.classList.remove('opacity-50', 'cursor-not-allowed');

            const localStorageName = 'selectedProductsForPOS';
            const storedProducts = JSON.parse(localStorage.getItem(localStorageName)) || [];

            const productIndex = storedProducts.findIndex(product => product.id === parseInt(productID));
            
            if (productIndex !== -1) {
                storedProducts[productIndex].imei = storedProducts[productIndex].imei || [];
                storedProducts[productIndex].imei.push(...imeiData.filter(imei => !storedProducts[productIndex].imei.includes(imei))); // Avoid duplicates
            } else {
                storedProducts.push({
                    id: productID,
                    imei: imeiData
                });
            }

            localStorage.setItem(localStorageName, JSON.stringify(storedProducts));
        } else {
            for (const [index, errorMessage] of Object.entries(data.errors)) {
                var inputField = imeiInputs[index];
                
                var errorSpan = document.createElement("span");
                errorSpan.classList.add('error-message', 'text-red-500', 'text-xs', 'mt-1', 'block');
                errorSpan.textContent = errorMessage;

                inputField.parentElement.appendChild(errorSpan);
                
                inputField.classList.add('border-red-500');
            }
        }
    })
    .catch(error => {
        console.error('Error:', error);
    });
});
</script>
<script>
    const localStorageName = 'selectedProductsForPOS';
    var imeiCounter = 1;
    const productID = @json($id);
    var imei_arr = @json($imei_product_arr);
    var product = getLocalStorageData(localStorageName, productID);
    product = product ? product[0] : [];

    // Retrieve the product count from localStorage, or use the initial quantity
    var storedProductCount = localStorage.getItem(`productCount_${productID}`);
    var productCount = parseInt(storedProductCount); 
    $('#productCount').text(productCount);

    const storeProducts = localStorage.getItem(localStorageName);

    const products = JSON.parse(storeProducts);

    document.addEventListener("DOMContentLoaded", function() {
        var tbody = document.getElementById("d-outer");
        var addBtn = document.getElementById("add-imei");
        
        // Initial button state check
        // toggleAddButton(productCount);

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
        // addIMEI(product);
        scanIMEICode(product, productID, products);

    });

    // function toggleAddButton(count) {
    //     var addBtn = document.getElementById("add-imei");
    //     if (count === 0) {
    //         addBtn.classList.add('disabled');
    //         addBtn.setAttribute('disabled', true);
    //         addBtn.classList.add('opacity-50');
    //     } else {
    //         addBtn.classList.remove('disabled');
    //         addBtn.removeAttribute('disabled');
    //         addBtn.classList.remove('opacity-50');
    //     }
    // }

    function scanIMEICode(product, productID, products) {
        var scannedCode = "";

        document.addEventListener("keydown", function (event) {
            var isNumber = /^\d$/;

            if (isNumber.test(event.key)) {
                scannedCode += event.key;
            } else if (event.key === "Enter") {
                product = getLocalStorageData(localStorageName, productID);

                product = product ? product[0] : [];

                if (scannedCode !== "") {
                    if (getAllIMEINumbers(localStorageName).includes(scannedCode)) 
                    {
                        showAlert("Already Added!.");
                    } else {
                        var currentInputElement = document.getElementById(
                            `imeiNumber${imeiCounter - 1}`
                        );

                        if (currentInputElement && (currentInputElement.textContent == null || currentInputElement.textContent == ""))
                        {
                            if (imei_arr.includes(scannedCode)) {
                                
                                currentInputElement.textContent = scannedCode;

                                product.imei.push(scannedCode);

                                const index = products.findIndex(
                                    (item) =>  item.id === parseInt(productID) ||
                                    item.product_id === parseInt(productID)
                                );
                                    
                                if (index !== -1) {
                                    products[index] = product;
                                    
                                    localStorage.setItem(
                                        localStorageName,
                                        JSON.stringify(products)
                                    );
                                }
                            } else {
                                showAlert(
                                    "Not Found IMEI Number.Please Try Again."
                                );
                            }
                        } else {
                            showAlert("Please Add One New !");
                        }
                    }

                    scannedCode = "";

                    return;
                }
            }
        });
    }

    function addRow(product, imei = null, counter, localStorageName) {
        var row = document.createElement("tr");
        row.classList.add("border-b");
        var imeiId = `imeiNumber${counter}`;
        const name = product.product_code;
        const id = product.id || product.product_id;
        const rprice = product.unit_price;

        row.innerHTML = `
        <td class="px-4 py-2 border-r h-7 whitespace-nowrap">${name}</td>
        <td class="px-4 py-2 border-r h-7 whitespace-nowrap">${Number(rprice).toLocaleString()}</td>
        <td class="px-4 py-2 border-r h-7 whitespace-nowrap">
            <input type="number" id="${imeiId}" name="imei_number[]" value="${imei || ""}" class="imei-input px-2 py-1 border rounded w-full" />
        </td>
        <td class="px-4 py-2 border-r h-7 whitespace-nowrap">
            <button onclick="removeRow(this,'${imeiId}','${id}','${localStorageName}')" class="btn-remove">
                <i class="fa-solid fa-minus bg-red-600 text-white p-1 rounded-full"></i>
            </button>
        </td>`;

        return row;
    }

    function removeRow(removeBtn, imeiId, productID, localStorageName) {
        const storeProducts = localStorage.getItem(localStorageName);

        const products = JSON.parse(storeProducts);

        var product = products.filter(function (item) {
            return (
                item.id === parseInt(productID) ||
                item.product_id === parseInt(productID)
            );
        });
        if (product.length === 0) {
            console.error("Product not found");
            return;
        }

        var imei = document.getElementById(imeiId).value;

        var updateIMEI = product[0].imei.filter(function (item) {
            return item !== imei;
        });

        var productIndex = products.findIndex(function (item) {
            return (
                item.id === parseInt(productID) ||
                item.product_id === parseInt(productID)
            );
        });

        if (productIndex !== -1) {
            products[productIndex].imei = updateIMEI;
            localStorage.setItem(localStorageName, JSON.stringify(products));
        }

        removeBtn.closest("tr").remove();

    }

    function getAllIMEINumbers(localStorageName) {
        const storeData = localStorage.getItem(localStorageName);

        const products = JSON.parse(storeData);

        const allIMEI = [];

        products.forEach((product) => {
            allIMEI.push(...product.imei);
        });

        return allIMEI;
    }
</script>
@endsection