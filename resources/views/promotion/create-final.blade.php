@extends('layouts.master-without-nav')
@section('title', 'Create Discount Promotion')
@section('css')

@endsection
@section('content')
    <section class="promotion__create__final">
        {{-- nav start  --}}
        @include('layouts.header-section', [
            'title' => 'Promotion Details',
            'subTitle' => '',
        ])
        {{-- nav end  --}}

        <div class="m-5 lg:m-7">
            <div class="bg-white shadow-xl mb-[30px] rounded-[20px] p-4 sm:p-6 ">
                <h1 class="font-jakarta text-noti font-semibold mb-3">Promotion Details</h1>

                <table class="w-full  text-sm text-center text-gray-500 ">

                    <tr class="bg-white border-b ">

                        <td class="px-6 py-2 whitespace-nowrap">
                            <div class="flex items-center gap-7">
                                <div>
                                    Promo Code
                                </div>
                                <h1 class="font-bold">{{ session('promo_code') }}</h1>
                            </div>
                        </td>
                        <td class="px-6 py-2 whitespace-nowrap">
                            <div class="flex items-center gap-13">
                                <div>
                                    Discount
                                </div>
                                <h1 class="font-bold">
                                    @if (session('promo_type') == 'cashback')
                                        Cashback
                                    @elseif (session('promo_type') == 'dis_percentage')
                                        {{ session('value') }} %
                                    @else
                                        {{ session('value') }} MMK
                                    @endif
                                </h1>
                            </div>
                        </td>

                        <td class="px-6 py-2 whitespace-nowrap ">
                            <div class="flex items-center gap-8">
                                <div>
                                    Locations
                                </div>
                                <h1 class="font-bold">{{ wrapText($locationData, 27) }}</h1>
                            </div>

                        </td>

                    </tr>

                    <tr class="bg-white border-b ">

                        <td class="px-6 py-2 whitespace-nowrap">
                            <div class="flex items-center gap-8">
                                <div>
                                    Promo Title
                                </div>
                                <h1 class="font-bold">{{ session('title') }}</h1>
                            </div>
                        </td>
                        <td class="px-6 py-2 whitespace-nowrap ">
                            <div class="flex items-center gap-12">
                                <div>
                                    Variant
                                </div>
                                <h1 class="font-bold ml-3">
                                    @if (session('variant') == 'time-quantity')
                                        Time + Quantity
                                    @else
                                        Time
                                    @endif
                                </h1>
                            </div>

                        </td>
                        <td class="px-6 py-2 whitespace-nowrap ">
                            <div class="flex items-center gap-7">
                                <div>
                                    Created By
                                </div>
                                <h1 class="font-bold">{{ auth()->user()->name }}</h1>
                            </div>

                        </td>

                    </tr>

                    <tr class="bg-white border-b ">

                        <td class="px-6 py-2 whitespace-nowrap">
                            <div class="flex items-center gap-7">
                                <div>
                                    Promo Type
                                </div>
                                <h1 class="font-bold">
                                    @if (session('promo_type') == 'dis_percentage')
                                        Discount (%)
                                    @elseif(session('promo_type') == 'dis_price')
                                        Discount (Price)
                                    @else
                                        Cashback
                                    @endif
                                </h1>
                            </div>
                        </td>
                        <td class="px-6 py-2 whitespace-nowrap ">
                            <div class="flex items-center gap-6">
                                <div>
                                    Starting Date
                                </div>
                                <h1 class="font-bold">{{ dateFormat(session('start_date')) }} </h1>
                            </div>

                        </td>
                        <td class="px-6 py-2 whitespace-nowrap ">
                            <div class="flex items-center gap-5">
                                <div>
                                    Ending Date
                                </div>
                                <h1 class="font-bold">{{ dateFormat(session('end_date')) }} </h1>
                            </div>

                        </td>

                    </tr>

                </table>

            </div>

            {{-- table start  --}}
            <div class="data-table mt-5">
                <div class="  bg-white px-4 py-2 font-poppins rounded-[20px]  ">
                    <h1 class="font-jakarta text-noti font-semibold mb-3 mt-2">Promotion Details</h1>
                    <div>
                        <div class="relative overflow-y-auto shadow-lg  overflow-x-auto  ">
                            <table class="w-full text-sm  text-gray-500 ">
                                <thead class="text-sm font-jakarta  text-primary  bg-gray-50 ">
                                    @if (session('variant') == 'time-quantity')
                                        <tr class="text-left border-b">
                                            <th
                                                class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-left">
                                                Product Name (ID)
                                            </th>
                                            <th
                                                class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-left">
                                                Category
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
                                                Type
                                            </th>
                                            <th
                                                class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-left">
                                                Design
                                            </th>
                                            <th
                                                class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-right">
                                                Normal Price
                                            </th>
                                            @if (session('promo_type') == 'cashback')
                                                <th
                                                    class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-right">
                                                    Cashback Amount
                                                </th>
                                            @else
                                                <th
                                                    class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-right">
                                                    Promotion Price
                                                </th>
                                            @endif
                                            <th
                                                class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-center">
                                                Quantity
                                            </th>
                                        </tr>
                                    @else
                                        <tr class="text-left border-b">
                                            <th
                                                class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-left">
                                                Product Name (ID)
                                            </th>
                                            <th
                                                class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-left">
                                                Category
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
                                                Type
                                            </th>
                                            <th
                                                class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-left">
                                                Design
                                            </th>
                                            <th
                                                class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-right">
                                                Normal Price
                                            </th>
                                            @if (session('promo_type') == 'cashback')
                                                <th
                                                    class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-right">
                                                    Cashback Amount
                                                </th>
                                            @else
                                                <th
                                                    class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-right">
                                                    Promotion Price
                                                </th>
                                            @endif
                                        </tr>
                                    @endif



                                </thead>
                                <tbody class="font-poppins text-[13px]">

                                    @forelse($promotion_products as $promotion)
                                        @php
                                            $product = App\Models\Product::find($promotion['product_id']);
                                        @endphp

                                        <tr class="bg-white border-b text-left">
                                            <th scope="row" class="px-6 py-2 font-medium  whitespace-nowrap ">

                                                <div class="flex items-center gap-3">
                                                    <div>
                                                        @if ($product->image)
                                                            <img src="{{ asset('products/image/' . $product->image) }}"
                                                                class="w-10 h-10" alt="">
                                                        @else
                                                            <img src="{{ asset('images/no-image.png') }}" class="w-12 h-12 "
                                                                alt="">
                                                        @endif
                                                    </div>
                                                    <h1 class="text-paraColor">{{ $product->name }} <span
                                                            class="text-noti">( {{ $product->code }} )</span></h1>
                                                </div>
                                            </th>
                                            <td class="px-6 py-2 whitespace-nowrap">
                                                {{ $product->category?->name }}
                                            </td>
                                            <td class="px-6 py-2 whitespace-nowrap ">
                                                {{ $product->brand?->name }}

                                            </td>
                                            <td class="px-6 py-2 whitespace-nowrap ">
                                                {{ $product->productModel?->name }}

                                            </td>
                                            <td class="px-6 py-2 whitespace-nowrap ">
                                                {{ $product->type?->name ?? '-' }}
                                            </td>

                                            <td class="px-6 py-2 whitespace-nowrap ">
                                                {{ $product->design?->name ?? '-' }}
                                            </td>

                                            <td class="px-6 py-2 whitespace-nowrap text-right">
                                                {{ number_format($promotion['normal_price']) }}
                                            </td>

                                            @if (session('promo_type') == 'cashback')
                                                <td class="px-6 py-2 whitespace-nowrap text-noti text-right">
                                                    {{ number_format($promotion['cashback']) }}
                                                </td>
                                            @else
                                                <td class="px-6 py-2 whitespace-nowrap text-noti text-right">
                                                    {{ number_format($promotion['promo_price']) }}
                                                </td>
                                            @endif

                                            @if (session('variant') == 'time-quantity')
                                                <td class="px-6 py-2 whitespace-nowrap text-center">
                                                    {{ $promotion['quantity'] }}

                                                </td>
                                            @endif
                                        </tr>
                                    @empty
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                    </div>


                </div>
            </div>

            {{-- table end --}}
            <form id="myForm" method="POST" action="{{ route('promotion-store') }}">
                @csrf
                <input type="hidden" name="promotion_products" id="promotion_products" />

                <div class=" mt-6 flex items-center justify-center">

                    <x-button-component class="bg-noti text-white" type="submit" id="done">
                        Confirm
                    </x-button-component>
                </div>
            </form>

        </div>
    </section>
@endsection

@section('script')
    <script>
        try {
            const items = localStorage.getItem('productPromotionCart');
            if (!items) {
                throw new Error('Cart items not found in local storage.');
            }

            const cart = JSON.parse(items);

            const products = @json($promotion_products);
            if (!Array.isArray(products)) {
                throw new Error('Invalid promotion products data.');
            }

            for (let i = 0; i < products.length; i++) {
                const productId = products[i].product_id;
                const cartItem = cart.find(item => item.product_id === productId);
                if (cartItem) {
                    cartItem.promo_wholesale_price = products[i].promo_wholesale_price;
                    cartItem.promo_retail_price = products[i].promo_retail_price;
                }
            }

            localStorage.setItem('productPromotionCart', JSON.stringify(cart));

            document.getElementById('promotion_products').value = JSON.stringify(cart);
        } catch (error) {
            console.error('Error:', error.message);
        }
    </script>

@endsection
