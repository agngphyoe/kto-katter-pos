<table>
    <thead>
        <tr>
            {{-- <td>
                Date Range
            </td>
            <td>
                {{ $start_date }} - {{ $end_date }}
            </td> --}}
        </tr>
        <x-table-head-component :columns="[
            'Name',
            'Code',
            'IMEI',
            'Category',
            'Brand',
            'Model',
            'Type',
            'Design',
            'Retail Price',
            'Total Purchase Amount',
            'Quantity',
            'Date',
        ]" />

    </thead>
    <tbody>
        <tr></tr>
        @include('report.product.get-report')
    </tbody>
</table>
