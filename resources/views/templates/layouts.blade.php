<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    @yield('styles')
    {{-- set icon --}}
    <link rel="shortcut icon" href="{{ asset('assets/img/logo.png') }}" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css"
        integrity="sha384-4LISF5TTJX/fLmGSxO53rV4miRxdg84mZsxmO8Rx5jGtp/LbrixFETvWa5a6sESd" crossorigin="anonymous">
    <link href="{{ asset('assets/css/loading.css') }}" rel="stylesheet">
    <style>
        .alert {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 9999;
            width: auto;
            opacity: 0;
            transition: opacity 0.3s ease-in-out;
        }

        .alert-show {
            opacity: 1;
        }
    </style>
</head>

<body>
    @yield('content')

    @include('components.loading')
    @yield('scripts')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
    <script src="{{ asset('assets/js/notification.js') }}"></script>
    <script>
        const loaderContainer = document.getElementById('loader-container');
        document.addEventListener("DOMContentLoaded", function() {
            // Hide loader after page is fully loaded
            window.addEventListener("load", function() {
                loaderContainer.style.display = 'none';
            });
        });

        // trigger loading when form is submitted
        document.querySelector('form').addEventListener('submit', function() {
            loaderContainer.style.display = 'flex';
        });
    </script>
</body>

</html>
