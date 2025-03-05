@extends('layouts.master')
@section('title', 'Po Transfer Lists')
@section('mainTitle', 'Po Transfer Lists')

@section('css')

@endsection
@section('content')
    <div class=" ">

        <div class="">
            {{-- search start --}}
            <x-search-com routeName="product-transfer-create" exportName="po_transfers" name="Create Transfer"
                permissionName="po-receive-create" />
            {{-- search end  --}}

        </div>


        {{-- table start --}}
        <div class="data-table">
            <div class=" ml-[20px] bg-white px-4 py-3 rounded-[20px]  md:ml-[270px] my-5 mr-[20px] 2xl:ml-[320px]">
                <div class="flex items-center justify-between">
                    <h1 class="text-[#999999] font-poppins text-sm">Number of Product Request needed to be Transfer : <span
                            class="showTotal text-primary">{{ $poTransfers->count() }}</span></h1>
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
                    'Request Date',
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
                                        Request Date
                                    </th>
                                    <th
                                        class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-center">
                                        Action
                                    </th>
                                </tr>
                            </thead>
                            <tbody id="searchResults"
                                class="font-normal animate__animated animate__slideInUp font-poppins text-[13px] text-paraColor">
                                @include('po-transfer.search')
                            </tbody>
                        </table>
                    </div>
                    {{ $poTransfers->links('layouts.paginator') }}

                </div>
            </div>
        </div>
        {{-- table end  --}}
    </div>

@endsection
@section('script')

    <script>
        $(document).ready(function() {
            var searchRoute = "{{ route('po-transfer') }}";
            executeSearch(searchRoute)
        });

        function changeStatus(id) {
            alert(id)
        }
    </script>


@endsection
