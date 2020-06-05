<div class="col s12 m12 l12">
    <form id="consultcand" name="consultcand">
        <h4 class="header">Consulta de la Categoria: {{$params['data']['categoria'][0]->nombre}}</h4>
        <div class="row">
            <div class="col s12 m12 l12" style="padding: 0px;">
                <div id="d" class="col s12 m8 l8 waves-effect waves-light btn gradient-45deg-red-pink z-depth-4 mr-1 bordde">
                    <a href="javascript:void(0);" onclick="dt()" style="color: #fff !important; font-size: 18px;">Datos Básicos</a>
                </div>
                <div id="c" class="col s12 m1 l1 waves-effect waves-light btn gradient-45deg-green-teal z-depth-4 mr-1 bordde">
                    <a href="javascript:void(0);" onclick="op()" style="color: #fff !important; font-size: 18px;">Opciones o Campos</a>
                </div>
                @if($params['data']['generos'] != false)
                <div id="g" class="col s12 m1 l1 waves-effect waves-light btn gradient-45deg-light-blue-cyan z-depth-4 mr-1 bordde">
                    <a href="javascript:void(0);" onclick="gen()" style="color: #fff !important; font-size: 18px;">Géneros de la Categoria</a>
                </div>
                @endif
            </div>
            <br><br>
            <div class="divider"></div>
            <div id="datos" class="col s12">
                <br> <br>
                <font style="font-weight: bold;">Descripción de la Categoria:</font>
                <p class="text-justify">
                    {{$params['data']['categoria'][0]->descateg}}
                    <br> <br> 
                </p>

                <font style="font-weight: bold;">Descripción del tipo de Candidato:</font>
                <p class="text-justify">
                    {{$params['data']['categoria'][0]->descand}}
                    <br> <br> <br> <br> 
                </p>
            </div>
            <div id="campos" class="col s12" style="display: none;">
                <br> <br>
                <font style="font-weight: bold;">Campos requeridos:</font>
                <p class="text-justify">
                    @foreach($params['data']['opciones'] as $key =>$r)
                <div class="col s6 m8 l8">
                    Nombre del candidato u opción:
                </div>
                <div class="col s6 m3 l3">
                    {{($r->nombre == true) ? "SI":"NO"}}<br>
                </div>
                <div class="col s6 m8 l8">
                    Información del Candidatos u opcion:
                </div>
                <div class="col s6 m3 l3">
                    {{($r->infor == true) ? "SI":"NO"}}<br>
                </div>
                <div class="col s6 m8 l8">
                    Género persona (Femenino - Masculino): 
                </div>
                <div class="col s6 m3 l3">
                    {{($r->gen == true) ? "SI":"NO"}}<br>
                </div>
                <div class="col s6 m8 l8">
                    Género de la Categoria:
                </div>
                <div class="col s6 m3 l3">
                    {{($r->generoart == true) ? "SI":"NO"}}<br>
                </div>
                <div class="col s6 m8 l8">
                    Imagen: 
                </div>
                <div class="col s6 m3 l3">
                    {{($r->img == true) ? "SI":"NO"}}<br>
                </div>
                <div class="col s6 m8 l8">
                    Audio:
                </div>
                <div class="col s6 m3 l3">
                    {{($r->audio == true) ? "SI":"NO"}}<br>
                </div>
                <div class="col s6 m8 l8">
                    Video: 
                </div>
                <div class="col s6 m3 l3">
                    {{($r->video == true) ? "SI":"NO"}}<br>
                </div>
                <div class="col s6 m8 l8">
                    Redes Sociales del Candidato: 
                </div>
                <div class="col s6 m3 l3">
                    {{($r->redes == true) ? "SI":"NO"}}<br>
                </div>
                <div class="col s6 m8 l8">
                    Página web del Candidato: 
                </div>
                <div class="col s6 m3 l3">
                    {{($r->pag == true) ? "SI":"NO"}}<br>
                </div>
                <div class="col s6 m8 l8">
                    Nro de Seguidores del Candidato: 
                </div>
                <div class="col s6 m3 l3">
                    {{($r->seg == true) ? "SI":"NO"}}<br>
                </div>
                <div class="col s6 m8 l8">
                    Compañia donde se desempeña el Candidato: 
                </div>
                <div class="col s6 m3 l3">
                    {{($r->cia == true) ? "SI":"NO"}}<br>
                </div>
                @endforeach
                <br>
                </p>
            </div>
            @if($params['data']['generos'] != false)
            <div id="generos" class="col s12" style="display: none;">
                <br> <br>
                <font style="font-weight: bold;">Géneros de la Categoria:</font>                    
                <p class="text-justify">
                    @foreach($params['data']['generos'] as $key =>$r)
                    {{$r->nomgenero}}<br>
                    @endforeach
                    <br>
                </p>
            </div>
            @endif
        </div>
    </form>  
</div>
@section('javascripts')
@parent
@endsection