@extends('layouts.master')
@section('title', 'Locations List')
@section('mainTitle', 'Locations List')

@section('css')

@endsection
@section('content')

    <section class="product-model ">

        {{-- search start --}}
        <x-location-create-search-com routeName="location-create" exportListName="locations" name="Create A New Location"
            permissionName="location-create" />
        {{-- search end  --}}

        {{-- table --}}
        <div class="dat-table font-jakarta md:ml-[270px] my-5 mr-[20px] 2xl:ml-[320px] ml-[20px] ">
            <div class="  bg-white px-4 py-3 rounded-[20px]    my-5 ">

                <div class="flex items-center justify-between">
                    <h1 class="text-[#999999] font-poppins text-sm">Search Result : <span
                            class="showTotal text-primary">0</span></h1>
                    <h1 class="text-[#999999] font-poppins text-sm">Number of Locations : <span
                            class="text-primary">{{ $locations->count() }}</span></h1>
                </div>

                <div>

                    <div class=" overflow-x-auto mt-3 shadow-lg">
                        <table class="w-full text-sm text-left text-gray-500 ">
                            <thead class="text-sm  text-primary  bg-gray-50 ">

                                {{-- <x-table-head-component :columns="[
                                            'Name',
                                            'Type',
                                            'Address',
                                            'Created by',
                                            'Action',
                                        ]" /> --}}
                                <tr class="text-left border-b">
                                    <th
                                        class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-left">
                                        Name
                                    </th>
                                    <th
                                        class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-left">
                                        Type
                                    </th>
                                    <th
                                        class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-left">
                                        Address
                                    </th>
                                    <th
                                        class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-left">
                                        Created by
                                    </th>
                                    <th
                                        class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-left">
                                        Action
                                    </th>
                                </tr>
                            </thead>
                            <tbody id="searchResults" class="font-poppins text-center text-[13px] ">
                                @include('location.search')
                            </tbody>
                        </table>
                    </div>
                    {{ $locations->links('layouts.paginator') }}
                </div>

                {{-- table end  --}}



    </section>
@endsection
@section('script')
    <script src="{{ asset('js/alertModelCreate.js') }}"></script>

    {{-- search --}}
    <script>
        $(document).ready(function() {
            var searchRoute = "{{ route('location') }}";

            executeSearch(searchRoute)
        });
    </script>
@endsection
