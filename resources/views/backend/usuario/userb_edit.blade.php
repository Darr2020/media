¡<form class="col s12" id="form_edituserb" name="form_edituserb" method="Post"><br><br>
<h4 class="center">Editar Usuario | backend</h4>
  <div class="col s12"><br>
  <div class="col s12 divider"></div></div>
  <div class="row">
    <div class="input-field col s12"><br>
      <span class="center-align">Nombre</span>
        <input id="nombreb" name="nombreb" type="text" class="validate" minlength="5" onkeypress="return sololetras(event)" value="{{ $usuario[0]->nombre}}">
    </div>
    <div class="col s12 input-field">
      <select id="perfilb" name="perfilb" class="materialize-select">
          @foreach($perfiles as $p)
              <option value="{{ $p->id }}" @if($usuario[0]->perfil_id == $p->id) selected @endif>{{ $p->descripcion }}</option>
          @endforeach
      </select>
      <label for="perfilb" class="center-align">Perfil</label>
    </div>
    <div class="input-field col s12"><br>
      <span class="center-align">Correo</span>
        <input id="correob" name="correob" type="email" class="validate" minlength="10" maxlength="120" value="{{ $usuario[0]->correo}}">
    </div>
    <div class="input-field col s12"><br>
    <input id="user_id" name="user_id" type="hidden" value="{{ $usuario[0]->id}}">                  
        <a onclick="save_editUserb()" class="btn green">Guardar</a>
    </div>
</div>
</form>
<script>$("#perfilb").material_select()</script>