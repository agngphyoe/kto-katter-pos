<table>
    <thead>
        <x-table-head-component :columns="[
                'Product Name',
                'Product Code',
                'Old Price',
                'New Price',
                'Created By',
                'Created At',
                ]" />
    </thead>
    <tbody>
        @include('price-history.search')
    </tbody>
</table>