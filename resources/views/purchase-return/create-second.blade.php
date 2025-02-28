@extends('layouts.master-without-nav')
@section('title', 'Purchase Return Create')
@section('css')

@endsection
@section('content')
    <section class="purchase__return__create__third">
        {{-- nav start  --}}
        @include('layouts.header-section', [
            'title' => 'Create A New Purchase Return',
            'subTitle' => 'Choose the purchase',
        ])
        {{-- nav end  --}}


        {{-- ........  --}}
        {{-- main start  --}}
        <div class="m-5 lg:m-10">

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
                <div class="  bg-white px-4 py-2 font-poppins rounded-[20px]  ">

                    <div>
                        <div class="relative shadow-lg overflow-x-auto mt-3">
                            <table class="w-full text-sm  text-gray-500 ">
                                <thead class=" font-jakarta  bg-gray-50  text-primary  ">

                                    {{-- <x-table-head-component :columns="[
                                                        'Purchase (ID)',
                                                        'Total Buying Amount',
                                                        'Discount',
                                                        'Paid Amount',
                                                        'Type',
                                                        'Cash Down',
                                                        'Quantity',
                                                        'Returned Quantity',
                                                        'Purchased At',
                                                        'Action',
                                                    ]" /> --}}
                                    <tr class="text-left border-b">
                                        <th
                                            class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-left">
                                            Purchase (ID)
                                        </th>
                                        <th
                                            class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-right">
                                            Total Buying Amount
                                        </th>
                                        <th
                                            class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-right">
                                            Discount
                                        </th>
                                        <th
                                            class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-right">
                                            Paid Amount
                                        </th>
                                        <th
                                            class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-left">
                                            Type
                                        </th>
                                        <th
                                            class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-right">
                                            Cash Down
                                        </th>
                                        <th
                                            class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-center">
                                            Quantity
                                        </th>
                                        <th
                                            class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-center">
                                            Returned Quantity
                                        </th>
                                        <th
                                            class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-left">
                                            Purchased At
                                        </th>
                                        <th
                                            class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-center">
                                            Action
                                        </th>
                                    </tr>
                                </thead>

                                <tbody id="purchaseTableBody">
                                    @include('purchase-return.search-purchase')
                                </tbody>
                            </table>

                        </div>
                        {{ $purchases->appends(['supplier_id' => $supplier_id])->links('layouts.paginator') }}
                    </div>
                </div>
            </div>

            {{-- table end  --}}
        </div>
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
        $(document).ready(function() {
            var searchRoute = "{{ route('purchase-return-search-purchase') }}";
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
                            $('#purchaseTableBody').html(response.html);
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
