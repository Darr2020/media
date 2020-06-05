<!-- Form social media login -->               
<div class="col s12 m12 l12">
    <h5 class="center login-form-text2">MediaMétrica</h5>
    <div class="row">
        <form class="col s12">
            <h6>Iniciar sesión con tus redes sociales:</h6>
            <div class="row">                
                <div class="input-field col s12 m6 l6">
                    <a href="{{ route('social.auth', 'facebook') }}" class="btn #0d47a1 blue darken-4 col s12"> <i class="fa fa-facebook"></i> Facebook</a>
                </div>
                <div class="input-field col s12 m6 l6">
                    <a href="{{ route('social.auth', 'google') }}" class="btn #e65100 orange darken-4 col s12"> <i class="fa fa-google"></i> Google</a>
                </div>
            </div>
        </form>
    </div>
</div>                  

<div class="divider"></div>
<!-- Form mormal login -->
<div class="col s12 m12 l12">
    <div class="row">
        <form class="col s12" id="logform">
            <h6 style="margin-top:">Iniciar sesión mediante correo electrónico:</h6>
            <div class="row">
                <div class="input-field col s12">
                    <input id="correo" type="email" class="validate">
                    <label for="correo" class="center-align">Correo</label>
                </div>

                <div class="input-field col s12">
                    <input id="clave" type="password" class="validate">
                    <label for="clave" class="center-align">Contraseña</label>
                </div>
                <div class="input-field col s12">
                    <input type="hidden" id="flagi" value="2">
                    <a onclick="loginf()"  class="btn gradient-45deg-purple-deep-orange col s12">Iniciar sesión</a>
                </div>
                <div class="input-field col s4 m4 l4">
                    <p class="margin medium-small">
                        
                        <a onclick="registrarsefm()" class="" >Regístrate</a>
                    </p>
                </div>
                <div class="input-field col s8 m8 l8">
                    <p class="margin right-align medium-small"><a class="modal-close modal-trigger" href="#">¿Has olvidado la contraseña?</a></p>
                </div>
            </div>
        </form>
    </div>
</div> 