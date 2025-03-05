<table>
    <thead>
        <x-table-head-component :columns="[
        'Code',
        'Remark',
        'FromLocation',
        'To Location',
        'Created By',
        'Status',
        'Transfer date'
        ]" />
    </thead>
    <tbody>
        <tr></tr>

        @include('product-receive.search')

    </tbody>
</table>