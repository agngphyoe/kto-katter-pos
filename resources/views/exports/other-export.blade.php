<table>
    <thead>
        <x-table-head-component :columns="[
        'Business',
        'Description',
        'Account',
        'Amount(MMK)',
        'Type',
        'Invoice Number',
        'NameBy',
        'DateBy',
        'Bank'
        ]" />
    </thead>
    <tbody>
        <tr></tr>

        @forelse ($others as $other)
            <tr class="bg-white border-b text-left">

                <td class="px-6 py-4 whitespace-nowrap  ">{{ $other->businessType->name }}</td>
                <td class="px-6 py-4 whitespace-nowrap  ">{{ $other->description }}</td>
                <td class="px-6 py-4 whitespace-nowrap  ">{{ $other->account->name }}</td>
                <td class="px-6 py-4 whitespace-nowrap  ">{{ number_format($other->amount) }}</td>
                <td class="px-6 py-4 whitespace-nowrap  ">{{ $other->invoice_number ?? '-'}} </td>
                <td class="px-6 py-4 whitespace-nowrap  ">{{ $other->employee_name ?? '-'}}</td>
                <td class="px-6 py-4 whitespace-nowrap">{{
                    dateFormat($other->issue_date)
                    }}</td>
                <td class="px-6 py-4 whitespace-nowrap  ">{{ $other->bank?->bank_name ?? '-'}}</td>
            </tr>
            @empty
            @include('layouts.not-found', ['colSpan' => 8])

            @endforelse

    </tbody>
</table>