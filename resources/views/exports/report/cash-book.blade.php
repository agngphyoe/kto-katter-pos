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
            'Account',
            'Bank',
            'Account Type',
            'Amount',
            'Invoice Number',
            'Employee',
            'Created By',
            'Created At',
            ]" />
    </thead>
    <tbody>
        <tr></tr>
        @include('report.cash-book.get-report')
    </tbody>
</table>