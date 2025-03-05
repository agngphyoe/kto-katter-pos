@extends('layouts.master-without-nav')
@section('title', 'Paymentable Report')
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
            'title' => 'Paymentable Report',
            'subTitle' => '',
        ])
        {{-- nav end  --}}

        {{-- box start  --}}

        <div class="m-3 md:m-5">


            <div class="bg-white">
                <div class="bg-primary flex items-center justify-between text-white py-3 px-5 font-jakarta">
                    <h1>Paymentable Report</h1>
                    <div>
                        <form action="{{ route('export-purchase-payment-report') }}" method="POST">
                            @csrf
                            <!-- <i class="fa-solid fa-print mr-3"></i> -->
                            <input type="hidden" name="supplier" id="customerElement" />
                            <input type="hidden" name="status" id="paymentStatusElement" />
                            <input type="hidden" name="date" id="dateElement" />
                            <button type="submit" class="hidden" id="exportBtn"><i
                                    class="fa-solid fa-download"></i></button>
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
                                                        <label for=""
                                                            class="font-jakarta text-[14px] text-paraColor font-semibold mb-2">Supplier</label>
                                                        <select name="supplier" class="select2 w-[300px]"
                                                            id="supplierSelect">
                                                            <option value="" selected>All</option>
                                                            @forelse($suppliers as $supplier)
                                                                <option value="{{ $supplier->id }}" class="px-10">
                                                                    {{ $supplier->name }}</option>
                                                            @empty
                                                                <option value="" selected disabled>No Data</option>
                                                            @endforelse
                                                        </select>
                                                        <!-- Error message -->
                                                        <p class="text-red-600 text-xs mt-1" id="categoryError"></p>
                                                    </div>
                                                    <div class="flex flex-col mb-5 ">
                                                        <label for=""
                                                            class="font-jakarta text-[14px] text-paraColor font-semibold mb-2">Status</label>
                                                        <select name="status" id="paymentStatus" class="w-[300px] select2">
                                                            <option value="" selected>All</option>
                                                            <option value="Ongoing">Ongoing</option>
                                                            <option value="Complete">Complete</option>
                                                        </select>
                                                        <!-- Error message -->
                                                        <p class="text-red-600 text-xs mt-1" id="additionalCategoryError">
                                                        </p>
                                                    </div>
                                                    <div class="flex flex-col mb-5">
                                                        <label for=""
                                                            class="font-jakarta text-[14px] text-paraColor font-semibold mb-2">Date
                                                            Range</label>
                                                        <div
                                                            class="outline bg-white outline-1 text-sm font-jakarta text-paraColor w-[300px] text-[16px] outline-primary pl-8 rounded-full">
                                                            <input type="text" name="daterange" id=""
                                                                placeholder="From Date To Date"
                                                                class="w-[230px] bg-transparent outline-none py-[10px]">
                                                            <i
                                                                class="fa-regular fa-calendar-minus text-lg text-primary"></i>
                                                        </div>
                                                        <!-- Error message -->
                                                        <p class="text-red-600 text-xs mt-1" id="dateRangeError"></p>
                                                    </div>


                                                    <button type="button"
                                                        class="bg-primary whitespace-nowrap text-white px-10 py-2 rounded-full font-poppins "
                                                        id="getReport">
                                                        Get Report
                                                    </button>
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
                                    {{-- <x-table-head-component :columns="[
                                        'Purchase Payment ID',
                                        'Purchase ID',
                                        'Supplier ID',
                                        'Supplier Name',
                                        'Purchase Type',
                                        'Total Quantity',
                                        'Net Total Buying Amount',
                                        'Paid Amount',
                                        'Remaining Amount',
                                        'Payment Due Date',
                                        'Status',
                                        'Purchase Date',
                                        'Purchase By',
                                    ]" /> --}}
                                    <tr class="text-left border-b">
                                        <th
                                            class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-left">
                                            Purchase Payment ID
                                        </th>
                                        <th
                                            class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-left">
                                            Purchase ID
                                        </th>
                                        <th
                                            class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-left">
                                            Supplier ID
                                        </th>
                                        <th
                                            class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-left">
                                            Supplier Name
                                        </th>
                                        <th
                                            class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-left">
                                            Purchase Type
                                        </th>
                                        <th
                                            class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-center">
                                            Total Quantity
                                        </th>
                                        <th
                                            class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-right">
                                            Net Total Buying Amount
                                        </th>
                                        <th
                                            class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-right">
                                            Paid Amount
                                        </th>
                                        <th
                                            class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-right">
                                            Remaining Amount
                                        </th>
                                        <th
                                            class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-right">
                                            Payment Due Payment
                                        </th>
                                        <th
                                            class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-left">
                                            Status
                                        </th>
                                        <th
                                            class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-left">
                                            Purchase Date
                                        </th>
                                        <th
                                            class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-left">
                                            Purchase By
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
            $('#supplierSelect').on('change', function() {
                let supplierId = $(this).val();
                // Additional logic here if needed for supplier-specific updates
            });

            $('#getReport').click(function() {
                var date = $('input[name="daterange"]').val();
                var supplier = $('#supplierSelect').val();
                var status = $('#paymentStatus').val();

                setSelectedValue();

                $.ajax({
                    url: "{{ route('get-purchase-payment-report') }}",
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        supplier,
                        status,
                        date,
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
            document.getElementById('customerElement').value = $('#supplierSelect').val();
            document.getElementById('paymentStatusElement').value = $('#paymentStatus').val();
            document.getElementById('dateElement').value = $('input[name="daterange"]').val();
        }
    </script>


    {{-- <script>
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
</script> --}}


@endsection
