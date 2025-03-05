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
            'Sale Return ID',
            'Sale ID',
            'Product Code',
            'Customer Name',
            'Total Quantity',
            'Buying Amount',
            'Refund Amount',
            'Return Quantity',
            'Remark',
            'Return Date',
            'Return By',
        ]" />
    </thead>
    <tbody>
        <tr></tr>
        @include('report.sale-return.get-report')
    </tbody>
</table>
