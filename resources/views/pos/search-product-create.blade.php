@if ($products)
    @forelse ($products as $product)
        <input id="product_model{{ $product->id }}" value="{{ $product->productModel->name }}" hidden>
        <input type="hidden" id="is_promoted{{ $product->id }}" value="{{ $product->is_promoted }}">
        <input type="hidden" id="promotion_id{{ $product->id }}" value="{{ $product->promotion_id }}">
        <input type="hidden" id="maxStock{{ $product->id }}" value="{{ $product->total_stock_qty }}">
        <input type="hidden" id="isIMEI{{ $product->id }}" value="{{ $product->is_imei }}">

        <div class="relative border rounded-md shadow-xl bg-white overflow-hidden hover:scale-95 transition-all duration-300"
            style="width: 15rem; height: 520px;">
            <div class="absolute top-0 right-0 mb-2">

                @if ($product->is_promoted == 'true')
                    <div class="bg-red-600 text-white text-[11px]  py-[2px] px-2">Promotion Item</div>
                @endif
            </div>

            <div class="bg-[#FCFCFC] ">
                @if ($product->image != null)
                    <img src="{{ asset('products/image/' . $product->image) }}" class="mx-auto object-cover img-fluid"
                        c alt="">
                @else
                    <img src="{{ asset('images/no-image.png') }}" class="mx-auto object-cover img-fluid" c
                        alt="">
                @endif
            </div>

            <div class="px-5 py-3" style="height: 230px;">
                <div class="mb-5 text-noti">
                    <h1 class="font-semibold font-jakarta text-sm" id="product_code{{ $product->id }}">
                        {{ $product->name }} <span class="text-primary">({{ $product->code }})</span>
                    </h1>
                </div>

                <div class="grid grid-cols-2">
                    <div>
                        <div class="flex items-center gap-2">
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
                        <div class="flex items-center  gap-2">
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

                <div class="grid grid-cols-2 mt-5">
                    <div>
                        <div class="flex items-center gap-1 ">
                            <div class=" text-sm font-jakarta text-paraColor font-medium">Stock :</div>
                            <div class=" font-jakarta text-sm  font-semibold" id="product_stock{{ $product->id }}">
                                {{ number_format($product->total_stock_qty) }}
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="ml-1" height="1em" viewBox="0 0 320 512">
                            <path
                                d="M160 0c17.7 0 32 14.3 32 32V67.7c1.6 .2 3.1 .4 4.7 .7c.4 .1 .7 .1 1.1 .2l48 8.8c17.4 3.2 28.9 19.9 25.7 37.2s-19.9 28.9-37.2 25.7l-47.5-8.7c-31.3-4.6-58.9-1.5-78.3 6.2s-27.2 18.3-29 28.1c-2 10.7-.5 16.7 1.2 20.4c1.8 3.9 5.5 8.3 12.8 13.2c16.3 10.7 41.3 17.7 73.7 26.3l2.9 .8c28.6 7.6 63.6 16.8 89.6 33.8c14.2 9.3 27.6 21.9 35.9 39.5c8.5 17.9 10.3 37.9 6.4 59.2c-6.9 38-33.1 63.4-65.6 76.7c-13.7 5.6-28.6 9.2-44.4 11V480c0 17.7-14.3 32-32 32s-32-14.3-32-32V445.1c-.4-.1-.9-.1-1.3-.2l-.2 0 0 0c-24.4-3.8-64.5-14.3-91.5-26.3c-16.1-7.2-23.4-26.1-16.2-42.2s26.1-23.4 42.2-16.2c20.9 9.3 55.3 18.5 75.2 21.6c31.9 4.7 58.2 2 76-5.3c16.9-6.9 24.6-16.9 26.8-28.9c1.9-10.6 .4-16.7-1.3-20.4c-1.9-4-5.6-8.4-13-13.3c-16.4-10.7-41.5-17.7-74-26.3l-2.8-.7 0 0C119.4 279.3 84.4 270 58.4 253c-14.2-9.3-27.5-22-35.8-39.6c-8.4-17.9-10.1-37.9-6.1-59.2C23.7 116 52.3 91.2 84.8 78.3c13.3-5.3 27.9-8.9 43.2-11V32c0-17.7 14.3-32 32-32z" />
                        </svg>
                        <h1 class=" font-jakarta text-noti font-extrabold" id="unit_price{{ $product->id }}"
                            style="font-size:12px;">
                            @if ($product->promotion_status)
                                {{ number_format($product->promotion_price) }}
                            @else
                                {{ number_format($product->retail_price) }}
                            @endif Ks
                            
                        </h1>
                        
                    </div>
                    @if ($product->cashback_value)
                        <span class=" font-jakarta text-red-600 font-extrabold text-xs mt-3" id="cashback_price{{ $product->id }}">
                            ({{ number_format($product->cashback_value) }} Ks Cashback)
                        </span>                               
                    @endif                    
                </div>
            </div>
            <div class="w-full h-[1px] bg-paraColor opacity-30 shadow-xl"></div>
            <div class="flex items-center px-5 py-3 justify-between">
                <div class="flex items-center gap-1 ">
                    <button class=" text-paraColor " onclick="increaseQuantity(this, {{ $product->id }})">
                        <i class="fa-solid fa-plus"></i>
                    </button>
                    <input class="font-jakarta  rounded-sm outline-none  w-16 text-center py-[1px] "
                        name="order_quantity" id="order_quantity{{ $product->id }}" type="text"
                        data-product-id="{{ $product->id }}" data-max-value="{{ $product->total_stock_qty }}"
                        value="0" min="0">
                    <button class=" text-paraColor " onclick="decreaseQuantity(this, {{ $product->id }})">
                        <i class="fa-solid fa-minus"></i>
                    </button>
                    <span id="order_quantity_span{{ $product->id }}"></span>
                </div>
                <div>
                    <button onclick="addToCart({{ $product->id }})" class="hover:scale-110">
                        <i class="fa-solid fa-cart-plus text-lg  "></i>
                    </button>
                </div>
            </div>
        </div>
    @empty
        <div id="loadingSpinner" class="loading-spinner text-center mt-3 mx-auto">
            <i class="fas fa-spinner fa-spin fa-7x"></i>
            <p>Loading...</p>
        </div>
    @endforelse
@endif
