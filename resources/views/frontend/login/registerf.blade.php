                
<div class="col s12 m12 l12">
    <h5 class="center login-form-text2">MediaMétrica</h5>
    <div class="row">
        <form class="col s12" id="form_registerf" name="form_registerf">
            <h6 class="center">Unete a MediaMétrica</h6>
            <div class="row">
                <div class="input-field col s12">
                    <input id="nombrelf" name="nombrelf" type="text" class="validate" minlength="5" onkeypress="return sololetras(event)">
                    <label for="nombrelf" class="center-align">Nombre</label>
                </div>
                <div class="input-field col s12">
                    <input id="correolf" name="correolf" type="email" class="validate" minlength="10" maxlength="120">
                    <label for="correolf" class="center-align">Correo</label>
                </div>
                <div class="input-field col s12">
                    <input id="passwordlf" name="passwordlf" type="password" class="validate" minlength="8">
                    <label for="passwordlf">Contraseña</label>
                </div>
                <div class="input-field col s12">
                    <input id="password_againlf" name="password_againlf" type="password" class="validate" minlength="8">
                    <label for="password_againlf">Repita la Contraseña</label>
                </div>
                <div class="input-field col s12">
                    <a onclick="registrarf()" class="btn gradient-45deg-purple-deep-orange col s12">Registrarte</a>
                </div>
                <div class="input-field col s12">
                    <p class="margin center medium-small">¿Ya tienes usuario? 
                        <!--<a class="modal-close modal-trigger" href="#modal1">Iniciar sesión</a>-->
                        
                    </p>
                </div>
            </div>

        </form>
    </div>
</div>  
