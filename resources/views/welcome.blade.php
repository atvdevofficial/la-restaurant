<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>FCKAIN</title>
        <meta content="" name="descriptison">
        <meta content="" name="keywords">

    <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}" />

        <!-- Google Fonts -->
        <link href='https://fonts.googleapis.com/css?family=Roboto:300,400,500,700,300italic,400italic' rel="stylesheet" >
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.0.0/animate.min.css"/>

        <!-- Script -->
        <!-- <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet"> -->
        {{-- <link href="{{ asset('css/aos.css') }}" rel="stylesheet"> --}}

        <!-- Styles -->
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        <link href="{{ asset('css/style.css') }}" rel="stylesheet">

        <style>
            a:link {
                text-decoration: none;
            }
            /* body {
                background: url("/img/zambo.jpg") cover;
            } */
        </style>
    </head>
    <body>
        <div id="app">
            <router-view></router-view>
            <!-- <div id="preloader"></div> -->
        </div>
        <!-- Scripts -->
        <script src="{{ asset('js/app.js') }}"></script>
        {{-- <script src="{{ asset('js/aos.js') }}"></script> --}}
        {{-- <script src="{{ asset('js/jquery.sticky.js') }}"></script> --}}
        {{-- <script src="{{ asset('js/main.js') }}"></script> --}}
    </body>
</html>
