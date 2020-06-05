@extends("backend.layout.layout-noticias")
@section("title", "Configuración de Publicidad")

@section('stylesheets')
    @parent
    <link rel="stylesheet" href="{{ asset('vendors/dropzone/dropzone.min.css') }}">
    <style>
        .card-body{
            padding:20px;
        }
        .container{
            margin-top:10px;
        }
        .alert{
            padding:10px;
            border-radius:10px;
            font-weight:bold;
            color:#FFF;
            font-size:1em;
        }
        .dropify-wrapper .dropify-message p{
            text-align:center;
        }
    </style>
@endsection

@section("body")
<div class="container" ng-controller="publicidadController">
    <div class="card"> 
        <div class="card-body">
            <h5>NUEVO BANNER PUBLICITARIO</h5>
            <form id="pub-form" name="pubform" id="pubform">
                <div class="row">
                    <div class="col s12 m4 l3">
                        <div class="card gradient-45deg-light-blue-cyan gradient-shadow">
                            <div class="card-content white-text">
                                <span class="card-title">Portada</span>
                                <p>
                                Cargar imagenes con dimensiones acordes al tipo descrito en la parte inferior, un peso de máximo <span class="gradient-45deg-purple-deep-orange-text"><b>2MB</b><br>
                                Alto: <span class="gradient-45deg-purple-deep-orange-text"><b>500x1000px</b><br>
                                Cuadrado: <span class="gradient-45deg-purple-deep-orange-text"><b>500x500px</b><br>
                                Largo: <span class="gradient-45deg-purple-deep-orange-text"><b>1000x500px</b>
                                </p>
                            </div>
                        </div>
                        <div class="gradient-45deg-purple-deep-orange gradient-shadow">
                            <div class="card-content white-text">
                                <p>Cuanto más peso tenga un banner, mayor sera su visibilidad en la página</p>
                            </div>
                        </div>
                    </div>
                    <div class="col s12 m8 l9">
                        <input type="file" id="image" data-height="360px" class="dropify" data-max-file-size="2.5M" data-allowed-file-extensions="png jpg jpeg" ng-required required/>
                    </div>
                </div>
                <div class="container">
                    <div class="row">
                        <div class="col s12 m6 l8">
                            <div class="input-field">
                                <input type="number" data-length="5" maxlength="5" ng-maxlength="5" name="peso" ng-model="peso" id="peso" ng-required required>
                                <label for="peso">Peso de la Publicidad</label>
                            </div>
                            <div class="input-field">
                                <input type="text" data-length="50" maxlength="50" name="nombre" ng-model="nombre" id="nombre" ng-required required>
                                <label for="nombre">Nombre del Banner</label>
                            </div>
                            <div class="input-field">
                                <input type="text" data-length="110" maxlength="110" name="link" ng-model="link" id="link" ng-required required>
                                <label for="link">Link de Redirección</label>
                            </div>
                        </div>
                        <div class="col s12 m6 l4">
                            <p>Tipo de Banner:</p>
                            <p>
                                <input class="with-gap" type="radio" name="position" ng-model="position" value="1" id="cuadrado" required>
                                <label for="cuadrado">Cuadrado</label>
                            </p>
                            <p>
                                <input class="with-gap" type="radio" name="position" ng-model="position" value="2" id="horizontal" required>
                                <label for="horizontal">Horizontal</label>
                            </p>
                            <p>
                                <input class="with-gap" type="radio" name="position" ng-model="position" value="3" id="vertical" required>
                                <label for="vertical">Vertical</label>
                            </p>
                        </div>
                    </div>
                </div>
                <button ng-click="savePublicidad($event)" class="btn right waves-effect waves-light gradient-45deg-purple-deep-orange" style="margin:20px"><i class="fa fa-save"></i> Guardar</button>
            </form>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <table id="table" class="table table-responsive table-stripped table-hover table-border">
                <thead>
                    <tr>
                        <th class="text-center">NOMBRE</th>
                        <th class="text-center">PESO</th>
                        <th class="text-center">AÑADIDO EN</th>
                        <th class="text-center">ACTIVO</th>
                        <th class="text-center">MODIFICAR</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($publicidad as $p)
                    <tr>
                        <th class="text-center">{{ $p->nombre }}</th>
                        <th class="text-center">{{ $p->peso }}</th>
                        <th class="text-center">{{ \App\Tools\NoticiaTool::format($p->fecha_agregado) }}</th>
                        <th class="text-center">
                            <p>
                                <input type="checkbox" name="publicidad{{ $p->id }}" id="{{ $p->id }}" @if($p->active == true) checked @endif>
                                <label onclick="checkPublicidad(this)" for="{{ $p->id }}"></label>
                            </p>
                        </th>
                        <th class="text-center"><button class="btn waves-effect waves-light gradient-45deg-purple-deep-orange" ng-click="displayModal($event,{{ $p->id }})"><i class="fa fa-gears"></i></button></th>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    
    <div class="modal" id="modal-publicidad">
        <div class="modal-content">
            <div id="publicidad-display">

            </div>
        </div>
        <div class="modal-footer">
            <button ng-click="modifyBanner($event)" class="waves waves-effect waves-light white-text btn-flat gradient-45deg-purple-deep-orange"><b>GUARDAR</b></button>
            <button class="waves modal-action modal-close waves-effect waves-light btn-flat white-text gradient-45deg-purple-deep-orange"><b>CANCELAR</b></button>
        </div>
    </div>


