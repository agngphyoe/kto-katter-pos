<table>
    <thead>
        <x-table-head-component :columns="[
        'Code',
        'Name',
        'Categories',
        'Brand',
        'Model',
        'Type',
        'Design',
        'Quantity',
        'Price',
        'Created By',
        'Created At']" />
    </thead>
    <tbody>
        <tr></tr>

        @include('product.search')

    </tbody>
</table>