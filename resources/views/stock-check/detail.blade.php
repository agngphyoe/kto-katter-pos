@extends('layouts.master-without-nav')
@section('title', 'Stocks Check Details')
@section('css')

@endsection

@section('content')
    <section class="Transfer__Detail">
        {{-- nav start  --}}
        @include('layouts.header-section', [
            'title' => 'Stocks Check Details',
            'subTitle' => 'Products List',
        ])
        {{-- nav end  --}}


        {{-- ..........  --}}

        {{-- main start  --}}
        <div class="lg:mx-[30px] mx-[10px] my-[10px] lg:my-[20px]">
            <div class="bg-white rounded-[25px]">
                <div>
                    <br>
                    <h1 class="text-noti  font-jakarta font-semibold text-center mt-5">Location Details</h1>
                    <div class="flex items-center justify-between flex-wrap gap-3 p-5">
                        <x-information title="Name" subtitle="{{ $location->location_name }}" />
                        <x-information title="Type"
                            subtitle="{{ $location->getLocationTypeByIdAttribute()->location_type_name }}" />
                        <x-information title="Address" subtitle="{{ $location->address }}" />
                        <x-information title="Phone" subtitle="{{ $location->phone ?? '-' }}" />
                        {{-- <x-information title="Products" subtitle="{{ $location->total_products }}" /> --}}
                        <div>
                            <h1 class="text-primary font-poppins text-center text-sm mb-2 font-semibold">Products
                            </h1>
                            <h1 class="text-paraColor font-poppins text-[13px] text-center whitespace-nowrap">
                                {{ $location->total_products }}</h1>
                        </div>
                        {{-- <x-information title="Quantities" subtitle="{{ $location->total_quantities }}" /> --}}
                        <div>
                            <h1 class="text-primary font-poppins text-center text-sm mb-2 font-semibold">Quantity
                            </h1>
                            <h1 class="text-paraColor font-poppins text-[13px] text-center whitespace-nowrap">
                                {{ $location->total_products }}</h1>
                        </div>
                    </div>
                    <br>
                </div>
            </div>
            {{-- ........  --}}
            {{-- purchase information start  --}}
            <div class="bg-white p-5 rounded-[20px] mt-5">
                <h1 class="text-noti  font-jakarta font-semibold text-center mt-2">Stocks List</h1>
                <x-product-search search="true" text="" />
                <input type="hidden" id="location_id" value="{{ $location->id }}">

                <div class="data-table">

                    <div class="bg-white px-1 py-1 font-poppins rounded-[20px]  ">
                        <div>
                            <div class="relative overflow-x-auto mt-3 shadow-lg">
                                <table class="w-full text-sm text-center text-gray-500 ">
                                    <thead class="text-sm text-primary bg-gray-50  font-medium font-poppins text-center">

                                        <tr class="text-left border-b">
                                            <th
                                                class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-left">
                                                Product Name (ID)
                                            </th>
                                            <th
                                                class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-left">
                                                Category
                                            </th>
                                            <th
                                                class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-left">
                                                Brand
                                            </th>
                                            <th
                                                class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-left">
                                                Model
                                            </th>
                                            <th
                                                class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-left">
                                                Design
                                            </th>
                                            <th
                                                class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-left">
                                                Type
                                            </th>
                                            <th
                                                class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-center">
                                                Quantity
                                            </th>
                                            <th
                                                class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-right">
                                                Total Selling Price
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody class="text-sm font-normal text-paraColor font-poppins" id="product-list">
                                        @include('stock-check.product-search')
                                    </tbody>
                                </table>
                            </div>

                        </div>

                    </div>
                </div>
            </div>
            {{-- purchase information end --}}
            <div class="flex justify-center mt-5 gap-5">
                <a href="{{ route('location-reconcile', ['location_id' => $location->id]) }}">
                    <x-button-component class="bg-primary text-white" type="button">
                        Reconcile
                    </x-button-component>
                </a>
                <a href="{{ route('stock-check-list') }}">
                    <x-button-component class="bg-noti text-white" type="button">
                        Back
                    </x-button-component>
                </a>
            </div>
        </div>
        {{-- main end  --}}

    </section>
@endsection
@section('script')
    <script src="{{ asset('js/SearchFilter.js') }}"></script>
    <script>
        $('#searchInput').on('input', function() {
            var inputText = $(this).val().trim();
            var location_id = document.getElementById('location_id').value;

            $.ajax({
                url: "{{ route('stock-check-search-location-product') }}",
                method: 'GET',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    search: inputText,
                    location_id: location_id,
                },
                success: function(response) {
                    if (response.success) {
                        $('#product-list').html(response.html);

                    } else {
                        console.error(response.error);
                    }
                },
                error: function(xhr, status, error) {
                    console.error(error);
                }
            });
        });
    </script>
@endsection
