@extends("layout.base")
@section("title", "MediaMétrica")
@section('stylesheets')
@parent

@endsection
@section("body")
<div class="section">
    <div class="row">
        <div class="col s12 m12 l12">
            <div class="slider">
                <ul class="slides">
                    @if($params['carousel'] != null)
                    @foreach($params['carousel'] as $carousel)
                    <li>
                        <img width="1200" height="700" src="{{ asset("images/gallary/".$carousel->imagen) }}">
                    </li>
                    @endforeach
                    @else
                    <li>
                        <img width="1200" height="700" src="{{ asset("images/gallary/Mcolor-01.png") }}">
                    </li>
                    @endif
                </ul>
            </div>
        </div>
    </div>
</div>
<div class="autocentrado">
    <div class="divider"></div>
    <div id="card-reveal" class="section">
        <div class="row">
            @if($params['home'] != false)
            @foreach($params['home'] as $categ)
            @if(count($categ) >= 5)
            <div class="col s12 m6 l4">
                <div class="card f-sessiones">
                    <div class="card-image">
                        @if(count($categ[0]) == 0)
                        <img width="420px" height="360px" src="{{ asset("images/media/Mcolor-01.png") }}">
                        @else
                        <img width="420px" height="360px" src="{{ asset("candidatos/images/".$categ[0]['img'])}}">
                        @endif
                    </div>
                    <div class="card-content" style="padding: 15px;">
                        <h4 class="t-sessiones"> {{strtoupper($categ[0]['nombre_categoria'])}}</h4>
                        <div class="col s12 m12 l12 votaciones">
                            <div class="col s2 m2 l2 gradient-gold">
                                1 
                            </div>
                            <div class="portfolio col s2 m2 l2">
                                @if($categ[0]['opcionvideo'] == 1)
                                <figure>
                                    <a onclick="videos({{$categ[0]['id']}},{{1}})" href="javascript:void(0);"> 
                                        <img class="i-sessiones" src="{{ asset("candidatos/images/".$categ[0]['img'])}}">
                                        <figcaption>
                                            <img class="imgvideo video" width="60" height="60" src="{{ asset("images/media/videover.png")}}">
                                        </figcaption>
                                    </a>
                                </figure>
                                @elseif($categ[0]['opcionimg'] == 1)
                                <img class="i-sessiones" src="{{ asset("candidatos/images/".$categ[0]['img'])}}">
                                @else
                                <img class="i-sessiones" src="{{ asset("images/media/Mcolor-01.png") }}">
                                @endif
                            </div>
                            <div class="col s4 m4 l4">
                                <font class="titulotop tooltipped" data-position="top" data-delay="50" data-tooltip="{{$categ[0]['nombrecandidato']}}">{{substr($categ[0]['nombrecandidato'], 0, 10)}}...</font><br>
                                @if($categ[0]['opciongenero'] == 1)
                                <font class="generotop">Género: 
                                {{--@foreach($categ[0]['generos'] as $generos)--}}
                                {{$categ[0]['generos'][0]}} 
                                {{--@endforeach--}}
                                </font>
                                @endif
                                <br>
                                <font class="vistastop">0 vistas</font><br>
                            </div>
                            <div class="col s4 m4 l4 votaciones">
                                @if($categ[0]['opcionaudio'] == 1)

                                <a  onclick="audios({{$categ[0]['id']}},{{1}})" href="javascript:void(0);"> 
                                    <img width="26px" height="26px" src="{{ asset("images/media/audifonomorado.png") }}">
                                </a>
                                @else
                                <img width="26px" height="26px" src="{{ asset("images/media/audifonodisable.png") }}" disabled>
                                @endif
                                @if(Session::has('usuario'))
                                @if($categ[0]['votos'] == 0)
                                <a onclick="voto({{$categ[0]['id']}},{{$categ[0]['categoria_id']}},{{$categ[0]['encuesta_id']}})" class="waves-effect waves-cyan">
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
                                <font class="top-sessiones {{$categ[0]['movimiento']}}">{{$categ[0]['puntaje']}}</font>
                            </div>
                        </div>
                        <div class="col s12 m12 l12 votaciones">
                            <div class="col s2 m2 l2 gradient-silver">
                                2 
                            </div>
                            <div class="col s2 m2 l2">
                                @if($categ[0]['opcionvideo'] == 1)
                                <figure>
                                    <a onclick="videos({{$categ[1]['id']}},{{1}})" href="javascript:void(0);"> 
                                        <img class="i-sessiones" src="{{ asset("candidatos/images/".$categ[1]['img'])}}">
                                        <figcaption>
                                            <img class="imgvideo video" width="60" height="60" src="{{ asset("images/media/videover.png")}}">
                                        </figcaption>
                                    </a>
                                </figure>
                                @elseif($categ[0]['opcionimg'] == 1)
                                <img class="i-sessiones" src="{{ asset("candidatos/images/".$categ[1]['img'])}}">
                                @else
                                <img class="i-sessiones" src="{{ asset("images/media/Mcolor-01.png") }}">
                                @endif
                            </div>
                            <div class="col s4 m4 l4">
                                <font class="titulotop tooltipped" data-position="top" data-delay="50" data-tooltip="{{$categ[1]['nombrecandidato']}}">{{substr($categ[1]['nombrecandidato'], 0, 10)}}...</font><br>
                                @if($categ[0]['opciongenero'] == 1)
                                <font class="generotop">Género: 
                                {{--@foreach($categ[1]['generos'] as $generos)--}}
                                {{$categ[1]['generos'][0]}} 
                                {{--@endforeach--}}
                                </font>
                                @endif
                                <br>
                                <font class="vistastop">0 vistas</font><br>
                            </div>
                            <div class="col s4 m4 l4 votaciones">
                                @if($categ[0]['opcionaudio'] == 1)
                                <a  onclick="audios({{$categ[1]['id']}},{{1}})" href="javascript:void(0);"> 
                                    <img width="26px" height="26px" src="{{ asset("images/media/audifonomorado.png") }}">
                                </a>
                                @else
                                <img width="26px" height="26px" src="{{ asset("images/media/audifonodisable.png") }}" disabled>
                                @endif
                                @if(Session::has('usuario'))
                                @if($categ[0]['votos'] == 0)
                                <a onclick="voto({{$categ[1]['id']}},{{$categ[0]['categoria_id']}},{{$categ[0]['encuesta_id']}})" class="waves-effect waves-cyan">
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
                                <font class="top-sessiones {{$categ[1]['movimiento']}}">{{$categ[1]['puntaje']}}</font>
                            </div>
                        </div>
                        <div class="col s12 m12 l12 votaciones">
                            <div class="col s2 m2 l2 gradient-bronze">
                                3
                            </div>
                            <div class="col s2 m2 l2">
                                @if($categ[0]['opcionvideo'] == 1)
                                <figure>
                                    <a onclick="videos({{$categ[2]['id']}},{{1}})" href="javascript:void(0);"> 
                                        <img class="i-sessiones" src="{{ asset("candidatos/images/".$categ[2]['img'])}}">
                                        <figcaption>
                                            <img class="imgvideo video" width="60" height="60" src="{{ asset("images/media/videover.png")}}">
                                        </figcaption>
                                    </a>
                                </figure>
                                @elseif($categ[0]['opcionimg'] == 1)
                                <img class="i-sessiones" src="{{ asset("candidatos/images/".$categ[2]['img'])}}">
                                @else
                                <img class="i-sessiones" src="{{ asset("images/media/Mcolor-01.png") }}">
                                @endif
                            </div>
                            <div class="col s4 m4 l4">
                                <font class="titulotop tooltipped" data-position="top" data-delay="50" data-tooltip="{{$categ[2]['nombrecandidato']}}">{{substr($categ[2]['nombrecandidato'], 0, 10)}}...</font><br>
                                @if($categ[0]['opciongenero'] == 1)
                                <font class="generotop">Género: 
                                {{--@foreach($categ[2]['generos'] as $generos)--}}
                                {{$categ[2]['generos'][0]}} 
                                {{--@endforeach--}}
                                </font>
                                @endif
                                <br>
                                <font class="vistastop">0 vistas</font><br>
                            </div>
                            <div class="col s4 m4 l4 votaciones">
                                @if($categ[0]['opcionaudio'] == 1)
                                <a  onclick="audios({{$categ[2]['id']}},{{1}})" href="javascript:void(0);"> 
                                    <img width="26px" height="26px" src="{{ asset("images/media/audifonomorado.png") }}">
                                </a>
                                @else
                                <img width="26px" height="26px" src="{{ asset("images/media/audifonodisable.png") }}" disabled>
                                @endif
                                @if(Session::has('usuario'))
                                @if($categ[0]['votos'] == 0)
                                <a onclick="voto({{$categ[2]['id']}},{{$categ[0]['categoria_id']}},{{$categ[0]['encuesta_id']}})" class="waves-effect waves-cyan">
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
                                <font class="top-sessiones {{$categ[2]['movimiento']}}">{{$categ[2]['puntaje']}}</font>
                            </div>
                        </div>
                        <div class="col s12 m12 l12 votaciones">
                            <div class="cirulo col s2 m2 l2">
                                4
                            </div>
                            <div class="col s2 m2 l2">
                                @if($categ[0]['opcionvideo'] == 1)
                                <figure>
                                    <a onclick="videos({{$categ[3]['id']}},{{1}})" href="javascript:void(0);"> 
                                        <img class="i-sessiones" src="{{ asset("candidatos/images/".$categ[3]['img'])}}">
                                        <figcaption>
                                            <img class="imgvideo video" width="60" height="60" src="{{ asset("images/media/videover.png")}}">
                                        </figcaption>
                                    </a>
                                </figure>
                                @elseif($categ[0]['opcionimg'] == 1)
                                <img class="i-sessiones" src="{{ asset("candidatos/images/".$categ[3]['img'])}}">
                                @else
                                <img class="i-sessiones" src="{{ asset("images/media/Mcolor-01.png") }}">
                                @endif
                            </div>
                            <div class="col s4 m4 l4">
                                <font class="titulotop tooltipped" data-position="top" data-delay="50" data-tooltip="{{$categ[3]['nombrecandidato']}}">{{substr($categ[3]['nombrecandidato'], 0, 10)}}...</font><br>
                                @if($categ[0]['opciongenero'] == 1)
                                <font class="generotop">Género: 
                                {{--@foreach($categ[3]['generos'] as $generos)--}}
                                {{$categ[3]['generos'][0]}} 
                                {{--@endforeach--}}
                                </font>
                                @endif
                                <br>
                                <font class="vistastop">0 vistas</font><br>
                            </div>
                            <div class="col s4 m4 l4 votaciones">
                                @if($categ[0]['opcionaudio'] == 1)
                                <a  onclick="audios({{$categ[3]['id']}},{{1}})" href="javascript:void(0);"> 
                                    <img width="26px" height="26px" src="{{ asset("images/media/audifonomorado.png") }}">
                                </a>
                                @else
                                <img width="26px" height="26px" src="{{ asset("images/media/audifonodisable.png") }}" disabled>
                                @endif
                                @if(Session::has('usuario'))
                                @if($categ[0]['votos'] == 0)
                                <a onclick="voto({{$categ[3]['id']}},{{$categ[0]['categoria_id']}},{{$categ[0]['encuesta_id']}})" class="waves-effect waves-cyan">
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
                                <font class="top-sessiones {{$categ[3]['movimiento']}}">{{$categ[3]['puntaje']}}</font>
                            </div>
                        </div>
                        <div class="col s12 m12 l12 votaciones">
                            <div class="cirulo col s2 m2 l2">
                                5
                            </div>
                            <div class="col s2 m2 l2">
                                @if($categ[0]['opcionvideo'] == 1)
                                <figure>
                                    <a onclick="videos({{$categ[4]['id']}},{{1}})" href="javascript:void(0);"> 
                                        <img class="i-sessiones" src="{{ asset("candidatos/images/".$categ[4]['img'])}}">
                                        <figcaption>
                                            <img class="imgvideo video" width="60" height="60" src="{{ asset("images/media/videover.png")}}">
                                        </figcaption>
                                    </a>
                                </figure>
                                @elseif($categ[0]['opcionimg'] == 1)
                                <img class="i-sessiones" src="{{ asset("candidatos/images/".$categ[4]['img'])}}">
                                @else
                                <img class="i-sessiones" src="{{ asset("images/media/Mcolor-01.png") }}">
                                @endif
                            </div>
                            <div class="col s4 m4 l4">
                                <font class="titulotop tooltipped" data-position="top" data-delay="50" data-tooltip="{{$categ[4]['nombrecandidato']}}">{{substr($categ[4]['nombrecandidato'], 0, 10)}}...</font><br>
                                @if($categ[0]['opciongenero'] == 1)
                                <font class="generotop">Género: 
                                {{--@foreach($categ[4]['generos'] as $generos)--}}
                                {{$categ[4]['generos'][0]}} 
                                {{--@endforeach--}}
                                </font>
                                @endif
                                <br>
                                <font class="vistastop">0 vistas</font><br>
                            </div>
                            <div class="col s4 m4 l4 votaciones">
                                @if($categ[0]['opcionaudio'] == 1)
                                <a  onclick="audios({{$categ[4]['id']}},{{1}})" href="javascript:void(0);"> 
                                    <img width="26px" height="26px" src="{{ asset("images/media/audifonomorado.png") }}">
                                </a>
                                @else
                                <img width="26px" height="26px" src="{{ asset("images/media/audifonodisable.png") }}" disabled>
                                @endif
                                @if(Session::has('usuario'))
                                @if($categ[0]['votos'] == 0)
                                <a onclick="voto({{$categ[4]['id']}},{{$categ[0]['categoria_id']}},{{$categ[0]['encuesta_id']}})" class="waves-effect waves-cyan">
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
                                <font class="top-sessiones {{$categ[4]['movimiento']}}">{{$categ[4]['puntaje']}}</font>
                            </div>
                        </div>
                        <div class="col s12 m12 l12" style="text-align:right">
                            <font>
                            <a class="titulotop" href="javascript:void(0);" onclick="verpagina({{$categ[0]['categoria_id']}})"> Ver más </a>
                            </font>
                            <br><br>
                        </div>
                    </div>
                </div>
            </div>
            @endif
            @endforeach
            @else
            <h4 style="text-align: center">No hay Categorias Activas, Contacte con el Administrador Web</h4>
            @endif
        </div>
    </div>    
</div>
<div id="videowebprincipal" style="display: none;">
    <div class="videoweb">
        <div class="right" style="margin-bottom: 10px; margin-top: 5px; font-weight: bold;">
            <a href="javascript:void(0);" id="cerrarvideo" class="btn-floating waves-effect waves-light grey"><i class="material-icons">clear</i></a>
        </div>
        <br><br>
        <div class="video-container responsive-video no-controls">
            <iframe width="500" height="150" id="videoweb" src=" " frameborder="0" allow="autoplay; encrypted-media" allowfullscreen style="border-radius: 13px;"></iframe>
        </div>
    </div>
</div>
<div id="audiowebprincipal" style="display: none;">
    <div class="audioweb">
        <div class="right" style="margin-bottom: 10px; margin-top: 5px; font-weight: bold;">
            <a href="javascript:void(0);" id="cerraraudio" class="btn-floating waves-effect waves-light grey"><i class="material-icons">clear</i></a>
        </div>
        <br><br>
        <audio id="audioweb" src=" " controls autoplay loop style="border: 7px solid grey; height: 45px; border-radius: 10px;"></audio>
    </div>
</div>
@endsection
@section('javascripts')
@parent
@endsection
