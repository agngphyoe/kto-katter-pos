<table>
    <thead>
        <x-table-head-component :columns="[
        'Name',
        'Prefix',
        'Created By',
        'Created At']" />
    </thead>
    <tbody>
        <tr></tr>
        @include('category.search')
    </tbody>
</table>