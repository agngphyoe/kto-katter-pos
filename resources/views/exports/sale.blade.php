<table class="w-full text-sm  text-gray-500 ">
    <thead class="sticky top-0 z-10   bg-gray-100  font-jakarta text-primary  ">
        <x-table-head-component :columns="[
            'Sale ID',
            'Customer Name',
            'Total Quantity',
            'Total Amount',
            'Discount Amount',
            'Net Total Amount',
            'Paid Amount',
            'Change Amount',
            'Payment Type',
            'Sell Date',
            'Sell By',
        ]" />
    </thead>
    <tbody>
        <tr></tr>

        @include('sale.search')

    </tbody>
</table>
