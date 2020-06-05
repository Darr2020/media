<form class="col s12" id="form_newuserb" name="form_newuserb" method="Post"><br><br>
<h4 class="center">Crear Usuario | backend</h4>
  <div class="col s12"><br>
  <div class="col s12 divider"></div></div>
  <div class="row">
    <div class="input-field col s12"><br>
        <input id="nombreb" name="nombreb" type="text" class="validate" minlength="5" onkeypress="return sololetras(event)">
        <label for="nombreb" class="center-align">Nombre</label>
    </div>
    <div class="input-field col s12">
        <input id="correob" name="correob" type="email" class="validate" minlength="10" maxlength="120">
        <label for="correob" class="center-align">Correo</label>
    </div>
    <div class="input-field col s12">
        <select id="perfilb" name="perfilb" class="validate">
            <option value="" selected>Seleccione...</option>
            @foreach($perfiles as $p)
                <option value="{{ $p->id }}">{{ $p->descripcion }}</option>
            @endforeach
        </select>
        <label for="perfilb" class="center-align">Perfil</label>
    </div>
    <div class="input-field col s12"><br>
        <a onclick="save_userb()" class="btn green">Guardar</a>
    </div>
</div>
</form>
<script>$("#perfilb").material_select()</script>
