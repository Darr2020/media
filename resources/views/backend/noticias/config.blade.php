@extends("backend.layout.layout-noticias")

@section("title", "MediaMétrica | Configuración de Grilla")

@section("stylesheets")
    @parent
    <link rel="stylesheet" href="{{ asset('css/noticias/config.noticia.css') }}"/>
@endsection

@section("body")
    @if(Auth::user()->is('escritor'))
    <ul class="tabs z-depth-1">
        <li class="tab col s3 full"><a class="active" href="#categorias">GRILLAS</a></li>
    </ul>
    @else
    <ul class="tabs z-depth-1">
        <li class="tab col s3 third"><a href="#principal">BLOQUES</a></li>
        <li class="tab col s3 third"><a class="active" href="#categorias">GRILLAS</a></li>
    </ul>
    @endif

    @if(Auth::user()->is(['editor','admin']))
    <div id="principal" class="tab-target">
        @include('backend.noticias.parts.bloques')
    </div>
    @endif
    <div id="categorias" class="tab-target">
        @include('backend.noticias.parts.grillas')
    </div>

    <div id="modal-grid" class="modal">
        <div class="modal-heading">
            <h4>DEFINIR GRILLA DE POSICIÓN <b id="grid-position"></b></h4>
        </div>
        <div class="modal-content" id="modal-grid-container">

        </div>
        <div class="modal-footer">
            <button id="modal-grid-button" class="waves waves-effect waves-light white-text btn-flat gradient-45deg-purple-deep-orange"><b>GUARDAR</b></button>
            <button class="waves modal-action modal-close waves-effect waves-light btn-flat white-text gradient-45deg-purple-deep-orange"><b>CANCELAR</b></button>
        </div>
    </div>

    <div id="modal-element" class="modal">
        <div class="modal-heading">
            <h4>DEFINIR ELEMENTO EN POSICIÓN <b id="grid-element"></b></h4>
        </div>
        <div class="modal-content" id="modal-grid-element">
            <form id="element-form">
                <input type="hidden" name="element">
                <div class="input-field">
                    <select name="type" id="type" class="materialize-select">
                        <option value="1">Noticias</option>
                        <option value="2">iFrame</option>
                        <option value="3">Publicidad</option>
                    </select>
                    <label for="type">Tipo de Elemento</label>
                </div><br>
                <div class="types">
                    <div id="select-iframe" class="hidden">
                        <div class="input-field col s12">
                            <select name="iframe" id="iframe" class="materialize-select">
                                @foreach($iframes as $n)
                                    <option value="{{ $n->id }}">{{ $n->nombre }}</option>
                                @endforeach
                            </select>
                            <label for="iframe">Iframe</label>
                        </div>
                    </div>
                    <div id="select-noticia" class="hidden">
                        <div class="input-field col s12">
                            <select name="noticia" id="noticia" class="materialize-select">
                                <option value="undefined">SIN DEFINIR</option>
                                @foreach($noticias as $n)
                                    <option value="{{ $n->id }}">{{ $n->titulo }}</option>
                                @endforeach
                            </select>
                            <label for="noticia">Noticia</label>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="modal-footer">
            <button id="modal-element-button" class="waves waves-effect waves-light white-text btn-flat gradient-45deg-purple-deep-orange"><b>GUARDAR</b></button>
            <button class="waves modal-action modal-close waves-effect waves-light btn-flat white-text gradient-45deg-purple-deep-orange"><b>CANCELAR</b></button>
        </div>
    </div>

@endsection

