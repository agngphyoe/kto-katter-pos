@extends('layouts.master')
@section('title', 'Cashbacks List')
@section('mainTitle', 'Cashbacks List')

@section('css')

@endsection
@section('content')
    <div class=" ">

        <div class="">
            {{-- search start --}}
            <x-search-com routeName="product-transfer-create" name="Create Transfer"
                permissionName="product-transfer-create" />
            {{-- search end  --}}

        </div>


        {{-- table start --}}
        <div class="data-table">
            <div class=" ml-[20px] bg-white px-4 py-3 rounded-[20px]  md:ml-[270px] my-5 mr-[20px] 2xl:ml-[320px]">
                
                <div class="flex items-center justify-between">
                    <h1 class="font-poppins text-paraColor font-semibold">Total Remaining Cashback Amount: <span
                        class="text-primary">{{ number_format($total_remaining_cashback) }}</span></h1>
                    <h1 class="text-[#999999] font-poppins text-sm">Search Result : <span
                            class="showTotal text-primary">0</span></h1>
                </div>
                <div>

                    <div class="relative overflow-x-auto h-[400px] shadow-lg  mt-3">
                        <table class="w-full    ">
                            <thead class="text-sm sticky top-0 z-10 font-jakarta  text-primary  bg-gray-50 ">
                                <tr class="text-left border-b">
                                    <th
                                        class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-left">
                                        Supplier
                                    </th>
                                    <th
                                        class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-right">
                                        Total Cashback Amount
                                    </th>
                                    <th
                                        class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-left">
                                        Status
                                    </th>
                                    
                                    <th
                                        class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-center">
                                        Action
                                    </th>
                                </tr>
                            </thead>
                            <tbody id="searchResults"
                                class="font-normal animate__animated animate__slideInUp font-poppins text-[13px] text-paraColor">
                                @include('pos-cashback.search')
                            </tbody>
                        </table>
                    </div>
                    {{-- {{ $product_transfers->links('layouts.paginator') }} --}}

                </div>
            </div>
        </div>
        {{-- table end  --}}
    </div>

@endsection
@section('script')
    {{-- <script>
        $(document).ready(function() {
            var searchRoute = "{{ route('product-transfer') }}";
            executeSearch(searchRoute)
        });

        function changeStatus(id) {
            alert(id)
        }
    </script> --}}


@endsection
