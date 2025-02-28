@extends('layouts.master')
@section('title', 'Dashboard')
@section('mainTitle', 'Dashboard')

@section('css')
    <style>
        .from-blue-500 {
            background-color: #3b82f6;
        }

        .to-blue-700 {
            background-color: #2563eb;
        }

        .from-purple-500 {
            background-color: #8B5CF6;
        }

        .to-purple-700 {
            background-color: #844CF8;
        }

        .bg-gradient {
            background: linear-gradient(90deg, rgba(255, 255, 255, 1) 30%, rgba(207, 210, 255, 1) 100%);
        }

        .bg-gradient-2 {
            background: linear-gradient(90deg, rgba(255, 255, 255, 1) 30%, rgba(236, 207, 255, 1) 100%);
        }

        .bg-green-100 {
            background-color: #e0ffe4;
        }

        .bg-red-100 {
            background-color: #ffe0e0;
        }

        .custom-scrollbar {
            scrollbar-width: thin;
            /* Firefox */
            scrollbar-color: #888 #f1f1f1;
            /* Firefox */
        }

        /* For Chrome, Edge, and Safari */
        .custom-scrollbar::-webkit-scrollbar {
            width: 6px;
        }

        .custom-scrollbar::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb {
            background-color: #888;
            border-radius: 10px;
            border: 2px solid #f1f1f1;
        }

        .bg-indigo-400 {
            background-color: rgb(199 210 254);
        }
    </style>

