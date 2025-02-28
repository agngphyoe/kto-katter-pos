<table>
    <thead>
        <x-table-head-component :columns="[
                    'User Name',
                    'Role',
                    'Permission',
                    'Created By',
                    'Created AT',
                ]" />
    </thead>
    <tbody>
        <tr></tr>
        @include('user.search')
    </tbody>
</table>