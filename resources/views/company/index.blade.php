@extends('layouts.master')
@section('title', 'Company List')
@section('mainTitle', 'Company Lists')

@section('css')

@endsection


@section('content')

<section class="product-model  ">
    <div class="mr-[20px]">
        {{-- search start --}}
        <x-search-com routeName="company-create" exportListName="companies" name="Create a Company" permissionName="company-create"/>
        {{-- search end  --}}

    </div>

    {{-- table --}}
    <div class="dat-table font-jakarta md:ml-[270px] my-5 mr-[20px] 2xl:ml-[320px] ml-[20px] ">
        <div class="  bg-white px-4 py-3 rounded-[20px] mr-[20px]    my-5 ">

            <div class="flex items-center justify-between">
                {{-- <h1 class="text-[#999999]">{{ $brands->count() }} brands are found</h1> --}}
            </div>

            <div>

                <div class=" overflow-x-auto mt-3 shadow-lg">
                    <table class="w-full text-sm text-left  text-gray-500 ">
                        <thead class="text-sm text-primary bg-gray-50    font-medium font-jakarta ">
                            <x-table-head-component :columns="[
                                    'Company Name',
                                    'Prefix',
                                    'Created By',
                                    'Created Date',
                                    'Action']" />
                        </thead>
                        <tbody id="searchResults" class=" text-sm font-normal text-paraColor font-poppins">
                            @include('company.search')
                        </tbody>
                    </table>
                </div>
                {{ $companies->links('layouts.paginator') }}

            </div>

            {{-- table end  --}}

</section>
@endsection
@section('script')

{{-- search --}}
<script>
    $(document).ready(function() {
        var searchRoute = "{{ route('company') }}";

        executeSearch(searchRoute)
    });
</script>
@endsection
