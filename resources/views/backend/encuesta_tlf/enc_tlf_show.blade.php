@extends("backend.layout.layout")
@section("title", "MediaMétrica | Encuesta Telefónica - Vista")
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
                    <li><a href="{{route('enc_tlf_index')}}">Encuesta Telefónica</a>
                    </li>
                    <li class="active">Resumen</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<!--breadcrumbs end-->

<div class="container">
    <div class="section">
        <div class="row">
            <div  class="col s12 m12 l12" >
                <div class="card-panel">
                    <div class="row">
                        <h4 class="header">Datos de la encuesta</h4>
                        <p class="medium col s12 m6 l6">
                            <strong>Fecha desde: </strong>
                            @php
                                $fecha_inicio = \App\Http\Controllers\Comun\AppComun::dar_formato_fecha_slash($encuesta->fecha_desde);
                                $fecha_final = \App\Http\Controllers\Comun\AppComun::dar_formato_fecha_slash($encuesta->fecha_hasta);
                                $fechai = \App\Http\Controllers\Comun\AppComun::dar_formato_fecha_guion($fecha_inicio);
                                $fechaf = \App\Http\Controllers\Comun\AppComun::dar_formato_fecha_guion($fecha_final);
                            @endphp
                            {{ $fecha_inicio }}
                        </p>
                        <p class="medium col s12 m6 l6">
                            <strong>Fecha hasta: </strong>{{ $fecha_final }}
                        </p>
                        <p class="medium col s12 m4 l4"><strong>Muestra: </strong> {{ $encuesta->muestra }}</p>
                        <p class="medium col s12 m4 l4"><strong>Muestra femenina: </strong> {{ $encuesta->muestra_femenina }}</p>
                        <p class="medium col s12 m4 l4"><strong>Muestra masculina: </strong> {{ $encuesta->muestra_masculina }}</p>
                        <p class="medium col s12"><strong>Descripción: </strong> {{ $encuesta->descripcion }}</p>
                        
                        <div class="input-field col s12">
                            <a class="waves-effect waves-light btn gradient-45deg-light-blue-cyan z-depth-4 mr-1" target='_blank' href="/encuesta/enc_tlf/{{$encuesta->id.'_'.$fechai.'_'.$fechaf.'.pdf'}}">
                                Ver PDF 
                                <i class="material-icons right">picture_as_pdf</i>
                            </a>
                        </div>
                    </div>
                   
                    <div class="row"><br>
                         <div class="divider"></div>
                        <div class="col s12">
                            <table id="dataTable" class="responsive-table display" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th>Candidato</th>
                                        <th>Detalle</th>
                                        <th>Categoria</th>
                                        <th>Puntaje</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>Candidato</th>
                                        <th>Detalle</th>
                                        <th>Categoria</th>
                                        <th>Puntaje</th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                    @foreach($info_candidatos as $ican)
                                    <tr>
                                        <td>{{ $ican->nom_candidato }}</td>
                                        <td>{{ $ican->det_candidato }}</td>
                                        <td>{{ $ican->nom_categoria }}</td>
                                        <td>{{ $ican->puntaje_tlf }}</td>
                                        @endforeach    
                                    </tr>


                                </tbody>
                            </table>
                        </div>
                    </div>


                        <div class="row">
                            <div class="col s12 offset-s6 m6 offset-m6" style="text-align: right;"><br>
                                <a href="{{route('enc_tlf_index')}}" class="btn deep-orange accent-3 waves-effect waves-light tooltipped" data-position="top" data-delay="50" data-tooltip="Ir al index de Encuesta Telefónica">
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
