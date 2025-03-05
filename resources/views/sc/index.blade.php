@extends('layouts.master')
@section('title', 'Sale Staffs List')
@section('mainTitle', 'Sale Staffs List')

@section('css')

@endsection
@section('content')

    <section class="product-model ">

        {{-- search start --}}
        <x-location-create-search-com routeName="sc-create" exportName="locations" name="Create A Sale Staff"
            permissionName="sc-create" />
        {{-- search end  --}}

        {{-- table --}}
        <div class="dat-table font-jakarta md:ml-[270px] my-5 mr-[20px] 2xl:ml-[320px] ml-[20px] ">
            <div class="  bg-white px-4 py-3 rounded-[20px]    my-5 ">

                <div class="flex items-center justify-between">
                    <h1 class="text-[#999999] font-poppins text-sm">Number of Sale Consultants : <span
                            class="text-primary">{{ $sale_consultants->count() }}</span></h1>
                </div>

                <div>

                    <div class=" overflow-x-auto mt-3 shadow-lg">
                        <table class="w-full text-sm text-left text-gray-500 ">
                            <thead class="text-sm  text-primary  bg-gray-50 ">

                                {{-- <x-table-head-component :columns="[
                                            'Name',
                                            'Location',
                                            'Action',
                                        ]" /> --}}
                                <tr class="text-left border-b">
                                    <th
                                        class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-left">
                                        Name
                                    </th>
                                    <th
                                        class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-left">
                                        Location
                                    </th>
                                    <th
                                        class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-left">
                                        Action
                                    </th>
                                </tr>
                            </thead>
                            <tbody id="searchResults" class="font-poppins text-center text-[13px] ">
                                @include('sc.search')
                            </tbody>
                        </table>
                    </div>
                    {{ $sale_consultants->links('layouts.paginator') }}
                </div>

                {{-- table end  --}}



    </section>
@endsection
@section('script')
    <script src="{{ asset('js/alertModelCreate.js') }}"></script>

    {{-- search --}}
    <script>
        $(document).ready(function() {
            var searchRoute = "{{ route('sc-list') }}";

            executeSearch(searchRoute)
        });
    </script>
@endsection
