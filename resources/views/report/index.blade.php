@extends('layouts.master')
@section('title', 'Report')
@section('mainTitle', 'Reports')

@section('css')

@endsection
@section('content')
    <section class="report">

        <div class=" md:ml-[270px] font-jakarta my-5  2xl:ml-[320px]">
            <div class="flex items-center gap-10 flex-wrap mt-10 px-5  md:px-6">

                @if (auth()->user()->hasPermissions('product-report'))
                    <x-dashboard-card routeName="{{ route('product-report') }}" title="Products">
                        <i class="fa-solid fa-layer-group text-lg"></i>
                    </x-dashboard-card>
                @endif

                @if (auth()->user()->hasPermissions('purchase-report'))
                    <x-dashboard-card routeName="{{ route('purchase-report') }}" title="Purchases">
                        <i class="fa-solid fa-cart-shopping text-lg"></i>
                    </x-dashboard-card>
                @endif

                @if (auth()->user()->hasPermissions('sale-report'))
                    <x-dashboard-card routeName="{{ route('sale-report') }}" title="Sales">
                        <i class="fa-solid   fa-money-bill-1-wave text-lg"></i>
                    </x-dashboard-card>
                @endif

                @if (auth()->user()->hasPermissions('payable-report'))
                    <x-dashboard-card routeName="{{ route('purchase-payment-report') }}" title="Payables">
                        <i class="fa-solid fa-coins text-lg"></i>
                    </x-dashboard-card>
                @endif

                @if (auth()->user()->hasPermissions('purchase-return-report'))
                    <x-dashboard-card routeName="{{ route('purchase-return-report') }}" title="Purchases Return">
                        <i class="fa-solid fa-arrows-rotate  text-lg"></i>
                    </x-dashboard-card>
                @endif

                @if (auth()->user()->hasPermissions('sale-return-report'))
                    <x-dashboard-card routeName="{{ route('sale-return-report') }}" title="Sales Return">
                        <i class="fa-solid fa-arrows-rotate  text-lg"></i>
                    </x-dashboard-card>
                @endif

                @if (auth()->user()->hasPermissions('bank-report'))
                    <x-dashboard-card routeName="{{ route('bank-report') }}" title="Banks">
                        <i class="fa-solid fa-business-time  text-lg"></i>
                    </x-dashboard-card>
                @endif

                {{-- @if (auth()->user()->hasPermissions('customer-report'))
                    <x-dashboard-card routeName="{{ route('customer-report') }}" title="Customers">
                        <i class="fa-solid fa-users text-lg"></i>
                    </x-dashboard-card>
                @endif --}}

                {{-- @if (auth()->user()->hasPermissions('sale-payment-report'))
                    <x-dashboard-card routeName="{{ route('sale-payment-report') }}" title="Receivables">
                        <i class="fa-solid fa-coins text-lg"></i>
                    </x-dashboard-card>
                @endif --}}

                @if (auth()->user()->hasPermissions('cashbook-report'))
                    <x-dashboard-card routeName="{{ route('cash-book-report') }}" title="CashBook">
                        <i class="fa-solid fa-arrows-rotate  text-lg"></i>
                    </x-dashboard-card>
                @endif

            </div>

        </div>
    </section>
@endsection
@section('script')

@endsection
