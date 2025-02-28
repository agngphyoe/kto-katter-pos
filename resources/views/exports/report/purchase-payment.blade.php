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
            'Purchase Payment ID',
            'Purchase ID',
            'Supplier ID',
            'Supplier Name',
            'Purchase Type',
            'Total Quantity',
            'Net Total Buying Amount',
            'Paid Amount',
            'Remaining Amount',
            'Payment Due Date',
            'Status',
            'Purchase Date',
            'Purchase By',
        ]" />
    </thead>
    <tbody>
        <tr></tr>
        @include('report.purchase-payment.get-report')
    </tbody>
</table>
