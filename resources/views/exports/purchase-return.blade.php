<table>
    <thead>
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

        @include('purchase-return.search')

    </tbody>
</table>
