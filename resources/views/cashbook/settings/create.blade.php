@extends('layouts.master')
@section('title', 'Master List')
@section('mainTitle', 'Settings Create')

@section('css')
@endsection
@section('content')

    <section class="master__list__create font-poppins md:ml-[270px] my-5 mr-[20px] 2xl:ml-[320px] ml-[20px]">
        <h1 class="text-center font-semibold mt-10 mb-20 text-xl" >Choose the list to add new</h1>
        <div class="flex items-center justify-center gap-20">
            <x-dashboard-card routeName="{{ route('business-type-create') }}" title="Business">
                <i class="fa-solid fa-briefcase text-lg"></i>
            </x-dashboard-card> 

            <x-dashboard-card routeName="{{ route('account-type-create') }}" title="Account Type">
                <i class="fa-solid fa-dollar-sign text-lg"></i>
            </x-dashboard-card> 

            <x-dashboard-card routeName="{{ route('account-create') }}" title="Account Name">
                <i class="fa-solid fa-dollar-sign text-lg"></i>
            </x-dashboard-card> 
        </div>
    </section>
@endsection
@section('script')
    <script src="{{ asset('js/alertModelCreate.js') }}"></script>


@endsection
