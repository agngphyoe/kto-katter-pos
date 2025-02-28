<div class="relative overflow-x-auto shadow-lg ">
    <table class="w-full text-sm  text-gray-500 ">
        <thead class="text-sm font-jakarta bg-gray-50   text-primary  ">

            <x-table-head-component :columns="[
                                    'Order Number',
                                    'Order Request',
                                    'Order Status',
                                    'Total Products',
                                    'Created By',
                                    'Ordered Date',
                                    'Total Amount']" />
        </thead>
        <tbody class="font-poppins text-[13px]">
            <tr class="bg-white">
                <th scope="row" class="py-4 font-medium text-noti">
                    {{ $order->order_number }}
                </th>
                <td class="px-6 py-4">
                    <x-badge class="bg-noti text-white px-3">
                        {{ $order->order_request }}
                    </x-badge>

                </td>
                <td class="px-6 py-4 text-noti">
                    <x-badge class="outline outline-1 outline-primary text-primary px-3">
                        {{ $order->order_status }}
                    </x-badge>

                </td>
                <td class="px-4 py-4 text-center">
                    {{ number_format($order->total_quantity) }}

                </td>
                <!-- <td class="px-6 py-4">
                    Bank Transfer

                </td> -->
                <td class="px-6 py-4">
                    {{ $order->createable?->name ?? '-'}}

                </td>
                <td class="px-6 py-4">
                    {{dateFormat($order->order_date) }}

                </td>
                <td class="pl-6 pr-14 py-4 text-right">
                    {{ number_format($order->total_amount) }}

                </td>



            </tr>
        </tbody>
    </table>
</div>
