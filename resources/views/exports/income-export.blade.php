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

        @forelse ($incomes as $income)
            <tr class="bg-white border-b text-left">

                <td class="px-6 py-4 whitespace-nowrap  ">{{ $income->businessType->name }}</td>
                <td class="px-6 py-4 whitespace-nowrap  ">{{ $income->description }}</td>
                <td class="px-6 py-4 whitespace-nowrap  ">{{ $income->account->name }}</td>
                <td class="px-6 py-4 whitespace-nowrap  ">{{ number_format($income->amount) }}</td>
                <td class="px-6 py-4 whitespace-nowrap  ">{{ $income->invoice_number ?? '-'}} </td>
                <td class="px-6 py-4 whitespace-nowrap  ">{{ $income->employee_name ?? '-'}}</td>
                <td class="px-6 py-4 whitespace-nowrap">{{
                    dateFormat($income->issue_date)
                    }}</td>
                <td class="px-6 py-4 whitespace-nowrap  ">{{ $income->bank?->bank_name ?? '-'}}</td>
            </tr>
            @empty
            @include('layouts.not-found', ['colSpan' => 8])

            @endforelse

    </tbody>
</table>