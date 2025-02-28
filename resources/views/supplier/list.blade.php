@extends('layouts.master')
@section('title', 'Suppliers List')
@section('mainTitle', 'Suppliers List')

@section('css')

@endsection
@section('content')
    <div class="list">
        {{-- search start --}}

        <x-search-com routeName="supplier-create" exportName="suppliers" name="Create a Supplier"
            permissionName="supplier-create" />

        {{-- search end  --}}

        {{-- table --}}
        <div class="data-table">
            <div class=" ml-[20px] bg-white px-4 py-3 rounded-[20px]  md:ml-[270px] my-5 mr-[20px] 2xl:ml-[320px]">
                <div class="flex items-center justify-between">
                    <h1 class="text-[#999999] font-poppins text-sm">Search Result : <span
                            class="showTotal text-primary">0</span> </h1>
                    <h1 class="text-[#999999] font-poppins text-sm">Number of Suppliers : <span
                            class="text-primary">{{ $suppliers->count() }}</span> </h1>
                </div>
                <div>

                    <div class="relative overflow-x-auto h-[430px]  shadow-lg mt-3">
                        <table class="w-full  text-center text-gray-500" style="padding-top: 24px;">
                            <thead class="text-sm sticky top-0 z-10 text-primary font-jakarta  bg-gray-50">
                                {{-- <x-table-head-component :columns="[
                                            'Supplier Name',
                                            'Supplier ID',
                                            'Phone Number',
                                            'Contact Person',
                                            'Contact Phone',
                                            'Created By',
                                            'Created Date',
                                            'Action',
                                        ]" /> --}}
                                <tr class="text-left border-b">
                                    <th
                                        class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-left">
                                        Supplier Name
                                    </th>
                                    <th
                                        class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-left">
                                        Supplier ID
                                    </th>
                                    <th
                                        class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-left">
                                        Phone Number
                                    </th>
                                    <th
                                        class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-left">
                                        Contact Person
                                    </th>
                                    <th
                                        class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-left">
                                        Contact Phone
                                    </th>
                                    <th
                                        class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-left">
                                        Created By
                                    </th>
                                    <th
                                        class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-left">
                                        Created Date
                                    </th>
                                    <th
                                        class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-center">
                                        Action
                                    </th>
                                </tr>
                            </thead>
                            <tbody id="searchResults"
                                class="font-poppins text-[13px] animate__animated animate__slideInUp text-sm">
                                @include('supplier.search')
                            </tbody>
                        </table>
                    </div>
                    {{ $suppliers->links('layouts.paginator') }}

                </div>
            </div>
            {{-- table end  --}}
        </div>

    @endsection
    @section('script')
        <script>
            $(document).ready(function() {
                var searchRoute = "{{ route('supplier-list') }}";

                executeSearch(searchRoute)
            });
        </script>

    @endsection
