
<!DOCTYPE html>
<html lang="{{ App::getLocale() }}" ng-app='myApp'>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="_token" content="{{ csrf_token() }}">
        <title> @yield('title') </title>
        <!-- Favicons-->
        <link rel="icon" href="{{ asset("images/favicon/favicon-mm.png") }}" sizes="32x32">
        <!-- Favicons-->
        <link rel="apple-touch-icon-precomposed" href="../../images/favicon/apple-touch-icon-152x152.png">
        <!-- For iPhone -->
        <meta name="msapplication-TileColor" content="#00bcd4">
        <meta name="msapplication-TileImage" content="images/favicon/mstile-144x144.html">
        <!-- For Windows Phone -->
        @section('stylesheets')
        <!-- CORE CSS-->
        <link rel="stylesheet" href="{{ asset('css/themes/collapsible-menu/materialize.css') }}">
        <link rel="stylesheet" href="{{ asset('css/themes/collapsible-menu/style.css') }}">

        <!-- Custome CSS-->
        <link rel="stylesheet" href="{{ asset('css/custom/custom.css') }}">

        <!-- INCLUDED PLUGIN CSS ON THIS PAGE -->
        <link rel="stylesheet" href="{{ asset('vendors/prism/prism.css') }}">
        <link rel="stylesheet" href="{{ asset('vendors/perfect-scrollbar/perfect-scrollbar.css') }}">
        <link rel="stylesheet" href="{{ asset('vendors/sweetalert/dist/sweetalert.css') }}">
        <link rel="stylesheet" href="{{ asset('vendors/dropify/css/dropify.min.css') }}">
        <link rel="stylesheet" href="{{ asset('vendors/flag-icon/css/flag-icon.min.css') }}">
        <link rel="stylesheet" href="{{ asset('vendors/data-tables/css/jquery.dataTables.min.css') }}">
        <link rel="stylesheet" href="{{ asset('css/font-awesome.min.css') }}">

        @show
    </head>
    <body>
        <!-- Start Page Loading -->
        <div id="loader-wrapper">
            <div id="loader"></div>
            <div class="loader-section section-left"></div>
            <div class="loader-section section-right"></div>
        </div>
        <!-- End Page Loading -->
        <!-- //////////////////////////////////////////////////////////////////////////// -->
        <!-- START HEADER -->
        <header id="header" class="page-topbar">
            <!-- start header nav-->
            <div class="navbar-fixed">
                <nav class="navbar-color gradient-45deg-purple-deep-orange gradient-shadow">
                    <div class="nav-wrapper">
                        <ul class="right hide-on-med-and-down">
                            <li>
                                <a href="javascript:void(0);" class="waves-effect waves-block waves-light toggle-fullscreen">
                                    <i class="material-icons">settings_overscan</i>
                                </a>
                            </li>
                        <!--    <li>
                                <a href="javascript:void(0);" class="waves-effect waves-block waves-light notification-button" data-activates="notifications-dropdown">
                                    <i class="material-icons">notifications_none
                                        <small class="notification-badge">5</small>
                                    </i>
                                </a>
                            </li>-->

                            <li>
                                <a href="javascript:void(0);" class="waves-effect waves-block waves-light profile-button" data-activates="profile-dropdown">
                                    <span class="avatar-status avatar-online">
                                        @if(Session::get("usuario_backend")->avatar)
                                        <img src="{{ Session::get("usuario_backend")->avatar }}" alt="avatar">
                                        @else
                                        <img src="../../images/avatar/avatar-0.png" alt="avatar">
                                        @endif
                                    </span>
                                    {{ Session::get('usuario_backend')->nombre }}
                                </a>
                            </li>

                        <!--    <li>
                                <a href="#" data-activates="chat-out" class="waves-effect waves-block waves-light chat-collapse">
                                    <i class="material-icons">format_indent_increase</i>
                                </a>
                            </li>-->
                        </ul>


                        <!-- //////////////////////////////////////////////////////////////////////////// -->
                        <!-- notifications-dropdown -->
                        <ul id="notifications-dropdown" class="dropdown-content">
                            <li>
                                <h6>NOTIFICATIONS
                                    <span class="new badge">5</span>
                                </h6>
                            </li>
                            <li class="divider"></li>
                            <li>
                                <a href="#!" class="grey-text text-darken-2">
                                    <span class="material-icons icon-bg-circle cyan small">add_shopping_cart</span> A new order has been placed!</a>
                                <time class="media-meta" datetime="2015-06-12T20:50:48+08:00">2 hours ago</time>
                            </li>
                            <li>
                                <a href="#!" class="grey-text text-darken-2">
                                    <span class="material-icons icon-bg-circle red small">stars</span> Completed the task</a>
                                <time class="media-meta" datetime="2015-06-12T20:50:48+08:00">3 days ago</time>
                            </li>
                            <li>
                                <a href="#!" class="grey-text text-darken-2">
                                    <span class="material-icons icon-bg-circle teal small">settings</span> Settings updated</a>
                                <time class="media-meta" datetime="2015-06-12T20:50:48+08:00">4 days ago</time>
                            </li>
                            <li>
                                <a href="#!" class="grey-text text-darken-2">
                                    <span class="material-icons icon-bg-circle deep-orange small">today</span> Director meeting started</a>
                                <time class="media-meta" datetime="2015-06-12T20:50:48+08:00">6 days ago</time>
                            </li>
                            <li>
                                <a href="#!" class="grey-text text-darken-2">
                                    <span class="material-icons icon-bg-circle amber small">trending_up</span> Generate monthly report</a>
                                <time class="media-meta" datetime="2015-06-12T20:50:48+08:00">1 week ago</time>
                            </li>
                        </ul>
                        <!-- profile-dropdown -->
                        <ul id="profile-dropdown" class="dropdown-content">
                         <!--   <li>
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
                            </li>-->
                            <li class="divider"></li>
                            <li>
                                <a href="{{route('backend_salir')}}" class="grey-text text-darken-1">
                                    <i class="material-icons">keyboard_tab</i> Cerrar sesión</a>
                            </li>
                        </ul>
                    </div>
                </nav>
            </div>
        </header>
        <!-- END HEADER -->


        <!-- //////////////////////////////////////////////////////////////////////////// -->
        <!-- START MAIN -->
        <div id="main">
            <!-- START WRAPPER -->
            <div class="wrapper">
                <!-- START LEFT SIDEBAR NAV-->
                <aside id="left-sidebar-nav" class="nav-expanded nav-lock nav-collapsible">
                    <div class="brand-sidebar">
                        <h1 class="logo-wrapper">
                            <a href="#" class="brand-logo darken-1">
                                <img src="{{ asset("images/logo/mm-blanco.png") }}" alt="mediametrica logo">
                                <span class="logo-text hide-on-med-and-down">MediaM</span>
                            </a>
                            <a href="#" class="navbar-toggler">
                                <i class="material-icons">radio_button_checked</i>
                            </a>
                        </h1>
                    </div>
                    <ul id="slide-out" class="side-nav fixed leftside-navigation">
                        <li class="no-padding">
                            <ul class="collapsible" data-collapsible="accordion">

                                <li class="bold">
                                    <a href="{{route('backend_inicio')}}" class="waves-effect waves-cyan">
                                        <i class="material-icons">home</i>
                                        <span class="nav-text">Inicio</span>
                                    </a>
                                </li>
                                
                                @if(Auth::user()->is('admin'))
                                <li class="bold">
                                    <a class="collapsible-header waves-effect waves-cyan">
                                        <i class="material-icons">dashboard</i>
                                        <span class="nav-text">Administración de <br> Categorias</span>
                                    </a>
                                    <div class="collapsible-body">
                                        <ul>
                                            <li class="active">
                                                <a href="{{route('crear_categoria')}}">
                                                    <i class="material-icons">keyboard_arrow_right</i>
                                                    <span>Crear Categorias</span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="{{route('consultar_categoria')}}">
                                                    <i class="material-icons">keyboard_arrow_right</i>
                                                    <span>Consultar Categorias</span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="{{route('crear_candidato')}}">
                                                    <i class="material-icons">keyboard_arrow_right</i>
                                                    <span>Crear Candidatos</span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="{{route('consultar_candidato')}}">
                                                    <i class="material-icons">keyboard_arrow_right</i>
                                                    <span>Consultar Candidatos</span>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </li>
                                @endif

                                @if(Auth::user()->is('admin'))
                                <li class="bold">
                                    <a class="collapsible-header waves-effect waves-cyan">
                                        <i class="material-icons">poll</i>
                                        <span class="nav-text">Encuestas</span>
                                    </a>
                                    <div class="collapsible-body">
                                        <ul>
                                            <li>
                                                <a href="{{route('enc_tlf_index')}}">
                                                    <i class="material-icons">keyboard_arrow_right</i>
                                                    <span>Telefónica</span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="{{route('encweb_index')}}">
                                                    <i class="material-icons">keyboard_arrow_right</i>
                                                    <span>Web</span>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </li>
                                @endif

                                @if(Auth::user()->is('admin'))
                                <li class="bold">
                                    <a href="{{route('index_cfparams')}}" class="waves-effect waves-cyan">
                                        <i class="material-icons">settings_applications</i>
                                        <span class="nav-text">Admin. Parametros</span>
                                    </a>
                                </li> 
                                @endif

                                @if(Auth::user()->is('admin'))
                                <li class="bold">
                                    <a href="{{route('admin_users')}}" class="waves-effect waves-cyan">
                                        <i class="material-icons">group</i>
                                        <span class="nav-text">Admin. Usuarios</span>
                                    </a>
                                </li>  
                                @endif

                                @if(Auth::user()->is('admin'))    
                                <li class="bold">
                                    <a class="collapsible-header waves-effect waves-cyan">
                                        <i class="material-icons">style</i>
                                        <span class="nav-text">Administración web</span>
                                    </a>
                                    <div class="collapsible-body">
                                        <ul>
                                            <li>
                                                <a href="{{route('admin_posicion')}}">
                                                    <i class="material-icons">keyboard_arrow_right</i>
                                                    <span>Posición Categoría</span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="{{route('admin_carrusel')}}">
                                                    <i class="material-icons">keyboard_arrow_right</i>
                                                    <span>Carrusel</span>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </li>
                                @endif

                                @if(Auth::user()->is(['admin','editor','escritor']))
                                <li class="bold">
                                    <a class="collapsible-header waves-effect waves-cyan">
                                        <i class="material-icons">book</i>
                                        <span class="nav-text">Noticias</span>
                                    </a>
                                    <div class="collapsible-body">
                                        <ul>
                                            @if(Auth::user()->is(['admin','editor','escritor']))
                                            <li>
                                                <a href="{{route('newNoticia')}}">
                                                    <i class="material-icons">queue</i>
                                                    <span>Agregar</span>
                                                </a>
                                            </li>
                                            @endif
                                            @if(Auth::user()->is(['admin','editor','escritor']))
                                            <li>
                                                <a href="{{route('showNoticiasBackend')}}">
                                                    <i class="material-icons">build</i>
                                                    <span>Publicaciones</span>
                                                </a>
                                            </li>
                                            @endif
                                            @if(Auth::user()->is(['admin','editor']))
                                            <li>
                                                <a href="{{route('configuracion_modulo')}}">
                                                    <i class="material-icons">list</i>
                                                    <span>Configuración de Módulo</span>
                                                </a>
                                            </li>
                                            @endif
                                            @if(Auth::user()->is(['admin','editor']))
                                            <li>
                                                <a href="{{route('configuracion_publicidad')}}">
                                                    <i class="material-icons">list</i>
                                                    <span>Publicidad</span>
                                                </a>
                                            </li>
                                            @endif
                                            @if(Auth::user()->is(['admin','editor']))
                                            <li>
                                                <a href="{{route('configuracion_iframes')}}">
                                                    <i class="material-icons">list</i>
                                                    <span>iFrames</span>
                                                </a>
                                            </li>
                                            @endif
                                        </ul>
                                    </div>
                                </li>
                                @endif

                            </ul>
                        </li>
                    </ul>



                    <a href="#" data-activates="slide-out" class="sidebar-collapse btn-floating btn-medium waves-effect waves-light hide-on-large-only gradient-45deg-light-blue-cyan gradient-shadow">
                        <i class="material-icons">menu</i>
                    </a>
                </aside>
                <!-- END LEFT SIDEBAR NAV-->


                <!-- //////////////////////////////////////////////////////////////////////////// -->
                <!-- START CONTENT -->
                <section id="content">
                    @section('body')

                    @show
                </section>
                <!-- END CONTENT -->
                <!-- //////////////////////////////////////////////////////////////////////////// -->




                <!-- //////////////////////////////////////////////////////////////////////////// -->
                <!-- START RIGHT SIDEBAR NAV-->
                <aside id="right-sidebar-nav">
                    <ul id="chat-out" class="side-nav rightside-navigation">
                        <li class="li-hover">
                            <div class="row">
                                <div class="col s12 border-bottom-1 mt-5">
                                    <ul class="tabs">
                                        <li class="tab col s4">
                                            <a href="#activity" class="active">
                                                <span class="material-icons">graphic_eq</span>
                                            </a>
                                        </li>
                                        <li class="tab col s4">
                                            <a href="#chatapp">
                                                <span class="material-icons">face</span>
                                            </a>
                                        </li>
                                        <li class="tab col s4">
                                            <a href="#settings">
                                                <span class="material-icons">settings</span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                                <div id="settings" class="col s12">
                                    <h6 class="mt-5 mb-3 ml-3">GENERAL SETTINGS</h6>
                                    <ul class="collection border-none">
                                        <li class="collection-item border-none">
                                            <div class="m-0">
                                                <span class="font-weight-600">Notifications</span>
                                                <div class="switch right">
                                                    <label>
                                                        <input checked type="checkbox">
                                                        <span class="lever"></span>
                                                    </label>
                                                </div>
                                            </div>
                                            <p>Use checkboxes when looking for yes or no answers.</p>
                                        </li>
                                        <li class="collection-item border-none">
                                            <div class="m-0">
                                                <span class="font-weight-600">Show recent activity</span>
                                                <div class="switch right">
                                                    <label>
                                                        <input checked type="checkbox">
                                                        <span class="lever"></span>
                                                    </label>
                                                </div>
                                            </div>
                                            <p>The for attribute is necessary to bind our custom checkbox with the input.</p>
                                        </li>
                                        <li class="collection-item border-none">
                                            <div class="m-0">
                                                <span class="font-weight-600">Notifications</span>
                                                <div class="switch right">
                                                    <label>
                                                        <input type="checkbox">
                                                        <span class="lever"></span>
                                                    </label>
                                                </div>
                                            </div>
                                            <p>Use checkboxes when looking for yes or no answers.</p>
                                        </li>
                                        <li class="collection-item border-none">
                                            <div class="m-0">
                                                <span class="font-weight-600">Show recent activity</span>
                                                <div class="switch right">
                                                    <label>
                                                        <input type="checkbox">
                                                        <span class="lever"></span>
                                                    </label>
                                                </div>
                                            </div>
                                            <p>The for attribute is necessary to bind our custom checkbox with the input.</p>
                                        </li>
                                        <li class="collection-item border-none">
                                            <div class="m-0">
                                                <span class="font-weight-600">Show your emails</span>
                                                <div class="switch right">
                                                    <label>
                                                        <input type="checkbox">
                                                        <span class="lever"></span>
                                                    </label>
                                                </div>
                                            </div>
                                            <p>Use checkboxes when looking for yes or no answers.</p>
                                        </li>
                                        <li class="collection-item border-none">
                                            <div class="m-0">
                                                <span class="font-weight-600">Show Task statistics</span>
                                                <div class="switch right">
                                                    <label>
                                                        <input type="checkbox">
                                                        <span class="lever"></span>
                                                    </label>
                                                </div>
                                            </div>
                                            <p>The for attribute is necessary to bind our custom checkbox with the input.</p>
                                        </li>
                                    </ul>
                                </div>
                                <div id="chatapp" class="col s12">
                                    <div class="collection border-none">
                                        <a href="#!" class="collection-item avatar border-none">
                                            <img src="../../images/avatar/avatar-1.png" alt="" class="circle cyan">
                                            <span class="line-height-0">Elizabeth Elliott </span>
                                            <span class="medium-small right blue-grey-text text-lighten-3">5.00 AM</span>
                                            <p class="medium-small blue-grey-text text-lighten-3">Thank you </p>
                                        </a>
                                        <a href="#!" class="collection-item avatar border-none">
                                            <img src="../../images/avatar/avatar-2.png" alt="" class="circle deep-orange accent-2">
                                            <span class="line-height-0">Edwars Adams </span>
                                            <span class="medium-small right blue-grey-text text-lighten-3">4.14 AM</span>
                                            <p class="medium-small blue-grey-text text-lighten-3">Hello Boo </p>
                                        </a>
                                        <a href="#!" class="collection-item avatar border-none">
                                            <img src="../../images/avatar/avatar-3.png" alt="" class="circle teal accent-4">
                                            <span class="line-height-0">Caleb Richards </span>
                                            <span class="medium-small right blue-grey-text text-lighten-3">9.00 PM</span>
                                            <p class="medium-small blue-grey-text text-lighten-3">Keny ! </p>
                                        </a>
                                        <a href="#!" class="collection-item avatar border-none">
                                            <img src="../../images/avatar/avatar-4.png" alt="" class="circle cyan">
                                            <span class="line-height-0">April Lane </span>
                                            <span class="medium-small right blue-grey-text text-lighten-3">4.14 AM</span>
                                            <p class="medium-small blue-grey-text text-lighten-3">Ohh God </p>
                                        </a>
                                        <a href="#!" class="collection-item avatar border-none">
                                            <img src="../../images/avatar/avatar-5.png" alt="" class="circle red accent-2">
                                            <span class="line-height-0">Eddie Fletcher </span>
                                            <span class="medium-small right blue-grey-text text-lighten-3">5.15 PM</span>
                                            <p class="medium-small blue-grey-text text-lighten-3">Love you </p>
                                        </a>
                                        <a href="#!" class="collection-item avatar border-none">
                                            <img src="../../images/avatar/avatar-6.png" alt="" class="circle deep-orange accent-2">
                                            <span class="line-height-0">Crystal Bates </span>
                                            <span class="medium-small right blue-grey-text text-lighten-3">8.00 AM</span>
                                            <p class="medium-small blue-grey-text text-lighten-3">Can we </p>
                                        </a>
                                        <a href="#!" class="collection-item avatar border-none">
                                            <img src="../../images/avatar/avatar-7.png" alt="" class="circle cyan">
                                            <span class="line-height-0">Nathan Watts </span>
                                            <span class="medium-small right blue-grey-text text-lighten-3">9.53 PM</span>
                                            <p class="medium-small blue-grey-text text-lighten-3">Great! </p>
                                        </a>
                                        <a href="#!" class="collection-item avatar border-none">
                                            <img src="../../images/avatar/avatar-8.png" alt="" class="circle red accent-2">
                                            <span class="line-height-0">Willard Wood </span>
                                            <span class="medium-small right blue-grey-text text-lighten-3">4.20 AM</span>
                                            <p class="medium-small blue-grey-text text-lighten-3">Do it </p>
                                        </a>
                                        <a href="#!" class="collection-item avatar border-none">
                                            <img src="../../images/avatar/avatar-9.png" alt="" class="circle teal accent-4">
                                            <span class="line-height-0">Rose Ellis </span>
                                            <span class="medium-small right blue-grey-text text-lighten-3">5.30 PM</span>
                                            <p class="medium-small blue-grey-text text-lighten-3">Got that </p>
                                        </a>
                                        <a href="#!" class="collection-item avatar border-none">
                                            <img src="../../images/avatar/avatar-10.png" alt="" class="circle cyan">
                                            <span class="line-height-0">Eva Wood </span>
                                            <span class="medium-small right blue-grey-text text-lighten-3">4.34 AM</span>
                                            <p class="medium-small blue-grey-text text-lighten-3">Like you </p>
                                        </a>
                                    </div>
                                </div>
                                <div id="activity" class="col s12">
                                    <h6 class="mt-5 mb-3 ml-3">RECENT ACTIVITY</h6>
                                    <div class="activity">
                                        <div class="col s3 mt-2 center-align recent-activity-list-icon">
                                            <i class="material-icons white-text icon-bg-color deep-purple lighten-2">add_shopping_cart</i>
                                        </div>
                                        <div class="col s9 recent-activity-list-text">
                                            <a href="#" class="deep-purple-text medium-small">just now</a>
                                            <p class="mt-0 mb-2 fixed-line-height font-weight-300 medium-small">Jim Doe Purchased new equipments for zonal office.</p>
                                        </div>
                                        <div class="recent-activity-list chat-out-list row mb-0">
                                            <div class="col s3 mt-2 center-align recent-activity-list-icon">
                                                <i class="material-icons white-text icon-bg-color cyan lighten-2">airplanemode_active</i>
                                            </div>
                                            <div class="col s9 recent-activity-list-text">
                                                <a href="#" class="cyan-text medium-small">Yesterday</a>
                                                <p class="mt-0 mb-2 fixed-line-height font-weight-300 medium-small">Your Next flight for USA will be on 15th August 2015.</p>
                                            </div>
                                        </div>
                                        <div class="recent-activity-list chat-out-list row mb-0">
                                            <div class="col s3 mt-2 center-align recent-activity-list-icon medium-small">
                                                <i class="material-icons white-text icon-bg-color green lighten-2">settings_voice</i>
                                            </div>
                                            <div class="col s9 recent-activity-list-text">
                                                <a href="#" class="green-text medium-small">5 Days Ago</a>
                                                <p class="mt-0 mb-2 fixed-line-height font-weight-300 medium-small">Natalya Parker Send you a voice mail for next conference.</p>
                                            </div>
                                        </div>
                                        <div class="recent-activity-list chat-out-list row mb-0">
                                            <div class="col s3 mt-2 center-align recent-activity-list-icon">
                                                <i class="material-icons white-text icon-bg-color amber lighten-2">store</i>
                                            </div>
                                            <div class="col s9 recent-activity-list-text">
                                                <a href="#" class="amber-text medium-small">1 Week Ago</a>
                                                <p class="mt-0 mb-2 fixed-line-height font-weight-300 medium-small">Jessy Jay open a new store at S.G Road.</p>
                                            </div>
                                        </div>
                                        <div class="recent-activity-list row">
                                            <div class="col s3 mt-2 center-align recent-activity-list-icon">
                                                <i class="material-icons white-text icon-bg-color deep-orange lighten-2">settings_voice</i>
                                            </div>
                                            <div class="col s9 recent-activity-list-text">
                                                <a href="#" class="deep-orange-text medium-small">2 Week Ago</a>
                                                <p class="mt-0 mb-2 fixed-line-height font-weight-300 medium-small">voice mail for conference.</p>
                                            </div>
                                        </div>
                                        <div class="recent-activity-list chat-out-list row mb-0">
                                            <div class="col s3 mt-2 center-align recent-activity-list-icon medium-small">
                                                <i class="material-icons white-text icon-bg-color brown lighten-2">settings_voice</i>
                                            </div>
                                            <div class="col s9 recent-activity-list-text">
                                                <a href="#" class="brown-text medium-small">1 Month Ago</a>
                                                <p class="mt-0 mb-2 fixed-line-height font-weight-300 medium-small">Natalya Parker Send you a voice mail for next conference.</p>
                                            </div>
                                        </div>
                                        <div class="recent-activity-list chat-out-list row mb-0">
                                            <div class="col s3 mt-2 center-align recent-activity-list-icon">
                                                <i class="material-icons white-text icon-bg-color deep-purple lighten-2">store</i>
                                            </div>
                                            <div class="col s9 recent-activity-list-text">
                                                <a href="#" class="deep-purple-text medium-small">3 Month Ago</a>
                                                <p class="mt-0 mb-2 fixed-line-height font-weight-300 medium-small">Jessy Jay open a new store at S.G Road.</p>
                                            </div>
                                        </div>
                                        <div class="recent-activity-list row">
                                            <div class="col s3 mt-2 center-align recent-activity-list-icon">
                                                <i class="material-icons white-text icon-bg-color grey lighten-2">settings_voice</i>
                                            </div>
                                            <div class="col s9 recent-activity-list-text">
                                                <a href="#" class="grey-text medium-small">1 Year Ago</a>
                                                <p class="mt-0 mb-2 fixed-line-height font-weight-300 medium-small">voice mail for conference.</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                    </ul>
                </aside>
                <!-- END RIGHT SIDEBAR NAV-->
            </div>
            <!-- END WRAPPER -->
        </div>
        <!-- END MAIN -->
        <!-- //////////////////////////////////////////////////////////////////////////// -->



        <!-- START FOOTER -->
        <footer class="page-footer gradient-45deg-purple-deep-orange">
            <div class="footer-copyright">
                <div class="container">
                    <span>Copyright ©
                        <script type="text/javascript">
                            document.write(new Date().getFullYear());
                        </script> <a class="grey-text text-lighten-4" href="#" target="_blank">Name</a> All rights reserved.</span>
                    <span class="right hide-on-small-only"> Design and Developed by <a class="grey-text text-lighten-4" href="#">Name</a></span>
                </div>
            </div>
        </footer>
        <!-- END FOOTER -->

        @section('javascripts')
        <!-- jQuery Library -->
        <script src="{{ asset('vendors/jquery-3.2.1.min.js') }}"></script>
        <!--angularjs-->
        <script src="{{ asset('vendors/angular.min.js') }}"></script>
        <!--materialize js-->
        <script src="{{ asset('js/materialize.js') }}"></script>       
        <!--scrollbar-->
        <script src="{{ asset('vendors/perfect-scrollbar/perfect-scrollbar.min.js') }}"></script>
        <!-- data-tables -->
        <script src="{{ asset('vendors/data-tables/js/jquery.dataTables.min.js') }}"></script>
        <!-- data-tables.js - Page Specific JS codes -->
        <script src="{{ asset('js/scripts/data-tables.js') }}"></script>        
        <script src="{{ asset('js/formatoConsultaTabla.js') }}"></script>
        <!--sweetalert -->
        <script src="{{ asset('vendors/sweetalert/dist/SweetAlert.js') }}"></script>
        <!--plugins.js - Some Specific JS codes for Plugin Settings-->
        <script src="{{ asset('js/plugins.js') }}"></script>
        <!--extra-components-sweetalert.js - Some Specific JS-->
        <script src="{{ asset('js/scripts/extra-components-sweetalert.js') }}"></script>
        <!-- dropify -->
        <script src="{{ asset('vendors/dropify/js/dropify.min.js') }}"></script>
        <script src="{{ asset('js/scripts/form-file-uploads.js') }}"></script>
        <script>
            const app = angular.module('myApp', [])
        </script>
        @show

    </body>
</html>