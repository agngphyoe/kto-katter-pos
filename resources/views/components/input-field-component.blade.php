<label for="{{$fieldID}}" class="font-jakarta text-paraColor text-sm font-semibold mb-2">{{$label}}</label>
<input type="{{$type}}" name="{{$fieldName}}" id="{{$fieldID}}" placeholder="{{$placeText}}"
    @if($max !== null) min="0" max="{{$max}}" @endif
         @if(old($fieldName)) value="{{ old($fieldName) }}"
    @elseif($value) value="{{ $value }}"
    @endif class="custom_input outline outline-1 text-sm font-jakarta text-paraColor w-[300px] outline-primary px-4 py-2 rounded-full"
    @if($readonly) readonly @endif @if($required) required @endif>

    @error($fieldName)
    <p class="text-red-600 text-xs mt-1">* {{ $message }}</p>
    @enderror
