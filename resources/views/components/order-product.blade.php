
<div class="relative overflow-x-auto pt-3 shadow-lg">
    <table class="w-full text-sm text-left   text-gray-500 ">
        <thead class="text-sm font-jakarta bg-gray-50   text-primary  ">
            <tr>
                <th scope="col" class="px-6 py-3 whitespace-nowrap py-3">
                    Order Number
                </th>
                <th scope="col" class="px-6 py-3 whitespace-nowrap">
                    Order Request
                </th>
                <th scope="col" class="px-6 py-3 whitespace-nowrap">
                    Order Status
                </th>
                <th scope="col" class="px-6 py-3 whitespace-nowrap">
                    Total Products
                </th>
                <th scope="col" class="px-6 py-3 whitespace-nowrap">
                    Created By
                </th>
                <th scope="col" class="px-6 py-3 whitespace-nowrap">
                    Ordered Date
                </th>
                <th scope="col" class="px-6 py-3 whitespace-nowrap">
                    Total Buying Price
                </th>

            </tr>
        </thead>
        <tbody class="font-poppins text-[13px]">
            @forelse($orders as $order)
            <tr class="bg-white  border-b   ">
                <th scope="row" class="px-6 py-3 font-medium  text-noti whitespace-nowrap ">
                    {{ $order->order_number }}
                </th>
                <td class="px-6 py-3 ">
                    <x-badge class="{{ $order->order_request == 'Normal' ? 'bg-[#00812C]' :'bg-[#FF8A00]'  }} text-white px-3" >
                        {{ $order->order_request }}
                    </x-badge>
                   
                </td>
               
                <td class="px-6 py-3 text-noti">
                    <x-badge class="{{ $order->order_status == \App\Constants\ProgressStatus::ONGOING ? 'bg-[#FF8A00]' : 'bg-[#00812C]'  }} text-white px-3">
                        {{ $order->order_status }}
                    </x-badge>
                  

                </td>
                <td class="px-6 py-3 text-center">
                    {{ $order->total_quantity }}

                </td>
                <td class="px-6 py-3" >
                    {{ $order->user?->name ?? '-'}}

                </td>
                <td class="px-6 py-3">
                    {{ dateFormat($order->order_date) }}

                </td>
                <td class="pl-6 pr-10  py-3 text-center text-noti">
                    {{ number_format($order->total_amount) }}

                </td>



            </tr>
            @empty
            <tr><td>No Order</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
