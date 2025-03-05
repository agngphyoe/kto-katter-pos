@extends('layouts.master-without-nav')
@section('title', 'Supplier Cashback Details')
@section('css')
    <style>
        .my-title {
            font-family: 'Plus Jakarta Sans', sans-serif;
            color: black;
            font-size: 20px;

        }

        .confirm-Button {
            color: #00812C;
            border: 1px solid #00812C;
            padding: 7px 40px;
            border-radius: 20px;
            margin-left: 10px;
            font-weight: 600;
            font-size: 20px;
        }

        .cancel-Button {
            color: #ff4c4a;
            border: 1px solid #ff4c4a;
            padding: 7px 40px;
            border-radius: 20px;

            font-weight: 600;
            font-size: 20px;
        }

        .confirm-Button:hover {
            background-color: #00812C;
            color: white;
        }

        .cancel-Button:hover {
            background-color: #ff4c4a;
            color: white;
        }

        .bg-headColor {
            background-color: #FFC727;
        }

        .bg-thirdy {
            background-color: #ff4c4a;
        }
    </style>

@endsection
@section('content')
    <section class="supplier-detail">
        {{-- nav start  --}}
        @include('layouts.header-section', [
            'title' => 'Supplier Cashback Details',
            'subTitle' => 'The detail of Supplier Cashback',
        ])
        {{-- nav end  --}}

        {{-- detail start  --}}

        <div class="mx-5 lg:mx-20  bg-white rounded-[20px] font-jakarta mt-10">
            <div class="grid grid-cols-1 xl:grid-cols-4 px-5 pb-10 lg:px-10  xl:px-16  gap-5">
                <div class="col-span-1  xl:col-span-1 px-1 2xl:px-16   ">
                    <div class="bg-gray-100 mt-10 mx-0 sm:mx-44 xl:mx-0  px-5  py-10 rounded-[20px] ">
                        <div class="">
                            @if ($supplier->image)
                                <img src="{{ asset('suppliers/image/' . $supplier->image) }}"
                                    class="w-40  h-40 object-cover rounded-full mx-auto" alt="">
                            @else
                                <img src="{{ asset('images/no-image.png') }}" class="w-40  h-40 rounded-full mx-auto"
                                    alt="">
                            @endif
                            <div class="text-center">
                                <h1 class="text-primary text-sm font-medium my-2 ">{{ $supplier->name }}</h1>
                                <h1 class="text-noti text-sm font-medium">{{ $supplier->user_number }}</h1>
                            </div>
                        </div>

                    </div>


                </div>
                <div class="col-span-1 xl:col-span-3 my-6 ">
                    
                    {{-- supplier detail start --}}

                    <div class="mb-4">
                        <h1 class="text-noti  font-medium text-center mb-3 ">Supplier Details</h1>
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-2 ">
                            <x-information title="Phone Number" subtitle="{{ $supplier->phone }}" />
                            <x-information title="Country" subtitle="{{ $supplier->country?->name }}" />
                            <x-information title="Address" subtitle="{{ $supplier->address }}" />


                        </div>
                    </div>
                    {{-- supplier detail end --}}
                    <div class="border border-dashed  "></div>
                    {{-- contact person information start --}}
                    <div class=" mt-3">
                        <h1 class="text-noti  font-medium text-center mb-3">Contact Person information</h1>
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-2">
                            <x-information title="Name" subtitle="{{ $supplier->contact_name }}" />
                            <x-information title="Phone Number" subtitle="{{ $supplier->contact_phone }}" />
                            <x-information title="Position" subtitle="{{ $supplier->contact_position }}" />
                            <x-information title="Created By" subtitle="{{ $supplier->user?->name }}" />
                        </div>
                    </div>

                    <div class="mt-6">
                        <h1 class="text-noti  font-medium text-center mb-2">Total Cashback Remaining Amount</h1>
                        <div class="flex justify-center">
                            <h1 class="text-paraColor font-poppins text-[19px] whitespace-nowrap">
                                {{ number_format($remaining_cashback) }} Ks
                            </h1>                          
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="mx-5 lg:mx-20 data-table mt-5">
            
            <div class="bg-white px-1 py-2 font-poppins rounded-[20px]">
                <h1 class="mt-2 font-poppins font-medium ml-2 text-noti">Product Data</h1>
                <div>
                    <div class="relative overflow-x-auto mt-3 shadow-lg">
                        <table class="w-full text-sm text-center text-gray-500">
                            <thead class="text-sm text-primary bg-gray-50 font-medium font-poppins">

                                <tr class="text-left border-b">
                                    <th
                                        class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-left">
                                        Product Name (Code)
                                    </th>
                                    <th
                                        class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-left">
                                        Sale ID
                                    </th>
                                    <th
                                        class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-left">
                                        IMEI
                                    </th>
                                    <th
                                        class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-right">
                                        Cashback Amount
                                    </th>
                                    <th
                                        class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-right">
                                        Status
                                    </th>                               
                                </tr>
                            </thead>
                            <tbody class="text-sm font-normal text-paraColor font-poppins text-center">
                                @forelse($cashback_products as $data)
                                    @php
                                        $product = \App\Models\Product::find($data->product_id);
                                    @endphp
                                    <tr class="bg-white border-b text-left">
                                        <th scope="row"
                                            class="px-6 py-4 whitespace-nowrap font-medium text-gray-900">
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
                                        </th>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            {{ $data->pointOfSale->order_number }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-noti">
                                            {{ $data->imei }}

                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right">
                                            {{ number_format($data->amount) }}
                                        </td>
                                        <td class="px-4 py-4 whitespace-nowrap text-right">
                                            @switch($data->payment_status)
                                            @case('paid')
                                                <x-badge class="bg-green-600 text-white px-2">
                                                    Paid
                                                </x-badge>
                                            @break
                            
                                            @case('unpaid')
                                                <x-badge class="bg-yellow-400 text-white px-2">
                                                    Unpaid
                                                </x-badge>
                                            @break
                            
                                            @default
                                        @endswitch
                                        </td>                                 
                                    </tr>
                                @empty
                                    @include('layouts.not-found', ['colSpan' => 6])
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>


        <div class="flex justify-center mt-5 gap-3 mb-5">
            @if (auth()->user()->hasPermissions('pos-receivable-change-status'))
                @if ($remaining_cashback > 0)
                <a href="{{ route('pos-cashback-change-status', ['supplier' => $supplier->id]) }}"
                    class="bg-primary text-white font-jakarta font-semibold px-20 py-2 rounded-full">Receive</a>
                @endif          
            @endif
            
            <a href="{{ route('pos-cashback-list') }}"
                class="bg-noti text-white font-jakarta font-semibold px-20 py-2 rounded-full">Back</a>
        </div>

        {{-- detail end --}}
    </section>
@endsection
@section('script')
<script>
    $('#done_btn').on('click', function() {

        var cashback_id = $('#cashback_id').val();
        alert(cashback_id);
        $.ajax({
            url: "",
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                name: name,
                phone: phone,
                address: address,
            },
            success: function(response) {

                // response.data.forEach(function(shopper) {
                //     $('#shopper_select').append('<option value="' + shopper.id + '">' + shopper.name + '</option>');
                // });

                // $('#shopper_cancel_btn').click();
                // $('#shopper_error_msg').css('display', 'none');
            },
            error: function(xhr, status, error) {
            }
        });
    });
</script>
@endsection
