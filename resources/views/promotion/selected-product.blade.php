@foreach ($products as $product)
    <div class="w-64   relative border rounded-md shadow-xl   bg-white  overflow-hidden hover:scale-95 transition-all duration-300"
        style="height: 560px;">
        <div class="bg-[#FCFCFC] ">
            @if ($product->image !== null)
                <img src="{{ asset('products/image/' . $product->image) }}" class="mx-auto object-cover img-fluid" c
                    alt="">
            @else
                <img src="{{ asset('images/no-image.png') }}" class="mx-auto object-cover img-fluid" c alt="">
            @endif
        </div>

        <div class="px-6 py-3" style="height: 150px;">
            <div class="mb-3  text-noti">
                <h1 class="font-extrabold font-jakarta text-sm">
                    {{ $product->name ?? '-' }}({{ $product->code ?? '-' }})
                </h1>
                <input value="{{ $product->code ?? '-' }}" id="productCode{{ $product->id }}" hidden>
            </div>
            <div class="grid grid-cols-2 ">
                <div>
                    <div class="flex items-center gap-1">
                        <svg xmlns="http://www.w3.org/2000/svg" height="0.9em" viewBox="0 0 640 512">
                            <path
                                d="M58.9 42.1c3-6.1 9.6-9.6 16.3-8.7L320 64 564.8 33.4c6.7-.8 13.3 2.7 16.3 8.7l41.7 83.4c9 17.9-.6 39.6-19.8 45.1L439.6 217.3c-13.9 4-28.8-1.9-36.2-14.3L320 64 236.6 203c-7.4 12.4-22.3 18.3-36.2 14.3L37.1 170.6c-19.3-5.5-28.8-27.2-19.8-45.1L58.9 42.1zM321.1 128l54.9 91.4c14.9 24.8 44.6 36.6 72.5 28.6L576 211.6v167c0 22-15 41.2-36.4 46.6l-204.1 51c-10.2 2.6-20.9 2.6-31 0l-204.1-51C79 419.7 64 400.5 64 378.5v-167L191.6 248c27.8 8 57.6-3.8 72.5-28.6L318.9 128h2.2z"
                                fill="#00812C" />
                        </svg>
                        <h1 class=" text-xs  font-jakarta text-noti font-semibold"
                            id="product_brand{{ $product->id }}">
                            {{ $product->brand->name ?? '-' }}
                        </h1>
                    </div>

                </div>

                <div>
                    <div class="flex items-center  gap-1">
                        <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 576 512">
                            <path
                                d="M48 115.8C38.2 107 32 94.2 32 80c0-26.5 21.5-48 48-48c14.2 0 27 6.2 35.8 16H460.2c8.8-9.8 21.6-16 35.8-16c26.5 0 48 21.5 48 48c0 14.2-6.2 27-16 35.8V396.2c9.8 8.8 16 21.6 16 35.8c0 26.5-21.5 48-48 48c-14.2 0-27-6.2-35.8-16H115.8c-8.8 9.8-21.6 16-35.8 16c-26.5 0-48-21.5-48-48c0-14.2 6.2-27 16-35.8V115.8zM125.3 96c-4.8 13.6-15.6 24.4-29.3 29.3V386.7c13.6 4.8 24.4 15.6 29.3 29.3H450.7c4.8-13.6 15.6-24.4 29.3-29.3V125.3c-13.6-4.8-24.4-15.6-29.3-29.3H125.3zm2.7 64c0-17.7 14.3-32 32-32H288c17.7 0 32 14.3 32 32v96c0 17.7-14.3 32-32 32H160c-17.7 0-32-14.3-32-32V160zM256 320h32c35.3 0 64-28.7 64-64V224h64c17.7 0 32 14.3 32 32v96c0 17.7-14.3 32-32 32H288c-17.7 0-32-14.3-32-32V320z"
                                fill="#00812C" />
                        </svg>
                        <h1 class=" text-xs  font-jakarta text-noti  font-semibold"
                            id="product_model{{ $product->id }}">
                            {{ $product->productModel->name ?? '-' }}
                        </h1>
                    </div>

                </div>

            </div>

        </div>
        <div class="w-full h-[1px] bg-paraColor opacity-30 shadow-xl"></div>

        <div class="px-6 py-3">
            <div class="flex flex-row items-center justify-center mb-1 gap-3">
                <h1 class="font-medium text-sm text-gray-500">Retail Price</h1>
            </div>
            <div class="flex flex-row items-center justify-center gap-3">
                <h1 class="font-semibold text-sm text-gray-500">
                    {{ number_format($product->retail_price) ?? '-' }}</h1>
            </div>

        </div>

        {{-- <div class="px-6 py-3 ">
            <div class="flex flex-row items-center justify-between mb-1 gap-3">
                <h1 class="font-medium text-sm text-gray-500">Wholesale Price</h1>
                <h1 class="font-medium text-sm text-gray-500">Retail Price</h1>
            </div>
            <div class="flex flex-row items-center justify-between gap-3">
                <h1 class="font-semibold text-sm text-gray-500">{{ number_format($product->wholesale_price) ?? '-' }}
                </h1>
                <h1 class="font-semibold text-sm text-gray-500">{{ number_format($product->retail_price) ?? '-' }}</h1>
            </div>

        </div> --}}

        @if (session('variant') == 'time')
            <div class="px-6 py-4">
                <div class="flex items-center justify-between gap-2 mb-1">

                    <input type="number" placeholder="Quantity"
                        class="w-28 px-4 text-xs py-1 rounded-full outline-none outline outline-1 outline-paraColor"
                        id="quantity{{ $product->id }}" min="0" max="{{ $product->quantity }}" value="0"
                        hidden>
                    @if (session('promo_type') == 'cashback')
                        <input type="number" placeholder="Cashback Amt" name="cashback_{{ $product->id }}"
                            class="w-28 px-1 text-xs py-1 rounded-full outline-none outline outline-1 outline-paraColor"
                            id="cashback_{{ $product->id }}" min="0">
                    @endif

                    <button
                        class="bg-primary hover:bg-transparent text-white font-jakarta text-sm font-bold py-1 px-4 w-41 rounded-full"
                        onclick="addToCard({{ $product->id }})">
                        Add
                    </button>
                </div>
            </div>
        @else
            <div class="px-3 py-4">
                <div class="flex flex-row items-center justify-between mb-1 gap-1">

                    <input type="number" placeholder="Quantity"
                        class="w-28 px-4 text-xs py-1 rounded-full  outline-none outline outline-1 outline-paraColor"
                        id="quantity{{ $product->id }}" min="0" max="{{ $product->quantity }}" required>

                    <button
                        class="bg-green-600 hover:bg-transparent text-white font-jakarta text-sm font-bold py-1 px-4 rounded-full"
                        onclick="addToCard({{ $product->id }})">
                        Add
                    </button>
                </div>
            </div>
        @endif

    </div>
@endforeach
