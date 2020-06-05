@extends("backend.layout.layout-noticias")
@section("title", "MediaMétrica | Nueva Noticia")

@section('stylesheets')
    @parent
    <link rel="stylesheet" href="{{ asset('vendors/dropzone/dropzone.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/noticias/nueva_noticia.css') }}">
@endsection

@section("body")
<ul class="tabs z-depth-1">
    <li class="tab col s3 halve"><a class="active" href="#publicacion">Publicación</a>
    </li>
    <li class="tab col s3 halve"><a href="#media">Media</a>
    </li>
</ul>
<div class="container" id="nuevaNoticiaApp" ng-controller="noticiaController">
    <div class="col s12">
        <div class="row">
            <div class="col s12">
                @include('backend.noticias.parts.newform')
                @include('backend.noticias.parts.newmedia')                 
            </div>
            <button ng-click="saveForm($event)" class="btn waves-effect waves-light gradient-45deg-purple-deep-orange" style="margin:20px">
                <i class="material-icons">save</i>
                Guardar
            </button>
        </div>
    </div>
</div>
@endsection

@section('javascripts')
    @parent
    <script src="{{ asset('vendors/ckeditor/ckeditor.js') }}"></script>
    <script src="{{ asset('vendors/dropzone/dropzone.min.js') }}"></script>
    <script src="{{ asset('js/noticias/nueva_noticia.js') }}"></script>    
@endsection
