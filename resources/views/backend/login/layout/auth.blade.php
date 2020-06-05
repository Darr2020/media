
<!DOCTYPE html>
<html lang="{{ App::getLocale() }}">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="_token" content="{{ csrf_token() }}">
        <title> @yield('title') </title>
        <!-- Favicons-->
        <link rel="icon" href="{{ asset("images/favicon/favicon-mm.png") }}" sizes="32x32">
        <!-- Favicons-->
        <link rel="apple-touch-icon-precomposed" href="../../images/favicon/apple-touch-icon-152x152.png" >
        <!-- For iPhone -->
        <meta name="msapplication-TileColor" content="#00bcd4">
        <meta name="msapplication-TileImage" content="images/favicon/mstile-144x144.png">
        <!-- For Windows Phone -->

        @section('stylesheets')
        <!-- CORE CSS-->
        <link rel="stylesheet" href="{{ asset('css/themes/collapsible-menu/materialize.css') }}">
        <link rel="stylesheet" href="{{ asset('css/themes/collapsible-menu/style.css') }}">
        <!-- CSS for Overlay Menu (Layout Full Screen)-->
        <link rel="stylesheet" href="{{ asset('css/layouts/style-fullscreen.css') }}">
        <!-- Custome CSS-->
        <link rel="stylesheet" href="{{ asset('css/custom/custom.css') }}">
        <link rel="stylesheet" href="{{ asset('css/layouts/page-center.css') }}">
        <!-- INCLUDED PLUGIN CSS ON THIS PAGE -->
        <link rel="stylesheet" href="{{ asset('vendors/perfect-scrollbar/perfect-scrollbar.css') }}">
        <link rel="stylesheet" href="{{ asset('vendors/sweetalert/dist/sweetalert.css') }}">
        @show
    </head>
    <body class="">
        <!-- Start Page Loading -->
        <div id="loader-wrapper">
            <div id="loader"></div>
            <div class="loader-section section-left"></div>
            <div class="loader-section section-right"></div>
        </div>
        <!-- End Page Loading -->
        <div id="login-page" class="row">
            @section('body')

            @show
        </div>


        @section('javascripts')
        <!-- jQuery Library -->
        <script src="{{ asset('vendors/jquery-3.2.1.min.js') }}"></script>
        <!--materialize js-->
        <script src="{{ asset('js/materialize.min.js') }}"></script>
        <!--scrollbar-->
        <script src="{{ asset('vendors/perfect-scrollbar/perfect-scrollbar.min.js') }}"></script>
        <!--sweetalert-->
        <script src="{{ asset('vendors/sweetalert/dist/sweetalert.min.js') }}"></script>
        <!--plugins.js - Some Specific JS codes for Plugin Settings-->
        <script src="{{ asset('js/plugins.js') }}"></script>
        <!--custom-script.js - Add your own theme custom JS-->
        <script src="{{ asset('js/custom-script.js') }}"></script>
        @show

    </body>
</html>

