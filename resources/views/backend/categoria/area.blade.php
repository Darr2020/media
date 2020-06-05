@extends("backend.layout.layout")
@section("title", "MediaMétrica | Crear Candidatos u Opciones")
@section('stylesheets')
@parent
@endsection
@section("body")
<div id="breadcrumbs-wrapper">
    <div class="container">
        <div class="row">
            <div class="col s12 m12 l12">
                <h5 class="breadcrumbs-title">Categorias</h5>
                <ol class="breadcrumbs">
                    <li><a href="#">Administración de categorias</a>
                    </li>
                    <li class="active">Registrar Candidatos u Opciones
                    </li>
                </ol>
            </div>
        </div>
    </div>
</div>
<div class="container">
    <div class="section">
        <p class="caption">Modulo para la administración de categorias.</p>
        <div class="divider"></div>
        <div class="row">
            @if ($params['data']['categ']!=false)
            <div class="col s12 m12 l12">
                <div class="card-panel">
                    <div class="row">
                        <form id="forcandop" name="forcandop" action="{{ url('crearCandidato/')}}" method="POST" enctype="multipart/form-data">
                            <input id="contador" name="contador" type="hidden"/>
                            <div class="col s12 m6 l6">
                                Seleccione la categoria
                                <select class="input-field" name="categ" id="categ" >
                                    <option value="0" selected>Seleccione...</option>
                                    @foreach($params['data']['categ'] as $categ)
                                    <option value ="{{$categ->id}}" >{{$categ->nombre}}</option>
                                    @endforeach
                                </select>
                                <label for="categ"></label>
                            </div>
                            <div id="opcfr" class="col s12">
                                <div id="1" class="input-field col s12 m6 l6" style="display: none;">
                                    Nombre del candidato u opción <a id="buscarcand" name="buscarcand"><i class="material-icons btn cyan waves-effect waves-light right" style="line-height: 1.5;">find_replace</i></a>
                                    <input class="fomul" id="nombree" name="nombree" type="text"/><label for="nombre"></label>
                                    <br><br>
                                </div>
                                <div id="nuevo" class="col s12 m12 l12" style="display: none;">
                                    <div  id="2" class="col s12 m6 l6" style="display: none;">
                                        Información del Candidato u opción
                                        <input class="fomul" type="text" id="inforr" name="inforr" maxlength="250" placeholder="Máximo de caracteres permitidos 250" /><label for="inforr"></label>
                                        <br><br>
                                    </div>
                                    <div id="3" class="col s12 m6 l6" style="display: none;">
                                        Género Persona
                                        <br><br>
                                        <input type="radio" name="gen"  id="femm" value="1" class="with-gap fomul genn">
                                        <label for="femm">Femenino</label>
                                        <br>
                                        <input class="with-gap fomul genn" id="mass" name="gen" type="radio" value="2" />
                                        <label for="mass">Masculino</label>
                                        <br>
                                        <input class="with-gap fomul genn" id="mixx" name="gen" type="radio" value="3" />
                                        <label for="mixx">Mixto</label>
                                        <br><br>
                                    </div>
                                    <div id="6" class="col s12 m12 l12" style="display: none;">
                                        Audio
                                        <div class="file-field input-field">
                                            <div class="btn">
                                                <span>Audio</span>
                                                <input type="file" id="audd" name="audd" accept="audio/*">
                                            </div>
                                            <div class="file-path-wrapper">
                                                <input class="file-path validate fomul" type="text">
                                            </div>
                                        </div>
                                        <br><br>
                                    </div>
                                    <div id="7" class="col s12 m6 l6" style="display: none;">
                                        Ruta del Video
                                        <input class="fomul" id="videoo" name="videoo" type="text"/><label for="videoo"></label>
                                        <br><br>
                                    </div>
                                    <div id="9" class="col s12 m6 l6" style="display: none;">
                                        Página WEB 
                                        <input class="fomul" type="text" id="pagg" name="pagg" /><label for="pagg"></label>
                                        <br><br>
                                    </div>
                                    <div id="10" class="col s12 m6 l6" style="display: none;">
                                        Nombre de la compañia 
                                        <input class="fomul" type="text" id="ciaa" name="ciaa" /><label for="ciaa"></label>
                                        <br><br>
                                    </div>
                                    <div id="11" class="col s12 m6 l6" style="display: none;">
                                        Nº seguidores
                                        <input class="fomul" type="text" id="segg" name="segg" /><label for="segg"></label>
                                        <br><br>
                                    </div> 
                                    <div id="5" class="col s12 m6 l6" style="display: none;">
                                        <div class="col s12 m12 l12">
                                            Imágen
                                            <br><br>
                                            <input type="file" id="imggg" name="imggg" class="dropify fomul" accept="image/*"/>
                                        </div>
                                        <br><br>
                                    </div>
                                    <div id="4" class="col s12 m6 l6" style="display: none;">
                                        Géneros de la Categoria
                                        <br><br>
                                        <div id="generoArtt">

                                        </div>
                                        <br><br>
                                    </div>
                                    <div id="8" class="col s12 m12 l12" style="display: none;">
                                        <div class="col s12 m6 l6" id="camposgenn">
                                            <br><br>
                                            Redes Sociales
                                            <label for="redess"></label>
                                        </div>
                                        <br><br>
                                    </div>
                                    <div class="input-field col s12">
                                        <div class="col col s12 m5 l5 left">
                                            <a id="agregarRedes" name="agregarRedes" class="btn purple" style="margin-right: 2%;display:none;">Agregar otra Red Social<i class="material-icons right" style="line-height: 35px;">add_to_photos</i>
                                            </a>
                                            <br><br>
                                        </div>
                                        <div class="col col s12 m7 l7 left">
                                            <a id="eliminarRedes" name="eliminarRedes" class="btn orange" style="margin-right: 2%;display:none;">Eliminar<i class="material-icons right" style="line-height: 35px;">indeterminate_check_box</i>
                                            </a>
                                            <br><br>
                                        </div>
                                    </div>
                                    <div class="input-field col s12 m12 l12">
                                        <div class="input-field col s12 m2 offset-m10 l2 offset-l10 right">
                                            <a id="guardarcand" name="guardarcand" class="btn cyan waves-effect waves-light" style="display: none;">Guardar <i class="material-icons right">save</i></a>
                                        </div>
                                    </div>
                                </div>
                                <div id="editar" class="col s12" style="display: none;">
                                    Se encontró conincidencia en la busqueda del candidato desea editarlo?
                                    <br><br>
                                    <div class="col s12 m12 l12" id="editables">

                                    </div>
                                </div>
                            </div>
                            {{ csrf_field()}}
                        </form>
                    </div>
                </div>
            </div>
            @else
            <div class="col s12 m12 l12">
                <div class="card-panel">
                    <div class="row">
                        <h4>No hay Categorias Cargadas, cree categorias nuevas e intente de nuevo.</h4>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
<!-- START MODAL -->
<div id="myModal" class="modal bordde" style="width: 70%;">
    <div class="modal-content">
        <div class="modal-body z-depth-5 bordde" id="cuerpo">

        </div>
    </div>
    <!-- END MODAL CONTANT -->

    <div class="modal-footer" style="margin-bottom: 15px; margin-top: 10px;">
        <a href="javascript:void(0);" class="modal-action modal-close waves-effect waves-red btn-flat orange white-text">Cerrar</a>
    </div>
</div>
<!-- END MODAL -->
@endsection
@section('javascripts')
@parent
@endsection