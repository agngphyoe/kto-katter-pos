@extends('layouts.master')
@section('title', 'Brands List')
@section('mainTitle', 'brands list')
@section('css')

@endsection
@section('content')

    <section class="product-model  ">
        <div>
            {{-- search start --}}
            <x-search-com routeName="brand-create" exportName="brands" name="Create a Brand" permissionName="brand-create" />
            {{-- search end  --}}

        </div>

        {{-- table --}}
        <div class="dat-table font-jakarta md:ml-[270px] my-5 mr-[20px] 2xl:ml-[320px] ml-[20px] ">
            <div class="  bg-white px-4 py-3 rounded-[20px]     my-5 ">

                <div class="flex items-center justify-between">
                    <h1 class=" text-[#999999] font-poppins text-sm">Search Result: <span
                            class="showTotal text-primary">0</span></h1>
                    <h1 class="text-[#999999] font-poppins text-sm">Number of Brands : <span
                            class="text-primary">{{ $brands->count() }}</span></h1>
                </div>

                <div>

                    <div class=" -z-10 overflow-x-auto shadow-xl  mt-3">
                        <table class="w-full  text-sm text-center text-gray-500 ">
                            <thead class="text-sm   text-primary  bg-gray-50 ">
                                {{-- <x-table-head-component :columns="['Name', 'Prefix', 'Category Name', 'Created By', 'Created At', 'Action']" /> --}}
                                <tr class="text-center border-b">
                                    <th
                                        class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-left">
                                        Name
                                    </th>
                                    <th
                                        class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-left">
                                        Prefix
                                    </th>
                                    <th
                                        class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-left">
                                        Category Name
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
                                @include('brand.search')
                            </tbody>
                        </table>
                    </div>
                    {{ $brands->links('layouts.paginator') }}
                </div>

            </div>
        </div>

        {{-- table end  --}}



    </section>
@endsection
@section('script')
    <script src="{{ asset('js/alertModelCreate.js') }}"></script>

    {{-- search --}}
    <script>
        $(document).ready(function() {
            var searchRoute = "{{ route('brand') }}";

            executeSearch(searchRoute)
        });
    </script>

    {{-- <script>
    $('#export_btn').on('click', function(){
        $('#my_form').submit();
    })
</script> --}}
@endsection
