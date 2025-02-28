@extends('layouts.master-without-nav')
@section('title', 'Product Return Create')

@section('css')
<link href="{{ asset('css/imei.css') }}" rel="stylesheet">
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
            <div class="px-8 py-6 ">
                <div class="flex items-center justify-between mb-5">
                    <h1 class="text-primary x  text-xl font-semibold">Add IMEI Numbers </h1>
                    <h1 class="text-sm text-white py-1 rounded-md bg-primary px-4 ml-3" id="productCount"></h1>
                </div>

                <table class="w-full border d-outer text-center">
                    <thead class="">
                        <tr class="bg-bgMain text-[13px]">
                            <td class="px-5 py-2 border-r">Product Name</td>
                            <td class="px-5 py-2 border-r">Wholesale Price</td>
                            <td class="px-5 py-2 border-r">Retail price</td>
                            <td class="px-5 py-2 border-r">IMEI Code</td>
                            <td class="px-4 py-2 border-r"></td>
                        </tr>
                    </thead>
                    <tbody class="text-[13px] text-center " id="d-outer">
                        <tr>

                        </tr>
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
    var imei_arr = @json($imei_product_arr);

    var productData = @json($product);

    const productID = productData.id;

    const localStorageName = 'productTransferCart';

    var imeiCounter = 1;

    const storeProducts = localStorage.getItem(localStorageName);

    const products = JSON.parse(storeProducts);

    var product = getLocalStorageData(localStorageName, productID);

    product = product ? product[0] : [];

    $('#productCount').text('Count : ' + product.quantity);

    document.addEventListener("DOMContentLoaded", function() {

        var tbody = document.getElementById("d-outer");

        var addBtn = document.getElementById("add-imei");

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
        scanIMEICode(product, productID, products);

    });
</script>

@endsection