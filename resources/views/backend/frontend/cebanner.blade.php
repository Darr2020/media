

@if($params['opt'] == 1)
<div class="col s12 m12 l12">
    <form id="editcand" name="editcand">
        <input id="contador" name="contador" type="hidden"/>
        <h4 class="header">Agregar un nuevo banner</h4>
        <div class="row">
            <div class="col s12 m12 l12">
                <br>
                <h5 style="color: #8e24aa;">Cargar imagen</h5>
                <br>
                <div class="divider"></div>
                <br>
                <div id="vimg" class="file-field input-field">
                    <div class="btn">
                        <span>Imagen</span>
                        <input type="file" href="javascript:void(0);" onchange="cambioimg()" id="imgg" name="imgg" accept="image/*">
                    </div>
                    <div class="file-path-wrapper">
                        <input class="file-path validate fomul" type="text">
                    </div>
                </div>
                <br>
            </div>
            <div id="pos" class="col s12 m12 l6">
                <h5 style="color: #8e24aa;">Seleccionar Posición</h5>
                <br>
                <div class="divider"></div>
                <br>
                <select name="posicion_id" id="posicion_id" >
                    <option value="0" selected>Seleccione...</option>
                    @foreach($params['posicionnew'] as $pos)
                    <option value ="{{$pos->id}}" >{{$pos->id}}</option>
                    @endforeach
                </select>
                <label for="posicion_id"></label>
                <br>
            </div>
            <div class="input-field col s12 m12 l12">
                <br><br><br>
                <div class="divider"></div>
                <div id="enviar" class="input-field col col s12 m12 l12">
                    <a href="javascript:void(0);" onclick="editarBanner(1)" class="btn cyan waves-effect waves-light right">Guardar <i class="material-icons right">save</i></a>
                </div>
            </div>
        </div>
    </form>
</div>
@elseif($params['opt'] == 4)
<div class="col s12 m12 l12">
    <form id="editcand" name="editcand">
        <input id="contador" name="contador" type="hidden"/>
        <h4 class="header">Cambiar imagen</h4>
        <div class="row">
            <div class="col s12 m12 l6">
                <h5 style="color: #8e24aa;">Imagen Actual</h5>
                <br>
                <div class="divider"></div>
                <br>
                <img width="400px" height="200px" src="{{ asset("images/gallary/".$params['bannerid'][0]->imagen) }}">
                <br>
            </div>
            <div class="col s12 m12 l6">
                <h5 style="color: #8e24aa;">Cargar nueva imagen</h5>
                <br>
                <div class="divider"></div>
                <br>
                <div id="vimg" class="file-field input-field">
                    <div class="btn">
                        <span>Imagen</span>
                        <input type="file" href="javascript:void(0);" onchange="cambioimg()" id="imgg" name="imgg" accept="image/*">
                    </div>
                    <div class="file-path-wrapper">
                        <input class="file-path validate fomul" type="text">
                    </div>
                </div>
                <br>
            </div>        
            <div id="pos" class="input-field col s12 m12 l6">
                <h5 style="color: #8e24aa;">Seleccionar Posición</h5>
                <br>
                <div class="divider"></div>
                <br>
                <select class="col s2 m2 offset-m5 l2 offset-l5 center" name="posicion_id" id="posicion_id">
                    <option value="0" selected>Seleccione...</option>
                    @foreach($params['posicionuod'] as $pos)
                    @if($pos->id == $params['bannerid'][0]->posicion_id )
                    <option value="{{$pos->id}}" selected="selected">{{$pos->id }}</option>
                    @else
                    <option value ="{{$pos->id}}" >{{$pos->id}}</option>
                    @endif
                    @endforeach
                </select>
                <label for="posicion_id"></label>
                <br>
            </div>
            <div class="input-field col s12 m12 l12">
                <br><br><br>
                <div class="divider"></div>
                <div id="enviar" class="input-field col col s12 m12 l12">
                    <a href="javascript:void(0);" onclick="editarBanner(2)" class="btn cyan waves-effect waves-light right">Guardar <i class="material-icons right">save</i></a>
                </div>
            </div>
            <input type="hidden" id="banner_id" name="banner_id" value="{{$params['bannerid'][0]->id}}" />
        </div>
    </form>
</div>
@endif
