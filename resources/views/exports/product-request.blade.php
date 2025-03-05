<table>
    <thead>
        <x-table-head-component :columns="[
        'Code',
        'Remark',
        'FromLocation',
        'To Location',
        'Created By',
        'Status',
        'Request date'
        ]" />
    </thead>
    <tbody>
        <tr></tr>

        @include('product-request.search')

    </tbody>
</table>