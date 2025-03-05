@foreach ($products as $product)
    <div
        class="w-64   relative border rounded-md shadow-xl   bg-white  overflow-hidden hover:scale-95 transition-all duration-300">
        @if ($product->is_imei == 1)
            <div class="bg-primary text-white text-[16px] px-2">IMEI Product</div>
        @endif
        <div class="bg-[#FCFCFC] ">
            @if ($product->image != null)
                <img src="{{ asset('products/image/' . $product->image) }}" class="mx-auto object-cover img-fluid" c
                    alt="">
            @else
                <img src="{{ asset('images/product_photo.jpg') }}" class="mx-auto object-cover img-fluid" c alt="">
            @endif
        </div>

        <div class="px-5 py-3">
            <div class="mb-3  text-noti">
                <h1 class="font-extrabold font-jakarta text-sm">
                    {{ $product->name ?? '-' }}({{ $product->code ?? '-' }})
                </h1>
                <input value="{{ $product->code ?? '-' }}" id="productCode{{ $product->id }}" hidden>
                <input value="{{ $product->name ?? '-' }}" id="productName{{ $product->id }}" hidden>
                <input value="{{ $product->is_imei }}" id="isIMEI{{ $product->id }}" hidden>
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

            <div class="grid grid-cols-2 mt-2">
                <div>
                    <div class="flex items-center  gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 576 512">
                            <path
                                d="M48 115.8C38.2 107 32 94.2 32 80c0-26.5 21.5-48 48-48c14.2 0 27 6.2 35.8 16H460.2c8.8-9.8 21.6-16 35.8-16c26.5 0 48 21.5 48 48c0 14.2-6.2 27-16 35.8V396.2c9.8 8.8 16 21.6 16 35.8c0 26.5-21.5 48-48 48c-14.2 0-27-6.2-35.8-16H115.8c-8.8 9.8-21.6 16-35.8 16c-26.5 0-48-21.5-48-48c0-14.2 6.2-27 16-35.8V115.8zM125.3 96c-4.8 13.6-15.6 24.4-29.3 29.3V386.7c13.6 4.8 24.4 15.6 29.3 29.3H450.7c4.8-13.6 15.6-24.4 29.3-29.3V125.3c-13.6-4.8-24.4-15.6-29.3-29.3H125.3zm2.7 64c0-17.7 14.3-32 32-32H288c17.7 0 32 14.3 32 32v96c0 17.7-14.3 32-32 32H160c-17.7 0-32-14.3-32-32V160zM256 320h32c35.3 0 64-28.7 64-64V224h64c17.7 0 32 14.3 32 32v96c0 17.7-14.3 32-32 32H288c-17.7 0-32-14.3-32-32V320z"
                                fill="#00812C" />
                        </svg>
                        <h1 class=" text-xs  font-jakarta text-noti  font-semibold" id="design{{ $product->id }}">
                            {{ $product->design->name ?? '-' }}
                        </h1>
                    </div>
                </div>

                <div>
                    <div class="flex items-center  gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 576 512">
                            <path
                                d="M48 115.8C38.2 107 32 94.2 32 80c0-26.5 21.5-48 48-48c14.2 0 27 6.2 35.8 16H460.2c8.8-9.8 21.6-16 35.8-16c26.5 0 48 21.5 48 48c0 14.2-6.2 27-16 35.8V396.2c9.8 8.8 16 21.6 16 35.8c0 26.5-21.5 48-48 48c-14.2 0-27-6.2-35.8-16H115.8c-8.8 9.8-21.6 16-35.8 16c-26.5 0-48-21.5-48-48c0-14.2 6.2-27 16-35.8V115.8zM125.3 96c-4.8 13.6-15.6 24.4-29.3 29.3V386.7c13.6 4.8 24.4 15.6 29.3 29.3H450.7c4.8-13.6 15.6-24.4 29.3-29.3V125.3c-13.6-4.8-24.4-15.6-29.3-29.3H125.3zm2.7 64c0-17.7 14.3-32 32-32H288c17.7 0 32 14.3 32 32v96c0 17.7-14.3 32-32 32H160c-17.7 0-32-14.3-32-32V160zM256 320h32c35.3 0 64-28.7 64-64V224h64c17.7 0 32 14.3 32 32v96c0 17.7-14.3 32-32 32H288c-17.7 0-32-14.3-32-32V320z"
                                fill="#00812C" />
                        </svg>
                        <h1 class=" text-xs  font-jakarta text-noti  font-semibold" id="type{{ $product->id }}">
                            {{ $product->type->name ?? '-' }}
                        </h1>
                    </div>
                </div>
            </div>


        </div>
        <div class="w-full h-[1px] bg-paraColor opacity-30 shadow-xl"></div>
        <div class="px-3 py-4 ">
            @if ($product->retail_price != 0)
                <input type="number" id="retailPrice{{ $product->id }}" value="{{ $product->retail_price }}" hidden>
                <div class="flex flex-row  mb-5 gap-3">
                    <input type="number" placeholder="Buying Price"
                        class="w-28 px-2 py-1 text-xs rounded-full  outline-none outline outline-1 outline-paraColor"
                        id="buyingPrice{{ $product->id }}" min="0" required>

                    <input type="number" placeholder="Quantity"
                        class="w-28 px-4 text-xs py-1 rounded-full  outline-none outline outline-1 outline-paraColor"
                        id="quantity{{ $product->id }}" min="0" required>
                </div>
                <br>
            @else
                <div class="flex flex-row mb-4 gap-3">
                    <input type="number" placeholder="Buying Price"
                        class="w-28 px-2 py-1 text-xs rounded-full  outline-none outline outline-1 outline-paraColor"
                        id="buyingPrice{{ $product->id }}" min="0" required>

                    <input type="number" placeholder="Selling Price"
                        class="w-28 px-2 text-xs rounded-full  outline-none outline outline-1 outline-paraColor"
                        id="retailPrice{{ $product->id }}" min="0" required>
                </div>
                <div class="flex flex-row  mb-4 gap-3">
                    <input type="number" placeholder="Quantity"
                        class="w-28 px-4 text-xs py-1 rounded-full  outline-none outline outline-1 outline-paraColor"
                        id="quantity{{ $product->id }}" min="0" required>
                </div>
            @endif

            <div class="flex flex-row justify-between">
                <button type="button" onclick="addToCard({{ $product->id }})">
                    <i class="fa-solid fa-cart-plus text-xl text-primary  "></i>
                </button>
            </div>
        </div>


    </div>
@endforeach
