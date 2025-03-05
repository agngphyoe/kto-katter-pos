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
            'Customer Name (ID)',
            'Phone',
            'Division',
            'Township',
            'Contact Name',
            'Contact Phone',
            'Type',
            'Created Date'
            ]" />
    </thead>
    <tbody>
        <tr></tr>
        @include('report.customer.get-report')
    </tbody>
</table>