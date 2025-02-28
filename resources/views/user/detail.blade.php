@extends('layouts.master-without-nav')
@section('title','Title')
@section('css')
    
@endsection
@section('content')
    <section class="user__detail">
        
        @include('layouts.header-section', [
            'title' => "User's Permission",
            'subTitle' => 'User Profile',
        ])
        {{-- nav end  --}}


        {{-- .................  --}}
        {{-- main start  --}}
        <div class="lg:mx-[30px] mx-[10px] my-[10px] lg:my-[20px]">
            <div class="grid grid-cols-1 md:grid-cols-5 lg:grid-cols-4 gap-5">

                {{-- table start  --}}
                <div class="col-span-1 md:col-span-3 lg:col-span-3">
                    <div class="data-table overflow-x-auto ">
                        <div class="  bg-white px-4 py-2 font-poppins rounded-[20px]  ">
                            <div class="flex items-center justify-start gap-10 lg:gap-96 pt-5 px-5">
                                <h1 class="text-paraColor font-semibold  font-jakarta">Permissions</h1>
                            
                            </div>
                            <div>
                                <div class=" h-[450px] overflow-x-auto mt-3">
                                    <table class="w-full  text-sm text-left font-poppins text-gray-500 ">
                                        <thead class="text-sm sticky top-0 right-0   font-jakarta  text-primary uppercase bg-gray-50  ">
                                            <tr>
                                                <th scope="col" class="px-6 py-3 ">
                                                
                                                </th>
                                                <th scope="col" class="px-6 py-3 ">
                                                    List
                                                </th>
                                                <th scope="col" class="px-6 py-3 ">
                                                    Create
                                                </th>
                                                <th scope="col" class="px-6 py-3 ">
                                                    Edit
                                                </th>
                                                <th scope="col" class="px-6 py-3 ">
                                                    Delete
                                                </th>
                                                <th scope="col" class="px-6 py-3 ">
                                                    Detail
                                                </th>
                                                <th scope="col" class="px-6 py-3 ">
                                                    Export
                                                </th>
                                                <th scope="col" class="px-6 py-3 ">
                                                    Print
                                                </th>
                                                
                                            </tr>
                                        </thead>
                                        <tbody class="">
                                            @forelse($groups as $group)
        
                                            <tr class="text-sm text-center  border-b" style="height: 60px;">
                                                <td class="text-noti ">{{ $group->name }}</td>
                                                @forelse($group->permissions as $permission)
                                                <td class=" ">
                                                    @if($user->hasPermissions($permission->name))
                                                    <i class="fa-solid fa-check text-primary text-lg"></i>
                                                    @else
                                                    <i class="fa-solid fa-xmark text-red-500 text-lg"></i>
                                                    @endif
                                                </td>
                                                @empty
            
                                                @endforelse
                                            </tr>
            
                                            @empty
            
                                            @endforelse
                                          
                                        </tbody>
                                    </table>
                                </div>
        
                            </div>
        
                            
                        </div>
                    </div>
                </div>
                {{-- table end --}}
                
                {{-- ..........................  --}}
                {{-- profile start  --}}
                <div class="col-span-1 md:col-span-2 lg:col-span-1">
                    <div class=" font-jakarta ">
                        <div class="bg-white relative  h-[520px] rounded-[20px] shadow-xl ">
                           <div class="">
                            <div class="flex items-center justify-center py-10">
                                <div>
                                    <div class="  relative">
                                        @if ($user->image == null)
                                            <img src="{{ asset('images/add_photo.png') }}" class="w-24 h-24 rounded-full mb-5" alt="">
                                        @else
                                            <img src="{{ asset('users/image/'. $user->image) }}" class="w-24 h-24 rounded-full mb-5 " alt="">
                                        @endif
                                        
                                        <div class="outline absolute bottom-0 right-0 bg-white outline-1 outline-noti rounded-full w-7 h-7 flex items-center justify-center">
                                            <a href="{{ route('user-edit-first', ['user' => $user->id]) }}">
                                                <i class="fa-solid fa-pencil text-xs text-noti"></i>
                                            </a>
                                        </div>
                                    </div>
                                    
                                    <h1 class="font-semibold text-center">{{ $user->name ?? '-' }}</h1>
                                    <h1 class="text-primary text-[14px] font-semibold text-center">{{ $user->role->name ?? '-' }}</h1>
                                </div>
                            </div>
                            <div class="px-5 flex flex-col gap-5">
                    
                                <div class="flex items-center gap-5">
                                    <i class="fa-regular fa-address-card text-noti"></i>
                                    <h1 class="text-paraColor text-[14px]">{{ $user->user_number ?? '-' }}</h1>
                                </div>
                    
                                <div class="flex items-center gap-5">
                                    <i class="fa-solid fa-phone text-noti"></i>
                                    <h1 class="text-paraColor text-[14px]">{{ $user->phone ?? '-' }}</h1>
                                </div>
                    
                            </div>
                            <div class="absolute bottom-8 left-5">
                                @if(!($user->id == Auth::user()->id))
                                
                                    @if($user->status)
                                    <a href="" class="accountStatus text-md py-1 text-white rounded-full bg-[#ff0000]" style="padding-left: 6rem; padding-right: 6rem;" data-route="{{ route('account-deactivate', $user->id) }}" type='button' >
                                        Deactivate
                                    </a>
                                    @else
                                    <a href="" class="accountStatus text-lg py-1 text-white rounded-full bg-primary" style="padding-left: 7rem; padding-right: 7rem;" data-route="{{ route('account-activate', $user->id) }}" type='button' >
                                        Activate
                                    </a>
                                    @endif
                                @endif
                            </div>
                           </div>
                        </div>
                    </div> 
                    {{-- profile start  --}}
                    {{-- <x-user-profile-com :user="$user" /> --}}
                    {{-- profile end --}}
                </div>
                {{-- profile end --}}
                

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