<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
    <link rel="stylesheet" href="{{ asset('assets/css/style_new.css') }}">
    @livewireStyles
</head>

<body>
    <div class="bg-banner">
    @include('website_layout/header')
    @yield('content')

    <!--js links  starts here-->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"
        integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy"
        crossorigin="anonymous"></script>
        <!--js links  starts here-->
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
            crossorigin="anonymous"></script>
        <!--js links ends here-->

        <script>
            $(document).ready(function(){
            // Toggle between login and signup forms
            $('#signup-tab').click(function (e) {
                e.preventDefault();
                $('#login-form').removeClass('show active');
                $('#signup-form').addClass('show active');
                $('#login-tab').removeClass('active');
                $('#signup-tab').addClass('active');
            });

            $('#login-tab').click(function (e) {
                e.preventDefault();
                $('#signup-form').removeClass('show active');
                $('#login-form').addClass('show active');
                $('#signup-tab').removeClass('active');
                $('#login-tab').addClass('active');
            });

            });
        </script>
        @livewireScripts
        <!--js links ends here-->
    @include('website_layout.footer')
</body>
</html>
