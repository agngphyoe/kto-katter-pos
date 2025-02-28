@extends('layouts.master')
@section('title', 'Staff')
@section('mainTitle', 'Staff Lists')

@section('css')
<style>
    .icon-container {
        position: relative;
        /* display: inline-block; */
    }

    .hover-icons {
        position: absolute;
        top: 50%;
        left: 20px;
        transform: translateY(-50%);

        opacity: 0;
        transition: opacity 0.3s, left 0.3s;
    }

    .icon-container:hover .hover-icons {
        opacity: 1;
        left: 30px;
    }
</style>
@endsection
@section('content')



<section class="staff">
    {{-- search start --}}
    <x-search-com routeName="staff-create" exportListName="products" name="Create a Staff" permissionName="sale-return-create" />
    {{-- search end  --}}

    {{-- .............. --}}
    <div class="md:ml-[270px] my-5 mr-[20px] 2xl:ml-[320px] ml-[20px]">


        {{-- table start --}}
        <div class="data-table ">
            <div class="  bg-white px-4 py-2 rounded-[20px]">
                <div>
                    <div class="relative overflow-x-auto shadow-lg mt-3">
                        <table class="w-full text-sm text-left text-gray-500 ">
                            <thead class="text-sm text-primary bg-gray-50    font-medium font-jakarta  ">
                                <x-table-head-component :columns="[
                                            'Staff Name',
                                            'Staff ID',
                                            'Position',
                                            'Phone Number',
                                            'Created By',
                                            'Created At',
                                            'Action',
                                        ]" />
                            </thead>
                            <tbody class="text-sm font-normal text-paraColor font-poppins" id="searchResults">
                                @include('staff.search')
                            </tbody>
                        </table>
                    </div>

                </div>


            </div>
        </div>
        {{-- table end  --}}

    </div>


</section>








@endsection
@section('script')

{{-- <script src="{{ asset('js/mySelect.js') }}"></script> --}}
<script src="{{ asset('js/dateRangePicker.js') }}"></script>

{{-- search --}}
<script>
    $(document).ready(function() {
        var searchRoute = "{{ route('staff') }}";

        executeSearch(searchRoute)
    });
</script>
@endsection