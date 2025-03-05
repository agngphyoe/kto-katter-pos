@extends('layouts.master-without-nav')
@section('title', 'Return Create')
@section('css')

@endsection

@php
    use App\Models\Product;
    use App\Constants\PrefixCodeID;
@endphp
@section('content')
    <section class="create-final">
        {{-- nav start  --}}
        @include('layouts.header-section', [
            'title' => 'Create A New Return',
            'subTitle' => 'Fill to create a new return',
        ])
        {{-- nav end  --}}

        {{-- ..................  --}}
        {{-- main start  --}}
        {{-- progress respomsive start  --}}
        <div class="lg:mx-[30px] mx-[10px] my-[10px] lg:my-[20px]">
            <div class="flex items-center lg:hidden justify-between gap-3 ">
                <div class="flex items-center gap-3 w-full">
                    <div class="w-12 h-12 shrink-0 flex items-center justify-center mb-3 bg-primary  rounded-full">
                        <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 448 512">
                            <path
                                d="M438.6 105.4c12.5 12.5 12.5 32.8 0 45.3l-256 256c-12.5 12.5-32.8 12.5-45.3 0l-128-128c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0L160 338.7 393.4 105.4c12.5-12.5 32.8-12.5 45.3 0z"
                                fill="#FFFFFF" />
                        </svg>
                    </div>
                    <div class="w-full h-[2px] flex-grow bg-primary "></div>
                </div>
                <div class="flex items-center gap-2 w-full">
                    <div class="w-12 h-12 shrink-0 flex items-center justify-center mb-3 bg-primary  rounded-full">
                        <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 448 512">
                            <path
                                d="M438.6 105.4c12.5 12.5 12.5 32.8 0 45.3l-256 256c-12.5 12.5-32.8 12.5-45.3 0l-128-128c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0L160 338.7 393.4 105.4c12.5-12.5 32.8-12.5 45.3 0z"
                                fill="#FFFFFF" />
                        </svg>
                    </div>
                    <div class="w-full h-[2px] flex-grow bg-primary "></div>
                </div>
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 flex items-center justify-center mb-3 bg-primary  rounded-full">
                        <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 448 512">
                            <path
                                d="M438.6 105.4c12.5 12.5 12.5 32.8 0 45.3l-256 256c-12.5 12.5-32.8 12.5-45.3 0l-128-128c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0L160 338.7 393.4 105.4c12.5-12.5 32.8-12.5 45.3 0z"
                                fill="#FFFFFF" />
                        </svg>
                    </div>

                </div>

            </div>
            <div class="flex items-center font-jakarta lg:hidden justify-between gap-3 ">
                <div>
                    <h1 class="text-primary  font-semibold mb-1 text-sm">Product Return</h1>
                    <h1 class="text-paraColor text-xs ">Return Information</h1>
                </div>
                <div>
                    <h1 class="text-primary font-semibold mb-1 ml-14 text-sm text-center">Product</h1>
                    <h1 class="text-paraColor text-xs ml-14 text-center ">Products details to be ordered</h1>
                </div>
            </div>
        </div>
        {{-- progress respomsive end  --}}


        <div class="lg:mx-[30px] mx-[10px] my-[10px] lg:my-[20px]">
            <div class="grid grid-cols-1 lg:grid-cols-5 gap-8 ">
                <div class="col-span-1 lg:col-span-4">
                    {{-- Product Transfer start  --}}
                    <div class="bg-white rounded-[20px] p-7">
                        <div>
                            <h1 class="font-jakarta text-noti font-semibold mb-3">Return Information</h1>
                            <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                                <div class="text-center">
                                    <h1 class="text-primary font-poppins text-sm font-semibold mb-2">Return Code</h1>
                                    <h1 class="text-[#5C5C5C]  font-poppins text-[13px] ">
                                        {{ PrefixCodeID::RETURN }}-{{ $data['return_code'] }}
                                    </h1>
                                </div>
                                <div class="text-center">
                                    <h1 class="text-primary font-poppins text-sm font-semibold mb-2">Remark</h1>
                                    <h1 class="text-[#5C5C5C]  font-poppins text-[13px] ">
                                        {{ $data['remark'] ?? '-' }}
                                    </h1>
                                </div>
                                <div class="md:text-center">
                                    <h1 class="text-primary font-poppins text-sm font-semibold mb-2">Location From</h1>
                                    <h1 class="text-[#5C5C5C] font-poppins text-[13px] ">
                                        {{ $data['from_location_name'] }}
                                    </h1>
                                </div>
                                <div class="text-center">
                                    <h1 class="text-primary font-poppins text-sm font-semibold mb-2">Location To</h1>
                                    <h1 class="text-[#5C5C5C] font-poppins text-[13px] ">
                                        {{ $data['to_location_name'] }}
                                    </h1>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- Product Transfer end --}}

                    {{-- ....................  --}}
                    {{-- purchase product table start  --}}
                    <div class="bg-white p-7 rounded-[20px] mt-5">
                        <div class="flex items-center justify-between flex-wrap gap-2 ">
                            <h1 class="text-noti font-semibold  mb-2 md:mb-0 font-jakarta">Return Products</h1>
                            {{-- <h1 class="text-noti font-semibold text-sm font-poppins">Total Quantity : <span class="ml-3 text-paraColor font-medium">{{ number_format($data['total_quantity']) ?? 0 }}</span> --}}
                            </h1>
                        </div>

                        {{-- table start --}}
                        <div class="data-table">
                            <div class="bg-white font-poppins rounded-[20px]">
                                <div>
                                    <div class="relative overflow-x-auto shadow-lg mt-3">
                                        <table class="w-full text-sm  text-gray-500 ">
                                            <thead class="text-sm text-left text-primary font-jakarta bg-gray-50  ">
                                                <tr class="text-left border-b">
                                                    <th scope="col" class="px-6 py-3 whitespace-nowrap">
                                                        Product ID
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
                                                    <th scope="col" class="px-6 py-3 whitespace-nowrap text-center">
                                                        Quantity
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody class="text-[13px] font-normal text-paraColor font-poppins">
                                                @forelse(json_decode($data['products']) as $product_data)
                                                    @php
                                                        $product = Product::find($product_data->product_id);
                                                    @endphp
                                                    <tr class="bg-white border-b text-left">
                                                        <td scope="row"
                                                            class="px-6 py-4 font-medium   text-gray-900 whitespace-nowrap ">
                                                            {{ $product->name }} <span
                                                                class="text-noti">({{ $product->code }})</span>
                                                        </td>
                                                        <td class="px-6 py-4 whitespace-nowrap">
                                                            {{ $product->category?->name ?? '-' }}
                                                        </td>
                                                        <td class="px-6 py-4 whitespace-nowrap ">
                                                            {{ $product->brand?->name ?? '-' }}

                                                        </td>
                                                        <td class="px-6 py-4 whitespace-nowrap">
                                                            {{ $product->productModel?->name ?? '-' }}

                                                        </td>
                                                        <td class="px-6 py-4 whitespace-nowrap text-center">
                                                            {{ number_format($product_data->quantity) ?? '-' }}

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
                    </div>
                    {{-- purchase product table end --}}

                </div>
                <div class="col-span-1 hidden font-jakarta lg:block lg:col-span-1">
                    {{-- progress start  --}}
                    <div>
                        <div class="flex justify-between">
                            <div>
                                <h1 class="text-primary font-semibold mb-1 ">Product Return</h1>
                                <h1 class="text-paraColor text-sm">Return Information</h1>
                            </div>
                            <div class="">
                                <div class="w-12 h-12 flex items-center justify-center mb-3 bg-primary  rounded-full">
                                    <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 448 512">
                                        <path
                                            d="M438.6 105.4c12.5 12.5 12.5 32.8 0 45.3l-256 256c-12.5 12.5-32.8 12.5-45.3 0l-128-128c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0L160 338.7 393.4 105.4c12.5-12.5 32.8-12.5 45.3 0z"
                                            fill="#FFFFFF" />
                                    </svg>
                                </div>
                                <div class="w-[2px] h-36 bg-primary mx-auto"></div>
                            </div>
                        </div>
                        <div class="flex justify-between mb-10">
                            <div>
                                <h1 class="text-primary font-semibold mb-1  ">Products</h1>
                                <h1 class="text-paraColor text-sm">Products details to be transfered</h1>
                            </div>
                            <div class="">
                                <div class="w-12 h-12 flex items-center justify-center mb-3 bg-primary  rounded-full">
                                    <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 448 512">
                                        <path
                                            d="M438.6 105.4c12.5 12.5 12.5 32.8 0 45.3l-256 256c-12.5 12.5-32.8 12.5-45.3 0l-128-128c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0L160 338.7 393.4 105.4c12.5-12.5 32.8-12.5 45.3 0z"
                                            fill="#FFFFFF" />
                                    </svg>
                                </div>

                            </div>
                        </div>
                        <form method="POST" action="{{ route('product-return-store') }}">
                            @csrf
                            <input type="hidden" name="data" value="{{ json_encode($data) }}">
                            <div>
                                <button class="bg-primary rounded-full w-full py-2 text-white font-poppins text-sm mb-5"
                                    type="submit">Confirm Return</button>
                                <a href="{{ route('product-return') }}">
                                    <button
                                        class="outline outline-1 outline-noti rounded-full w-full py-2 text-noti font-poppins text-sm mb-5"
                                        type="button">Cancel Return</button>
                                </a>

                            </div>
                        </form>
                    </div>

                </div>
                {{-- progress end --}}

            </div>
            <div class="mt-5 lg:hidden flex justify-center">
                <form method="POST" action="{{ route('product-transfer-store') }}">
                    @csrf
                    <input type="hidden" name="data" value="{{ json_encode($data) }}">
                    <div class="flex flex-col ">
                        <button class="bg-primary rounded-full w-[300px] py-2 text-white font-poppins text-sm mb-5"
                            type="submit">Confirm Return</button>
                        <a href="{{ route('product-transfer') }}">
                            <button
                                class="outline outline-1 outline-noti rounded-full w-[300px] py-2 text-noti font-poppins text-sm mb-5"
                                type="button">Cancel Return</button>
                        </a>
                    </div>
                </form>
            </div>
        </div>
        {{-- main end --}}

    </section>
@endsection
@section('script')

@endsection
