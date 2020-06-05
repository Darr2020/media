<div id="Swipeable-tab" class="section">
    <h4 class="header">Consulta del Candidato: {{$params['data']['candidato'][0]->nombrecandidato}}</h4>
    <div class="row">
        <div class="col s12 m12 l12" style="padding: 0px;">
            <div id="d" class="col s12 m8 l8 waves-effect waves-light btn gradient-45deg-red-pink z-depth-4 mr-1 bordde">
                <a href="javascript:void(0);" onclick="dt()" style="color: #fff !important; font-size: 18px;">Datos Básicos</a>
            </div>
            @if($params['data']['generos'] != false)
            <div id="g" class="col s12 m1 l1 waves-effect waves-light btn gradient-45deg-light-blue-cyan z-depth-4 mr-1 bordde">
                <a href="javascript:void(0);" onclick="gen()" style="color: #fff !important; font-size: 18px;">Géneros del Candidato</a>
            </div>
            @endif
            @if($params['data']['redes'] != false || $params['data']['candidato'][0]->pag != null || $params['data']['candidato'][0]->seguidores != null)
            <div id="c" class="col s12 m1 l1 waves-effect waves-light btn gradient-45deg-amber-amber z-depth-4 mr-1 bordde">
                <a href="javascript:void(0);" onclick="op()" style="color: #fff !important; font-size: 18px;">Redes Sociales</a>
            </div>
            @endif
            @if($params['data']['multimedia'] != false)
            <div id="m" class="col s12 m1 l1 waves-effect waves-light btn gradient-45deg-green-teal z-depth-4 mr-1 bordde">
                <a href="javascript:void(0);" onclick="mul()" style="color: #fff !important; font-size: 18px;">Multimedia</a>
            </div>
            @endif
        </div>
        <br><br>
        <div class="divider"></div>
        <div id="datoscand" class="col s12">
            @if ($params['data']['candidato'][0]->detalle != '')
            <br> <br>
            <font style="font-weight: bold;">Información del Candidato:</font>
            <p class="text-justify">
                {{$params['data']['candidato'][0]->detalle}}
                <br> <br> 
            </p>
            @endif
            @if ($params['data']['candidato'][0]->sexo != 0)
            <font style="font-weight: bold;">Sexo del Candidato:</font>
            <p class="text-justify">
                @if ($params['data']['candidato'][0]->sexo == 1)
                Femenino
                @elseif ($params['data']['candidato'][0]->sexo == 2)
                Masculino
                @elseif ($params['data']['candidato'][0]->sexo == 3)
                Mixto
                @endif
                <br> <br> 
            </p>
            @endif
            <br> <br> <br> <br>   
        </div>
        <div id="generoscand" class="col s12" style="display: none;">
            @if($params['data']['generos'] != false)
            <font style="font-weight: bold;">Géneros del Candidato:</font>                    
            <p class="text-justify">
                @foreach($params['data']['generos'] as $key =>$r)
                {{$r->nombregenero}}<br>
                @endforeach
                <br>
            </p>
            @endif
            <br> <br> <br> <br>
        </div>
        <div id="redescand" class="col s12" style="display: none;">
            @if ($params['data']['candidato'][0]->pag != null)
            <font style="font-weight: bold;">Página Web del Candidato:</font>
            <p class="text-justify">
                {{$params['data']['candidato'][0]->pag}}
                <br> <br> 
            </p>
            @endif
            @if($params['data']['redes'] != false)
            <font style="font-weight: bold;">Redes Sociales del Candidato:</font>                    
            <p class="text-justify">
                @foreach($params['data']['redes'] as $key =>$r)
                {{$r->nombreredes}}<br>
                @endforeach
                <br>
            </p>
            @endif
            @if ($params['data']['candidato'][0]->seguidores != null)
            <font style="font-weight: bold;">Nro de seguidores del Candidato:</font>
            <p class="text-justify">
                {{$params['data']['candidato'][0]->seguidores}}
                <br> <br> 
            </p>
            @endif

            <br> <br> <br> <br>
        </div>
        <div id="multicand" class="col s12" style="display: none;">
            @if($params['data']['multimedia'] != false)
            @if ($params['data']['multimedia'][0]->empresa != null)
            <font style="font-weight: bold;">Empresa donde se desempaña el Candidato:</font>
            <p class="text-justify">
                {{$params['data']['multimedia'][0]->empresa}}
                <br> <br> 
            </p>
            @endif
            @if ($params['data']['multimedia'][0]->img != null)
            <font style="font-weight: bold;">Imágen actual del Candidato:</font>
            <p class="text-center">
                <img width="700" height="500" src="{{ asset("candidatos/images/".$params['data']['multimedia'][0]->img)}}">
                <br> <br> 
            </p>
            @endif
            @if ($params['data']['multimedia'][0]->audio != null)
            <font style="font-weight: bold;">Audio del Candidato:</font>
            <p class="text-justify">
        	<audio id="audioweb" src="{{ asset("candidatos/audio/".$params['data']['multimedia'][0]->audio)}}" controls loop></audio>
                <br> <br> 
            </p>
            @endif
            @if ($params['data']['multimedia'][0]->video != null)
            <font style="font-weight: bold;">Video del Candidato:</font>
            <p class="text-center">
                <iframe width="700" height="500" src="https://www.youtube.com/embed/{{$params['data']['multimedia'][0]->video}}" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
                <br> <br> 
            </p>
            @endif                 
            @endif
            <br> <br> <br> <br>
        </div>
    </div>
</div>
