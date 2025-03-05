@extends('layouts.master')
@section('title', 'Master List')
@section('css')
@endsection
@section('content')

    <section class="master__list ">
        <div>
             {{-- search start--}}
           {{-- search start --}}
           <x-search-com routeName="settings-create" exportListName="brands" name="Create Master List" />
           {{-- search end  --}}
             {{-- search end--}}
        </div>
        <div class="data-table md:ml-[270px] my-5 mr-[20px] 2xl:ml-[320px] ml-[20px] ">
            <div class="  bg-white px-4 py-3 rounded-[20px] my-5">
                <div class=" overflow-x-auto shadow-xl mt-3">
                    <table class="w-full text-sm text-center text-gray-500 ">
                        <thead class="text-sm   font-jakarta text-primary  bg-gray-50 ">
                            <x-table-head-component :columns="[
                        'No',
                        'Employee',
                        'Business',
                        'Category',
                        'Account'
                        ]" />
                        </thead>
                        <tbody id="searchResults" class="text-sm text-left animate__animated animate__slideInUp font-normal text-paraColor font-poppins">
                           <tr>
                                <td class="px-6 py-4">1</td>
                                <td class="px-6 py-4">Ei Khaing Soe</td>
                                <td class="px-6 py-4">Business</td>
                                <td class="px-6 py-4">Buying Goods</td>
                                <td class="px-6 py-4">Income</td>
                           </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('script')
    <script src="{{ asset('js/alertModelCreate.js') }}"></script>


@endsection
