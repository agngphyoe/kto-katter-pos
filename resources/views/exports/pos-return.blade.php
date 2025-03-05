<table>
    <thead>
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
        @include('pos-return.search')
    </tbody>
</table>
