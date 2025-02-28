    @extends('layouts.master-without-nav')
    @section('title', 'Create Product Prefix')
    @section('css')


    @endsection
    @section('content')
    <section class="product-prefix-create">



        {{-- nav start  --}}
        @include('layouts.header-section', [
        'title' => 'Create A New Product Prefix',
        'subTitle' => 'Fill to create a new product prefix',
        ])
        {{-- nav end  --}}

        {{-- box start  --}}
        <form id="myForm" action="{{ route('product-prefix-store') }}" method="POST">
            @csrf
            <div class=" font-jakarta flex items-center justify-center mt-32
            ">
                <div>
                    <div class="bg-white mb-5  p-10 shadow-2xl rounded-[20px]">
                        <div class="flex items-start flex-wrap gap-10">
                                {{-- prefix --}}

                                    <div class="">
                                        <label for="" class=" block mb-2 text-paraColor font-semibold text-sm">Prefix</label>
                                        <input type="text" minlength="1"  placeholder="Enter Data Name" oninput="convertToUppercase(this)" class="outline w-[220px] outline-1 outline-primary px-4 py-2 rounded-2xl text-sm custom_input" name="prefix" id="textInput" value="{{ old('name') }}" autocomplete="off">
                                        @error('name')
                                        <p class="text-red-600 text-xs mt-2">* {{ $message }}</p>
                                        @enderror
                                    </div>


                                {{-- length --}}
                                <div>
                                    <label for="" class=" block mb-2 text-paraColor font-semibold text-sm">Length</label>

                                    {{-- <select name="brand_id" id="brand_id_select" class="select2 w-[220px]">
                                      <option value="" selected disabled>Choose Length</option>
                                      <option value="1">1</option>
                                      <option value="2">2</option>
                                      <option value="3">3</option>
                                      <option value="custom">Custom</option>
                                    </select> --}}
                                  
                                    <div>
                                      <input type="number" name="prefix_length" id="brand_id_select" list="prefix" minlength="1" maxlength="5"  class="outline w-[220px] outline-1 outline-primary px-4 py-2 rounded-2xl text-sm custom_input" placeholder="please input number">
                                    </div>
                                    <datalist id="prefix">
                                        @for($i=1;$i<=9;$i++) 
                                            <option value="{{ $i }}">{{ $i }}</option>
                                        @endfor
                                    </datalist>
                                    @error('brand_id')
                                    <p class="text-red-600 text-xs mt-2">* {{ $message }}</p>
                                    @enderror
                                </div>
                        </div>



                        <div class="flex flex-col md:items-center text-center md:text-left md:flex-row mt-10 md:justify-center gap-10">
                            <a href="{{ route('product-model') }}">
                                <button type="button" class="outline outline-1 text-noti text-sm  outline-noti w-full md:w-44 py-2 rounded-2xl">Cancel</button>
                            </a>
                            <button type="submit" class="text-sm bg-noti outline mx-auto md:mx-0 text-white outline-1 w-full outline-noti md:w-44 py-2 rounded-2xl" id="done">Done</button>
                        </div>

                    </div>


                </div>

            </div>
        </form>
        {{-- box end  --}}

    </section>

    @endsection
    @section('script')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('js/alertModelCreate.js') }}"></script>
    {{-- <script src="{{ asset('js/jquery.js') }}"></script> --}}

    <script>
        // import $ from 'jquery';
        import 'select2';

        $(document).ready(function() {
            $('#mySelect').select2();
        });

    </script>
    <script>
        let inputField = document.getElementById("textInput");

        inputField.addEventListener("input", function(event) {
        event.preventDefault();
        this.value = this.value.toUpperCase();
        });
    </script>

    @endsection
