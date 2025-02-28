<table>
    <thead>
        <tr>
            <th>Reconcilication ID</th>
            <th>Location Date</th>
            <th>Product Name</th>
            <th>Code</th>
            <th>Software Qty</th>
            <th>Ground Qty</th>
            <th>Discrepancy</th>
            <th>Reconcile By</th>
            <th>Reconcile Date</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($reconciliation->products as $product)
            @php
                $discrepancy = $product->pivot->real_qty - $product->pivot->inv_qty;
                $isDiscrepant = $discrepancy !== 0;
            @endphp
            <tr>
                <td @if ($isDiscrepant) style="color: #FF0000;" @endif>
                    {{ $reconciliation->reconciliation_id }}</td>
                <td @if ($isDiscrepant) style="color: #FF0000;" @endif>
                    {{ $reconciliation->location->location_name }}</td>
                <td @if ($isDiscrepant) style="color: #FF0000;" @endif>{{ $product->name }}</td>
                <td @if ($isDiscrepant) style="color: #FF0000;" @endif>{{ $product->code }}</td>
                <td @if ($isDiscrepant) style="color: #FF0000;" @endif>{{ $product->pivot->inv_qty }}</td>
                <td @if ($isDiscrepant) style="color: #FF0000;" @endif>{{ $product->pivot->real_qty }}
                </td>
                <td @if ($isDiscrepant) style="color: #FF0000;" @endif>
                    @if ($discrepancy > 0)
                        +{{ $discrepancy }}
                    @else
                        {{ $discrepancy }}
                    @endif
                </td>
                <td @if ($isDiscrepant) style="color: #FF0000;" @endif>
                    {{ $reconciliation->createdBy->name }}
                </td>
                <td @if ($isDiscrepant) style="color: #FF0000;" @endif>
                    {{ $reconciliation->created_at->format('d M Y') }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
