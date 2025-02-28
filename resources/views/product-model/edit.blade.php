@extends('layouts.master-without-nav')
@section('title', 'Edit Model')
@section('css')

@endsection
@section('content')
    <section class="product-model-create">

        {{-- nav start  --}}
        @include('layouts.header-section', [
            'title' => 'Edit Product-Model',
            'subTitle' => 'Fill to edit product-model',
        ])
        {{-- nav end  --}}

        {{-- box start  --}}

        <form id="modelCreateForm" action="{{ route('product-model-update', ['product_model' => $product_model->id]) }}"
            method="POST">
            @csrf
            @method('PUT')

            <div class=" font-jakarta flex items-center justify-center mt-32">
                <div>
                    <div class="bg-white mb-5  p-10 shadow-2xl rounded-[20px]">
                        <div class="flex  md:flex-row flex-col  gap-10">

                            {{-- categories --}}
                            <div class="category_id_select">
                                <label for=""
                                    class=" block mb-2 text-paraColor font-semibold text-sm">Categories</label>
                                <select name="category_id" id="category_id_select" class=" select2 w-[220px]">
                                    <option value="">Choose Categories</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}"
                                            {{ $category->id == $product_model->brand?->category?->id ? 'selected' : '' }}
                                            ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('category_id')
                                    <p class="text-red-600 text-xs mt-2">* {{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="" class=" block mb-2 text-paraColor font-semibold text-sm">Brand</label>
                                <div>
                                    <select name="brand_id" id="brand_id_select" class="outline-none select2 w-[220px]">
                                        <option value="" selected disabled>Choose Brand</option>
                                        @php
                                            $brands = \App\Models\Brand::where(
                                                'category_id',
                                                $product_model->brand?->category?->id,
                                            )->get();
                                        @endphp
                                        @foreach ($brands as $brand)
                                            <option value="{{ $brand->id }}"
                                                {{ $brand->id == $product_model->brand_id ? 'selected' : '' }}>
                                                {{ $brand->name }}
                                            </option>
                                        @endforeach
                                    </select>

                                </div>
                            </div>
                        </div>

                        <div class="flex  md:flex-row flex-col  gap-10 mt-5">
                            <div class="flex items-center gap-10">
                                <div>
                                    <label for=""
                                        class=" block mb-2 text-paraColor font-semibold text-sm">Model</label>
                                    <input type="text" placeholder="Enter Data Name"
                                        class="outline w-[220px] outline-1 outline-primary px-4 py-2 rounded-2xl text-sm custom_input"
                                        name="name" id="product_model_input" value="{{ $product_model->name }}"
                                        autocomplete="off">
                                    @error('name')
                                        <p class="text-red-600 text-xs mt-2">* {{ $message }}</p>
                                    @enderror
                                </div>

                                {{-- <div>
                                    <label for=""
                                        class=" block mb-2 text-paraColor font-semibold text-sm">Prefix</label>
                                    <input type="text" value="{{ $product_model->prefix }}"
                                        class="outline w-[220px] outline-1 outline-primary px-4 py-2 rounded-2xl text-sm custom_input"
                                        name="prefix" id="product_model_input" value="{{ $product_model->name }}"
                                        autocomplete="off">
                                    @error('prefix')
                                        <p class="text-red-600 text-xs mt-2">* {{ $message }}</p>
                                    @enderror
                                </div> --}}

                            </div>
                        </div>
                        <div
                            class="flex flex-col md:items-center text-center md:text-left md:flex-row mt-10 md:justify-center gap-10">
                            <a href="{{ route('product-model') }}">
                                <button type="button"
                                    class="outline outline-1 text-noti text-sm  outline-noti w-full md:w-44 py-2 rounded-2xl">Cancel</button>
                            </a>
                            <button type="submit"
                                class="text-sm bg-noti outline mx-auto md:mx-0 text-white outline-1 w-full outline-noti md:w-44 py-2 rounded-2xl"
                                id="submitButton">Done</button>
                        </div>

                    </div>
                </div>

            </div>
        </form>
        {{-- box end  --}}

    </section>

@endsection
@section('script')

    <script>
        document.getElementById('modelCreateForm').addEventListener('submit', function(event) {
            event.preventDefault();

            const submitButton = document.getElementById('submitButton');
            submitButton.disabled = true;
            submitButton.innerHTML = "Processing...";
            submitButton.style.opacity = '0.5';

            this.submit();
        });
    </script>

    <script>
        $('select[name="category_id"]').change(function() {
            var category_id = $(this).val();
            $.ajax({
                url: "{{ route('get-category-brands') }}",
                type: 'GET',
                dataType: 'json',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    id: category_id
                },
                success: function(response) {
                    $('#brand_id_select').html(response.html);

                    $('.select2').select2();
                },
                error: function(xhr, status, error) {
                    console.log(error);
                }
            });
        });
    </script>

@endsection
