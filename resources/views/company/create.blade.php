@extends('layouts.master-without-nav')
@section('title', 'Company Create')
@section('css')

@endsection
@section('content')
<section class="company__create">


    {{-- nav start  --}}
    @include('layouts.header-section', [
    'title' => 'Create A New Company',
    'subTitle' => 'Fill to create a new company',
    ])
    {{-- nav end  --}}

    <form id="myForm" action="{{ route('company-store') }}" method="POST">
        @csrf
        {{-- box start  --}}
        <div class=" flex items-center font-jakarta justify-center h-screen">
            <div class="mx-10">
                <div class="bg-white mb-5  p-10 shadow-xl rounded-[20px]">
                    <div class="flex md:items-center md:flex-row flex-col  gap-10">
                        <div class="flex flex-col mb-5">
                            <x-input-field-component type="text" value="" label="Company Name" name="name" id="companyName" text="Name..." />
                        </div>

                        <div class="flex flex-col mb-5">
                            <x-input-field-component type="text" value="" label="Prefix" name="prefix" id="prefix" text="Prefix..." />
                        </div>
                    </div>
                    <div class="flex flex-col md:items-center text-center md:text-left md:flex-row mt-10 md:justify-center gap-10">
                        <x-button-component class="outline outline-1 text-noti text-sm  outline-noti" type="button">
                            Cancel
                        </x-button-component>

                        <x-button-component class="bg-noti text-white" type="submit" id="done">
                            Done
                        </x-button-component>
                    </div>
                </div>


            </div>

        </div>
    </form>
    {{-- box end  --}}

</section>

@endsection
@section('script')

@endsection
