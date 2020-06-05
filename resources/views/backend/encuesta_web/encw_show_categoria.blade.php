@extends("backend.layout.layout")
@section("title", "MediaMétrica | Encuesta Web - Ver")
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
                     <li><a href="{{route('encwebP2', ['id'=> $encuesta->id])}}">Parte II</a></li>
                    <li class="active">Ver</li>
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

                <div id="table-datatables">
                        <div class="row">
                        <h4 class="header">Datos de la encuesta</h4>
                        <p class="medium col s12 m12 l12"><strong>Identificador de la encuesta: </strong> {{ $encuesta->id }}</p>
                    </div>
                    
                    <div class="row">
                        <h4 class="header">Listado de candidatos de la categoría: <strong>{{ $categoria->nombre }} </strong> </h4>
                        @if($enc_cate_cand !=null)
                        <div class="col s12"><br>
                            <table id="dataTable" class="responsive-table display" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th style="text-align: center">Candidato</th>
                                        <th style="text-align: justify;">Detalle</th>
                                        @if($sum_ptos_cand[0]->bandera==1)
                                        <th style="text-align: center">Puntaje</th>
                                        @elseif($sum_ptos_cand[0]->bandera==2)
                                        <th style="text-align: center">Orden</th>
                                        @endif
                                </thead>

                                @if($sum_ptos_cand[0]->puntaje==1)
                                <tfoot>
                                    <tr>
                                        <th colspan="3">Total Puntos</th>
                                        <th colspan="1" style="text-align: center">{{ $sum_ptos_cand[0]->puntaje }}</th>
                                    </tr>
                                </tfoot>
                                @endif
                                <tbody>

                                    @php
                                    $c=0;
                                    @endphp
                                    @foreach($enc_cate_cand as $ecc)
                                    @php
                                    $c++;
                                    @endphp
                                    <tr>
                                        <td> {{ $c }} </td>
                                        <td style="text-align: center">{{ $ecc->nom_candidato }} </td>
                                        <td style="text-align: justify;">{{ $ecc->detalle }} </td>
                                        <td style="text-align: center">{{ $ecc->puntaje }}</td>
                                        @endforeach
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        @elseif($enc_cate_cand ==null)
                        <div class="col s12 center">
                            <p>Sin información para mostrar</p>
                        </div>
                        @endif

                    </div>
                </div>

                        <div class="row">
                            <div class="col s12 offset-s6 m6 offset-m6" style="text-align: right;"><br>
                                <a href="{{route('encwebP2', ['id'=> $encuesta->id])}}" class="btn deep-orange accent-3 waves-effect waves-light tooltipped" data-position="top" data-delay="50" data-tooltip="Ir a la parte II de Encuesta Web">
                                            Volver
                                            <i class="material-icons right">reply</i>
                                </a>
                            </div>  

                        </div>


            </div> <!-- card-panel-->
        </div>
    </div>
</div>

@endsection
@section('javascripts')
@parent
@endsection
