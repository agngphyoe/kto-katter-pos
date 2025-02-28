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

        @forelse ($expenses as $expense)
            <tr class="bg-white border-b text-left">

                <td class="px-6 py-4 whitespace-nowrap  ">{{ $expense->businessType->name }}</td>
                <td class="px-6 py-4 whitespace-nowrap  ">{{ $expense->description }}</td>
                <td class="px-6 py-4 whitespace-nowrap  ">{{ $expense->account->name }}</td>
                <td class="px-6 py-4 whitespace-nowrap  ">{{ number_format($expense->amount) }}</td>
                <td class="px-6 py-4 whitespace-nowrap  ">{{ $expense->invoice_number ?? '-'}} </td>
                <td class="px-6 py-4 whitespace-nowrap  ">{{ $expense->employee_name ?? '-'}}</td>
                <td class="px-6 py-4 whitespace-nowrap">{{
                    dateFormat($expense->issue_date)
                    }}</td>
                <td class="px-6 py-4 whitespace-nowrap  ">{{ $expense->bank?->bank_name ?? '-'}}</td>
            </tr>
            @empty
            @include('layouts.not-found', ['colSpan' => 8])

            @endforelse

    </tbody>
</table>