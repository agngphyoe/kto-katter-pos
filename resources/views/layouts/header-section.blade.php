<nav class="sticky animate__animated animate__fadeInDown top-0 z-50 ">
    <div class="nav   font-jakarta shadow-xl  overflow-hidden   bg-white  ">
        <div class="flex items-center justify-between py-[12px] xxl:py-[22px] px-3 md:px-12 ">
            <div class="flex items-center gap-5">

                <button onclick="window.history.back();" class="outline shrink-0 outline-1 outline-noti text-noti w-9 h-9 rounded-full" id="back_btn">
                    <i class="fa-solid fa-arrow-left text-lg"></i>
                </button>
                
                <div>
                    <h1 class="text-primary text-[16px]  md:text-[20px] font-semibold font-jakarta">{{ $title }}</h1>
                    <h1 class="text-black opacity-50 text-[12px]">{{ $subTitle }}</h1>
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
    </div>

    @include('layouts.logout-section')
    @include('layouts.noti')

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
