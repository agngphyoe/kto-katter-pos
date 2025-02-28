<option value="" class="px-10" selected disabled>Select Category
</option>
@forelse ($categories as $category)
    <option value="{{ $category->id }}"
        {{ old('category_id') == $category->id ? 'selected' : '' }}>
        {{ $category->name }}
    </option>
@empty
    <option value="" disabled>No Category</option>
@endforelse