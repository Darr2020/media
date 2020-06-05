<!DOCTYPE html>
<html lang="{{ App::getLocale() }}">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        @section('meta')
            
        @show
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
        <link rel="stylesheet" href="{{ asset('css/themes/overlay-menu/portfolio.css') }}">
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

        <!-- START HEADER -->
        <header id="header" class="page-topbar">
            <div class="navbar-fixed">
                <nav class="navbar-color">
                    <div class="nav-wrapper">
                        <ul class="left">
                            <li>
                                <h1 class="logo-wrapper">
                                    @if(Session::has('usuario'))
                                    <a class="brand-logo darken-1" href="{{ route('pagina_principal')}}">
                                    @else
                                    <a class="brand-logo darken-1" href="{{ route('pagina_principal')}}">
                                        <img src="{{ asset("images/logo/mm-color.png") }}" alt="mediametrica logo" style="width: 30px; height:27px;">
                                        <span class="logo-text hide-on-med-and-down">MediaMétrica</span>
                                    </a>
                                    @endif
                                </h1>
                            </li>
                        </ul>

                        @section('navbar-top')
                        {{-- <div class="header-search-wrapper hide-on-med-and-down sideNav-lock" style="margin-left: 300px">
                            <i class="material-icons">search</i>
                            <input type="text" name="Search" class="header-search-input z-depth-2" placeholder="Buscar" />
                        </div> --}}
                        @show

                        @if(Session::has('usuario'))
                        <ul class="right hide-on-med-and-down">
                            <li>

                                @if(Session::get("usuario")->avatar)
                                <a href="javascript:void(0);" class="waves-effect waves-block waves-light profile-button" data-activates="profile-dropdown">
                                    <span class="avatar-status avatar-online" >
                                        <img src="{{ Session::get("usuario")->avatar }}" alt="avatar">
                                    </span>
                                    {{ Session::get('usuario')->nombre }}
                                </a>
                                @else
                                <a href="javascript:void(0);" class="waves-effect waves-block waves-light profile-button" data-activates="profile-dropdown">
                                    <span class="avatar-status avatar-online" >
                                        <img src="../../images/avatar/avatar-0.png" alt="avatar">
                                    </span>
                                    {{ Session::get('usuario')->nombre }}
                                </a>
                                @endif

                            </li>
                        </ul>

                        <!-- profile-dropdown -->
                        <ul id="profile-dropdown" class="dropdown-content">
                       <!--     <li>
                                <a href="#" class="grey-text text-darken-1">
                                    <i class="material-icons">face</i> Profile</a>
                            </li>
                            <li>
                                <a href="#" class="grey-text text-darken-1">
                                    <i class="material-icons">settings</i> Settings</a>
                            </li>
                            <li>
                                <a href="#" class="grey-text text-darken-1">
                                    <i class="material-icons">live_help</i> Help</a>
                            </li> -->
                            <li class="divider"></li>
                            <li>
                                <a href="{{ route('cerrar_sesion')}}" class="grey-text text-darken-1">
                                    <i class="material-icons">keyboard_tab</i> Cerrar sesión</a>
                            </li>
                        </ul>

                        @else
                        <ul class="right hide-on-med-and-down">
                            <li>
                                <a onclick="ingresarfm()" class="waves-effect waves-block waves-light">
                                    Ingresar <i class="material-icons right">lock_open</i>
                                </a>
                            </li>
                        </ul>
                        @endif


                    </div>
                </nav>
            </div>
        </header>
        <!-- END HEADER -->

        <!-- START MAIN -->
        <div id="main">
            <!-- START WRAPPER -->
            <div class="wrapper">
                <!-- START LEFT SIDEBAR NAV-->
                <aside id="left-sidebar-nav">
                    <ul id="slide-out" class="side-nav leftside-navigation">
                        <li class="no-padding">
                            <ul class="collapsible" data-collapsible="accordion">

                                @section('categorias')

                                @if(Session::has('usuario'))
                                <li class="bold">
                                    <a href="{{ route('cerrar_sesion')}}" class="waves-effect waves-cyan">
                                        <i class="material-icons">keyboard_tab</i>
                                        <span class="nav-text">Cerrar sesión</span>
                                    </a>
                                </li>
                                @else 
                                <li class="bold">
                                    <a onclick="ingresarfm()" class="waves-effect waves-block waves-light">
                                        Ingresar <i class="material-icons right">lock_open</i>
                                    </a>
                                </li>
                                @endif

                                @show

                            </ul>
                        </li>
                    </ul>

                    <a href="#" data-activates="slide-out" class="sidebar-collapse @if(!Session::has('usuario')) hidden @endif btn-floating btn-medium waves-effect waves-light pink accent-2">
                        <i class="material-icons">menu</i>
                    </a>
                </aside>
                <!-- END LEFT SIDEBAR NAV-->
                <!-- START CONTENT -->
                <section id="content">
                    <!--start container-->
                    <div class="container">
                        <div class="section">
                            <div class="row">
                                <div class="patreon-img-ad2">
                                    <img class="materialboxed" width="40px" height="35px" src="{{ asset("images/media/audifonos-01.png") }}">
                                </div>
                                <div class="patreon-img-ad2">
                                    <img class="materialboxed" width="60px" height="35px" src="{{ asset("images/media/cloud-01.png") }}">
                                </div>
                            </div>
                            <div class="row" >
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
                                        <a href="/"> <img class="zoom" width="80px" height="80px" src="{{ asset("images/media/ranking.png") }}"></a>
                                    </div>
                                    <div class="patreon-img-ad3">
                                        <a href="{{ route('noticias_main') }}"><img class="zoom" width="80px" height="80px" src="{{ asset("images/media/noticias.png") }}"></a>
                                    </div>
                                    <div class="patreon-img-ad3">
                                        <img class="zoom" width="80px" height="80px" src="{{ asset("images/media/productos.png") }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                        @section('body')

                        @show
                    </div>
                    <!--end container-->
                </section>
                <!-- END CONTENT -->
            </div>
            <!-- END WRAPPER -->
            @section('floating')
            <!-- Floating Action Button -->
            <div class="fixed-social">
                <ul class="fixed-list">
                    <li>
                        <a href="">
                            <img src="{{ asset('images/noticias/redes/facebook.png') }}" alt="facebook">
                        </a>
                    </li>
                    <li>
                        <a href="">
                            <img src="{{ asset('images/noticias/redes/instagram.png') }}" alt="instagram">
                        </a>
                    </li>
                    <li>
                        <a href="">
                            <img src="{{ asset('images/noticias/redes/youtube.png') }}" alt="youtube">
                        </a>
                    </li>
                    <li>
                        <a href="">
                            <img src="{{ asset('images/noticias/redes/twitter.png') }}" alt="twiiter">
                        </a>
                    </li>
                    <li>
                        <a href="">
                            <img src="{{ asset('images/noticias/redes/tumblr.png') }}" alt="tumblr">
                        </a>
                    </li>
                    <li>
                        <a href="">
                            <img src="{{ asset('images/noticias/redes/snapchat.png') }}" alt="tumblr">
                        </a>
                    </li>
                </ul>
            </div>
            <!-- Floating Action Button -->
            @show
        </div>
        <!-- END MAIN -->
        <!-- START FOOTER -->
        <footer class="page-footer" style="background-color: #999999">
            <div class="footer-copyright" style="background-color: #999999">
                <div class="container">
                    <div class="row">
                        <div class="col s12 m6 offset-m3">
                            <div class="col s12 m6" style="text-align: center" >
                                <div class="col s12 m7 offset-m5">
                                    <img class="" width="131px" height="144px" src="{{ asset("images/media/contacto.png") }}" >
                                </div>
                                <div class="col s12 m7 offset-m5">
                                    <h5 style="color: #fff; font-size: 23px; font-family: 'Gotham';"><strong>Nosotros</strong></h5>
                                    <h6 style="color: #fff; font-size: 23px; font-family: 'Gotham';">Quiénes Somos</h6>
                                </div>
                            </div>
                            <div class="col s12 m6" style="float: right; text-align: center">
                                <div class="col s12">
                                    <img class="" width="131px" height="143px" src="{{ asset("images/media/contacto2.png") }}" >
                                </div>
                                <div class="col s12">
                                    <h5 style="color: #fff; font-size: 23px; font-family: 'Gotham';"><strong>Contáctenos</strong></h5>
                                    <h6 style="color: #fff; font-family: 'Gotham';">Escribanos a nuestro correo electrónico</h6>
                                    <h6 style="color: #4d4d4d; font-family: 'Gotham';"> info@mediametrica.com</h6>
                                    <h6> o envíenos su mensaje a través del</h6>
                                    <h6 style="color: #4d4d4d; font-family: 'Gotham';"> formulario de contácto</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row" style="text-align: center;">
                        <div class="col s12" >
                            <h6 style="color: #fff; font-size: 10px; font-family: 'Gotham';">Copyright MediaMétrica<br> 
                                Todos los derechos Reservado<br>
                                Developed by</h6>
                            <h6 style="color: #4d4d4d; font-size: 10px; font-family: 'Gotham';">NAME</h6>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
        <!-- END FOOTER -->


        <!-- START MODALGeneric -->
        <div id="ModalG" class="modal modal-fixed-footer">
            <div class="modal-content">
                <div class="modal-body" id="cuerpoModal">

                </div>
            </div>
            <!-- END MODAL CONTANT --> 

            <div class="modal-footer">
                <a href="#!" class="modal-action modal-close waves-effect waves-red btn-flat ">Cerrar</a>
            </div>
        </div>
        <!-- END MODALG -->           


        @section('javascripts')
        <!-- jQuery Library -->
        <script src="{{ asset('vendors/jquery-3.2.1.min.js') }}"></script>
        <!--materialize js-->
        <script src="{{ asset('js/materialize.js') }}"></script>
        <!--prism-->
        <script src="{{ asset('vendors/prism/prism.js') }}"></script>
        <!--scrollbar-->
        <script src="{{ asset('vendors/perfect-scrollbar/perfect-scrollbar.min.js') }}"></script>
        <!--sweetalert -->
        <script src="{{ asset('vendors/sweetalert/dist/SweetAlert.js') }}"></script>
        <!--plugins.js - Some Specific JS codes for Plugin Settings-->
        <script src="{{ asset('js/plugins.js') }}"></script>
        <!--extra-components-sweetalert.js - Some Specific JS-->
        <script src="{{ asset('js/scripts/extra-components-sweetalert.js') }}"></script>
        <!--advance-ui-carousel.js - Page Specific JS codes-->
        <script src="{{ asset('js/scripts/advance-ui-carousel.js')}}"></script>
        <!--advanced-ui-modals.js - Some Specific JS codes -->
        <script src="{{ asset('js/scripts/advanced-ui-modals.js') }}"></script>
        <!--custom-script.js - Add your own theme custom JS-->
        <script src="{{ asset('js/custom-script.js') }}"></script>
        <!--js frontend-->
        <script src="{{ asset('js/frontend.js') }}"></script>
        <script src="{{ asset("js/login.js") }}"></script>
        @show
    </body>
</html>
