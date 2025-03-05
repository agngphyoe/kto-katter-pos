<table>
    <thead>
        <x-table-head-component :columns="[
        'Remark',
        'Location',
        'Product',
        'Status',
        'Quantity',
        'Action By',
        'Adjustment Date',
        ]" />
    </thead>
    <tbody>
        <tr></tr>

        @include('exports.stockAdjustment')

    </tbody>
</table>