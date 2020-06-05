<div class="col s12 m12 l12">
    <form id="editcat" name="editcat">
        <input id="contador" name="contador" type="hidden"/>
        <h4 class="header">Editar la Categoria: {{$params['data']['categoria'][0]->nombre}}</h4>
        <div class="row">
            <div class="col s12 m12 l12" style="padding: 0px;">
                <div id="d" class="col s12 m8 l8 waves-effect waves-light btn gradient-45deg-red-pink z-depth-4 mr-1 bordde">
                    <a href="javascript:void(0);" onclick="dt()" style="color: #fff !important; font-size: 18px;">Datos Básicos</a>
                </div>
                <div id="c" class="col s12 m1 l1 waves-effect waves-light btn gradient-45deg-green-teal z-depth-4 mr-1 bordde">
                    <a href="javascript:void(0);" onclick="op()" style="color: #fff !important; font-size: 18px;">Opciones o Campos</a>
                </div>
            </div>
            <br><br><br>
            <div class="divider"></div>
            <div id="datos" class="col s12">
                <br> <br>
                <font style="font-weight: bold;">Descripción de la categoría:</font>
                <p class="text-justify">
                    <textarea id= "desCateg"  name="desCateg" class="materialize-textarea bloq">{{$params['data']['categoria'][0]->descateg}}</textarea>
                    <br> <br> 
                </p>

                <font style="font-weight: bold;">Descripción del tipo de Candidato:</font>
                <p class="text-justify">
                    <textarea id= "desCand" name="desCand" class="materialize-textarea bloq">{{$params['data']['categoria'][0]->descand}}</textarea>
                    <br> <br> <br> <br> 
                </p>
            </div>
            <div id="campos" class="col s12" style="display: none;">
                <br> <br>
                <font style="font-weight: bold;">Campos requeridos:</font>
                <p class="text-justify">
                    @foreach($params['data']['opciones'] as $key =>$r)
                <div class="col s6 m8 l8">
                    Nombre del candidato u opción:
                </div>
                <div class="col s6 m3 l3">
                    <input  class="with-gap" id="nombre" name="nombre" type="radio" checked="checked" /><label for="nombre"></label><br>
                </div>
                <div class="col s6 m8 l8">
                    Información del Candidatos u opcion:
                </div>
                <div class="col s6 m3 l3">
                    @if($r->infor == true)
                    <input type="checkbox" id="infor" name="infor" checked="checked" /><label for="infor"></label><br>
                    @else
                    <input type="checkbox" id="infor" name="infor"/><label for="infor"></label><br>
                    @endif
                </div>
                <div class="col s6 m8 l8">
                    Género persona (Femenino - Masculino): 
                </div>
                <div class="col s6 m3 l3">
                    @if($r->gen == true)
                    <input type="checkbox" id="gen" name="gen" checked="checked" /><label for="gen"></label><br>
                    @else
                    <input type="checkbox" id="gen" name="gen"/><label for="gen"></label><br>
                    @endif
                </div>
                <div class="col s6 m8 l8">
                    Género de la Categoria:
                </div>
                <div class="col s6 m3 l3">
                    @if($r->generoart == true)
                    <input type="checkbox" onclick="hgenart()" id="generoArt" name="generoArt" checked="checked" /><label for="generoArt"></label><br>
                    @else
                    <input type="checkbox" onclick="hgenart()" id="generoArt" name="generoArt"/><label for="generoArt"></label><br>
                    @endif
                </div>
                <div class="col s6 m8 l8">
                    Imagen: 
                </div>
                <div class="col s6 m3 l3">
                    <input class="with-gap" type="radio" id="img" name="img" checked="checked"/><label for="img"></label>
                </div>
                <div class="col s6 m8 l8">
                    Audio:
                </div>
                <div class="col s6 m3 l3">
                    @if($r->audio == true)
                    <input type="checkbox" id="audio" name="audio" checked="checked" /><label for="audio"></label><br>
                    @else
                    <input type="checkbox" id="audio" name="audio"/><label for="audio"></label><br>
                    @endif
                </div>
                <div class="col s6 m8 l8">
                    Video: 
                </div>
                <div class="col s6 m3 l3">
                    @if($r->video == true)
                    <input type="checkbox" id="video" name="video" checked="checked" /><label for="video"></label><br>
                    @else
                    <input type="checkbox" id="video" name="video"/><label for="video"></label><br>
                    @endif
                </div>
                <div class="col s6 m8 l8">
                    Redes Sociales del Candidato: 
                </div>
                <div class="col s6 m3 l3">
                    @if($r->redes == true)
                    <input type="checkbox" id="redes" name="redes" checked="checked" /><label for="redes"></label><br>
                    @else
                    <input type="checkbox" id="redes" name="redes"/><label for="redes"></label><br>
                    @endif
                </div>
                <div class="col s6 m8 l8">
                    Página web del Candidato: 
                </div>
                <div class="col s6 m3 l3">
                    @if($r->pag == true)
                    <input type="checkbox" id="pag" name="pag" checked="checked" /><label for="pag"></label><br>
                    @else
                    <input type="checkbox" id="pag" name="pag"/><label for="pag"></label><br>
                    @endif
                </div>
                <div class="col s6 m8 l8">
                    Nro de Seguidores del Candidato: 
                </div>
                <div class="col s6 m3 l3">
                    @if($r->gen == true)
                    <input type="checkbox" id="seg" name="seg" checked="checked" /><label for="seg"></label><br>
                    @else
                    <input type="checkbox" id="seg" name="seg"/><label for="seg"></label><br>
                    @endif
                </div>
                <div class="col s6 m8 l8">
                    Compañia donde se desempeña el Candidato: 
                </div>
                <div class="col s6 m3 l3">
                    @if($r->cia == true)
                    <input type="checkbox" id="cia" name="cia" checked="checked" /><label for="cia"></label><br>
                    @else
                    <input type="checkbox" id="cia" name="cia"/><label for="cia"></label><br>
                    @endif
                </div>
                @endforeach
                </p>
                <br> <br>
                <div id="genero" class="col s12">
                    @if($params['data']['generos'] != false)
                    <div id="genArt" class="input-field col s10">
                        <div class="input-field col s6 tooltipped" data-position="top" data-delay="50" data-tooltip="Agregar Géneros ">
                            <br> <br>
                            <font style="font-weight: bold;">Géneros de la Categoria:</font>                    
                            <?php $nextinput = count($params['data']['generos']) ?>
                            <input type="text" class="genr" id="generosArt0" name="generosArt[0]" 
                                   value="<?php echo $params['data']['generos'][0]->nomgenero; ?>"/>
                            @for($a = 1; $a < $nextinput; $a++)
                            <input type="text" class="genr" id="generosArt{{$a}}" name="generosArt[{{$a}}]" value="{{$params['data']['generos'][$a]->nomgenero}}" />
                            @endfor
                            <div id="camposed">
                                <label for="genArt"></label>
                            </div>
                            <input type="hidden" id="agrnext" value="{{$a-1}}" />
                        </div>
                    </div>
                    <div class="col col s12 m6 l6 left">
                        <a href="javascript:void(0);" onclick="agregar()" class="btn purple tooltipped" data-position="right" data-delay="50" data-tooltip="Agregar otro Género" style="margin-right: 2%;">Agregar otro Género<i class="material-icons right" style="line-height: 35px;">add_to_photos</i>
                        </a>
                        <br><br>
                    </div>
                    <div class="col col s12 m6 l6 left">
                        <a href="javascript:void(0);" onclick="eliminarGenArt()" class="btn orange" style="margin-right: 2%;">Eliminar<i class="material-icons right" style="line-height: 35px;">indeterminate_check_box</i>
                        </a>
                        <br><br>
                    </div>
                    @endif
                </div>
            </div>
            @if($params['data']['generos'] != false)
            <input type="hidden" id="gener" name="gener" value="1" /> 
            @else
            <input type="hidden" id="gener" name="gener" value="0" /> 
            @endif
            <div id="generosnuevos" class="col s12" style="display: none;">
                <div id="genArt" class="input-field col s10">
                    <div class="input-field col s6 tooltipped" data-position="top" data-delay="50" data-tooltip="Agregar Géneros ">
                        <br> <br>
                        <font style="font-weight: bold;">Géneros de la Categoria:</font>                    
                        <?php $nextinput = 0 ?>


                        <input type="text" class="genr" id="generosArt{{$nextinput}}" name="generosArt[{{$nextinput}}]"/>

                        <div id="camposed">
                            <label for="genArt"></label>
                        </div>
                    </div>
                </div>
                <div class="col col s12 m6 l6 left">
                    <a href="javascript:void(0);" onclick="agregar()" class="btn purple tooltipped" data-position="right" data-delay="50" data-tooltip="Agregar otro Género" style="margin-right: 2%;">Agregar otro Género<i class="material-icons right" style="line-height: 35px;">add_to_photos</i>
                    </a>
                    <br><br>
                </div>
                <div class="col col s12 m6 l6 left">
                    <a href="javascript:void(0);" onclick="eliminarGenArt()" name="eliminarRedes" class="btn orange" style="margin-right: 2%;">Eliminar<i class="material-icons right" style="line-height: 35px;">indeterminate_check_box</i>
                    </a>
                    <br><br>
                </div>
            </div>
            <input type="hidden" id="agrnext" value="{{$nextinput}}" />
            <input type="hidden" id="tipo" name="tipo" value="2" />
            <input type="hidden" id="cat_id" name="cat_id" value="{{$params['data']['categoria'][0]->id}}" />
            <div class="input-field col s12 m12 l12">
                <br><br><br>
                <div class="divider"></div>
                <div id="verif" class="input-field col col s12 m12 l12">
                    <a href="javascript:void(0);" onclick="editarCategoria()" class="btn cyan waves-effect waves-light right">Guardar <i class="material-icons right">save</i></a>
                </div>
                <div id="enviar" class="input-field col col s12 m12 l12">

                </div>
            </div>
        </div>
    </form>  
</div>
@section('javascripts')
@parent
@endsection