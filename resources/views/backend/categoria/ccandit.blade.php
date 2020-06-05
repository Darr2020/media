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
                    <li><a href="#">Administración de Candidatos</a>
                    </li>
                    <li class="active">Consultar Candidatos u Opciones
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
            <div class="col col s12 m6 l6 right">
                <br><br>
                <a href="{{url('/backend/area')}}" class="btn cyan waves-effect waves-light right">Crear Candidatos <i class="material-icons right">person_pin</i></a>
            </div>
            <div class="col s12 m12 l12">
                <div class="card-panel">
                    <div class="row"> 
                        <form name="csvcat" id="csvcat">
                            <div class=" col s12 m4 l4">
                                Seleccione la categoria
                                <select class="input-field" name="categ" id="categ" >
                                    <option value="0" selected>Seleccione...</option>
                                    @foreach($params['data']['categ'] as $categ)
                                    <option value ="{{$categ->id}}" >{{$categ->nombre}}</option>
                                    @endforeach
                                </select>
                                <label for="categ"></label>
                            </div>
                            <div class="col s12 m12 l12">
                                <table id="consulta_candidato" class="responsive-table display" cellspacing="0" width="100%" style="display: none;">
                                    <thead>
                                        <tr>
                                            <th class="center">Nombre</th>
                                            <th class="center">Información<br>Candidato</th>
                                            <th class="center">Activar / Desactivar<br>Candidato</th>
                                            <th class="center">Ver</th>
                                            <th class="center">Editar</th>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>
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
