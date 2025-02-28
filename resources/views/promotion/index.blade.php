@extends('layouts.master')
@section('title', 'Promotions List')
@section('mainTitle', 'Promotions List')

@section('css')
    <style>
        #check_status {
            display: none;
        }

        /* Style for the custom toggle switch */
        .toggle-switch {
            position: relative;
            display: inline-block;
            width: 37px;
            height: 24px;
        }

        .toggle-switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #ccc;
            -webkit-transition: .4s;
            transition: .4s;
        }

        .slider:before {
            position: absolute;
            content: "";
            height: 16px;
            width: 13px;
            left: 4px;
            bottom: 4px;
            background-color: white;
            -webkit-transition: .4s;
            transition: .4s;
        }

        input:checked+.slider {
            background-color: #00812C;
        }

        input:focus+.slider {
            box-shadow: 0 0 1px #00812C;
        }

        input:checked+.slider:before {
            -webkit-transform: translateX(15px);
            -ms-transform: translateX(15px);
            transform: translateX(15px);
        }

        /* Optional: Add some additional styling */
        .slider.round {
            border-radius: 10px;
        }

        .slider.round:before {
            border-radius: 50%;
        }
    </style>
@endsection

@section('content')
    <section class="promotion">
        {{-- search start --}}
        <x-search-com routeName="promotion-create-first" name="Create a Promotion" permissionName="promotion-create" />

        {{-- search end  --}}

        <div class=" md:ml-[270px] font-jakarta my-5 mr-[20px] 2xl:ml-[320px]">
            {{-- table start --}}
            <div class="data-table mt-5">
                <div class="  bg-white px-4 py-4 font-jakarta rounded-[20px]  ">
                    <div>
                        <div class="   overflow-x-auto  h-[450px] shadow-lg ">
                            <table class="w-full text-sm   text-gray-500 ">
                                <thead class=" sticky top-0  z-10  text-sm  text-primary  bg-gray-50 ">
                                    {{-- <x-table-head-component :columns="[
                                            'Title',
                                            'Promo Type',
                                            'Variant',
                                            'Locations',
                                            'Created By',
                                            'Created At',
                                            'Status',
                                            'Actions',
                                        ]" /> --}}
                                    <tr class="text-left border-b">
                                        <th
                                            class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-left">
                                            Title
                                        </th>
                                        <th
                                            class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-left">
                                            Promo Type
                                        </th>
                                        <th
                                            class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-left">
                                            Variant
                                        </th>
                                        <th
                                            class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-center">
                                            Locations
                                        </th>
                                        <th
                                            class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-left">
                                            Created By
                                        </th>
                                        <th
                                            class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-left">
                                            Created At
                                        </th>
                                        <th
                                            class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-center">
                                            Status
                                        </th>
                                        <th
                                            class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-center">
                                            Actions
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="font-poppins animate__animated animate__slideInUp text-[13px]"
                                    id="searchResults">
                                    @include('promotion.search')
                                </tbody>
                            </table>
                        </div>
                        {{ $promotions->links('layouts.paginator') }}

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
            var searchRoute = "{{ route('promotion') }}";

            executeSearch(searchRoute)
        });
    </script>

    <script>
        function updateValue(checkbox) {
            var promotionId = checkbox.dataset.promotionId;

            var $checkbox = $(checkbox);
            var $label = $(".toggle-switch");

            var status = $checkbox.prop("checked") ? "active" : "inactive";
            $label.attr("data-value", status);

            var url = "{{ route('promotion-change-status', ['promotion' => ':promotionId']) }}";
            url = url.replace(':promotionId', promotionId);

            $.ajax({
                url: url,
                type: 'PUT',
                dataType: 'json',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    status: status
                },
                success: function(response) {
                    toastr.success(response.message);
                },
                error: function(xhr, status, error) {
                    console.log('Response: ', xhr.responseText); // Full response text
                    toastr.error('An error occurred');
                }
            });
        }
    </script>
@endsection
