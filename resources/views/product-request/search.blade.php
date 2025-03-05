@forelse($product_requests as $request)

    <tr class="bg-white border-b text-left ">
        <td scope="row" class=" py-4 whitespace-nowrap px-6      ">
            {{ $request->request_inv_code ?? '' }}
        </td>
        <td scope="row" class=" py-4 whitespace-nowrap px-6      ">
            {{ $request->remark ?? '' }}
        </td>
        <td class=" py-4 whitespace-nowrap px-6">
            {{ $request->fromLocationName->location_name ?? '-' }}
        </td>
        <td class=" py-4 whitespace-nowrap px-6">
            {{ $request->toLocationName->location_name ?? '-' }}
        </td>
        <td class=" py-4 whitespace-nowrap px-6">
            {{ $request->user->name ?? '-' }}
        </td>
        <td class=" py-4 whitespace-nowrap px-6">
            @switch($request->status)
                @case('transferred')
                    <x-badge class="bg-green-600 text-white px-2">
                        Transferred
                    </x-badge>
                @break

                @case('reject')
                    <x-badge class="bg-red-600 text-white px-2">
                        Rejected
                    </x-badge>
                @break

                @case('pending')
                    <x-badge class="bg-yellow-400 text-white px-2">
                        Pending
                    </x-badge>
                @break

                @case('partial')
                    <x-badge class="bg-gray-300 text-dark px-2">
                        Partial
                    </x-badge>
                @break

                @default
            @endswitch
        </td>
        <td class=" py-4 whitespace-nowrap px-6 w-48">
            {{ dateFormat(Carbon\Carbon::parse($request->created_at)->format('d-m-Y')) }}
        </td>

        @if (!isset($is_export) || !$is_export)
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
                            <div class="flex flex-col gap-3">

                                {{-- detail --}}
                                @if (auth()->user()->hasPermissions('product-request-detail'))
                                    <a
                                        href="{{ route('product-request-detail', ['product' => $request->request_inv_code]) }}">
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
                                {{-- delete --}}
                                {{-- @if ($request->status == 'pending')
                            <a href="#" data-route="{{ route('product-delete', $request->id) }}" data-redirect-route="product/list" class="deleteAction">
                                <button class=" bg-white outline outline-1 outline-primary h-8 w-8 flex items-center justify-center  rounded-full">
                                    <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 448 512"><!--! Font Awesome Free 6.4.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                                        <path d="M170.5 51.6L151.5 80h145l-19-28.4c-1.5-2.2-4-3.6-6.7-3.6H177.1c-2.7 0-5.2 1.3-6.7 3.6zm147-26.6L354.2 80H368h48 8c13.3 0 24 10.7 24 24s-10.7 24-24 24h-8V432c0 44.2-35.8 80-80 80H112c-44.2 0-80-35.8-80-80V128H24c-13.3 0-24-10.7-24-24S10.7 80 24 80h8H80 93.8l36.7-55.1C140.9 9.4 158.4 0 177.1 0h93.7c18.7 0 36.2 9.4 46.6 24.9zM80 128V432c0 17.7 14.3 32 32 32H336c17.7 0 32-14.3 32-32V128H80zm80 64V400c0 8.8-7.2 16-16 16s-16-7.2-16-16V192c0-8.8 7.2-16 16-16s16 7.2 16 16zm80 0V400c0 8.8-7.2 16-16 16s-16-7.2-16-16V192c0-8.8 7.2-16 16-16s16 7.2 16 16zm80 0V400c0 8.8-7.2 16-16 16s-16-7.2-16-16V192c0-8.8 7.2-16 16-16s16 7.2 16 16z" fill="#00812C" />
                                    </svg>
                                </button>
                            </a>
                        @endif --}}
                                {{-- edit --}}

                                {{-- @if (auth()->user()->hasPermissions('product-edit'))
                        <a href="{{ route('product-edit', ['product' => $transfer->id]) }}">
                            <button class="bg-white outline outline-1 outline-primary h-8 w-8 flex items-center justify-center   rounded-full">
                                <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 512 512"><!--! Font Awesome Free 6.4.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                                    <path d="M395.8 39.6c9.4-9.4 24.6-9.4 33.9 0l42.6 42.6c9.4 9.4 9.4 24.6 0 33.9L417.6 171 341 94.4l54.8-54.8zM318.4 117L395 193.6l-219 219V400c0-8.8-7.2-16-16-16H128V352c0-8.8-7.2-16-16-16H99.4l219-219zM66.9 379.5c1.2-4 2.7-7.9 4.7-11.5H96v32c0 8.8 7.2 16 16 16h32v24.4c-3.7 1.9-7.5 3.5-11.6 4.7L39.6 472.4l27.3-92.8zM452.4 17c-21.9-21.9-57.3-21.9-79.2 0L60.4 329.7c-11.4 11.4-19.7 25.4-24.2 40.8L.7 491.5c-1.7 5.6-.1 11.7 4 15.8s10.2 5.7 15.8 4l121-35.6c15.4-4.5 29.4-12.9 40.8-24.2L495 138.8c21.9-21.9 21.9-57.3 0-79.2L452.4 17zM331.3 202.7c6.2-6.2 6.2-16.4 0-22.6s-16.4-6.2-22.6 0l-128 128c-6.2 6.2-6.2 16.4 0 22.6s16.4 6.2 22.6 0l128-128z" fill="#00812C" />
                                </svg>

                            </button>
                        </a>
                        @endif --}}

                            </div>
                        </div>

                    </div>
                </div>


            </td>
        @endif

    </tr>
    @empty
        @include('layouts.not-found', ['colSpan' => 13])
    @endforelse
