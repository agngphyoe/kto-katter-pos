<option value="" class="px-10" selected disabled>Select Design
</option>
@forelse ($designs as $design)
    <option value="{{ $design->id }}"
        {{ old('design_id') == $design->id ? 'selected' : '' }}>
        {{ $design->name }}
    </option>
@empty
    <option value="" disabled>No Designs</option>
@endforelse