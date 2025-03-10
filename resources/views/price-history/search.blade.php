@php
    use App\Models\User;
@endphp
@forelse ($product_price_histories as $product_price_history)
    <tr class="bg-white border-b  text-left font-poppins">
        @php
            $createdByArray = explode(',', $product_price_history->created_by);

            // Initialize an array to store user names
            $userNames = [];

            // Assuming you have a User model with a 'name' attribute
            foreach ($createdByArray as $userId) {
                // Retrieve the user by their ID and get the 'name' attribute
                $user = User::find($userId);

                if ($user) {
                    $userNames[] = $user->name;
                }
            }
        @endphp

        <td class="px-6 py-4 whitespace-nowrap">
            @foreach ($userNames as $userName)
                {{ $userName ?? '-' }}
            @endforeach
        </td>
        <td class="px-6 py-4 whitespace-nowrap">{{ dateFormat($product_price_history->date) ?? '-' }}
            {{ timeFormat($product_price_history->date) }}</td>
        <td class=" py-4 whitespace-nowrap  ">
            <div class="flex items-center justify-center">
                <div class="flex items-center  gap-5 icon-container">
                    <button class="bg-bgMain h-9 w-9 flex items-center justify-center rounded-full">
                        <svg xmlns="http://www.w3.org/2000/svg" height="1.5em" viewBox="0 0 128 512">
                            <path
                                d="M64 360a56 56 0 1 0 0 112 56 56 0 1 0 0-112zm0-160a56 56 0 1 0 0 112 56 56 0 1 0 0-112zM120 96A56 56 0 1 0 8 96a56 56 0 1 0 112 0z"
                                fill="#00812C" class="centered-svg" />
                        </svg>
                    </button>
                    <div>

                    </div>
                    <div class="flex items-center hover-icons ">
                        <div class="flex flex-col gap-6">

                            {{-- detail --}}
                            @if (auth()->user()->hasPermissions('product-detail'))
                                <a
                                    href="{{ route('product-history-detail', ['date' => $product_price_history->date]) }}">
                                    <button
                                        class="bg-white outline outline-1 outline-primary h-8 w-8 flex items-center justify-center rounded-full">
                                        <svg xmlns="http://www.w3.org/2000/svg" height="1em"
                                            viewBox="0 0 576 512"><!--! Font Awesome Free 6.4.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                                            <path
                                                d="M288 80c-65.2 0-118.8 29.6-159.9 67.7C89.6 183.5 63 226 49.4 256c13.6 30 40.2 72.5 78.6 108.3C169.2 402.4 222.8 432 288 432s118.8-29.6 159.9-67.7C486.4 328.5 513 286 526.6 256c-13.6-30-40.2-72.5-78.6-108.3C406.8 109.6 353.2 80 288 80zM95.4 112.6C142.5 68.8 207.2 32 288 32s145.5 36.8 192.6 80.6c46.8 43.5 78.1 95.4 93 131.1c3.3 7.9 3.3 16.7 0 24.6c-14.9 35.7-46.2 87.7-93 131.1C433.5 443.2 368.8 480 288 480s-145.5-36.8-192.6-80.6C48.6 356 17.3 304 2.5 268.3c-3.3-7.9-3.3-16.7 0-24.6C17.3 208 48.6 156 95.4 112.6zM288 336c44.2 0 80-35.8 80-80s-35.8-80-80-80c-.7 0-1.3 0-2 0c1.3 5.1 2 10.5 2 16c0 35.3-28.7 64-64 64c-5.5 0-10.9-.7-16-2c0 .7 0 1.3 0 2c0 44.2 35.8 80 80 80zm0-208a128 128 0 1 1 0 256 128 128 0 1 1 0-256z"
                                                fill="#00812C" />
                                        </svg>
                                    </button>
                                </a>
                            @endif

                        </div>

                    </div>
                </div>


        </td>
    </tr>
@empty
    @include('layouts.not-found', ['colSpan' => 6])
@endforelse
