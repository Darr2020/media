@extends("layout.base")
@section("title", "MediaMétrica | Detalle")
@section('stylesheets')
@parent
<link rel="stylesheet" href="{{ asset('css/style-feel.css') }}">
@endsection
@section("body")
@if($params['data']['categorias'] != false)
<div class="section">
    <div id="header">
        <table>
            <tr>
                <td>
                    <font style="color:#652D90; font-size:3.2vmin;"><b> Top Ranking: </b></font>
                    <?php $color = '#652D90'; ?>
                    @if($params['data']['menu'] != false)
                    @foreach($params['data']['menu'] as $cmenu)
                    @if($cmenu->id == $params['id'])
                    <font style="padding: 6px; color:{{$cmenu->color}}; font-size:5vmin;"><b> {{$cmenu->nombrecategoria}}</b></font> |
                    <?php $color = $cmenu->color; ?>
                    @else
                    <a href="javascript:void(0);" onclick="verpagina({{$cmenu->id}})">
                        <font style="color:{{$cmenu->color}};font-size:3.2vmin;">{{$cmenu->nombrecategoria}}</font></a> |
                    @endif
                    @endforeach
                    @else
                    <h4 style="text-align: center">No hay Categorias Activas, Contacte con el Administrador Web</h4>
                    @endif

                </td>
            </tr>
        </table>
    </div>
    @if ($params['rankweb'] > 1 || ($params['ranktefl'] > 1))
    @if ($params['rankweb'] > 1)
    <img class="materialboxed rankweb" width="100%" height="500px" src="{{ asset("candidatos/images/".$params['data']['rankingweb'][0]['img'])}}">
    @elseif ($params['ranktefl'] > 1)
    <img class="materialboxed ranktefl" width="100%" height="500px" src="{{ asset("candidatos/images/".$params['data']['rankingtelf'][0]['img'])}}">
    @endif
    @else
    <img class="materialboxed" width="100%" height="500px" src="{{ asset("images/media/Mcolor-01.png") }}">
    @endif
