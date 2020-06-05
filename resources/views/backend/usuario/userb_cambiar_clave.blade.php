@extends("backend.login.layout.auth")
@section("title", "MediaMétrica | Cambiar contraseña")
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
            <div class="input-field col s12 center">
              <h4 class="header">Cambiar contraseña</h4>
            </div>
          </div>
        <div class="row">
            <div class="input-field col s12">
                <i class="material-icons prefix pt-5">person_outline</i>
                <input id="correo" type="email" disabled value="{{ $usuario->correo }}">
            </div>
       </div>
        <div class="row">
            <div class="input-field col s12">
                <i class="material-icons prefix pt-5">lock_outline</i>
                <input id="clave" type="password" class="validate" minlength="8">
                <label for="clave">Ingrese la contraseña</label>
            </div>
            <div class="input-field col s12">
                <i class="material-icons prefix pt-5">lock_outline</i>
                <input id="clave_re" type="password" class="validate" minlength="8">
                <label for="clave_re">Repita la contraseña</label>
            </div>

        </div>
        <div class="row">
            <input id="user_id" type="hidden" value="{{ $usuario->id }}">
            <div class="input-field col s12">
                <a href="#" class="change_pass btn gradient-45deg-purple-deep-orange col s12">Cambiar contraseña</a>
            </div>
   
            <div class="input-field col s12"><br>
                <p class="margin medium-small center"><a href="{{url('/backend')}}">Volver</a></p>
            </div>
        </div>

    </form>
</div>      

@endsection
@section('javascripts')
@parent
<script src="{{ asset("js/usuario.js") }}"></script>
@endsection
