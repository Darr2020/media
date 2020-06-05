@extends("backend.layout.layout")
@section("title", "MediaMétrica | Encuesta Telefónica")
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
                    <li><a href="#!">Encuesta Telefónica</a>
                    </li>
                    <li class="active">Principal</li>
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
                    <h4 class="header">Listado de encuesta telefónica</h4>
                    <div class="row">
                        @if($enc_sin_publicar == 0)
                        <div class="col col s12 m6 l6 right">
                            <a href="{{route('enc_tlfP1')}}" class="btn cyan waves-effect waves-light right">Crear Encuesta Telefónica <i class="material-icons right">add_box</i></a>
                        </div>
                        
                        @if($last_enctlf!=false)
                        <div class="col s12 m4 l4">
                                <a onclick="crear_enc_tlf_ult()" class="btn btn-large waves-effect waves-light gradient-45deg-indigo-blue">
                                     a partir de la última telefónica
                                    <i class="material-icons right">add_box</i></a>
                        </div>
                        @endif
                        @endif
                        
                        <div class="col s12"><br>
                            @if($encuesta!=false)

                            <table id="dataTable" class="responsive-table display" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Fecha Publicación</th>
                                        <th>Estatus</th>
                                        <th>Editar Encuesta</th>
                                        <th>Editar Puntaje</th>
                                        <th>Ver</th>
                                        <th>Acción</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    
                                    @php
                                     $min_categoria_por_encuesta_info = \App\Models\ConfigParametro::get_min_categoria_por_encuesta();

                                     //error_log('min_categoria_por_encuesta_info: '.print_r($min_categoria_por_encuesta_info,true));
                                     $min_categoria_por_encuesta = $min_categoria_por_encuesta_info[0]->valor;

                                     $min_candidatos_por_categoria_info = \App\Models\ConfigParametro::get_min_candidatos_por_categoria();

                                    // error_log('min_candidatos_por_categoria_info: '.print_r($min_candidatos_por_categoria_info,true));

                                     $min_candidatos_por_categoria = $min_candidatos_por_categoria_info[0]->valor;


                                    $countCategorias = \App\Models\EncuestaAll::traer_categorias_activas_order_by_id();
                                    @endphp   

                                    @foreach($encuesta as $enc)
                                        @php 
                                          $countCant = \App\Models\EncuestaAll::countPuntosCandidatosPorEncuestaTlfActivas($enc->id);
                                     
                                          @endphp
                                     
                                    <tr>
                                        <td>{{ $enc->id  }}</td>
                                         <td>
                                            {{ \App\Http\Controllers\Comun\AppComun::dar_formato_fecha_slash($enc->fecha_publicacion) }}
                                        </td>
                                        <td>
                                            @if($enc->estatus == 1)
                                                {{ 'Iniciada' }}
                                            @elseif($enc->estatus == 2)
                                                {{ 'Publicada' }}
                                            @elseif($enc->estatus == 3)
                                                {{ 'Archivada' }}
                                            @endif
                                        </td>

                                        <td>
                                            @if($enc->estatus==1)
                                            <a href="{{route('enc_tlf_p1mod', ['id'=> $enc->id])}}" class="btn light-green waves-effect waves-light" style="font-size: 12px;">
                                                Encuesta<i class="material-icons right">edit</i></a>
                                            @else
                                            <a class="btn grey waves-effect waves-light disabled" style="font-size: 12px;">
                                                Encuesta<i class="material-icons right">edit</i></a>
                                            @endif
                                        </td>

                                        <td>
                                            @if($enc->estatus==1)
                                            <a href="{{route('enc_tlfP2', ['id'=> $enc->id])}}" class="btn orange waves-effect waves-light" style="font-size: 12.6px;">
                                                Puntaje<i class="material-icons right">mode_edit</i></a>
                                            @else
                                            <a href="#" class="btn grey waves-effect waves-light disabled" style="font-size: 12.6px;">
                                                Puntaje<i class="material-icons right">mode_edit</i></a>
                                            @endif
                                        </td>
                                        <td>
                                            @if($countCant==false)    
                                               <a href="#" class="btn grey waves-effect waves-light disabled" style="font-size: 12.6px;">
                                                   Ver <i class="material-icons right">visibility</i></a>
                                            @else
                                               <a href="{{route('enc_tlfShow', ['id'=> $enc->id])}}" class="btn teal waves-effect waves-light" style="font-size: 12.6px;">
                                                   Ver <i class="material-icons right">visibility</i></a>
                                            @endif   
                                        </td>
                                        <td>
                                             
                                            {{-- start habilitar la publicación --}}
                                            {{-- Cuando la encuesta no tiene candidatos con puntos --}}
                                                    @if($countCant==false || $countCant==null )
                                                      <a href="#" class="btn grey waves-effect waves-light disabled" style="font-size: 12.6px;">
                                                          Publicar<i class="material-icons right">public</i>
                                                    </a>
                                                    
                                                    {{-- Encuesta candidatos con puntos --}}
                                                    @else
                                                        @if($enc->estatus==1)

                                                                <!--///////////-->
                                                               {{--Cuando la cantidad de categorias que tienen puntos es igual o mayor a min_categoria_por_encuesta --}}
                                                               @if(count($countCant) >= $min_categoria_por_encuesta)
                                                                       @foreach($countCant as $cc)
                                                                    <!--///////////-->
                                                                    {{--Verificando el minimo de candidatos por categoria --}}
                                                                           @if($cc->candidatos_con_puntos < $min_candidatos_por_categoria)
                                                                               @php
                                                                                   $flag=0;
                                                                                   break;
                                                                               @endphp
                                                                               <!--///////////-->
                                                                           @else
                                                                               @php
                                                                               $flag=1;
                                                                               @endphp
                                                                           @endif
                                                                           <!--///////////-->

                                                                       @endforeach   
                                                                           <!--///////////-->
                                                                           {{-- Alguna de las categorias no cumple con el minimo de 20 candidatos--}}
                                                                             @if($flag==0)
                                                                                 <a href="#" class="btn grey waves-effect waves-light disabled" style="font-size: 12.6px;">
                                                                                 Publicar<i class="material-icons right">public</i>
                                                                                 </a>                                                    
                                                                             <!--///////////-->
                                                                             @else
                                                                                 <a onclick="publicar_encTlf({{ $enc->id }})" class="btn indigo waves-effect waves-light" style="font-size: 12.6px;">
                                                                                         Publicar<i class="material-icons right">public</i>
                                                                                 </a>                                                    
                                                                             @endif
                                                                             <!--///////////-->  

                                                                <!--///////////-->
                                                                {{--Cuando la cantidad de categorias que tienen puntos es menor al minimo --}}
                                                                @else
                                                                       <a href="#" class="btn grey waves-effect waves-light disabled" style="font-size: 12.6px;">
                                                                                 Publicar<i class="material-icons right">public</i>
                                                                       </a>  
                                                                @endif
                                                                <!--///////////-->   

                                                    <!--///////////-->  
                                                    {{-- ET esta publicada o archivada  --}}
                                                        @else
                                                            <a href="#" class="btn grey waves-effect waves-light disabled" style="font-size: 12.6px;">
                                                                 Publicar<i class="material-icons right">public</i>
                                                            </a>                                       
                                                        @endif
                                                                
                                                    @endif
                                            {{-- end habilitar la publicación --}}
                                        
                                        </td>
                                        @endforeach
                                    </tr>
                                </tbody>
                            </table>
                            @endif
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
