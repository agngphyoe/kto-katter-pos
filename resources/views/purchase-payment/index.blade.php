@extends('layouts.master')
@section('title', 'Purchase Payments List')
@section('mainTitle', 'Purchase Payments List')

@section('css')

@endsection
@section('content')
    <section class="purchase payment">
        <x-search-com routeName="purchase-payment-create-first" exportName="purchase-payment" name="Create a Purchase Payment"
            permissionName="purchase-payment-create" />

        <div class=" md:ml-[270px] font-jakarta my-5 ml-[20px] mr-[20px] 2xl:ml-[320px]">
            {{-- table start --}}
            <div class="data-table mt-5">
                <div class="bg-white px-4 py-4 font-jakarta rounded-[20px] ">
                    <div class="flex items-center justify-between mb-3">
                        <h1 class="text-[#999999] font-poppins text-sm">Search Result :
                            <span class="showTotal text-primary">0</span>
                        </h1>
                        <h1 class="text-[#999999] font-poppins text-sm">Number of Payments :
                            <span class="text-primary">{{ $payments->count() }}</span>
                        </h1>
                    </div>
                    <div>
                        <div class=" overflow-x-auto h-[450px] shadow-lg    ">
                            <table class="w-full text-sm  text-gray-500 ">
                                <thead class="sticky top-0 text-sm   z-10   bg-gray-100 text-primary  ">
                                    {{-- <x-table-head-component :columns="[
                                    'Supplier Name',
                                    'Purchase Invoice',
                                    'Total Amount',
                                    'Discount',
                                    'Cash Down',
                                    'Net Amount',
                                    'Total Paid Amount',
                                    'Remaining Amount',
                                    'Progress',
                                    'Payment Date',
                                    'Created By',
                                    'Action']" /> --}}
                                    <tr class="text-left border-b">
                                        <th
                                            class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-left">
                                            Supplier Name
                                        </th>
                                        <th
                                            class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-left">
                                            Purchase Invoice
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
                                            Payment Date
                                        </th>
                                        <th
                                            class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-left">
                                            Created By
                                        </th>
                                        <th
                                            class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-center">
                                            Action
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="font-poppins text-sm" id="searchResults">
                                    @include('purchase-payment.search')
                                </tbody>
                            </table>
                        </div>
                        {{ $payments->links('layouts.paginator') }}

                    </div>


                </div>
            </div>
            {{-- table end  --}}

        </div>
    </section>
@endsection

@section('script')
    <script>
        clearLocalStorage();

        $(document).ready(function() {
            var searchRoute = "{{ route('purchase-payment') }}";

            executeSearch(searchRoute)
        });
    </script>
@endsection
