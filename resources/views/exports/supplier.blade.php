<table class="mtable" style="width: 100%">
    <thead>
        <x-table-head-component :columns="[
            'Supplier Name',
            'Supplier ID',
            'Phone Number',
            'Contact Person',
            'Contact Phone',
            'Created By',
            'Created Date',
    ]" />
    </thead>
    <tbody>
        <tr></tr>

        @include('supplier.search')

    </tbody>
</table>