@extends('layouts.master')
@section('title', 'Banks List')
@section('mainTitle', 'Banks List')

@section('css')

@endsection
@section('content')

    <section class="Bank">

        {{-- search start --}}
        <x-search-com routeName="bank-create" name="Create Bank" permissionName="bank-create" />
        {{-- search end  --}}


        {{-- table --}}
        <div class="dat-table font-jakarta md:ml-[270px] my-5 mr-[20px] 2xl:ml-[320px] ml-[20px] ">
            <div class=" bg-white px-4 py-3 rounded-[20px] my-5 ">
                <div>

                    <div class=" -z-10 overflow-x-auto shadow-xl  mt-3">
                        <table class="w-full  text-sm text-center text-gray-500 ">
                            <thead class="text-sm   text-primary  bg-gray-50 ">
                                {{-- <x-table-head-component :columns="[
                                        'Name',
                                        'Account Name',
                                        'Account Number',
                                        'Created By',
                                        'Created At',
                                        'Action']" /> --}}
                                <tr class="text-center border-b ">
                                    <th
                                        class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-left">
                                        Bank Name
                                    </th>
                                    <th
                                        class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-left">
                                        Account Name
                                    </th>
                                    <th
                                        class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-left">
                                        Account Number
                                    </th>
                                    <th
                                        class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-left">
                                        Create By
                                    </th>
                                    <th
                                        class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-left">
                                        Create At
                                    </th>
                                    <th class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3">
                                        Action
                                    </th>
                                </tr>
                            </thead>
                            <tbody id="searchResults"
                                class="text-sm animate__animated animate__slideInUp font-normal text-paraColor font-poppins">
                                @include('cashbook.bank.search')
                            </tbody>
                        </table>
                    </div>
                    {{ $banks->links('layouts.paginator') }}
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
            var searchRoute = "{{ route('bank') }}";

            executeSearch(searchRoute)
        });
    </script>
@endsection
