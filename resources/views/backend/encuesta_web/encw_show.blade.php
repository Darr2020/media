@extends("backend.layout.layout")
@section("title", "MediaMétrica | Encuesta Web - Resumen")
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
                        <p class="medium col s12 m12 l12"><strong>Identificador de la encuesta: </strong> {{ $encuesta->id }}</p>
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
                                        @if($bandera== 1)
                                        <th>Puntaje</th>
                                        @else
                                        <th>Orden</th>
                                        @endif
                                        
                                    </tr>
                                </thead>
                                @if($bandera == 1)
                                <tfoot>
                                    <tr>
                                        <th>Candidato</th>
                                        <th>Detalle</th>
                                        <th>Categoria</th>
                                        <th>Puntaje</th>
                                    </tr>
                                </tfoot>
                                @endif
                                <tbody>
                                    @foreach($info_candidatos as $ican)
                                    <tr>
                                        <td>{{ $ican->nom_candidato }}</td>
                                        <td>{{ $ican->det_candidato }}</td>
                                        <td>{{ $ican->nom_categoria }}</td>
                                        <td>{{ $ican->puntaje }}</td>
                                        @endforeach    
                                    </tr>
                                </tbody>
                            </table>
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
