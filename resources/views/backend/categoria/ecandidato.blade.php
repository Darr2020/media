<div class="col s12 m12 l12">
    <form id="editcand" name="editcand">
        <input id="contador" name="contador" type="hidden"/>
        <h4 class="header">Editar el Candidato: {{$params['data']['candidato'][0]->nombrecandidato}}</h4>
        <div class="row">
            <div class="col s12 m12 l12" style="padding: 0px;">
                <div id="d" class="col s12 m8 l8 waves-effect waves-light btn gradient-45deg-red-pink z-depth-4 mr-1 bordde">
                    <a href="javascript:void(0);" onclick="dt()" style="color: #fff !important; font-size: 18px;">Datos Básicos</a>
                    <input type="hidden" name="a1" id="a1" value="1">
                </div>
                @if($params['data']['generos'] != false)
                <div id="g" class="col s12 m1 l1 waves-effect waves-light btn gradient-45deg-light-blue-cyan z-depth-4 mr-1 bordde">
                    <a href="javascript:void(0);" onclick="gen()" style="color: #fff !important; font-size: 18px;">Géneros del Candidato</a>
                    <input type="hidden" name="a2" id="a2" value="2">
                </div>
                @endif
                @if($params['data']['redes'] != false || $params['data']['candidato'][0]->pag != null || $params['data']['candidato'][0]->seguidores != null)
                <div id="c" class="col s12 m1 l1 waves-effect waves-light btn gradient-45deg-amber-amber z-depth-4 mr-1 bordde">
                    <a href="javascript:void(0);" onclick="op()" style="color: #fff !important; font-size: 18px;">Redes Sociales</a>
                    <input type="hidden" name="a3" id="a3" value="3">
                </div>
                @endif
                @if($params['data']['multimedia'] != false)
                <div id="m" class="col s12 m1 l1 waves-effect waves-light btn gradient-45deg-green-teal z-depth-4 mr-1 bordde">
                    <a href="javascript:void(0);" onclick="mul()" style="color: #fff !important; font-size: 18px;">Multimedia</a>
                    <input type="hidden" name="a4" id="a4" value="4">
                </div>
                @endif
            </div>
            <br><br>
            <div class="divider"></div>
            <!--Primera parte: Editar Datos Básicos-->
            <div id="datoscand" class="col s12">
                @if ($params['data']['candidato'][0]->detalle != '')
                <br> <br>
                <font style="font-weight: bold;">Información del Candidato:</font>
                <p class="text-justify">
                    <input class="fomul" type="text" id="infor" name="infor" value="{{$params['data']['candidato'][0]->detalle}}"/><label for="infor"></label>
                    <br> <br> 
                </p>
                @endif
                @if ($params['data']['candidato'][0]->sexo != 0)
                <br> <br>
                <font style="font-weight: bold;">Sexo del Candidato:</font>
                <p class="text-justify">
                    @if($params['data']['candidato'][0]->sexo == 1)
                    <input type="radio" name="gen"  id="fem" value="1" class="with-gap fomul genn" checked="checked"/>
                    <label for="fem">Femenino</label>
                    <br>
                    <input class="with-gap fomul genn" id="mas" name="gen" type="radio" value="2" />
                    <label for="mas">Masculino</label>
                    <br>
                    <input class="with-gap fomul genn" id="mixx" name="gen" type="radio" value="3" />
                    <label for="mixx">Mixto</label>
                    <br><br>
                    @elseif($params['data']['candidato'][0]->sexo == 2)
                    <input type="radio" name="gen"  id="fem" value="1" class="with-gap fomul genn"/>
                    <label for="fem">Femenino</label>
                    <br>
                    <input class="with-gap fomul genn" id="mas" name="gen" type="radio" value="2" checked="checked" />
                    <label for="mas">Masculino</label>
                    <br>
                    <input class="with-gap fomul genn" id="mixx" name="gen" type="radio" value="3" />
                    <label for="mixx">Mixto</label>
                    <br><br>
                    @elseif($params['data']['candidato'][0]->sexo == 3)
                    <input type="radio" name="gen"  id="fem" value="1" class="with-gap fomul genn"/>
                    <label for="fem">Femenino</label>
                    <br>
                    <input class="with-gap fomul genn" id="mas" name="gen" type="radio" value="0" />
                    <label for="mas">Masculino</label>
                    <br>
                    <input class="with-gap fomul genn" id="mixx" name="gen" type="radio" value="3" checked="checked" />
                    <label for="mixx">Mixto</label>
                    <br><br>
                    @endif
                    <br> <br> 
                </p>
                @endif
                <div class="input-field col s12 m12 l12">
                    <br><br><br>
                    <div class="divider"></div>
                    @if($params['data']['generos'] != false || $params['data']['redes'] != false || $params['data']['candidato'][0]->pag != null || $params['data']['candidato'][0]->seguidores != null || $params['data']['multimedia'] != false)
                    <div id="verif" class="input-field col col s12 m12 l12">
                        <a href="javascript:void(0);" onclick="editarCandidato(1)" class="btn cyan waves-effect waves-light right">Guardar y Continuar <i class="material-icons right">save</i></a>
                    </div>
                    @else
                    <div id="enviar" class="input-field col col s12 m12 l12">
                        <a href="javascript:void(0);" onclick="editarCandidato(1)" class="btn cyan waves-effect waves-light right">Guardar <i class="material-icons right">save</i></a>
                    </div>
                    @endif
                </div>
            </div>
            <!--Fin Primera parte: Editar Datos Básicos-->
            <!--Segunda parte: Géneros del Candidato-->
            <div id="generoscand" class="col s12" style="display: none;">
                <br> <br>
                @if($params['data']['generos'] != false)
                <font style="font-weight: bold;">Géneros del Candidato:</font>                    
                <p class="text-justify">
                    <?php $cont = 0; ?>
                    @if($params['data']['generos']!=false)
                    @foreach($params['data']['generos'] as $key =>$gc)
                <div class="col s8 m8 l8 gennnn">{{$gc->nombregenero}}</div>
                <div class="col s4 m4 l4 gennnn">
                    <input class="gennnn" type="checkbox" id="generoArt[{{$cont}}]" name="generoArt" value="{{$gc->gen_id}}" checked="checked" />
                    <label for="generoArt[{{$cont}}]"></label>
                </div>
                <?php $cont++ ?>
                @endforeach
                @endif
                <br>
                <?php $contt = $cont; ?>
                @if($params['data']['genero']!=false)
                @foreach($params['data']['genero'] as $key =>$g)
                <div class="col s8 m8 l8 gennnn">{{$g->nombregenero}}</div>
                <div class="col s4 m4 l4 gennnn">
                    <input class="gennnn" type="checkbox" id="generoArt[{{$contt}}]" name="generoArt" value="{{$g->id}}"/>
                    <label for="generoArt[{{$contt}}]"></label>
                </div>
                <?php $contt++ ?>
                @endforeach
                @endif
                <br>
                </p>
                @endif
                <div class="input-field col s12 m12 l12">
                    <br><br><br>
                    <div class="divider"></div>
                    @if($params['data']['redes'] != false || $params['data']['candidato'][0]->pag != null || $params['data']['candidato'][0]->seguidores != null || $params['data']['multimedia'] != false)
                    <div id="verif" class="input-field col col s12 m12 l12">
                        <a href="javascript:void(0);" onclick="editarCandidato(2)" class="btn cyan waves-effect waves-light right">Guardar y Continuar <i class="material-icons right">save</i></a>
                    </div>
                    @else
                    <div id="enviar" class="input-field col col s12 m12 l12">
                        <a href="javascript:void(0);" onclick="editarCandidato(2)" class="btn cyan waves-effect waves-light right">Guardar <i class="material-icons right">save</i></a>
                    </div>
                    @endif
                </div>
            </div>
            <!--Fin Segunda parte: Géneros del Candidato-->
            <!--Tercera parte: Redes Sociales-->
            <div id="redescand" class="col s12" style="display: none;">
                <br> <br>
                @if ($params['data']['candidato'][0]->pag != null)
                <font style="font-weight: bold;">Página Web del Candidato:</font>
                <p class="text-justify">
                    <input class="fomul" type="text" id="pag" name="pag" value="{{$params['data']['candidato'][0]->pag}}" /><label for="pag"></label>
                    <br> <br> 
                </p>
                @endif
                @if ($params['data']['candidato'][0]->seguidores != null)
                <font style="font-weight: bold;">Nro de seguidores del Candidato:</font>
                <p class="text-justify">
                    <input class="fomul" type="text" id="seg" name="seg" value="{{$params['data']['candidato'][0]->seguidores}}" /><label for="seg"></label>                     
                    <br> <br> 
                </p>
                @endif
                @if($params['data']['redes'] != false)
                <font style="font-weight: bold;">Redes Sociales del Candidato:</font>                    
                <p class="text-justify">
                <div class="col s12 m7 l7">
                    <?php $a = 0; ?>
                    @foreach($params['data']['redes'] as $key =>$r)
                    <input type="text" class="redessoc" id="redes[{{$a}}]" name="redes" value="{{$r->nombreredes}}" />
                    <?php $a++ ?>
                    @endforeach
                </div>
                <div class="col s12 m7 l7" id="camposgen">
                    <label for="redes"></label>
                </div>
                <input type="hidden" id="agrnext" value="{{$a-1}}" />
                </p>
                <div class="input-field col s12">
                    <div class="col col s12 m5 l5 left">
                        <a href="javascript:void(0);" onclick="agregarredes()" class="btn purple" style="margin-right: 2%;">Agregar otra Red Social<i class="material-icons right" style="line-height: 35px;">add_to_photos</i>
                        </a>
                        <br><br>
                    </div>
                    <div class="col col s12 m7 l7 left">
                        <a href="javascript:void(0);" onclick="eliminarredes()" class="btn orange" style="margin-right: 2%;">Eliminar<i class="material-icons right" style="line-height: 35px;">indeterminate_check_box</i>
                        </a>
                        <br><br>
                    </div>
                </div>
                @endif
                <div class="input-field col s12 m12 l12">
                    <br><br><br>
                    <div class="divider"></div>
                    @if($params['data']['multimedia'] != false)
                    <div id="verif" class="input-field col col s12 m12 l12">
                        <a href="javascript:void(0);" onclick="editarCandidato(3)" class="btn cyan waves-effect waves-light right">Guardar y Continuar <i class="material-icons right">save</i></a>
                    </div>
                    @else
                    <div id="enviar" class="input-field col col s12 m12 l12">
                        <a href="javascript:void(0);" onclick="editarCandidato(3)" class="btn cyan waves-effect waves-light right">Guardar <i class="material-icons right">save</i></a>
                    </div>
                    @endif
                </div>
            </div>
            <!--Fin Tercera parte: Redes Sociales-->
            <!--Cuarta parte: Multimedia-->
            <div id="multicand" class="col s12" style="display: none;">
                <br> <br>
                @if($params['data']['multimedia'] != false)
                @if ($params['data']['multimedia'][0]->empresa != null)
                <font style="font-weight: bold;">Empresa donde se desempaña el Candidato:</font>
                <br><br>
                <p class="text-justify">
                    <input class="fomul" type="text" id="cia" name="cia" /><label for="cia"></label>
                    <br><br>
                    <br> <br> 
                </p>
                @endif
                @if ($params['data']['multimedia'][0]->img != null)
                <font style="font-weight: bold;">Imágen del Candidato:</font>
                <br><br>
                <p class="text-center">
                <div class="file-field input-field">
                    <div class="btn">
                        <span>Imagen</span>
                        <input type="file" href="javascript:void(0);" onchange="cambioimg()" id="imgg" name="imgg" accept="image/*">
                    </div>
                    <div class="file-path-wrapper">
                        <input class="file-path validate fomul" type="text">
                    </div>
                </div>
                </p>
                @endif
                @if ($params['data']['multimedia'][0]->audio != null)
                <font style="font-weight: bold;">Audio del Candidato:</font>
                <br><br>
                <p class="text-justify">
                <div class="file-field input-field">
                    <div class="btn">
                        <span>Audio</span>
                        <input type="file" id="aud" name="aud" accept="audio/*">
                    </div>
                    <div class="file-path-wrapper">
                        <input class="file-path validate fomul" type="text">
                    </div>
                </div>
                <br><br>
                </p>
                @endif
                @if ($params['data']['multimedia'][0]->video != null)
                <font style="font-weight: bold;">Ruta del Video:</font>
                <p class="text-center">
                    <input class="fomul" id="video" name="video" type="text"/><label for="video"></label>
                    <br><br>
                </p>
                @endif                 
                @endif
                <div class="input-field col s12 m12 l12">
                    <br><br><br>
                    <div class="divider"></div>
                    <div id="enviar" class="input-field col col s12 m12 l12">
                        <a href="javascript:void(0);" onclick="editarCandidato(4)" class="btn cyan waves-effect waves-light right">Guardar <i class="material-icons right">save</i></a>
                    </div>
                </div>
            </div>
            <!--Fin Cuarta parte: Multimedia-->
            <input type="hidden" id="cand_id" name="cand_id" value="{{$params['data']['candidato'][0]->id}}" />
        </div>
    </form>
</div>
