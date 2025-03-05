<option value="" class="px-10" selected disabled>Select Model
</option>
@forelse ($product_models as $product_model)
    <option value="{{ $product_model->id }}"
        {{ old('model_id') == $product_model->id ? 'selected' : '' }}>
        {{ $product_model->name }}
    </option>
@empty
    <option value="" disabled>No Model</option>
@endforelse