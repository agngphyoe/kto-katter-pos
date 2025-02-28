<table>
    <thead>

        <x-table-head-component :columns="[
            'Purchase ID',
            'Supplier ID',
            'Supplier Name',
            'Product Name',
            'Product Code',
            'Categories',
            'Brand',
            'Model',
            'Design',
            'Type',
            'Buying Price',
            'Total Quantity',
            'Total Buying Amount',
            'Discount',
            'Net Amount',
            'Cash Down',
            'Paid Amount',
            'Remaining Amount',
        ]" />
    </thead>
    <tbody>
        @forelse($purchase->purchaseProducts as $purchaseData)
            @php
                $product = \App\Models\Product::find($purchaseData->product_id);
            @endphp
            <tr>

                <td>{{ $purchase->invoice_number }}</td>

                <td>{{ $purchase->supplier?->user_number }}</td>

                <td>{{ $purchase->supplier?->name ?? '-' }}</td>

                <td>{{ $product->name }}</td>

                <td>{{ $product->code }}</td>

                <td>{{ $product->category?->name }}</td>

                <td>{{ $product->brand?->name }}</td>

                <td>{{ $product->productModel?->name }}</td>

                <td>{{ $product->design?->name ?? '-' }}</td>

                <td>{{ $product->type?->name ?? '-' }}</td>

                <td>{{ number_format($purchaseData->buying_price) }}</td>

                <td>{{ number_format($purchaseData->purchase_quantity) }}</td>

                <td> {{ number_format($purchase->currency_purchase_amount) }}</td>

                <td>{{ number_format($purchase->currency_discount_amount) }}</td>

                <td>{{ number_format($purchase->currency_purchase_amount - $purchase->currency_discount_amount) }}</td>

                <td>{{ number_format($purchase->cash_down) }}</td>

                <td>{{ number_format($purchase->total_paid_amount) }}</td>

                <td>

                    @php
                        $remaining = \App\Models\Paymentable::where('paymentable_type', 'App\Models\Purchase')
                            ->where('paymentable_id', $purchase->id)
                            ->orderByDesc('id')
                            ->first();
                    @endphp
                    {{ number_format($remaining->remaining_amount) }}
                </td>

            </tr>
        @empty
            @include('layouts.not-found', ['colSpan' => 13])
        @endforelse
    </tbody>
</table>
