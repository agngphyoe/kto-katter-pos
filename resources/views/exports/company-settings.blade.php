<table>
    <thead>
        <x-table-head-component :columns="[
        'Company Name',
        'URL',
        'Created By',
        'Created Date']" />
    </thead>
    <tbody>
        <tr></tr>

        @include('company-settings.search')


    </tbody>
</table>