@endsection
@section('content')
    <section class="dashboard">
        <div class=" md:ml-[270px] mx-3 font-jakarta my-5 md:mr-[20px] 2xl:ml-[320px]">

            {{-- Total Sales, Total Sales All Branches, and Total Income Cards --}}
            @if (auth()->user()->hasPermissions('sale-dashboard'))
                <div class="flex items-center justify-between mb-5">
                    <div class="flex items-center">
                        <div class="text-2xl font-bold text-gray-700 ml-1">Dashboard</div>
                    </div>
                    <div class="mt-2">
                        <select id="locationSelect" class="select2 w-[200px]" onchange="handleLocationChange(this.value)">
                            <option value="all" selected>All Branches</option>
                            @foreach ($shops as $shop)
                                <option value="{{ $shop->id }}">{{ $shop->location_name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-5">
                    <div class="bg-gradient shadow rounded-lg p-6 overflow-hidden">
                        <div class="flex items-center">
                            <div class="w-12 h-12 bg-blue-500 text-white rounded-full flex items-center justify-center">
                                <i class="fa-solid fa-chart-line text-xl"></i>
                            </div>
                            <div class="ml-4">
                                <div class="text-sm font-semibold text-gray-700">Today Sales</div>
                                <p class="text-lg font-bold" id="todayTotalSales">{{ number_format($todayTotalSales) }}
                                    MMK
                                </p>
                            </div>
                        </div>
                        <hr class="mt-5 border-gray-200">
                        <div class="mt-4">
                            {{-- @foreach ($todaySalesByLocation as $sale) --}}
                            <div class="flex justify-between items-center py-1">
                                <div class="text-sm font-semibold text-gray-700">Yesterday Sales</div>
                                <div class="flex items-center ml-auto space-x-2">
                                    <p class="text-sm font-bold" id="yesterdayTotalSales">
                                        {{ number_format($yesterdayTotalSales) }} MMK
                                    </p>
                                    @if ($todayTotalSales > 0 || $yesterdayTotalSales > 0)
                                        <div id="daySaleRate" @class([
                                            'text-sm',
                                            'rounded-full',
                                            'font-bold',
                                            'px-1',
                                            'py-1',
                                            'daySaleRate',
                                            'text-red-500' => $daySalePercentage < 0,
                                            'text-primary' => $daySalePercentage > 0,
                                            'bg-red-100' => $daySalePercentage < 0,
                                            'bg-green-100' => $daySalePercentage > 0,
                                        ])>
                                            @if ($daySalePercentage < 0)
                                                <i class="fa-solid fa-arrow-trend-down mr-1 text-xs"></i>
                                            @else
                                                <i class="fa-solid fa-arrow-trend-up mr-1 text-xs"></i>
                                            @endif
                                            {{ $daySalePercentage }} %
                                        </div>
                                    @endif
                                </div>
                            </div>
                            {{-- @endforeach --}}
                        </div>
                    </div>
                    <div class="bg-gradient-2 shadow rounded-lg p-6">
                        <div class="flex items-center">
                            <div class="w-12 h-12 to-purple-700 text-white rounded-full flex items-center justify-center">
                                <i class="fa-solid fa-store-alt text-xl"></i>
                            </div>
                            <div class="ml-4">
                                <h2 class="text-sm font-semibold text-gray-700">This Month Sales</h2>
                                <p class="text-lg font-bold" id="thisMonthTotalSales">
                                    {{ number_format($thisMonthTotalSales) }} MMK</p>
                            </div>
                        </div>
                        <hr class="mt-5 border-gray-200">
                        <div class="mt-4">
                            <div class="flex justify-between items-center py-1">
                                <div class="text-sm font-semibold text-gray-700">Last Month Sales</div>
                                <div class="flex items-center ml-auto space-x-2">
                                    <p class="text-sm font-bold" id="lastMonthTotalSales">
                                        {{ number_format($lastMonthTotalSales) }} MMK
                                    </p>
                                    @if ($thisMonthTotalSales > 0 || $lastMonthTotalSales > 0)
                                        <div id="monthSaleRate" @class([
                                            'text-sm',
                                            'rounded-full',
                                            'font-bold',
                                            'px-1',
                                            'py-1',
                                            'daySaleRate',
                                            'text-red-500' => $monthSalePercentage < 0,
                                            'text-primary' => $monthSalePercentage > 0,
                                            'bg-red-100' => $monthSalePercentage < 0,
                                            'bg-green-100' => $monthSalePercentage > 0,
                                        ])>
                                            @if ($monthSalePercentage < 0)
                                                <i class="fa-solid fa-arrow-trend-down mr-1 text-xs"></i>
                                            @else
                                                <i class="fa-solid fa-arrow-trend-up mr-1 text-xs"></i>
                                            @endif
                                            {{ $monthSalePercentage }} %
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            {{-- Shop Selector --}}
            @if (auth()->user()->hasPermissions('shop-dashboard'))
                <div class="mb-5">
                    {{-- Top Sales Category, Brand, Model --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-4 mb-5" id="top-sales-section">
                        <div class="bg-white shadow rounded-lg p-6">
                            <div class="flex items-center mb-5">
                                <div class="w-12 h-12 bg-red-500 text-white rounded-full flex items-center justify-center">
                                    <i class="fa-solid fa-network-wired text-xl"></i>
                                </div>
                                <h2 class="text-lg font-semibold text-gray-700 ml-3">Top Sales Category</h2>
                            </div>
                            <div class="overflow-x-auto overflow-y-auto max-h-72" style="max-height: 350px;">
                                @if ($topSaleCategory->isNotEmpty())
                                    <table class="w-full text-center">
                                        <thead
                                            class="text-sm sticky top-0 text-center z-10 text-primary bg-gray-50 font-jakarta">
                                            <tr class="text-center border-b ">
                                                <th class="px-6 whitespace-nowrap py-3 text-left">
                                                    Name</th>
                                                <th class="px-6 whitespace-nowrap py-3">
                                                    Quantity</th>
                                            </tr>
                                        </thead>
                                        <tbody class="font-normal text-paraColor font-poppins">

                                            @foreach ($topSaleCategory as $category)
                                                <tr class="bg-white border-b">
                                                    <td
                                                        class="px-6 py-4 border-b whitespace-nowrap text-sm text-left text-black">
                                                        {{ $category['name'] ?? '-' }}</td>
                                                    <td
                                                        class="px-6 py-4 border-b whitespace-nowrap text-sm text-center text-noti">
                                                        {{ number_format($category->total_quantity) }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                @else
                                    <p class="text-xl">-</p>
                                @endif
                            </div>
                        </div>
                        <div class="bg-white shadow rounded-lg p-6">
                            <div class="flex items-center mb-5">
                                <div class="w-12 h-12 bg-pink-600 text-white rounded-full flex items-center justify-center">
                                    <i class="fa-solid fa-box-open text-xl"></i>
                                </div>
                                <h2 class="text-lg font-semibold text-gray-700 ml-3">Top Sales Brand</h2>
                            </div>
                            <div class="overflow-x-auto overflow-y-auto max-h-72" style="max-height: 350px;">
                                @if ($topSaleBrand->isNotEmpty())
                                    <table class="w-full text-center">
                                        <thead
                                            class="text-sm sticky top-0 text-center z-10 text-primary bg-gray-50 font-jakarta">
                                            <tr class="text-center border-b">
                                                <th class="px-6 whitespace-nowrap py-3 text-left">
                                                    Name</th>
                                                <th class="px-6 whitespace-nowrap py-3">
                                                    Quantity</th>
                                            </tr>
                                        </thead>
                                        <tbody class="font-normal text-paraColor font-poppins">
                                            @foreach ($topSaleBrand as $brand)
                                                <tr class="bg-white border-b">
                                                    <td
                                                        class="px-6 py-4 border-b whitespace-nowrap text-sm text-left text-black">
                                                        {{ $brand['name'] ?? '-' }}</td>
                                                    <td
                                                        class="px-6 py-4 border-b whitespace-nowrap text-sm text-center text-noti">
                                                        {{ number_format($brand->total_quantity) }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                @else
                                    <p class="text-xl">-</p>
                                @endif
                            </div>
                        </div>
                        <div class="bg-white shadow rounded-lg p-6">
                            <div class="flex items-center mb-5">
                                <div
                                    class="w-12 h-12 bg-green-600 text-white rounded-full flex items-center justify-center">
                                    <i class="fa-solid fa-box text-xl"></i>
                                </div>
                                <h2 class="text-lg font-semibold text-gray-700 ml-3">Top Sales Model</h2>
                            </div>
                            <div class="overflow-x-auto overflow-y-auto max-h-72" style="max-height: 350px;">
                                @if ($topSaleModel->isNotEmpty())
                                    <table class="w-full text-center">
                                        <thead
                                            class="text-sm sticky top-0 text-center z-10 text-primary bg-gray-50 font-jakarta">
                                            <tr class="text-center border-b ">
                                                <th class="px-6 whitespace-nowrap py-3 text-left">
                                                    Name</th>
                                                <th class="px-6 whitespace-nowrap py-3">
                                                    Quantity</th>
                                            </tr>
                                        </thead>
                                        <tbody class="font-normal text-paraColor font-poppins">
                                            @foreach ($topSaleModel as $model)
                                                <tr class="bg-white border-b">
                                                    <td
                                                        class="px-6 py-4 border-b whitespace-nowrap text-sm text-left text-black">
                                                        {{ $model['name'] ?? '-' }}</td>
                                                    <td
                                                        class="px-6 py-4 border-b whitespace-nowrap text-sm text-center text-noti">
                                                        {{ number_format($model->total_quantity) }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                @else
                                    <p class="text-xl">-</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            {{-- Today Purchase and Total Purchase --}}
            @if (auth()->user()->hasPermissions('purchase-dashboard'))
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-5">
                    <div class="bg-white shadow rounded-lg overflow-hidden">
                        <div class="bg-green-600 px-6 py-4 text-white">
                            <div class="flex justify-between items-center">
                                <div>
                                    <h1 class="text-sm font-semibold mb-2">Today's Purchase</h1>
                                    <p class="text-lg font-bold" id="todayTotalPurchase">
                                        {{ number_format($todayTotalPurchase) }} MMK
                                    </p>
                                </div>
                                <div>
                                    <img src="{{ asset('images/linechart.png') }}" alt="Line Chart"
                                        class="w-full h-auto">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white shadow rounded-lg overflow-hidden">
                        <div class="bg-noti px-6 py-4 text-white">
                            <div class="flex justify-between items-center">
                                <div>
                                    <h2 class="text-sm font-semibold mb-2">Total Purchase This Month</h2>
                                    <p class="text-lg font-bold">{{ number_format($totalPurchaseThisMonth) }} MMK</p>
                                </div>
                                <div>
                                    <img src="{{ asset('images/linechart.png') }}" alt="Line Chart"
                                        class="w-full h-auto">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <div class="grid mb-3">
                {{-- Payables section --}}
                @if (auth()->user()->hasPermissions('payable-dashboard'))
                    <div class="bg-white p-6 rounded-lg shadow-md">
                        <h2 class="text-lg font-semibold text-gray-700 mb-4">Upcoming Due Payments</h2>

                        <div class="overflow-x-auto max-h-60 custom-scrollbar" style='max-height: 250px;'>
                            @if ($upcomingPurchases->isEmpty())
                                <p class="text-sm">No payments close to the due date.</p>
                            @else
                                <table class="w-full  text-sm text-center text-gray-500 ">
                                    <thead
                                        class="text-sm sticky top-0 text-center z-10 text-primary bg-gray-50 font-jakarta">
                                        <tr class="text-left border-b">
                                            <th
                                                class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-left">
                                                Supplier
                                            </th>
                                            <th
                                                class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-left">
                                                Due Date
                                            </th>
                                            <th
                                                class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-right">
                                                Total Amount
                                            </th>
                                            <th
                                                class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-right">
                                                Remaining Amount
                                            </th>
                                            <th
                                                class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-left">
                                                Status
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody
                                        class="text-sm animate__animated animate__slideInUp font-normal text-paraColor font-poppins">
                                        @foreach ($upcomingPurchases as $purchase)
                                            <tr class="bg-white text-left border-b">
                                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                    {{ $purchase->supplier->name ?? 'N/A' }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                                    {{ \Carbon\Carbon::parse($purchase->due_date)->format('d/m/Y') }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-right">
                                                    {{ number_format($purchase->total_amount) }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-right">
                                                    {{ number_format($purchase->remaining_amount) }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-left">
                                                    @if ($purchase->purchase_status === 'Complete')
                                                        <span
                                                            class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-600 text-green-800">
                                                            Complete
                                                        </span>
                                                    @else
                                                        <span
                                                            class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                                            Ongoing
                                                        </span>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            @endif
                        </div>
                    </div>
                @endif
            </div>

            {{-- <div class='grid grid-cols-1 xl:grid-cols-3 gap-0 sm:gap-7  '> --}}
            @if (auth()->user()->hasPermissions('stock-dashboard'))
                <div class="container">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- First Container -->
                        <div class="flex-1 bg-white px-4 py-4 mt-3 rounded-lg">
                            <h1 class="text-lg font-bold ml-1">Product Stock Chart</h1>
                            <div class="p-4 col-span-2 md:col-span-1 lg:col-span-1">
                                <div class="overflow-x-auto overflow-y-auto max-h-60 custom-scrollbar">
                                    <canvas class="mt-3" id="productListChart" width="400" height="400"></canvas>
                                </div>
                            </div>
                            <div class="p-4 col-span-2 md:col-span-2 lg:col-span-2 mt-32">
                                <div class="overflow-x-auto overflow-y-auto max-h-60" style="max-height: 240px;">
                                    <table class="w-full text-center">
                                        <thead
                                            class="text-sm sticky top-0 text-center z-10 text-primary bg-gray-50 font-jakarta">
                                            <tr class="text-left border-b">
                                                <th class="px-6 whitespace-nowrap py-3 text-left">
                                                    Product Name</th>
                                                <th class="px-6 whitespace-nowrap py-3 text-center">Quantity</th>
                                            </tr>
                                        </thead>
                                        <tbody id="productQuantityTable" class="font-normal text-paraColor font-poppins">
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <!-- Second Container -->
                        <div class="flex-1 bg-white px-4 py-4 mt-3 rounded-lg">
                            <h1 class="text-lg font-bold ml-1 mb-3">Product Location Data</h1>
                            <!-- Search Section (Choose Product and Search) -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 w-full">
                                <!-- Choose Product Section -->
                                <div
                                    class="flex items-center justify-start gap-6 animate__animated animate__zoomIn w-full">
                                    <select name="searchValue" id="productSelect"
                                        class="px-3 py-2 border rounded-md w-full sm:w-56">
                                        <option value="" selected disabled>Choose Product</option>
                                        @foreach ($products as $data)
                                            <option value="{{ $data->id }}">{{ $data->name }}
                                                ({{ $data->code }})
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Search Button Section -->
                                <div class="flex items-center justify-end gap-6 animate__animated animate__zoomIn w-full">
                                    <div
                                        class="flex items-center outline outline-1 outline-primary rounded-full px-4 py-2">
                                        <button type="button" id="searchButton"
                                            class="text-primary font-semibold">Search</button>
                                    </div>
                                </div>
                            </div>

                            <!-- Product Location Chart and Table -->
                            <div class="mt-4">
                                <h1 class="text-lg font-bold ml-1 mb-3">Stock Chart</h1>
                                <div class="p-4 col-span-2 md:col-span-1 lg:col-span-1">
                                    <canvas class="mt-3" id="productLocationChart" width="400"
                                        height="400"></canvas>
                                </div>
                                <div class="p-4 col-span-2 md:col-span-2 lg:col-span-2 -mt-32">
                                    <div class="flex items-center justify-center font-semibold" id="product_title">Product
                                        Name</div>
                                    <div class="overflow-x-auto overflow-y-auto max-h-60" style="max-height: 240px;">
                                        <table class="w-full text-center">
                                            <thead
                                                class="text-sm sticky top-0 text-center z-10 text-primary bg-gray-50 font-jakarta">
                                                <tr class="text-left border-b">
                                                    <th class="px-6 whitespace-nowrap py-3 text-left">Location</th>
                                                    <th class="px-6 whitespace-nowrap py-3 text-center">Quantity</th>
                                                </tr>
                                            </thead>
                                            <tbody id="productLocationTable"
                                                class="font-normal text-paraColor font-poppins"></tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            @endif


            {{-- @if (auth()->user()->hasPermissions('stock-utilization-dashboard'))
                <div class="container">
                    <div class="bg-white px-4 py-4 mt-3 rounded-[20px] overflow-x-auto">
                        <table class="table-auto border-collapse w-full text-center">
                            <thead class="text-sm sticky top-0 text-center z-10 text-black bg-indigo-400 font-jakarta">
                                <tr class="text-center border-b">
                                    <th scope="col" class="whitespace-nowrap text-left py-4 border border-gray-300">
                                        Category
                                    </th>
                                    <th scope="col" class="whitespace-nowrap text-right py-4 border border-gray-300">
                                        Start Date Stock
                                    </th>
                                    <th scope="col" class="whitespace-nowrap text-right py-4 border border-gray-300">
                                        End Date Stock
                                    </th>
                                    <th scope="col" class="whitespace-nowrap text-right py-4 border border-gray-300">
                                        Average Stock
                                    </th>
                                    <th scope="col" class="whitespace-nowrap text-right py-4 border border-gray-300">
                                        Net Sale
                                    </th>
                                    <th scope="col" class="px-6 whitespace-nowrap py-4 border border-gray-300">
                                        Inventory Sale Ratio
                                    </th>
                                    <th scope="col" class="px-6 whitespace-nowrap py-4 border border-gray-300">
                                        Inventory Turnover
                                    </th>
                                    <th scope="col" class="px-6 whitespace-nowrap py-4 border border-gray-300">
                                        Day Sale Of Inventory
                                    </th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            @endif --}}
        </div>
    </section>
@endsection
@section('script')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        $(document).ready(function() {
            $('#productSelect').select2();
            $('#locationSelect').select2();

            let productQuantityData = @json($productQuantityChartData);
            updateChart(productListChart, productQuantityData);
            updateTable(productQuantityData);

        });
    </script>

    <script>
        var ctx = document.getElementById('productListChart').getContext('2d');

        var data = {
            labels: [],
            datasets: [{
                data: [],
                backgroundColor: [],
            }]
        };

        var options = {
            cutoutPercentage: 50, // Adjust the cutout percentage for the doughnut effect
        };

        var productListChart = new Chart(ctx, {
            type: 'doughnut',
            data: data,
            options: options,
        });

        var ctx = document.getElementById('productLocationChart').getContext('2d');

        var data = {
            labels: [],
            datasets: [{
                data: [],
                backgroundColor: [],
            }]
        };

        var options = {
            cutoutPercentage: 50, // Adjust the cutout percentage for the doughnut effect
        };

        var productLocationChart = new Chart(ctx, {
            type: 'doughnut',
            data: data,
            options: options,
        });
    </script>

    <script>
        $("#searchButton").on("click", function() {
            var searchValue = document.getElementById('productSelect').value;

            $.ajax({
                method: "GET",
                url: "{{ route('productChartData') }}",
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                },
                data: {
                    search: searchValue,
                },
                success: function(response) {
                    // console.log(response);

                    if (response.data && response.data.product_name) {
                        $("#product_title").text(response.data.product_name); // Update text dynamically
                    } else {
                        console.log("Product name not found in response.");
                    }

                    updateChart(productLocationChart, response.data);
                    updateProductLocationTable(response.data);
                },
                error: function(xhr, status, error) {
                    console.log(error);
                },
            });
        });

        function updateChart(chartInstance, data) {
            chartInstance.data.labels = data.labels;
            chartInstance.data.datasets[0].data = data.data;
            chartInstance.data.datasets[0].backgroundColor = generateRandomColors(data.labels.length);
            chartInstance.update();
        }

        function updateTable(data) {
            var tableBody = $('#productQuantityTable');
            tableBody.empty();

            data.labels.forEach(function(label, index) {
                var newRow = $('<tr class="bg-white border-b">');
                var labelCell = $('<td class="px-6 py-2 whitespace-nowrap text-sm text-left font-medium">').text(
                    label);
                var dataCell = $('<td class="px-6 py-2 whitespace-nowrap text-sm text-center text-noti">').text(data
                    .data[
                        index]);

                newRow.append(labelCell, dataCell);
                tableBody.append(newRow);
            });
        }

        function updateProductLocationTable(data) {
            console.log(data);
            var tableBody = $('#productLocationTable');
            tableBody.empty();

            data.labels.forEach(function(label, index) {
                var newRow = $('<tr class="bg-white border-b">');
                var labelCell = $('<td class="px-6 py-4 border-b whitespace-nowrap text-sm text-left">').text(
                    label);
                var dataCell = $('<td class="px-6 py-4 border-b whitespace-nowrap text-sm text-center text-noti">')
                    .text(data
                        .data[index]);

                newRow.append(labelCell, dataCell);
                tableBody.append(newRow);
            });
        }

        function generateRandomColors(count) {
            var colors = [];
            for (var i = 0; i < count; i++) {
                var randomColor = '#' + Math.floor(Math.random() * 16777215).toString(16); // Generate a random hex color
                colors.push(randomColor);
            }
            return colors;
        }
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('productsBelowMinQtyChart').getContext('2d');
            const products = @json($productsBelowMinQty);

            const labels = products.map(product => product.product_name);
            const data = products.map(product => product.quantity);

            const chart = new Chart(ctx, {
                type: 'bar', // or 'line', 'pie', etc.
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Quantity',
                        data: data,
                        backgroundColor: '#00812C',
                        borderColor: '#006B24',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        });

        // Shop selector functionality
        $(document).ready(function() {
            function fetchShopData(shopId) {
                $.ajax({
                    url: '{{ route('filter.shop.data') }}',
                    method: 'GET',
                    data: {
                        shop_id: shopId
                    },
                    success: function(data) {
                        $('#top-sales-category').text(data.top_sales_category);
                        $('#top-sales-brand').text(data.top_sales_brand);
                        $('#top-sales-model').text(data.top_sales_model);
                        // Update charts and other elements if necessary
                    }
                });
            }

            // Fetch data for all shops on page load
            fetchShopData('');

            $('#shop-selector').on('change', function() {
                var shopId = $(this).val();
                fetchShopData(shopId);
            });
        });
    </script>

    <script>
        // $(document).ready(function() {
        //     $('.select2').select2();
        // });
    </script>

    <script>
        function handleLocationChange(locationId) {
            if (locationId === "all") {
                window.location.href = "{{ route('dashboard') }}";
            } else {
                fetch(`/location-data/${locationId}`, {
                        method: 'GET',
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}' // Laravel CSRF token for security
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        // console.log("Data from controller:", data);

                        function formatValue(value) {
                            return isNaN(value) ? '0' : new Intl.NumberFormat().format(value);
                        }

                        $('#todayTotalSales').text(formatValue(data['todayTotalSales']) + ' MMK');
                        $('#yesterdayTotalSales').text(formatValue(data['yesterdayTotalSales']) + ' MMK');

                        var daySalePercentage = data['daySalePercentage'];

                        if (data['todayTotalSales'] === 0 && data['yesterdayTotalSales'] === 0) {
                            $('#daySaleRate').hide();
                        } else {
                            var daySaleRate = $('#daySaleRate');
                            daySaleRate
                                .removeClass(
                                    'text-red-500 text-primary bg-red-100 bg-green-100')
                                .addClass(daySalePercentage < 0 ? 'text-red-500 bg-red-100' :
                                    'text-primary bg-green-100')
                                .html(`
                                <i class="fa-solid ${daySalePercentage < 0 ? 'fa-arrow-trend-down' : 'fa-arrow-trend-up'} mr-1 text-xs"></i>
                                ${daySalePercentage}%
                            `)
                                .show();
                        }

                        $('#thisMonthTotalSales').text(formatValue(data['thisMonthTotalSales']) + ' MMK');
                        $('#lastMonthTotalSales').text(formatValue(data['lastMonthTotalSales']) + ' MMK');

                        var monthSalePercentage = data['monthSalePercentage'];

                        if (data['thisMonthTotalSales'] === 0 && data['lastMonthTotalSales'] === 0) {
                            $('#monthSaleRate').hide();
                        } else {
                            var monthSaleRate = $('#monthSaleRate');
                            monthSaleRate
                                .removeClass(
                                    'text-red-500 text-primary bg-red-100 bg-green-100')
                                .addClass(monthSalePercentage < 0 ? 'text-red-500 bg-red-100' :
                                    'text-primary bg-green-100')
                                .html(`
                                <i class="fa-solid ${monthSalePercentage < 0 ? 'fa-arrow-trend-down' : 'fa-arrow-trend-up'} mr-1 text-xs"></i>
                                ${monthSalePercentage}%
                            `)
                                .show();
                        }

                        // Update the chart
                        const chartData = data['productQuantityChartData'];
                        const numericData = chartData.data.map(value => Number(value));
                        // console.log(chartData);
                        if (!chartData || !Array.isArray(chartData.labels) || !Array.isArray(numericData)) {
                            console.error("Invalid chartData structure:", chartData);
                            return;
                        }

                        productListChart.data.labels = chartData.labels;
                        productListChart.data.datasets[0].data = numericData;
                        productListChart.data.datasets[0].backgroundColor = generateRandomColors(chartData.labels
                            .length);
                        productListChart.update();

                        updateTable(data['productQuantityChartData']);
                    })
                    .catch(error => console.error('Error:', error));
            }
        }
    </script>


@endsection
