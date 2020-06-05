@extends('backend.layout.layout-noticias')

@section("title", "Definir Contenido de Elemento")

@section('stylesheets')
    @parent
    <style>
        div.card {margin-top:20px}
        div.card-body {padding:20px}
        div.card-body h4 {
            text-align:center;
            text-transform:uppercase;
            }
        .alert p {
            font-size:1.3em;
            color:#FFF;
            text-transform:uppercase;
            font-weight:bold;
        }
        .card-body.alert p {
            font-size:1em;
            color:#FFF;
            text-transform:uppercase;
            font-weight:bold;
        }
    </style>
@endsection

@section("body")
<div class="container" ng-controller="defController">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col s6">
                    <h5>{{ $layout->label  }}</h5>
                    <p>BLOQUE: <b>#{{ $elemento->grid_position }}</b></p>
                    <p>POSICIÓN: <b>#{{ $elemento->element_position + 1 }}</b></p>
                    <p>Elemento Actual: <b>{{ ($info["value"]) ? $info["value"]:'AUTOMATICO' }}</b></p>
                    <p>Tipo de Elemento: <b>{{ $info["type"] }}</b></p>
                    <p></p>
                </div>
                <div class="col s6">
                    <img src="{{ asset('images/noticias/elements_layouts/'.$grid->type."-0".($elemento->element_position + 1)).".png" }}" height="150" width="300" alt="{{ $layout->label  }}">
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <h4>Noticias</h4>
            <table class="table table-hover table-stripped">
                <thead>
                    <tr>
                        <th width="40%">TITULO</th>
                        <th width="20%">FECHA DE CREACIÓN</th>
                        <th width="20%">FECHA DE PUBLICACIÓN</th>
                        <th width="20%">ACCIÓN</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($noticias as $n)
                        <tr>
                            <th width="40%">{{ $n->titulo }}</th>
                            <th width="20%">{{ \App\Tools\NoticiaTool::format($n->fecha_esc) }}</th>
                            <th width="20%">{{ \App\Tools\NoticiaTool::format($n->fecha_publish) }}</th>
                            <th width="20%">
                                <button class="btn gradient-45deg-light-blue-cyan waves-effect waves" ng-click="define($event,{{ $position }},1,{{ $n->id }})"><i class="fa fa-check"></i></button>
                            </th>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <button class="btn gradient-45deg-purple-deep-orange waves waves-effect" ng-click="define($event,{{ $position }},1,null)"><b>AUTOMATICO</b></button>
        </div>
    </div>
    
    @if($iframes)
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col s6">
                    <h4 class="gradient-45deg-purple-deep-orange-text">Iframes de Videos</h4>
                </div>
                <div class="col s6">
                    <div class="card gradient-45deg-purple-deep-orange">
                        <div class="card-body alert">
                            <p>Debido a temas de distorción y proporción : los videos solo se veran en contenedores de 4 espacios y contenedores dobles horizontales</p>
                        </div>
                    </div>
                </div>
            </div>
            <table class="table table-hover table-stripped">
                <thead>
                    <th>Titulo</th>
                    <th>Fecha de Creación</th>
                    <th>Acción</th>
                </thead>
                <tbody>
                    @foreach($iframes as $i)
                        <tr>
                            <th>{{ $i->nombre }}</th>
                            <th>{{ \App\Tools\NoticiaTool::format($i->fecha_agregado) }}</th>
                            <th>
                                <button class="btn gradient-45deg-purple-deep-orange waves-effect waves" ng-click="define($event,{{ $position }},2,{{ $i->id }})"><i class="fa fa-check"></i></button>
                            </th>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @else
    <div class="card alert gradient-45deg-purple-deep-orange">
        <div class="card-body">
            <p>Debido al tamaño del contenedor, no se puede colocar iframes en el mismo por causas de distorción</p>
        </div>
    </div>
    @endif

    @if($publicidad)
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col s6">
                    <h4 class="gradient-45deg-purple-deep-orange-text">Banners Publicitarios</h4>
                </div>
                <div class="col s6">
                    <div class="card  gradient-45deg-light-blue-cyan">
                        <div class="card-body alert">
                            <p>Algunos banners podrian no aparecer por no encajar con el tamaño del elemento</p>
                        </div>
                    </div>
                </div>
            </div>
            <table class="table table-hover table-stripped">
                <thead>
                    <th>Titulo</th>
                    <th>Fecha de Creación</th>
                    <th>Acción</th>
                </thead>
                <tbody>
                    @foreach($publicidad as $p)
                        <tr>
                            <th>{{ $p->nombre }}</th>
                            <th>{{ \App\Tools\NoticiaTool::format($p->fecha_agregado) }}</th>
                            <th>
                                <button class="btn gradient-45deg-light-blue-cyan waves-effect waves" ng-click="define($event,{{ $position }}, 3, {{ $p->id }})"><i class="fa fa-check"></i></button>
                            </th>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <button class="btn gradient-45deg-light-blue-cyan waves waves-effect" ng-click="define($event,{{ $position }},3,null)"><b>AUTOMATICO</b></button>
        </div>
    </div>
    @else
    <div class="card alert gradient-45deg-purple-deep-orange">
        <div class="card-body">
            <p>Debido al tamaño del contenedor, no se pueden colocar banners publicitarios</p>
        </div>
    </div>
    @endif

</div>
@endsection

@section('javascripts')
    @parent
    <script>
        app.controller('defController', ['$scope','$http', ($scope, $http) => {

            $scope.define = ($event, position, type, id) => {
                $event.stopPropagation();
                var data = { id:id, key:position, type:type };
                swal({
                    title: '¿Estas segur@?',
                    text: 'Al realiza esta acción podrias reemplazar un elemento fijado por otro Usuario.',
                    type: 'question',
                    showCancelButton: true,
                    cancelButtonColor: '#FF2020',
                    cancelButtonText: 'Cancelar',
                    confirmButtonText: 'Aceptar'
                }).then(function (result) {
                    if (result.value) {
                        Materialize.toast('Espere....', 6000);
                        $("button.btn").prop('disabled', true);
                        $http.post('/backend/noticias/defineSpecElement', data ).then(res => {
                            if(res.data.success){
                                swal('EXITO',res.data.success,'success');
                                return setTimeout(function(){
                                    location.href="/backend/noticias/configuracion";xº
                                }, 3000);
                            } else if(res.data.error){
                                $("button.btn").prop('disabled',false);
                                return Materialize.toast(res.data.error,4000);
                            }
                        });     
                    }
                });
            }
            
            angular.element('[ng-controller]').ready(function(){
                
                $(".table").DataTable({
                    language:lang
                });

            });
        }]);
    </script>
@endsection
