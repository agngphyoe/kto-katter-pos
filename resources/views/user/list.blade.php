@extends('layouts.master')
@section('title', 'User List')
@section('mainTitle', 'User Lists')

@section('css')

@endsection
@section('content')
    <section class="user">
        <x-search-com routeName="user-create-first" exportListName="users" name="Create A New User"
            permissionName="user-create" />
        <div class=" md:ml-[270px] font-jakarta my-5 mr-[20px] 2xl:ml-[320px]">
            {{-- table start --}}
            <div class="data-table mt-5">
                <div class="  bg-white px-4 py-2 font-poppins rounded-[20px]  ">
                    <div class="flex items-center justify-between pt-3 px-5">
                        <h1 class="text-[#999999] font-poppins text-sm">User</h1>
                    </div>
                    <div>
                        <div class=" overflow-x-auto mt-3 shadow-lg">
                            <table class="w-full text-sm font-poppins text-gray-500 ">
                                <thead class="text-sm font-jakarta  text-primary  bg-gray-50 ">
                                    {{-- <x-table-head-component :columns="[
                                            'User Name',
                                            'Position',
                                            'Company',
                                            'Permission',
                                            'Created By',
                                            'Created AT',
                                            'Action',
                                        ]" /> --}}
                                    <tr class="text-left border-b">
                                        <th
                                            class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-left">
                                            User Name
                                        </th>
                                        <th
                                            class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-left">
                                            Position
                                        </th>
                                        <th
                                            class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-left">
                                            Company
                                        </th>
                                        <th
                                            class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-left">
                                            Permission
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
                                <tbody id="searchResults" class="text-[13px]">
                                    @include('user.search')
                                </tbody>
                            </table>
                        </div>
                        {{ $users->links('layouts.paginator') }}
                    </div>


                </div>
            </div>
            {{-- table end --}}
        </div>

    </section>
@endsection
@section('script')
    <script src="{{ asset('js/alertModelCreate.js') }}"></script>

    {{-- search --}}
    <script>
        $(document).ready(function() {
            var searchRoute = "{{ route('user-list') }}";

            executeSearch(searchRoute)
        });
    </script>

@endsection
