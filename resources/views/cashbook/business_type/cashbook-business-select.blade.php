<option value="" class="px-10" selected disabled>Select Business
</option>
@forelse ($businessTypes as $businessType)
    <option value="{{ $businessType->id }}"
        {{ old('business_type_id') == $businessType->id ? 'selected' : '' }}>
        {{ $businessType->name }}
    </option>
@empty
    <option value="" disabled>No Business Type</option>
@endforelse
