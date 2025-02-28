<option value="" class="px-10" selected disabled>Select Type
</option>
@forelse ($types as $type)
    <option value="{{ $type->id }}"
        {{ old('type_id') == $type->id ? 'selected' : '' }}>
        {{ $type->name }}
    </option>
@empty
    <option value="" disabled>No Type</option>
@endforelse