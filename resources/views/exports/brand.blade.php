<table>
    <thead>
        <x-table-head-component :columns="[
            'Name',
            'Prefix',
            'Category',
            'Created By',
            'Created At']" />
    </thead>
    <tbody>
        <tr></tr>

        @include('brand.search')

    </tbody>
</table>