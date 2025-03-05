<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', env('APP_NAME'))</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('images/mi.png') }}">
    <!-- SweetAlert 2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.5/dist/sweetalert2.min.css">
    {{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">  --}}
    <link href="{{ asset('css/fontawesome.css') }}" rel="stylesheet">
    <link rel="stylesheet" type="text/css"
        href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

    @yield('css')
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/myselect.css') }}" rel="stylesheet">
    <link href="{{ asset('css/iconAction.css') }}" rel="stylesheet">
    {{-- <link href="{{ asset('css/imei.css') }}" rel="stylesheet"> --}}
    <link href="{{ asset('css/inputNumber.css') }}" rel="stylesheet">
    <link href="{{ asset('css/toastr.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .my-title {
            font-family: 'Plus Jakarta Sans', sans-serif;
            color: #00812C;
            margin-bottom: 0;

        }

        ..swal2-container {
            font-family: 'Plus Jakarta Sans', sans-serif;
            color: blue;
        }

        .confirm-Button {
            color: #00812C;
            border: 1px solid #00812C;
            padding: 7px 40px;
            border-radius: 20px;
            margin-left: 10px;
            font-weight: 600;
            font-size: 20px;
            font-family: 'Inter';
        }

        .confirm-Button:hover {
            background-color: #00812C;
            color: white;
            transition-duration: 0.3s;
        }

        .custom_validation_error {
            color: red;
            font-size: 12px !important;
            margin-top: 3px;
        }
    </style>


</head>

<body class="bg-bgMain">
    <section class="product " id="user">

        @yield('content')
    </section>


    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- SweetAlert 2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.5/dist/sweetalert2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

    <script>
        $(document).ready(function() {
            $('.select2').select2();
        });
    </script>
    <script src="{{ asset('js/alertModelCreate.js') }}"></script>
    <script src="{{ asset('js/DeleteAction.js') }}"></script>
    <script src="{{ asset('js/IMEI.js') }}"></script>
    <script src="{{ asset('js/fontawesome.js') }}"></script>
    <script src="{{ asset('js/header-section.js') }}"></script>
    <script src="{{ asset('js/PrintDetail.js') }}"></script>
    <script src="{{ asset('js/ClearLocalStorage.js') }}"></script>
    <script src="{{ asset('js/dateRangePicker.js') }}"></script>
    <script src="https://js.pusher.com/7.2/pusher.min.js"></script>
    <script src="{{ asset('js/UpdateQuantity.js') }}"></script>
    <script src="{{ asset('js/toastr.js') }}"></script>
    {{-- <script src="{{ asset('js/jquery-3.7.1.js') }}"></script> --}}

    <script>
        var PUSHER_APP_KEY = @json(config('broadcasting.connections.pusher.key'));
        var pusher = new Pusher(PUSHER_APP_KEY, {
            cluster: 'ap1',
            encrypted: true
        });

        var channelName = @json(config('app.env')) === 'production' ? 'quantity' : 'quantity-dev';

        var channel = pusher.subscribe(channelName); //subscribe to channels

        channel.bind('update', function(data) { //bind with event

            updateQuantityAndPrice(data)

        });
    </script>

    {{-- <script>
        document.getElementById("myForm").addEventListener('submit', function() {
            document.getElementById("done").setAttribute('disabled', 'true');
        });
    </script> --}}
    <script>
        var myForm = document.getElementById("myForm");
        var doneButton = document.getElementById("done");

        if (myForm && doneButton) {

            myForm.addEventListener('submit', function(event) {

                doneButton.setAttribute('disabled', 'true');

                setTimeout(function() {

                    doneButton.removeAttribute('disabled');

                }, 3000);

            });
        }
    </script>
    <script>
        toastr.options.timeOut = 1000;

        @if (Session::has('success'))
            toastr.success('{{ Session::get('success') }}');
        @elseif (Session::has('error'))
            toastr.error('{{ Session::get('error') }}');
        @endif
    </script>

    <script>
        // Disable the button immediately after submitting the form
        document.getElementById('submitForm').addEventListener('submit', function(event) {
            event.preventDefault();

            const submitButton = document.getElementById('submitButton');
            submitButton.disabled = true;
            submitButton.innerHTML = "Processing...";
            submitButton.style.opacity = '0.5';

            this.submit();
        });
    </script>

    <script>
        // Disable scroll wheel input change for all number inputs
        document.addEventListener('DOMContentLoaded', function() {
            const numberInputs = document.querySelectorAll('input[type="number"]');

            numberInputs.forEach(input => {
                input.addEventListener('wheel', function(event) {
                    event.preventDefault();
                });
            });
        });
    </script>

    <script>
        // Only disable submit button on form submission
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('submitForm');
            const submitButton = document.getElementById('submitButton');

            if (form && submitButton) {
                form.addEventListener('submit', function(event) {
                    submitButton.disabled = true;
                    submitButton.innerHTML = "Processing...";
                    submitButton.style.opacity = '0.5';
                });
            }
        });
    </script>
    @yield('script')
</body>



</html>
