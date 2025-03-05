{{-- table start --}}
  <div class="data-table mt-5">
      <div class="  bg-white px-5 py-4 font-poppins rounded-[20px]  ">
          {{--  <div class="flex items-center justify-between flex-wrap gap-5 ">
              <h1 class="text-noti font-semibold  font-jakarta">{{ $title }}</h1>
              <div class="flex items-center flex-wrap gap-4">
                  <h1 class="text-noti font-medium text-sm">Total Quantity : <span class="text-[#5C5C5C] text-sm">{{ number_format($order->total_quantity) }}</span></h1>


                  <h1 class="text-noti font-medium text-sm">Total Amount : <span class="text-[#5C5C5C] text-sm">{{ number_format($order->total_amount) }}</span></h1>

              </div>
          </div>  --}}
          <div class="flex items-center justify-between flex-wrap gap-3 ">
            <h1 class="text-noti font-semibold  font-jakarta">{{ $title }}</h1>
            <div class="">
                <h1 class="text-noti  font-medium text-sm">Total Quantity : <span class="text-[#5C5C5C] text-sm">{{ number_format($order->total_quantity) }}</span></h1>

            </div>
            <div class="">
                <h1 class="text-noti font-medium text-sm">Total Net Amount : <span class="text-[#5C5C5C] text-sm">{{ number_format($order->total_amount) }}</span></h1>

            </div>
        </div>
          <div>
              <div class="relative overflow-x-auto mt-3 h-[300px] shadow-lg">
                  <table class="w-full text-sm text-left text-gray-500 ">

                        <thead class="text-sm sticky top-0 font-jakarta bg-gray-50  border-y text-primary  ">
                            <tr>
                                <th scope="col" class="px-6 py-3 whitespace-nowrap">
                                    Product Name <span class="text-[#5C5C5C] font-medium">(ID)</span>
                                </th>
                                <th scope="col" class="px-6 py-3 whitespace-nowrap">
                                    Categories
                                </th>
                                <th scope="col" class="px-6 py-3 whitespace-nowrap">
                                    Brand
                                </th>
                                <th scope="col" class="px-6 py-3 whitespace-nowrap">
                                    Model
                                </th>
                                <th scope="col" class="px-6 py-3 whitespace-nowrap">
                                    Design
                                </th>
                                <th scope="col" class="px-6 py-3 whitespace-nowrap">
                                    Type
                                </th>
                                <th scope="col" class="px-6 py-3 whitespace-nowrap">
                                    Unit Price
                                </th>
                                <th scope="col" class="px-6 py-3 text-right whitespace-nowrap">
                                    Quantity
                                </th>
                                <th scope="col" class="px-6  py-3 text-right whitespace-nowrap">
                                    Total Amount
                                </th>
                            </tr>
                        </thead>


                      <tbody class="text-[13px] text-left">
                          @forelse($order->orderProducts as $order_product)
                
                          <tr class="bg-white border-b ">
                              <th scope="row" class="px-6 py-4 font-medium  text-gray-900 whitespace-nowrap ">
                                  <div class="flex items-center gap-2">

                                          @if($order_product->product?->image)
                                          <img src="{{ asset('products/image/'.$order_product->product->image) }}" class="w-10 object-contain ">
                                          @else
                                          <img src="{{ asset('images/no-image.png') }}" class="w-20 ">
                                          @endif

                                      <h1 class="text-[#5C5C5C] font-medium">{{ $order_product->product?->name}}<span class="text-noti ">({{ $order_product->product?->code }})</span></h1>
                                  </div>


                              </th>
                              <td class="px-6 py-4">
                                  {{ $order_product->product?->category->name }}
                              </td>
                              <td class="px-6 py-4 ">
                                  {{ $order_product->product?->brand->name }}
                              </td>
                              <td class="px-6 py-4">
                                  {{ $order_product->product?->productModel->name }}
                              </td>
                              <td class="px-6 py-4">
                                  {{ $order_product->product?->design->name ?? '-' }}
                              </td>
                              <td class="px-6 py-4">
                                  {{ $order_product->product?->type?->name ?? '-' }}
                              </td>
                              <td class="px-6 py-4 text-right">
                                {{ number_format($order_product->unit_price) }}
                              </td>
                              <td class="px-6 py-4 text-center">
                                  {{ $order_product->quantity }}
                              </td>
                              <td class="px-6 py-4 font-medium text-right text-noti">
                                  {{ number_format($order_product->price) }}
                              </td>


                          </tr>
                          @empty
                          @endforelse
                      </tbody>
                  </table>
              </div>

          </div>
      </div>
  </div>
  {{-- table end  --}}
