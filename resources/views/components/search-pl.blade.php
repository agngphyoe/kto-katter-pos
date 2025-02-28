{{-- search start --}}
<div class="data-serch font-poppins text-[15px]">
    <div
        class=" ml-[20px] bg-white flex items-center justify-start xl:justify-between flex-wrap gap-4 px-4 py-4 rounded-[20px]  md:ml-[270px] my-5 mr-[20px] 2xl:ml-[320px]">

        <div class="flex items-center gap-4 animate__animated animate__zoomIn">
            <div class="flex items-center w-full outline outline-1 outline-primary rounded-full px-4 py-[7px]">
                <input type="search" class="outline-none outline-transparent" placeholder="Search..." id="searchInput"
                    value="{{ request()->get('search') }}">

                <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 512 512">
                    <path
                        d="M416 208c0 45.9-14.9 88.3-40 122.7L502.6 457.4c12.5 12.5 12.5 32.8 0 45.3s-32.8 12.5-45.3 0L330.7 376c-34.4 25.2-76.8 40-122.7 40C93.1 416 0 322.9 0 208S93.1 0 208 0S416 93.1 416 208zM208 352a144 144 0 1 0 0-288 144 144 0 1 0 0 288z"
                        fill="#00812C" />
                </svg>
            </div>
        </div>

        {{-- Format Button --}}
        <div class="flex items-center gap-4 animate__animated animate__zoomIn">
            <a href="{{ route('profit-and-loss-select-income-expense') }}">
                <button type="button"
                    class="outline outline-1 text-primary text-md outline-primary w-full md:w-44 py-2 rounded-full">
                    Format
                </button>
            </a>
        </div>

        @isset($permissionName)
            <div class="flex items-center gap-5 animate__animated animate__zoomIn">
                @if (auth()->user()->hasPermissions($permissionName))
                    <a href="{{ route($routeName) }}">
                        <div class="flex items-center gap-2 px-4 py-[7px] outline outline-1 outline-primary rounded-full">
                            <div>
                                @if ($name != 'Histories List')
                                    <img src="{{ asset('images/create.png') }}" alt="">
                                @endif
                            </div>
                            <h1 class="text-primary font-medium">{{ $name }}</h1>
                        </div>
                    </a>
                @endif
            </div>
        @endisset

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

    function getRouteNameFromUrl() {
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
