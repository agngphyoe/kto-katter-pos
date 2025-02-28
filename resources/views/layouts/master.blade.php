<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', env('APP_NAME'))</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('images/mobileShop_logo.png') }}">
    <!-- SweetAlert 2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.5/dist/sweetalert2.min.css">

    <link href="{{ asset('css/fontawesome.css') }}" rel="stylesheet">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css" />
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
    <link href="https://cdn.jsdelivr.net/npm/@splidejs/splide@4.1.4/dist/css/splide.min.css" rel="stylesheet">
    @yield('css')
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/myselect.css') }}" rel="stylesheet">
    <link href="{{ asset('css/sidebar.css') }}" rel="stylesheet">
    <link href="{{ asset('css/inputNumber.css') }}" rel="stylesheet">
    <link href="{{ asset('css/dashboard.css') }}" rel="stylesheet">


    <link href="{{ asset('css/iconAction.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css">
    <link href="{{ asset('css/datatable.css') }}" rel="stylesheet">
    <link href="{{ asset('css/toastr.css') }}" rel="stylesheet">
</head>

<body class="bg-bgMain">
    <section class="product">
        @include('layouts.sidebar')
        @include('layouts.nav')
        @yield('content')
    </section>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    {{-- <script src="{{ asset('js/jquery-3.7.1.js') }}"></script> --}}
    {{-- <scriptsrc="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></scriptsrc=> --}}
    <script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
    {{--  <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js"></script>  --}}
    <script src="{{ asset('js/fontawesome.js') }}"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.5/dist/sweetalert2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>
    <script src="
    https://cdn.jsdelivr.net/npm/@splidejs/splide@4.1.4/dist/js/splide.min.js
    "></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <script src="{{ asset('js/Nav.js') }}"></script>
    <script src="{{ asset('js/handleAjaxRequest.js') }}"></script>
    <script src="{{ asset('js/ClearLocalStorage.js') }}"></script>
    <script src="{{ asset('js/SearchFilter.js') }}"></script>
    <script src="{{ asset('js/splide.js') }}"></script>
    <script src="{{ asset('js/Sidebar.js') }}"></script>
    <script src="{{ asset('js/DataTable.js') }}"></script>
    <script src="{{ asset('js/mySelect.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script src="{{ asset('js/toastr.js') }}"></script>
    <script>
        toastr.options.timeOut = 1000;

        @if(Session::has('success'))
        toastr.success('{{ Session::get('success') }}');
        @elseif(Session::has('error'))
        toastr.error('{{ Session::get('error') }}');
        @endif
    </script>

    <script>
        $('input[name="daterange"]').daterangepicker({
            // opens: 'left'
        });
    </script>
    <script src="{{ asset('js/DeleteAction.js') }}"></script>
    <script src="https://js.pusher.com/7.2/pusher.min.js"></script>
    <script src="{{ asset('js/UpdateQuantity.js') }}"></script>

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

<script>
    function toggleIcon(element) {
        if (element.classList.contains("fa-angle-down")) {
            element.classList.remove("fa-angle-down");
            element.classList.add("fa-angle-up");
        } else {
            element.classList.remove("fa-angle-up");
            element.classList.add("fa-angle-down");
        }
    }
</script>
    @yield('script')
</body>

</html>
