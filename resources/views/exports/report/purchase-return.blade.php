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
            'Purchase Return ID',
            'Purchase ID',
            'Supplier ID',
            'Supplier Name',
            'Purchase Type',
            'Total Buying Quantity',
            'Return Quantity',
            'Return Remark',
            'Return Date',
            'Return By',
        ]" />
    </thead>
    <tbody>
        <tr></tr>
        @include('report.purchase-return.get-report')
    </tbody>
</table>
