@extends('layouts.master-without-nav')
@section('title','Choose Location')
@section('css')

@endsection
@section('content')
<section class="product__stock__update1">
    {{-- nav start  --}}
    @include('layouts.header-section', [
    'title' => 'Choose Location',
    'subTitle' => '',
    ])
    {{-- nav end  --}}

    <form id="myForm" action="{{ route('damage-create-first') }}" method="GET">
        @csrf
        {{-- box start  --}}
        <div class=" font-jakarta flex items-center justify-center mt-32">
            <div>
                <div class="bg-white animate__animated animate__zoomIn mb-5  p-10 shadow-xl rounded-[20px]">
                    <div class="flex items-center justify-center gap-10">
                        <div class="flex flex-col ">

                            <label for="" class="block mb-2 font-jakarta text-left text-paraColor font-semibold text-sm">Select Location</label>
                            <select name="location_id" id="" class="select2 w-[220px]" required>
                                
                                <option value="" disabled selected>Choose Location</option>
                                @foreach ($locations as $location)                                    
                                    <option value="{{ $location['id'] }}">{{ $location['location_name'] }}</option>
                                @endforeach
                            </select>
                            @error('location_id')
                            <p class="text-red-600 text-xs mt-2">* {{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="flex flex-col md:items-center text-center md:text-left md:flex-row mt-10 md:justify-center gap-10">

                        <a href="{{ route('damage') }}">
                            <button type="button" class="outline outline-1 text-noti text-sm  outline-noti w-full md:w-44 py-2 rounded-2xl">Cancel</button>
                        </a>
                        <button type="submit" class="text-sm bg-noti outline mx-auto md:mx-0 text-white outline-1 w-full outline-noti md:w-44 py-2 rounded-2xl" id="done">Done</button>
                    </div>
                </div>
            </div>

        </div>
        {{-- box end  --}}
    </form>


</section>
@endsection
@section('script')
<script>
    localStorage.removeItem('damageSelectedProducts');
</script>
@endsection