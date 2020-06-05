@extends("backend.layout.layout")
@section("title", "MediaMétrica | Administración web")
@section('stylesheets')
@parent
@endsection
@section("body")
<div id="breadcrumbs-wrapper">
    <div class="container">
        <div class="row">
            <div class="col s12 m12 l12">
                <h5 class="breadcrumbs-title">Posición de las Categorias</h5>
                <ol class="breadcrumbs">
                    <li><a href="#">Administración web</a>
                    </li>
                    <li class="active">Asignar Posición a las Categorias
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
            @if ($params['data']['posicioncatg']!=false)
            <div class="col s12 m12 l12">
                <div class="card-panel">
                    <div class="row">
                        <form id="consultposcateg" name="consultposcateg">
                            <input id="contador" name="contador" type="hidden"/>
                            <table id="poscateg" class="responsive-table display"  cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th class="center">Posición<br>Actual</th>
                                        <th class="center">Categoria</th>
                                        <th class="center">Cambiar<br>Posición</th>
                                        <th class="center">Color<br>Actual</th>
                                        <th class="center">Color<br>Nuevo</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $col = 1; ?>
                                    @foreach ($params['data']['posicioncatg'] as $frontend) 
                                    <tr>
                                        <td class="center">{{$frontend->posicionid}}</td>
                                        <td class="center">{{$frontend->nombrecategoria}}</td>
                                        <td class="center">
                                            <select class="col s2 m2 offset-m5 l2 offset-l5 center" name="posicion_id{{$frontend->id}}" id="posicion_id{{$frontend->id}}" onchange="updatePos({{$frontend->id}}, 3)">
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
                                            <font id="pruebacolor{{$frontend->posicionid}}" name="pruebacolor{{$frontend->posicionid}}" style="color:#ffffff; padding: 6px 6px 6px 6px; font-size:1.1em; background-color: {{$frontend->color}};"><b> {{$frontend->color}}</b></font>
                                        </td>
                                        <td class="center">
                                            <input type="color" onchange="cambiocolor({{$frontend->posicionid}})" value="{{$frontend->color}}" name="color{{$frontend->posicionid}}" id="color{{$frontend->posicionid}}">
                                        </td>
                                    </tr>
                                    <?php $col++; ?>
                                    @endforeach
                                </tbody>
                            </table>
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
@endsection
@section('javascripts')
@parent
@endsection