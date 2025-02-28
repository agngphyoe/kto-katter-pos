@extends('layouts.master')
@section('title', 'Add IMEI')
{{-- @section('title', 'Product Purchase') --}}
@section('mainTitle', 'Add IMEI Data')

@section('css')

@endsection
@section('content')

    <section class="product-model ">
        <div class=" ">
            <div class="">
                <div>
                    {{-- table --}}
                    <div class="dat-table md:ml-[270px] my-5 mr-[20px] 2xl:ml-[320px] ml-[20px]">

                        <div class="bg-white px-4 py-3 rounded-[20px] my-5 ">

                            <div class="flex items-center justify-between mb-6">
                                <h1 class="text-bold font-poppins text-md">Total Count : <span id="productCount"
                                        class="text-noti"></span></h1>

                                <form id="uploadForm" enctype="multipart/form-data">
                                    @csrf
                                    <div class="flex items-center gap-4">
                                        <div class="flex items-center gap-3">
                                            <div class="grid w-full max-w-xs items-center gap-2">
                                                <input
                                                    class="flex w-full px-2 py-1 rounded-2xl border border-primary border-input bg-white text-sm text-white file:border-0 file:bg-primary file:text-white file:text-sm file:font-medium"
                                                    type="file" name="excel_file" accept=".xlsx, .xls"
                                                    style="background-color: #00812C" />
                                            </div>


                                            <span id="file-chosen"
                                                class="text-sm text-gray-600 font-jakarta min-w-[150px] max-w-[200px] truncate"></span>
                                        </div>

                                        <button type="submit"
                                            class="flex items-center justify-center gap-2 text-sm bg-primary font-semibold font-jakarta text-white px-6 py-2 rounded-2xl hover:bg-primary/90 transition-colors duration-200">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                                            </svg>
                                            Upload Excel
                                        </button>
                                    </div>
                                </form>
                            </div>
                            <div>
                                <div class=" overflow-x-auto shadow-xl  mt-3">
                                    <table class="w-full text-sm text-center text-gray-500 ">

                                        <th class="mb-2">IMEI Numbers</th>

                                        <tbody id="imeiData"
                                            class="select-2 text-sm animate__animated animate__slideInUp font-normal text-paraColor font-poppins">

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            {{-- table end  --}}
                        </div>
                        <div class="w-full flex items-center gap-10 justify-center">
                            <a href="{{ route('purchase-choose-type', ['id' => $id, 'supplier_id' => $supplier_id]) }}">
                                <button type="button"
                                    class="outline outline-1 text-noti font-semibold font-jakarta text-sm outline-noti w-32 py-2 rounded-2xl">
                                    Cancel
                                </button>
                            </a>
                            <a href="{{ route('purchase-create-second', ['supplier_id' => $supplier_id]) }}" type="button"
                                class="text-center text-sm font-semibold bg-noti outline mx-auto md:mx-0 text-white outline-1 outline-noti w-32 py-2 rounded-2xl">
                                Done
                            </a>
                        </div>
                    </div>

                </div>


    </section>
@endsection
@section('script')
    <script src="{{ asset('js/IMEI.js') }}"></script>
    <script>
        const localStorageName = 'productPurchaseCart';

        const productID = @json($id);

        var product = getLocalStorageData(localStorageName, productID);
        product = product ? product[0] : [];

        $('#productCount').text(product.quantity);
    </script>

    <script>
        $(document).ready(function() {
            $('#uploadForm').submit(function(e) {
                e.preventDefault();

                var formData = new FormData(this);

                $.ajax({
                    url: '{{ route('fetch-excel-data') }}',
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        if (response.data.length == product.quantity && product.isIMEI == 1) {
                            product.imei = product.imei.concat(response.data);

                            saveProductToLocalStorage(localStorageName, product);

                            $('#imeiData').empty();

                            response.data.forEach(function(imei) {
                                $('#imeiData').append('<tr><td>' + imei + '</td></tr>');
                            });
                        } else {
                            toastr.error('Something Went Wrong!', 'Error', {
                                timeOut: 1000
                            });
                        }
                    },

                    error: function(error) {
                        console.error('Error uploading and fetching Excel data:', error);
                    }
                });
            });
        });
    </script>

    <script>
        function saveProductToLocalStorage(localStorageName, product) {

            const localStorageData = JSON.parse(localStorage.getItem(localStorageName)) || [];


            const updatedLocalStorageData = localStorageData.map(item => {
                if (item.product_id === product.product_id) {
                    return product;
                }
                return item;
            });

            localStorage.setItem(localStorageName, JSON.stringify(updatedLocalStorageData));
        }
    </script>
@endsection
