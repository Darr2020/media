<div id="publicacion" class="col s12" style="margin-top:20px">
  <form id="noticias-form" name="noticiasForm" novalidate>
    <div class="input-field col s12">
        <input placeholder="Escribír aqui el título de la noticia" id="titulo" ng-maxlength="50" maxlength="50" data-length="50" name="titulo" class="validate" ng-model="titulo" type="text" required>
        <label for="titulo">Título de la Noticia</label>
    </div>
    <span ng-show="titulo == null || titulo.length > 50" class="error-view">Titulo de noticia <b>invalido</b></span>
    <div class="row">
        <div class="col s12 radios">
            <h6>Posición de Titulo</h6>
            <p>
                <input type="radio" ng-model="title_position" ng-required="!title_position" id="se" value="se">
                <label for="se">Superior-externo</label>
            </p>
            <p>
                <input type="radio" ng-model="title_position" ng-required="!title_position" id="ie" value="ie">
                <label for="ie">Inferior-externo</label>
            </p>
            <p>
                <input type="radio" ng-model="title_position" ng-required="!title_position" id="si" value="si">
                <label for="si">Superior-interno</label>
            </p>
            <p>
                <input type="radio" ng-model="title_position" ng-required="!title_position" id="ci" value="ci">
                <label for="ci">Central-interno</label>
            </p>
            <p>
                <input type="radio" ng-model="title_position" ng-required="!title_position" id="ii" value="ii">
                <label for="ii">Inferior-interno</label>
            </p>
        </div>
        <span ng-show="noticiasForm.title_position.$invalid" class="error-view">Posición de Titulo <b>invalido</b></span>
    </div>
    <div class="col s4">
        <div class="input-field" id="tagSelecter">
            <i class="material-icons" ng-click="addTag($event)">fast_forward</i>
            <input id="tag-input" data-length="20" maxlength="20" type="text" list="taglist" required>
            <label for="tags">Tags</label>
        </div>
        <span ng-show="tags.length == 0 || tags.length > 20" class="error-view">Etiquetas de identificación <b>Requeridas</b></span>
    </div>
    <div class="col s8" id="tagDumper"></div>
    <datalist id="taglist">
        <option value="@{{ x.nombre }}" ng-repeat="x in t">@{{ x.nombre }}</option>
    </datalist>
    <div class="col s12 input-field">
        <select id="categoria" ng-model="categoria" class="validate" required>
            @foreach($categorias as $c)
            <option value="{{ $c->id }}">{{ $c->nombre }}</option>
            @endforeach
        </select>
        <label for="categoria">Seleccione una categoria</label>
        <span ng-show="categoria == null" class="error-view">Categoria valida <b>requerida</b></span>
    </div>
    <div class="col s12 input-field">
        <textarea id="descripcion" class="materialize-textarea" ng-model="descripcion" name="descripcion" ng-maxlength="300" data-length="300" required></textarea>
        <label for="descripcion">Agregar una Descripción</label>
        <span ng-show="descripcion == null || descripcion.length > 300" class="error-view">Descripcion valida <b>requerida</b></span>
      </div>
    <div class="padding">
        <div class="col s12 input-field">
          <textarea id="contenido" ng-model="contenido"></textarea>
        </div>
    </div>
  </form>
</div>