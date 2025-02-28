<table>
    <thead>

        <x-table-head-component :columns="[
            'Sale ID',
            'Customer Name',
            'Product Name',
            'Product Code',
            'IMEI Code',
            'Category',
            'Brand',
            'Model',
            'Design',
            'Type',
            'Unit Price',
            'Quantity',
            'Total Amount',
        ]" />
    </thead>
    <tbody>
        @forelse($sale->pointOfSaleProducts as $data)
            @php
                $product = \App\Models\Product::find($data->product_id);
            @endphp
            <tr>
                <td>{{ $sale->order_number }}</td>

                <td>{{ $sale->shopper->name }}</td>

                <td>{{ $product->name }}</td>

                <td>({{ $product->code }})</td>

                <td>
                    @if ($product->is_imei == 1)
                        <span>{{ $data->imei ?? '-' }}</span>
                    @else
                        <span>-</span>
                    @endif
                </td>

                <td>{{ $product->category?->name }}</td>

                <td>{{ $product->brand?->name }}</td>

                <td>{{ $product->productModel?->name }}</td>

                <td>{{ $product->design?->name ?? '-' }}</td>

                <td>{{ $product->type?->name ?? '-' }}</td>

                <td>
                    {{ number_format($data->unit_price) }}
                    @if ($data->is_promote == 1)
                        <span> *</span>
                    @endif
                </td>

                <td>{{ number_format($data->quantity) }}</td>

                <td>{{ number_format($data->price) }}</td>

            </tr>
        @empty
            @include('layouts.not-found', ['colSpan' => 13])
        @endforelse
    </tbody>
</table>
