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
            'Sale ID',
            'Customer Name',
            'Total Quantity',
            'Total Amount',
            'Discount Amount',
            'Net Total Amount',
            'Paid Amount',
            'Change Amount',
            'Payment Type',
            'Sell Date',
            'Sell By',
        ]" />
    </thead>
    <tbody>
        <tr></tr>
        @include('report.sale.get-report')
    </tbody>
</table>
