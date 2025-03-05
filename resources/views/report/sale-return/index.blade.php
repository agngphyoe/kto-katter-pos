@extends('layouts.master-without-nav')
@section('title', 'Sale Return Report')
@section('css')
    <style>
        .content {
            overflow: hidden;
            height: auto;
            max-height: 200px;
            width: 100%;
            transition: max-height 1s linear;
        }

        .content.is-collapsed {
            max-height: 0
        }
    </style>
@endsection
@section('content')
    <section class="report__product">
        {{-- nav start  --}}
        @include('layouts.header-section', [
            'title' => 'Sale Return Report',
            'subTitle' => '',
        ])
        {{-- nav end  --}}

        {{-- box start  --}}

        <div class="m-3 md:m-5">


            <div class="bg-white">
                <div class="bg-primary flex items-center justify-between text-white py-3 px-5 font-jakarta">
                    <h1>Sale Return Report</h1>
                    <div>
                        <form action="{{ route('export-sale-return-report') }}" method="POST">
                            @csrf
                            <!-- <i class="fa-solid fa-print mr-3"></i> -->
                            <input type="hidden" name="category" id="categoryElement" />
                            <input type="hidden" name="brand" id="brandElement" />
                            <input type="hidden" name="model" id="modelElement" />
                            <input type="hidden" name="date" id="dateElement" />
                            <input type="hidden" name="order_number" id="orderNumberElement" />
                            <button type="submit" class="hidden" id="exportBtn"><i
                                    class="fa-solid fa-download"></i></button>
                        </form>

                    </div>

                </div>

                <div class="px-3 py-3  ">
                    <div class="border rounded-md">
                        <div class="bg-gray-50">
                            <div class="py-3 px-5">
                                <div>
                                    <div class="flex items-center justify-center flex-wrap gap-5">

                                        <div class="flex flex-col mb-5">
                                            <label for=""
                                                class="font-jakarta text-[14px] text-paraColor font-semibold mb-2">Sale
                                                ID</label>
                                            <input type="text" name="order_number" id="orderNumberInput"
                                                style="outline-color: #90bfa0;padding-top: 3px;padding-bottom: 3px;"
                                                class="w-[300px] outline-none py-[10px] pl-8 rounded-full">
                                        </div>

                                        <div class="flex flex-col mb-5">
                                            <label for=""
                                                class="font-jakarta text-[14px] text-paraColor font-semibold mb-2">Date
                                                Range</label>
                                            <div
                                                class="outline outline-1 bg-white text-sm font-jakarta text-paraColor w-[300px]  text-[16px] outline-primary pl-8    rounded-full">
                                                <input type="text" name="daterange" id=""
                                                    placeholder="From Date To Date"
                                                    class="w-[230px]  outline-none py-[10px]">
                                                <i class="fa-regular fa-calendar-minus text-lg text-primary"></i>
                                            </div>

                                        </div>

                                        {{-- <button id="showMoreButton" class="bg-primary text-white px-2 rounded-md">
                                            <i class="fa-solid fa-angles-down"></i>
                                        </button> --}}

                                        <button type="button"
                                            class="bg-primary text-white px-10 py-2 rounded-full font-poppins"
                                            id="getReport">
                                            Get Report
                                        </button>

                                    </div>
                                    <div id="additionalFilters" class="content is-collapsed">
                                        <div class="flex items-center gap-5 px-5">
                                            {{-- <div class="flex flex-col mb-5">
                                                <label for=""
                                                    class="font-jakarta text-[14px] text-paraColor font-semibold mb-2">Categories</label>
                                                <select name="category" id="categorySelect" class="select2 w-[300px]">
                                                    <option value="" selected>All</option>
                                                    @forelse($categories as $category)
                                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                                    @empty
                                                        <option value="" selected disabled>No Data</option>
                                                    @endforelse
                                                </select>
                                            </div>
                                            <div class="flex flex-col mb-5">
                                                <label for=""
                                                    class="font-jakarta text-[14px] text-paraColor font-semibold mb-2">Brands</label>
                                                <select name="brand" id="brandSelect" class="select2 w-[300px]">
                                                    <option value="" selected>All</option>
                                                    @forelse($brands as $brand)
                                                        <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                                                    @empty
                                                        <option value="" selected disabled>No Data</option>
                                                    @endforelse
                                                </select>
                                            </div>
                                            <div class="flex flex-col mb-5">
                                                <label for=""
                                                    class="font-jakarta text-[14px] text-paraColor font-semibold mb-2">Product
                                                    Model</label>
                                                <select name="model" id="modelSelect" class="select2 w-[300px]">
                                                    <option value="" selected>All</option>
                                                    @forelse($models as $model)
                                                        <option value="{{ $model->id }}">{{ $model->name }}</option>
                                                    @empty
                                                        <option value="" selected disabled>No Data</option>
                                                    @endforelse
                                                </select>
                                            </div> --}}
                                        </div>
                                    </div>

                                </div>
                            </div>

                        </div>

                    </div>
                    <div class="mt-5 border ">
                        <div class="flex items-center justify-end gap-3">

                            <h1 class="font-jakarta font-medium px-5 py-4">

                                Date : <span id="selectedDate"></span>
                            </h1>
                        </div>

                        {{-- table start  --}}
                        <div class="overflow-x-auto h-[250px]">
                            <table class="w-full  text-sm text-left text-gray-500 ">
                                <thead class="text-sm sticky top-0 text-primary bg-gray-50  font-jakarta  font-medium   ">
                                    {{-- <x-table-head-component :columns="[
                                        'Sale Return ID',
                                        'Sale ID',
                                        'Customer Name',
                                        'Total Quantity',
                                        'Buying Amount',
                                        'Refund Amount',
                                        'Return Quantity',
                                        'Remark',
                                        'Return Date',
                                        'Return By',
                                        'Action',
                                    ]" /> --}}
                                    <tr class="text-left border-b">
                                        <th
                                            class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-left">
                                            Sale Return ID
                                        </th>
                                        <th
                                            class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-left">
                                            Sale ID
                                        </th>
                                        <th
                                            class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-left">
                                            Customer Name
                                        </th>
                                        <th
                                            class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-center">
                                            Total Quantity
                                        </th>
                                        <th
                                            class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-right">
                                            Buying Amount
                                        </th>
                                        <th
                                            class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-right">
                                            Refund Amount
                                        </th>
                                        <th
                                            class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-center">
                                            Return Quantity
                                        </th>
                                        <th
                                            class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-left">
                                            Remark
                                        </th>
                                        <th
                                            class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-left">
                                            Return Date
                                        </th>
                                        <th
                                            class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-left">
                                            Return By
                                        </th>
                                        <th
                                            class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-center">
                                            Action
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="text-[13px]  text-paraColor font-poppins" id="reportContainer">

                                </tbody>
                            </table>
                        </div>
                        {{-- table end --}}
                    </div>

                </div>


            </div>



        </div>
        {{-- box end  --}}
    </section>
@endsection
@section('script')
    <script>
        $(function() {
            $('input[name="daterange"]').daterangepicker({
                opens: 'left'
            }, function(start, end, label) {
                var formattedStartDate = start.format('MM/DD/YYYY');
                var formattedEndDate = end.format('MM/DD/YYYY');

                $('#selectedDate').text(formattedStartDate + ' - ' + formattedEndDate);
            });
        });

        $(document).ready(function() {

            $('#categorySelect').on('change', function() {
                let categoryId = $(this).val();

                $('#brandSelect').empty().append('<option value="" selected>Loading...</option>');
                $('#modelSelect').empty().append('<option value="" selected>All</option>');

                if (categoryId) {
                    $.ajax({
                        url: "{{ route('get-brands', ':categoryId') }}".replace(':categoryId',
                            categoryId),
                        type: 'GET',
                        dataType: 'json',
                        success: function(brands) {
                            $('#brandSelect').empty().append(
                                '<option value="" selected>All</option>');

                            if (brands.length) {
                                $.each(brands, function(index, brand) {
                                    $('#brandSelect').append(
                                        `<option value="${brand.id}">${brand.name}</option>`
                                    );
                                });
                            } else {
                                $('#brandSelect').append(
                                    '<option value="" disabled>No Brands Available</option>'
                                );
                            }
                        },
                        error: function() {
                            console.error('Error retrieving brands');
                            $('#brandSelect').empty().append(
                                '<option value="" disabled>Error loading brands</option>');
                        }
                    });
                } else {
                    $('#brandSelect').empty().append('<option value="" selected>All</option>');
                }
            });

            $('#brandSelect').on('change', function() {
                let brandId = $(this).val();

                $('#modelSelect').empty().append('<option value="" selected>Loading...</option>');

                if (brandId) {
                    $.ajax({
                        url: "{{ route('get-models', ':brandId') }}".replace(':brandId',
                            brandId),
                        type: 'GET',
                        dataType: 'json',
                        success: function(models) {
                            $('#modelSelect').empty().append(
                                '<option value="" selected>All</option>');

                            if (models.length) {
                                $.each(models, function(index, model) {
                                    $('#modelSelect').append(
                                        `<option value="${model.id}">${model.name}</option>`
                                    );
                                });
                            } else {
                                $('#modelSelect').append(
                                    '<option value="" disabled>No Models Available</option>'
                                );
                            }
                        },
                        error: function() {
                            console.error('Error retrieving models');
                            $('#modelSelect').empty().append(
                                '<option value="" disabled>Error loading models</option>');
                        }
                    });
                } else {
                    $('#modelSelect').empty().append('<option value="" selected>All</option>');
                }
            });

            $('#getReport').click(function() {
                var date = $('input[name="daterange"]').val();
                var category = $('#categorySelect').val();
                var brand = $('#brandSelect').val();
                var model = $('#modelSelect').val();
                var order_number = $('#orderNumberInput').val();

                setSelectedValue();

                $.ajax({
                    url: "{{ route('get-sale-return-report') }}",
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        category,
                        brand,
                        model,
                        order_number,
                        date
                    },
                    success: function(response) {
                        $('#reportContainer').html(response.view);

                        if (response.purchase_return_count > 0) {
                            $('#exportBtn').removeClass('hidden');
                        } else {
                            $('#exportBtn').addClass('hidden');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error(error);
                    }
                });
            });
        });

        function setSelectedValue() {
            document.getElementById('categoryElement').value = $('#categorySelect').val();
            document.getElementById('brandElement').value = $('#brandSelect').val();
            document.getElementById('modelElement').value = $('#modelSelect').val();
            document.getElementById('orderNumberElement').value = $('#orderNumberInput').val();
            document.getElementById('dateElement').value = $('input[name="daterange"]').val();
        }
    </script>
    <script>
        const button = document.getElementById('showMoreButton');
        const content = document.getElementById('additionalFilters');
        let hidden = true;

        button.addEventListener('click', () => {
            hidden = !hidden;

            if (hidden) {
                content.classList.add('is-collapsed');
                return setTimeout(() => {
                    content.hidden = hidden;
                }, 1000);
            }

            content.hidden = hidden;
            return setTimeout(() => {
                content.classList.remove('is-collapsed');
            }, 100);
        })
    </script>
@endsection
