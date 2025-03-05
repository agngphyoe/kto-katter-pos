@extends('layouts.master')
@section('title', 'Products List')
@section('mainTitle', 'Products List')

@section('css')

@endsection
@section('content')
    <div class=" ">

        <div class="">
            {{-- search start --}}
            <x-search-com routeName="product-create" name="Create a Product" permissionName="product-create" />
            {{-- search end  --}}

        </div>
        {{-- table start --}}
        <div class="data-table">
            <div class=" ml-[20px] bg-white px-4 py-3 rounded-[20px]  md:ml-[270px] my-5 mr-[20px] 2xl:ml-[320px]">
                <div class="flex items-center justify-between">
                    <h1 class=" text-[#999999] font-poppins text-sm">Search Result: <span
                            class="showTotal text-primary">0</span></h1>
                    <!-- Button to open the modal -->
                    {{-- @if (auth()->user()->hasPermissions('product-create'))
                        @if ($products->count() == 0)
                            <button id="openModalBtn"
                            class="text-sm bg-primary  font-semibold font-jakarta text-white  w-32  py-2 rounded-2xl"
                            onclick="toggleModal()">Import Excel</button>
                        @endif                      
                    @endif --}}

                    <h1 class="text-[#999999] font-poppins text-sm">Number of Products : <span
                            class="text-primary">{{ $total_count }}</span></h1>

                    <!-- The Modal -->
                    <div id="importModal" class="modal hidden fixed inset-0 overflow-y-auto" style="z-index: 1000;">
                        <div class="modal-content flex items-center justify-center min-h-screen">
                            <div class="border-2 border-gray-300 bg-white w-96 p-4 rounded shadow-lg relative">
                                <div class="flex justify-between items-center ">
                                    <label for="excel_file" class="text-md font-poppins font-semibold text-primary">
                                        Choose Excel File
                                    </label>
                                    <button type="button" onclick="closeModal()"
                                        class="text-red-500 bg-transparent hover:bg-red-200 hover:text-red-700 rounded-lg text-sm w-8 h-8 flex justify-center items-center dark:hover:bg-red-600 dark:hover:text-white"
                                        data-modal-hide="static-modal">
                                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                            fill="none" viewBox="0 0 14 14">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                                        </svg>
                                        <span class="sr-only">Close modal</span>
                                    </button>
                                </div>

                                <!-- Form goes here -->
                                <form action="{{ route('import.excel') }}" method="post" enctype="multipart/form-data"
                                    class="space-y-4">
                                    @csrf
                                    <div class="flex justify-start items-center mb-4 gap-4">
                                        <div class="text-sm text-paraColor">You can download sample format here</div>
                                        <a href="{{ url('/download/product_import_xlsx.xlsx') }}" class="text-primary">
                                            <i class="fa-solid fa-download"></i>
                                        </a>
                                    </div>
                                    <div class="grid w-full max-w-xs items-center gap-1.5">
                                        <input type="file" id="excel_file" name="excel_file" accept=".xlsx, .xls"
                                            class="flex h-10 w-full rounded-md border border-input bg-white px-3 py-2 text-sm text-gray-400 file:border-0 file:bg-transparent file:text-gray-600 file:text-sm file:font-medium">
                                    </div>

                                    <div class="w-full flex items-center gap-10 justify-center">
                                        <button
                                            class="text-sm bg-primary  font-semibold font-jakarta text-white  w-32  py-2 rounded-2xl"
                                            type="submit">
                                            Import
                                        </button>
                                    </div>
                                </form>

                                <!-- Missing columns message goes here -->
                                @if (session('missing_columns'))
                                    <div class="bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded mt-4"
                                        role="alert">
                                        <strong class="font-bold">Missing Columns!</strong>
                                        <p>The following columns are missing in your Excel file:</p>
                                        <ul>
                                            @foreach (session('missing_columns') as $missingColumn)
                                                <li>{{ $missingColumn }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>


                </div>
                <div>

                    <div class="relative overflow-x-auto h-[400px] shadow-lg  mt-3">
                        <table class="w-full    ">
                            <thead class="text-sm sticky top-0 z-10 font-jakarta  text-primary  bg-gray-50 ">
                                {{-- <x-table-head-component :columns="[
                                'Code',
                                'Name',
                                'Categories',
                                'Brand',
                                'Model',
                                'Type',
                                'Design',
                                'IMEI',
                                'Quantity',
                                'Selling Price',
                                'Created By',
                                'Created At',
                                'Action',
                            ]" /> --}}
                                <tr class="text-left border-b">
                                    <th
                                        class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-left">
                                        Code
                                    </th>
                                    <th
                                        class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-left">
                                        Name
                                    </th>
                                    <th
                                        class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-left">
                                        Categories
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
                                        Type
                                    </th>
                                    <th
                                        class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-left">
                                        Design
                                    </th>
                                    <th
                                        class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-center">
                                        Quantity
                                    </th>
                                    <th
                                        class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-right">
                                        Selling Price
                                    </th>
                                    <th
                                        class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-left">
                                        Created By
                                    </th>
                                    <th
                                        class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-left">
                                        Created At
                                    </th>
                                    <th
                                        class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-center">
                                        Action
                                    </th>
                                </tr>
                            </thead>
                            <tbody id="searchResults"
                                class="font-normal animate__animated animate__slideInUp font-poppins text-[13px] text-paraColor">
                                @include('product.search')
                            </tbody>
                        </table>
                    </div>
                    {{ $products->links('layouts.paginator') }}

                </div>
            </div>
        </div>
        {{-- table end  --}}
    </div>

@endsection
@section('script')

    <script>
        $(document).ready(function() {
            var searchRoute = "{{ route('product-list') }}";

            executeSearch(searchRoute)
        });

        function toggleModal() {
            var modal = document.getElementById('importModal');
            modal.classList.toggle('hidden');
        }

        function closeModal() {
            document.getElementById('importModal').classList.add('hidden');
        }
    </script>

    <script>
        function updateFileName() {
            const input = document.getElementById('excel_file');
            const fileNameDisplay = document.getElementById('file_name');
            if (input.files.length > 0) {
                fileNameDisplay.textContent = input.files[0].name;
            } else {
                fileNameDisplay.textContent = '';
            }
        }
    </script>
@endsection
