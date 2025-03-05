@forelse($products as $product)
    <tr class="bg-white border-b text-left">

        <td class="px-6 py-4">
            <h1 id="name{{ $product->id }}">
                {{ $product->name ?? '-' }}
            </h1>

        </td>
        <td class="px-6 py-4" id="action_quantity{{ $product->id }}">
            {{ number_format($product->quantity) }}
        </td>
        <td>
            <button type="button" class="bg-primary text-white rounded-full w-28 py-3 mt-3 btn"
                data-id="{{ $product->id }}" id="btn{{ $product->id }}">Select</button>
        </td>
    </tr>
@empty
    @include('layouts.not-found', ['colSpan' => 10])
@endforelse

@section('script')
@endsection
