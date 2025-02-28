@extends('layouts.master')
@section('title', 'POS Returns List')
@section('mainTitle', 'POS Returns List')

@section('css')

@endsection
@section('content')
    <section class="purchase__return">
        {{-- search start --}}
        <x-search-com routeName="pos-return-create-first" exportName="pos-returns" name="Create POS Return"
            permissionName="pos-return-create" />
        {{-- search end  --}}


        {{-- ..............  --}}
        {{-- table start  --}}
        <div class=" md:ml-[270px] font-jakarta my-5 mx-[20px] 2xl:ml-[320px]">
            <div class="data-table mt-5">
                <div class="bg-white px-4 py-2 font-poppins rounded-[20px]">

                    <div>
                        <div class=" overflow-x-auto shadow-lg mt-3">
                            <table class="w-full text-sm text-left text-gray-500 ">
                                <thead class=" font-jakarta  bg-gray-50  text-primary  ">

                                    {{-- <x-table-head-component :columns="[
                                        'Sale Return ID',
                                        'Sale ID',
                                        'Customer Name',
                                        // 'Total Quantity',
                                        // 'Buying Amount',
                                        'Refund Amount',
                                        'Return Quantity',
                                        'Remark',
                                        'Return Date',
                                        'Return By',
                                        'Action',
                                    ]" /> --}}
                                    <tr class="text-left border-b">
                                        <th
                                            class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-left">
                                            Sale Return ID</th>
                                        <th
                                            class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-left">
                                            Sale ID</th>
                                        <th
                                            class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-left">
                                            Customer Name</th>
                                        <th
                                            class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-right">
                                            Refund Amount</th>
                                        <th
                                            class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-center">
                                            Return Quantity</th>
                                        <th
                                            class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-left">
                                            Remark</th>
                                        <th
                                            class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-left">
                                            Return Date</th>
                                        <th
                                            class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-left">
                                            Return By</th>
                                        <th
                                            class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-center">
                                            Action</th>
                                    </tr>
                                </thead>
                                <tbody id="searchResults">
                                    @include('pos-return.search')
                                </tbody>
                            </table>
                        </div>
                        {{ $returns->links('layouts.paginator') }}

                    </div>


                </div>
            </div>
        </div>

        {{-- table end --}}
    </section>
@endsection
@section('script')
    <script>
        $(document).ready(function() {
            var searchRoute = "{{ route('pos-return-list') }}";

            executeSearch(searchRoute);
            clearLocalStorage();

        });
    </script>
@endsection
