@forelse($cash_book_reports as $cash_book_report)

<tr class="bg-white border-b  ">
    <td scope="row" class="px-6   py-4 whitespace-nowrap ">
        <h1 class="text-noti text-left">
            {{ $cash_book_report->businessType->name ?? '-' }}
        </h1>
    </td>

    <td class="px-6 py-4 whitespace-nowrap">

        {{ $cash_book_report->account->name ?? '-' }}
    </td>

    <td class="px-6 py-4 whitespace-nowrap">

        {{ $cash_book_report->bank->bank_name ?? '-' }}
    </td>

    <td class="px-6 py-4 whitespace-nowrap">

        {{ $cash_book_report->transaction_type ?? '-' }}
    </td>

    <td class="px-6 py-4 whitespace-nowrap text-noti">

        {{ number_format($cash_book_report->amount) ?? '-' }}
    </td>

    <td class="px-6 py-4 whitespace-nowrap text-noti">

        {{ $cash_book_report->invoice_number ?? '-' }}
    </td>

    <td class="px-6 py-4 whitespace-nowrap">

        {{ $cash_book_report->employee_name ?? '-' }}
    </td>
    <td class="px-6 py-4    ">

        {{ $cash_book_report->user->name ?? '-' }}
    </td>
    <td class="px-6 py-4    ">

        {{ dateFormat( $cash_book_report->created_at )  ?? '-' }}
    </td>
</tr>
@empty
<tr>
    <td colspan="9" class="py-5">
        <img class="mx-auto w-28" src="{{ asset('images/not_found.gif') }}">
        <h1 class="text-center pt-3">Not Found Data</h1>
    </td>
</tr>
@endforelse
