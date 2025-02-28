<label for="" class="font-jakarta text-paraColor mb-2 text-sm font-semibold">{{ $label }}</label>
<select class="select2 w-[300px]   " name="{{$name}}" id="{{$id}}" required>
    <option value="" selected disabled>| Type</option>
    @foreach($types as $key=>$type)
    <option value="{{ $key }}" @if(old($name) == $key) selected @endif> {{ $type }}</option>
    @endforeach
</select>
@error($name)
<p class="text-red-600 text-xs mt-1">* {{ $message }}</p>
@enderror
