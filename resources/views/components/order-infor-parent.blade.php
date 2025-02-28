<div class="flex items-center justify-between">
    <h1 class="font-jakarta text-noti font-semibold">Order Information</h1>
    
</div>
<div class="outline-dashed outline-1 outline-primary opacity-50 my-3"></div>

<x-order-infor-child title="" :customer="$customer" />

<div class="outline-dashed outline-1 outline-primary opacity-50 my-3"></div>

<div class="relative overflow-x-auto mt-3">
    <table class="w-full text-sm text-left text-gray-500">
        <thead class="text-base  border-y text-primary">
            <x-table-head-component :columns="[
                    'Order Number',
                    'Order Request',
                    'Order Status',
                    'Total Products',
                    'Reminder',
                    'Created By',
                    'Ordered Date',
                    'Total Buying Amount']" />
        </thead>
        <tbody>
            @forelse($orders as $order)
            <tr class="bg-white border-b ">
                <th scope="row" class="px-6 py-4 font-medium  text-gray-900 whitespace-nowrap ">
                    {{ $order->order_number }}
                </th>
                <td class="px-6 py-4">
                    <button class="bg-noti text-white rounded-full py-1 px-3 ">{{ $order->order_request }}</button>
                </td>
                <td class="px-6 py-4 text-noti">
                    <button class="outline outline-1 outline-primary rounded-full py-1 px-3 text-primary">{{ $order->order_status }}</button>

                </td>
                <td class="px-6 py-4">
                    {{ $order->total_quantity }}

                </td>
                <td class="px-6 py-4">
                    solid Color

                </td>
                <td class="px-6 py-4">
                    {{ $order->user?->name }}

                </td>
                <td class="px-6 py-4">
                    {{ dateFormat($order->order_date)}}

                </td>
                <td class="px-6 py-4 text-noti">
                    {{ number_format($order->total_amount) }} 

                </td>


            </tr>
            @empty
            @endforelse
        </tbody>
    </table>
</div>