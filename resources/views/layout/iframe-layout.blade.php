<!DOCTYPE html>
<html lang="{{ App::getLocale() }}">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        @section('stylesheets')
        <link rel="stylesheet" href="{{ asset('css/themes/overlay-menu/materialize.css') }}">
        <link rel="stylesheet" href="{{ asset('css/font-awesome.min.css') }}">
        @show
        @section('javascripts')
        <script src="{{ asset('vendors/jquery-3.2.1.min.js') }}"></script>
        <script src="{{ asset('js/materialize.min.js') }}"></script>
        @show
    </head>
    <body>
        @section('body')
        @show
    </body>
</html>
