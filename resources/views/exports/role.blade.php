<table>
    <thead>

        <x-table-head-component :columns="[
                        'Role Name',
                        'User',
                        'Permission Allowed',
                        'All Permission',
                        'Created At',
                        'Created By',
                    ]" />
    </thead>
    <tbody>
        @include('role.search')
    </tbody>
</table>