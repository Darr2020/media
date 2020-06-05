
<!DOCTYPE html>
<html lang="{{ App::getLocale() }}">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="_token" content="{{ csrf_token() }}">
        <title>404 Error Page | MediaMétrica</title>
        <!-- Favicons-->
        <link rel="icon" href="../../images/favicon/favicon-mm.png" sizes="32x26">
        <!-- Favicons-->
        <link rel="apple-touch-icon-precomposed" href="../../images/favicon/favicon-mm.png" >
        <!-- For iPhone -->
        <meta name="msapplication-TileColor" content="#00bcd4">
        <!-- For Windows Phone -->
        <meta name="msapplication-TileImage" content="images/favicon/mstile-144x144.html">
        <!-- For Windows Phone -->




        <!-- CORE CSS-->      
        <link rel="stylesheet" href="{{ asset('css/themes/overlay-menu/materialize.css') }}">
         <link rel="stylesheet" href="{{ asset('css/themes/overlay-menu/style.css') }}">
        <!-- Custome CSS-->
        <link rel="stylesheet" href="{{ asset('css/custom/custom.css') }}">
        <link rel="stylesheet" href="{{ asset('css/layouts/page-center.css') }}">
        <!-- INCLUDED PLUGIN CSS ON THIS PAGE -->
        <link rel="stylesheet" href="{{ asset('vendors/perfect-scrollbar/perfect-scrollbar.css') }}">
    </head>
    <body>
        <!-- Start Page Loading -->
        <div id="loader-wrapper">
            <div id="loader"></div>
            <div class="loader-section section-left"></div>
            <div class="loader-section section-right"></div>
        </div>
        <!-- End Page Loading -->
        <div id="error-page">
            <div class="row">
                <div class="col s12">
                    <div class="browser-window">
                        <div class="top-bar">
                            <div class="circles">
                                <div id="close-circle" class="circle"></div>
                                <div id="minimize-circle" class="circle"></div>
                                <div id="maximize-circle" class="circle"></div>
                            </div>
                        </div>
                        <div class="content">
                            <div class="row">
                                <div id="site-layout-example-top" class="col s12">
                                    <p class="flat-text-logo center white-text caption-uppercase">Lo sentimos pero no pudimos encontrar esta página <b>:(</b></p>
                                </div>
                                <div id="site-layout-example-right" class="col s12 m12 l12" style="height:auto">
                                    <div class="row center">
                                        <h1 class="text-long-shadow col s12 mt-3">404</h1>
                                        <p><button class="btn" onclick="window.history.back()">VOLVER</button></p>
                                        <p class="center white-text">Parece que esta página no existe.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- ================================================
        Scripts
        ================================================ -->
        <!-- jQuery Library -->
        <script src="{{ asset('vendors/jquery-3.2.1.min.js') }}"></script>
        <!--materialize js-->
        <script src="{{ asset('js/materialize.js') }}"></script>
        <!--scrollbar-->
        <script src="{{ asset('vendors/perfect-scrollbar/perfect-scrollbar.min.js') }}"></script>
        <!--plugins.js - Some Specific JS codes for Plugin Settings-->
        <script src="{{ asset('js/plugins.js') }}"></script>
        <!--custom-script.js - Add your own theme custom JS-->
        <script src="{{ asset('js/custom-script.js') }}"></script>
        <script type="text/javascript">
    function goBack() {
        window.history.back();
    }
        </script>
    </body>

</html>