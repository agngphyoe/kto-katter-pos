@extends('layouts.master')
@section('title', 'Product Restores List')
@section('mainTitle', 'Product Restores List')

@section('css')

@endsection
@section('content')
    <div class=" ">

        <div class="">
            {{-- search start --}}
            <x-search-com permissionName="" exportName="product_restores" />
            {{-- search end  --}}

        </div>


        {{-- table start --}}
        <div class="data-table">
            <div class=" ml-[20px] bg-white px-4 py-3 rounded-[20px]  md:ml-[270px] my-5 mr-[20px] 2xl:ml-[320px]">
                <div class="flex items-center justify-between">
                    <h1 class="text-[#999999] font-poppins text-sm">Number of Product Restores : <span
                            class="showTotal text-primary">{{ $product_restores->count() }}</span></h1>
                </div>
                <div>

                    <div class="relative overflow-x-auto h-[400px] shadow-lg  mt-3">
                        <table class="w-full    ">
                            <thead class="text-sm sticky top-0 z-10 font-jakarta  text-primary  bg-gray-50 ">
                                {{-- <x-table-head-component :columns="[
                    'Code',
                    'Remark',
                    'From Location',
                    'To Location',
                    'Created By',
                    'Status',
                    'Return Date',
                    'Action',
                ]" /> --}}
                                <tr class="text-left border-b">
                                    <th
                                        class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-left">
                                        Code
                                    </th>
                                    <th
                                        class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-left">
                                        Remark
                                    </th>
                                    <th
                                        class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-left">
                                        From Location
                                    </th>
                                    <th
                                        class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-left">
                                        To Location
                                    </th>
                                    <th
                                        class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-left">
                                        Created By
                                    </th>
                                    <th
                                        class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-left">
                                        Status
                                    </th>
                                    <th
                                        class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-left">
                                        Return Date
                                    </th>
                                    <th
                                        class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-center">
                                        Action
                                    </th>
                                </tr>
                            </thead>
                            <tbody id="searchResults"
                                class="font-normal animate__animated animate__slideInUp font-poppins text-[13px] text-paraColor">
                                @include('product-restore.search')
                            </tbody>
                        </table>
                    </div>
                    {{ $product_restores->links('layouts.paginator') }}

                </div>
            </div>
        </div>
        {{-- table end  --}}
    </div>

@endsection
@section('script')

    <script>
        $(document).ready(function() {
            var searchRoute = "{{ route('product-restore') }}";
            executeSearch(searchRoute)
        });

        function changeStatus(id) {
            alert(id)
        }
    </script>


@endsection
