@extends("backend.layout.layout")
@section("title", "MediaMétrica | Encuesta Web - Parte III")
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
                    <li><a href="{{route('encweb_index')}}">Encuesta Web</a></li>
                    <li><a href="{{route('encwebP2', ['id'=> $encuesta->id])}}">Parte II</a></li>
                    <li class="active">Parte III</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<!--breadcrumbs end-->

<div class="container">
    <div class="section">
        <div class="row">
            <div class="card-panel">
                <!--DataTables-->
                <div id="table-datatables">
                    <div class="row">
                        <h4 class="header">Datos de la encuesta</h4>
                        <p class="medium col s12 m12 l12"><strong>Identificador de la encuesta: </strong> {{ $encuesta->id }}</p>
                        {{-- dd($existe_encCand,$count_cand_cate,$bandera)  --}}
                    </div>

                    <div class="row">
                        {{--CREANDO; SOLO PARA LA PRIMERA VEZ--}} 
                        {{--No esta en EW--}}
                        @if($existe_encCand==0)
                            @if($count_cand_cate < 20)
                            <div class="row">
                                <div id="card-alert" class="card gradient-45deg-amber-amber col s12">
                                    <div class="card-content white-text">
                                        <p>
                                            <i class="material-icons">warning</i> AVISO : El minimo de candidatos para la categoría es <strong>20</strong>, 
                                            actualmente solo hay <strong>{{ $count_cand_cate }}</strong>. Debe crear más candidatos para la 
                                            categoría  <strong>{{ $categoria->nombre }} </strong>
                                        </p>
                                    </div>
                                </div>
                                <div class="col s12 m6 l6 left">
                                    <a href="{{url('/backend/area')}}" class="btn cyan waves-effect waves-light pulse">Crear Candidatos <i class="material-icons right">person_pin</i></a>
                                </div>
                            </div>
                            @endif                        

                        <!--///////////-->
                        {{-- Por primera vez; cuando se crea una encuesta vacia, y se selecciona alguna categoria con orden --}}
                        @if($bandera==2)
                            <div class="row">
                                <form id="form_ordenweb" class="col s12" method="GET" action="{{route('encweb_search_cateCand', ['id'=> $categoria->id,'enc_id'=> $encuesta->id])}}">  
                                    <h4 class="header">Listado de candidatos de la categoría: <strong>{{ $categoria->nombre }} </strong> </h4>
                                    <div class="col s12"><br>
                                        <table id="dataTable" class="responsive-table display" cellspacing="0" width="100%">
                                            <thead>
                                                <tr>
                                                    <th style="text-align: center" width="60%">Nombre</th>
                                                    <th style="text-align: center" width="20%">Orden</th>
                                                    <th style="text-align: center" width="20%">Agregar/Editar Orden</th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                                @if($existe_encCand == 0)
                                                @php
                                                $a = 0;
                                                @endphp 
                                                @foreach($candidato_all as $cand)
                                                @php
                                                $a++;
                                                @endphp 
                                                <tr>
                                                    {{--Sin puntaje--}}
                                                    <td style="text-align: center">{{ $cand->nombre }}</td>
                                                    <td style="text-align: center"></td>
                                                    <td style="text-align: center">
                                                        <input style="text-align: center" id="ordenweb" name="ordenweb[]" data-id="{{ $cand->id }}" type="text" onkeypress="return solonumeros(event)" value="">                                            
                                                    </td>

                                                    @endforeach
                                                </tr>
                                                @endif
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="input-field col s12">
                                        <input id="enc_id" name="enc_id" type="hidden" value="{{ $encuesta->id }}">
                                        <input id="cat_id" name="cat_id" type="hidden" value="{{ $categoria->id }}">
                                        <div class="col s12">
                                            <a onclick="actualizar_orden_web()" class="btn green waves-effect waves-light">
                                                Guardar<i class="material-icons right">save</i>
                                            </a>
                                        </div>
                                        <div class="col s12 m6" style="text-align: right;">
                                            <a href="{{route('encwebP2', ['id'=> $encuesta->id])}}" class="btn deep-orange accent-3 waves-effect waves-light tooltipped" data-position="top" data-delay="50" data-tooltip="Ir a la parte II de Encuesta Web">
                                                        Volver
                                                        <i class="material-icons right">reply</i>
                                            </a>
                                        </div>  
                                    </div>
                                </form>  

                            </div> 
                        @endif

                        <!--///////////// -->
                        {{-- Por primera vez; cuando se crea una encuesta vacia, se muestra para asignar orden o puntaje --}}
                        @if($bandera==0)
                            <div class="row">
                                <div class="col s12">
                                    <h4 class="header">Listado de candidatos de la categoría: <strong>{{ $categoria->nombre }} </strong> </h4>
                                    <p style="color: #ef6c00">Debe seleccionar el método para asignar la posción del candidato, ya sea indicando el orden o el puntaje</p>
                                </div>
                                <div class="col s12"><br>
                                    <table id="dataTable" class="responsive-table display" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                                <th style="text-align: center" width="60%">Nombre</th>
                                                <th style="text-align: center" width="20%">Agregar Orden</th>
                                                <th style="text-align: center" width="20%">Agregar Puntaje</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            @if($existe_encCand == 0)

                                            @foreach($candidato_all as $cand)
                                            <tr>
                                                {{--Sin puntaje--}}
                                                <td style="text-align: justify">{{ $cand->nombre }}</td>
                                                <td style="text-align: center">
                                                    <form id="form_opinicial" class="col s12" method="GET" action="{{route('encweb_search_cateCand', ['id'=> $categoria->id,'enc_id'=> $encuesta->id])}}">  
                                                        <input style="text-align: center" id="ordeniweb" name="ordeniweb[]" type="text" onkeypress="return solonumeros(event)" value="" onchange="addOrdenPuntaje($(this).val(),{{ $cand->id }},{{ $encuesta->id }},{{ $flag=2 }},{{ $categoria->id }})">                                            
                                                    </form>
                                                </td>
                                                <td style="text-align: center">
                                                    <form id="form_opinicial" class="col s12" method="GET" action="{{route('encweb_search_cateCand', ['id'=> $categoria->id,'enc_id'=> $encuesta->id])}}">  
                                                        <input  style="text-align: center" id="puntajeiweb" name="puntajeiweb[]" type="text" onkeypress="return solonumeros(event)" value="" onchange="addOrdenPuntaje($(this).val(),{{ $cand->id }},{{ $encuesta->id }},{{ $flag=1 }},{{ $categoria->id }})">                                            
                                                    </form>
                                                </td>
                                                @endforeach
                                            </tr>

                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>  
                        @endif {{-- $bandera==0 --}}

                        <!--///////////-->
                        {{-- Por primera vez; cuando se clona una telefonica y tiene categorias sin puntaje --}}
                        @if($bandera==1)
                            <div class="row">
                                <form id="form_puntajeweb" class="col s12" method="GET" action="{{route('encweb_search_cateCand', ['id'=> $categoria->id,'enc_id'=> $encuesta->id])}}">  
                                    <h4 class="header">Listado de candidatos de la categoría: <strong>{{ $categoria->nombre }} </strong> </h4>
                                    <div class="col s12"><br>
                                        <table id="dataTable" class="responsive-table display" cellspacing="0" width="100%">
                                            <thead>
                                                <tr>
                                                    <th style="text-align: center" width="60%">Nombre</th>
                                                    <th style="text-align: center" width="20%">Puntaje</th>
                                                    <th style="text-align: center" width="20%">Agregar/Editar Puntaje</th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                                @if($existe_encCand == 0)
                                                @php
                                                $a = 0;
                                                @endphp 
                                                @foreach($candidato_all as $cand)
                                                @php
                                                $a++;
                                                @endphp 
                                                <tr>
                                                    {{--Sin puntaje--}}
                                                    <td style="text-align: center">{{ $cand->nombre }}</td>
                                                    <td style="text-align: center"></td>
                                                    <td style="text-align: center">
                                                        <input style="text-align: center" id="puntajeweb" name="puntajeweb[]" data-id="{{ $cand->id }}" type="text" onkeypress="return solonumeros(event)" value="">  
                                                    </td>

                                                    @endforeach
                                                </tr>
                                                @endif
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="input-field col s12">
                                        <input id="enc_id" name="enc_id" type="hidden" value="{{ $encuesta->id }}">
                                        <input id="cat_id" name="cat_id" type="hidden" value="{{ $categoria->id }}">
                                        <div class="col s12">
                                            <a onclick="actualizar_puntaje_web()" class="btn green waves-effect waves-light">
                                                Guardar <i class="material-icons right">save</i>
                                            </a>
                                        </div>
                                        <div class="col s12 m6" style="text-align: right;">
                                            <a href="{{route('encwebP2', ['id'=> $encuesta->id])}}" class="btn deep-orange accent-3 waves-effect waves-light tooltipped" data-position="top" data-delay="50" data-tooltip="Ir al parte II de Encuesta Web">
                                                        Volver
                                                        <i class="material-icons right">reply</i>
                                            </a>
                                        </div>  
                                    </div>
                                </form>  
                            </div>
                        @endif {{-- $bandera==1 --}}
                        <!--///////////-->
                        <!--////////////////////////////////////////////////////////////////////////////////////////////////////////-->                           

                        {{--EDITANDO GLOBALL--}}
                        {{--Esta presente en EC--}}
                        @elseif($existe_encCand >0)
                            <!--//////////-->
                            {{--TIENE PUNTOS | EDITAR--}}
                            @if($bandera==1)
                                @if($count_cand_cate < 20)
                                <div class="row">
                                    <div id="card-alert" class="card gradient-45deg-amber-amber col s12">
                                        <div class="card-content white-text">
                                            <p>
                                                <i class="material-icons">warning</i> AVISO : El minimo de candidatos para la categoría es <strong>20</strong>, 
                                                actualmente solo hay <strong>{{ $count_cand_cate }}</strong>. Debe crear más candidatos para la 
                                                categoría  <strong>{{ $categoria->nombre }} </strong>
                                            </p>
                                        </div>
                                    </div>
                                    <div class="col s12 m6 l6 left">
                                        <a href="{{url('/backend/area')}}" class="btn cyan waves-effect waves-light pulse">Crear Candidatos <i class="material-icons right">person_pin</i></a>
                                    </div>
                                </div>
                                @endif

                                @if($count_ptos_cancat[0]->puntaje_web < 20)
                                <div class="row"><br>
                                    <div id="card-alert" class="card yellow lighten-1 col s12">
                                        <div class="card-content white-text">
                                            <p style="color: #000">
                                                <i class="material-icons">warning</i> AVISO : El minimo de candidatos con puntos para la categoría es <strong>20</strong>, 
                                                actualmente solo hay <strong>{{ $count_ptos_cancat[0]->puntaje_web }}</strong>. Debe asignar el puntaje a los candidatos restantes.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                @endif

                                <div class="row">
                                    <form id="form_puntajeweb" class="col s12" method="GET" action="{{route('encweb_search_cateCand', ['id'=> $categoria->id,'enc_id'=> $encuesta->id])}}">  

                                        <h4 class="header">Listado de candidatos de la categoría: <strong>{{ $categoria->nombre }} </strong> </h4>
                                        <div class="col s12"><br>
                                            <table id="dataTable" class="responsive-table display" cellspacing="0" width="100%">
                                                <thead>
                                                    <tr>
                                                        <th style="text-align: center" width="50%">Nombre</th>
                                                        <th style="text-align: center" width="10%">Puntaje</th>
                                                        <th style="text-align: center" width="20%">Agregar/Editar Puntaje</th>
                                                        <th style="text-align: center" width="20%">Remover</th>
                                                    </tr>
                                                </thead>

                                                <tfoot>
                                                    <tr>
                                                        <th colspan="1">Total Puntos</th>
                                                        <th colspan="1" style="text-align: center">{{ $sum_ptos_cand[0]->puntaje }}</th>
                                                        <th colspan="2"></th>
                                                    </tr>
                                                </tfoot>
                                                <tbody>

                                                    @if($candidato_all != null)
                                                    @php
                                                    $flag = 0;
                                                    @endphp 
                                                    @foreach($candidato_all as $cand)

                                                    <tr>
                                                        {{-- Candidato con puntaje--}}
                                                        @foreach($enc_candidato as $enccand)
                                                        @if( $enccand->candidato_id == $cand['id'] )
                                                        @php
                                                        $flag = 1;
                                                        break;
                                                        @endphp
                                                        @else
                                                        @php
                                                        $flag = 0;
                                                        @endphp
                                                        @endif
                                                        @endforeach

                                                        <td style="text-align: center">{{ $cand['nombre'] }}</td>
                                                        <td style="text-align: center">{{ $cand['puntaje_web'] }}</td>

                                                        @if($flag == 0)
                                                        <td style="text-align: center">
                                                            <input style="text-align: center" id="puntajeweb" name="puntajeweb[]" data-id="{{ $cand['id'] }}" type="text" onkeypress="return solonumeros(event)" value="">
                                                        </td>
                                                        @elseif ($flag == 1)
                                                        <td style="text-align: center">
                                                            <input style="text-align: center" id="puntajeweb" name="puntajeweb[]" data-id="{{ $cand['id'] }}" type="text" onkeypress="return solonumeros(event)" value="{{ $cand['puntaje_web'] }}">                                                
                                                        </td>
                                                        @endif


                                                        <td style="text-align: center">
                                                            <form id="form_remover" class="col s12" method="POST" action="{{route('encweb_search_cateCand', ['id'=> $categoria->id,'enc_id'=> $encuesta->id,'var'=> 1])}}">
                                                                @if($flag == 1)    
                                                                <a onclick="remover_opcion({{ $cand['id'] }},{{ $encuesta->id }},{{ $categoria->id }})" class="btn red waves-effect waves-light"  style="font-size: 12.6px;">
                                                                    Remover <i class="material-icons right">remove_circle</i>
                                                                </a>
                                                                @else
                                                                <a href="#" class="btn red waves-effect waves-light disabled"  style="font-size: 12.6px;">
                                                                    Remover <i class="material-icons right">remove_circle</i>
                                                                </a>
                                                                @endif
                                                            </form>
                                                        </td>

                                                        <!--//////////-->
                                                        @endforeach
                                                    </tr>
                                                    <!--//////////-->
                                                    @else
                                                    <tr>
                                                        <td colspan="2" style="text-align: center">Sin información para mostrar</td>
                                                    </tr>
                                                    @endif
                                                    <!--//////////-->

                                                </tbody>
                                            </table>


                                        </div>
                                        <div class="input-field col s12">
                                            <input id="enc_id" name="enc_id" type="hidden" value="{{ $encuesta->id }}">
                                            <input id="cat_id" name="cat_id" type="hidden" value="{{ $categoria->id }}">
                                            <div class="col s12">
                                                <a onclick="actualizar_puntaje_web()" class="btn green waves-effect waves-light">
                                                    Guardar<i class="material-icons right">save</i>
                                                </a>
                                            </div>
                                            <div class="col s12 m6" style="text-align: right;">
                                                <a href="{{route('encwebP2', ['id'=> $encuesta->id])}}" class="btn deep-orange accent-3 waves-effect waves-light tooltipped" data-position="top" data-delay="50" data-tooltip="Ir al parte II de Encuesta Web">
                                                        Volver
                                                        <i class="material-icons right">reply</i>
                                                </a>
                                            </div>  
                                        </div>
                                    </form>
                                </div>   

                            <!--//////////-->
                            {{--TIENE ORDEN | EDITAR --}}
                            @elseif($bandera==2) 
                                @if($count_cand_cate < 20)
                                <div class="row">
                                    <div id="card-alert" class="card gradient-45deg-amber-amber col s12">
                                        <div class="card-content white-text">
                                            <p>
                                                <i class="material-icons">warning</i> AVISO : El minimo de candidatos para la categoría es <strong>20</strong>, 
                                                actualmente solo hay <strong>{{ $count_cand_cate }}</strong>. Debe crear más candidatos para la 
                                                categoría  <strong>{{ $categoria->nombre }} </strong>
                                            </p>
                                        </div>
                                    </div>
                                    <div class="col s12 m6 l6 left">
                                        <a href="{{url('/backend/area')}}" class="btn cyan waves-effect waves-light pulse">Crear Candidatos <i class="material-icons right">person_pin</i></a>
                                    </div>

                                </div>
                                @endif

                                @if($count_orden_cancat < 20)
                                <div class="row"><br>
                                    <div id="card-alert" class="card yellow lighten-1 col s12">
                                        <div class="card-content white-text">
                                            <p style="color: #000">
                                                <i class="material-icons">warning</i> AVISO : El minimo de candidatos con orden para la categoría es <strong>20</strong>, 
                                                actualmente solo hay <strong>{{ $count_orden_cancat }}</strong>. Debe añadir el valor a los candidatos restantes.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                @endif


                                <div class="row">
                                    <form id="form_ordenweb" class="col s12" method="GET" action="{{route('encweb_search_cateCand', ['id'=> $categoria->id,'enc_id'=> $encuesta->id])}}">  
                                        <h4 class="header">Listado de candidatos de la categoría: <strong>{{ $categoria->nombre }} </strong> </h4>
                                        <div class="col s12"><br>
                                            <table id="dataTable" class="responsive-table display" cellspacing="0" width="100%">
                                                <thead>
                                                    <tr>
                                                        <th style="text-align: center" width="60%">Nombre</th>
                                                        <th style="text-align: center" width="20%">Orden</th>
                                                        <th style="text-align: center" width="20%">Agregar/Editar Orden</th>
                                                    </tr>
                                                </thead>
                                                <tbody>

                                                    @if($candidato_all != null)
                                                    @php
                                                    $flag = 0;
                                                    $a=0;
                                                    @endphp 
                                                    @foreach($candidato_all as $cand)
                                                    @php
                                                    $a++;
                                                    @endphp 
                                                    <tr>
                                                        {{-- Candidato con puntaje--}}
                                                        @foreach($enc_candidato as $enccand)
                                                        @if( $enccand->candidato_id == $cand['id'] )
                                                        @php
                                                        $flag = 1;
                                                        break;
                                                        @endphp
                                                        @else
                                                        @php
                                                        $flag = 0;
                                                        @endphp
                                                        @endif
                                                        @endforeach

                                                        <td style="text-align: center">{{ $cand['nombre'] }}</td>
                                                        <td style="text-align: center">{{ $cand['orden'] }}</td>
                                                        <td style="text-align: center">
                                                            @if($flag == 0)                                                   
                                                            <input style="text-align: center" id="ordenweb" name="ordenweb[]" data-id="{{ $cand['id'] }}" type="text" onkeypress="return solonumeros(event)" value="">                                            
                                                            @elseif ($flag == 1)
                                                            <input style="text-align: center" id="ordenweb" name="ordenweb[]" data-id="{{ $cand['id'] }}" type="text" onkeypress="return solonumeros(event)" value="{{ $cand['orden'] }}">                       
                                                            @endif
                                                        </td>

                                                        @endforeach
                                                    </tr>

                                                    @else
                                                    <tr>
                                                        <td colspan="2" style="text-align: center">Sin información para mostrar</td>
                                                    </tr>
                                                    @endif

                                                </tbody>
                                            </table>
                                        </div>

                                        <div class="input-field col s12">
                                                <input id="enc_id" name="enc_id" type="hidden" value="{{ $encuesta->id }}">
                                                <input id="cat_id" name="cat_id" type="hidden" value="{{ $categoria->id }}">
                                                <div class="col s12 m6">
                                                    <a onclick="actualizar_orden_web()" class="btn green waves-effect waves-light">
                                                        Guardar<i class="material-icons right">save</i>
                                                    </a>
                                                </div>

                                                <div class="col s12 m6" style="text-align: right;">
                                                    <a href="{{route('encwebP2', ['id'=> $encuesta->id])}}" class="btn deep-orange accent-3 waves-effect waves-light tooltipped" data-position="top" data-delay="50" data-tooltip="Ir al parte II de Encuesta Web">
                                                        Volver
                                                        <i class="material-icons right">reply</i>
                                                    </a>
                                                </div>  
                                        </div>
                                    </form>  
                                </div>                             

                            @endif {{--bandera2 --}}
                            <!--//////////--> 
                        @endif    {{--existe_encCand --}}             
                    </div>
                </div>




            </div>
        </div>
    </div>

    @endsection
    @section('javascripts')
    @parent
    @endsection
