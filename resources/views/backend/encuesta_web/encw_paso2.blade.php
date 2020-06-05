@extends("backend.layout.layout")
@section("title", "MediaMétrica | Encuesta Web - Parte II")
@section('stylesheets')
@parent
@endsection
@section("body")

<!--breadcrumbs start-->
<div id="breadcrumbs-wrapper">
    <div class="container">
        <div class="row">
            <div class="col s12 m12 l12">
                <h5 class="breadcrumbs-title">Encuestas</h5>
                <ol class="breadcrumbs">
                    <li><a href="{{route('encweb_index')}}">Encuesta Web</a>
                    </li>
                    <li class="active">Parte II</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<!--breadcrumbs end-->

<div class="container">
    <div class="section">
        <div class="row">
            <div id="test2" class="col s12">
                <div class="card-panel">
                    <!--DataTables-->
                    <div id="table-datatables">
                        <div class="row">
                            <h4 class="header">Datos de la encuesta</h4>
                            <p class="medium col s12 m12 l12"><strong>Identificador de la encuesta: </strong> {{ $encuesta->id }}</p>
                        </div>
                        <div class="row">
                            <h4 class="header">Listado de categorías</h4>
                            <div class="col s12"><br>
                                <table id="dataTable" class="responsive-table display" cellspacing="0" width="100%">
                                    <thead>
                                        <tr>
                                            <th width="5%">#</th>
                                            <th style="text-align: center" width="40%">Catergoria</th>
                                            <th style="text-align: center" width="10%">Ver</th>
                                            <th style="text-align: center" width="10%">Acción</th>
                                            <th style="text-align: center" width="20%">Activar/Desactivar</th>
                                            <th style="text-align: center" width="15%">Candidatos con Puntaje</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @php
                                            $min_candidatos_por_categoria_info = \App\Models\ConfigParametro::get_min_candidatos_por_categoria();
                                            //error_log('Min candidatos por categoria=== '.$min_candidatos_por_categoria_info[0]->valor);
                                            $min_candidatos_por_categoria = $min_candidatos_por_categoria_info[0]->valor;

                                        $i=0;
                                        @endphp
                                        @foreach($categoria as $cate)
                                        @php
                                        $i++;
                                        @endphp
                                        <tr>
                                            <td> {{ $i }} </td>

                                            @if($exist_eweb==0) {{-- primera vez --}}
                                            <td style="text-align: justify"> {{ $cate->categoria }} </td>
                                            <td style="text-align: center"> 
                                                <a href="{{route('encweb_show_cate', ['cate_id'=> $cate->categoria_id,'enc_id'=> $encuesta->id])}}" class="btn teal waves-effect waves-light" style="font-size: 12.6px;">
                                                    Ver <i class="material-icons right">visibility</i>
                                                </a>
                                            </td>
                                            <td style="text-align: center">
                                                <a href="{{route('encweb_search_cateCand', ['id'=> $cate->categoria_id,'enc_id'=> $encuesta->id])}}" class="btn light-blue accent-2 waves-effect waves-light" style="font-size: 12.6px;">
                                                        Opciones <i class="material-icons right">add</i>
                                                </a>
                                            </td>

                                             <td style="text-align: center"> 
                                                <a class="btn grey waves-effect waves-light disabled"  style="font-size: 12.6px;">Activar <i class="material-icons right">
                                                add_circle_outline</i>
                                                </a>                                             
                                             </td>
                                             <td style="text-align: center"> {{0}} / {{ $min_candidatos_por_categoria }}</td>                                              

                                            @else {{-- ya existe al menos un candidato de una categoria guardado para esta encuesta --}}
                                            <td style="text-align: justify"> {{ $cate['categoria'] }} </td>
                                           
                                            <td style="text-align: center"> 
                                                <a href="{{route('encweb_show_cate', ['cate_id'=> $cate['categoria_id'],'enc_id'=> $encuesta->id])}}" class="btn teal waves-effect waves-light" style="font-size: 12.6px;">
                                                    Ver <i class="material-icons right">visibility</i>
                                                </a>
                                            </td>
                                            <td style="text-align: center">
                                                @if($cate['estatus_cat_encweb'] == 1 || $cate['candidatos_con_puntos']==null)
                                                    <a href="{{route('encweb_search_cateCand', ['id'=> $cate['categoria_id'],'enc_id'=> $encuesta->id])}}" class="btn light-blue accent-2 waves-effect waves-light" style="font-size: 12.6px;">
                                                        Opciones <i class="material-icons right">add</i>
                                                    </a>

                                                @elseif($cate['estatus_cat_encweb'] == 2)
                                                    <a  class="btn grey waves-effect waves-light disabled" style="font-size: 12.6px;">
                                                        Opciones <i class="material-icons right">add</i>
                                                    </a>
                                                @endif
                                            </td>

                                             <td style="text-align: center"> 
                                                @if($cate['candidatos_con_puntos']!=null)
                                                    @if($cate['estatus_cat_encweb'] == 1)
                                                        <a onclick="remover_cat_eweb({{$encuesta->id}},{{$cate['categoria_id']}},{{2}})" class="btn red waves-effect waves-light"  style="font-size: 12.6px;">Desactivar <i class="material-icons right">remove_circle</i>
                                                        </a> 
                                                    @elseif($cate['estatus_cat_encweb'] == 2)
                                                        <a onclick="remover_cat_eweb({{$encuesta->id}},{{$cate['categoria_id']}},{{1}})" class="btn amber darken-2 waves-effect waves-light"  style="font-size: 12.6px;">Activar <i class="material-icons right">add_circle_outline</i>
                                                        </a> 
                                                    @endif
                                             
                                           
                                                @endif
                                             </td>
                                             <td style="text-align: center"> 
                                                @if($cate['candidatos_con_puntos']!=null)
                                                     {{ $cate['candidatos_con_puntos'] }} 
                                                @else
                                                    {{'0'}}
                                                @endif
                                                 / {{ $min_candidatos_por_categoria }}
                                            </td>    

                                            @endif                                        
                                            @endforeach

                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                        <div class="row">
                            <div class="col s12 offset-s6 m6 offset-m6" style="text-align: right;"><br>
                                <a href="{{route('encweb_index')}}" class="btn deep-orange accent-3 waves-effect waves-light tooltipped" data-position="top" data-delay="50" data-tooltip="Ir al index de Encuesta Web">
                                            Volver
                                            <i class="material-icons right">reply</i>
                                </a>
                            </div>  

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
