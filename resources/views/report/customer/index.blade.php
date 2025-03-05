@extends('layouts.master-without-nav')
@section('title', 'Customer Report')
@section('css')

@endsection
@section('content')
<section class="report__product">
    {{-- nav start  --}}
    @include('layouts.header-section', [
    'title' => 'Customer Report',
    'subTitle' => '',
    ])
    {{-- nav end  --}}

    {{-- box start  --}}

    <div class="m-3 md:m-5">


        <div class="bg-white">
            <div class="bg-primary flex items-center justify-between text-white py-3 px-5 font-jakarta">
                <h1>Customer Report</h1>
                <div>
                    <form action="{{ route('export-customer-report') }}" method="POST">
                        @csrf
                        <!-- <i class="fa-solid fa-print mr-3"></i> -->
                        <input type="hidden" name="division" id="divisionElement" />
                        <input type="hidden" name="township" id="townshipElement" />
                        <input type="hidden" name="date" id="dateElement" />
                        <button type="submit" class="hidden" id="exportBtn"><i class="fa-solid fa-download"></i></button>
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
                                        <label for="" class="font-jakarta text-[14px] text-paraColor font-semibold mb-2">Divisions</label>
                                        <select name="division_id" id="divisionSelect" class="select2 w-[300px]">
                                            <option value="" selected>All</option>
                                            @forelse($divisions as $division)
                                            <option value="{{ $division->id }}">{{ $division->name }}</option>
                                            @empty
                                            <option value="" selected disabled>No Data</option>
                                            @endforelse
                                        </select>
                                    </div>
                                    <div class="flex flex-col mb-5">
                                        <label for="" class="font-jakarta text-[14px] text-paraColor font-semibold mb-2">Townships</label>
                                        <select name="township_id" id="townshipSelect" class="select2 w-[300px]">
                                            <option value="" selected>All</option>
                                        </select>
                                    </div>
                                    <div class="flex flex-col mb-5">
                                        <label for="" class="font-jakarta text-[14px] text-paraColor font-semibold mb-2">Date Range</label>
                                        <div class="outline outline-1 bg-white text-sm font-jakarta text-paraColor w-[300px]  text-[16px] outline-primary pl-8    rounded-full">
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
                    <div class="overflow-x-auto h-[250px]">
                        <table class="w-full  text-sm text-left text-gray-500  ">
                            <thead class="text-sm sticky top-0 text-primary bg-gray-50   font-jakarta  font-medium   ">
                                <x-table-head-component :columns="[
                                            'Customer Name (ID)',
                                            'Phone',
                                            'Division',
                                            'Township',
                                            'Contact Name',
                                            'Contact Phone',
                                            'Type',
                                            'Created Date'
                                            ]" />
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

<script src="{{ asset('js/mySelect.js') }}"></script>

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

        $('#getReport').click(function() {
            var date = $('input[name="daterange"]').val();
            var division = $('#divisionSelect').val();
            var township = $('#townshipSelect').val();
            document.getElementById('divisionElement').value = division;
            document.getElementById('townshipElement').value = township;
            document.getElementById('dateElement').value = date;

            $.ajax({
                url: "{{ route('get-customer-report') }}",
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    division,
                    township,
                    date
                },
                success: function(response) {
                    $('#reportContainer').html(response.view);

                    if (response.customer_count > 0) {
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
</script>
@endsection
