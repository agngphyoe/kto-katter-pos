@extends('layouts.master')
@section('title','Purchase List')
@section('mainTitle', 'Purchase Lists')

@section('css')

@endsection
@section('content')
<section class="purchase-list">
    {{-- search start --}}
    <x-search-com routeName="purchase-create-first" exportListName="purchases" name="Create a Purchase" permissionName="purchase-create" />
    {{-- search end  --}}

    {{-- .......  --}}
    {{-- main start  --}}
    <div class=" md:ml-[270px] font-jakarta my-5 ml-[20px] mr-[20px] 2xl:ml-[320px]">


        {{-- table start  --}}
        <div class="bg-white p-5 rounded-[20px] mt-5">


            {{-- table start --}}
            <div class="data-table">
                <div class="  bg-white px-1 py-2 rounded-[20px]  ">

                    <div>

                        <div class="relative overflow-x-auto h-[450px] shadow-lg ">
                            <table class="w-full text-sm   ">
                                <thead class="text-sm sticky top-0 z-10  text-primary  bg-gray-50 font-jakarta ">
                                    {{-- <x-table-head-component :columns="[
                                            'Purchase ID',
                                            'Supplier Name',
                                            'Total Buying Amount',
                                            'Discount/CashDown Amount',
                                            'Type',
                                            'Products',
                                            'Purchased Date',
                                            'Created By',
                                            'Action',
                                        ]" /> --}}
                                        <tr class="text-left border-b">
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
                                                class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-left">
                                                Currency Type
                                            </th>
                                            <th
                                                class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-center">
                                                Total Quantity
                                            </th>
                                            <th
                                                class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-left">
                                                Total Buying Amount
                                            </th>
                                            <th
                                                class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-left">
                                                Discount
                                            </th>
                                            <th
                                                class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-left">
                                                Net Amount
                                            </th>
                                            <th
                                                class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-left">
                                                Cash Down
                                            </th>
                                            <th
                                                class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-left">
                                                Paid Amount
                                            </th>
                                            <th
                                                class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-left">
                                                Remaining Amount
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
                                            <th
                                                class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-center">
                                                Action
                                            </th>
                                        </tr>

                                </thead>
                                <tbody id="searchResults" class="text-sm font-normal animate__animated animate__slideInUp text-paraColor font-poppins">
                                    @include('purchase.search')
                                </tbody>
                            </table>
                        </div>
                        {{ $purchases->links('layouts.paginator') }}
                    </div>


                </div>
            </div>
            {{-- table end  --}}
        </div>
        {{-- table end --}}
    </div>

    {{-- main end --}}


</section>
@endsection
@section('script')
<script>
    clearLocalStorage();

    $(document).ready(function() {
        var searchRoute = "{{ route('purchase-list') }}";

        executeSearch(searchRoute)
    });
</script>
@endsection
