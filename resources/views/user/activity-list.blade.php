@extends('layouts.master')
@section('title', 'User Activity List')
@section('mainTitle', 'Activity Log Lists')

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
                        <h1 class="text-paraColor font-semibold  font-jakarta">User</h1>
                    </div>
                    <div>
                        <div class="relative overflow-x-auto mt-3 shadow-lg">
                            <table class="w-full text-sm  font-poppins text-gray-500 ">
                                <thead class="text-sm  text-primary font-jakarta  bg-gray-50 ">

                                    {{-- <x-table-head-component :columns="[
                                            'User Name',
                                            'Position',
                                            'Task',
                                            'Activity',
                                            'Date'
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
                                            Task
                                        </th>
                                        <th
                                            class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-left">
                                            Activity
                                        </th>
                                        <th
                                            class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-left">
                                            Date
                                        </th>
                                    </tr>
                                </thead>
                                </thead>
                                <tbody id="searchResults" class="text-[13px]">
                                    @include('user.activity-search')

                                </tbody>
                            </table>
                        </div>
                        {{ $activies->links('layouts.paginator') }}

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
            var searchRoute = "{{ route('user-activity-list') }}";

            executeSearch(searchRoute);
        });
    </script>

@endsection
