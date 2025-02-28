@extends('layouts.master-without-nav')
@section('title', 'IMEI Stock Details')
@section('css')
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <style>
        .my-title {
            font-family: 'Plus Jakarta Sans', sans-serif;
            color: black;
            font-size: 20px;

        }

        .confirm-Button {
            color: #00812C;
            border: 1px solid #00812C;
            padding: 7px 40px;
            border-radius: 20px;
            margin-left: 10px;
            font-weight: 600;
            font-size: 20px;
        }

        .cancel-Button {
            color: #ff4c4a;
            border: 1px solid #ff4c4a;
            padding: 7px 40px;
            border-radius: 20px;

            font-weight: 600;
            font-size: 20px;
        }

        .confirm-Button:hover {
            background-color: #00812C;
            color: white;
        }

        .cancel-Button:hover {
            background-color: #ff4c4a;
            color: white;
        }

        .imei-numbers {
            white-space: normal;
            word-wrap: break-word;
            overflow-wrap: break-word;
        }
    </style>

@endsection

@section('content')
    <section class="detail">
        <div class="">
            {{-- nav start  --}}
            @include('layouts.header-section', [
                'title' => 'IMEI Stock Details View',
                'subTitle' => 'The details of stock',
            ])
            {{-- nav end  --}}
            <div class="grid grid-cols-1 xl:grid-cols-2 mt-10 mx-5 xl:mx-10 ">
                <div class="col-span-1 xl:col-span-1 mb-10 xl:mb-4  flex items-center justify-center ">
                    <div class="mt-5">
                        <div class="bg-[#FCFCFC] ">
                            @if ($product->image !== null)
                                <img src="{{ asset('products/image/' . $product->image) }}"
                                    class="mx-auto object-cover img-fluid" c alt="">
                            @else
                                <img src="{{ asset('images/no-image.png') }}" class="mx-auto object-cover img-fluid" c
                                    alt="">
                            @endif
                        </div>

                    </div>

                </div>
                <div class="col-span-1 xl:col-span-1 bg-white rounded-[20px] px-4 xl:px-14  py-8">
                    <div class="xl:flex xl:items-center xl:justify-between mb-8">
                        <h1 class="font-semibold mb-3 xl:mb-0 font-jakarta text-lg">{{ $product->name }} <span
                                class="text-noti">({{ $product->code }})</span></h1>
                    </div>

                    <table id="imeiTable" class="table table-striped mx-auto" style="width:90%">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>IMEI Numbers</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $i = 1;
                            @endphp
                            @foreach ($imei_numbers as $data)
                                <tr>
                                    <td>{{ $i++ }}.</td>
                                    <td>{{ $data->imei_number }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <div class="flex justify-center mt-5">
                        <a href="{{ route('stock-check-details', ['id' => $location->id]) }}"
                            class="bg-noti text-white font-jakarta px-7 py-3 text-md rounded-full">Back</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('script')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('js/Sweetalert.js') }}"></script>
    <script src="{{ asset('js/Nav.js') }}"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#imeiTable').DataTable();
        });
    </script>
@endsection
