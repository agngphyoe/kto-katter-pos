<table>
    <thead>
        <x-table-head-component :columns="[
            'Customer Name',
            'Customer ID',
            'Sale Invoice',
            'Delivered To',
            'Status',
            'Created By',
            'Created At',
            ]" />
    </thead>
    <tbody>
        @php
        use App\Constants\DeliveryStatus;

        @endphp

        @forelse($deliveries as $delivery)
            <tr>
                <th>
                    <div>
                        {{ $delivery->sale?->saleableBy?->name }}
                    </div>

                </th>

                <td>
                    {{ $delivery->sale?->saleableBy?->user_number }}
                </td>
                <td>
                    {{ $delivery->sale?->invoice_number }}
                </td>
                <td>
                    {{ $delivery->sale?->division?->name }} , {{ $delivery->sale?->township?->name }}

                </td>
                <td>
                    @php
                        if($delivery->status=='Delivered'){
                            $buttonColor = 'bg-[#00812C]';
                        }
                        if($delivery->status=='Pending'){
                            $buttonColor = 'bg-red-600';
                        }
                        if($delivery->status=='In_Transit'){
                            $buttonColor = 'bg-[#FF8A00]';
                        }
                    @endphp
                    <x-badge class="{{ $buttonColor }} text-white px-3">
                        {{ $delivery->status }}
                    </x-badge>
                </td>
                <td>
                    {{ $delivery->user?->name ?? '-' }}
                </td>

                <td>
                    {{ dateFormat($delivery->created_at) }}
                </td>

            </tr>
        @empty

            @include('layouts.not-found', ['colSpan' => 8])
        @endforelse

    </tbody>
</table>