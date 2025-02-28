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
        <x-table-head-component :columns="
            ['Invoice Number', 
            'Customer Name', 
            'Customer Phone', 
            'Status', 
            'Amount', 
            'Total Paid Amount', 
            'Payment Date', 
            'Next Payment Date', 
            ]" />
    </thead>
    <tbody>
        <tr></tr>
        @include('report.sale-payment.get-report')
    </tbody>
</table>