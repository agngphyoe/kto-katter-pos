<table>
    <thead>
        <x-table-head-component :columns="[
            'Name',
            'User Number',
            'Phone',
            'Type',
            'Township',
            'Division',
            'Created At',
        ]" />
    </thead>
    <tbody>
        <tr></tr>

        @include('customer.search')


    </tbody>
</table>