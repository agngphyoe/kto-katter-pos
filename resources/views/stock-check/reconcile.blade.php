{{-- <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventory Reconciliation</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <!-- Header Section -->
        <div class="text-center mb-4">
            <h1>Inventory Reconciliation</h1>
            <p class="text-muted">Compare and update quantities between software and real-world inventory.</p>
            <div class="input-group w-50 mx-auto">
                <input type="text" class="form-control" placeholder="Search by product name, code, or category...">
                <button class="btn btn-primary">Search</button>
            </div>
        </div>

        <!-- Table Section -->
        <div class="table-responsive">
            <table class="table table-bordered align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>Product Name</th>
                        <th>Code/Barcode</th>
                        <th>Software Qty</th>
                        <th>Real Qty</th>
                        <th>Discrepancy</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Widget A</td>
                        <td>123456</td>
                        <td>50</td>
                        <td><input type="number" class="form-control" value="" placeholder="Enter real quantity"></td>
                        <td class="text-danger">-10</td>
                        <td>
                            <button class="btn btn-success btn-sm">Update</button>
                            <button class="btn btn-warning btn-sm">Flag Issue</button>
                        </td>
                    </tr>
                    <tr>
                        <td>Widget B</td>
                        <td>654321</td>
                        <td>30</td>
                        <td><input type="number" class="form-control" value="30"></td>
                        <td class="text-success">0</td>
                        <td>
                            <button class="btn btn-success btn-sm">Update</button>
                            <button class="btn btn-warning btn-sm">Flag Issue</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Footer Section -->
        <div class="d-flex justify-content-between align-items-center mt-4">
            <div>
                <p>Total Items Checked: <strong>2</strong></p>
                <p>Total Discrepancies: <strong>1</strong></p>
            </div>
            <div>
                <button class="btn btn-secondary">Export Report</button>
                <button class="btn btn-primary">Save Changes</button>
                <button class="btn btn-success">Finish Audit</button>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> --}}

