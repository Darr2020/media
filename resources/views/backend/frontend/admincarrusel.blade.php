@extends("backend.layout.layout")
@section("title", "MediaMétrica | Administración Carousel")
@section('stylesheets')
@parent
@endsection
@section("body")
<div id="breadcrumbs-wrapper">
    <div class="container">
        <div class="row">
            <div class="col s12 m12 l12">
                <h5 class="breadcrumbs-title">Carousel</h5>
                <ol class="breadcrumbs">
                    <li><a href="#">Administración web</a>
                    </li>
                    <li class="active">Administración Carousel
                    </li>
                </ol>
            </div>
        </div>
    </div>
</div>
<div class="container">
    <div class="section">
        <p class="caption">Modulo para la administración web.</p>
        <div class="divider"></div>
        <div class="row">
            <div class="col col s12 m6 l6 right">
                <br><br>
                <a href="javascript:void(0)" onclick="masImg(0, 1)" class="btn cyan waves-effect waves-light right">Agregar Imágen<i class="material-icons right">add_box</i></a>
            </div>
            <div class="col s12 m12 l12">
                <div class="card-panel">
                    <div class="row">

                        <form id="admincarrusel" name="admincarrusel" action="{{ url('adminCarrusel/')}}" method="POST" enctype="multipart/form-data">
                            <input id="contador" name="contador" type="hidden"/>
                            <table id="poscateg" class="responsive-table display"  cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th class="center">Imagen<br>Actual</th>
                                        <th class="center">Posición<br>Actual</th>
                                        <th class="center">Activar / Desactivar</th>
                                        <th class="center">Editar</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($params['data']['carousel'] as $frontend) 
                                    <tr>
                                        <td class="center">
                                            <img width="200px" height="150px" src="{{ asset("images/gallary/".$frontend->imagen) }}">
                                        </td>
                                        <td class="center">
                                            <select class="col s2 m2 offset-m5 l2 offset-l5 center" name="posicion_id{{$frontend->id}}" id="posicion_id{{$frontend->id}}" onchange="updatePos({{$frontend->id}},2)">
                                                @foreach($params['posicionuod'] as $pos)
                                                @if($pos->id == $frontend->posicion_id )
                                                <option value="{{$pos->id}}" selected="selected">{{$pos->id }}</option>
                                                @else
                                                <option value ="{{$pos->id}}" >{{$pos->id}}</option>
                                                @endif
                                                @endforeach
                                            </select>
                                            <label for="posicion_id"></label>
                                        </td>
                                        <td class="center">
                                            @if ($frontend->estatus === 1)
                                            <a onclick="masImg({{$frontend->id}},{{2}},{{2}})" class="btn orange waves-effect waves-light" style="font-size: 12.6px;">Inactivar <i class="material-icons right">visibility_off</i></a>
                                            @else
                                            <a onclick="masImg({{$frontend->id}},{{3}},{{1}})" class="btn cyan waves-effect waves-light" style="font-size: 12.6px;">Activar <i class="material-icons right">visibility</i></a>
                                            @endif
                                        </td>
                                        <td class="center">
                                            @if ($frontend->estatus === 1)
                                            <a onclick="masImg({{$frontend->id}},{{4}})" class="btn cyan waves-effect waves-light" style="font-size: 12.6px;">Editar <i class="material-icons right">edit</i></a>
                                            @else
                                            <a class="btn cyan waves-effect waves-light" style="font-size: 12.6px;" disabled>Editar <i class="material-icons right">edit</i></a>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            {{ csrf_field()}}
                        </form>
                    </div>
                </div>
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