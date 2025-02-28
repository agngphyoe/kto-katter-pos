
@extends('layouts.master')
@section('title', 'Position List')
@section('mainTitle', 'Position Lists')

@section('css')

@endsection
@section('content')

<section class="product-model  ">
    <div>
        {{-- search start --}}
        <x-search-com routeName="position-create" exportListName="positions" name="Create a Position" permissionName="brand-create" />
        {{-- search end  --}}

    </div>

    {{-- table --}}
    <div class="dat-table font-jakarta md:ml-[270px] my-5 mr-[20px] 2xl:ml-[320px] ml-[20px] ">
        <div class="  bg-white px-4 py-3 rounded-[20px]     my-5 ">

            <div class="flex items-center justify-between">
                <h1 class="text-[#999999] text-xs"><span class="showTotal">{{ $positions->count() }}</span> positions are found</h1>
            </div>

            <div>

                <div class=" -z-10 overflow-x-auto  mt-3 shadow-lg">
                    <table class="w-full text-sm text-left text-gray-500 ">
                        <thead class="text-sm   text-primary  bg-gray-50 ">
                            <tr>
                                <th scope="col" class="px-6 animate__animated animate__fadeInTopLeft  py-3">
                                    Name
                                </th>
                                <th scope="col" class="px-6 animate__animated animate__fadeInTopLeft  py-3">
                                    Created By
                                </th>
                                <th scope="col" class="px-6 animate__animated animate__fadeInTopLeft  py-3">
                                Created At
                                </th>
                                <th scope="col" class="px-6 animate__animated animate__fadeInTopLeft  py-3">
                                Action
                                </th>
                        </tr>
                        </thead>
                        <tbody id="searchResults" class="text-center">
                            @include('position.search')
                        </tbody>
                    </table>
                </div>
                {{ $positions->links('layouts.paginator') }}
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
        var searchRoute = "{{ route('position') }}";

        executeSearch(searchRoute)
    });
</script>
@endsection