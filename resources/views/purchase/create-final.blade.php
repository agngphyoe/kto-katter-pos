@extends('layouts.master-without-nav')
@section('title', 'Create Purchase')
@section('css')

@endsection

@php
    use App\Models\Product;
    use App\Models\Supplier;

    $supplier = Supplier::find($data['supplier_id']);

@endphp
@section('content')
    <section class="create-final">
        {{-- nav start  --}}
        @include('layouts.header-section', [
            'title' => 'Create A New Purchase',
            'subTitle' => 'Fill to create a new purchase',
        ])
        {{-- nav end  --}}

        {{-- ..................  --}}
        {{-- main start  --}}
        {{-- progress respomsive start  --}}
        <div class="lg:mx-[30px] mx-[10px] my-[10px] lg:my-[20px]">
            <div class="flex items-center block lg:hidden justify-between gap-3 ">
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
            <div class="flex items-center font-jakarta block lg:hidden justify-between gap-3 ">
                <div>
                    <h1 class="text-primary  font-semibold mb-1 text-sm">Supplier</h1>
                    <h1 class="text-paraColor text-xs ">Supplier Information</h1>
                </div>
                <div>
                    <h1 class="text-primary font-semibold mb-1 ml-14 text-sm text-center">Product</h1>
                    <h1 class="text-paraColor text-xs ml-14 text-center ">Products details to be ordered</h1>
                </div>
                <div>
                    <h1 class="text-primary font-semibold mb-1 text-sm text-right">payment</h1>
                    <h1 class="text-paraColor text-xs text-right ">The final steps to be purchased</h1>
                </div>

            </div>
        </div>
        {{-- progress respomsive end  --}}


        <div class="lg:mx-[30px] mx-[10px] my-[10px] lg:my-[20px]">
            <div class="grid grid-cols-1 lg:grid-cols-5 gap-8 ">
                <div class="col-span-1 lg:col-span-4">
                    {{-- supplier detail start  --}}
                    <div class="bg-white rounded-[20px] p-7">
                        <div>
                            <h1 class="font-jakarta text-noti font-semibold mb-3">Supplier Details</h1>
                            <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                                <div>
                                    <h1 class="text-primary font-poppins mb-2 font-semibold text-sm">Supplier Name <span
                                            class="text-paraColor">(ID)</span></h1>
                                    <div class="flex items-center gap-2 ">
                                        <div>
                                            @if ($supplier->image)
                                                <img src="{{ asset('suppliers/image/' . $supplier->image) }}"
                                                    class="w-12 h-12 object-contain" alt="">
                                            @else
                                                <img src="{{ asset('images/no-image.png') }}"
                                                    class="w-12 h-12 object-contain" alt="">
                                            @endif
                                        </div>
                                        <h1 class="text-paraColor text-xs font-poppins">{{ $supplier->name }} <span
                                                class="text-noti">({{ $supplier->user_number }})</span></h1>
                                    </div>
                                </div>
                                <div class="text-left">
                                    <h1 class="text-primary font-poppins text-sm font-semibold mb-2">Contact Person</h1>
                                    <h1 class="text-[#5C5C5C]  font-poppins text-[13px] ">
                                        {{ $supplier->contact_name }}
                                    </h1>
                                </div>
                                <div class="md:text-left">
                                    <h1 class="text-primary font-poppins text-sm font-semibold mb-2">Contact Number</h1>
                                    <h1 class="text-[#5C5C5C] font-poppins text-[13px] ">
                                        {{ $supplier->contact_phone }}
                                    </h1>
                                </div>
                                <div class="text-left">
                                    <h1 class="text-primary font-poppins text-sm font-semibold mb-2">Work Position</h1>
                                    <h1 class="text-[#5C5C5C] font-poppins text-[13px] ">
                                        {{ $supplier->contact_position }}
                                    </h1>
                                </div>
                                <div class="text-left">
                                    <h1 class="text-primary font-poppins text-sm font-semibold mb-2">Phone Number</h1>
                                    <h1 class="text-[#5C5C5C] font-poppins text-[13px] ">{{ $supplier->phone }}
                                    </h1>
                                </div>

                                <div class="text-left">
                                    <h1 class="text-primary font-poppins text-sm font-semibold mb-2">Country</h1>
                                    <h1 class="text-[#5C5C5C] font-poppins text-[13px]">
                                        {{ $supplier->country?->name ?? '-' }}
                                    </h1>
                                </div>
                                <div class="md:text-left">
                                    <h1 class="text-primary font-poppins text-sm font-semibold mb-2">Address
                                    </h1>
                                    <h1 class="text-[#5C5C5C] font-poppins text-[13px] ">{{ $supplier->address ?? '-' }}
                                    </h1>
                                </div>
                            </div>

                        </div>
                    </div>
                    {{-- supplier detail end --}}

                    {{-- ...............  --}}
                    {{-- purchase information start  --}}
                    <div class="bg-white p-7 rounded-[20px] mt-5">
                        <h1 class="font-jakarta font-semibold text-noti mb-3">Purchase Information</h1>
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                            <div class="text-center">
                                <h1 class="text-primary font-poppins text-sm font-semibold mb-2">Total Buying Amount</h1>
                                <h1 class="text-[#5C5C5C] font-poppins text-[13px]  ">
                                    {{ number_format($data['total_amount']) ?? '-' }}
                                </h1>
                            </div>
                            <div class="md:text-center">
                                <h1 class="text-primary font-poppins text-sm font-semibold mb-2">Discount Amount</h1>
                                <h1 class="text-[#5C5C5C] font-poppins text-[13px]  ">
                                    {{ number_format($data['discount_amount']) ?? 0 }}
                                </h1>
                            </div>
                            <div class="md:text-center">
                                <h1 class="text-primary font-poppins text-sm font-semibold mb-2">Net Amount</h1>
                                <h1 class="text-[#5C5C5C] font-poppins text-[13px]  " style="color: coral">
                                    {{ number_format($data['total_amount'] - $data['discount_amount']) ?? 0 }}
                                </h1>
                            </div>
                            @if ($data['action_type'] == 'Credit')

                                <div class="md:text-center">
                                    <h1 class="text-primary font-poppins text-sm font-semibold mb-2">Cash Down Amount</h1>
                                    <h1 class="text-[#5C5C5C] font-poppins text-[13px]  ">
                                        {{ number_format($data['cash_down']) ?? 0 }}
                                    </h1>
                                </div>
                                <div class="md:text-center">
                                    <h1 class="text-primary font-poppins text-sm font-semibold mb-2">Remaining Amount</h1>
                                    <h1 class="text-[#5C5C5C] font-poppins text-[13px]  ">
                                        @if ($data['action_type'] == 'Cash')
                                            0
                                        @else
                                            {{ number_format($data['total_amount'] - $data['discount_amount'] - $data['cash_down']) ?? 0 }}
                                        @endif
                                    </h1>
                                </div>
                            @endif
                            <div class="md:text-center">
                                <h1 class="text-primary font-poppins text-sm font-semibold mb-2">Currency Type</h1>
                                <h1 class="text-[#5C5C5C] font-poppins text-[13px]  ">
                                    {{ strtoupper($data['currency_type']) }}
                                </h1>
                            </div>
                            @if ($data['currency_type'] !== 'kyat')
                                <div class="md:text-center">
                                    <h1 class="text-primary font-poppins text-sm font-semibold mb-2">Currency Rate</h1>
                                    <h1 class="text-noti font-poppins text-[13px]  ">
                                        {{ $data['currency_value'] ?? 1 }}
                                    </h1>
                                </div>
                            @endif

                            <div class="md:text-center">
                                <h1 class="text-primary font-poppins text-sm font-semibold mb-2">Purchase Type</h1>

                                <div class="flex items-center justify-center">
                                    <x-badge
                                        class="{{ $data['action_type'] == 'Credit' ? 'bg-[#FF8A00]' : 'bg-[#00812C]' }} text-white px-3">
                                        {{ $data['action_type'] }}
                                    </x-badge>
                                </div>
                            </div>

                            <div class="md:text-center">
                                <h1 class="text-primary font-poppins text-sm  font-semibold mb-2">Payment Type</h1>
                                <h1 class="text-[#5C5C5C] font-poppins text-[13px] ">
                                    {{ $payment_type->bank_name }}
                                </h1>
                            </div>

                            <div class="md:text-center">
                                <h1 class="text-primary font-poppins text-sm  font-semibold mb-2">Date</h1>
                                <h1 class="text-[#5C5C5C] font-poppins text-[13px] ">
                                    {{ date('d M, Y', strtotime($data['action_date'])) }}
                                </h1>
                            </div>

                            <form method="POST" action="{{ route('purchase-store') }}" id="purchaseSubmitForm">
                                @csrf
                                <div class="md:text-center">
                                    <h1 class="text-primary font-poppins text-sm  font-semibold mb-2">Choose Location :
                                    </h1>
                                    <select name="location_id" id="" class="select2 w-[120px]" required>
                                        <option value="none" selected>None</option>
                                        @foreach ($locations as $location)
                                            <option value="{{ $location->id }}">{{ $location->location_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                        </div>
                    </div>
                    {{-- purchase information end --}}


                    {{-- ....................  --}}
                    {{-- purchase product table start  --}}
                    <div class="bg-white p-7 rounded-[20px] mt-5">
                        <div class="flex items-center justify-between flex-wrap gap-2 ">
                            <h1 class="text-noti font-semibold  mb-2 md:mb-0 font-jakarta">Purchased Products</h1>
                            <h1 class="text-noti font-semibold text-sm font-poppins">Total Quantity : <span
                                    class="ml-3 text-paraColor font-medium">{{ number_format($data['total_quantity']) ?? 0 }}</span>
                            </h1>
                        </div>

                        {{-- table start --}}
                        <div class="data-table">
                            <div class="  bg-white  font-poppins rounded-[20px]  ">

                                <div>

                                    <div class="relative overflow-x-auto shadow-lg mt-3">
                                        <table class="w-full text-sm  text-gray-500 ">
                                            <thead class="text-sm text-left text-primary font-jakarta bg-gray-50  ">
                                                <tr>
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
                                                        Type
                                                    </th>
                                                    <th scope="col" class="px-6 py-3 whitespace-nowrap">
                                                        Design
                                                    </th>
                                                    <th scope="col" class="px-6 py-3 whitespace-nowrap text-right">
                                                        Buying Price
                                                    </th>
                                                    <th scope="col" class="px-6 py-3 whitespace-nowrap">
                                                        Quantity
                                                    </th>
                                                    <th scope="col" class="px-6 py-3 whitespace-nowrap text-right">
                                                        Amount
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
                                                            {{ $product->type?->name ?? '-' }}

                                                        </td>
                                                        <td class="px-6 py-4 whitespace-nowrap">
                                                            {{ $product->design?->name ?? '-' }}

                                                        </td>
                                                        <td class="px-6 py-4 whitespace-nowrap text-right text-noti">
                                                            {{ number_format($product_data->buying_price) ?? '-' }}

                                                        </td>
                                                        <td class="px-6 py-4 whitespace-nowrap text-center">
                                                            {{ number_format($product_data->quantity) ?? '-' }}

                                                        </td>
                                                        <td class="px-6 py-4 whitespace-nowrap text-right text-noti">
                                                            {{ number_format($product_data->quantity * $product_data->buying_price) ?? '-' }}
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
                                <h1 class="text-primary font-semibold mb-1 ">Supplier</h1>
                                <h1 class="text-paraColor text-sm">Supplier Information</h1>
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
                        <div class="flex justify-between my-3">
                            <div>
                                <h1 class="text-primary font-semibold mb-1  ">Product</h1>
                                <h1 class="text-paraColor text-sm">Products details to be ordered</h1>
                            </div>
                            <div class="">
                                <div class="w-12 h-12 flex items-center justify-center mb-3 bg-primary  rounded-full">
                                    <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 448 512">
                                        <path
                                            d="M438.6 105.4c12.5 12.5 12.5 32.8 0 45.3l-256 256c-12.5 12.5-32.8 12.5-45.3 0l-128-128c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0L160 338.7 393.4 105.4c12.5-12.5 32.8-12.5 45.3 0z"
                                            fill="#FFFFFF" />
                                    </svg>
                                </div>
                                <div class="w-[2px] h-36 bg-primary mx-auto "></div>
                            </div>
                        </div>
                        <div class="flex justify-between mb-10">
                            <div>
                                <h1 class="text-primary font-semibold mb-1  ">Payment</h1>
                                <h1 class="text-paraColor text-sm">The final steps to be purchased</h1>
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

                        <input type="hidden" name="data" value="{{ json_encode($data) }}">
                        <div>
                            <button id="submitButton"
                                class="bg-primary rounded-full w-full py-2 text-white font-poppins text-sm mb-5"
                                type="submit">Confirm Purchase</button>
                            <a href="{{ route('purchase') }}">
                                <button
                                    class="outline outline-1 outline-noti rounded-full w-full py-2 text-noti font-poppins text-sm mb-5"
                                    type="button">Cancel Purchase</button>
                            </a>

                        </div>
                        </form>
                    </div>

                </div>
                {{-- progress end --}}

            </div>
            <div class="mt-5 lg:hidden flex justify-center">

                <form method="POST" action="{{ route('purchase-store') }}">
                    @csrf
                    <input type="hidden" name="data" value="{{ json_encode($data) }}">
                    <input type="hidden" name="payment_type" value="{{ $payment_type->id }}">

                    <div class="flex flex-col ">
                        <button id="submitButton"
                            class="bg-primary rounded-full w-[300px] py-2 text-white font-poppins text-sm mb-5"
                            type="submit">Confirm</button>
                        <button
                            class="outline outline-1 outline-noti rounded-full w-[300px] py-2 text-noti font-poppins text-sm mb-5"
                            type="button">Cancel Purchase</button>
                    </div>
                </form>
            </div>
        </div>
        {{-- main end --}}

    </section>
@endsection

@section('script')

    <script>
        // Disable the button immediately after submitting the form
        document.getElementById('purchaseSubmitForm').addEventListener('submit', function(event) {
            event.preventDefault();

            const submitButton = document.getElementById('submitButton');
            submitButton.disabled = true;
            submitButton.innerHTML = "Processing...";
            submitButton.style.opacity = '0.5';

            this.submit();
        });
    </script>

@endsection
