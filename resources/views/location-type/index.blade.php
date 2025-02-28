@extends('layouts.master')
@section('title','Location Type List')
@section('mainTitle', 'Location Type Lists')

@section('css')

@endsection
@section('content')

<section class="product-model  ">

    {{-- search start --}}
    <x-search-com routeName="location-type-create" exportListName="location_types" name="Create A New Location Type" permissionName="location-type-create"/>
    {{-- search end  --}}

    {{-- table --}}
    <div class="dat-table font-jakarta md:ml-[270px] my-5 mr-[20px] 2xl:ml-[320px] ml-[20px] ">
        <div class="  bg-white px-4 py-3 rounded-[20px]    my-5 ">

            <div class="flex items-center justify-between">
                <h1 class="text-[#999999] font-poppins text-sm">{{ $locationTypes->count() }} locations are found</h1>
            </div>

            <div>

                <div class=" overflow-x-auto mt-3 shadow-lg">
                    <table class="w-full text-sm text-left text-gray-500 ">
                        <thead class="text-sm  text-primary  bg-gray-50 ">

                            <x-table-head-component :columns="[
                                            'Location Type Name',
                                            'Number Of Stores',
                                            'Created By',
                                            'Created Date',
                                            'Action',
                                        ]" />
                        </thead>
                        <tbody id="searchResults" class="font-poppins text-center text-[13px] ">
                            @include('location-type.search')
                        </tbody>
                    </table>
                </div>
                {{ $locationTypes->links('layouts.paginator') }}
            </div>

            {{-- table end  --}}



</section>
@endsection
@section('script')
<script src="{{ asset('js/alertModelCreate.js') }}"></script>

{{-- search --}}
<script>
    $(document).ready(function() {
        var searchRoute = "{{ route('location-type') }}";
        
        executeSearch(searchRoute)
    });
</script>
@endsection
