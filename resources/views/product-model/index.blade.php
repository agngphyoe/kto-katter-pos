@extends('layouts.master')
@section('title', 'Product Model List')
@section('mainTitle', 'Product Model Lists')

@section('css')

@endsection
@section('content')

    <section class="product-model  ">
        <div class=" ">
            <div class="">
                <div>
                    {{-- search --}}
                    <x-search-com routeName="product-model-create" exportName="product-models" name="Create a Model"
                        permissionName="model-create" />
                    {{-- search end  --}}

                    {{-- table --}}
                    <div class="dat-table font-jakarta md:ml-[270px] my-5 mr-[20px] 2xl:ml-[320px] ml-[20px] ">
                        <div class="  bg-white px-4 py-3 rounded-[20px]     my-5 ">

                            <div class="flex items-center justify-between">
                                <h1 class=" text-[#999999] font-poppins text-sm">Search Result: <span
                                        class="showTotal text-primary">0</span></h1>
                                <h1 class="text-[#999999] font-poppins text-sm">Number of Product Models : <span
                                        class="text-primary">{{ $product_models->count() }}</span></h1>
                            </div>

                            <div>

                                <div class=" overflow-x-auto shadow-xl  mt-3">
                                    <table class="w-full text-sm  text-gray-500 ">
                                        <thead class="text-sm   text-primary  bg-gray-50  ">

                                            {{-- <x-table-head-component :columns="[
                                                'Name',
                                                'Brand',
                                                'Categories',
                                                'Created By',
                                                'Created At',
                                                'Action',
                                            ]" /> --}}
                                            <tr class="text-center border-b">
                                                <th
                                                    class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-left">
                                                    Name
                                                </th>
                                                <th
                                                    class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-left">
                                                    Brand
                                                </th>
                                                <th
                                                    class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-left">
                                                    Categories
                                                </th>
                                                <th
                                                    class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-left">
                                                    Created By
                                                </th>
                                                <th
                                                    class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-left">
                                                    Created At
                                                </th>
                                                <th
                                                    class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-left">
                                                    Action
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody id="searchResults"
                                            class="text-sm animate__animated animate__slideInUp font-normal text-paraColor font-poppins">
                                            @include('product-model.search')
                                        </tbody>
                                    </table>
                                </div>
                                {{ $product_models->links('layouts.paginator') }}
                            </div>

                            {{-- table end  --}}
                        </div>
                    </div>

                </div>


    </section>
@endsection
@section('script')

    <script>
        $(document).ready(function() {
            var searchRoute = "{{ route('product-model') }}";

            executeSearch(searchRoute)
        });
    </script>

@endsection
