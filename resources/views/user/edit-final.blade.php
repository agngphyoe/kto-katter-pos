@extends('layouts.master-without-nav')
@section('title', 'Title')
@section('css')
<style>
    .check-box {
        display: flex;
        align-items: center;
        gap: 10px;
        cursor: pointer;
        padding-right: 20px;
    }

    .check-box .check-item {
        padding: 4px 19px;
        color: #5D5A88;
        border-radius: 20px;
        font-size: 14px;
        border: 1px solid #5D5A88;
    }

    .check-box .check-item.active {
        background-color: #93AAFD;
        border: none;
        color: white;
    }

    .buttonCheck {
        background: #8d8686;
        width: 50px;
        height: 23px;
        border-radius: 200px;
        cursor: pointer;
        position: relative;
        transition: all 0.4s ease-in-out;
    }

    .buttonCheck::before {
        position: absolute;
        content: '';
        background-color: #fff;
        width: 20px;
        height: 19px;
        border-radius: 200px;
        top: 0;
        left: 0;
        margin: 2px;
        transition: all 0.4s ease-in-out;
    }

    input:checked+.buttonCheck {
        background-color: #28a745;
    }

    input:checked+.buttonCheck::before {
        transform: translateX(26px);
    }
</style>
@endsection
@section('content')
<section class="user__create">
    {{-- nav start  --}}
    @include('layouts.header-section', [
    'title' => 'Edit user',
    'subTitle' => '',
    ])
    {{-- nav end  --}}

    {{-- main start  --}}

    <form id="myForm" action="{{ route('user-update', ['user'=>$user->id]) }}" method="POST">
        @csrf
        @method('PUT')
        <div class=" mx-[30px] my-[10px] lg:my-[20px]">

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">
                <div class="col-span-1 lg:col-span-2">
                    <div class="bg-white px-8 py-4 rounded-[20px] ">
                        <div class="mb-5">
                            @forelse($permission_groups as $group)

                            @php
                            $permissions = $group->permissions->toArray();
                            $half = ceil(count($permissions) / 2);
                            $leftPermissions = array_slice($permissions, 0, $half);
                            $rightPermissions = array_slice($permissions, $half);
                            @endphp

                            <h1 class="text-noti font-jakarta text-[18px] text-center font-semibold mb-5">{{ $group->name }}</h1>
                            {{-- view edit start  --}}
                            <div class="grid grid-cols-1 md:grid-cols-2 md:gap-2 mb-6 ">

                                @foreach($leftPermissions as $permission)
                                <div class="col-span-1 pb-4 mb-6 xl:mb-0">
                                    <div class="flex items-center justify-between pb-4 border border-b border-x-0 border-t-0 border-primary">

                                        <h1 class="font-jakarta text-sm text-paraColor">{{ $permission['name'] }}</h1>
                                        <ul class="flex items-center gap-4">
                                            <li class="check-box">
                                                <input type="checkbox" style="opacity: 0" class="" id="check{{$permission['id']}}" name="permissions[]" value="{{ $permission['id'] }}" {{ in_array($permission['id'], old('permissions', [])) ? 'checked' : '' }} @if($role->hasPermissions($permission['name'])) checked disabled @endif @if(in_array($permission['id'], $extra_permissions)) checked @endif>
                                                <label for="check{{ $permission['id'] }}" class="buttonCheck" @if($role->hasPermissions($permission['name'])) style="background-color:#d3d7d3;" @endif></label>
                                            </li>
                                        </ul>

                                    </div>
                                </div>
                                @endforeach

                                @foreach($rightPermissions as $permission)
                                <div class="col-span-1 pb-4">
                                    <div class="flex items-center justify-between pb-4 border border-b border-x-0 border-t-0 border-primary">
                                        <h1 class="font-jakarta text-sm text-paraColor">{{ $permission['name'] }}</h1>
                                        <ul class="flex items-center gap-4">
                                            <li class="check-box">
                                                <input type="checkbox" style="opacity: 0" class="" id="check{{$permission['id']}}" name="permissions[]" value="{{ $permission['id'] }}" {{ in_array($permission['id'], old('permissions', [])) ? 'checked' : '' }} @if($role->hasPermissions($permission['name'])) checked disabled @endif @if(in_array($permission['id'], $extra_permissions)) checked @endif>
                                                <label for="check{{ $permission['id'] }}" class="buttonCheck" @if($role->hasPermissions($permission['name'])) style="background-color:#d3d7d3;" @endif></label>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                            {{-- view edit end --}}
                            @empty
                            <p>No permission groups found.</p>
                            @endforelse

                        </div>
                    </div>
                </div>

                <div class="col-span-1 lg:col-span-1">
                    <div class="  rounded-b-[20px] shadow-xl bg-white rounded-[20px]  ">
                        <div class="py-10 px-5">
                            <div>
                                <input type="text" name="image" value="{{ $image }}" hidden>
                                

                                <div class="flex items-center justify-center flex-wrap gap-5">
                                    <input type="password" name="password" value="{{ $data['password'] }}" hidden>
                                    {{-- <input name="user_number" value="{{ $data['user_number'] }}" hidden> --}}
                                    
                                    {{-- name --}}
                                    <div class="flex flex-col mb-5 ">
                                        <label for="" class="font-jakarta text-[15px] text-paraColor font-semibold mb-2">User Name </label>
                                        <input type="text" name="name" class="outline outline-1 text-sm font-jakarta text-paraColor w-[300px]  text-[13px] outline-primary px-8 py-2 rounded-full" value="{{ $data['name'] }}" readonly>
                                    </div>

                                    {{-- role --}}
                                    <div class="flex flex-col mb-5">
                                        <label for="" class="font-jakarta text-[15px] text-paraColor font-semibold mb-2">Role</label>
                                        <input type="text" class="outline outline-1 text-sm font-jakarta text-paraColor w-[300px]  text-[13px] outline-primary px-8 py-2 rounded-full" value="{{ $role->name }}" readonly>
                                    </div>
                                    <input name="role_id" value="{{ $role->id }}" hidden>

                                    {{-- company --}}
                                    {{-- <div class="flex flex-col mb-5">
                                        <label for="" class="font-jakarta text-[15px] text-paraColor font-semibold mb-2">Company</label>
                                        <input type="text"  class="outline outline-1 text-sm font-jakarta text-paraColor w-[300px]  text-[13px] outline-primary px-8 py-2 rounded-full" value="{{ $company->name }}" readonly
                                    >
                                </div>
                                <input name="company_id" value="{{ $company->id }}" hidden> --}}

                                {{-- phone --}}
                                <div class="flex flex-col mb-5">
                                    <label for="" class="font-jakarta text-[15px] text-paraColor font-semibold mb-2">Phone Number</label>
                                    <input type="text" name="phone" class="outline outline-1 text-sm font-jakarta text-paraColor w-[300px]  text-[13px] outline-primary px-8 py-2 rounded-full" value="{{ $data['phone'] ?? null }}">
                                </div>

                                {{-- Locations --}}
                                <div class="flex flex-col mb-5 hidden">
                                    <label for="" class="block mb-2 text-paraColor font-medium text-sm ">Locations</label>
                                    <select name="location_id[]" id="product_model_select" class="select2 w-full" required multiple>
                                        @forelse($locations as $location)
                                            <option value="{{ $location->id }}" class="outline-none font-Pop" selected>{{ $location->location_name }}</option>
                                        @empty
                                            <option value="" class="outline-none font-Pop" disabled selected>No Data</option>
                                        @endforelse
                                    </select>
                                </div>

                                <div class="flex items-center justify-center mt-5">
                                    <x-button-component class="bg-noti text-white" type="submit" id="done">
                                        Next
                                    </x-button-component>
                                </div>
                            </div>


                        </div>
                    </div>
                </div>
            </div>
        </div>

        </div>
        {{-- main end --}}

    </form>


</section>
@endsection
@section('script')
<script>
    const addPhotoImg = document.getElementById('addPhoto');
    const photoInput = document.getElementById('photoInput');

    addPhotoImg.addEventListener('click', function() {
        photoInput.click();
    });
</script>
@endsection