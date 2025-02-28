<table>
    <thead>
        <x-table-head-component :columns="[
            'Purchase ID',
            'Supplier ID',
            'Supplier Name',
            'Purchase Type',
            'Currency Type',
            'Total Quantity',
            'Total Buying Amount',
            'Discount',
            'Cash Down',
            'Paid Amount',
            'Remaining Amount',
            'Net Amount',
            'Status',
            'Purchase Date',
            'Purchase By',
            'Action',
        ]" />
    </thead>
    <tbody>
        <tr></tr>

        @include('purchase.search')

    </tbody>
</table>
