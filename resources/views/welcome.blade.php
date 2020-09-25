<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>
        <meta content="" name="descriptison">
        <meta content="" name="keywords">

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}" />
    </head>
    <body>
        <div id="app">
            <router-view></router-view>
            <!-- <div id="preloader"></div> -->
        </div>
        <!-- Scripts -->
        <script src="{{ asset('js/app.js') }}"></script>
    </body>
</html>
