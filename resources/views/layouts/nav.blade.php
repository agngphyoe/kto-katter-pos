<nav class="sticky animate__animated animate__fadeInDown  top-0 z-40">
    <div class="nav  shadow-xl  font-jakarta md:ml-[270px] overflow-hidden   bg-white  md:rounded-bl-[20px] 2xl:ml-[320px]">
        <div class="flex items-center justify-between py-[12px] xxl:py-[22px] px-6 ">
            <div class="flex items-center gap-3">
                <div>
                    {{-- menu btn  --}}
                    <svg xmlns="http://www.w3.org/2000/svg" height="1.2em" viewBox="0 0 448 512">
                        <path d="M0 96C0 78.3 14.3 64 32 64H416c17.7 0 32 14.3 32 32s-14.3 32-32 32H32C14.3 128 0 113.7 0 96zM0 256c0-17.7 14.3-32 32-32H416c17.7 0 32 14.3 32 32s-14.3 32-32 32H32c-17.7 0-32-14.3-32-32zM448 416c0 17.7-14.3 32-32 32H32c-17.7 0-32-14.3-32-32s14.3-32 32-32H416c17.7 0 32 14.3 32 32z" fill="#00812C" class="md:hidden pt-10 cursor-pointer " id="menu-btn" />
                    </svg>
                    {{-- menu btn end  --}}
                </div>
                <div>
                    <h1 class="text-primary text-[14px] md:text-[16px] uppercase font-semibold font-jakarta">@yield('mainTitle')</h1>
                    @if(!in_array(\Route::currentRouteName(), ['dashboard','report','coa-list'] ))
                    {{-- <h1 class="text-black opacity-50 text-[13px]">Total <span>{{$total_count ?? 0}}</span> records</h1> --}}
                    @endif
                </div>


            </div>
            <div class="flex items-center gap-2">

                <button class=" relative px-4 py-3 rounded-md" id="noti-btn">
                    {{-- <i class="fa-solid fa-bell  text-primary text-xl"></i> --}}
                    {{-- <div class=" absolute -top-2 -right-2 bg-red-600 text-white px-1  flex items-center justify-center rounded-full text-[10px] font-extrabold" id="notiCount">{{ auth()->user()->noti_unread_count ?? 0}}</div> --}}
                </button>

                <div class="relative profile">
                    <button class="p-3 bg-bgMain rounded-full cursor-pointer" id="dropdown-btn">
                        <svg xmlns="http://www.w3.org/2000/svg" height="1.5em" viewBox="0 0 448 512">
                            <path d="M304 128a80 80 0 1 0 -160 0 80 80 0 1 0 160 0zM96 128a128 128 0 1 1 256 0A128 128 0 1 1 96 128zM49.3 464H398.7c-8.9-63.3-63.3-112-129-112H178.3c-65.7 0-120.1 48.7-129 112zM0 482.3C0 383.8 79.8 304 178.3 304h91.4C368.2 304 448 383.8 448 482.3c0 16.4-13.3 29.7-29.7 29.7H29.7C13.3 512 0 498.7 0 482.3z" fill="#00812C" />
                        </svg>
                    </button>
                </div>


            </div>
        </div>

        @include('layouts.logout-section')
        @include('layouts.noti')
    </div>

</nav>
<script src="https://js.pusher.com/7.2/pusher.min.js"></script>
<script src="{{ asset('js/Notification.js') }}"></script>

<script>
    var PUSHER_APP_KEY = @json(config('broadcasting.connections.pusher.key'));

    var pusher = new Pusher(PUSHER_APP_KEY, {
        cluster: 'ap1',
        encrypted: true
    });

    var channelName = @json(config('app.env')) === 'production' ? 'activity-log' : 'activity-log-dev';

    var channel = pusher.subscribe(channelName); //subscribe to channels

    channel.bind('create', function(data) { // bind with event

        updateNotiCount(data.log, data.user_id, data.user_name)
    });
</script>