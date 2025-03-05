@extends('layouts.master')
@section('title', 'Role List')
@section('mainTitle', 'Roles List')

@section('css')

@endsection
@section('content')

    <section class="product-model  ">

        {{-- search start --}}
        <x-search-com routeName="role-create" exportName="roles" name="Create A New Role" permissionName="role-create" />
        {{-- search end  --}}

        {{-- table --}}
        <div class="dat-table font-jakarta md:ml-[270px] my-5 mr-[20px] 2xl:ml-[320px] ml-[20px] ">
            <div class="  bg-white px-4 py-3 rounded-[20px]    my-5 ">

                <div class="flex items-center justify-between">
                    <h1 class="text-[#999999] font-poppins text-sm">Search Result : <span class="showTotal text-primary"> 0
                        </span></h1>
                    <h1 class="text-[#999999] font-poppins text-sm">Number of Roles : <span
                            class="text-primary">{{ $roles->count() }} </span></h1>
                </div>

                <div>

                    <div class=" overflow-x-auto mt-3 shadow-lg">
                        <table class="w-full text-sm text-left text-gray-500 ">
                            <thead class="text-sm  text-primary  bg-gray-50 ">

                                {{-- <x-table-head-component :columns="[
                                            'Role Name',
                                            'User',
                                            'Permission Allowed',
                                            'All Permission',
                                            'Created At',
                                            'Created By',
                                            'Action',
                                        ]" /> --}}
                                <tr class="text-left border-b">
                                    <th
                                        class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-left">
                                        Role Name
                                    </th>
                                    <th
                                        class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-center">
                                        User
                                    </th>
                                    <th
                                        class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-center">
                                        Permission Allowed
                                    </th>
                                    <th
                                        class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-center">
                                        All Permission
                                    </th>
                                    <th
                                        class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-left">
                                        Created At
                                    </th>
                                    <th
                                        class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-left">
                                        Created By
                                    </th>
                                    <th
                                        class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-left">
                                        Action
                                    </th>
                                </tr>
                            </thead>
                            <tbody id="searchResults" class="font-poppins text-center text-[13px] ">
                                @include('role.search')
                            </tbody>
                        </table>
                    </div>
                    {{ $roles->links('layouts.paginator') }}
                </div>

                {{-- table end  --}}



    </section>
@endsection
@section('script')
    <script src="{{ asset('js/alertModelCreate.js') }}"></script>

    {{-- search --}}
    <script>
        $(document).ready(function() {
            var searchRoute = "{{ route('role') }}";

            executeSearch(searchRoute)
        });
    </script>
@endsection
