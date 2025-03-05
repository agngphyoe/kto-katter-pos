@forelse($productables as $productable)
    <tr class="bg-white border-b text-left ">
        <td scope="row" class="px-6 py-4 whitespace-nowrap">
            <h1 class="text-left">
                {{ $productable->name }}
            </h1>
        </td>

        <td scope="row" class="px-6 py-4 whitespace-nowrap text-noti">
            {{ $productable->code }}
        </td>

        <td class="px-6 py-4 whitespace-nowrap">
            @if ($productable->available_imei_products && $productable->available_imei_products->count() > 0)
                <ul>
                    @foreach ($productable->available_imei_products as $imeiProduct)
                        <li>{{ $imeiProduct->imei_number }}, </li>
                    @endforeach
                </ul>
            @else
                <span>-</span>
            @endif
        </td>

        <td class="px-6 py-4 whitespace-nowrap">

            {{ $productable->category?->name ?? '-' }}
        </td>

        <td class="px-6 py-4 whitespace-nowrap">

            {{ $productable->brand?->name ?? '-' }}
        </td>

        <td class="px-6 py-4 whitespace-nowrap">
            {{ $productable->productModel?->name ?? '-' }}
        </td>

        <!-- Design Column -->
        <td class="px-6 py-4 whitespace-nowrap">
            {{ $productable->design?->name ?? '-' }}
        </td>

        <!-- Type Column -->
        <td class="px-6 py-4 whitespace-nowrap">
            {{ $productable->type?->name ?? '-' }}
        </td>

        <td class="px-6 py-4 text-right whitespace-nowrap">

            {{ number_format($productable->retail_price) }}
        </td>

        <td class="px-6 py-4 text-right whitespace-nowrap">
            @php
                $total_purchase_amount = 0;
                $purchase_histories = \App\Models\DistributionTransaction::where('product_id', $productable->id)->get();

                foreach ($purchase_histories as $data) {
                    $total_purchase_amount += $data->buying_price * $data->quantity;
                }

                $sellingAmount = \App\Models\PointOfSaleProduct::where('product_id', $productable->id)->sum('price');

                $remaining_purchase_amount = $total_purchase_amount - $sellingAmount;
            @endphp
            {{ number_format($remaining_purchase_amount) ?? '-' }}
        </td>

        <td class="px-6 py-4 text-center">


            @php
                $total_quantity = \App\Models\LocationStock::where('product_id', $productable->id)
                    ->whereIn('location_id', $validateLocation)
                    ->sum('quantity');
            @endphp
            {{ $total_quantity }}
        </td>

        <td class="px-6 py-4 whitespace-nowrap">

            {{ dateFormat($productable->created_at) }}
        </td>
    </tr>
@empty

    @include('layouts.not-found', ['colSpan' => 12])
@endforelse
