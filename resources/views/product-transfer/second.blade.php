@extends('layouts.master-without-nav')
@section('title', 'Create Product Transfer')
@section('css')

@endsection
@section('content')
    @php
        use App\Constants\PrefixCodeID;
    @endphp
    <section class="product_transfer_create_second">
        {{-- nav start  --}}
        @include('layouts.header-section', [
            'title' => 'Create A New Product Transfer',
            'subTitle' => 'Fill to build a new Transfer',
        ])
        {{-- nav end  --}}
        <div class="font-poppins my-7 mx-5">
            <div class="grid grid-cols-1 lg:grid-cols-4 gap-10">
                <div class="col-span-1 lg:col-span-3">
                    {{--  search start   --}}
                    <div>
                        <label for="" class="text-primary font-semibold block mb-2 ">Product Search</label>
                        <div class="outline outline-1 outline-primary w-full flex items-center gap-5 rounded-md px-4 py-3 ">
                            <i class="fa-solid fa-magnifying-glass  text-primary"></i>
                            <input type="search" name="" id="" class="bg-transparent w-full outline-none ">
                        </div>
                    </div>
                    {{--  product cart start   --}}
                    <div class="mt-5">
                        <div class="flex items-center flex-wrap gap-2">
                            @foreach ($products as $product)
                                <div class="w-[250px]  border shadow-xl bg-white rounded-xl">
                                    <div class="px-4 py-5">
                                        <div>
                                            <img src="https://images.unsplash.com/photo-1700451761309-656bd9439443?w=500&auto=format&fit=crop&q=60&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxlZGl0b3JpYWwtZmVlZHwyNHx8fGVufDB8fHx8fA%3D%3D"
                                                class="h-[150px] object-contain mx-auto" alt="">
                                        </div>
                                        <div class="text-center mt-3  text-sm ">
                                            <h1 class="font-semibold mb-1">{{ $product->name }}</h1>
                                            <h1 class="text-primary mb-1">{{ $product->code }}</h1>
                                            <h1 class="text-paraColor mb-2">qty - {{ $product->quantity }}</h1>
                                            <button class="bg-primary text-white w-[100px] py-1 rounded-full" onclick="addToCard({{$product->id}})">Add</button>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                </div>
                {{--  cart start   --}}
                <div class="col-span-1">
                    <div class="bg-white relative h-screen">
                        <div class="px-5 py-5 relative">
                            <h1 class="text-noti text-center font-semibold text-sm mb-3">Transferred Products</h1>
                            <div class="grid grid-cols-2 text-xs">
                                <div class="flex flex-col gap-2 text-primary font-semibold">
                                    <h1>Transfer From </h1>
                                    <h1>Date </h1>
                                    <h1>Transfer To </h1>
                                </div>
                                <div class="flex flex-col gap-2  text-paraColor">
                                    <h1>{{ $data['from_location_name'] }}</h1>
                                    <h1>{{ $data['date'] }}</h1>
                                    <h1>{{ $data['to_location_name'] }}</h1>
                                </div>

                            </div>
                            {{--  table start   --}}
                            <div class="h-[300px] overflow-y-auto">
                                <table class="text-sm mt-5 w-full">
                                    <thead class="text-primary">
                                        <tr class="border-y">
                                            <td class="px-3 py-2 font-semibold text-left">Product Code</td>
                                            <td class="px-3 py-2 font-semibold text-center">Quantity</td>
                                        </tr>
                                    </thead>
                                    <tbody id="cartBody">
                                        
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="absolute bottom-0 right-0 left-0">
                            {{--  button start   --}}

                            <div class="flex items-center justify-center gap-5 mb-5 ">
                                <button
                                    class="outline outline-1 outline-primary text-primary text-sm px-5 rounded-full py-1">
                                    <i class="fa-solid fa-arrow-left-long text-primary mr-3"></i>
                                    Back
                                </button>
                                <button
                                    class="outline outline-1 outline-primary bg-primary text-white text-sm px-5 rounded-full py-1">
                                    <i class="fa-solid fa-check text-white mr-3"></i>
                                    Done
                                </button>
                            </div>

                            <div class="bg-primary text-white  text-sm px-3 py-2">
                                <div class="flex items-center mb-2 ">
                                    <h1 class="mr-[40px]">Total Quantity</h1>
                                    <h1 class="font-semibold">2</h1>
                                </div>
                                <div class="flex items-center ">
                                    <h1 class="mr-[43px]">Total Amount</h1>
                                    <h1 class="font-semibold">20,000 MMK</h1>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

    </section>
@endsection
@section('script')
<script>
    function addToCard(productId) {

        console.log(productId);

        displayCartItems();
    }

    function displayCartItems() {
        //alert('hello')
        const tableBody = document.getElementById('cartBody');
        const selectedProductsInput = document.getElementById('selectedProducts');

        tableBody.innerHTML = `
                <tr>
                <td class="px-3 py-2 text-paraColor font-semibold ">ST-1234</td>
                <td class="text-center ">
                    <button class="mr-3">-</button>
                    <button class="bg-primary mr-3 rounded-md text-white px-2 py-1">2</button>
                    <button>+</button>
                </td>
                </tr>
                `;

        const cartItems = localStorage.getItem('productPurchaseCart');

        if (cartItems) {
            const items = JSON.parse(cartItems);

            items.forEach(function(item) {
                const row = document.createElement('tr');

                row.innerHTML = `
                <tr>
                <td class="px-3 py-2 text-paraColor font-semibold ">ST-1234</td>
                <td class="text-center ">
                    <button class="mr-3">-</button>
                    <button class="bg-primary mr-3 rounded-md text-white px-2 py-1">2</button>
                    <button>+</button>
                </td>
                </tr>
                `;
                console.log('hello');
                tableBody.appendChild(row);
            });

            updateTotalValue();
            checkEnableCheckOut();
            selectedProductsInput.value = JSON.stringify(items);
        } else {
            selectedProductsInput.value = [];
        }


    }
</script>
@endsection
