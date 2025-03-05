@extends('layouts.master-without-nav')
@section('title', 'Supplier Details')
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
            'title' => 'Supplier Detail View',
            'subTitle' => 'The detail of Supplier',
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
                    {{-- <div class="flex items-center mb-2 gap-4 justify-end">
                        <a href="{{ route('supplier-list') }}">
                            <i class="fa-solid fa-house-chimney text-noti"></i>
                        </a>
                        @if (auth()->user()->hasPermissions('supplier-delete'))
                            @if (!$supplier->purchases?->first())
                                <a href="#" data-route="{{ route('supplier-delete', $supplier->id) }}"
                                    data-redirect-route="supplier/list" class="deleteAction">
                                    <i class="fa-solid fa-trash-can text-red-500"></i>
                                </a>
                            @endif
                        @endif

                        <a href="{{ route('supplier-edit', ['supplier' => $supplier->id]) }}">
                            <i class="fa-solid fa-pencil text-primary"></i>
                        </a>


                    </div> --}}
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
                    {{-- contact person information end --}}
                    {{-- <a href="{{ route('supplier.payment-detail', ['supplier' => $supplier->id]) }}"
                        class="outline outline-1 text-noti text-sm font-bold outline-noti bg-white px-6 float-right rounded-full mt-10 py-2">Payment History</a> --}}
                </div>
            </div>
        </div>

        <div class="mx-5 lg:mx-20 mb-4">
            <div class="flex justify-between items-center mt-8">
                <!-- Total Amount Card -->
                <div class="w-1/3">
                    <div class="px-6 py-2 mb-5 bg-primary rounded-xl">
                        <div class="flex flex-col items-center justify-center">
                            <p class="font-semibold text-white">Total Purchase Amount</p>
                            <p class="text-white font-semibold">{{ number_format($supplier->total_purchase_amount) }}
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Total Remaining Card -->
                <div class="w-1/3">
                    <div class="px-6 py-2 mb-5 bg-noti rounded-xl">
                        <div class="flex flex-col items-center justify-center">
                            <p class="font-semibold text-white">Total Payables Amount</p>
                            <p class="text-white font-semibold">{{ number_format($supplier->total_remaining_amount) }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid mx-5 lg:mx-20 mb-4">
            <div class="bg-white p-6 rounded-lg shadow-md">
                <div class="flex items-center justify-between mb-3">
                    <h1 class="text-xl font-semibold text-primary">Purchases</h1>
                    @if (!$supplier->purchases->isEmpty())
                        <a href="{{ route('purchase', ['supplier_id' => $supplier->id]) }}"
                            class="bg-primary text-white px-4 py-2 rounded-lg">
                            See More
                        </a>
                    @endif

                </div>
                <div class="overflow-x-auto max-h-60 custom-scrollbar" style='max-height: 250px;'>
                    <table class="w-full text-center">
                        <thead class="text-sm sticky top-0 text-right z-10 text-primary bg-gray-50 font-jakarta">
                            {{-- <x-table-head-component :columns="[
                                'Purchase ID',
                                'Purchased Date',
                                'Type',
                                'Purchase Amount',
                                'Action',
                            ]" /> --}}
                            <tr class="text-left border-b">
                                <th class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-left">
                                    Purchase ID
                                </th>
                                <th class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-left">
                                    Purchased Date
                                </th>
                                <th class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-left">
                                    Type
                                </th>
                                <th class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-right">
                                    Net Amount
                                </th>
                                <th
                                    class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-center">
                                    Action
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse ($supplier->purchases->reverse()->take(3) as $purchase)
                                <tr class="bg-white border-b text-left ">
                                    <td
                                        class=" py-4 px-6 whitespace-nowrap text-paraColor font-poppins text-[13px] text-left">
                                        {{ $purchase->invoice_number }}
                                    </td>
                                    <td
                                        class="py-4 px-6 whitespace-nowrap text-paraColor font-poppins text-[13px] text-left">
                                        {{ dateFormat($purchase->action_date) }}
                                    </td>
                                    <td
                                        class="py-4 px-6 whitespace-nowrap text-paraColor font-poppins text-[13px] text-left">
                                        {{ $purchase->action_type }}
                                    </td>
                                    <td
                                        class="py-4 px-6 whitespace-nowrap text-paraColor font-poppins text-[13px] text-right">
                                        {{ number_format($purchase->purchase_amount) }}
                                    </td>
                                    <td class="text-right align-middle">
                                        <a href="{{ route('purchase-detail', ['purchase' => $purchase->id]) }}"
                                            class="bg-white outline outline-1 outline-primary h-8 w-8 flex items-center justify-center rounded-full mx-auto">
                                            <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 576 512"
                                                class="mx-auto">
                                                <path
                                                    d="M288 80c-65.2 0-118.8 29.6-159.9 67.7C89.6 183.5 63 226 49.4 256c13.6 30 40.2 72.5 78.6 108.3C169.2 402.4 222.8 432 288 432s118.8-29.6 159.9-67.7C486.4 328.5 513 286 526.6 256c-13.6-30-40.2-72.5-78.6-108.3C406.8 109.6 353.2 80 288 80zM95.4 112.6C142.5 68.8 207.2 32 288 32s145.5 36.8 192.6 80.6c46.8 43.5 78.1 95.4 93 131.1c3.3 7.9 3.3 16.7 0 24.6c-14.9 35.7-46.2 87.7-93 131.1C433.5 443.2 368.8 480 288 480s-145.5-36.8-192.6-80.6C48.6 356 17.3 304 2.5 268.3c-3.3-7.9-3.3-16.7 0-24.6C17.3 208 48.6 156 95.4 112.6zM288 336c44.2 0 80-35.8 80-80s-35.8-80-80-80c-.7 0-1.3 0-2 0c1.3 5.1 2 10.5 2 16c0 35.3-28.7 64-64 64c-5.5 0-10.9-.7-16-2c0 .7 0 1.3 0 2c0 44.2 35.8 80 80 80zm0-208a128 128 0 1 1 0 256 128 128 0 1 1 0-256z"
                                                    fill="#00812C" />
                                            </svg>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                @include('layouts.not-found', ['colSpan' => 5])
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- <div class="grid mx-5 lg:mx-20 mt-8">
            <div class="bg-white p-6 rounded-lg shadow-md">
                <h1 class="mb-3 text-xl font-semibold text-primary">Payments</h1>
                <div class="overflow-x-auto max-h-60 custom-scrollbar" style='max-height: 250px;'>
                    <table class="w-full text-center">
                        <thead class="text-sm sticky top-0 text-right z-10 text-primary bg-gray-50 font-jakarta">
                            <x-table-head-component :columns="[
                                'Purchase ID',
                                'Purchased Date',
                                'Type',
                                'Purchase Amount',
                                'Action',
                            ]" />
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse ($supplier->purchases->reverse()->take(3) as $purchase)
                                <tr class="bg-white border-b text-left ">
                                    <td
                                        class=" py-4 px-6 whitespace-nowrap text-paraColor font-poppins text-[13px] text-left">
                                        {{ $purchase->invoice_number }}
                                    </td>
                                    <td
                                        class="py-4 px-6 whitespace-nowrap text-paraColor font-poppins text-[13px] text-left">
                                        {{ dateFormat($purchase->action_date) }}
                                    </td>
                                    <td
                                        class="py-4 px-6 whitespace-nowrap text-paraColor font-poppins text-[13px] text-left">
                                        {{ $purchase->action_type }}
                                    </td>
                                    <td
                                        class="py-4 px-6 whitespace-nowrap text-paraColor font-poppins text-[13px] text-right">
                                        {{ number_format($purchase->purchase_amount) }}
                                    </td>
                                    <td class="text-center align-middle">
                                        <a href="{{ route('purchase', ['supplier_id' => $supplier->id]) }}"
                                            class="bg-white outline outline-1 outline-primary h-8 w-8 flex items-center justify-center rounded-full mx-auto">
                                            <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 576 512"
                                                class="mx-auto">
                                                <path
                                                    d="M288 80c-65.2 0-118.8 29.6-159.9 67.7C89.6 183.5 63 226 49.4 256c13.6 30 40.2 72.5 78.6 108.3C169.2 402.4 222.8 432 288 432s118.8-29.6 159.9-67.7C486.4 328.5 513 286 526.6 256c-13.6-30-40.2-72.5-78.6-108.3C406.8 109.6 353.2 80 288 80zM95.4 112.6C142.5 68.8 207.2 32 288 32s145.5 36.8 192.6 80.6c46.8 43.5 78.1 95.4 93 131.1c3.3 7.9 3.3 16.7 0 24.6c-14.9 35.7-46.2 87.7-93 131.1C433.5 443.2 368.8 480 288 480s-145.5-36.8-192.6-80.6C48.6 356 17.3 304 2.5 268.3c-3.3-7.9-3.3-16.7 0-24.6C17.3 208 48.6 156 95.4 112.6zM288 336c44.2 0 80-35.8 80-80s-35.8-80-80-80c-.7 0-1.3 0-2 0c1.3 5.1 2 10.5 2 16c0 35.3-28.7 64-64 64c-5.5 0-10.9-.7-16-2c0 .7 0 1.3 0 2c0 44.2 35.8 80 80 80zm0-208a128 128 0 1 1 0 256 128 128 0 1 1 0-256z"
                                                    fill="#00812C" />
                                            </svg>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                @include('layouts.not-found', ['colSpan' => 5])
                            @endforelse

                        </tbody>
                    </table>

                </div>
                @if (!$supplier->purchases->isEmpty())
                    <div class="flex justify-center">
                        <a href="{{ route('purchase', ['supplier_id' => $supplier->id]) }}"
                            class="bg-primary text-white font-jakarta font-semibold mt-10 px-20 py-2 rounded-full">See More</a>
                    </div>
                @endif
            </div>
        </div> --}}

        <div class="flex justify-center mt-3">
            <a href="{{ route('supplier-list') }}"
                class="bg-noti text-white font-jakarta font-semibold px-20 py-2 rounded-full">Back</a>
        </div>

        {{-- detail end --}}
    </section>
@endsection
@section('script')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const dropdownBtn = document.getElementById("dropdown-btn");
            const dropdownMenu = document.getElementById("dropdown-menu");

            dropdownBtn.addEventListener("click", function() {
                dropdownMenu.classList.toggle("hidden");
            });
        });
    </script>

@endsection
