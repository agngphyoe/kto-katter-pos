<table>
    <thead>
        <x-table-head-component :columns="[
                    'Order Id',
                    'Total Amount',
                    'Discount Amount',
                    'Balance Amount',
                    'Selled Date',
                    'Payment Type',
                    'Created By',
                ]" />
    </thead>
    <tbody>
        <tr></tr>
        @include('pos.search-order')
    </tbody>
</table>