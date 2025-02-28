@extends('layouts.master-without-nav')
@section('title', 'Create Payment')
@section('css')
    @php

        use App\Constants\ExchangeCashType;

    @endphp
    <style>
        /* Style for the progress bar container */
        .progress {
            width: 100%;
            background-color: #f0f0f0;
            border-radius: 4px;
            height: 20px;
            overflow: hidden;
        }

        /* Style for the progress bar itself */
        .progress-bar {
            height: 100%;
            color: #fff;
            text-align: center;
            line-height: 20px;
            /* To center the percentage text vertically */
            background-color: #007bff;
            /* Change this to your desired color */
            transition: width 0.3s ease-in-out;
            /* Animation for smooth width transition */
        }
    </style>

@endsection
@section('content')
    <section class="purchase__payment__create__second">
        {{-- nav start  --}}
        @include('layouts.header-section', [
            'title' => 'Purchase Payment Create',
            'subTitle' => 'Choose the purchase to create a payment',
        ])
        {{-- nav end  --}}

        {{-- main start  --}}
        <div class="m-5 lg:m-7">

            {{-- search start --}}
            <div class="data-serch font-poppins text-[15px]">
                <div
                    class="bg-white flex justify-start xl:justify-between flex-wrap gap-4 px-4 py-4 rounded-[20px]  md:ml-[250px] my-5">

                    <div class="flex items-center gap-4 animate__animated animate__zoomIn">

                        <div class="flex items-center w-full outline outline-1 outline-primary rounded-full px-4 py-[7px]">
                            <input type="search" class="outline-none outline-transparent" placeholder="Search..."
                                id="searchInput" value="{{ request()->get('search') }}">

                            <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 512 512">

                                <path
                                    d="M416 208c0 45.9-14.9 88.3-40 122.7L502.6 457.4c12.5 12.5 12.5 32.8 0 45.3s-32.8 12.5-45.3 0L330.7 376c-34.4 25.2-76.8 40-122.7 40C93.1 416 0 322.9 0 208S93.1 0 208 0S416 93.1 416 208zM208 352a144 144 0 1 0 0-288 144 144 0 1 0 0 288z"
                                    fill="#00812C" />
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
            {{-- search end  --}}

            {{-- table start --}}
            <div class="data-table mt-5">
                <div class="  bg-white px-4 py-2 font-jakarta rounded-[20px]  ">
                    <div>
                        <div class="relative overflow-x-auto mt-4  ">
                            <table class="w-full text-sm text-left text-gray-500 ">
                                <thead class="text-sm  bg-gray-50  text-primary  ">

                                    {{-- <x-table-head-component :columns="[
                                    'Purchase Invoice',
                                    'Purchase Type',
                                    'Currency Type',
                                    'Total Amount',
                                    'Discount',
                                    'Cash Down',
                                    'Net Amount',
                                    'Total Paid Amount',
                                    'Remaining Amount',
                                    'Progress',
                                    'Received At',
                                    'Action']" /> --}}
                                    <tr class="text-left border-b">
                                        <th
                                            class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-left">
                                            Purchase Invoice
                                        </th>
                                        <th
                                            class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-left">
                                            Purchase Type
                                        </th>
                                        <th
                                            class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-left">
                                            Currency Type
                                        </th>
                                        <th
                                            class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-right">
                                            Total Amount
                                        </th>
                                        <th
                                            class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-right">
                                            Discount
                                        </th>
                                        <th
                                            class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-right">
                                            Cash Down
                                        </th>
                                        <th
                                            class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-right">
                                            Net Amount
                                        </th>
                                        <th
                                            class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-right">
                                            Total Paid Amount
                                        </th>
                                        <th
                                            class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-right">
                                            Remaining Amount
                                        </th>
                                        <th
                                            class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-left">
                                            Progress
                                        </th>
                                        <th
                                            class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-left">
                                            Received At
                                        </th>
                                        <th
                                            class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-center">
                                            Action
                                        </th>
                                    </tr>
                                </thead>
                                {{-- form start --}}
                                <form action="{{ route('purchase-payment-create-third') }}" id="myForm">
                                    @csrf
                                    <input id="purchase_id" name="purchase_id" hidden>
                                </form>

                                <tbody class="font-poppins text-[13px] text-left" id="purchasePaymentTableBody">
                                    @include('purchase-payment.search-purchase')
                                </tbody>
                            </table>
                            {{-- {{ $purchases->appends(['supplier_id' => $supplier_id])->links('layouts.paginator') }} --}}
                        </div>
                        {{ $purchases->appends(['supplier_id' => $supplier_id])->links('layouts.paginator') }}
                    </div>

                </div>
            </div>
        </div>

        {{-- table end  --}}

        {{-- main end --}}
    </section>
@endsection
@section('script')
    <script src="{{ asset('js/SearchFilter.js') }}"></script>

    <script>
        function getRouteNameFromUrl() {
            var url = window.location.href;

            var pathName = new URL(url).pathname;

            var parts = pathName.split("/").filter((part) => part !== "");

            if (parts.length >= 2) {
                return parts.slice(-2).join("/");
            } else {
                return parts[0] || null;
            }
        }
    </script>

    <script>
        $('.selectBtn').on('click', function() {
            var purchase_id = $(this).data('sale-id');
            $('#purchase_id').val(purchase_id);
            $('#myForm').submit();
        });
    </script>

    <script>
        $(document).ready(function() {
            var searchRoute = "{{ route('purchase-payment-search-purchase') }}";
            var supplierId = @json($supplier_id);

            $('#searchInput').on('input', function() {
                var searchValue = $(this).val();
                $.ajax({
                    url: searchRoute,
                    type: 'GET',
                    data: {
                        search: searchValue,
                        supplier_id: supplierId
                    },
                    success: function(response) {
                        if (response.success) {
                            $('#purchasePaymentTableBody').html(response.html);
                        } else {
                            alert(response.message);
                        }
                    }
                });
            });

            clearLocalStorage();
        });
    </script>

@endsection
