@extends("backend.layout.layout")
@section("title", "MediaMétrica | Crear Categorias")
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
                    <li class="active">Crear Categorias
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
            <div class="col s12 m12 l12">
                <div class="card-panel">
                    <div class="row">
                        <form name="svcat" id="svcat">
                            <input id="contador" name="contador" type="hidden"/>
                            <div class="input-field col s12 m12 l12">
                                <input class="bloq" id="nomCatg" name="nomCatg" type="text" placeholder="Ejemplos: Artistas">
                                <label for="nomCatg">Nombre de la Categoría</label>
                                <div class="errornomCatg"></div>
                            </div>
                            <div class="input-field col s6 m6 l6">
                                <textarea id= "desCateg"  name="desCateg" class="materialize-textarea bloq"></textarea>
                                <label for="desCateg">Descripción de la categoría</label>
                                <div class="errordesCateg"></div>
                            </div>
                            <div class="input-field col s6 m6 l6">
                                <textarea id= "desCand" name="desCand" class="materialize-textarea bloq"></textarea>
                                <label for="desCand">Descripción del tipo de Candidatos u opciones</label>
                                <div class="errordesCand"></div>
                            </div>
                            <div id="opciones" class="col s12 m12 l12" >
                                <label for="tipo2">Seleccione opciones a registrar</label>
                                <br> <br>
                                <div class="col s12 m12 l12">
                                    <div class="col s8 tooltipped" data-position="top" data-delay="50" data-tooltip="Nombre del candidato u opción">
                                        Nombre del candidato u opción  
                                    </div>
                                    <div class="col s3 tooltipped" data-position="left" data-delay="50" data-tooltip="Nombre del candidato u opción">
                                        <input  class="with-gap" id="nombre" name="nombre" type="radio"/><label for="nombre"></label>
                                    </div>
                                    <div class="col s8 tooltipped" data-position="top" data-delay="50" data-tooltip="Información del Candidatos u opcion">
                                        Información del Candidatos u opcion
                                    </div>
                                    <div class="col s3 tooltipped" data-position="left" data-delay="50" data-tooltip="Información del Candidatos u opcion">
                                        <input type="checkbox" id="infor" name="infor"/><label for="infor"></label>
                                    </div>
                                    <div class="col s8 tooltipped" data-position="top" data-delay="50" data-tooltip="Género persona (Femenino - Masculino)">
                                        Género persona (Femenino - Masculino) 
                                    </div>
                                    <div class="col s3 tooltipped" data-position="left" data-delay="50" data-tooltip="Género persona (Femenino - Masculino)">
                                        <input type="checkbox" id="gen" name="gen" /><label for="gen"></label>
                                    </div>
                                    <div class="col s8 tooltipped" data-position="top" data-delay="50" data-tooltip="Género (Ejemplo Música (pop, balada) - Artistas (drama, comedia))">
                                        Género (Ejemplo Música (pop, balada) - Artistas (drama, comedia))
                                    </div>
                                    <div class="col s3 tooltipped" data-position="left" data-delay="50" data-tooltip="Género (Ejemplo Música (pop, balada) - Artistas (drama, comedia))">
                                        <input type="checkbox" id="generoArt" name="generoArt"/><label for="generoArt"></label>
                                    </div>
                                    <div class="col s8 tooltipped" data-position="top" data-delay="50" data-tooltip="Imágenes ">
                                        Imágen
                                    </div>
                                    <div class="col s3 tooltipped" data-position="left" data-delay="50" data-tooltip="Imágenes ">
                                        <input class="with-gap" type="radio" id="img" name="img" /><label for="img"></label>
                                    </div>
                                    <div class="col s8 tooltipped" data-position="top" data-delay="50" data-tooltip="Audio ">
                                        Audio
                                    </div>
                                    <div class="col s3 tooltipped" data-position="left" data-delay="50" data-tooltip="Audio ">
                                        <input type="checkbox" id="audio" name="audio" /><label for="audio"></label>
                                    </div>
                                    <div class="col s8 tooltipped" data-position="top" data-delay="50" data-tooltip="Videos ">
                                        Videos
                                    </div>
                                    <div class="col s3 tooltipped" data-position="left" data-delay="50" data-tooltip="Videos ">
                                        <input type="checkbox" id="video" name="video" /><label for="video"></label>
                                    </div>
                                    <div class="col s8 tooltipped" data-position="top" data-delay="50" data-tooltip="Redes Sociales  ">
                                        Redes Sociales 
                                    </div>
                                    <div class="col s3 tooltipped" data-position="left" data-delay="50" data-tooltip="Redes Sociales  ">
                                        <input type="checkbox" id="redes" name="redes" /><label for="redes"></label>
                                    </div>
                                    <div class="col s8 tooltipped" data-position="top" data-delay="50" data-tooltip="Página WEB ">
                                        Página WEB 
                                    </div>
                                    <div class="col s3 tooltipped" data-position="left" data-delay="50" data-tooltip="Página WEB ">
                                        <input type="checkbox" id="pag" name="pag" /><label for="pag"></label>
                                    </div>
                                    <div class="col s8 tooltipped" data-position="top" data-delay="50" data-tooltip="Nombre de la compañia ">
                                        Nombre de la compañia 
                                    </div>
                                    <div class="col s3 tooltipped" data-position="left" data-delay="50" data-tooltip="Nombre de la compañia ">
                                        <input type="checkbox" id="cia" name="cia" /><label for="cia"></label>
                                    </div>
                                    <div class="col s8 tooltipped" data-position="top" data-delay="50" data-tooltip="Nº seguidores ">
                                        Nº seguidores
                                    </div>
                                    <div class="col s3 tooltipped" data-position="left" data-delay="50" data-tooltip="Nº seguidores ">
                                        <input type="checkbox" id="seg" name="seg" /><label for="seg"></label>
                                    </div> 
                                </div>
                            </div>
                            <input type="hidden" id="tipo" name="tipo" value="1" />
                            <div id="genArt" class="input-field col s10" style="display: none">
                                <div class="input-field col s6 tooltipped" data-position="top" data-delay="50" data-tooltip="Agregar Géneros ">
                                    <div id="campos">
                                        <label for="genArt">Agregar Géneros </label>
                                    </div>
                                </div>
                            </div>
                            <div class="input-field col s12">
                                <div class="col col s12 m4 l4 left">
                                    <a id="agregar" name="agregar" class="btn purple tooltipped" data-position="right" data-delay="50" data-tooltip="Agregar otro Género" style="margin-right: 2%;display: none;">Agregar otro Género<i class="material-icons right" style="line-height: 35px;">add_to_photos</i>
                                    </a>
                                    <br><br>
                                </div>
                                <div class="col col s12 m7 l7 left">
                                    <a id="eliminargenArt" name="eliminargenArt" class="btn orange" style="margin-right: 2%;display: none;">Eliminar<i class="material-icons right" style="line-height: 35px;">indeterminate_check_box</i>
                                    </a>
                                    <br><br>
                                </div>
                            </div>
                            <div class="input-field col s12 m12 l12">
                                <div class="input-field col col s12 m6 offset-m6 l6 offset-l6 right">
                                    <a id="guardar" name="guardar" class="btn cyan waves-effect waves-light">Guardar <i class="material-icons right">save</i></a>
                                </div>
                            </div>
                            {{ csrf_field()}}
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('javascripts')
@parent
@endsection