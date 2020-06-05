<div class="container">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="input-field col s4">
                    <input type="text" value="{{ count($elements) }}" id="cantidadElementos" disabled>
                    <label for="cantidadElementos">Cantidad Maxima de Cacillas Editables</label>
                </div>  
            </div>
            <table id="elementTable" class="responsive-table display" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th class="text-center" width="10%">BLOQUE</th>
                        <th class="text-center" width="10%">POSICIÓN</th>
                        <th class="text-center" width="40%">CONTENIDO</th>
                        <th class="text-center" width="20%">TIPO DE ELEMENTO</th>
                        <th class="text-center" width="40%">TIPO DE BLOQUE</th>
                        <th class="text-center" width="10%">MODIFICAR</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($elements as $key => $e)
                        <tr>
                            <th class="text-center" width="10%">{{ $e->grid_position }}</th>
                            <th class="text-center" width="10%">
                                <img src="{{ asset('images/noticias/elements_layouts/'.$e->image.".png") }}" height="50px" width="100px" alt="{{ $e->image }}">
                            </th>
                            <th class="text-center" width="40%">{{ $e->value }}</th>
                            <th class="text-center" width="20%">{{ $e->type }}</th>
                            <th class="text-center" width="40%">{{ $e->label }}</th>
                            <th class="text-center" width="10%">
                                <a class="btn waves-effect waves-light gradient-45deg-light-blue-cyan gradient-shadow" href="{{ route("define_specific_item", ['key' => $key]) }}"><i class="fa fa-gears"></i></button>
                            </th>
                        </tr>
                    @endforeach
                </tbody>               
            </table>
        </div>
    </div>
</div>