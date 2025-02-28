@extends('layouts.master-without-nav')
@section('title','Add Expire Date')
@section('css')

@endsection
@section('content')
<section class="product__stock__update1">
    {{-- nav start  --}}
    @include('layouts.header-section', [
    'title' => 'Add Expire Date',
    'subTitle' => '',
    ])
    {{-- nav end  --}}
    
        <input type="number" name="supplier_id" value="{{ $supplier_id }}" hidden>
        {{-- box start  --}}
        <div class=" font-jakarta flex items-center justify-center mt-20">
            <div>
                <div class="p-4 mb-4 text-sm text-white rounded-lg" role="alert" style="background-color: green" id="success-alert" hidden>
                    <span class="font-medium">Expire Date Added Successfully!</span>
                  </div>
                <div class="bg-white animate__animated animate__zoomIn mb-5  p-10 shadow-xl rounded-[20px]">
                    <div class="row items-center gap-10">
                        <div class="col-md-6">
                            <label for="product_name" class="block mb-2 font-jakarta text-left text-paraColor font-semibold text-sm">Product Name</label>
                            <input type="text" id="product_name" readonly
                            class="custom_input outline outline-1 text-sm font-semibold text-paraColor w-[300px] outline-primary px-4 py-2 rounded-full">
                        </div>
                        <div class="col-md-6 mt-3">
                            <label for="product_quantity" class="block mb-2 font-jakarta text-left text-paraColor font-semibold text-sm">Product Quantity</label>
                            <input type="text" id="product_quantity" readonly
                            class="custom_input outline outline-1 text-sm font-semibold text-paraColor w-[300px] outline-primary px-4 py-2 rounded-full">
                        </div>
                        <div class="col-md-6 mt-3">
                            <label for="expire_date" class="block mb-2 font-jakarta text-left text-paraColor font-semibold text-sm">Select Expire Date</label>
                            <input type="date" name="expire_date" id="expire_date" 
                            class="custom_input outline outline-1 text-sm font-semibold text-paraColor w-[300px] outline-primary px-4 py-2 rounded-full"
                            min="{{ $date }}">
                        </div>
                    </div>

                    <div class="flex flex-col md:items-center text-center md:text-left md:flex-row mt-10 md:justify-center gap-10">
                        <button class="text-sm bg-noti outline mx-auto md:mx-0 text-white outline-1 w-full outline-noti md:w-44 py-2 rounded-2xl" id="done" onclick="addQuantity()">Done</button>
                    </div>
                </div>

            </div>

        </div>
        {{-- box end  --}}


</section>
@endsection
@section('script')

<script>
    var localStorageName = 'productPurchaseCart';
    const productID = @json($id);

    var product = getLocalStorageData(localStorageName, productID);
    product = product ? product[0] : [];
    
    document.getElementById("product_name").value = product.product_name + ' (' + product.product_code + ')';
    document.getElementById("product_quantity").value = product.quantity;

    function addQuantity(){
        var expired_date = document.getElementById("expire_date").value;
        
        product.expire_date = expired_date;

        // localStorage.setItem(localStorageName, JSON.stringify(product));
        saveProductToLocalStorage(localStorageName, product);

        document.getElementById("success-alert").style.display = 'block';
    }
</script>

<script>
    function saveProductToLocalStorage(localStorageName, product) {
    
        const localStorageData = JSON.parse(localStorage.getItem(localStorageName)) || [];

        
        const updatedLocalStorageData = localStorageData.map(item => {
            if (item.product_id === product.product_id) {
                return product;
            }
            return item;
        });
        
        localStorage.setItem(localStorageName, JSON.stringify(updatedLocalStorageData));
    }
</script>
@endsection