</div>

@endsection

@section('javascripts')
    @parent
    <script src="{{ asset('vendors/dropzone/dropzone.min.js') }}"></script>
    <script>

    function clean(){
        $("#publicidad-display").empty();
    }

    function displayModal(content){
        $("#publicidad-display").append($(content));
        $("#modal-publicidad").modal('open');
    }

    function checkPublicidad(element){
        var checked = $('#'+$(element).attr('for')).prop('checked');
        var value = $(element).attr('for');
        Materialize.toast('Espere....', 6000);
        $.ajax({
            url:'/backend/noticias/define',
            type:'POST',
            data:{
                type:1,
                def:0,
                key:value,
                label:'active',
                value:!checked,
            },
            success: res => {
                if(res.error){
                    return Materialize.toast(res.error, 4000);
                } else if(res.success) {
                    return Materialize.toast(res.success, 4000);
                }
            }
        });
    }

    app.controller('publicidadController', ['$http','$scope', ($http, $scope) => {
        
        $scope.image = [];

        $scope.modifyBanner = $event => {
            $event.stopPropagation()
            try {

                var form = $("#modify-form").find('input');
                var data = {};
                form.each(function(e){
                    if(this.value == ""){
                        throw 'Existen valor por llenar'
                    }
                    data[this.name] = this.value;
                });
                Materialize.toast('Espere....', 6000);
                $http.post('/backend/noticias/updateBanner', data).then(res => {
                    if(res.data.success){
                        return swal('EXITO', res.data.success, 'success');
                    } else if(res.data.error) {
                        return Materialize.toast(res.data.error, 4000);
                    }
                });

            } catch(e) {
                return Materialize.toast(e, 4000);
            }
        }

        $scope.displayModal = ($event, id) => {
            $event.stopPropagation()
            try {
                Materialize.toast('Espere....', 6000);
                $http.post('/backend/noticias/showPublicidad',{publicidad:id}).then(res => {
                    if(res.data.success){
                        clean();
                        displayModal(res.data.success);
                    } else if(res.data.error){
                        throw res.data.error
                    }
                });

            } catch (e) {
                return Materialize.toast(e, 4000);
            }
        }
        
        $scope.savePublicidad = $event => {
            $event.stopPropagation()
            try {

                if(!$scope.pubform.$valid){
                    throw 'Complete todos los campos';
                }

                if($scope.image.length < 1){
                    throw 'Agregue una imagen a la publicidad';
                }

                var form = new FormData();

                form.append('type',0);
                form.append('def',0);
                form.append('image', $scope.image);
                form.append('value', $scope.nombre);
                form.append('peso', $scope.peso);
                form.append('tipo_banner', $scope.position);
                form.append('link', $scope.link);

                $.post({
                    url:'/backend/noticias/define',
                    data:form,
                    processData: false,
                    contentType: false,
                    success: res => {
                        if(res.success){
                            return Materialize.toast(res.success, 4000, '', function(){
                                location.reload();
                            });
                        } else if(res.error) {
                            return Materialize.toast(res.error, 4000);
                        }
                    }
                });

            } catch(e){
                return Materialize.toast(e, 4000);
            }
        }
        
        angular.element('document').ready(function(){

            $('.modal').modal()

            $("#image").on('change', function(e){
                var files = $(this).prop('files')[0]
                var scope = angular.element('div[ng-controller]').scope();
                scope.$apply($scope => {
                    $scope.image = files
                });
            });

            $("#table").DataTable({
                language: {
                    "sProcessing": "Procesando...",
                    "sLengthMenu": "Mostrar _MENU_ registros",
                    "sZeroRecords": "No se encontraron resultados",
                    "sEmptyTable": "Ningun dato disponible en esta tabla",
                    "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                    "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
                    "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
                    "sInfoPostFix": "",
                    "sSearch": "Buscar:",
                    "sUrl": "",
                    "sInfoThousands": ",",
                    "sLoadingRecords": "Cargando...",
                    "oPaginate": {
                        "sFirst": "Primero",
                        "sLast": "Ultimo",
                        "sNext": "Siguiente",
                        "sPrevious": "Anterior"
                    },
                    "oAria": {
                        "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
                        "sSortDescending": ": Activar para ordenar la columna de manera descendente"
                    }
                }
            });
        });

    }]);
    </script>
@endsection