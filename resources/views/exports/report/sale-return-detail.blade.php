<table>
    <thead>
        <x-table-head-component :columns="[
            'Sale ID',
            'Customer Name',
            'Product Name',
            'Product Code',
            'Category',
            'Brand',
            'Model',
            'Design',
            'Type',
            'Return Type',
            'Quantity',
            'Remark',
        ]" />
    </thead>
    <tbody>
        @forelse($return->posReturnProducts as $data)
            @php
                $product = App\Models\Product::find($data['product_id']);
            @endphp
            <tr>

                <td>{{ $return->pointOfSale->order_number }}</td>

                <td>{{ $return->pointOfSale->shopper->name }}</td>

                <td>{{ $product->name }}</td>

                <td>{{ $product->code }}</td>

                <td>{{ $product->category?->name }}</td>

                <td>{{ $product->brand?->name }}</td>

                <td>{{ $product->productModel?->name }}</td>

                <td>{{ $product->design?->name ?? '-' }}</td>

                <td>{{ $product->type?->name ?? '-' }}</td>

                <td>
                    <x-badge>
                        {{ $data['return_type'] == 'product' ? 'Exchange' : 'Cash' }}
                    </x-badge>
                </td>

                <td>{{ number_format($data['quantity']) }}</td>

                <td>{{ $return->remark }}</td>

            </tr>
        @empty
        @endforelse
    </tbody>
</table>
