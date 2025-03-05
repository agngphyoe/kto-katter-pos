<label for="" class="block mb-2 text-paraColor font-jakarta font-medium text-sm">{{ $label }} <span class="text-red-600">*</span></label>
<select name="{{$name}}" id="{{$id}}" class="select2 w-[300px]" required>
    <option value="" selected disabled>Select...</option>
    @forelse ($datas as $data)
    <option value="{{$data->id}}" @if(old($name) == $data->id) selected @endif>{{$data->name ?? $data->invoice_number}}</option>
    @empty

    @endforelse
</select>
@error($name)
<p class="text-red-600 text-xs mt-1">* {{ $message }}</p>
@enderror
