@extends('layouts.master-without-nav')
@section('title', 'Payment History')

@section('content')
    @include('layouts.header-section', [
        'title' => 'Payment History',
        'subTitle' => 'The Details of Supplier Payment History',
    ])

    <div class="mt-10 mx-5 xl:mx-10">
        <div class="bg-white rounded-[20px] p-6">
            <form action="{{ route('supplier-payment-history-search') }}" method="get">
                <input type="hidden" name="supplier_id" value="{{ $supplier->id }}">
                <div class="mb-6 flex justify-between items-center">
                    {{-- <h2 class="text-primary font-jakarta text-lg font-semibold">Payment History</h2> --}}
                    <div class="flex gap-0">
                        <div class="mr-[20px]">
                            <label class="block text-sm font-jakarta text-paraColor font-semibold mb-1">From</label>
                            <div class="outline outline-1 flex items-center text-sm font-jakarta text-paraColor w-[200px] outline-primary rounded-full ">
                                <input type="date" name="start_date" class="py-2 flex-grow rounded-r-full px-3 outline-none" required>
                            </div>
                        </div>
                        <div class="mr-[20px]">
                            <label class="block text-sm font-jakarta text-paraColor font-semibold mb-1">To</label>
                            <div class="outline outline-1 flex items-center text-sm font-jakarta text-paraColor w-[200px] outline-primary rounded-full ">
                                <input type="date" name="end_date" class="py-2 flex-grow rounded-r-full px-3 outline-none" required>
                            </div>
                        </div>
                        
                        <button type="submit" class="outline outline-1 text-noti font-semibold font-jakarta text-sm outline-noti w-32 py-2 rounded-full mt-6">
                            Search
                        </button>
                    </div>
                    
                    <a href="{{ route('export-payment-detail', ['supplier' => $supplier->id]) }}"
                        class="dropdown-item animate__animated animate__zoomIn">
                        <div class="flex items-center gap-2 px-4 py-[7px] outline outline-1 outline-primary rounded-full mt-4">
                            <div>
                                <img src="{{ asset('images/export.png') }}" alt="">
                            </div>
                            {{-- <h1 class="text-primary font-poppins font-medium">Export</h1> --}}
                        </div>
                    </a>
                    {{-- <a href="{{ route('supplier-detail', ['supplier' => $supplier->id]) }}"
                        class="text-noti outline outline-1 outline-noti font-jakarta font-semibold px-10 py-2 rounded-full text-sm">
                        Back
                    </a> --}}
                </div>
            </form>
            

            <div class="overflow-x-auto max-h-60 custom-scrollbar" style='max-height: 450px;'>
                <table class="w-full text-center">
                    <thead class="text-sm sticky top-0 text-right z-10 text-primary bg-gray-50 font-jakarta">
                        <tr class="text-left border-b">
                            <th class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-left">
                                Paid Date
                            </th>
                            <th class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-right">
                                Paid Amount
                            </th>
                            <th class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-left">
                                Payment Type
                            </th>
                            <th class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-left">
                                Created By
                            </th>
                            <th class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-left">
                                Created At
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @include('supplier.payment-search')
                        
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
