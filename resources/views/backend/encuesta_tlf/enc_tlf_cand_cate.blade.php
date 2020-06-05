@extends("backend.layout.layout")
@section("title", "MediaMétrica | Encuesta - Parte III")
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
                    <li><a href="{{route('enc_tlf_index')}}">Encuesta Telefónica</a></li>
                    <li><a href="{{route('enc_tlfP2', ['id'=> $encuesta->id])}}">Parte II</a></li>
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
            <form id="form_puntaje_edit" class="col s12" method="GET" action="{{route('search_cateCand', ['id'=> $categoria->id,'enc_id'=> $encuesta->id])}}">
                <div class="card-panel">
                    <!--DataTables-->
                    <div id="table-datatables">
                        <div class="row">

                            <h4 class="header">Datos de la encuesta</h4>
                            <p class="medium col s12 m6 l6">
                                <strong>Fecha desde: </strong>{{ \App\Http\Controllers\Comun\AppComun::dar_formato_fecha_slash($encuesta->fecha_desde)}}
                            </p>
                            <p class="medium col s12 m6 l6">
                                <strong>Fecha hasta: </strong>{{ \App\Http\Controllers\Comun\AppComun::dar_formato_fecha_slash($encuesta->fecha_hasta)}}
                            </p>
                            <p class="medium col s12 m4 l4"><strong>Muestra: </strong> {{ $encuesta->muestra }}</p>
                            <p class="medium col s12 m4 l4"><strong>Muestra femenina: </strong> {{ $encuesta->muestra_femenina }}</p>
                            <p class="medium col s12 m4 l4"><strong>Muestra masculina: </strong> {{ $encuesta->muestra_masculina }}</p>
                            <p class="medium col s12"><strong>Descripción: </strong> {{ $encuesta->descripcion }}</p>
                        </div>
                        <div class="divider"></div>

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

                        @if($count_ptos_cancat[0]->puntaje_tlf < 20)
                        <div class="row"><br>
                            <div id="card-alert" class="card yellow lighten-1 col s12">
                                <div class="card-content white-text">
                                    <p style="color: #000">
                                        <i class="material-icons">warning</i> AVISO : El minimo de candidatos con puntos para la categoría es <strong>20</strong>, 
                                        actualmente solo hay <strong>{{ $count_ptos_cancat[0]->puntaje_tlf }}</strong>. Debe asignar el puntaje a los candidatos restantes.
                                    </p>
                                </div>
                            </div>
                        </div>
                        @endif

                        @if($sum_ptos_cand[0]->puntos_enc_tlf > $encuesta->muestra)
                        <div class="row"><br>
                            <div id="card-alert" class="card gradient-45deg-red-pink col s12">
                                <div class="card-content white-text">
                                    <p>
                                        <i class="material-icons">error</i> IMPORTANTE : 
                                        La sumatoria de los puntos de los candidatos <strong>{{ $sum_ptos_cand[0]->puntos_enc_tlf }}</strong>
                                        no puede ser mayor a la muestra de la encuesta <strong>{{ $encuesta->muestra }} </strong>
                                        . Debe editar los puntajes de los candidatos.
                                    </p>
                                </div>
                            </div>

                        </div>
                        @endif


                        <div class="row">
                            <h4 class="header">Listado de candidatos de la categoría: <strong>{{ $categoria->nombre }} </strong> </h4>
                            <div class="col s12"><br>
                                <table id="dataTable" class="responsive-table display" cellspacing="0" width="100%">
                                    <thead>
                                        <tr>
                                            <th style="text-align: center" width="60%">Nombre</th>
                                            <th style="text-align: center" width="20%">Puntaje</th>
                                            <th style="text-align: center" width="20%">Agregar/Editar Puntaje</th>
                                        </tr>

                                {{--CREANDO POR PRIMERA VEZ--}} 
                                @if($enc_candidato_tlf==null)            
                                                </thead>
                                                <tbody>

                                                    @if($existe_enc_tlf == 0)

                                                    @foreach($candidato_all as $cand)
                                                    <tr>
                                                        {{--Sin puntaje--}}
                                                        <td style="text-align: center">{{ $cand->nombre }}</td>
                                                        <td style="text-align: center"></td>
                                                        <td style="text-align: center">
                                                            <input style="text-align: center" id="puntaje" name="puntaje[]" data-id="{{ $cand->id }}" type="text" onkeypress="return solonumeros(event)" value="">
                                                        </td>
                                                        @endforeach

                                                    </tr>
                                                    @endif

                                {{--EDITANDO --}}                    
                                @else                
                                                    </thead>

                                                    <tfoot>
                                                        <tr>
                                                            <th colspan="1">Total Puntos</th>
                                                            <th colspan="1" style="text-align: center">{{ $sum_ptos_cand[0]->puntos_enc_tlf }}</th>
                                                            <th colspan="1"></th>
                                                        </tr>
                                                    </tfoot>
                                                    <tbody>

                                        @if($candidato_all != null)
                                            @php
                                            $flag = 0;
                                            @endphp 
                                            @foreach($candidato_all as $cand)

                                                <tr>
                                                    {{-- Candidato sin puntaje--}}
                                                    @if($existe_enc_tlf == 0)
                                                        <td style="text-align: center">{{ $cand->nombre }}</td>
                                                        <td style="text-align: center">{{ $cand->puntaje_tlf }}</td>
                                                        <td style="text-align: center">
                                                            <input style="text-align: center" id="puntaje" name="puntaje[]" data-id="{{ $cand->id }}" type="text" onkeypress="return solonumeros(event)" value="">
                                                        </td>

                                                    {{-- Candidato con puntaje--}}
                                                    @else
                                                        @foreach($enc_candidato_tlf as $enccand)
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
                                                        <td style="text-align: center">{{ $cand['puntaje_tlf'] }}</td>
                                                        <td style=" ">
                                                            @if($flag == 0)
                                                            <input style="text-align: center" id="puntaje" name="puntaje[]" data-id="{{ $cand['id'] }}" type="text" onkeypress="return solonumeros(event)" value="">

                                                            @elseif ($flag == 1)
                                                                <input style=" text-align: center" id="puntaje" name="puntaje[]" data-id="{{  $cand['id'] }}" type="text" onkeypress="return solonumeros(event)"  value="{{ $cand['puntaje_tlf'] }}">
                                                 
                                                            @endif
                                                        </td>
                                                    @endif    
                                            @endforeach

                                                </tr>

                                            @else
                                            <tr>
                                                <td colspan="2" style="text-align: center">Sin información para mostrar</td>
                                            </tr>
                                        @endif
                                @endif

                                    </tbody>
                                </table>
                            </div>{{-- col s12 --}}
                        </div> {{-- row --}}

                    </div> {{-- table-datatables --}}


                    <div class="row">
                        <div class="input-field col s12">
                            <input id="enc_id" name="enc_id" type="hidden" value="{{ $encuesta->id }}">
                            <input id="cat_id" name="cat_id" type="hidden" value="{{ $categoria->id }}">
                            <div class="col s12 m6">
                                <a onclick="actualizar_puntaje()" class="btn green waves-effect waves-light">
                                    Guardar<i class="material-icons right">save</i>
                                </a>
                            </div>
    
                            <div class="col s12 m6" style="text-align: right;"><br>
                                <a href="{{route('enc_tlfP2', ['id'=> $encuesta->id])}}" class="btn deep-orange accent-3 waves-effect waves-light tooltipped" data-position="top" data-delay="50" data-tooltip="Ir a la parte II de Encuesta Telefónica">
                                            Volver
                                            <i class="material-icons right">reply</i>
                                </a>
                            </div>  
                        </div>
                    </div>

                </div>
            </form>
        </div>
    </div>
</div>


@endsection
@section('javascripts')
@parent

@endsection
