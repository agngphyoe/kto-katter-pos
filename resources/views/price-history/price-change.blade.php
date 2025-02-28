@extends('layouts.master-without-nav')
@section('title', 'Change Price')
@section('css')


@endsection
@section('content')
<section class="Price__Change">
    {{-- nav start  --}}
    @include('layouts.header-section', [
    'title' => 'Create A Price Change',
    'subTitle' => 'Fill to create a price change',
    ])
    {{-- nav end  --}}

    {{-- box start  --}}
    <form id="myForm" action="{{ route('product-price-change-store') }}" method="POST">
        @csrf
        <div class=" font-jakarta flex items-center justify-center mt-32">
            <div>
                <div class="bg-white mb-5  p-10 shadow-2xl rounded-[20px]">
                    <div class="flex md:flex-row flex-col  gap-10">
                        {{-- product --}}
                        <div>
                            <label for="" class=" block mb-2 text-paraColor font-semibold text-sm">Product</label>
                            <select class="select2 w-[220px]" name="product_id">
                                <option value="" selected disabled>Choose a Product</option>
                                @forelse($products as $product)
                                <option value="{{ $product->id }}">{{ $product->code }}</option>
                                @empty
                                <option value="" disabled>No Prodcut</option>
                                @endforelse
                            </select>


                        </div>

                        {{-- Price change --}}
                        <div class="flex items-center gap-10">
                            <div>
                                <label for="" class=" block mb-2 text-paraColor font-semibold text-sm">Change
                                    Price</label>
                                <input type="number" placeholder="Change price" class="outline w-[220px] outline-1 outline-primary px-4 py-2 rounded-2xl text-sm custom_input" name="new_price" id="product_model_input" value="{{ old('name') }}" autocomplete="off">
                                @error('name')
                                <p class="text-red-600 text-xs mt-2">* {{ $message }}</p>
                                @enderror
                            </div>

                        </div>
                    </div>



                    <div class="flex flex-col md:items-center text-center md:text-left md:flex-row mt-10 md:justify-center gap-10">
                        <a href="#">
                            <button type="button" class="outline outline-1 text-noti text-sm  outline-noti w-full md:w-44 py-2 rounded-2xl">Cancel</button>
                        </a>
                        <button type="submit" class="text-sm bg-noti outline mx-auto md:mx-0 text-white outline-1 w-full outline-noti md:w-44 py-2 rounded-2xl" id="done">Update</button>
                    </div>

                </div>


            </div>

        </div>
    </form>
    {{-- box end  --}}

</section>

@endsection
