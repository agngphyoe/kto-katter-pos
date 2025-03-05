<option value="" class="px-10" selected disabled>Select
    Brand
</option>
@forelse ($brands as $brand)
    <option value="{{ $brand->id }}"
        {{ $brand_id == $brand->id ? 'selected' : '' }}>
        {{ $brand->name }}
    </option>
@empty
    <option value="" disabled>No Brand</option>
@endforelse