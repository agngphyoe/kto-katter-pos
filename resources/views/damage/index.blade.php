@extends('layouts.master')
@section('title', 'Damage List')
@section('mainTitle', 'Damage Lists')

@section('css')

@endsection
@section('content')
    <section class="damage">
        <x-search-com routeName="damage-choose-location" exportName="damages" name="Create a Damage"
            permissionName="product-damage-create" />

        <div class=" md:ml-[270px] font-jakarta my-5 mr-[20px] 2xl:ml-[320px]">

            {{-- table start --}}
            <div class="data-table mt-5">
                <div class="bg-white px-4 py-4 font-poppins rounded-[20px]">
                    <div>
                        <div class="overflow-x-auto  shadow-lg">
                            <table class="w-full text-sm  text-gray-500 ">
                                <thead class="  bg-gray-50 sticky top-0 z-10 mt-4  font-jakarta text-primary text-right">

                                    {{-- <x-table-head-component :columns="[
                                    'Remark',
                                    'Total Damaged Quantity',
                                    'Damaged Date',
                                    'Damaged By',
                                    'Action']" /> --}}
                                    <tr class="text-left border-b">
                                        <th
                                            class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-left">
                                            Remark
                                        </th>
                                        <th
                                            class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-center">
                                            Total Damaged Quantity
                                        </th>
                                        <th
                                            class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-left">
                                            Damaged Date
                                        </th>
                                        <th
                                            class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-left">
                                            Damaged By
                                        </th>
                                        <th
                                            class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-center">
                                            Action
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="font-poppins text-center text-[13px]" id="searchResults">
                                    @include('damage.search')
                                </tbody>
                            </table>
                        </div>
                        {{ $damages->links('layouts.paginator') }}

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

            var searchRoute = "{{ route('damage') }}";

            executeSearch(searchRoute)
        });
    </script>
@endsection
