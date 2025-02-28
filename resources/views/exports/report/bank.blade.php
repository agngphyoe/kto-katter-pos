<table>
    <thead>
        <tr>
            <td>
                Date Range
            </td>
            <td>
                {{ $start_date }} - {{ $end_date }}
            </td>
        </tr>
        <tr></tr>
        <x-table-head-component :columns="[
            'Business Type',
            'Bank',
            'Account Name',
            'Amount',
            'Invoice Number',
            'Created By',
            'Created At',
            ]" />
    </thead>
    <tbody>
        <tr></tr>
        @include('report.bank.get-report')
    </tbody>
</table>