@forelse ($designs as $design)
    <tr class="bg-white border-b  text-left ">
        <td class="px-6 py-4 whitespace-nowrap">{{ $design->name }}</td>
        <td class="px-6 py-4 whitespace-nowrap">{{ $design->user?->name ?? '-' }}</td>
        <td class="px-6 py-4 whitespace-nowrap">{{ dateFormat($design->created_at) }}</td>

        @if (!isset($is_export) || !$is_export)
            <td class="px-6 py-4 whitespace-nowrap flex justify-start items-center gap-4">
                {{-- edit --}}
                @if (auth()->user()->hasPermissions('design-edit'))
                    <a href="{{ route('design-edit', ['design' => $design->id]) }}">
                        <svg xmlns="http://www.w3.org/2000/svg" height="1.2em" viewBox="0 0 512 512" class="mx-auto">
                            <path
                                d="M441 58.9L453.1 71c9.4 9.4 9.4 24.6 0 33.9L424 134.1 377.9 88 407 58.9c9.4-9.4 24.6-9.4 33.9 0zM209.8 256.2L344 121.9 390.1 168 255.8 302.2c-2.9 2.9-6.5 5-10.4 6.1l-58.5 16.7 16.7-58.5c1.1-3.9 3.2-7.5 6.1-10.4zM373.1 25L175.8 222.2c-8.7 8.7-15 19.4-18.3 31.1l-28.6 100c-2.4 8.4-.1 17.4 6.1 23.6s15.2 8.5 23.6 6.1l100-28.6c11.8-3.4 22.5-9.7 31.1-18.3L487 138.9c28.1-28.1 28.1-73.7 0-101.8L474.9 25C446.8-3.1 401.2-3.1 373.1 25zM88 64C39.4 64 0 103.4 0 152V424c0 48.6 39.4 88 88 88H360c48.6 0 88-39.4 88-88V312c0-13.3-10.7-24-24-24s-24 10.7-24 24V424c0 22.1-17.9 40-40 40H88c-22.1 0-40-17.9-40-40V152c0-22.1 17.9-40 40-40H200c13.3 0 24-10.7 24-24s-10.7-24-24-24H88z"
                                fill="#00812C" />
                        </svg>
                    </a>
                @endif

                {{-- delete --}}
                @if (auth()->user()->hasPermissions('design-delete'))
                    <a href="#" data-route="{{ route('design-delete', $design->id) }}"
                        data-redirect-route="design" class="deleteAction">
                        <svg xmlns="http://www.w3.org/2000/svg" height="1.2em" viewBox="0 0 448 512" class="mx-auto">
                            <path
                                d="M164.2 39.5L148.9 64H299.1L283.8 39.5c-2.9-4.7-8.1-7.5-13.6-7.5H177.7c-5.5 0-10.6 2.8-13.6 7.5zM311 22.6L336.9 64H384h32 16c8.8 0 16 7.2 16 16s-7.2 16-16 16H416V432c0 44.2-35.8 80-80 80H112c-44.2 0-80-35.8-80-80V96H16C7.2 96 0 88.8 0 80s7.2-16 16-16H32 64h47.1L137 22.6C145.8 8.5 161.2 0 177.7 0h92.5c16.6 0 31.9 8.5 40.7 22.6zM64 96V432c0 26.5 21.5 48 48 48H336c26.5 0 48-21.5 48-48V96H64zm80 80V400c0 8.8-7.2 16-16 16s-16-7.2-16-16V176c0-8.8 7.2-16 16-16s16 7.2 16 16zm96 0V400c0 8.8-7.2 16-16 16s-16-7.2-16-16V176c0-8.8 7.2-16 16-16s16 7.2 16 16zm96 0V400c0 8.8-7.2 16-16 16s-16-7.2-16-16V176c0-8.8 7.2-16 16-16s16 7.2 16 16z"
                                fill="#E53935" />
                        </svg>
                    </a>
                @endif
            </td>
        @endif
    </tr>
@empty
    @include('layouts.not-found', ['colSpan' => 6])

@endforelse
