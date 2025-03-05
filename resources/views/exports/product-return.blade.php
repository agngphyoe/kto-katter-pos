<table>
    <thead>
        <x-table-head-component :columns="[
        'Code',
        'Remark',
        'FromLocation',
        'To Location',
        'Created By',
        'Status',
        'Return date'
        ]" />
    </thead>
    <tbody>
        <tr></tr>

        @include('product-return.search')

    </tbody>
</table>