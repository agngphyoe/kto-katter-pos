@extends('layouts.master-without-nav')
@section('title', 'Title')
@section('css')

@endsection
@section('content')
    <section class="user__task">
        {{-- nav start  --}}
        @include('layouts.header-section', [
            'title' => "User's Permission",
            'subTitle' => 'User Profile',
        ])
        {{-- nav end  --}}


        {{-- .................  --}}
        {{-- main start  --}}
        <div class="lg:mx-[30px] mx-[10px] my-[10px] lg:my-[20px]">
            <div class="grid grid-cols-1 lg:grid-cols-4 gap-5">
                <div class="col-span-1 lg:col-span-3">
                    {{-- table start --}}
                    <div class="data-table overflow-x-auto ">
                        <div class="  bg-white px-4  font-poppins rounded-[20px]  ">

                            <div class="">
                                <div class="relative overflow-x-auto ">
                                    <table class="w-full text-sm text-center mt-3 font-poppins text-gray-500 ">
                                        <thead class="text-sm font-jakarta  bg-gray-50 uppercase text-primary  ">
                                            <tr>
                                                <th scope="col"
                                                    class="px-6 py-3 
                                        ">
                                                    Activity
                                                </th>
                                                <th scope="col"
                                                    class="px-6 py-3 
                                        ">
                                                    Task
                                                </th>
                                                <th scope="col"
                                                    class="px-6 py-3 
                                         ">
                                                    Date
                                                </th>



                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($user->activityLogs as $user_activitylog)
                                                <tr class="bg-white border-b  ">
                                                    <td scope="row"
                                                        class="px-6 py-3 font-medium  text-noti whitespace-nowrap ">
                                                        {{ $user_activitylog->title ?? '-' }}
                                                    </td>
                                                    <td class="px-6 py-3  text-noti">
                                                        {{ $user_activitylog->activity ?? '-' }}
                                                    </td>
                                                    <td class="px-6 py-3  ">
                                                        {{ dateFormat($user_activitylog->created_at) ?? '-' }}
                                                    </td>

                                                </tr>
                                            @empty
                                                @include('layouts.not-found', ['colSpan' => 3])
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>

                            </div>


                        </div>
                    </div>
                    {{-- table end  --}}
                </div>
                <div class="col-span-1 mx-48 lg:mx-0 lg:col-span-1">
                    {{-- profile start  --}}
                    <x-user-profile-com :user="$user" />
                    {{-- profile end --}}
                </div>
            </div>

        </div>
        {{-- main end --}}


    </section>
@endsection
@section('script')
{{-- account activate and deactivate --}}
<script>
    $(document).ready(function() {
        $('.accountStatus').on('click', function(e) {
            e.preventDefault();

            var route = $(this).data('route');
            var action = $(this).text().trim();

            Swal.fire({
                title: 'Confirmation',
                text: 'Are you sure you want to ' + action + ' this account?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'OK',
                cancelButtonText: 'Cancel',
                reverseButtons: true

            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: route,
                        type: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            Swal.fire({
                                title: 'Success',
                                text: 'Account ' + action.toLowerCase() + 'd successfully!',
                                icon: 'success',
                                showConfirmButton: false,
                                timer: 1500
                            }).then(() => {
                                // Refresh the page
                                location.reload();
                            });
                        },
                        error: function(xhr, status, error) {
                            Swal.fire({
                                title: 'Error',
                                text: 'An error occurred while ' + action.toLowerCase() + 'ing the account.',
                                icon: 'error'
                            });
                        }
                    });
                }
            });
        });
    });
</script>
@endsection
