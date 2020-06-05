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
                    <li class="active">Consultar Categorias
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
            <div class="col col s12 m6 l6 right">
                <br><br>
                <a href="{{url('/backend/categoria')}}" class="btn cyan waves-effect waves-light right">Crear Categoria <i class="material-icons right">add_box</i></a>
            </div>
            <div class="col col s12 m12 l12">
                <div class="card-panel">
                    <form id="consultcand" name="consultcand">
                        <table id="consulta_categorias" class="responsive-table display"  cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th class="center">Categoria</th>
                                    <th class="center">Descripción<br>Categoria</th>
                                    <th class="center">Descripción<br>Candidatos</th>
                                    <th class="center">Activar / Desactivar<br>Categoria</th>
                                    <th class="center">Ver<br>Opciones o Campos</th>
                                    <th class="center">Editar</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </form>
                </div>
                {{ csrf_field()}}
            </div>
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