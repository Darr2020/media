@extends("backend.layout.layout")
@section("title", "MediaMétrica | Encuesta Web - Principal")
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
                    <li><a href="#!">Encuesta Web</a></li>
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
                    <h4 class="header">Listado de Encuestas</h4>
                    <div class="row"> 
                        <div class="col s12">
                            
                            @if($enc_sin_publicar == 0)
                            <div class="col s12 divider"></div>
                            <h4 class="header">Crear Encuestas</h4>
                            
                            <div class="col s12 m3 l3">
                                <a onclick="crear_enc_web_vacia()" class="btn btn-large waves-effect waves-light cyan">
                                    en blanco <i class="material-icons right">add_box</i></a>
                            </div>
                            
                            @if($last_enctlf!=false)
                            <div class="col s12 m5 l5">
                                <a onclick="crear_enc_web_de_tlf()" class="btn btn-large waves-effect waves-light gradient-45deg-green-teal">
                                    a partir de una telefónica
                                    <i class="material-icons right">add_box</i></a>
                            </div>
                            @endif
                            @if($last_encweb!=false)
                            <div class="col s12 m4 l4">
                                <a onclick="crear_enc_web_ult()" class="btn btn-large waves-effect waves-light gradient-45deg-indigo-blue">
                                     a partir de la última Web
                                    <i class="material-icons right">add_box</i></a>
                            </div>
                            @endif
                            
                            <div class="col s12 divider" style="margin-top: 30px"></div>
                            @endif
                            
                        </div>
                                           

                        <div class="row">
                            <div class="col s12">
                                <!--DataTables-->
                                <div id="table-datatables">
                                    @if($encuesta!=false)
                                    <table id="dataTable" class="responsive-table display" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th style="text-align: center">id</th>
                                                <th style="text-align: center">Estatus</th>
                                                <th style="text-align: center">Editar</th>
                                                <th style="text-align: center">Ver</th>
                                                <th style="text-align: center">Acción</th>
                                            </tr>
                                        </thead>

                                        <tbody>

                                            @php
                                                 $min_categoria_por_encuesta_info = \App\Models\ConfigParametro::get_min_categoria_por_encuesta();
                                                 $min_categoria_por_encuesta = $min_categoria_por_encuesta_info[0]->valor;

                                                 $min_candidatos_por_categoria_info = \App\Models\ConfigParametro::get_min_candidatos_por_categoria();
                                                 $min_candidatos_por_categoria = $min_candidatos_por_categoria_info[0]->valor;


                                                $countCategorias = \App\Models\EncuestaAll::traer_categorias_activas_order_by_id();
                                            @endphp
                                            @foreach($encuesta as $enc)
                                                @php 
                                                    $countPtosCan = \App\Models\EncuestaAll::countPuntosCandidatosPorEncuestaWebActivas($enc->id);
                                                    $ban = \App\Models\EncuestaAll::getBanderaEncuesta($enc->id);
                                                    $bandera = $ban[0]->bandera;
                                                    
                                                $flag =0;
                                                @endphp
                                            <tr>
                                                <td style="text-align: center">{{ $enc->id }}</td>
                                                <td style="text-align: center">
                                                    @if($enc->estatus == 1)
                                                    {{ 'Iniciada' }}
                                                    @elseif($enc->estatus == 2)
                                                    {{ 'Publicada' }}
                                                    @elseif($enc->estatus == 3)
                                                    {{ 'Archivada' }}
                                                    @endif   
                                                </td>
                                                <td style="text-align: center">
                                                    @if($enc->estatus == 1)
                                                    <a href="{{route('encwebP2', ['id'=> $enc->id])}}" class="btn orange waves-effect waves-light" style="font-size: 12.6px;">
                                                        Editar <i class="material-icons right">mode_edit</i></a>
                                                    @else
                                                    <a href="{{route('encwebP2', ['id'=> $enc->id])}}" class="btn orange waves-effect waves-light disabled" style="font-size: 12.6px;">
                                                        Editar <i class="material-icons right">mode_edit</i></a>
                                                    @endif
                                                </td>
                                                <td style="text-align: center">
                                                    @if($countPtosCan==false)
                                                    <a href="#" class="btn teal waves-effect waves-light disabled" style="font-size: 12.6px;">
                                                        Ver <i class="material-icons right">visibility</i>
                                                    </a>
                                                    @else
                                                    <a href="{{route('encwebShow', ['id'=> $enc->id])}}" class="btn teal waves-effect waves-light" style="font-size: 12.6px;">
                                                        Ver <i class="material-icons right">visibility</i>
                                                    </a>
                                                    @endif
                                                </td>                           

                                                <td style="text-align: center">
                                                {{-- Cuando la encuesta no tiene candidatos con puntaje --}} 
                                                @if((($countPtosCan==false || $countPtosCan==null) && $bandera==1) || (($countPtosCan==false || $countPtosCan==null)  && $bandera==2 ) ||(($countPtosCan==false || $countPtosCan==null)  && $bandera==0 )   )
                                                      <a href="#" class="btn indigo waves-effect waves-light disabled" style="font-size: 12.6px;">
                                                          Publicar<i class="material-icons right">public</i>
                                                    </a>

                                                {{-- Encuesta candidatos con puntos --}}
                                                @else
                                                    @if($enc->estatus==1) 

                                                        <!--///////////-->
                                                        @if($bandera==1)
                                                            @if($countPtosCan!=null)
                                                                <!--///////////-->
                                                                {{--Cuando la cantidad de categorias que tienen puntos es igual o mayor a min_categoria_por_encuesta--}}
                                                                @if(count($countPtosCan) >= $min_categoria_por_encuesta)

                                                                    @foreach($countPtosCan as $cpc)
                                                                        <!--///////////-->
                                                                        {{--Verificando el minimo de candidatos por categoria --}}
                                                                        @if(($cpc->candidatos_con_puntos) < $min_candidatos_por_categoria)
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
                                                                    <a href="#" class="btn indigo waves-effect waves-light disabled" style="font-size: 12.6px;">
                                                                        Publicar<i class="material-icons right">public</i>
                                                                    </a>                                                    
                                                                    <!--///////////-->
                                                                    @else
                                                                    <a onclick="publicar_encWeb({{ $enc->id }})" class="btn indigo waves-effect waves-light" style="font-size: 12.6px;">
                                                                        Publicar <i class="material-icons right">public</i>
                                                                    </a>                                                    
                                                                    @endif
                                                                    <!--///////////-->

                                                                <!--///////////-->
                                                                {{--Cuando la cantidad de categorias habilitadas no coinciden con las que tienen puntos --}}
                                                                @else
                                                                <a href="#" class="btn grey waves-effect waves-light disabled" style="font-size: 12.6px;">
                                                                    Publicar<i class="material-icons right">public</i>
                                                                </a>                                                                        
                                                                @endif
                                                                <!--///////////-->          

                                                            <!--///////////-->
                                                            @elseif($countPtosCan==null)                     
                                                            <a href="#" class="btn grey waves-effect waves-light disabled" style="font-size: 12.6px;">
                                                                Publicar<i class="material-icons right">public</i>
                                                            </a>
                                                            @endif
                                                            <!--///////////-->                                                                

                                                        <!--///////////-->
                                                        @elseif($bandera==2)
                                                                <!--///////////-->
                                                                @if($countPtosCan!=null)

                                                                        <!--///////////-->
                                                                        {{--Cuando la cantidad de categorias que tienen puntos es igual o mayor a min_categoria_por_encuesta--}}
                                                                        @if(count($countPtosCan) >= $min_categoria_por_encuesta)                                                      
                                                                                @foreach($countPtosCan as $coc)
                                                                                    <!--///////////-->
                                                                                    {{--Verificando el minimo de candidatos por categoria --}}
                                                                                    @if(($coc->candidatos_con_puntos) < $min_candidatos_por_categoria)
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

                                                                                <!--///////////-->
                                                                                {{-- Alguna de las categorias no cumple con el minimo de 20 candidatos--}}
                                                                                @if($flag==0)
                                                                                <a href="#" class="btn grey waves-effect waves-light disabled" style="font-size: 12.6px;">
                                                                                    Publicar<i class="material-icons right">public</i>
                                                                                </a>                                                    
                                                                                <!--///////////-->
                                                                                @else
                                                                                <a onclick="publicar_encWeb({{ $enc->id }})" class="btn indigo waves-effect waves-light" style="font-size: 12.6px;">
                                                                                    Publicar<i class="material-icons right">public</i>
                                                                                </a>                                                    
                                                                                @endif
                                                                                <!--///////////-->
                                                                        <!--///////////-->  
                                                                        @else
                                                                        <a href="#" class="btn grey waves-effect waves-light disabled" style="font-size: 12.6px;">
                                                                            Publicar<i class="material-icons right">public</i>
                                                                        </a>                                                                           
                                                                        @endif                    
                                                                        <!--///////////-->
                                                                @elseif($countPtosCan==null)                     
                                                                <a href="#" class="btn grey waves-effect waves-light disabled" style="font-size: 12.6px;">
                                                                    Publicar<i class="material-icons right">public</i>
                                                                </a>
                                                                @endif
                                                                <!--///////////-->               
                                                        @endif
                                                        <!--///////////-->

                                                    {{-- ET esta publicada o archivada  --}}
                                                    @else
                                                        <a href="#" class="btn indigo waves-effect waves-light disabled" style="font-size: 12.6px;">
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
    </div>
</div>

@endsection
@section('javascripts')
@parent
@endsection
