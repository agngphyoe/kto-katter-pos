@extends('layouts.master-without-nav')
@section('title', 'CashBook Report')
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
            max-height: 0;
        }
    </style>

@endsection
@section('content')
    <section class="report__product">
        {{-- nav start  --}}
        @include('layouts.header-section', [
            'title' => 'CashBook Report',
            'subTitle' => '',
        ])
        {{-- nav end  --}}

        {{-- box start  --}}

        <div class="m-3 md:m-5">


            <div class="bg-white">
                <div class="bg-primary flex items-center justify-between text-white py-3 px-5 font-jakarta">
                    <h1>CashBook Report</h1>
                    <div>
                        <form action="{{ route('export-cash-book-report') }}" method="POST">
                            @csrf
                            <!-- <i class="fa-solid fa-print mr-3"></i> -->
                            <input type="hidden" name="business_type" id="businessTypeElement" />
                            <input type="hidden" name="account" id="accountElement" />
                            <input type="hidden" name="account_type" id="accountTypeElement" />
                            <input type="hidden" name="date" id="dateElement" />
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
                                        {{-- Business Type --}}
                                        <div class="flex flex-col mb-5">
                                            <label for=""
                                                class="font-jakarta text-[14px] text-paraColor font-semibold mb-2">Business Types</label>
                                            <select id="businessTypeSelect" class="select2 w-[300px]">
                                                <option value="" selected>All</option>
                                                @forelse($business_types as $business_type)
                                                    <option value="{{ $business_type->id }}">{{ $business_type->name }}</option>
                                                @empty
                                                    <option value="" selected disabled>No Data</option>
                                                @endforelse
                                            </select>
                                        </div>

                                        {{-- Account Type --}}
                                        <div class="flex flex-col mb-5">
                                            <label for=""
                                                class="font-jakarta text-[14px] text-paraColor font-semibold mb-2">Account Types</label>
                                            <select name="accountType" id="accountTypeSelect" class="select2 w-[300px]">
                                                <option value="" selected>All</option>
                                                @forelse($account_types as $account_type)
                                                    <option value="{{ $account_type->id }}">{{ $account_type->name }}</option>
                                                @empty
                                                    <option value="" selected disabled>No Data</option>
                                                @endforelse
                                            </select>
                                        </div>

                                        {{-- Account --}}
                                        <div class="flex flex-col mb-5">
                                            <label for=""
                                                class="font-jakarta text-[14px] text-paraColor font-semibold mb-2">Accounts</label>
                                            <select id="accountSelect" class="select2 w-[300px]">
                                                
                                            </select>
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
                                    {{-- <div id="additionalFilters" class="content is-collapsed">
                                        <div class="flex items-center gap-5 px-5">
                                            <div class="flex flex-col mb-5">
                                                <label for=""
                                                    class="font-jakarta text-[14px] text-paraColor font-semibold mb-2">Purchase
                                                    Status</label>
                                                <select name="purchase_status" id="purchaseStatusSelect"
                                                    class="select2 w-[300px]">
                                                    <option value="" selected>All</option>
                                                    <option value="Ongoing">Ongoing</option>
                                                    <option value="Complete">Complete</option>

                                                </select>
                                            </div>
                                        </div>
                                    </div> --}}

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
                                    <x-table-head-component :columns="[
                                        'Business Type',
                                        'Account',
                                        'Bank',
                                        'Account Type',
                                        'Amount',
                                        'Invoice Number',
                                        'Employee',
                                        'Created By',
                                        'Created At',
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
                var business_type = $('#businessTypeSelect').val();
                var account = $('#accountSelect').val();
                var account_type = $('#accountTypeSelect').val();

                setSelectedValue();

                $.ajax({
                    url: "{{ route('get-cash-book-report') }}",
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        business_type,
                        account,
                        account_type,
                        date
                    },
                    success: function(response) {
                        $('#reportContainer').html(response.view);

                        if (response.cash_book_record_count > 0) {
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
            document.getElementById('businessTypeElement').value = $('#businessTypeSelect').val();
            document.getElementById('accountElement').value = $('#accountSelect').val();
            document.getElementById('accountTypeElement').value = $('#accountTypeSelect').val();
            document.getElementById('dateElement').value = $('input[name="daterange"]').val();
        }
    </script>

    <script>
        $('select[name="accountType"]').change(function() {
            var account_type_id = $(this).val();
            console.log('one');
            $.ajax({
                    url: "{{ route('get-account-from-account-type-selected') }}",
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        account_type_id,
                    },
                    success: function(response) {
                        $('#accountSelect').html(response.html);
                    },
                    error: function(xhr, status, error) {
                        console.error(error);
                    }
        }); 
    });
    </script>
    {{-- <script>
        const button = document.getElementById('showMoreButton');
        const content = document.getElementById('additionalFilters');
        let invisibale = true;

        button.addEventListener('click', () => {
            invisibale = !invisibale;

            if (invisibale) {
                content.classList.add('is-collapsed');
                return setTimeout(() => {
                    content.invisibale = invisibale;
                }, 1000);
            } else {
                content.invisibale = invisibale;
                return setTimeout(() => {
                    content.classList.remove('is-collapsed');
                }, 100);
            }


        })
    </script> --}}
@endsection
