@extends('layouts.master-without-nav')
@section('title', 'IMEI History')
@section('css')
    <style>
        .center-content {
            display: flex;
            justify-content: center;
            align-items: center;
            height: calc(100vh - 150px);
            /* Adjust height based on header or navbar size */
        }

        .search-box-wrapper {
            display: flex;
            gap: 10px;
        }

        .search-box-wrapper input {
            width: 300px;
            /* Adjust width as needed */
        }
    </style>
@endsection

@section('content')
    @include('layouts.header-section', [
        'title' => 'IMEI History',
        'subTitle' => 'Fill or Scan Products to Search',
    ])

    <div class="center-content">
        <div class="search-box-wrapper">
            <div class="flex flex-col gap-2 w-full">
                <div class="flex justify-between items-center gap-4">
                    <input type="text" id="imeiInput" name="imei"
                        class="outline outline-1 text-sm font-jakarta text-paraColor w-full text-[16px] outline-primary px-8 py-2 rounded-full"
                        placeholder="Enter or Scan IMEI">
                    <button class="bg-primary text-white rounded-full w-52 text-md font-semibold py-2" id="searchButton">
                        Search
                    </button>
                </div>
                <span id="errorMsg" class="text-sm text-red-600"></span>
            </div>
        </div>
    </div>

@endsection

@section('script')
    <script>
        $(document).ready(function() {
            $('#searchButton').click(function(event) {
                event.preventDefault(); // Prevent form submission

                const imei = $('#imeiInput').val().trim();
                const csrfToken = $('meta[name="csrf-token"]').attr('content');
                const errorMsg = $('#errorMsg');

                errorMsg.text('');

                if (imei === '') {
                    errorMsg.text('Please enter or scan an IMEI.').addClass('text-red-600').removeClass(
                        'text-green-600');
                    return;
                }

                $.ajax({
                    url: '/imei-history/check-imei-product',
                    method: 'POST',
                    data: {
                        imei: imei,
                        _token: csrfToken
                    },
                    success: function(response) {
                        console.log(response);
                        if (response.success) {
                            errorMsg.text('Product found. Redirecting...')
                                .addClass('text-primary')
                                .removeClass('text-red-600');

                            setTimeout(() => {
                                window.location.href =
                                    `/imei-history/imei-history-data/${imei}`;
                            }, 1000);
                        } else {
                            errorMsg.text('Product not found. Please try another IMEI.')
                                .addClass('text-red-600')
                                .removeClass('text-green-600');
                        }
                    },
                    error: function() {
                        errorMsg.text('An error occurred. Please try again.')
                            .addClass('text-red-600')
                            .removeClass('text-green-600');
                    }
                });
            });
        });
    </script>
@endsection
