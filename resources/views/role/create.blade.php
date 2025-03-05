@extends('layouts.master-without-nav')
@section('title', 'Create Role')
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
        transition: all 0.2s ease-in-out;
    }

    input:checked + .buttonCheck {
        background-color: #28a745;
    }

    input:checked + .buttonCheck::before {
        transform: translateX(26px);
    }
</style>
@endsection

@section('content')
<section class="user__create">
    @include('layouts.header-section', ['title' => 'Create New Role', 'subTitle' => ''])

    <form id="submitForm" action="{{ route('role-store') }}" method="POST">
        @csrf
        <div class="mx-[30px] my-[10px] lg:my-[20px] xl:mx-[300px]">
            <div class="grid grid-cols-1 gap-5">
                <div class="col-span-1 lg:col-span-1">
                    <div class="rounded-b-[20px] shadow-xl bg-white rounded-[20px]">
                        <div class="py-5">
                            <div class="flex items-center justify-center flex-wrap gap-5">
                                <div class="flex flex-col mb-5">
                                    <x-input-field-component type="text" value="" label="Role Name" name="name" id="roleName" text="Name..." />
                                </div>
                                <button class="bg-noti text-white px-4 py-2 rounded-lg font-jakarta" id="submitButton">Done</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-span-1 lg:col-span-2">
                    <div class="bg-white px-8 py-4 rounded-[20px]">
                        <div class="mb-5">
                            @forelse($permission_groups as $group)
                                @php
                                    $permissions = $group->permissions->toArray();
                                    $half = ceil(count($permissions) / 2);
                                    $leftPermissions = array_slice($permissions, 0, $half);
                                    $rightPermissions = array_slice($permissions, $half);
                                @endphp

                                <h1 class="text-noti font-jakarta text-[18px] text-center font-semibold mb-5">{{ $group->name }}</h1>
                                <div class="select-group">
                                    <input type="checkbox" id="selectGroup{{ $group->id }}" class="select-group-checkbox" data-permission-id="{{ $group->id }}" {{ $group->id == 1 ? 'checked' : '' }}>
                                    <label for="selectGroup{{ $group->id }}" class="select-group-label">Select All</label>
                                </div>
                                
                                <div class="grid grid-cols-1 md:grid-cols-2 md:gap-2 mb-6">
                                    @foreach($leftPermissions as $permission)
                                        <div class="col-span-1 pb-4 mb-6 xl:mb-0">
                                            <div class="flex items-center justify-between pb-4 border border-b border-x-0 border-t-0 border-primary">
                                                <h1 class="font-jakarta text-sm text-paraColor">{{ $permission['name'] }}</h1>
                                                <ul>
                                                    <li class="check-box">
                                                        <input type="checkbox" style="opacity: 0" class="group-check{{ $group->id }}" id="check{{ $permission['id'] }}" name="permissions[]" value="{{ $permission['id'] }}" {{ $permission['name'] == 'dashboard' ? 'checked' : (in_array($permission['id'], old('permissions', [])) ? 'checked' : '') }}>
                                                        <label for="check{{ $permission['id'] }}" class="buttonCheck"></label>
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
                                                        <input type="checkbox" style="opacity: 0" class="group-check{{ $group->id }}" id="check{{ $permission['id'] }}" name="permissions[]" value="{{ $permission['id'] }}" {{ in_array($permission['id'], old('permissions', [])) ? 'checked' : '' }}>
                                                        <label for="check{{ $permission['id'] }}" class="buttonCheck"></label>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @empty
                                <p>No permission groups found.</p>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</section>
@endsection
@section('script')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Select All checkboxes for permission groups
        const selectGroupCheckboxes = document.querySelectorAll('.select-group-checkbox');
        selectGroupCheckboxes.forEach(selectGroupCheckbox => {
            selectGroupCheckbox.addEventListener('change', function() {
                var group_id = $(this).data('permission-id');
                var checkboxes = document.querySelectorAll('.group-check' + group_id);

                checkboxes.forEach(checkbox => {
                    checkbox.checked = this.checked;
                    updateCheckboxStyle(checkbox);
                });
            });
        });

        // Update custom checkbox styles
        function updateCheckboxStyle(checkbox) {
            const buttonCheck = checkbox.nextElementSibling;
            if (checkbox.checked) {
                buttonCheck.classList.add('active');
            } else {
                buttonCheck.classList.remove('active');
            }
        }

        // Initialize styles for pre-checked checkboxes
        document.querySelectorAll('input[type="checkbox"]').forEach(checkbox => {
            updateCheckboxStyle(checkbox);
            checkbox.addEventListener('change', () => updateCheckboxStyle(checkbox));
        });
    });
</script>
@endsection