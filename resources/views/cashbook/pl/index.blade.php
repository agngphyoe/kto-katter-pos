@extends('layouts.master')
@section('title', 'Profit and Loss List')
@section('mainTitle', 'Profit and Loss List')

@section('css')
    <style>
        .table-header {
            background-color: #f2f2f2;
        }

        .table-row:hover {
            background-color: #f9f9f9;
        }
    </style>
@endsection

@section('content')
    <div class="">
        <div class="">
            {{-- Search start --}}
            <x-search-pl routeName="profit-and-loss-choose-month" name="Create Profit and Loss"
                permissionName="profit-and-loss" />
            {{-- Search end --}}
        </div>

        {{-- Table start --}}
        <div class="data-table">
            <div class="ml-[20px] bg-white px-4 py-3 rounded-[20px] md:ml-[270px] my-5 mr-[20px] 2xl:ml-[320px]">
                <div class="flex items-center justify-between">
                    <h1 class="text-[#999999] font-poppins text-sm">Search Result: <span
                            class="showTotal text-primary">{{ $pls->total() }}</span></h1>
                    <h1 class="text-[#999999] font-poppins text-sm">Number of sheets: <span
                            class="text-primary">{{ $pls->count() }}</span></h1>
                </div>
                <div>
                    <div class="relative overflow-x-auto h-[400px] shadow-lg mt-3">
                        <table class="w-full">
                            <thead class="text-sm sticky top-0 z-10 font-jakarta text-primary bg-gray-50 table-header">
                                <tr class="text-left border-b">
                                    <th
                                        class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-left">
                                        Profit and Loss ID</th>
                                    <th
                                        class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-left">
                                        Month</th>
                                    <th
                                        class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-left">
                                        Created By</th>
                                    <th
                                        class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-center">
                                        Action</th>
                                </tr>
                            </thead>
                            <tbody id="searchResults"
                                class="font-normal animate__animated animate__slideInUp font-poppins text-[13px] text-paraColor">
                                @include('cashbook.pl.search')
                            </tbody>
                        </table>
                    </div>
                    {{ $pls->links('layouts.paginator') }}
                </div>
            </div>
        </div>
        {{-- Table end --}}
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function() {});

        function toggleModal() {
            var modal = document.getElementById('importModal');
            modal.classList.toggle('hidden');
        }

        function closeModal() {
            document.getElementById('importModal').classList.add('hidden');
        }
    </script>
@endsection