</div>
<div class="section">
    <div id="card-widgets" class="seaction">
        <div class="row">
            <div class="col s12 m12 l12">
                @if ($params['rankweb'] > 1 || ($params['ranktefl'] > 1))
                @foreach($params['data']['categorias'] as $categ)
                <div class="col s12 m6 l6 f-sessiones" style="padding-bottom: 25px;">
                    <div id="toprankingmedia" class="col s12">
                        <br>
                        @if ($params['rankweb'] > 1)
                        <a id="rma" href="javascript:void(0)"><img class="col s12 m6 l6" src="{{ asset("images/media/trm.png") }}"></a>
                        @endif
                        @if ($params['ranktefl'] > 1)
                        <a id="rci" href="javascript:void(0)"><img class="col s12 m6 l6" src="{{ asset("images/media/trti.png") }}"></a>
                        @endif
                        <br>
                    </div>
                    <div id="toprankingcall" class="col s12" style=" display: none;">
                        <br>
                        @if ($params['rankweb'] > 1)
                        <a id="rmi" href="javascript:void(0)"><img class="col s12 m6 l6" src="{{ asset("images/media/trmi.png") }}"></a>
                        @endif
                        @if ($params['ranktefl'] > 1)
                        <a id="rca" href="javascript:void(0)"><img class="col s12 m6 l6" src="{{ asset("images/media/trt.png") }}"></a>
                        @endif
                        <br>
                    </div>
                    <br><br><br><br>
                    @if ($params['rankweb'] > 1)
                    <div id="RankingM" class="card-content">
                        <div class="col s12 m12 l12">
                            <div class="col s2 m2 l2 gradient-gold">
                                1 
                            </div>
                            <div class="col s2 m2 l2">
                                <input type="hidden" id="video" value="{{$params['data']['categorias'][0]->video}}">
                                @if($params['data']['categorias'][0]->video == 1)
                                <figure>
                                    <a onclick="videos({{$params['data']['rankingweb'][0]['id']}},{{1}},{{$params['data']['rankingweb'][0]['encuesta_id']}} )" href="javascript:void(0);"> 
                                        <img class="i-sessiones" src="{{ asset("candidatos/images/".$params['data']['rankingweb'][0]['img'])}}">
                                        <figcaption>
                                            <img class="imgvideo video" width="60" height="60" src="{{ asset("images/media/videover.png")}}">
                                        </figcaption>
                                    </a>
                                </figure>
                                @elseif($params['data']['categorias'][0]->img == 1)
                                <a onclick="videos({{$params['data']['rankingweb'][0]['id']}},{{3}},{{$params['data']['rankingweb'][0]['encuesta_id']}})" href="javascript:void(0);"> 
                                    <img class="i-sessiones" src="{{ asset("candidatos/images/".$params['data']['rankingweb'][0]['img'])}}">
                                </a>
                                @else
                                <img class="i-sessiones" src="{{ asset("images/media/Mcolor-01.png") }}">
                                @endif
                            </div>
                            <div class="col s4 m4 l4">
                                <font class="titulotop">{{$params['data']['rankingweb'][0]['nombrecandidato']}}</font>
                                <br>
                                @if($params['data']['categorias'][0]->generoart == 1)
                                <font class="generotop">Género: 
                                @foreach($params['data']['rankingweb'][0]['generos'] as $generos)
                                {{$generos}} / 
                                @endforeach
                                </font><br>
                                @endif
                                <font class="vistastop">0 vistas</font><br>
                            </div>
                            <div class="col s4 m4 l4" >
                                @if($params['data']['categorias'][0]->audio == 1)
                                <a  onclick="audios({{$params['data']['rankingweb'][0]['id']}},{{2}})" href="javascript:void(0);"> 
                                    <img width="30px" height="30px" src="{{ asset("images/media/audifonomorado.png") }}">
                                </a>
                                @else
                                <img width="30px" height="30px" src="{{ asset("images/media/audifonodisable.png") }}" disabled>
                                @endif
                                @if(Session::has('usuario'))
                                @if($params['voto'] == 0)
                                <a onclick="voto({{$params['data']['rankingweb'][0]['id']}},{{$params['data']['categorias'][0]->id}},{{$params['data']['rankingweb'][0]['encuesta_id']}})" class="waves-effect waves-cyan">
                                    <font class="votar"> VOTAR </font>
                                </a>
                                @else
                                <a class="waves-effect waves-cyan ">
                                    <font class="votardis"> VOTAR </font>
                                </a> 
                                @endif 
                                @else
                                <a onclick="ingresarfm()" class="waves-effect waves-cyan">
                                    <font class="votar"> VOTAR </font>
                                </a> 
                                @endif                                
                                <font class="top-sessionesd {{$params['data']['rankingweb'][0]['movimiento']}}d">{{$params['data']['rankingweb'][0]['puntaje']}}</font>
                            </div>
                        </div>
                        <div class="col s12 m12 l12">
                            <div class="col s2 m2 l2 gradient-silver">
                                2 
                            </div>
                            <div class="col s2 m2 l2">
                                @if($params['data']['categorias'][0]->video == 1)
                                <figure>
                                    <a onclick="videos({{$params['data']['rankingweb'][1]['id']}},{{1}} ,{{$params['data']['rankingweb'][0]['encuesta_id']}})" href="javascript:void(0);"> 
                                        <img class="i-sessiones" src="{{ asset("candidatos/images/".$params['data']['rankingweb'][1]['img'])}}">
                                        <figcaption>
                                            <img class="imgvideo video" width="60" height="60" src="{{ asset("images/media/videover.png")}}">
                                        </figcaption>
                                    </a>
                                </figure>
                                @elseif($params['data']['categorias'][0]->img == 1)
                                <a onclick="videos({{$params['data']['rankingweb'][1]['id']}},{{3}} ,{{$params['data']['rankingweb'][0]['encuesta_id']}})" href="javascript:void(0);"> 
                                    <img class="i-sessiones" src="{{ asset("candidatos/images/".$params['data']['rankingweb'][1]['img'])}}">
                                </a>
                                @else
                                <img class="i-sessiones" src="{{ asset("images/media/Mcolor-01.png") }}">
                                @endif
                            </div>
                            <div class="col s4 m4 l4">
                                <font class="titulotop">{{$params['data']['rankingweb'][1]['nombrecandidato']}}</font>
                                <br>
                                @if($params['data']['categorias'][0]->generoart == 1)
                                <font class="generotop">Género: 
                                @foreach($params['data']['rankingweb'][1]['generos'] as $generos)
                                {{$generos}} / 
                                @endforeach
                                </font><br>
                                @endif
                                <font class="vistastop">0 vistas</font><br>
                            </div>
                            <div class="col s4 m4 l4" >
                                @if($params['data']['categorias'][0]->audio == 1)
                                <a  onclick="audios({{$params['data']['rankingweb'][1]['id']}},{{2}})" href="javascript:void(0);"> 
                                    <img width="30px" height="30px" src="{{ asset("images/media/audifonomorado.png") }}">
                                </a>                                
                                @else
                                <img width="30px" height="30px" src="{{ asset("images/media/audifonodisable.png") }}" disabled>
                                @endif
                                @if(Session::has('usuario'))
                                @if($params['voto'] == 0)
                                <a onclick="voto({{$params['data']['rankingweb'][1]['id']}},{{$params['data']['categorias'][0]->id}},{{$params['data']['rankingweb'][1]['encuesta_id']}})" class="waves-effect waves-cyan">
                                    <font class="votar"> VOTAR </font>
                                </a>
                                @else
                                <a class="waves-effect waves-cyan ">
                                    <font class="votardis"> VOTAR </font>
                                </a> 
                                @endif 
                                @else
                                <a onclick="ingresarfm()" class="waves-effect waves-cyan">
                                    <font class="votar"> VOTAR </font>
                                </a> 
                                @endif                              
                                <font class="top-sessionesd {{$params['data']['rankingweb'][1]['movimiento']}}d">{{$params['data']['rankingweb'][1]['puntaje']}}</font>
                            </div>
                        </div>
                        <div class="col s12 m12 l12">
                            <div class="col s2 m2 l2 gradient-bronze">
                                3
                            </div>
                            <div class="col s2 m2 l2">
                                @if($params['data']['categorias'][0]->video == 1)
                                <figure>
                                    <a onclick="videos({{$params['data']['rankingweb'][2]['id']}},{{1}},{{$params['data']['rankingweb'][0]['encuesta_id']}})" href="javascript:void(0);"> 
                                        <img class="i-sessiones" src="{{ asset("candidatos/images/".$params['data']['rankingweb'][2]['img'])}}">
                                        <figcaption>
                                            <img class="imgvideo video" width="60" height="60" src="{{ asset("images/media/videover.png")}}">
                                        </figcaption>
                                    </a>
                                </figure>
                                @elseif($params['data']['categorias'][0]->img == 1)
                                <a onclick="videos({{$params['data']['rankingweb'][2]['id']}},{{3}},{{$params['data']['rankingweb'][0]['encuesta_id']}})" href="javascript:void(0);"> 
                                    <img class="i-sessiones" src="{{ asset("candidatos/images/".$params['data']['rankingweb'][2]['img'])}}">
                                </a>
                                @else
                                <img class="i-sessiones" src="{{ asset("images/media/Mcolor-01.png") }}">
                                @endif
                            </div>
                            <div class="col s4 m4 l4">
                                <font class="titulotop">{{$params['data']['rankingweb'][2]['nombrecandidato']}}</font>
                                <br>
                                @if($params['data']['categorias'][0]->generoart == 1)
                                <font class="generotop">Género: 
                                @foreach($params['data']['rankingweb'][2]['generos'] as $generos)
                                {{$generos}} /  
                                @endforeach
                                </font><br>
                                @endif
                                <font class="vistastop">0 vistas</font><br>
                            </div>
                            <div class="col s4 m4 l4" >
                                @if($params['data']['categorias'][0]->audio == 1)
                                <a  onclick="audios({{$params['data']['rankingweb'][2]['id']}},{{2}})" href="javascript:void(0);"> 
                                    <img width="30px" height="30px" src="{{ asset("images/media/audifonomorado.png") }}">
                                </a>                                
                                @else
                                <img width="30px" height="30px" src="{{ asset("images/media/audifonodisable.png") }}" disabled>
                                @endif
                                @if(Session::has('usuario'))
                                @if($params['voto'] == 0)
                                <a onclick="voto({{$params['data']['rankingweb'][2]['id']}},{{$params['data']['categorias'][0]->id}},{{$params['data']['rankingweb'][2]['encuesta_id']}})" class="waves-effect waves-cyan">
                                    <font class="votar"> VOTAR </font>
                                </a>
                                @else
                                <a class="waves-effect waves-cyan ">
                                    <font class="votardis"> VOTAR </font>
                                </a> 
                                @endif 
                                @else
                                <a onclick="ingresarfm()" class="waves-effect waves-cyan">
                                    <font class="votar"> VOTAR </font>
                                </a> 
                                @endif                               
                                <font class="top-sessionesd {{$params['data']['rankingweb'][2]['movimiento']}}d">{{$params['data']['rankingweb'][2]['puntaje']}}</font>
                            </div>
                        </div>
                        <?php $numweb = 4; ?>
                        @for ($cont = 3; $cont < $params['rankweb']; $cont++)
                        <div class="col s12 m12 l12">
                            <div class="cirulo col s2 m2 l2" >
                                {{$numweb}}
                            </div>
                            <div class="col s2 m2 l2">
                                @if($params['data']['categorias'][0]->video == 1)
                                <figure>
                                    <a onclick="videos({{$params['data']['rankingweb'][$cont]['id']}},{{1}},{{$params['data']['rankingweb'][0]['encuesta_id']}})" href="javascript:void(0);"> 
                                        <img class="i-sessiones" src="{{ asset("candidatos/images/".$params['data']['rankingweb'][$cont]['img'])}}">
                                        <figcaption>
                                            <img class="imgvideo video" width="60" height="60" src="{{ asset("images/media/videover.png")}}">
                                        </figcaption>
                                    </a>
                                </figure>
                                @elseif($params['data']['categorias'][0]->img == 1)
                                <a onclick="videos({{$params['data']['rankingweb'][$cont]['id']}},{{3}},{{$params['data']['rankingweb'][0]['encuesta_id']}})" href="javascript:void(0);"> 
                                    <img class="i-sessiones" src="{{ asset("candidatos/images/".$params['data']['rankingweb'][$cont]['img'])}}">
                                </a>
                                @else
                                <img class="i-sessiones" src="{{ asset("images/media/Mcolor-01.png") }}">
                                @endif
                            </div>
                            <div class="col s4 m4 l4">
                                <font class="titulotop">{{$params['data']['rankingweb'][$cont]['nombrecandidato']}}</font>
                                <br>
                                @if($params['data']['categorias'][0]->generoart == 1)
                                <font class="generotop">Género: 
                                @foreach($params['data']['rankingweb'][$cont]['generos'] as $generos)
                                {{$generos}} /  
                                @endforeach
                                </font><br>
                                @endif
                                <font class="vistastop">0 vistas</font><br>
                            </div>
                            <div class="col s4 m4 l4" >
                                @if($params['data']['categorias'][0]->audio == 1)
                                <a  onclick="audios({{$params['data']['rankingweb'][$cont]['id']}},{{2}})" href="javascript:void(0);"> 
                                    <img width="30px" height="30px" src="{{ asset("images/media/audifonomorado.png") }}">
                                </a>                               
                                @else
                                <img width="30px" height="30px" src="{{ asset("images/media/audifonodisable.png") }}" disabled>
                                @endif
                                @if(Session::has('usuario'))
                                @if($params['voto'] == 0)
                                <a onclick="voto({{$params['data']['rankingweb'][$cont]['id']}},{{$params['data']['categorias'][0]->id}},{{$params['data']['rankingweb'][$cont]['encuesta_id']}})" class="waves-effect waves-cyan">
                                    <font class="votar"> VOTAR </font>
                                </a>
                                @else
                                <a class="waves-effect waves-cyan ">
                                    <font class="votardis"> VOTAR </font>
                                </a> 
                                @endif 
                                @else
                                <a onclick="ingresarfm()" class="waves-effect waves-cyan">
                                    <font class="votar"> VOTAR </font>
                                </a> 
                                @endif                             
                                <font class="top-sessionesd {{$params['data']['rankingweb'][$cont]['movimiento']}}d">{{$params['data']['rankingweb'][$cont]['puntaje']}}</font>
                            </div>
                        </div>
                        <?php $numweb++; ?>
                        @endfor
                    </div>
                    @endif
                    @if ($params['ranktefl'] > 1)
                    <div id="RankingC" class="card-content" style=" display: none;">
                        <div class="col s12 m12 l12">
                            <div class="col s2 m2 l2 gradient-gold" >
                                1 
                            </div>
                            <div class="col s2 m2 l2">
                                @if($params['data']['categorias'][0]->video == 1)
                                <figure>
                                    <a onclick="videos({{$params['data']['rankingtelf'][0]['id']}},{{2}},{{$params['data']['rankingtelf'][0]['encuesta_id']}})" href="javascript:void(0);"> 
                                        <img class="i-sessiones" src="{{ asset("candidatos/images/".$params['data']['rankingtelf'][0]['img'])}}">
                                        <figcaption>
                                            <img class="imgvideo video" width="60" height="60" src="{{ asset("images/media/videover.png")}}">
                                        </figcaption>
                                    </a>
                                </figure>
                                @elseif($params['data']['categorias'][0]->img == 1)
                                <a onclick="videos({{$params['data']['rankingtelf'][0]['id']}},{{4}},{{$params['data']['rankingtelf'][0]['encuesta_id']}})" href="javascript:void(0);"> 
                                    <img class="i-sessiones" src="{{ asset("candidatos/images/".$params['data']['rankingtelf'][0]['img'])}}">
                                </a>
                                @else
                                <img class="i-sessiones" src="{{ asset("images/media/Mcolor-01.png") }}">
                                @endif
                            </div>
                            <div class="col s4 m4 l4">
                                <font class="titulotop">{{$params['data']['rankingtelf'][0]['nombrecandidato']}}</font>
                                <br>
                                @if($params['data']['categorias'][0]->generoart == 1)
                                <font class="generotop">Género: 
                                @foreach($params['data']['rankingtelf'][0]['generos'] as $generos)
                                {{$generos}} /  
                                @endforeach
                                </font><br>
                                @endif
                                <font class="vistastop">0 vistas</font><br>
                            </div>
                            <div class="col s4 m4 l4" >
                                @if($params['data']['categorias'][0]->audio == 1)
                                <a  onclick="audios({{$params['data']['rankingtelf'][0]['id']}},{{2}})" href="javascript:void(0);"> 
                                    <img width="30px" height="30px" src="{{ asset("images/media/audifonomorado.png") }}">
                                </a>                                
                                @else
                                <img width="30px" height="30px" src="{{ asset("images/media/audifonodisable.png") }}" disabled>
                                @endif                               
                                <font class="top-sessionesd nuevod">{{$params['data']['rankingtelf'][0]['puntaje']}}</font>
                            </div>
                        </div>
                        <div class="col s12 m12 l12">
                            <div class="col s2 m2 l2 gradient-silver" >
                                2 
                            </div>
                            <div class="col s2 m2 l2">
                                @if($params['data']['categorias'][0]->video == 1)
                                <figure>
                                    <a onclick="videos({{$params['data']['rankingtelf'][1]['id']}},{{2}},{{$params['data']['rankingtelf'][0]['encuesta_id']}})" href="javascript:void(0);"> 
                                        <img class="i-sessiones" src="{{ asset("candidatos/images/".$params['data']['rankingtelf'][1]['img'])}}">
                                        <figcaption>
                                            <img class="imgvideo video" width="60" height="60" src="{{ asset("images/media/videover.png")}}">
                                        </figcaption>
                                    </a>
                                </figure>
                                @elseif($params['data']['categorias'][0]->img == 1)
                                <a onclick="videos({{$params['data']['rankingtelf'][1]['id']}},{{4}},{{$params['data']['rankingtelf'][0]['encuesta_id']}})" href="javascript:void(0);"> 
                                    <img class="i-sessiones" src="{{ asset("candidatos/images/".$params['data']['rankingtelf'][1]['img'])}}">
                                </a>
                                @else
                                <img class="i-sessiones" src="{{ asset("images/media/Mcolor-01.png") }}">
                                @endif
                            </div>
                            <div class="col s4 m4 l4">
                                <font class="titulotop">{{$params['data']['rankingtelf'][1]['nombrecandidato']}}</font>
                                <br>
                                @if($params['data']['categorias'][0]->generoart == 1)
                                <font class="generotop">Género: 
                                @foreach($params['data']['rankingtelf'][1]['generos'] as $generos)
                                {{$generos}} /  
                                @endforeach
                                </font><br>
                                @endif
                                <font class="vistastop">0 vistas</font><br>
                            </div>
                            <div class="col s4 m4 l4" >
                                @if($params['data']['categorias'][0]->audio == 1)
                                <a  onclick="audios({{$params['data']['rankingtelf'][1]['id']}},{{2}})" href="javascript:void(0);"> 
                                    <img width="30px" height="30px" src="{{ asset("images/media/audifonomorado.png") }}">
                                </a>
                                @else
                                <img width="30px" height="30px" src="{{ asset("images/media/audifonodisable.png") }}" disabled>
                                @endif                                
                                <font class="top-sessionesd nuevod">{{$params['data']['rankingtelf'][1]['puntaje']}}</font>
                            </div>
                        </div>
                        <div class="col s12 m12 l12">
                            <div class="col s2 m2 l2 gradient-bronze" >
                                3
                            </div>
                            <div class="col s2 m2 l2">
                                @if($params['data']['categorias'][0]->video == 1)
                                <figure>
                                    <a onclick="videos({{$params['data']['rankingtelf'][2]['id']}},{{2}},{{$params['data']['rankingtelf'][0]['encuesta_id']}})" href="javascript:void(0);"> 
                                        <img class="i-sessiones" src="{{ asset("candidatos/images/".$params['data']['rankingtelf'][2]['img'])}}">
                                        <figcaption>
                                            <img class="imgvideo video" width="60" height="60" src="{{ asset("images/media/videover.png")}}">
                                        </figcaption>
                                    </a>
                                </figure>
                                @elseif($params['data']['categorias'][0]->img == 1)
                                <a onclick="videos({{$params['data']['rankingtelf'][2]['id']}},{{4}},{{$params['data']['rankingtelf'][0]['encuesta_id']}})" href="javascript:void(0);"> 
                                    <img class="i-sessiones" src="{{ asset("candidatos/images/".$params['data']['rankingtelf'][2]['img'])}}">
                                </a>
                                @else
                                <img class="i-sessiones" src="{{ asset("images/media/Mcolor-01.png") }}">
                                @endif
                            </div>
                            <div class="col s4 m4 l4">
                                <font class="titulotop">{{$params['data']['rankingtelf'][2]['nombrecandidato']}}</font>
                                <br>
                                @if($params['data']['categorias'][0]->generoart == 1)
                                <font class="generotop">Género: 
                                @foreach($params['data']['rankingtelf'][2]['generos'] as $generos)
                                {{$generos}} /  
                                @endforeach
                                </font><br>
                                @endif
                                <font class="vistastop">0 vistas</font><br>
                            </div>
                            <div class="col s4 m4 l4" >
                                @if($params['data']['categorias'][0]->audio == 1)
                                <a  onclick="audios({{$params['data']['rankingtelf'][2]['id']}},{{2}})" href="javascript:void(0);"> 
                                    <img width="30px" height="30px" src="{{ asset("images/media/audifonomorado.png") }}">
                                </a>
                                @else
                                <img width="30px" height="30px" src="{{ asset("images/media/audifonodisable.png") }}" disabled>
                                @endif                              
                                <font class="top-sessionesd nuevod">{{$params['data']['rankingtelf'][2]['puntaje']}}</font>
                            </div>
                        </div>
                        <?php $numtefl = 4; ?>
                        @for ($contt = 3; $contt < $params['ranktefl']; $contt++)
                        <div class="col s12 m12 l12">
                            <div class="cirulo col s2 m2 l2" >
                                {{$numtefl}}
                            </div>
                            <div class="col s2 m2 l2">
                                @if($params['data']['categorias'][0]->video == 1)
                                <figure>
                                    <a onclick="videos({{$params['data']['rankingtelf'][$contt]['id']}},{{2}},{{$params['data']['rankingtelf'][0]['encuesta_id']}})" href="javascript:void(0);"> 
                                        <img class="i-sessiones" src="{{ asset("candidatos/images/".$params['data']['rankingtelf'][$contt]['img'])}}">
                                        <figcaption>
                                            <img class="imgvideo video" width="60" height="60" src="{{ asset("images/media/videover.png")}}">
                                        </figcaption>
                                    </a>
                                </figure>
                                @elseif($params['data']['categorias'][0]->img == 1)
                                <a onclick="videos({{$params['data']['rankingtelf'][$contt]['id']}},{{4}},{{$params['data']['rankingtelf'][0]['encuesta_id']}})" href="javascript:void(0);"> 
                                    <img class="i-sessiones" src="{{ asset("candidatos/images/".$params['data']['rankingtelf'][$contt]['img'])}}">
                                </a>
                                @else
                                <img class="i-sessiones" src="{{ asset("images/media/Mcolor-01.png") }}">
                                @endif
                            </div>
                            <div class="col s4 m4 l4">
                                <font class="titulotop">{{$params['data']['rankingtelf'][$contt]['nombrecandidato']}}</font>
                                <br>
                                @if($params['data']['categorias'][0]->generoart == 1)
                                <font class="generotop">Género: 
                                @foreach($params['data']['rankingtelf'][$contt]['generos'] as $generos)
                                {{$generos}} /  
                                @endforeach
                                </font><br>
                                @endif
                                <font class="vistastop">0 vistas</font><br>
                            </div>
                            <div class="col s4 m4 l4" >
                                @if($params['data']['categorias'][0]->audio == 1)
                                <a  onclick="audios({{$params['data']['rankingtelf'][$contt]['id']}},{{2}})" href="javascript:void(0);"> 
                                    <img width="30px" height="30px" src="{{ asset("images/media/audifonomorado.png") }}">
                                </a>
                                @else
                                <img width="30px" height="30px" src="{{ asset("images/media/audifonodisable.png") }}" disabled>
                                @endif                               
                                <font class="top-sessionesd nuevod">{{$params['data']['rankingtelf'][$contt]['puntaje']}}</font>
                            </div>
                        </div>
                        <?php $numtefl++; ?>
                        @endfor
                    </div>
                    @endif
                </div>
                @endforeach
                @else
                <div class="col s12 m6 l6 f-sessiones">
                    <h4 style="text-align: center">No hay Candidatos para esta Categoria.</h4>
                    <br><br>
                </div>
                @endif
                <div class="col s12 m6 l6">
                    <div class="col s12 m12 l12"> {{--'Div 12 global 1'--}}
                        <!-- video post -->
                        @if ($params['rankweb'] > 1 || ($params['ranktefl'] > 1))
                        <div class="card"> {{--'Div Card'--}}
                            <div class="card-image">
                                <div class="video-container no-controls">
                                    @if($params['data']['categorias'][0]->video == 1)
                                    @if ($params['rankweb'] > 1)
                                    @if (isset($params['data']['rankingweb'][0]['video']))  

                                    <iframe class="vidweb" width="640" height="260" id="videoweb" src="https://www.youtube.com/embed/{{ ($params['data']['rankingweb'][0]['video']) }}?rel=0&enablejsapi=1&version=3&autoplay=1&playerapiid=ytplayer" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>

                                    <iframe class="vidtel" width="640" height="260" id="videotel" src="https://www.youtube.com/embed/{{ ($params['data']['rankingtelf'][0]['video']) }}?rel=0&enablejsapi=1&version=3&playerapiid=ytplayer" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen style="display: none;"></iframe>
                                    @endif
                                    @endif
                                    @elseif($params['data']['categorias'][0]->img == 1)
                                    @if ($params['rankweb'] > 1)
                                    @if ($params['data']['rankingweb'][0]['img'])
                                    <img  class="materialboxed" width="640" height="360" id="imgweb" src="{{ asset("candidatos/images/".$params['data']['rankingweb'][0]['img'])}}">
                                    <img  class="materialboxed" width="640" height="360" id="imgtelf" src="{{ asset("candidatos/images/".$params['data']['rankingtelf'][0]['img'])}}" style="display: none;">
                                    @endif
                                    @endif
                                    @else
                                    <img class="materialboxed" width="640" height="360" src="{{ asset("images/media/Mcolor-01.png") }}">
                                    @endif
                                </div>
                            </div>

                            <div class="col s12 m12 l12"> {{--' Div 12 global 2A'--}}
                                <div id="InfomacioWeb" style="padding: 8px 8px 8px 8px;">
                                    <b>Nombre:</b>
                                    <font id="nombre">
                                    {{ucwords(strtolower($params['data']['rankingweb'][0]['nombrecandidato']))}}
                                    </font>
                                    <br>
                                    @if($params['data']['rankingweb'][0]['detalle']!=null)
                                    <b>Detalle:</b>
                                    <font id="detalle" style="text-align: justify;"> 
                                    {{ucfirst(strtolower($params['data']['rankingweb'][0]['detalle']))}}
                                    </font>
                                    <br> 
                                    @endif
                                    @if($params['data']['categorias'][0]->generoart == 1)
                                    <b>Género:</b> 
                                    <font id="generos">
                                    @foreach($params['data']['rankingweb'][0]['generos'] as $generos)
                                    {{ucfirst(strtolower($generos))}} /  
                                    @endforeach
                                    </font>
                                    <br>
                                    @endif
                                    @if($params['data']['rankingweb'][0]['sexo'] != 0)
                                    <b>Sexo:</b>
                                    <font id="sexo">
                                    @if($params['data']['rankingweb'][0]['sexo'] == 1)
                                    Femenino
                                    @elseif($params['data']['rankingweb'][0]['sexo'] == 2)
                                    Masculino
                                    @elseif($params['data']['rankingweb'][0]['sexo'] == 3)
                                    Mixto
                                    @endif
                                    </font>
                                    <br>
                                    @endif
                                    @if($params['data']['rankingweb'][0]['pag']!=null)
                                    <b>Página WEB:</b>
                                    <font id="pag">
                                    {{strtolower($params['data']['rankingweb'][0]['pag'])}}
                                    </font>
                                    <br>
                                    @endif
                                    @if($params['data']['rankingweb'][0]['seguidores']!=null)
                                    <b>Nº de Seguidores:</b>
                                    <font id="seguidores">
                                    {{$params['data']['rankingweb'][0]['seguidores']}}
                                    </font>
                                    <br>
                                    @endif
                                    @if(count($params['data']['rankingweb'][0]['redes']) > 1)
                                    <b>Redes:</b> 
                                    <font id="redes">
                                    @foreach($params['data']['rankingweb'][0]['redes'] as $redes)
                                    {{strtolower($redes)}} /  
                                    @endforeach
                                    </font>
                                    <br>
                                    @endif
                                </div>
                                @if ($params['ranktefl'] > 1)
                                <div id="InfomacioTelf" style="display:none; padding: 8px 8px 8px 8px;">

                                    <b>Nombre:</b>
                                    <font id="nombret">
                                    {{ucwords(strtolower($params['data']['rankingtelf'][0]['nombrecandidato']))}}
                                    </font>
                                    <br>
                                    @if($params['data']['rankingtelf'][0]['detalle']!=null)
                                    <b>Detalle:</b>
                                    <font id="detallet" style="text-align: justify;"> 
                                    {{ucfirst(strtolower($params['data']['rankingtelf'][0]['detalle']))}}
                                    </font> 
                                    <br>
                                    @endif
                                    @if($params['data']['categorias'][0]->generoart == 1)
                                    <b>Género:</b> 
                                    <font id="generost">
                                    @foreach($params['data']['rankingtelf'][0]['generos'] as $generos)
                                    {{ucfirst(strtolower($generos))}} /  
                                    @endforeach
                                    </font>
                                    <br>
                                    @endif
                                    @if($params['data']['rankingtelf'][0]['sexo'] != 0)
                                    <b>Sexo:</b>
                                    <font id="sexot">
                                    @if($params['data']['rankingtelf'][0]['sexo'] == 1)
                                    Femenino
                                    @elseif($params['data']['rankingtelf'][0]['sexo'] == 2)
                                    Masculino
                                    @elseif($params['data']['rankingtelf'][0]['sexo'] == 3)
                                    Mixto
                                    @endif
                                    </font>
                                    <br>
                                    @endif
                                    @if($params['data']['rankingtelf'][0]['pag']!=null)
                                    <b>Página WEB:</b>
                                    <font id="pagt">
                                    {{strtolower($params['data']['rankingtelf'][0]['pag'])}}
                                    </font>
                                    <br>
                                    @endif
                                    @if($params['data']['rankingtelf'][0]['seguidores']!=null)
                                    <b>Nº de Seguidores:</b>
                                    <font id="seguidorest">
                                    {{$params['data']['rankingtelf'][0]['seguidores']}}
                                    </font>
                                    <br>
                                    @endif
                                    @if(count($params['data']['rankingtelf'][0]['redes']) > 1)
                                    <b>Redes:</b> 
                                    <font id="redest">
                                    @foreach($params['data']['rankingtelf'][0]['redes'] as $redes)
                                    {{strtolower($redes)}} /  
                                    @endforeach
                                    </font>
                                    <br>
                                    @endif
                                </div>
                                @endif                            
                            </div>{{--' END Div 12 global 2A'--}}

                            <div class="col s12 m12 l12"> {{--' Div 12 global 2B'--}}
                                <div class="col s7 m7 l7" style="padding: 0;margin-top: 0;">
                                    {{-- SECCIÓN EMOCION Y COMPARTIR --}}
                                    <div class="page-data" style="padding: 30px 0px 40px;margin-top: 0px;">
                                        <div class="page-social" style=" padding: 0px;">
                                            @if(Session::has('usuario'))

                                            {{--/////////////////////////////////////////////////////////////////////--}}
                                            <div id="rweb_zone">                                        
                                                @php
                                                $encuesta_id = $params['data']['rankingweb'][0]['encuesta_id'];
                                                $categoria_id = $params['id'];
                                                $candidato_multimedia_id = $params['data']['rankingweb'][0]['candidato_multimedia_id'];
                                                $candidato_id = $params['data']['rankingweb'][0]['id'];
                                                $cua=0;
                                                @endphp
                                                <input type="hidden" id="cua" value="{{$cua}}">
                                                <div id="first_load_RW">
                                                    @if($params['data']['categorias'][0]->video == 1)
                                                    @php
                                                    $tipo_multimedia = 2;
                                                    $opt = 1; //videoRW
                                                    //obtener likes del multimedia del candidato X
                                                    $get_like_generic = \App\Models\CmGustos::get_like_generic_cand($encuesta_id,$categoria_id,$candidato_multimedia_id,$candidato_id,$tipo_multimedia);

                                                    //obtener dislikes del multimedia del candidato 
                                                    $get_dislike_generic = \App\Models\CmGustos::get_dislike_generic_cand($encuesta_id,$categoria_id,$candidato_multimedia_id,$candidato_id,$tipo_multimedia);

                                                    //obtener el gusto emitido por el usuario
                                                    $getFeelBdUser = \App\Models\CmGustos::get_feeling_byUser($encuesta_id,$categoria_id,$candidato_multimedia_id,$candidato_id,$tipo_multimedia,Session::get("usuario")->id);
                                                    @endphp

                                                    @if($getFeelBdUser!=null) 
                                                    @if($getFeelBdUser->gusto == 1)
                                                    <div id="meGustaU">
                                                        <div class="emotion_list" id="like_likep">
                                                            <span class="cant like" id="lvmore_selectedp">{{$get_like_generic }}</span>
                                                            <a id="likebu" onclick="feel({{$encuesta_id}},{{$categoria_id}},{{$candidato_multimedia_id}},{{$candidato_id}},{{$tipo_multimedia}},{{1}},{{$opt}})">
                                                                <img id="like"  class="emotion img_selected" src="{{ asset('images/noticias/like.png') }}" alt="Me Gusta"/>
                                                            </a>
                                                        </div>
                                                        <div class="emotion_list" id="like_dislikep">
                                                            <span class="cant dislike" id="dvmorep">{{ $get_dislike_generic }}</span>
                                                            <a id="dislbu" onclick="feel({{$encuesta_id}},{{$categoria_id}},{{$candidato_multimedia_id}},{{$candidato_id}},{{$tipo_multimedia}},{{2}},{{$opt}})">
                                                                <img id="dislike" class="emotion" src="{{ asset('images/noticias/dislike.png') }}" alt="No me Gusta"/>
                                                            </a>
                                                        </div>
                                                    </div>
                                                    @elseif($getFeelBdUser->gusto == 2)
                                                    <div id="noMeGustaU">
                                                        <div class="emotion_list" id="dislike_likep">
                                                            <span class="cant like" id="lvmorep">{{$get_like_generic }}</span>
                                                            <a id="likecu" onclick="feel({{$encuesta_id}},{{$categoria_id}},{{$candidato_multimedia_id}},{{$candidato_id}},{{$tipo_multimedia}},{{1}},{{$opt}})">

                                                                <img id="like" class="emotion" src="{{ asset('images/noticias/like.png') }}" alt="Me Gusta"/>
                                                            </a>
                                                        </div>
                                                        <div class="emotion_list" id="dislike_dislikep">
                                                            <span class="cant dislike" id="dvmorep_selected">{{ $get_dislike_generic }}</span>
                                                            <a id="dislcu" onclick="feel({{$encuesta_id}},{{$categoria_id}},{{$candidato_multimedia_id}},{{$candidato_id}},{{$tipo_multimedia}},{{2}},{{$opt}})">
                                                                <img id="dislike" class="emotion img_selected" src="{{ asset('images/noticias/dislike.png') }}" alt="No me Gusta"/>
                                                            </a>
                                                        </div>              
                                                    </div> 
                                                    @else
                                                    <div id="generico">
                                                        <div class="emotion_list">
                                                            <span class="cant like" id="likega">{{$get_like_generic}}</span>
                                                            <a id="likeau" onclick="feel({{$encuesta_id}},{{$categoria_id}},{{$candidato_multimedia_id}},{{$candidato_id}},{{$tipo_multimedia}},{{1}},{{$opt}})">
                                                                <img id="like" src="{{ asset('images/noticias/like.png') }}" alt="Me Gusta"/>
                                                            </a>
                                                        </div>
                                                        <div class="emotion_list">
                                                            <span class="cant dislike" id="dislikega">{{ $get_dislike_generic }}</span>
                                                            <a id="dislau" onclick="feel({{$encuesta_id}},{{$categoria_id}},{{$candidato_multimedia_id}},{{$candidato_id}},{{$tipo_multimedia}},{{2}},{{$opt}})">
                                                                <img id="dislike" src="{{ asset('images/noticias/dislike.png') }}" alt="No me Gusta"/>
                                                            </a>
                                                        </div> 
                                                    </div>
                                                    @endif
                                                    @elseif($getFeelBdUser==null) {{--'NO HA EMITIDO GUSTO '--}} 
                                                    <div id="genericoB">
                                                        <div class="emotion_list">
                                                            <span class="cant like" id="likegb">{{$get_like_generic}}</span>
                                                            <a id="likeab" onclick="feel({{$encuesta_id}},{{$categoria_id}},{{$candidato_multimedia_id}},{{$candidato_id}},{{$tipo_multimedia}},{{1}},{{$opt}})">
                                                                <img id="like" src="{{ asset('images/noticias/like.png') }}" alt="Me Gusta"/>
                                                            </a>
                                                        </div>
                                                        <div class="emotion_list">
                                                            <span class="cant dislike" id="dislikegb">{{ $get_dislike_generic }}</span>
                                                            <a id="dislab" onclick="feel({{$encuesta_id}},{{$categoria_id}},{{$candidato_multimedia_id}},{{$candidato_id}},{{$tipo_multimedia}},{{2}},{{$opt}})">
                                                                <img id="dislike" src="{{ asset('images/noticias/dislike.png') }}" alt="No me Gusta"/>
                                                            </a>
                                                        </div> 
                                                    </div>
                                                    @endif     

                                                    {{--'\\\\\\\\\\\\\\\\\ IMAGEN DEL RANKING WEB //////////////'--}}
                                                    @elseif($params['data']['categorias'][0]->img == 1)                
                                                    @php
                                                    $tipo_multimedia = 1;
                                                    $opt = 3; //imgRW
                                                    //obtener likes del multimedia del candidato X
                                                    $get_like_generic = \App\Models\CmGustos::get_like_generic_cand($encuesta_id,$categoria_id,$candidato_multimedia_id,$candidato_id,$tipo_multimedia);

                                                    //obtener dislikes del multimedia del candidato 
                                                    $get_dislike_generic = \App\Models\CmGustos::get_dislike_generic_cand($encuesta_id,$categoria_id,$candidato_multimedia_id,$candidato_id,$tipo_multimedia);

                                                    //obtener el gusto emitido por el usuario
                                                    $getFeelBdUser = \App\Models\CmGustos::get_feeling_byUser($encuesta_id,$categoria_id,$candidato_multimedia_id,$candidato_id,$tipo_multimedia,Session::get("usuario")->id);
                                                    @endphp

                                                    @if($getFeelBdUser!=null) 
                                                    @if($getFeelBdUser->gusto == 1)
                                                    <div id="meGustaImgF">
                                                        <div class="emotion_list" id="like_likeImgF">
                                                            <span class="cant like" id="limgmoref_selected">{{$get_like_generic }}</span>
                                                            <a id="likeimgAF" onclick="feel({{$encuesta_id}},{{$categoria_id}},{{$candidato_multimedia_id}},{{$candidato_id}},{{$tipo_multimedia}},{{1}},{{$opt}})">
                                                                <img id="like"  class="emotion img_selected" src="{{ asset('images/noticias/like.png') }}" alt="Me Gusta"/>
                                                            </a>
                                                        </div>
                                                        <div class="emotion_list" id="like_dislikeImgF">
                                                            <span class="cant dislike" id="dimgmoref">{{ $get_dislike_generic }}</span>
                                                            <a id="dislimgAF" onclick="feel({{$encuesta_id}},{{$categoria_id}},{{$candidato_multimedia_id}},{{$candidato_id}},{{$tipo_multimedia}},{{2}},{{$opt}})">
                                                                <img id="dislike" class="emotion" src="{{ asset('images/noticias/dislike.png') }}" alt="No me Gusta"/>
                                                            </a>
                                                        </div>
                                                    </div>          

                                                    @elseif($getFeelBdUser->gusto == 2)
                                                    <div id="noMeGustaImgF">
                                                        <div class="emotion_list" id="dislikef_like">
                                                            <span class="cant like" id="limgmore">{{$get_like_generic }}</span>
                                                            <a id="likeimgBF" onclick="feel({{$encuesta_id}},{{$categoria_id}},{{$candidato_multimedia_id}},{{$candidato_id}},{{$tipo_multimedia}},{{1}},{{$opt}})">
                                                                <img id="like" class="emotion" src="{{ asset('images/noticias/like.png') }}" alt="Me Gusta"/>
                                                            </a>
                                                        </div>
                                                        <div class="emotion_list" id="dislikef_dislike">
                                                            <span class="cant dislike" id="dimgmore_selected">{{ $get_dislike_generic }}</span>
                                                            <a id="dislBF" onclick="feel({{$encuesta_id}},{{$categoria_id}},{{$candidato_multimedia_id}},{{$candidato_id}},{{$tipo_multimedia}},{{2}},{{$opt}})">
                                                                <img id="dislike" class="emotion img_selected" src="{{ asset('images/noticias/dislike.png') }}" alt="No me Gusta"/>
                                                            </a>
                                                        </div>              
                                                    </div>                                       
                                                    @else
                                                    <div id="genericoImgF">
                                                        <div class="emotion_list">
                                                            <span class="cant like" id="likegImgF">{{$get_like_generic}}</span>
                                                            <a id="likeimgCF" onclick="feel({{$encuesta_id}},{{$categoria_id}},{{$candidato_multimedia_id}},{{$candidato_id}},{{$tipo_multimedia}},{{1}},{{$opt}})">
                                                                <img id="like" src="{{ asset('images/noticias/like.png') }}" alt="Me Gusta"/>
                                                            </a>
                                                        </div>
                                                        <div class="emotion_list">
                                                            <span class="cant dislike" id="dislikegImgF">{{ $get_dislike_generic }}</span>
                                                            <a id="dislimgCF" onclick="feel({{$encuesta_id}},{{$categoria_id}},{{$candidato_multimedia_id}},{{$candidato_id}},{{$tipo_multimedia}},{{2}},{{$opt}})">
                                                                <img id="dislike" src="{{ asset('images/noticias/dislike.png') }}" alt="No me Gusta"/>
                                                            </a>
                                                        </div> 
                                                    </div>                                         
                                                    @endif
                                                    @elseif($getFeelBdUser==null) {{--'NO HA EMITIDO GUSTO '--}} 
                                                    <div id="genericoImgFO">
                                                        <div class="emotion_list">
                                                            <span class="cant like" id="likegImgFO">{{$get_like_generic}}</span>
                                                            <a id="likeimgFO" onclick="feel({{$encuesta_id}},{{$categoria_id}},{{$candidato_multimedia_id}},{{$candidato_id}},{{$tipo_multimedia}},{{1}},{{$opt}})">
                                                                <img id="like" src="{{ asset('images/noticias/like.png') }}" alt="Me Gusta"/>
                                                            </a>
                                                        </div>
                                                        <div class="emotion_list">
                                                            <span class="cant dislike" id="dislikeImgFO">{{ $get_dislike_generic }}</span>
                                                            <a id="dislimgFO" onclick="feel({{$encuesta_id}},{{$categoria_id}},{{$candidato_multimedia_id}},{{$candidato_id}},{{$tipo_multimedia}},{{2}},{{$opt}})">
                                                                <img id="dislike" src="{{ asset('images/noticias/dislike.png') }}" alt="No me Gusta"/>
                                                            </a>
                                                        </div> 
                                                    </div>  
                                                    @endif     
                                                    {{--'\\\\\\\\\\\\\\\\\ FIN IMAGEN DEL RANKINGWEB //////////////'--}}
                                                    @endif
                                                </div>  {{--'==first_load_RW=='--}}     
                                            </div> {{-- 'DIV PARA rweb_zone ' --}}

                                            {{--'\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\   ZONE - RANKING TELEFONICO  \\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\'--}}
                                            <div id="rtlf_zone" style="display: none">
                                                @php
                                                $encuesta_id = $params['data']['rankingtelf'][0]['encuesta_id'];
                                                $categoria_id = $params['id'];
                                                $candidato_multimedia_id = $params['data']['rankingtelf'][0]['candidato_multimedia_id'];
                                                $candidato_id = $params['data']['rankingtelf'][0]['id'];
                                                $cua=0;
                                                @endphp
                                                <input type="hidden" id="cuaT" value="{{$cua}}">                                            
                                                <div id="first_load_RT">
                                                    @if($params['data']['categorias'][0]->video == 1)
                                                    @php
                                                    $tipo_multimedia = 2;
                                                    $opt = 2;//RT 
                                                    //obtener likes del multimedia del candidato X
                                                    $get_like_generic = \App\Models\CmGustos::get_like_generic_cand($encuesta_id,$categoria_id,$candidato_multimedia_id,$candidato_id,$tipo_multimedia);

                                                    //obtener dislikes del multimedia del candidato 
                                                    $get_dislike_generic = \App\Models\CmGustos::get_dislike_generic_cand($encuesta_id,$categoria_id,$candidato_multimedia_id,$candidato_id,$tipo_multimedia);

                                                    //obtener el gusto emitido por el usuario
                                                    $getFeelBdUser = \App\Models\CmGustos::get_feeling_byUser($encuesta_id,$categoria_id,$candidato_multimedia_id,$candidato_id,$tipo_multimedia,Session::get("usuario")->id);
                                                    @endphp

                                                    @if($getFeelBdUser!=null) 
                                                    @if($getFeelBdUser->gusto == 1)
                                                    <div id="meGustaFRT">
                                                        <div class="emotion_list" id="like_likeflrtv">
                                                            <span class="cant like" id="lflrtv_selected">{{$get_like_generic }}</span>
                                                            <a id="likeaflrtv" onclick="feel({{$encuesta_id}},{{$categoria_id}},{{$candidato_multimedia_id}},{{$candidato_id}},{{$tipo_multimedia}},{{1}},{{$opt}})">
                                                                <img id="like"  class="emotion img_selected" src="{{ asset('images/noticias/like.png') }}" alt="Me Gusta"/>
                                                            </a>
                                                        </div>
                                                        <div class="emotion_list" id="like_dislikeflrtv">
                                                            <span class="cant dislike" id="dflrtv">{{ $get_dislike_generic }}</span>
                                                            <a id="dislaflrtv" onclick="feel({{$encuesta_id}},{{$categoria_id}},{{$candidato_multimedia_id}},{{$candidato_id}},{{$tipo_multimedia}},{{2}},{{$opt}})">
                                                                <img id="dislike" class="emotion" src="{{ asset('images/noticias/dislike.png') }}" alt="No me Gusta"/>
                                                            </a>
                                                        </div>
                                                    </div>

                                                    @elseif($getFeelBdUser->gusto == 2)
                                                    <div id="noMeGustaFRT">
                                                        <div class="emotion_list" id="dislike_likeflrtv">
                                                            <span class="cant like" id="lflrtv">{{$get_like_generic }}</span>
                                                            <a id="likebflrtv" onclick="feel({{$encuesta_id}},{{$categoria_id}},{{$candidato_multimedia_id}},{{$candidato_id}},{{$tipo_multimedia}},{{1}},{{$opt}})">
                                                                <img id="like" class="emotion" src="{{ asset('images/noticias/like.png') }}" alt="Me Gusta"/>
                                                            </a>
                                                        </div>
                                                        <div class="emotion_list" id="dislike_dislikeflrtv">
                                                            <span class="cant dislike" id="dflrtv_selected">{{ $get_dislike_generic }}</span>
                                                            <a id="dislbflrtv" onclick="feel({{$encuesta_id}},{{$categoria_id}},{{$candidato_multimedia_id}},{{$candidato_id}},{{$tipo_multimedia}},{{2}},{{$opt}})">
                                                                <img id="dislike" class="emotion img_selected" src="{{ asset('images/noticias/dislike.png') }}" alt="No me Gusta"/>
                                                            </a>
                                                        </div>              
                                                    </div> 
                                                    @else
                                                    <div id="genericoRT">
                                                        <div class="emotion_list">
                                                            <span class="cant like" id="likeg_flrtv">{{$get_like_generic}}</span>
                                                            <a id="likeaflrtv" onclick="feel({{$encuesta_id}},{{$categoria_id}},{{$candidato_multimedia_id}},{{$candidato_id}},{{$tipo_multimedia}},{{1}},{{$opt}})">
                                                                <img id="like" src="{{ asset('images/noticias/like.png') }}" alt="Me Gusta"/>
                                                            </a>
                                                        </div>
                                                        <div class="emotion_list">
                                                            <span class="cant dislike" id="dislikeg_flrtv">{{ $get_dislike_generic }}</span>
                                                            <a id="dislaflrtv" onclick="feel({{$encuesta_id}},{{$categoria_id}},{{$candidato_multimedia_id}},{{$candidato_id}},{{$tipo_multimedia}},{{2}},{{$opt}})">
                                                                <img id="dislike" src="{{ asset('images/noticias/dislike.png') }}" alt="No me Gusta"/>
                                                            </a>
                                                        </div> 
                                                    </div>
                                                    @endif
                                                    @elseif($getFeelBdUser==null) {{--'NO HA EMITIDO GUSTO '--}} 
                                                    <div id="genericoBRT">
                                                        <div class="emotion_list">
                                                            <span class="cant like" id="likegb_flrtv">{{$get_like_generic}}</span>
                                                            <a id="likeab_flrtv" onclick="feel({{$encuesta_id}},{{$categoria_id}},{{$candidato_multimedia_id}},{{$candidato_id}},{{$tipo_multimedia}},{{1}},{{$opt}})">
                                                                <img id="like" src="{{ asset('images/noticias/like.png') }}" alt="Me Gusta"/>
                                                            </a>
                                                        </div>
                                                        <div class="emotion_list">
                                                            <span class="cant dislike" id="dislikegb_flrtv">{{ $get_dislike_generic }}</span>
                                                            <a id="dislab_flrtv" onclick="feel({{$encuesta_id}},{{$categoria_id}},{{$candidato_multimedia_id}},{{$candidato_id}},{{$tipo_multimedia}},{{2}},{{$opt}})">
                                                                <img id="dislike" src="{{ asset('images/noticias/dislike.png') }}" alt="No me Gusta"/>
                                                            </a>
                                                        </div> 
                                                    </div>
                                                    @endif     

                                                    {{--'\\\\\\\\\\\\\\\\\ IMAGEN DEL RANKING WEB //////////////'--}}
                                                    @elseif($params['data']['categorias'][0]->img == 1)                
                                                    @php
                                                    $tipo_multimedia = 1;
                                                    $opt = 4; //imgRT
                                                    //obtener likes del multimedia del candidato X
                                                    $get_like_generic = \App\Models\CmGustos::get_like_generic_cand($encuesta_id,$categoria_id,$candidato_multimedia_id,$candidato_id,$tipo_multimedia);

                                                    //obtener dislikes del multimedia del candidato 
                                                    $get_dislike_generic = \App\Models\CmGustos::get_dislike_generic_cand($encuesta_id,$categoria_id,$candidato_multimedia_id,$candidato_id,$tipo_multimedia);

                                                    //obtener el gusto emitido por el usuario
                                                    $getFeelBdUser = \App\Models\CmGustos::get_feeling_byUser($encuesta_id,$categoria_id,$candidato_multimedia_id,$candidato_id,$tipo_multimedia,Session::get("usuario")->id);

                                                    @endphp

                                                    @if($getFeelBdUser!=null) 
                                                    @if($getFeelBdUser->gusto == 1)
                                                    <div id="meGustaImgFRT">
                                                        <div class="emotion_list" id="like_likeImgFRT">
                                                            <span class="cant like" id="limgmoref_selected">{{$get_like_generic }}</span>
                                                            <a id="likeimgAFRT" onclick="feel({{$encuesta_id}},{{$categoria_id}},{{$candidato_multimedia_id}},{{$candidato_id}},{{$tipo_multimedia}},{{1}},{{$opt}})">
                                                                <img id="like"  class="emotion img_selected" src="{{ asset('images/noticias/like.png') }}" alt="Me Gusta"/>
                                                            </a>
                                                        </div>
                                                        <div class="emotion_list" id="like_dislikeImgFRT">
                                                            <span class="cant dislike" id="dimgmorefRT">{{ $get_dislike_generic }}</span>
                                                            <a id="dislimgAFRT" onclick="feel({{$encuesta_id}},{{$categoria_id}},{{$candidato_multimedia_id}},{{$candidato_id}},{{$tipo_multimedia}},{{2}},{{$opt}})">
                                                                <img id="dislike" class="emotion" src="{{ asset('images/noticias/dislike.png') }}" alt="No me Gusta"/>
                                                            </a>
                                                        </div>
                                                    </div>          

                                                    @elseif($getFeelBdUser->gusto == 2)
                                                    <div id="noMeGustaImgFRT">
                                                        <div class="emotion_list" id="dislikef_likeRT">
                                                            <span class="cant like" id="limgmoreRT">{{$get_like_generic }}</span>
                                                            <a id="likeimgBFRT" onclick="feel({{$encuesta_id}},{{$categoria_id}},{{$candidato_multimedia_id}},{{$candidato_id}},{{$tipo_multimedia}},{{1}},{{$opt}})">
                                                                <img id="like" class="emotion" src="{{ asset('images/noticias/like.png') }}" alt="Me Gusta"/>
                                                            </a>
                                                        </div>
                                                        <div class="emotion_list" id="dislikef_dislikeRT">
                                                            <span class="cant dislike" id="dimgmoreRT_selected">{{ $get_dislike_generic }}</span>
                                                            <a id="dislBFRT" onclick="feel({{$encuesta_id}},{{$categoria_id}},{{$candidato_multimedia_id}},{{$candidato_id}},{{$tipo_multimedia}},{{2}},{{$opt}})">
                                                                <img id="dislike" class="emotion img_selected" src="{{ asset('images/noticias/dislike.png') }}" alt="No me Gusta"/>
                                                            </a>
                                                        </div>              
                                                    </div>                                       
                                                    @else
                                                    <div id="genericoImgFRT">
                                                        <div class="emotion_list">
                                                            <span class="cant like" id="likegImgFRT">{{$get_like_generic}}</span>
                                                            <a id="likeimgCFRT" onclick="feel({{$encuesta_id}},{{$categoria_id}},{{$candidato_multimedia_id}},{{$candidato_id}},{{$tipo_multimedia}},{{1}},{{$opt}})">
                                                                <img id="like" src="{{ asset('images/noticias/like.png') }}" alt="Me Gusta"/>
                                                            </a>
                                                        </div>
                                                        <div class="emotion_list">
                                                            <span class="cant dislike" id="dislikegImgFRT">{{ $get_dislike_generic }}</span>
                                                            <a id="dislimgCFRT" onclick="feel({{$encuesta_id}},{{$categoria_id}},{{$candidato_multimedia_id}},{{$candidato_id}},{{$tipo_multimedia}},{{2}},{{$opt}})">
                                                                <img id="dislike" src="{{ asset('images/noticias/dislike.png') }}" alt="No me Gusta"/>
                                                            </a>
                                                        </div> 
                                                    </div>                                         

                                                    @endif
                                                    @elseif($getFeelBdUser==null) {{--'NO HA EMITIDO GUSTO '--}} 
                                                    <div id="genericoImgFORT">
                                                        <div class="emotion_list">
                                                            <span class="cant like" id="likegImgFORT">{{$get_like_generic}}</span>
                                                            <a id="likeimgFORT" onclick="feel({{$encuesta_id}},{{$categoria_id}},{{$candidato_multimedia_id}},{{$candidato_id}},{{$tipo_multimedia}},{{1}},{{$opt}})">
                                                                <img id="like" src="{{ asset('images/noticias/like.png') }}" alt="Me Gusta"/>
                                                            </a>
                                                        </div>
                                                        <div class="emotion_list">
                                                            <span class="cant dislike" id="dislikeImgFORT">{{ $get_dislike_generic }}</span>
                                                            <a id="dislimgFORT" onclick="feel({{$encuesta_id}},{{$categoria_id}},{{$candidato_multimedia_id}},{{$candidato_id}},{{$tipo_multimedia}},{{2}},{{$opt}})">
                                                                <img id="dislike" src="{{ asset('images/noticias/dislike.png') }}" alt="No me Gusta"/>
                                                            </a>
                                                        </div> 
                                                    </div>  
                                                    @endif     

                                                    {{--'\\\\\\\\\\\\\\\\\ FIN IMAGEN DEL RANKING TLF //////////////'--}}
                                                    @endif
                                                </div>
                                            </div>  
                                            {{--'///////////////////////// FIN ZONE - RANKING TELEFONICO    ///////////////////////'--}}

                                            {{--'\\\\\\\\\\\\\\\\\ LOS DEMAS VIDEOS E IMAGENES DEL RANKING //////////////'--}}
                                            <div id="moreRWLoad">
                                                <div id="meGustaT" style="display: none;">
                                                    <div class="emotion_list" id="like_like">
                                                        <span class="cant like" id="lvmore_selected"></span>
                                                        <a id="likeb" >
                                                            <img id="likeUpTM"  src="{{ asset('images/noticias/like.png') }}" alt="Me Gusta"/>
                                                        </a>
                                                    </div>
                                                    <div class="emotion_list" id="like_dislike">
                                                        <span class="cant dislike" id="dvmore"></span>
                                                        <a id="dislb" >
                                                            <img id="dislikeUpTM" src="{{ asset('images/noticias/dislike.png') }}" alt="No me Gusta"/>
                                                        </a>
                                                    </div>
                                                </div>

                                                <div id="noMeGustaT" style="display: none;">
                                                    <div class="emotion_list" id="dislike_like">
                                                        <span class="cant like" id="lvmore"></span>
                                                        <a id="likec" >
                                                            <img id="like" src="{{ asset('images/noticias/like.png') }}" alt="Me Gusta"/>
                                                        </a>
                                                    </div>
                                                    <div class="emotion_list" id="dislike_dislike">
                                                        <span class="cant dislike" id="dvmore_selected"></span>
                                                        <a id="dislc" >
                                                            <img id="dislike"  src="{{ asset('images/noticias/dislike.png') }}" alt="No me Gusta"/>
                                                        </a>
                                                    </div>              
                                                </div> 

                                                <div id="genericoT" style="display: none;">
                                                    <div class="emotion_list">
                                                        <span class="cant like" id="likeg"></span>
                                                        <span class="cant like" id="likegT" style="display: none"></span>
                                                        <a id="likea" >
                                                            <img id="likeUp" src="{{ asset('images/noticias/like.png') }}" alt="Me Gusta"/>
                                                        </a>
                                                    </div>
                                                    <div class="emotion_list">
                                                        <span class="cant dislike" id="dislikeg"></span>
                                                        <span class="cant dislike" id="dislikegT" style="display: none"></span>
                                                        <a id="disla" >
                                                            <img id="dislikeUp" src="{{ asset('images/noticias/dislike.png') }}" alt="No me Gusta"/>
                                                        </a>
                                                    </div> 
                                                </div>

                                            </div>  
                                            {{--'\\\\\\\\\\\\\\\\\ FINAL DE LOS DEMAS VIDEOS DEL RANKING //////////////'--}}

                                            @else {{-- SIN AUTENTICAR --}}
                                            <div id="rweb_sinAuth">
                                                @if($params['data']['categorias'][0]->video == 1) {{-- 'ES UN VIDEO RANKINGWEB' --}}
                                                @php
                                                //obtener_likes_candidato
                                                $get_like_generic = \App\Models\CmGustos::get_like_generic_cand($params['data']['rankingweb'][0]['encuesta_id'],$params['id'],$params['data']['rankingweb'][0]['candidato_multimedia_id'],$params['data']['rankingweb'][0]['id'],2);

                                                //obtener_dislikes_candidato
                                                $get_dislike_generic = \App\Models\CmGustos::get_dislike_generic_cand($params['data']['rankingweb'][0]['encuesta_id'],$params['id'],$params['data']['rankingweb'][0]['candidato_multimedia_id'],$params['data']['rankingweb'][0]['id'],2);
                                                @endphp

                                                @elseif($params['data']['categorias'][0]->img == 1) {{-- 'ES UNA IMAGEN RANKINGWEB' --}}
                                                @php
                                                //obtener_likes_candidato
                                                $get_like_generic = \App\Models\CmGustos::get_like_generic_cand($params['data']['rankingweb'][0]['encuesta_id'],$params['id'],$params['data']['rankingweb'][0]['candidato_multimedia_id'],$params['data']['rankingweb'][0]['id'],1);

                                                //obtener_dislikes_candidato
                                                $get_dislike_generic = \App\Models\CmGustos::get_dislike_generic_cand($params['data']['rankingweb'][0]['encuesta_id'],$params['id'],$params['data']['rankingweb'][0]['candidato_multimedia_id'],$params['data']['rankingweb'][0]['id'],1);
                                                @endphp
                                                @endif
                                                <div id="emotionSinAuth"> 
                                                    <div class="emotion_list">
                                                        <span class="cant like" id="like_sinauth">{{$get_like_generic}}</span>
                                                        <a onclick="ingresarfm()">
                                                            <img id="like"  src="{{ asset('images/noticias/like.png') }}" alt="Me Gusta"/>
                                                        </a>
                                                    </div>
                                                    <div class="emotion_list">
                                                        <span class="cant dislike" id="dislike_sinauth">{{ $get_dislike_generic }}</span>
                                                        <a onclick="ingresarfm()">
                                                            <img id="dislike"  src="{{ asset('images/noticias/dislike.png') }}" alt="No me Gusta"/>
                                                        </a>
                                                    </div> 
                                                </div>
                                            </div>

                                            <div id="rtlf_sinAuth" style="display: none;">
                                                @if($params['data']['categorias'][0]->video == 1) {{-- 'ES UN VIDEO RANKING TLF' --}}
                                                @php
                                                //obtener_likes_candidato
                                                $get_like_generic = \App\Models\CmGustos::get_like_generic_cand($params['data']['rankingtelf'][0]['encuesta_id'],$params['id'],$params['data']['rankingtelf'][0]['candidato_multimedia_id'],$params['data']['rankingtelf'][0]['id'],2);

                                                //obtener_dislikes_candidato
                                                $get_dislike_generic = \App\Models\CmGustos::get_dislike_generic_cand($params['data']['rankingtelf'][0]['encuesta_id'],$params['id'],$params['data']['rankingtelf'][0]['candidato_multimedia_id'],$params['data']['rankingtelf'][0]['id'],2);
                                                @endphp

                                                @elseif($params['data']['categorias'][0]->img == 1) {{-- 'ES UNA IMAGEN RANKING TLF' --}}
                                                @php
                                                //obtener_likes_candidato
                                                $get_like_generic = \App\Models\CmGustos::get_like_generic_cand($params['data']['rankingtelf'][0]['encuesta_id'],$params['id'],$params['data']['rankingtelf'][0]['candidato_multimedia_id'],$params['data']['rankingtelf'][0]['id'],1);

                                                //obtener_dislikes_candidato
                                                $get_dislike_generic = \App\Models\CmGustos::get_dislike_generic_cand($params['data']['rankingtelf'][0]['encuesta_id'],$params['id'],$params['data']['rankingtelf'][0]['candidato_multimedia_id'],$params['data']['rankingtelf'][0]['id'],1);
                                                @endphp
                                                @endif  
                                                <div id="emotionSinAuthRT"> 
                                                    <div class="emotion_list">
                                                        <span class="cant like" id="like_sinauthRT">{{$get_like_generic}}</span>
                                                        <a onclick="ingresarfm()">
                                                            <img id="like"  src="{{ asset('images/noticias/like.png') }}" alt="Me Gusta"/>
                                                        </a>
                                                    </div>
                                                    <div class="emotion_list">
                                                        <span class="cant dislike" id="dislike_sinauthRT">{{ $get_dislike_generic }}</span>
                                                        <a onclick="ingresarfm()">
                                                            <img id="dislike"  src="{{ asset('images/noticias/dislike.png') }}" alt="No me Gusta"/>
                                                        </a>
                                                    </div> 
                                                </div>                                                                                         
                                            </div>

                                            {{--'CUANDO PINCHA OTRO VIDEO DEL RANKING  SIN AUTENTICARSE'--}}
                                            <div id="emotionSinAuthOther" style="display: none;" > 
                                                <div class="emotion_list">
                                                    <span class="cant like" id="like_sinauthO"></span>
                                                    <a onclick="ingresarfm()">
                                                        <img id="like"  src="{{ asset('images/noticias/like.png') }}" alt="Me Gusta"/>
                                                    </a>
                                                </div>
                                                <div class="emotion_list">
                                                    <span class="cant dislike" id="dislike_sinauthO"></span>
                                                    <a onclick="ingresarfm()">
                                                        <img id="dislike"  src="{{ asset('images/noticias/dislike.png') }}" alt="No me Gusta"/>
                                                    </a>
                                                </div> 
                                            </div>
                                            {{--///////////////////////////////  SIN AUTENTICAR   //////////////////////////////--}}
                                            @endif
                                        </div>{{--' END page-social'--}}                                
                                    </div> {{--' END page-data'--}}
                                </div>
                                <div class="col s5 m5 l5">
                                    <div class="share">
                                        <div class="popover" id="social-popover">
                                            <a href="#!"><i class="fa fa-twitter"></i></a>
                                            <a href="#!"><i class="fa fa-tumblr"></i></a>
                                            <a href="#!"><i class="fa fa-whatsapp"></i></a>
                                            <a href="#!"><i class="fa fa-facebook"></i></a>
                                            <a href="#!"><i class="fa fa-pinterest"></i></a>
                                        </div>
                                        
                                            <img data-action="share" id="share-button" src="{{ asset('images/noticias/social.png') }}" alt="Compartir"/>  
                                        </div>{{--  'END SHARE' --}}     
                                </div>

                            </div>{{--' END Div 12 global 2B'--}}
                        </div> {{-- '*************  FIN class card ***************' --}}
                        @endif {{-- '*************  FIN if kankingweb o telefonico ***************' --}}
                    </div> {{--' END Div 12 global 1'--}}



                    <div id="audiowebprincipal" style="display: none;">
                        <div class="audiowebdet">
                            <a href="javascript:void(0);" id="cerraraudiodetalle" class="btn-floating waves-effect waves-light grey right" style="margin-bottom: 10px; margin-top: 5px;"><i class="material-icons">clear</i></a>
                            <br><br>
                            <audio id="audioweb" src=" " controls autoplay loop style="border: 7px solid grey; height: 45px; border-radius: 10px;"></audio>
                        </div>
                    </div>


                    <div class="col s12 m12 l12">
                        <h4 class="t-sessionesh f-sessionesvv">HISTÓRICO</h4>
                        <div class="card">
                            <div class="card-image">
                                <img src="{{ asset("images/media/publicidad.png") }}">
                            </div>
                        </div>
                    </div>
                    <div class="col s12 m12 l12">
                        <!--Form-->
                        <div class="card-panel">
                            <h5 class="" style="color: #652D90">Consulte a nuestros especialistas</h5>
                            <div class="row">
                                <form class="col s12">
                                    <div class="row">
                                        <div class="input-field col s4">
                                            <input id="nombrecontac" type="text">
                                            <label for="nombrecontac">Nombre y Apellido</label>
                                        </div>
                                        <div class="input-field col s4">
                                            <input id="email" type="text">
                                            <label for="email">Email</label>
                                        </div>

                                        <div class="input-field col s4">
                                            <input id="telefono" type="text">
                                            <label for="telefono">Télefono</label>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="input-field col s6">
                                            <input id="empresa" type="text">
                                            <label for="empresa">Empresa</label>
                                        </div>
                                        <div class="input-field col s6">
                                            <select id="pais">
                                                <option value="0" disabled selected>Seleccione un país</option>
                                                <option value="Argentina">Argentina</option>
                                                <option value="Bolivia">Bolivia</option>
                                                <option value="China">China</option>
                                                <option value="México">México</option>
                                                <option value="Rusia">Rusia</option>
                                                <option value="Venezuela">Venezuela</option>
                                                <option value="Otro">Otro</option>
                                            </select>
                                            <label>País</label>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="input-field col s12">
                                            <textarea id="mensaje" class="materialize-textarea" length="120"></textarea>
                                            <label for="message">Mensaje</label>
                                        </div>
                                        <input type="hidden" id="categoria_id" value="{{$params['data']['categorias'][0]->id}}">
                                        <div class="row">
                                            <div class="input-field col s12">
                                                <a href="javascript:void(0);" class="btn red waves-effect waves-light  border-round mr-1 right contacto">Enviar
                                                    <i class="material-icons right">send</i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div><!-- M6 L6-->
            </div>
            <!--work collections end-->
        </div>
    </div>
</div>
@else
<h4 style="text-align: center">No hay Categorias Activas, Contacte con el Administrador Web</h4>
@endif


<!-- START MODALGeneric -->
<div id="ModalG" class="modal modal-fixed-footer">
    <div class="modal-content">
        <div class="modal-body" id="cuerpoModal">

        </div>
    </div>
    <!-- END MODAL CONTANT --> 

    <div class="modal-footer">
        <a href="#!" class="modal-action modal-close waves-effect waves-red btn-flat ">Cerrar</a>
    </div>
</div>
<!-- END MODALG -->    



{{-- SHARE SNS --}}

<script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>

<!-- Inserta esta etiqueta en la sección "head" o justo antes de la etiqueta "body" de cierre. -->
<script src="https://apis.google.com/js/platform.js" async defer>
                                                        {lang: 'es'}
</script>

<div id="fb-root"></div>
<script>
    (function(d, s, id) {
    var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id)) return;
    js = d.createElement(s); js.id = id;
    js.src = 'https://connect.facebook.net/es_ES/sdk.js#xfbml=1&version=v3.1&appId=2113524235564288&autoLogAppEvents=1';
    fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));</script>
@endsection
@section('javascripts')
@parent
<!--chartjs-->
<script src="{{ asset('vendors/chartjs/chart.min.js') }}"></script>
<!--sparkline-->
<script src="{{ asset('vendors/sparkline/jquery.sparkline.min.js') }}"></script>
<!--card-advanced.js - Page specific JS-->
<script src="{{ asset('js/scripts/card-advanced.js') }}"></script>

<script src="{{ asset('js/share.js') }}"></script>

@endsection