@extends('layouts.master-without-nav')
@section('title', 'Title')
@section('css')

@endsection
@section('content')
<section class="report__product">
    {{-- nav start  --}}
    @include('layouts.header-section', [
    'title' => 'Product Report',
    'subTitle' => '',
    ])
    {{-- nav end  --}}

    {{-- box start  --}}
    <form>

        <div class="md:mt-10  m-3 md:mx-10">


            <div class="bg-white">
                <div class="bg-primary flex items-center justify-between text-white py-3 px-5 font-jakarta">
                    <h1>Product Report</h1>
                    <div>
                        <i class="fa-solid fa-print mr-3"></i>
                        <i class="fa-solid fa-download"></i>
                    </div>

                </div>
                <div class="px-3 py-3  ">
                    <div class="border rounded-md">
                        <div class="bg-gray-50">
                            <div class="py-3 px-5">
                                <div>
                                    <div class="flex items-center justify-center flex-wrap gap-5">

                                        <div class="flex flex-col mb-5">
                                            <label for="" class="font-jakarta text-[14px] text-paraColor font-semibold mb-2">Categories</label>
                                            <select name="category" id="categorySelect" class="select2 w-[300px]">

                                                
                                            </select>
                                        </div>
                                        <div class="flex flex-col mb-5">
                                            <label for="" class="font-jakarta text-[14px] text-paraColor font-semibold mb-2">Date Range</label>
                                            <div class="outline outline-1 text-sm font-jakarta text-paraColor w-[300px]  text-[16px] outline-primary pl-8    rounded-full">
                                                <input type="text" name="daterange" id="" placeholder="From Date To Date" class="w-[230px]  outline-none py-[10px]">
                                                <i class="fa-regular fa-calendar-minus text-lg text-primary"></i>
                                            </div>

                                        </div>

                                        <button type="button" class="bg-primary text-white px-10 py-2 rounded-full font-poppins" id="getReport">
                                            Get Report
                                        </button>

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
                        <div class="overflow-x-auto">
                            <table class="w-full  text-sm text-left text-gray-500 ">
                                <thead class="text-sm text-primary bg-gray-50  font-jakarta  font-medium   ">
                                    <tr>
                                        <th scope="col" class="px-6 py-3">
                                            Name
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            Category
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            Brand
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            Latest Quantity
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="text-sm  text-paraColor font-poppins" id="reportContainer">

                                </tbody>
                            </table>
                        </div>
                        {{-- table end --}}
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
    $(function() {
        $('input[name="daterange"]').daterangepicker({
            opens: 'left'
        }, function(start, end, label) {

        });
    });

    $(document).ready(function() {

        $('#getReport').click(function() {

            var date = $('input[name="daterange"]').val();
            var category = $('#categorySelect').val();

            $.ajax({
                url: "{{ route('get-product-report') }}",
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    category,
                    date
                },
                success: function(data) {
                    // Clear existing table rows
                    $('#reportTableBody').empty();

                    // Loop through the received product data and append rows to the table
                    $.each(data, function(index, product) {
                        var row = '<tr>' +
                            '<td>' + product.name + '</td>' +
                            '<td>' + product.brand + '</td>' +
                            '<td>' + product.model + '</td>' +
                            '<td>' + product.price + '</td>' +
                            '</tr>';
                        $('#reportTableBody').append(row);
                    });
                },
                error: function(xhr, status, error) {
                    console.error(error);
                }
            });
        });
    });
</script>
@endsection