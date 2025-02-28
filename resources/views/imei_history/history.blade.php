@extends('layouts.master-without-nav')
@section('title', 'IMEI History')

@section('css')
@endsection

@section('content')
    <section class="Purchase__Detail">
        {{-- nav start  --}}
        @include('layouts.header-section', [
            'title' => 'Purchase Details',
            'subTitle' => 'Details of Purchase',
        ])
        {{-- nav end  --}}


        {{-- ..........  --}}

        {{-- main start  --}}
        <div class="lg:mx-[30px] mx-[10px] my-[10px] lg:my-[20px]">
            {{-- ........  --}}
            {{-- product details start  --}}
            <div class="bg-white p-5 rounded-[20px] mt-5">

                <div class="flex items-center justify-between pt-5">
                    <h1 class="text-noti text-lg font-semibold font-jakarta">Product Information <span class="text-gray-900 text-md">({{ $imei }})</span></h1>
                </div>

                <div class="data-table">
                    <div class="bg-white px-1 py-2 font-poppins rounded-[20px]  ">
                        <div>
                            <div class="relative overflow-x-auto mt-3 shadow-lg">
                                <table class="w-full text-sm text-center text-gray-500 ">
                                    <thead class="text-sm text-primary bg-gray-50  font-medium font-poppins">

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
                                                Design
                                            </th>
                                            <th
                                                class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-left">
                                                Type
                                            </th>
                                            <th
                                                class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-right">
                                                Selling Price
                                            </th>
                                            <th
                                                class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-right">
                                                Location
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody class="text-sm font-normal text-paraColor font-poppins">
                                        <tr class="bg-white border-b text-left">
                                            <th scope="row"
                                                class="px-6 py-4 whitespace-nowrap font-medium  text-gray-900">
                                                <div class="flex items-center gap-2">

                                                    @if ($product->image)
                                                        <img src="{{ asset('products/image/' . $product->image) }}"
                                                            class="w-10 h-10 object-cover">
                                                    @else
                                                        <img src="{{ asset('images/no-image.png') }}"
                                                            class="w-10 h-10 object-cover">
                                                    @endif


                                                    <h1 class="text-[#5C5C5C] font-medium  ">{{ $product->name }} <span
                                                            class="text-noti ">({{ $product->code }})</span></h1>
                                                </div>
                                                @if ($productLocation->status == 'Sold')
                                                    <span class="text-red-600 font-bold">Sold Out</span>
                                                @else
                                                    <span class="text-primary font-bold">Available</span>
                                                @endif
                                                
                                            </th>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                {{ $product->category?->name }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                {{ $product->brand?->name }}

                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                {{ $product->productModel?->name }}

                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                {{ $product->design?->name ?? '-' }}


                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                {{ $product->type?->name ?? '-' }}

                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-primary text-right">
                                                {{ number_format($product->retail_price) }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-right">
                                                @if ($productLocation->status == 'Sold')
                                                    -
                                                @else
                                                @php
                                                    $location = \App\Models\Location::where('id', $productLocation->location_id)->value('location_name');
                                                @endphp
                                                    {{ $location }}
                                                @endif
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                        </div>


                    </div>
                </div>
            </div>
            {{-- product details end --}}

            {{-- product activity start  --}}
            <div class="bg-white p-5 rounded-[20px] mt-5">

                <div class="flex items-center justify-between pt-5">
                    <h1 class="text-noti text-lg font-semibold font-jakarta">IMEI Transaction Log</h1>
                </div>

                <div class="data-table">
                    <div class="bg-white px-1 py-2 font-poppins rounded-[20px]  ">
                        <div>
                            <div class="relative overflow-x-auto mt-3 shadow-lg">
                                <table class="w-full text-sm text-center text-gray-500 ">
                                    <thead class="text-sm text-primary bg-gray-50  font-medium font-poppins">

                                        <tr class="text-left border-b">
                                            <th
                                                class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-left">
                                                Date
                                            </th>
                                            <th
                                                class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-left">
                                                Action Type
                                            </th>

                                            <th
                                                class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-left">
                                                Reference Number
                                            </th>

                                            <th
                                                class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-left">
                                                From
                                            </th>

                                            <th
                                                class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-left">
                                                To
                                            </th>
                                            
                                        </tr>
                                    </thead>
                                    <tbody class="text-sm font-normal text-paraColor font-poppins">
                                        @foreach ($history as $item)
                                            <tr class="bg-white border-b text-left">
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    {{ \Carbon\Carbon::parse($item['date'])->format('Y-m-d') }}
                                                </td>
                                                <td class="px-6 py-3 whitespace-nowrap">
                                                    {{ $item['type'] }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    {{ $item['reference_number'] }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    @switch($item['type'])
                                                        @case('Purchase')
                                                            @php
                                                                $supplier = \App\Models\Supplier::where('id', $item['from'])->value('name');
                                                            @endphp
                                                                {{ $supplier }}
                                                        @break
                                                        @case('Purchase Return')
                                                        @php
                                                            $location = \App\Models\Location::join('distribution_transactions as dt', 'dt.location_id', 'locations.id')
                                                                                            ->where('dt.purchase_id', $item['id'])
                                                                                            ->value('locations.location_name');
                                                        @endphp
                                                            {{ $location }}
                                                        @break
                                                        @case('Product Transfer')
                                                        @php
                                                            $location = \App\Models\Location::where('id', $item['from'])->value('location_name');
                                                        @endphp
                                                            {{ $location }}
                                                        @break
                                                        @case('Product Receive')
                                                        @php
                                                            $location = \App\Models\Location::where('id', $item['from'])->value('location_name');
                                                        @endphp
                                                            {{ $location }}
                                                        @break
                                                        @case('Point Of Sale')
                                                        @php
                                                            $location = \App\Models\Location::where('id', $item['from'])->value('location_name');
                                                        @endphp
                                                            {{ $location }}
                                                        @break
                                                        @default
                                                            
                                                    @endswitch
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    @switch($item['type'])
                                                        @case('Purchase')
                                                            @php
                                                                $location = \App\Models\Location::join('distribution_transactions as dt', 'dt.location_id', 'locations.id')
                                                                                                ->where('dt.purchase_id', $item['id'])
                                                                                                ->value('locations.location_name');
                                                            @endphp
                                                                {{ $location }}
                                                        @break
                                                        @case('Purchase Return')
                                                        @php
                                                            $location = \App\Models\Location::join('distribution_transactions as dt', 'dt.location_id', 'locations.id')
                                                                                            ->where('dt.purchase_id', $item['id'])
                                                                                            ->value('locations.location_name');
                                                        @endphp
                                                            {{ $location }}
                                                        @break
                                                        @case('Product Transfer')
                                                        @php
                                                            $location = \App\Models\Location::where('id', $item['to'])->value('location_name');
                                                        @endphp
                                                            {{ $location }}
                                                        @break
                                                        @case('Product Receive')
                                                        @php
                                                            $location = \App\Models\Location::where('id', $item['to'])->value('location_name');
                                                        @endphp
                                                            {{ $location }}
                                                        @break
                                                        @case('Point Of Sale')
                                                        @php
                                                            $shopper = \App\Models\Shopper::where('id', $item['to'])->value('name');
                                                        @endphp
                                                            {{ $shopper }}
                                                        @break
                                                        @default
                                                            
                                                    @endswitch
                                                </td>
                                            </tr>
                                            
                                        @endforeach
                                        
                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div>
                </div>                
            </div>
            <div class="flex justify-center">
                <a href="{{ route('dashboard')}}"
                    class="bg-noti text-white font-jakarta font-semibold mt-10 px-20 py-2 rounded-full">Back</a>
            </div>
        </div>
            {{-- product activity end --}}

        </div>
        {{-- main end  --}}

    </section>
@endsection

@section('script')
    
@endsection