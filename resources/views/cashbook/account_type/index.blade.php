@extends('layouts.master')
@section('title', 'Account Types')
@section('mainTitle', 'Account Types')

@section('css')

@endsection
@section('content')

    <section class="account__type">
        <div>
            {{-- search start --}}
            {{-- <x-search-com routeName="account-type-create" name="Create a Account Type" permissionName="account-type-create" />  --}}
            {{-- search end  --}}

        </div>

        {{-- table --}}
        <div class="dat-table font-jakarta md:ml-[270px] my-5 mr-[20px] 2xl:ml-[320px] ml-[20px] ">
            <div class=" bg-white px-4 py-3 rounded-[20px] my-5 ">

                <div class="flex items-center justify-between">
                    <h1 class="text-[#999999] font-poppins text-sm">Number of Account Types : <span
                            class="showTotal">{{ $account_types->count() }}</span></h1>
                </div>

                <div>

                    <div class=" -z-10 overflow-x-auto shadow-xl  mt-3">
                        <table class="w-full  text-sm text-center text-gray-500 ">
                            <thead class="text-sm   text-primary  bg-gray-50 ">
                                {{-- <x-table-head-component :columns="[
                                    'Name',
                                    'Created At',
                                    'Action']" /> --}}
                                <tr class="text-center border-b ">
                                    <th
                                        class="px-20 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-left">
                                        Name
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
                                @include('cashbook.account_type.search')
                            </tbody>
                        </table>
                    </div>
                    {{ $account_types->links('layouts.paginator') }}
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
            var searchRoute = "{{ route('account-type-list') }}";

            executeSearch(searchRoute)
        });
    </script>
@endsection
