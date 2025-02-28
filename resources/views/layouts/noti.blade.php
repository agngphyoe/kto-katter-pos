{{-- <div id="noti-menu" class="bg-white h-auto  font-poppins  w-[300px]  shadow-2xl  z-20 hidden absolute top-18 rounded-lg right-10 ">

    <div class="px-4 py-2 bg-primary text-[15px] font-medium text-white rounded-t-lg">
        <h1>

            Notifications
        </h1>
    </div>
    <div class=" text-[13px] px-5 pt-2 pb-0 font-medium flex flex-col activity-log-container">
        @forelse(App\Models\ActivityLog::latest()->take(4)->get() as $log)
        <a href="{{ route('user') }}" onclick="handleActivityLogClick(event)">
            <div class="pb-3">
                <div class="flex  gap-2">
                    <i class="fa-solid mt-1 fa-circle-exclamation text-noti text-[15px] "></i>
                    <div class="border-b pb-2">
                        <h1 class="mb-1 font-semibold">{{ $log->title }} </h1>
                        <h1 class="text-paraColor">{{ $log->createable?->name }} {{ $log->activity }} at {{ dateFormat($log->created_at) }}</h1>
                    </div>
                </div>

            </div>
        </a>
        @empty

        @endforelse

    </div>

    <div class="flex item-center justify-center pb-3 pt-0">
        <a href="{{ route('user') }}" class="text-center hover:underline underline-offset-2 text-sm">Load More >>></a>

    </div>

</div> --}}

<script>
    function handleActivityLogClick(event) {
        event.preventDefault();
        
        $.ajax({
            url: "{{ route('reset.noti-count') }}",
            type: 'POST',
            dataType: 'json',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {

                window.location.href = '/user';

                document.getElementById('notiCount').textContent = 0;
            },
            error: function(xhr, status, error) {
                console.log(error);
            }
        });
    }
</script>