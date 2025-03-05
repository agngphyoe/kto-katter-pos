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
            'Purchase ID',
            'Supplier ID',
            'Supplier Name',
            'Purchase Type',
            'Currency Type',
            'Total Quantity',
            'Total Buying Amount',
            'Discount',
            'Net Amount',
            'Cash Down',
            'Paid Amount',
            'Remaining Amount',
            'Status',
            'Purchase Date',
            'Purchase By',
        ]" />
    </thead>
    <tbody>
        <tr></tr>
        @include('report.purchase.get-report')
    </tbody>
</table>
