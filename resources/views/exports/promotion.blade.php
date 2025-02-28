<table>
    <thead>
        <x-table-head-component :columns="[
                    'Name',
                    'Code',
                    'Status',
                    'Total Quantity',
                    'Total Promote Amount',
                    'Start Date',
                    'End Date',
                    'Created By',
                    'Created Date',
                    'Change Status',
                ]" />
    </thead>
    <tbody>
        <tr></tr>
        @include('promotion.search')
    </tbody>
</table>