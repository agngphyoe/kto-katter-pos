@extends('layouts.master-without-nav')
@section('title','Company Settings Edit')
@section('css')

@endsection

@section('content')
<section class="product-model-create">
    {{-- nav start  --}}
    @include('layouts.header-section', [
    'title' => 'Edit Company',
    'subTitle' => 'Fill to edit company settings',
    ])

    {{-- nav end  --}}

    {{-- box start  --}}
    <form id="myForm" action="{{ route('company-settings-update',['company_settings'=>$company_settings->id]) }}" method="POST">
        @csrf
        @method('PUT')

        {{-- box start  --}}
        <div class=" flex items-center font-jakarta justify-center h-screen">
            <div class="mx-10">
                <div class="bg-white mb-5  p-10 shadow-xl rounded-[20px]">
                    <div class="flex md:items-center md:flex-row flex-col  gap-10">
                        <div class="flex flex-col mb-5">
                            <x-input-field-component type="text" value="{{ $company_settings->name }}" label="Company Name" name="name" id="companyName" text="Name..." />
                        </div>

                        <div class="flex flex-col mb-5">
                            <x-input-field-component type="text" value="{{ $company_settings->url }}" label="Prefix" name="url" id="url" text="URL..." />
                        </div>
                    </div>
                    <div class="flex flex-col md:items-center text-center md:text-left md:flex-row mt-10 md:justify-center gap-10">
                        <a href="#}">
                            <button type="button" class="outline outline-1 text-noti text-sm  outline-noti w-full md:w-44 py-2 rounded-2xl">Cancel</button>
                        </a>
                        <button type="submit" class="text-sm bg-noti outline mx-auto md:mx-0 text-white outline-1 w-full outline-noti md:w-44 py-2 rounded-2xl" id="done">Done</button>
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
