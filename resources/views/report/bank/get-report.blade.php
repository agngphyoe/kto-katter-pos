@forelse($bank_reports as $bank_report)

<tr class="bg-white border-b  ">
    <td scope="row" class="px-6   py-4 whitespace-nowrap ">
        <h1 class="text-noti text-left">
            {{ $bank_report->businessType->name ?? '-' }}
        </h1>
    </td>

    <td class="px-6 py-4 whitespace-nowrap">

        {{ $bank_report->bank->bank_name ?? '-' }}
    </td>

    <td class="px-6 py-4 whitespace-nowrap">

        {{ $bank_report->bank->account_name ?? '-' }}
    </td>

    <td class="px-6 py-4 whitespace-nowrap text-noti">

        {{ number_format($bank_report->amount) ?? '-' }}
    </td>

    <td class="px-6 py-4 whitespace-nowrap">

        {{ $bank_report->transaction_type ?? '-' }}
    </td>

    <td class="px-6 py-4 whitespace-nowrap">

        {{ $bank_report->invoice_number ?? '-' }}
    </td>

    <td class="px-6 py-4    ">

        {{ $bank_report->user->name ?? '-' }}
    </td>

    <td class="px-6 py-4    ">

        {{ dateFormat( $bank_report->created_at )  ?? '-' }}
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