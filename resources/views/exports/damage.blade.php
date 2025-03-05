<table>
    <thead>
        <x-table-head-component :columns="[
            'Remark',
            'Total Damaged Quantity',
            'Damaged Date',
            'Damaged By']" />
    </thead>
    <tbody>
        <tr></tr>

        @include('damage.search')

    </tbody>
</table>