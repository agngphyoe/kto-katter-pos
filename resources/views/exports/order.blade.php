<table>
    <thead>
        <x-table-head-component :columns="[
            'Order Number',
            'Order Request',
            'Order Status',
            'Total Net Amount',
            'Shop Name',
            'Created By',
            'Created Date',
        ]" />
    </thead>
    <tbody>
        @include('order.search')
    </tbody>
</table>