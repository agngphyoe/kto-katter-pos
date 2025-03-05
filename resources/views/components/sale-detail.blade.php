<div class="relative shadow-lg overflow-x-auto pt-3">
    <table class="w-full text-sm  text-gray-500 ">
        <thead class="text-sm font-jakarta bg-gray-50    text-primary  ">
            <x-table-head-component :columns="[
                                        'Sale Invoice',
                                        'Sale Type',
                                        // 'Tax',
                                        'Delivery Charges',
                                        'Total Amount',
                                        // 'Cashdown Amount',
                                        // 'Remaining Amount',
                                        'Return(+) / Refund(-)',
                                        'Sold At',
                                        'Sold By']" />
        </thead>
        <tbody class="font-poppins text-[13px]">
            <tr class="bg-white  ">
                <td class="px-6 py-4">
                    {{ $sale->invoice_number }}
                </td>
                <td class="px-6 py-4">
                    @php
                        if($sale->action_type == 'Credit'){
                            $buttonColor = 'bg-[#FF8A00]';
                        }
                        if ($sale->action_type == 'Cash') {
                            $buttonColor = 'bg-[#00812C]';
                        }
                        if($sale->action_type == 'Consignment')
                        {
                            $buttonColor = 'bg-[#FFC727]';
                        }

                    @endphp

                    <x-badge class="{{ $buttonColor }} text-white px-3">
                        {{ $sale->action_type ?? '-' }}
                    </x-badge>

                    <button class="text-noti cursor-default outline-noti text-[12px] px-3 font-semibold rounded-full"
                            style="background-color: {{ $buttonColor }}; color: white;">
                        {{ $sale->action_type ?? '-' }}
                    </button>
                </td>
                {{-- <td class="px-6 py-4 text-noti">
                    {{ $sale->tax_amount > 0 ? $sale->tax_amount : '-' }}

                </td> --}}
                <td class="px-6 py-4">
                    {{ number_format($sale->delivery_amount) }}

                </td>
                <td class="pl-6 pr-12 py-4">
                    {{ number_format($sale->total_amount) }}

                </td>
                {{-- <td class="pl-6 pr-12 py-4">
                    {{ number_format($sale->cash_down) }}

                </td>
                <td class="pl-6 pr-12 py-4">
                    {{ number_format($sale->remaining_amount) }}

                </td> --}}
                @php
                    $latest_sale_return = $sale->returnable->last();

                    $sale_return_refund_amount = $latest_sale_return?->latest_cash_back_amount;

                    if ($sale_return_refund_amount > 0) {

                        if ($latest_sale_return?->latest_cash_back_type == "Refund") {

                            $sale_return_refund_amount = '- ' . number_format($sale_return_refund_amount);
                        } else {

                            $sale_return_refund_amount = number_format($sale_return_refund_amount);
                        }
                    }
                @endphp
                <td class="px-6 py-4">
                    {{ $sale_return_refund_amount }}

                </td>
                <td class="px-6 py-4">

                    {{ date('d M, Y', strtotime($sale->action_date))}}

                </td>
                <td class="px-6 py-4">
                    {{ $sale->user?->name }}

                </td>

            </tr>
        </tbody>
    </table>
</div>