@extends('layouts.master-without-nav')
@section('title', 'Reconciliation')
@section('css')
    {{-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"> --}}
@endsection

@section('content')
    <section class="Transfer__Detail">
        {{-- nav start  --}}
        @include('layouts.header-section', [
            'title' => 'Location Reconciliation',
            'subTitle' => 'Compare quantities between software and real-world inventory',
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
                    </div>
                    <br>
                </div>
            </div>
            {{-- ........  --}}
            {{-- purchase information start  --}}
            <div class="bg-white p-5 rounded-[20px] mt-5">

                <h1 class="text-noti font-jakarta font-bold text-center mt-2">Location Reconcile Process</h1>
                <div class="flex w-full items-center justify-between">
                    <div class="flex items-center gap-4">
                        <div class="flex items-center">
                            <x-product-search search="true" text="" />
                        </div>

                        <div class="category_id_select">
                            <select name="category_id" id="category_id_select" class="select2 w-[220px]">
                                <option value="" selected disabled>Choose Category</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <p class="text-red-600 text-xs mt-2">* {{ $message }}</p>
                            @enderror
                        </div>

                        <div class="brand_id_select">
                            <select name="brand_id" id="brand_id_select" class="select2 w-[220px]">
                                <option value="" selected disabled>Choose Brand</option>
                                @foreach ($brands as $brand)
                                    <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                                @endforeach
                            </select>
                            @error('brand_id')
                                <p class="text-red-600 text-xs mt-2">* {{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    {{-- <div class="flex flex-col font-medium text-gray-500 items-end">
                        <h1 class="mb-1">Total Items Checked: <span class="text-noti total-items-checked">0</span></h1>
                        <h1>Total Discrepancies: <span class="text-noti total-discrepancies">0</span></h1>
                    </div> --}}
                </div>

                <input type="hidden" id="location_id" value="{{ $location->id }}">

                <div class="data-table">

                    <div class="bg-white px-1 py-1 font-poppins rounded-[20px]  ">
                        <div>
                            <div class="relative overflow-x-auto mt-3 shadow-lg">
                                <form action="{{ route('location-reconcile-save', ['location_id' => $location->id]) }}"
                                    method="POST">
                                    @csrf

                                    <table class="w-full text-sm text-center text-gray-500 ">
                                        <thead
                                            class="text-sm text-primary bg-gray-50  font-medium font-poppins text-center">

                                            <tr class="text-left border-b">
                                                <th
                                                    class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-left">
                                                    Product Name
                                                </th>
                                                <th
                                                    class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-left">
                                                    Code
                                                </th>
                                                <th
                                                    class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-center">
                                                    Software Qty
                                                </th>
                                                <th
                                                    class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-center">
                                                    Ground Qty
                                                </th>
                                                <th
                                                    class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-center">
                                                    Discrepancy
                                                </th>
                                                <th
                                                    class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-left">
                                                    Actions
                                                </th>

                                            </tr>
                                        </thead>
                                        <tbody class="text-sm font-normal text-paraColor font-poppins" id="product-list">

                                            @include('stock-check.reconcile-product-search')
                                        </tbody>
                                    </table>
                            </div>

                        </div>

                    </div>
                </div>
            </div>
            {{-- purchase information end --}}
            <div class="flex justify-center mt-5 gap-5">
                <x-button-component class="bg-primary text-white" type="submit">
                    Check and Download
                </x-button-component>
                <a href="{{ url()->previous() }}">
                    <x-button-component class="bg-noti text-white" type="button">
                        Back
                    </x-button-component>
                </a>
            </div>
            </form>
        </div>
        {{-- main end  --}}

    </section>
@endsection

@section('script')
    <script src="{{ asset('js/SearchFilter.js') }}"></script>

    <script>
        $(document).ready(function() {
            $('#category_id_select').on('change', function() {
                var categoryId = $(this).val();

                if (categoryId) {
                    $.ajax({
                        url: "{{ route('get.brands.by.category') }}",
                        method: 'GET',
                        data: {
                            category_id: categoryId,
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            if (response.success) {
                                var brandSelect = $('#brand_id_select');
                                brandSelect.empty();
                                brandSelect.append(
                                    '<option value="" selected disabled>Choose Brand</option>'
                                );

                                $.each(response.brands, function(index, brand) {
                                    brandSelect.append(
                                        $('<option>', {
                                            value: brand.id,
                                            text: brand.name
                                        })
                                    );
                                });

                                fetchFilteredProducts();
                            }
                        },
                        error: function(xhr, status, error) {
                            console.error(error);
                        }
                    });
                } else {
                    $('#brand_id_select').html('<option value="" selected disabled>Choose Brand</option>');
                }
            });

            function fetchFilteredProducts() {
                var inputText = $('#searchInput').val().trim();
                var location_id = $('#location_id').val();
                var category_id = $('#category_id_select').val();
                var brand_id = $('#brand_id_select').val();

                $.ajax({
                    url: "{{ route('location-reconcile-search-product') }}",
                    method: 'GET',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        search: inputText,
                        location_id: location_id,
                        category_id: category_id,
                        brand_id: brand_id
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
            }

            $('#searchInput').on('input', fetchFilteredProducts);
            $('#brand_id_select').on('change', fetchFilteredProducts);
        });
    </script>

    <script>
        function checkProduct(productId) {
            var softwareQuantity = parseInt(document.getElementById('softwareQuantity').textContent.trim());
            var groundQuantity = parseInt(document.getElementById('realQty_' + productId).value.trim());

            var errorMessage = document.getElementById('error_msg_' + productId);

            if (isNaN(groundQuantity)) {
                errorMessage.classList.remove("hidden");
            } else {
                errorMessage.classList.add("hidden");

                var diff = softwareQuantity - groundQuantity;
                if (diff === 0) {

                }
            }

        }
    </script>

    <script>
        function checkProduct(productId) {
            var softwareQtyElement = document.querySelector(`#softwareQuantity_${productId}`);
            var groundQtyInput = document.querySelector(`#realQty_${productId}`);
            var discrepancyElement = document.querySelector(`#discrepancy_${productId}`);
            var errorMsgElement = document.querySelector(`#error_msg_${productId}`);

            var softwareQty = parseInt(softwareQtyElement.textContent.trim()) || 0;

            var groundQty = groundQtyInput.value.trim();

            if (groundQty === "") {
                errorMsgElement.classList.remove('hidden');
                discrepancyElement.textContent = "0";
                return;
            } else {
                errorMsgElement.classList.add('hidden');
            }

            groundQty = parseInt(groundQty) || 0;

            var discrepancy = groundQty - softwareQty;

            if (discrepancy > 0) {
                discrepancyElement.textContent = `+${discrepancy}`;
            } else if (discrepancy < 0) {
                discrepancyElement.textContent = `${discrepancy}`;
            } else {
                discrepancyElement.textContent = "0";
            }

            if (discrepancy === 0) {
                discrepancyElement.classList.remove('text-red-600');
                discrepancyElement.classList.add('text-primary');
            } else {
                discrepancyElement.classList.remove('text-primary');
                discrepancyElement.classList.add('text-red-600');
            }
        }
    </script>

@endsection
