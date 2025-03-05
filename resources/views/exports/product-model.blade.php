<table>
    <thead>
        <x-table-head-component :columns="[
        'Name',
        'Prefix',
        'Brand',
        'Category',
        'Created By',
        'Created At',
        ]" />
    </thead>
    <tbody>
        <tr></tr>

        @include('product-model.search')

    </tbody>
</table>