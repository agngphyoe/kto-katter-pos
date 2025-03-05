@forelse($customers as $customer)
<tr class="bg-white border-b  ">
    <td scope="row" class="px-6   py-4 whitespace-nowrap ">
        <h1 class="text-noti text-left">
            {{ $customer->name }} ({{ $customer->user_number }})
        </h1>
    </td>

    <td class="px-6 py-4 whitespace-nowrap">

        {{ $customer->phone ?? '-' }}
    </td>

    <td class="px-6 py-4 whitespace-nowrap">

        {{ $customer->division?->name ?? '-' }}
    </td>
    <td class="px-6 py-4 whitespace-nowrap">

        {{ $customer->township?->name ?? '-' }}
    </td>
    <td class="px-6 py-4 whitespace-nowrap">

        {{ $customer->contact_name ?? '-' }}
    </td>

    <td class="px-6 py-4  text-noti  ">

        {{ $customer->contact_phone ?? '-' }}
    </td>
    <td class="px-6 py-4  text-noti  ">

        {{ $customer->type ?? '-' }}
    </td>
    <td class="px-6 py-4  text-noti  ">

        {{ dateFormat($customer->created_at) }}
    </td>
</tr>
@empty
<tr>
    <td colspan="8" class="py-5">
        <img class="mx-auto w-28" src="{{ asset('images/not_found.gif') }}">
        <h1 class="text-center pt-3">Not Found Data</h1>
    </td>
</tr>
@endforelse
