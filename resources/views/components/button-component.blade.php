<button {{ $attributes->merge(['class' => 'font-semibold rounded-full  px-5 py-2 font-jakarta md:w-60']) }} type="{{$type}}" @if(isset($id)) id="{{$id}}" @endif>

    {{ $slot }}

</button>