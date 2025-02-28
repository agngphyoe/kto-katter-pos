@extends('layouts.master')
@section('title', 'Purchase Returns List')
@section('mainTitle', 'Purchase Returns List')

@section('css')

@endsection
@section('content')
    <section class="purchase__return">
        {{-- search start --}}
        <x-search-com routeName="purchase-return-create-first" exportName="purchase-returns" name="Create Purchase Return"
            permissionName="return-purchase-create" />
        {{-- search end  --}}


        {{-- ..............  --}}
        {{-- table start  --}}
        <div class=" md:ml-[270px] font-jakarta my-5 mx-[20px] 2xl:ml-[320px]">
            <div class="data-table mt-5">
                <div class="  bg-white px-4 py-2 font-poppins rounded-[20px]  ">

                    <div>
                        <div class=" overflow-x-auto shadow-lg mt-3">
                            <table class="w-full text-sm text-left text-gray-500 ">
                                <thead class=" font-jakarta  bg-gray-50  text-primary  ">

                                    {{-- <x-table-head-component :columns="[
                                        'Purchase Return Number',
                                        'Purchase ID',
                                        'Supplier Name',
                                        'Purchase Type',
                                        'Return Quantity',
                                        'Return Remark',
                                        'Return Date',
                                        'Return By',
                                        'Action',
                                    ]" /> --}}
                                    <tr class="text-left border-b">
                                        <th
                                            class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-left">
                                            Purchase Return Number
                                        </th>
                                        <th
                                            class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-left">
                                            Purchase ID
                                        </th>
                                        <th
                                            class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-left">
                                            Supplier Name
                                        </th>
                                        <th
                                            class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-left">
                                            Purchase Type
                                        </th>
                                        <th
                                            class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-center">
                                            Return Quantity
                                        </th>
                                        <th
                                            class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-left">
                                            Return Remark
                                        </th>
                                        <th
                                            class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-left">
                                            Return Date
                                        </th>
                                        <th
                                            class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-left">
                                            Return By
                                        </th>
                                        <th
                                            class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-left">
                                            Action
                                        </th>
                                    </tr>
                                </thead>
                                <tbody id="searchResults">
                                    @include('purchase-return.search')
                                </tbody>
                            </table>
                        </div>
                        {{ $purchase_returns->links('layouts.paginator') }}

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
            var searchRoute = "{{ route('purchase-return') }}";

            executeSearch(searchRoute);
            clearLocalStorage();

        });
    </script>
@endsection
