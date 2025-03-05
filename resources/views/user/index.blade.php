@extends('layouts.master')
@section('title', 'Users List')
@section('mainTitle', 'Users List')


@section('css')

@endsection
@php
    use App\Models\PermissionUser;
@endphp
@section('content')
    <section class="user">
        {{-- search start
    <x-search-com routeName="role-create" exportListName="roles" name="Create A New Role" />
    search end  --}}
        <div class=" md:ml-[270px] ml-[20px] font-jakarta my-5 mr-[20px] 2xl:ml-[320px]">

            <div class="data-table mt-5">
                <div class="  bg-white px-4 py-2 border-b font-poppins rounded-[20px]  ">
                    <div class="flex items-center justify-between pt-2 px-5">
                        <div class="flex items-center gap-5">

                            <h1 class="text-paraColor font-semibold  font-jakarta">User List</h1>
                            @if (auth()->user()->hasPermissions('user-create'))
                                <a href="{{ route('user-create-first') }}"
                                    class="flex items-center text-white   gap-1 border border-primary bg-primary px-2 py-1  rounded-md">
                                    <i class="fa-solid fa-plus text-xs "></i>
                                    <h1 class="font-medium text-xs  font-jakarta">Add User</h1>
                                </a>
                            @endif
                        </div>
                        {{-- <a href="{{ route('user-list') }}">
                            <h1 class="text-xs py-[2px] bg-noti text-white px-3 rounded-full font-jakarta">See More</h1>
                        </a> --}}
                    </div>
                    <div>
                        <div class="relative overflow-x-auto mt-3 shadow-lg">
                            <table class="w-full text-sm  font-poppins text-gray-500 ">
                                <thead class="text-sm font-jakarta  text-primary  bg-gray-50 ">

                                    {{-- <x-table-head-component :columns="[
                                        'User Name',
                                        'Role',
                                        'Location',
                                        'Permission',
                                        'Created By',
                                        'Created At',
                                        'Action',
                                    ]" /> --}}
                                    <tr class="text-left border-b">
                                        <th
                                            class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-left">
                                            User Name
                                        </th>
                                        <th
                                            class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-left">
                                            Role
                                        </th>
                                        <th
                                            class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-left">
                                            Location
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
                                <tbody class="font-poppins text-[13px]">
                                    @include('user.search')
                                </tbody>
                            </table>
                        </div>
                        {{ $users->links('layouts.paginator') }}
                    </div>


                </div>
            </div>
        </div>

        {{-- <div class=" md:ml-[270px] ml-[20px] font-jakarta my-5 mr-[20px] 2xl:ml-[320px]">
        <div class="data-table mt-5">
            <div class="  bg-white px-4 py-3 border-b font-poppins rounded-[20px]  ">
                <div class="flex items-center justify-between pt-3 px-5">
                    <h1 class="text-paraColor font-semibold  font-jakarta">Activity Log</h1>

                    <a href="{{ route('user-activity-list') }}">
                        <h1 class="text-xs py-[2px] bg-noti text-white px-3 rounded-full font-jakarta">See More</h1>
                    </a>
                </div>
                <div>
                    <div class=" overflow-x-auto mt-3 shadow-lg">
                        <table class="w-full text-sm font-poppins text-gray-500 ">
                            <thead class="text-sm font-jakarta  text-primary  bg-gray-50  ">
                                <x-table-head-component :columns="[
                                            'User Name',
                                            'Position',
                                            'Task',
                                            'Activity',
                                            'Date',
                                        ]" />
                            </thead>
                            <tbody id="searchResults" class="text-[13px]">
                                @include('user.activity-search')

                            </tbody>
                        </table>
                    </div>

                </div>


            </div>
        </div>
    </div> --}}
    </section>
@endsection
@section('script')

@endsection
