@extends("backend.login.layout.auth")
@section("title", "MediaMétrica | Iniciar sesión")
@section('stylesheets')
@parent

@endsection
@section("body")
<div class="col s10 offset-s1 z-depth-4 card-panel">
    <form class="login_form">
        <div class="row">
            <div class="input-field col s12 center">
                <img src="{{ asset("images/logo/mm-login-deg.png") }}" alt="" class="circle responsive-img valign profile-image-login">
            </div>
        </div>
        <div class="row">
            <div class="input-field col s12">
                <i class="material-icons prefix pt-5">person_outline</i>
                <input id="correo" type="email" class="validate">
                <label for="correo" class="center-align">Ingrese el correo</label>
            </div>

            <div class="input-field col s12">
                <i class="material-icons prefix pt-5">lock_outline</i>
                <input id="clave" type="password" class="validate">
                <label for="clave">Ingrese la contraseña</label>
            </div>
        </div>
        <div class="row">
            <input type="hidden" id="flagi" value="1">
            <div class="input-field col s12">
                <a href="#" class="login_bac btn gradient-45deg-purple-deep-orange col s12">Iniciar sesión</a>
            </div>
        </div><br>

    </form>
</div>

@endsection
@section('javascripts')
@parent
<script src="{{ asset("js/login.js") }}"></script>
@endsection
