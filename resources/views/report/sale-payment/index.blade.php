@extends('layouts.master-without-nav')
@section('title', 'Receivable Report')
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
    'title' => 'Receivable Report',
    'subTitle' => '',
    ])
    {{-- nav end  --}}

    {{-- box start  --}}

    <div class="m-3 md:m-5">


        <div class="bg-white">
            <div class="bg-primary flex items-center justify-between text-white py-3 px-5 font-jakarta">
                <h1>Receivable Report</h1>
                <div>
                    <form action="{{ route('export-sale-payment-report') }}" method="POST">
                        @csrf
                        <!-- <i class="fa-solid fa-print mr-3"></i> -->
                        <input type="hidden" name="customer" id="customerElement" />
                        <input type="hidden" name="status" id="paymentStatusElement" />
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
                        <div class=" ">
                            <div>
                                <div class="flex items-center justify-center flex-wrap  gap-5">
                                    {{-- ..............  --}}
                                    <div class=" px-5">
                                        <div class="container mx-auto p-5">
                                            <div class="flex items-center gap-5">
                                                <!-- Initial select boxes -->
                                                <div class="flex flex-col mb-5">
                                                    <label for="" class="font-jakarta text-[14px] text-paraColor font-semibold mb-2">Customers</label>
                                                    <select name="customer" class="select2 w-[300px]" id="customerSelect">
                                                        <option value="" selected>All</option>
                                                        @forelse($customers as $customer)
                                                        <option value="{{ $customer->id }}" class="px-10">{{ $customer->name }}</option>
                                                        @empty
                                                        <option value="" selected disabled>No Data</option>
                                                        @endforelse
                                                    </select>
                                                    <!-- Error message -->
                                                    <p class="text-red-600 text-xs mt-1" id="categoryError"></p>
                                                </div>
                                                <div class="flex flex-col mb-5 ">
                                                    <label for="" class="font-jakarta text-[14px] text-paraColor font-semibold mb-2">Status</label>
                                                    <select name="status" id="paymentStatus" class="w-[300px] select2">
                                                        <option value="" selected>All</option>
                                                        <option value="Ongoing">Balance</option>
                                                        <option value="Complete">Paid</option>
                                                    </select>
                                                    <!-- Error message -->
                                                    <p class="text-red-600 text-xs mt-1" id="additionalCategoryError">
                                                    </p>
                                                </div>
                                                <div class="flex flex-col mb-5">
                                                    <label for="" class="font-jakarta text-[14px] text-paraColor font-semibold mb-2">Date
                                                        Range</label>
                                                    <div class="outline bg-white outline-1 text-sm font-jakarta text-paraColor w-[300px] text-[16px] outline-primary pl-8 rounded-full">
                                                        <input type="text" name="daterange" id="" placeholder="From Date To Date" class="w-[230px] bg-transparent outline-none py-[10px]">
                                                        <i class="fa-regular fa-calendar-minus text-lg text-primary"></i>
                                                    </div>
                                                    <!-- Error message -->
                                                    <p class="text-red-600 text-xs mt-1" id="dateRangeError"></p>
                                                </div>


                                                <!-- "Show More" button to gradually reveal additional filters -->
                                                <button id="showMoreButton" class="bg-primary text-white px-2 rounded-md">
                                                    <i class="fa-solid fa-angles-down"></i>
                                                </button>

                                                <button type="button" class="bg-primary whitespace-nowrap text-white px-10 py-2 rounded-full font-poppins " id="getReport">
                                                    Get Report
                                                </button>
                                            </div>

                                            <!-- Additional select boxes (hidden by default) -->
                                            <div id="additionalFilters" class="content is-collapsed">
                                                <div class="flex items-center  gap-5">
                                                    <div class="flex flex-col mb-5">
                                                        <label for="" class="font-jakarta text-[14px] text-paraColor font-semibold mb-2">Divisions</label>
                                                        <select name="division_id" id="divisionSelect" class="select2 w-[300px]">
                                                            <option value="" selected>All</option>
                                                            @forelse($divisions as $division)
                                                            <option value="{{$division->id}}">{{ $division->name }}</option>
                                                            @empty
                                                            <option value="" selected disabled>No Data</option>
                                                            @endforelse
                                                        </select>
                                                    </div>
                                                    <div class="flex flex-col mb-5 mr-5">
                                                        <label for="" class="font-jakarta text-[14px] text-paraColor font-semibold mb-2">Townships</label>
                                                        <select name="township" id="townshipSelect" class="select2 w-[300px]">
                                                            <option value="" selected>All</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>


                                        </div>
                                    </div>
                                    {{-- ..............  --}}


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
                                <x-table-head-component :columns="
                                ['Invoice Number',
                                'Customer Name',
                                'Customer Phone',
                                'Status',
                                'Amount',
                                'Total Paid Amount',
                                'Payment Date',
                                'Next Payment Date',
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
            var customer = $('#customerSelect').val();
            var status = $('#paymentStatus').val();
            var division = $('#divisionSelect').val();
            var township = $('#townshipSelect').val();

            setSelectedValue();

            $.ajax({
                url: "{{ route('get-sale-payment-report') }}",
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    customer,
                    status,
                    division,
                    township,
                    date
                },
                success: function(response) {
                    $('#reportContainer').html(response.view);

                    if (response.sale_payment_count > 0) {
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
        document.getElementById('customerElement').value = $('#customerSelect').val();
        document.getElementById('paymentStatusElement').value = $('#paymentStatus').val();
        document.getElementById('divisionElement').value = $('#divisionSelect').val();
        document.getElementById('townshipElement').value = $('#townshipSelect').val();
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
