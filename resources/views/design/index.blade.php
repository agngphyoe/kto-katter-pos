@extends('layouts.master')
@section('title', 'Designs List')
@section('mainTitle', 'Designs List')

@section('css')

@endsection
@section('content')

    <section class="product-model ">
        <div class=" ">
            <div class="">
                <div>
                    {{-- search --}}
                    <x-search-com routeName="design-create" exportName="designs" name="Create a Design"
                        permissionName="design-create" />
                    {{-- search end  --}}

                    {{-- table --}}
                    <div class="dat-table md:ml-[270px] my-5  2xl:ml-[320px] ml-[20px] ">
                        <div class="  bg-white px-4 py-3 rounded-[20px] mr-[20px]    my-5 ">

                            <div class="flex items-center justify-between">
                                <h1 class=" text-[#999999] font-poppins text-sm">Search Result: <span
                                        class="showTotal text-primary">0</span></h1>
                                <h1 class="text-[#999999] font-poppins text-sm">Number of Designs: <span
                                        class="text-primary">{{ $designs->count() }}</span></h1>
                            </div>

                            <div>

                                <div class=" overflow-x-auto shadow-xl  mt-3">
                                    <table class="w-full text-sm text-center text-gray-500 ">
                                        <thead class=" text-sm  font-jakarta text-primary  bg-gray-50 ">

                                            {{-- <x-table-head-component :columns="['Name', 'Created By', 'Created At', 'Action']" /> --}}
                                            <tr class="text-left border-b">
                                                <th
                                                    class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3">
                                                    Name
                                                </th>
                                                <th
                                                    class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3">
                                                    Created By
                                                </th>
                                                <th
                                                    class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3">
                                                    Created At
                                                </th>
                                                <th
                                                    class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-left">
                                                    Action
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody id="searchResults"
                                            class="text-sm font-normal animate__animated animate__slideInUp text-paraColor font-poppins">
                                            @include('design.search')
                                        </tbody>
                                    </table>
                                </div>
                                {{ $designs->links('layouts.paginator') }}
                            </div>

                            {{-- table end  --}}
                        </div>
                    </div>

                </div>


    </section>
@endsection
@section('script')

    <script src="{{ asset('js/alertModelCreate.js') }}"></script>

    <script>
        $(document).ready(function() {
            var searchRoute = "{{ route('design') }}";

            executeSearch(searchRoute)
        });
    </script>

@endsection
