@extends("backend.layout.layout-noticias")
@section("title", "Configuración de iFrames")

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
            color:#FFF;
            font-size:1em;
        }
        .modal{
            max-height:100%;
            height:auto;
        }
    </style>
@endsection

@section("body")
<div class="container">
    <div class="card"> 
        <div class="card-body">
            <h5>Agregar iFrame</h5>
            <div class="row">
                <div class="row">
                <div class="col s8" style="padding:20px">
                    <div class="input-field">
                        <textarea type="text" data-length="500" maxlength="500" id="iframe" class="materialize-textarea"></textarea>
                        <label for="iframe">Código del Iframe (pegar el código del Iframe)</label>
                    </div>
                    <div class="input-field">
                        <input type="text" data-length="60" maxlength="60" id="titulo">
                        <label for="titulo">Titulo del Iframe (Descripción)</label>
                    </div>
                </div>
                <div class="col s4">
                    <div class="card gradient-45deg-purple-deep-orange">
                        <div class="card-body">
                            <p class="alert"><b>NOTA:</b> Solo agregar iframes con naturaleza de Videos (Ejm: Youtube, DailyMotion, Twitch etc...), estos Iframes seran mostrados en los contenedores dobles horizontales, los contenedores cuadruples y contenedores de portada.</p>
                        </div>
                    </div>
                </div>
            </div>
            </div>
            <br>
            <button id="saveIframe" class="btn right waves-effect waves-light gradient-45deg-purple-deep-orange" style="margin:20px"><i class="fa fa-save"></i> Guardar</button>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <table id="table" class="table table-responsive table-stripped table-hover table-border">
                <thead>
                    <tr>
                        <th class="text-center">NOMBRE</th>
                        <th class="text-center">AÑADIDO EN</th>
                        <th class="text-center">ACTIVO</th>
                        <th class="text-center">MODIFICAR</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($iframes as $iframe)
                    <tr>
                        <th class="text-center">{{ $iframe->nombre }}</th>
                        <th class="text-center">{{ \App\Tools\NoticiaTool::format($iframe->fecha_agregado) }}</th>
                        <th class="text-center">
                            <p>
                                <input type="checkbox" name="iframe{{ $iframe->id }}" id="{{ $iframe->id }}" @if($iframe->active == true) checked @endif>
                                <label onclick="checkIframe(this)" for="{{ $iframe->id }}"></label>
                            </p>
                        </th>
                        <th class="text-center"><button class="btn waves-effect waves-light gradient-45deg-purple-deep-orange" data-iframe="{{ $iframe->id }}"><i class="fa fa-gears"></i></button></th>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="modal" id="modal-iframe">
    <div class="modal-content">
        <div id="iframe-display">

        </div>
    </div>
    <div class="modal-footer">
        <button id="submit-iframe" class="waves waves-effect waves-light white-text btn-flat gradient-45deg-purple-deep-orange"><b>GUARDAR</b></button>
        <button class="waves modal-action modal-close waves-effect waves-light btn-flat white-text gradient-45deg-purple-deep-orange"><b>CANCELAR</b></button>
    </div>
</div>
@endsection

@section('javascripts')
    @parent
    <script src="{{ asset('vendors/dropzone/dropzone.min.js') }}"></script>
    <script>

        function clean(){
            $("#iframe-display").empty();
        }

        function displayModal(content){
            $("#iframe-display").append($(content));
            $("#modal-iframe").modal('open');
        }

        function checkIframe(element){
            var checked = $('#'+$(element).attr('for')).prop('checked');
            var value = $(element).attr('for');
            Materialize.toast('Espere....', 6000);
            $.ajax({
                url:'/backend/noticias/define',
                type:'POST',
                data:{
                    type:1,
                    def:1,
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

        $(function(){

            $("#modal-iframe").modal();

            $("#submit-iframe").click(function(e){
                e.preventDefault()
                try{
                    var form = $("#iframe-form");
                    var inputs = form.find('input, textarea');
                    if(inputs[0].value == "" || inputs[1].value == ""){
                        throw 'LLenar los inputs';
                    }
                    Materialize.toast('Espere....', 6000);
                    $.ajax({
                        url:'/backend/noticias/define',
                        type:'POST',
                        data:{
                            type:1,
                            def:1,
                            key:inputs[0].value,
                            label:'contenido',
                            value:inputs[1].value,
                        },
                        success: res => {
                            if(res.error){
                                return Materialize.toast(res.error, 4000);
                            } else if(res.success) {
                                Materialize.toast(res.success, 4000,'', function(){
                                    location.reload()
                                });
                            }
                        }
                    });
                } catch(e){
                    return Materialize.toast(e, 4000);
                }
            });

            $("button[data-iframe]").click(function(e){
                e.preventDefault();
                var iframe = $(this).data('iframe');
                $.post({
                    url: '/backend/noticias/showIframe',
                    data:{iframe:iframe},
                    success: r => {
                        if(r.success){
                            clean();
                            displayModal(r.success);
                        } else {
                            return Materialize.toast(r.error, 4000);
                        }
                    }
                })
            })

            $("#table").DataTable({
                language: {
                    "sProcessing": "Procesando...",
                    "sLengthMenu": "Mostrar _MENU_ registros",
                    "sZeroRecords": "No se encontraron resultados",
                    "sEmptyTable": "NingÃºn dato disponible en esta tabla",
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
                        "sLast": "Ãšltimo",
                        "sNext": "Siguiente",
                        "sPrevious": "Anterior"
                    },
                    "oAria": {
                        "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
                        "sSortDescending": ": Activar para ordenar la columna de manera descendente"
                    }
                }
            });

            $("#saveIframe").click(function(e){
                e.preventDefault();
                try {
                    var iframe = $("#iframe").val();
                    var titulo = $("#titulo").val();

                    if(iframe.length == 0 || titulo.length == 0){
                        throw 'Introduzca un Iframe y un Titulo';
                    }
                    Materialize.toast('Espere....', 6000);
                    $.ajax({
                        url:'/backend/noticias/define',
                        type:'POST',
                        data:{
                            type:0,
                            def:1,
                            value:iframe,
                            titulo:titulo
                        },
                        success: res => {
                            if(res.error){
                                return Materialize.toast(res.success, 4000)
                            } else if(res.success) {
                                swal('Exito',res.success,'success');
                                return setTimeout(function(){
                                    location.reload()
                                }, 4000)
                            }
                        }
                    });
                } catch(e) {
                    return Materialize.toast(e, 4000);
                }
            });

        });
    </script>
@endsection