@section('javascripts')
    @parent
    <script>
        
        function select(element){
            $(".picture.selected").removeClass('selected');
            $(element).addClass('selected');
        }

        function restart(){
            $("b#grid-element").text('');
            $("input[name='element']").val('');
            $("#select-iframe").hide();
            $("#select-noticia").hide();
        }

        function procesamiento(type){
            var data = {type:type,form:2, key:$("input[name='element']").val()}
            if(type == 1){
                data.value = $("#noticia").val();
            } else if(type == 2) {
                data.value = $("#iframe").val();
            }
            swal({
                title: '¿Estas segur@?',
                text: 'Este cambio no puede ser revertido.',
                type: 'question',
                showCancelButton: true,
                cancelButtonColor: '#FF2020',
                cancelButtonText: 'Cancelar',
                confirmButtonText: 'Aceptar'
            }).then(function (result) {
                if (result.value) {
                    Materialize.toast('Espere....', 6000);
                    $.ajax({
                        url:'/backend/noticias/update',
                        data:data,
                        type:'POST',
                        success: function(r){
                            if(r.error){
                                return swal('ERROR',r.error,'error')
                            } else if(r.success) {
                                return swal('Configuración Cambiada',r.success,'success').then(function(result){
                                    location.reload();
                                });
                            }
                        }
                    })
                }
            });
        }

        @if(Auth::user()->is(['admin','editor']))
        function revert(){
            Materialize.toast('Espere....', 6000);
            $.ajax({
                url:'/backend/noticias/authorize',
                type:'POST',
                data:{type:2},
                success: function(r){
                    if(r.error){
                        return Materialize.toast(r.error, 1000);
                    } else if(r.success) {
                        return Materialize.toast(r.success, 1000);
                    }
                }
            })
        }
        @endif

        $(function(){

            $('button[href]').click(function(e){
                e.preventDefault()
                window.open($(this).attr('href'),'_blank')
            })
            @if(Auth::user()->is(['admin','editor']))
            $("#authorize").click(function(e) {
                e.preventDefault();
                swal({
                    title: '¿Estas segur@?',
                    text: 'Este cambio alterará grandemente la vista de la página principal. Solo podras revertir este cambio una vez.',
                    type: 'question',
                    showCancelButton: true,
                    cancelButtonColor: '#FF2020',
                    cancelButtonText: 'Cancelar',
                    confirmButtonText: 'Aceptar'
                }).then(function (result) {
                    if (result.value) {
                        Materialize.toast('Espere....', 6000);
                        $.ajax({
                            url:'/backend/noticias/authorize',
                            type:'POST',
                            data:{type:1},
                            success: function(r){
                                if(r.error){
                                    return Materialize.toast(r.error, 1000);
                                } else if(r.success) {
                                    return Materialize.toast(r.success+' <span class="revert" onclick="revert()"> Revertir</span>');
                                }
                            }
                        })
                    }
                });
            });
            @endif

            

            $("button#modal-element-button").click(function(e){
                e.preventDefault();
                var active_type = $("select[name='type']");
                if(active_type.val() == 1){
                    procesamiento(1);
                } else if (active_type.val() == 2) {
                    if($("#iframe").val() == ''){
                        return swal('Error','Introduzca un iframe','error');
                    } else {
                        procesamiento(2);
                    }
                } else {
                    procesamiento(3);
                }
            });

            $('button[data-element]').click(function(e){
                e.preventDefault();
                var assign = $(this).data('element');
                var type = 2;
                Materialize.toast('Espere....', 6000);
                $.ajax({
                    url:'/backend/noticias/modal',
                    data: {
                        assign: assign,
                        type: type,
                    },
                    type:'POST',
                    success: function(r){
                        if(r.error) {
                            return swal('ERROR',r.error,'error');
                        } else if(r.data) {
                            restart()
                            $("b#grid-element").text(r.data.element_position + 1);
                            $("input[name='element']").val(r.data.key);
                            if(r.data.type == 1){
                                $("#select-iframe").hide();
                                $("#select-noticia").show();
                            } else if(r.data.type == 2) {
                                $("#select-iframe").show();
                                $("#select-noticia").hide();
                            }
                            $("#modal-element").modal('open');
                        }
                    }
                })
            });

            $('select[name="type"]').change(function(e){
                if($(this).val() == 1) {
                    $("#select-iframe").fadeOut();
                    $("#select-noticia").fadeIn();
                } else if ($(this).val() == 2) {
                    $("#select-iframe").fadeIn();
                    $("#select-noticia").fadeOut();
                } else if ($(this).val() == 3) {
                    $("#select-iframe").fadeOut();
                    $("#select-noticia").fadeOut();
                }
            });

            $("button#modal-grid-button").click(function(e){
                e.preventDefault()
                try {
                    var selected = $($("img.picture.selected")[0]);
                    
                    if(selected.length != 1)
                        throw 'Seleccione una Grilla';

                    swal({
                        title: '¿Estas segur@?',
                        text: 'Este cambio alterará grandemente la vista de la página principal.',
                        type: 'question',
                        showCancelButton: true,
                        cancelButtonColor: '#FF2020',
                        cancelButtonText: 'Cancelar',
                        confirmButtonText: 'Aceptar'
                    }).then(function (result) {
                        if (result.value) {
                            Materialize.toast('Espere....', 6000);
                            $.ajax({
                                url:'/backend/noticias/update',
                                data:{
                                    key: selected.data('key'),
                                    position: selected.data('position'),
                                    form:4,
                                },
                                type:'POST',
                                success: function(r){
                                    if(r.error){
                                        return swal('ERROR',r.error,'error')
                                    } else if(r.success) {
                                        return swal('Configuración Cambiada',r.success,'success').then(function(result){
                                            location.reload();
                                        });
                                    }
                                }
                            })
                        }
                    });
                
                } catch(e) {
                    swal('Error', e, 'error');
                }

            });

            $('.modal').modal()

            $('#elementTable').DataTable({
                lengthMenu: [[20, 40, 60, 100, 500, -1], [20, 40, 60, 100, 500, "Todos"]],
                "language": {
                    "sProcessing": "Procesando...",
                    "sLengthMenu": "Mostrar _MENU_ registros",
                    "sZeroRecords": "No se encontraron resultados",
                    "sEmptyTable": "Ningún dato disponible en esta tabla",
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
                        "sLast": "Último",
                        "sNext": "Siguiente",
                        "sPrevious": "Anterior"
                    },
                    "oAria": {
                        "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
                        "sSortDescending": ": Activar para ordenar la columna de manera descendente"
                    }
                }
            });

            $('#gridTable').DataTable({
                lengthMenu: [[20, 40, 60, 100, 500, -1], [20, 40, 60, 100, 500, "Todos"]],
                "language": {
                    "sProcessing": "Procesando...",
                    "sLengthMenu": "Mostrar _MENU_ registros",
                    "sZeroRecords": "No se encontraron resultados",
                    "sEmptyTable": "Ningún dato disponible en esta tabla",
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
                        "sLast": "Último",
                        "sNext": "Siguiente",
                        "sPrevious": "Anterior"
                    },
                    "oAria": {
                        "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
                        "sSortDescending": ": Activar para ordenar la columna de manera descendente"
                    }
                }
            });

            $("button[data-assign]").click(function(e){
                e.preventDefault()
                var assign = $(this).data('assign');
                var type = $(this).data('type');
                var position = $(this).data('position');
                Materialize.toast('Espere....', 6000);
                $.ajax({
                    url:'/backend/noticias/modal',
                    data: {
                        assign: assign,
                        type: type,
                    },
                    type:'POST',
                    success: function(r){
                        if(r.html){
                            $("div#modal-grid-container").empty();
                            $("#grid-position").text(position);
                            $("div#modal-grid-container").append(r.html);
                            $("#modal-grid").modal('open');
                        } else if(r.error) {
                            return swal('ERROR',r.error,'error');
                        }
                    }
                })
            });

            $("#saveConfig").click(function(e){
                e.preventDefault();
                swal({
                    title: '¿Estas seguro?',
                    text: 'Este cambio alterará grandemente la vista de la página principal.',
                    type: 'question',
                    showCancelButton: true,
                    cancelButtonColor: '#FF2020',
                    cancelButtonText: 'Cancelar',
                    confirmButtonText: 'Aceptar'
                }).then(function (result) {
                    if (result.value) {
                        Materialize.toast('Espere....', 6000);
                        $.ajax({
                            url:'/backend/noticias/updateMainConfig',
                            data: {
                                cantidad_main: $("#cantidadMaxima").val(),
                                cantidad_categoria: $("#cantidadCategoria").val(),
                            },
                            type:'POST',
                            success: function(r){
                                if(r.error){
                                    return swal('ERROR',r.error,'error')
                                } else if(r.success) {
                                    return swal('Configuración Cambiada',r.success,'success').then(function(result){
                                        location.reload();
                                    });
                                }
                            }
                        })
                    }
                });
            });

        });
    </script>
@endsection
