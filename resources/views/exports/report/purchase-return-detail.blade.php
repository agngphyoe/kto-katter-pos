<table>
    <thead>

        <x-table-head-component :columns="[
            'Product Name (ID)',
            'Category',
            'Brand',
            'Model',
            'Design',
            'Type',
            'Buy Price',
            'Quantity',
            'Amount',
        ]" />
    </thead>
    <tbody">
        @forelse($purchase_return->purchaseReturnProducts as $return_product)
            <tr>
                <td>
                    <div>
                        <span class="text-noti">{{ $return_product->product->name ?? '-' }}
                            ({{ $return_product->product->code ?? '-' }})
                        </span>
                    </div>
                </td>

                <td>{{ $return_product->product?->category?->name ?? '-' }}</td>

                <td>{{ $return_product->product?->brand?->name ?? '-' }}</td>

                <td>{{ $return_product->product?->productModel?->name ?? '-' }}</td>

                <td>{{ $return_product->product?->design?->name ?? '-' }}</td>

                <td>{{ $return_product->product?->type?->name ?? '-' }}</td>

                <td>{{ number_format($return_product->unit_price) ?? '-' }}</td>

                <td>{{ $return_product->quantity ?? '-' }}</td>

                <td>{{ number_format($return_product->unit_price * $return_product->quantity) ?? '-' }}</td>

            </tr>
        @empty
        @endforelse
        </tbody>
</table>
