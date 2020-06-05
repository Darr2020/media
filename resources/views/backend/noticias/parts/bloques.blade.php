<div class="container">
    <div class="card">
        <div class="card-body" style="height:200px">
            <div class="row">
                <div class="col s6">
                    <div class="input-field">
                        <select name="cantidadMaxima" id="cantidadMaxima">
                            <option value="50" @if($config->cantidad_maxima_principal == 50) selected @endif>50 Noticias</option>
                            <option value="100" @if($config->cantidad_maxima_principal == 100) selected @endif>100 Noticias</option>
                            <option value="150" @if($config->cantidad_maxima_principal == 150) selected @endif>150 Noticias</option>
                        </select>
                        <label for="cantidadMaxima">Cantidad Maxima de Noticias:</label>
                    </div>
                </div>
                <div class="col s6">
                    <div class="input-field">
                        <select name="cantidadCategoria" id="cantidadCategoria">
                            <option value="50" @if($config->cantidad_maxima_categoria == 50) selected @endif>50 Noticias</option>
                            <option value="100" @if($config->cantidad_maxima_categoria == 100) selected @endif>100 Noticias</option>
                            <option value="150" @if($config->cantidad_maxima_categoria == 150) selected @endif>150 Noticias</option>
                        </select>
                        <label for="cantidadCategoria">Cantidad Maxima de Categoria:</label>
                    </div>
                </div>
            </div>
            <button class="btn waves-effect waves-light gradient-45deg-light-blue-cyan gradient-shadow" id="saveConfig">Guardar</button>
            <button class="btn waves-effect waves-light gradient-45deg-purple-deep-orange" id="authorize">Autorizar Cambios</button>
            <button class="btn waves-effect waves-light gradient-45deg-light-blue-cyan gradient-shadow" href="{{ route('noticias_test') }}"> VISTA PREVIA </button>
        </div>
    </div>
    <div class="card">
        <div class="card-body">    
            <table id="gridTable" class="responsive-table display" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th class="text-center" width="15%">POSICIÓN #</th>
                        <th class="text-center" width="30%">TIPO</th>
                        <th class="text-center" width="10%">IMAGEN</th>
                        <th class="text-center" width="20%">MODIFICAR</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($grids as $key => $g)
                    <tr>
                        <th class="text-center">{{ $g->position }}</th>
                        <th class="text-center">{{ $g->label }}</th>
                        <th class="text-center"><img height="50px" width="100px" src="{{ asset('images/noticias/grilla_layouts/'.$g->type.'.png') }}" alt="{{ $g->label }}"></th>
                        <th class="text-center">
                            <button class="btn waves-effect waves-light gradient-45deg-purple-deep-orange" data-type="1" data-assign="{{ $key }}" data-position="{{ $g->position }}"><i class="fa fa-gears"></i></button>
                        </th>
                    </tr>
                    @endforeach
                </tbody>               
            </table>  
        </div>
    </div>
</div>