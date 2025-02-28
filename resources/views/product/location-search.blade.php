@forelse ($stocks as $stock)
    <tr class="bg-white border-b text-left">
        <td class="px-6 py-4 whitespace-nowrap">{{ $stock->location->location_name ?? '-' }}</td>
        <td class="px-6 py-4 text-noti text-center">{{ $stock->quantity }}</td>
    </tr>
@empty

    @include('layouts.not-found', ['colSpan' => 4])
@endforelse
