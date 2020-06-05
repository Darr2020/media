@extends("backend.layout.layout-noticias")
@section("title", "MediaMétrica | Publicación")

@section("stylesheets")
    @parent
    <style>
        .container{ padding:20px; }
        .btn-60{ width:60%;padding:5px;font-size:1em;}
        .btn-80{ width:80%;padding:5px;font-size:1em;}
    </style>
@endsection

@section("body")
<div class="container">
    <table id="noticias-table" class="striped highlight centered responsive-table">
        <thead>
            <tr>
                <th>Título</th>
                <th>Categoria</th>
                <th>Escritor</th>
                <th>Fecha de Escritura</th>
                <th>Publicado</th>
                <th>Acción</th>
            </tr>
        </thead>
        <tbody></tbody>
    </table>
</div>
@endsection

@section('javascripts')
    @parent
    <script>
    $(function(){

        $("#noticias-table").DataTable({
            ajax: {
                url: "noticias/show-datatable",
                type: "POST",
                dataSrc:'data',
            },
            columns: [
                { data: 'titulo' },
                { data: 'categoria' },
                { data:'nombre' },
                { data: 'fecha_esc' },
                { 
                    data: null, 
                    render: function(o){ 
                        if(o.published){
                            return '<p><input type="checkbox" class="publish" id="'+o.id+'" checked><label onclick="checkNew(this)" for="'+o.id+'"></label></p>';
                        } else {
                            return '<p><input type="checkbox" class="publish" id="'+o.id+'"><label onclick="checkNew(this)" for="'+o.id+'"></label></p>';
                        }
                    } 
                },
                {
                    data: null,
                    orderable: false,
                    render: function(o){
                        return '<a target="_blank" href="/backend/ver/test/'+o.id+'" class="btn waves-effect waves gradient-45deg-light-blue-cyan gradient-shadow">DETALLES</a>'
                    }
                }
            ],
            lengthMenu: [[20, 40, 60, 100, 500, -1], [20, 40, 60, 100, 500, "Todos"]],
            dom: 'Blfrtip',
            processing: true,
            serverSide: true,
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
        })            
    })
    
    function checkNew(element){
        var id = $(element).attr('for');
        var valor = $('#'+id).prop('checked');
        $.ajax({
            url:'/backend/noticias/publicar',
            type:'post',
            data: {noticia: id, action: (!valor) ? 'pub':'des'},
            success: res => {
                if(res.success) {
                    Materialize.toast(res.success, 4000);
                } else if(res.error) {
                    Materialize.toast(res.error, 4000);
                    $('#'+id).prop('checked', valor)
                }
            }
        });
    }
    </script>
@endsection