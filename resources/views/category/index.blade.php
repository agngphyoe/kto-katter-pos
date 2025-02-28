@extends('layouts.master')
@section('title', 'Categories List')
@section('mainTitle', 'Categories List')

@section('css')
@endsection
@section('content')

    <section class="product-model">
        <div class=" ">
            <div class="">
                <div>
                    {{-- search start --}}
                    <x-search-com routeName="category-create" exportName="categories" name="Create a Category"
                        permissionName="category-create" />
                    {{-- search end --}}

                    {{-- table --}}
                    <div class="dat-table md:ml-[270px] my-5 mr-[20px] 2xl:ml-[320px] ml-[20px] ">
                        <div class="bg-white px-4 py-3 rounded-[20px] my-5 ">

                            <div class="flex items-center justify-between">
                                <h1 class=" text-[#999999] font-poppins text-sm">Search Result: <span
                                        class="showTotal text-primary">0</span></h1>
                                <h1 class=" text-[#999999] font-poppins text-sm">Number of Categories: <span
                                        class="text-primary">{{ $total_count }}</span></h1>
                            </div>

                            <div>

                                <div class=" overflow-x-auto shadow-xl mt-3">
                                    <table class="w-full text-sm text-center text-gray-500 ">
                                        <thead class="text-sm   font-jakarta text-primary  bg-gray-50 ">
                                            {{-- <x-table-head-component :columns="[
                                    'Name',
                                    'Prefix',
                                    'Created By',
                                    'Created At',
                                    'Action']" /> --}}
                                            <tr class="text-center border-b ">
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
                                            @include('category.search')
                                        </tbody>
                                    </table>
                                </div>
                                {{ $categories->links('layouts.paginator') }}
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

            var searchRoute = "{{ route('category') }}";

            executeSearch(searchRoute)
        });
    </script>

    <script>
        // Disable the button immediately after submitting the form
        document.getElementById('categoryEditForm').addEventListener('submit', function(event) {
            event.preventDefault();

            const submitButton = document.getElementById('submitButton');
            submitButton.disabled = true;
            submitButton.innerHTML = "Processing...";
            submitButton.style.opacity = '0.5';

            this.submit();
        });
    </script>
@endsection
