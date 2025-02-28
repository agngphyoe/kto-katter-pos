@extends('layouts.master-without-nav')
@section('title', 'POS Return Create')
@section('css')

@endsection
@section('content')
    <section class="damage__create__final">
        {{-- nav start  --}}
        @include('layouts.header-section', [
            'title' => 'Create A New POS Return',
            'subTitle' => '',
        ])
        {{-- nav end  --}}

        <div class="lg:mx-[30px] m-5 lg:my-[30px]">
            <div class="bg-white shadow-xl mb-[30px] rounded-[20px] p-4 sm:p-10 font-poppins">
                <div class="flex items-center justify-around flex-wrap gap-4">
                    <x-information title="POS ID" subtitle="{{ $purchase->order_number }}" />
                    <x-information title="Remarks" subtitle="{{ $remark }}" />
                    <x-information title="Date" subtitle="{{ dateFormat($return_date) }}" />
                    <x-information title="Location" subtitle="{{ $purchase->location->location_name }}" />
                    <x-information title="Created By" subtitle="{{ auth()->user()->name }}" />
                    {{-- <x-information title="Total Return Quantity" subtitle="{{ $quantity_count }}" />
                    <x-information title="Old Amount" subtitle="{{ number_format($purchase->net_amount) }}" />
                    <x-information title="New Amount" subtitle="{{ number_format($new_purchase_amount) }}" /> --}}
                    <div>
                        <h1 class="text-primary font-poppins text-left text-sm mb-2 font-semibold">Total Return Quantity
                        </h1>
                        <h1 class="text-paraColor font-poppins text-[13px] text-center whitespace-nowrap">
                            {{ $quantity_count }}
                        </h1>
                    </div>
                    <div>
                        <h1 class="text-primary font-poppins text-left text-sm mb-2 font-semibold">Old Amount</h1>
                        <h1 class="text-paraColor font-poppins text-[13px] text-right whitespace-nowrap">
                            {{ number_format($purchase->net_amount) }}
                        </h1>
                    </div>
                    <div>
                        <h1 class="text-primary font-poppins text-left text-sm mb-2 font-semibold">New Amount</h1>
                        <h1 class="text-paraColor font-poppins text-[13px] text-right whitespace-nowrap">
                            {{ number_format($new_purchase_amount) }}
                        </h1>
                    </div>
                </div>
                <div class="flex items-center justify-around flex-wrap gap-4 mt-4">

                </div>
            </div>

            {{-- table start  --}}
            <div class="data-table mt-5">
                <div class="  bg-white px-4 py-2 font-poppins rounded-[20px]  ">
                    <div>
                        <div class="relative overflow-y-auto  overflow-x-auto  shadow-lg ">
                            <table class="w-full text-sm   text-gray-500 ">
                                <thead class="  bg-gray-50  font-jakarta text-primary  ">
                                    {{-- <x-table-head-component :columns="[
                                        'Product Name',
                                        'Categories',
                                        'Brand',
                                        'Model',
                                        'Design',
                                        'Type',
                                        'Unit Price',
                                        'Return Type',
                                        'Return Quantity',
                                        'Return Amount',
                                        // 'Damage Amount'
                                    ]" /> --}}
                                    <tr class="text-left border-b">
                                        <th
                                            class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-left">
                                            Product Name</th>
                                        <th
                                            class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-left">
                                            Category</th>
                                        <th
                                            class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-left">
                                            Brand</th>
                                        <th
                                            class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-left">
                                            Model</th>
                                        <th
                                            class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-left">
                                            Design</th>
                                        <th
                                            class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-left">
                                            Type</th>
                                        <th
                                            class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-right">
                                            Unit Price</th>
                                        <th
                                            class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-left">
                                            Return Type</th>
                                        <th
                                            class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-center">
                                            Return Quantity</th>
                                        <th
                                            class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-right">
                                            Return Amount</th>
                                    </tr>
                                </thead>
                                <tbody class="font-poppins text-[13px]">
                                    @forelse($productData as $data)
                                        @php
                                            $product = App\Models\Product::find($data['product_id']);
                                        @endphp
                                        <tr class="bg-white border-b text-left ">
                                            <th scope="row" class="px-6 py-3 font-medium  whitespace-nowrap ">

                                                <div class="flex items-start gap-3">
                                                    <h1 class="text-paraColor text-left">{{ $product->name }} <span
                                                            class="text-noti">({{ $product->code }})</span></h1>
                                                </div>
                                            </th>
                                            <td class="px-6 py-3 whitespace-nowrap">
                                                {{ $product->category?->name }}
                                            </td>
                                            <td class="px-6 py-3 whitespace-nowrap">
                                                {{ $product->brand?->name }}

                                            </td>
                                            <td class="px-6 py-3 whitespace-nowrap">
                                                {{ $product->productModel?->name }}

                                            </td>
                                            <td class="px-6 py-3 whitespace-nowrap">
                                                {{ $product->design?->name ?? '-' }}

                                            </td>
                                            <td class="px-6 py-3 whitespace-nowrap">
                                                {{ $product->type?->name ?? '-' }}
                                            </td>

                                            <td class="px-6 py-3 whitespace-nowrap text-right">
                                                {{ number_format($data['unit_price']) }}
                                            </td>

                                            <td class="px-6 py-3 whitespace-nowrap">
                                                <x-badge class="bg-green-600 text-white px-2">
                                                    {{ $data['return_type'] == 'product' ? 'Exchange' : 'Cash' }}
                                                </x-badge>
                                            </td>

                                            <td class="px-6 py-3 whitespace-nowrap text-center">
                                                {{ $data['quantity'] }}
                                            </td>

                                            <td class="px-6 py-3 whitespace-nowrap text-right">
                                                {{ number_format($data['quantity'] * $data['unit_price']) }}
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

            <form method="post" action="{{ route('pos-return-store') }}">
                @csrf
                <input type="hidden" name="purchase_id" value="{{ $purchase->id }}">
                <input type="hidden" name="remark" value="{{ $remark }}">
                <input type="hidden" name="return_date" value="{{ $return_date }}">
                <input type="hidden" name="quantity_count" value="{{ $quantity_count }}">
                @foreach ($productData as $data)
                    <input type="hidden" name="product_id[]" value="{{ $data['product_id'] }}">
                    <input type="hidden" name="return_type[]" value="{{ $data['return_type'] }}">
                    <input type="hidden" name="quantity[]" value="{{ $data['quantity'] }}">
                @endforeach

                <div class=" mt-6 flex items-center justify-center flex-wrap gap-5">
                    <a href="{{ url()->previous() }}">
                        <x-button-component class="outline outline-1 outline-noti text-noti" type="button">
                            Cancel
                        </x-button-component>
                    </a>

                    <x-button-component class="bg-noti text-white" type="submit">
                        Done
                    </x-button-component>

                </div>
            </form>
        </div>
    </section>
@endsection
@section('script')
    <script>
        // Disable the button immediately after submitting the form
        document.getElementById('posReturnSubmitForm').addEventListener('submit', function(event) {
                    event.preventDefault();

                @endsection
