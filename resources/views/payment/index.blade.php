@extends('layouts.master')
@section('title', 'Payment List')
@section('mainTitle', 'Receive Payments Lists')

@section('content')
<section class="payment">
    <x-search-com routeName="payment-create-first" exportListName="payments" name="Create a Receive Payment" permissionName="payment-create" />

    <div class=" md:ml-[270px] font-jakarta my-5 ml-[20px] mr-[20px] 2xl:ml-[320px]">



        {{-- table start --}}
        <div class="data-table mt-5">
            <div class="  bg-white px-4 py-4 font-jakarta rounded-[20px]  ">
                <div>
                    <div class=" overflow-x-auto h-[450px] shadow-lg    ">
                        <table class="w-full text-sm  text-gray-500 ">
                            <thead class="sticky top-0 text-sm   z-10   bg-gray-100 text-primary  ">
                                <x-table-head-component :columns="[
                                    'Customer Name',
                                    'Sale Invoice',
                                    'Total Amount',
                                    'Amount',
                                    'Total Paid Amount',
                                    'Return(+) / Refund(-)',
                                    'Cash Down',
                                    'Remain Amount',
                                    'Progress',
                                    'Payment Date',
                                    'Created By',
                                    'Action']" />
                            </thead>
                            <tbody class="font-poppins text-[13px] animate__animated animate__slideInUp" id="searchResults">
                                @include('payment.search')
                            </tbody>
                        </table>
                    </div>
                    {{ $payments->links('layouts.paginator') }}

                </div>


            </div>
        </div>
        {{-- table end  --}}

    </div>
</section>
@endsection

@section('script')
<script>
    clearLocalStorage();

    $(document).ready(function() {
        var searchRoute = "{{ route('payment') }}";

        executeSearch(searchRoute)
    });
</script>
@endsection
