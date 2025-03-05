@forelse($activies as $activity)
    <tr class="bg-white border-b text-left">
        <td scope="row" class="px-6 py-3 font-medium  text-gray-900 whitespace-nowrap ">
            {{ $activity->createable?->name ?? '-' }}
        </td>
        <td class="px-6 py-3 whitespace-nowrap">
            @if ($activity->createable instanceof App\Models\User)
                {{ $activity->createable?->role?->name ?? '-' }}
            @else
                {{ $activity->createable?->position?->name ?? '-' }}
            @endif
        </td>
        <td class="px-6 py-3 text-noti">
            {{ $activity->activity ?? '-' }}

        </td>
        <td class="px-6 py-3 whitespace-nowrap">
            {{ $activity->title ?? '-' }}

        </td>
        <td class="px-6 py-3 whitespace-nowrap">
            {{ dateFormat($activity->created_at) ?? '-' }}
        </td>
    </tr>
@empty
    @include('layouts.not-found', ['colSpan' => 5])
@endforelse
