 {{-- search start --}}
 <div class="data-serch font-poppins text-[15px]">
    <div class=" ml-[20px] bg-white flex items-center justify-start xl:justify-between flex-wrap gap-4 px-4 py-4 rounded-[20px]  md:ml-[270px] my-5 mr-[20px] 2xl:ml-[320px]">

        <div class="flex items-center gap-4 animate__animated animate__zoomIn">

            <div class="flex items-center w-full outline outline-1 outline-primary rounded-full px-4 py-[7px]">
                <input type="search" class="outline-none outline-transparent" placeholder="Search..." id="searchInput" value="{{ request()->get('search') }}">

                <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 512 512">

                    <path d="M416 208c0 45.9-14.9 88.3-40 122.7L502.6 457.4c12.5 12.5 12.5 32.8 0 45.3s-32.8 12.5-45.3 0L330.7 376c-34.4 25.2-76.8 40-122.7 40C93.1 416 0 322.9 0 208S93.1 0 208 0S416 93.1 416 208zM208 352a144 144 0 1 0 0-288 144 144 0 1 0 0 288z" fill="#00812C" />
                </svg>
            </div>
        </div>

        <div class="flex items-center gap-4 animate__animated animate__zoomIn">

            <div class="flex items-center outline outline-1 outline-primary rounded-full px-4 py-2">
                <input type="text" name="daterange" class="outline-none w-[220px]" id="date_range_input" value="{{ request()->get('start_date') ? request()->get('start_date') . ' - ' . request()->get('end_date') : '' }}">
                <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 448 512">
                    <path d="M128 0c17.7 0 32 14.3 32 32V64H288V32c0-17.7 14.3-32 32-32s32 14.3 32 32V64h48c26.5 0 48 21.5 48 48v48H0V112C0 85.5 21.5 64 48 64H96V32c0-17.7 14.3-32 32-32zM0 192H448V464c0 26.5-21.5 48-48 48H48c-26.5 0-48-21.5-48-48V192zm64 80v32c0 8.8 7.2 16 16 16h32c8.8 0 16-7.2 16-16V272c0-8.8-7.2-16-16-16H80c-8.8 0-16 7.2-16 16zm128 0v32c0 8.8 7.2 16 16 16h32c8.8 0 16-7.2 16-16V272c0-8.8-7.2-16-16-16H208c-8.8 0-16 7.2-16 16zm144-16c-8.8 0-16 7.2-16 16v32c0 8.8 7.2 16 16 16h32c8.8 0 16-7.2 16-16V272c0-8.8-7.2-16-16-16H336zM64 400v32c0 8.8 7.2 16 16 16h32c8.8 0 16-7.2 16-16V400c0-8.8-7.2-16-16-16H80c-8.8 0-16 7.2-16 16zm144-16c-8.8 0-16 7.2-16 16v32c0 8.8 7.2 16 16 16h32c8.8 0 16-7.2 16-16V400c0-8.8-7.2-16-16-16H208zm112 16v32c0 8.8 7.2 16 16 16h32c8.8 0 16-7.2 16-16V400c0-8.8-7.2-16-16-16H336c-8.8 0-16 7.2-16 16z" fill="#00812C" />
                </svg>
            </div>
        </div>

        <form id="myForm" action="{{ route('export-list', ['list' => $exportListName]) }}">
            @csrf

            <input type="hidden" name="search" id="name_for_export" />
            <input type="hidden" name="start_date" id="start_date_for_export" />
            <input type="hidden" name="end_date" id="end_date_for_export" />
            <button class="dropdown-item animate__animated animate__zoomIn " type="submit" id="done">
                <div class="flex items-center  gap-2 px-4 py-[7px] outline outline-1 outline-primary rounded-full">
                    <div>
                        <img src="{{ asset('images/export.png') }}" alt="">
                    </div>
                    <h1 class="text-primary font-poppins font-medium">Export</h1>
                </div>
            </button>
        </form>


        <div class="flex items-center gap-5 animate__animated animate__zoomIn">
            @if(auth()->user()->hasPermissions($permissionName))
            <a href="{{ route($routeName) }}">
                <div class="flex items-center gap-2 px-4 py-[7px] outline outline-1 outline-primary rounded-full">
                    <div>
                        <img src="{{ asset('images/create.png') }}" alt="">
                    </div>
                    <h1 class="text-primary font-medium">{{ $name }}</h1>
                </div>
            </a>
            @endif
            <a href="#" class="text-sm py-1 bg-red-600 text-white px-2 rounded-full clear-button">Clear <i class="fa-solid fa-xmark text-white"></i></a>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const clearButton = document.querySelector('.clear-button');

        clearButton.addEventListener('click', (event) => {
            event.preventDefault();

            const currentRoute = getRouteNameFromUrl();
           
            const localStorageKey = `${currentRoute}_search`;
           
            localStorage.removeItem(localStorageKey);

            window.location.reload();
        });
    });

    function getRouteNameFromUrlReceive() {
        var url = window.location.href;
        var pathName = new URL(url).pathname;

        var parts = pathName.split("/").filter((part) => part !== "");

        if (parts.length >= 2) {
            return parts.slice(-2).join("/");
        } else {
            return parts[0] || null;
        }
    }
</script>
{{-- search end  --}}