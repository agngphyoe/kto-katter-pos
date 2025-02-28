<div class=" font-jakarta ">
    <div class="bg-white relative  h-[620px] rounded-[20px] shadow-xl ">
       <div class="">
        <div class="flex items-center justify-center py-10">
            <div>
                <div class="  relative">
                    <img src="{{ asset('users/image/' . $user->image)}}" class="w-24 h-24 rounded-full mb-5 " alt="">
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
                <i class="fa-regular fa-envelope text-noti"></i>
                <h1 class="text-paraColor text-[14px]">{{ $user->email ?? '-' }}</h1>
            </div>

            <div class="flex items-center gap-5">
                <i class="fa-regular fa-address-card text-noti"></i>
                <h1 class="text-paraColor text-[14px]">{{ $user->user_number ?? '-' }}</h1>
            </div>

            <div class="flex items-center gap-5">
                <i class="fa-regular fa-address-card text-noti"></i>
                <h1 class="text-paraColor text-[14px]">{{ $user->nrc ?? '-' }}</h1>
            </div>

            <div class="flex items-center gap-5">
                <i class="fa-solid fa-phone text-noti"></i>
                <h1 class="text-paraColor text-[14px]">{{ $user->phone ?? '-' }}</h1>
            </div>

        </div>
        <div class="absolute bottom-8 left-8">
            <div class="absolute bottom-8 left-8">
            
                <a href="{{ route('user-task', ['user'=>$user->id]) }}">
                <h1 class="text-noti font-semibold text-[14px] mb-2">View Tasks</h1>
                </a>

                @if(!($user->id == Auth::user()->id))
                
                <a href="#" data-route="{{ route('user-delete', $user->id) }}" data-redirect-route="user" class="deleteAction">
                    <h1 class="text-noti font-semibold text-[14px] mb-2">Delete</h1>
                </a>
               
                    @if($user->status)
                    <a href="" class="accountStatus text-xs py-1 text-white rounded-full px-4 bg-[#ff0000] " data-route="{{ route('account-deactivate', $user->id) }}" type='button' >
                        Deactivate
                    </a>
                    @else
                    <a href="" class="accountStatus text-xs py-1 text-white rounded-full px-4 bg-primary" data-route="{{ route('account-activate', $user->id) }}" type='button' >
                        Activate
                    </a>
                    @endif
                @endif
            </div>
        </div>
       </div>
    </div>
</div>