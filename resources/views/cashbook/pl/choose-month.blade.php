{{-- <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Choose Month UI</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body class="bg-light">

<div class="container d-flex justify-content-center align-items-center vh-100">
    <div class="card shadow-lg p-4" style="width: 350px;">
        <h5 class="text-center mb-3">Select Month & Year</h5>
        <form>
            <div class="mb-3">
                <label for="month" class="form-label">Month</label>
                <select id="month" class="form-select">
                    <option value="1">January</option>
                    <option value="2">February</option>
                    <option value="3">March</option>
                    <option value="4">April</option>
                    <option value="5">May</option>
                    <option value="6">June</option>
                    <option value="7">July</option>
                    <option value="8">August</option>
                    <option value="9">September</option>
                    <option value="10">October</option>
                    <option value="11">November</option>
                    <option value="12">December</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="year" class="form-label">Year</label>
                <select id="year" class="form-select">
                    <!-- JavaScript will populate the years dynamically -->
                </select>
            </div>
            <div class="d-grid">
                <button type="button" class="btn btn-primary" onclick="submitSelection()">Apply</button>
            </div>
        </form>
    </div>
</div>

<script>
    // Auto-populate years from 2000 to the current year
    const yearSelect = document.getElementById("year");
    const currentYear = new Date().getFullYear();

    for (let year = currentYear; year >= 2000; year--) {
        let option = document.createElement("option");
        option.value = year;
        option.textContent = year;
        yearSelect.appendChild(option);
    }

    function submitSelection() {
        const month = document.getElementById("month").value;
        const year = document.getElementById("year").value;
        alert(`Selected Month: ${month}, Year: ${year}`);
    }
</script>

</body>
</html> --}}

@extends('layouts.master-without-nav')
@section('title', 'Choose Month')
@section('css')
@endsection

@section('content')
    <section class="product-model-create">

        {{-- nav start  --}}
        @include('layouts.header-section', [
            'title' => 'Profit and Loss',
            'subTitle' => 'Choose Month',
        ])
        {{-- nav end  --}}

        <form id="" action="{{ route('profit-and-loss-calculate-data') }}" method="GET">
            @csrf
            {{-- box start  --}}
            <div class=" font-jakarta flex items-center justify-center mt-32">
                <div>
                    <div class="bg-white animate__animated animate__zoomIn mb-5  p-10 shadow-xl rounded-[20px]">
                        <div class="flex items-center justify-center gap-10">
                            <div class="flex flex-col mb-5">
                                <label for="start_date"
                                    class="font-jakarta text-[14px] text-paraColor font-semibold mb-2">From</label>
                                <div
                                    class="outline outline-1 bg-white text-sm font-jakarta text-paraColor w-[200px] text-[16px] outline-primary px-2 rounded-full flex items-center gap-2">
                                    <input type="text" name="start_date" id="start_date" placeholder="Select Start Date"
                                        class="w-[230px] outline-none py-[10px]">
                                    <i class="fa-regular fa-calendar-minus text-lg text-primary"></i>
                                </div>
                            </div>
                            <div class="flex flex-col mb-5">
                                <label for="end_date"
                                    class="font-jakarta text-[14px] text-paraColor font-semibold mb-2">To</label>
                                <div
                                    class="outline outline-1 bg-white text-sm font-jakarta text-paraColor w-[200px] text-[16px] outline-primary px-2 rounded-full flex items-center gap-2">
                                    <input type="text" name="end_date" id="end_date" placeholder="Select End Date"
                                        class="w-[230px] outline-none py-[10px]">
                                    <i class="fa-regular fa-calendar-minus text-lg text-primary"></i>
                                </div>
                            </div>
                        </div>

                        <div
                            class="flex flex-col md:items-center text-center md:text-left md:flex-row mt-10 md:justify-center gap-10">
                            <a href="{{ route('pl-list') }}">
                                <button type="button"
                                    class="outline outline-1 text-noti text-sm  outline-noti w-full md:w-44 py-2 rounded-2xl">Back</button>
                            </a>
                            <button type="submit"
                                class="text-sm bg-noti outline mx-auto md:mx-0 text-white outline-1 w-full outline-noti md:w-44 py-2 rounded-2xl"
                                id="submitButton">Calculate</button>
                        </div>
                    </div>

                </div>

            </div>
            {{-- box end  --}}
        </form>
    </section>
@endsection

@section('script')
    <script>
        $(function() {
            $('#start_date').daterangepicker({
                singleDatePicker: true,
                showDropdowns: true,
                autoApply: true,
                locale: {
                    format: 'MM/DD/YYYY'
                }
            });

            $('#end_date').daterangepicker({
                singleDatePicker: true,
                showDropdowns: true,
                autoApply: true,
                locale: {
                    format: 'MM/DD/YYYY'
                }
            });
        });
    </script>
    <script>
        const yearSelect = document.getElementById("year");
        const currentYear = new Date().getFullYear();

        for (let year = currentYear; year >= 2025; year--) {
            let option = document.createElement("option");
            option.value = year;
            option.textContent = year;
            yearSelect.appendChild(option);
        }
    </script>
@endsection
