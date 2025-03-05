<div class="mb-4">
    <label for="" class=" block mb-2 text-paraColor font-medium  text-sm">City</label>
    <div class="">
        <select name="city_id" class="outline-none text-sm pr-2 text-paraColor w-full  font-medium  px-4 myselect-5 select2">
            <option value="">| City</option>
            @forelse($cities as $city)
            <option value="{{ $city->id }}" {{ old('city_id') == $city->id ? 'selected' : '' }}>{{ $city->name }}
            </option>
            @empty
            <option value="" disabled>No City</option>
            @endforelse
        </select>
    </div>
    @error('city_id')
    <p class="text-red-600 text-xs mt-1">* {{ $message }}</p>
    @enderror
</div>