<!DOCTYPE html>
<html lang="{{ App::getLocale() }}">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="_token" content="{{ csrf_token() }}">
        <title> @yield('title') </title>
        <!-- Favicons-->
        <link rel="icon" href="{{ asset('images/favicon/favicon-mm.png') }}" sizes="32x26">
        <!-- Favicons-->
        <link rel="apple-touch-icon-precomposed" href="{{ asset('images/favicon/favicon-mm.png') }}" >
        <!-- For iPhone -->
        <meta name="msapplication-TileColor" content="#00bcd4">
        <!-- For Windows Phone -->
        @section('stylesheets')
        <!-- CORE CSS-->
        <link rel="stylesheet" href="{{ asset('css/themes/overlay-menu/materialize.css') }}">
        <link rel="stylesheet" href="{{ asset('css/themes/overlay-menu/style.css') }}">
        <!-- CSS for Overlay Menu (Layout Full Screen)-->
        <link rel="stylesheet" href="{{ asset('css/layouts/style-fullscreen.css') }}">
        <!-- Custome CSS-->
        <link rel="stylesheet" href="{{ asset('css/custom/custom.css') }}">
        <!-- INCLUDED PLUGIN CSS ON THIS PAGE -->
        <link rel="stylesheet" href="{{ asset('vendors/prism/prism.css') }}">
        <link rel="stylesheet" href="{{ asset('vendors/perfect-scrollbar/perfect-scrollbar.css') }}">
        <link rel="stylesheet" href="{{ asset('vendors/flag-icon/css/flag-icon.min.css') }}">
        <link rel="stylesheet" href="{{ asset('vendors/sweetalert/dist/sweetalert.css') }}">
        <link rel="stylesheet" href="{{ asset('css/font-awesome.min.css') }}">
        @show
    </head>
    <body class="layout-light">

        <!-- Start Page Loading -->
        <div id="loader-wrapper">
            <div id="loader"></div>
            <div class="loader-section section-left"></div>
            <div class="loader-section section-right"></div>
        </div>
        <!-- End Page Loading -->

        <!-- START MAIN -->
        <div id="main">
            <!-- START WRAPPER -->
            <div class="wrapper">
                <!-- START CONTENT -->
                <section id="content">
                    <!--start container-->
                    <div class="container">
                        <div class="section">
                            <div class="col s12" style="text-align: center;">
                                <div class="" >
                                    <div class="card-image">
                                        <a href="{{ route('pagina_principal')}}"> 
                                        <img class="" width="400px" height="" src="{{ asset("images/media/logo_mediametrica-01.png") }}">
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="col s12" style="text-align: center;">
                                <div class="patreon-img-ad3">
                                    <a href="{{ url('categoria_detalle/1') }}"> 
                                        <img class="zoom" width="80px" height="80px" src="{{ asset("images/media/ranking.png") }}">
                                    </a>
                                </div>
                                <div class="patreon-img-ad3">
                                    <a href="{{ route('noticias_main') }}">
                                        <img class="zoom" width="80px" height="80px" src="{{ asset("images/media/noticias.png") }}">    
                                    </a>
                                </div>
                                <div class="patreon-img-ad3">
                                    <img class="zoom" width="80px" height="80px" src="{{ asset("images/media/productos.png") }}">
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--end container-->
                </section>
                <!-- END CONTENT -->
            </div>
        
            @section('body')
            @show
            
        @section('javascripts')
        <!-- jQuery Library -->
        <script src="{{ asset('vendors/jquery-3.2.1.min.js') }}"></script>
        <!--materialize js-->
        <script src="{{ asset('js/materialize.js') }}"></script>
        <!--prism-->
        <script src="{{ asset('vendors/prism/prism.js') }}"></script>
        <!--scrollbar-->
        <script src="{{ asset('vendors/perfect-scrollbar/perfect-scrollbar.min.js') }}"></script>
        <!--sweetalert-->
        <script src="{{ asset('vendors/sweetalert/dist/sweetalert.min.js') }}"></script>
        <!--plugins.js - Some Specific JS codes for Plugin Settings-->
        <script src="{{ asset('js/plugins.js') }}"></script>
        @show
    </body>
</html>