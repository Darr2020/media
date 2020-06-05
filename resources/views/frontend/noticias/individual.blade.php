@extends('layout.base')

@section('title', $noticia->titulo)

@section('stylesheets')
    @parent
    <link rel="stylesheet" href="{{ asset('css/noticias/individual.noticia.css') }}">
    <link rel="stylesheet" href="{{ asset('css/noticias/categoria.noticia.css') }}">
@endsection

@section('navbar-top')
@show

@section('meta')
    @parent
    <meta name="descripcion" content="{{ $noticia->descripcion }}" />
    <meta name="language" content="spanish"/>
    <meta name="keywords" content="@foreach($noticia->tagDeNoticia as $tagDeNoticia){{ trim($tagDeNoticia->tag->nombre) }}@if(!$loop->last),@endif @endforeach"/>
@endsection

@section('body')
    
<div ng-app="myApp">
    <section id="categories">
        @foreach($categorias as $c)
            @if($loop->last)
            <span><a href="{{ route('categoria_individual', ['id' => $c->id ]) }}" style="color:#{{ $c->hexcode }};@if($noticia->id_categoria == $c->id)font-size:5vmin @endif">{{ $c->nombre }}</a></span>
            @else
            <span><a href="{{ route('categoria_individual', ['id' => $c->id ]) }}" style="color:#{{ $c->hexcode }};@if($noticia->id_categoria == $c->id)font-size:5vmin @endif">{{ $c->nombre }}</a><b>|</b></span>
            @endif
        @endforeach
    </section>
    <div class="row">
        <div class="col s12 m12 l8 page-content">
            <span id="catcolor">{{ $noticia->hexcode }}</span>
            <span id="newcode" class="hidden">{{ $noticia->id }}</span>
            <div class="page-title">
                @if(in_array(\App\Tools\NoticiaTool::mainPosition($noticia->title_position),['superior','central']))<h3><b>{{ $noticia->titulo }}</b></h3>@endif
                <img data-border class="image-title" src="{{ asset('storage/portadas/'.$noticia->foto_portada) }}" alt="portada">
                @if(in_array(\App\Tools\NoticiaTool::mainPosition($noticia->title_position),['inferior']))<h3><b>{{ $noticia->titulo }}</b></h3>@endif
            </div>
            <div class="page-data">
                <div class="page-labels">
                    {{--<span class="categoria" data-hex-bg="{{ $noticia->hexcode }}" data-hex-cl="{{ $noticia->hexcode }}"><b>{{ $noticia->categoria }}</b></span><br>--}}
                    <span class="fecha">{{ \Carbon\Carbon::createFromFormat('Y-m-d',$noticia->fecha_esc)->format('d-m-Y H:m a') }}</span><br>
                    Por <i><b>{{ $noticia->nombre }}</b></i>
                </div>
                <div class="page-social" ng-controller="likeController">
                    @if(!$rating)
                        <div class="emotion_list" @if(!Session::has('usuario')) onclick="ingresarfm()" @else ng-click="like(this)" @endif><span class="cant like">{{ $noticia->likes() }}</span><img id="like" src="{{ asset('images/noticias/like.png') }}" alt="Me Gusta"/></div>
                        <div class="emotion_list" @if(!Session::has('usuario')) onclick="ingresarfm()" @else ng-click="dislike(this)" @endif><span class="cant dislike">{{ $noticia->dislikes() }}</span><img id="dislike" src="{{ asset('images/noticias/dislike.png') }}" alt="No me Gusta"/></div>
                    @else
                        @if($rating->id_emocion == 2)
                        <div class="emotion_list" @if(!Session::has('usuario')) onclick="ingresarfm()" @else ng-click="like(this)" @endif><span class="cant like">{{ $noticia->likes() }}</span><img class="emotion" id="like" src="{{ asset('images/noticias/like.png') }}" alt="Me Gusta"/></div>
                        <div class="emotion_list" @if(!Session::has('usuario')) onclick="ingresarfm()" @else ng-click="dislike(this)" @endif><span class="cant dislike">{{ $noticia->dislikes() }}</span><img class="emotion img_selected" id="dislike" src="{{ asset('images/noticias/dislike.png') }}" alt="No me Gusta"/></div>
                        @else
                        <div class="emotion_list" @if(!Session::has('usuario')) onclick="ingresarfm()" @else ng-click="like(this)" @endif><span class="cant like">{{ $noticia->likes() }}</span><img class="emotion img_selected" id="like" src="{{ asset('images/noticias/like.png') }}" alt="Me Gusta"/></div>
                        <div class="emotion_list" @if(!Session::has('usuario')) onclick="ingresarfm()" @else ng-click="dislike(this)" @endif><span class="cant dislike">{{ $noticia->dislikes() }}</span><img class="emotion" id="dislike" src="{{ asset('images/noticias/dislike.png') }}" alt="No me Gusta"/></div>
                        @endif
                    @endif
                    <div class="share">
                        <div class="popover" id="social-popover">
                            <a href="#!"><i class="fa fa-twitter"></i></a>
                            <a href="#!"><i class="fa fa-tumblr"></i></a>
                            <a href="#!"><i class="fa fa-whatsapp"></i></a>
                            <a href="#!"><i class="fa fa-facebook"></i></a>
                            <a href="#!"><i class="fa fa-pinterest"></i></a>
                        </div>
                        <img data-action="share" id="share-button" src="{{ asset('images/noticias/social.png') }}" alt="Compartir"/>
                    </div>
                </div>
            </div>
        </div>
        <div class="col s12 m12 l4" style="padding-top:20px">
            <form id="redform" method="POST" target="_blank" action="/categoria_detalle">
            {{ csrf_field() }}
            <input type="hidden" value="0" name="id">
            </form>
            <ul class="collapsible" data-collapsible="accordion">
                @forelse($topRanking as $categoria => $candidatos)
                    <li>
                        <div class="collapsible-header @if($loop->first) active @endif">
                            <b> TOP {{ strtoupper($categoria) }}</b>
                        </div>
                        <div class="collapsible-body">
                            @foreach($candidatos as $key => $single)
                                @if(!in_array($key, [0,1,2]))
                                    @continue
                                @endif
                                <div class="candidatos" data-position="{{ $key }}">
                                    <div class="position{{ $key + 1 }}"></div>
                                    <img src="{{ asset("candidatos/images/".strtolower($single->img))}}">    
                                    <div class="info">
                                        <p><span class="title">{{ $single->nombrecandidato }}</span><br>
                                        <span class="genre">Genero: {{ implode(',',array_splice($single->generos,0,2)) }}</span><br>
                                        <span class="votos">{{ $single->votos }} Votos</span></p>
                                        <span class="redirect" onclick="redirect({{ $single->categoria_id }})">Ver mas</span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </li>
                @empty
                @endforelse
            </ul>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col s12 m12 l8" id="new-html">
                {!! $html !!}
            </div>
            <div class="col s12 m12 l4">
                
            </div>
        </div>
    </div>
    <section class="comentarios" ng-controller="comentsController">
        <div class="comment_section row">
            <div class="col s2 m2 l2">
                @if(Session::has('usuario') && Session::get('usuario')->avatar)
                <img class="avatar" src="{{ asset('images/avatar/'.Session::get('usuario')->avatar) }}" alt="avatar">
                @else
                <img class="avatar" src="{{ asset('images/avatar/avatar-0.png') }}" alt="avatar">
                @endif
            </div>
            <div class="col s12 m10 l10">
                <div class="input-field">
                    <textarea @if(!Session::has('usuario')) disabled @endif ng-model="comentar" data-length="500" maxlength="500" id="comentar" class="materialize-textarea" data-hex-border="{{ $noticia->hexcode }}"></textarea>
                    <label for="comentar">Agregar Comentario</label>
                </div>
            </div>
        </div>
        <button class="ver" @if(!Session::has('usuario')) onclick="ingresarfm()" @else ng-click="addComment($event)" @endif>Agregar Comentario</button>
        <div class="comments">
            <div class="row comment" ng-repeat="c in comentarios">
                <div class="col s2">
                    <div class="avatar" ng-if="c.avatar != null"><img src="@{{ c.avatar }}" alt="avatar"></div>
                    <div class="avatar" ng-if="c.avatar == null"><img src="{{ asset('images/avatar/avatar-0.png') }}" alt="avatar"></div>
                </div>
                <div class="col s10">
                    <span class="fecha">@{{ formatDate(c.fecha_done) | date:"dd-MM-yyyy 'a las' h:mm a" }}</span>
                    <span class="comentator">@{{ c.nombre }}</span>            
                    <span class="content">@{{ c.comentario }}</span>
                </div>
            </div>
        </div>
        <button class="ver" ng-show="buttons.mas" ng-click="displayMore($event)">Ver más</button>
    </section>

    <section class="interest">
        <div class="row">
            <div class="col s12 m12 l8">
                <h4 class="title">Lo + visto</h4>
                @foreach($most as $key => $e)
                    <div class="row most-container @if($loop->last) last @endif">
                        <div class="col s4 image">
                            <a href="{{ route('noticia_individual', ['id' => $e->id]) }}"><img src="{{ asset('storage/portadas/'.$e->foto_portada) }}"></a>
                        </div>
                        <div class="col s8 details">
                            <a href="{{ route('noticia_individual', ['id' => $e->id]) }}"><span class="title">{{ $e->titulo }}</span></a>
                            <span class="desc">{{ $e->descripcion }}</span>
                            <span class="categoria" data-hex-bg="{{ $e->hexcode }}" data-hex-cl="{{ $e->hexcode }}">{{ $e->categoria }}</span>
                            <span class="most-megusta"><span class="cant">{{ $e->megusta }}</span><img src="{{ asset('images/noticias/like.png') }}"></span>
                            <span class="most-nomegusta"><span class="cant">{{ $e->nomegusta }}</span><img src="{{ asset('images/noticias/dislike.png') }}"></span>
                        </div>
                    </div>
                @endforeach
                <h4 class="title">Te interesará</h4>
                @foreach($interes as $key => $e)
                    <div class="row most-container @if($loop->last) last @endif">
                        <div class="col s4 image">
                            <a href="{{ route('noticia_individual', ['id' => $e->id]) }}"><img src="{{ asset('storage/portadas/'.$e->foto_portada) }}"></a>
                        </div>
                        <div class="col s8 details">
                            <a href="{{ route('noticia_individual', ['id' => $e->id]) }}"><span class="title">{{ $e->titulo }}</span></a>
                            <span class="desc">{{ $e->descripcion }}</span>
                            <span class="most-megusta"><span class="cant">{{ $e->megusta }}</span><img src="{{ asset('images/noticias/like.png') }}"></span>
                            <span class="most-nomegusta"><span class="cant">{{ $e->nomegusta }}</span><img src="{{ asset('images/noticias/dislike.png') }}"></span>
                            <span class="categoria" data-hex-bg="{{ $e->hexcode }}" data-hex-cl="{{ $e->hexcode }}">{{ $e->categoria }}</span>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="col s12 m6 l8"></div>
        </div>
    </section>
    <div class="popover" id="social-popover">
        <div class="close">&times;</div>
        <div class="share-container">
            <div class="header">Compartir en</div>
            <div class="web">
                <a href="#!"><i class="fa fa-twitter"></i></a>
                <a href="#!"><i class="fa fa-tumblr"></i></a>
                <a href="#!"><i class="fa fa-whatsapp"></i></a>
                <a href="#!"><i class="fa fa-facebook"></i></a>
                <a href="#!"><i class="fa fa-pinterest"></i></a>
            </div>
        </div>
    </div>
@endsection

@section('javascripts')
    @parent
    <script src="{{ asset('vendors/angular.min.js') }}"></script>
    <script src="{{ asset('js/noticias/individual_noticia.js') }}"></script>
@endsection