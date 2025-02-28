<div class="mb-10 flex items-center justify-between">
    <label for="" class="font-jakarta text-paraColor ">Model</label>
    <select name="model_id"
        class="outline outline-1 font-jakarta text-paraColor  text-[16px] outline-paraColor px-14 py-2 rounded-full select2">
        <option value="" class="px-10" selected disabled>Select Model</option>
        @forelse ($product_models as $product_model)
            <option value="{{ $product_model->id }}" {{ old('model_id') == $product_model->id ? 'selected' : '' }}>{{ $product_model->name }}</option>
        @empty
            <option value="" disabled>No Model</option>
        @endforelse
    </select>
</div>