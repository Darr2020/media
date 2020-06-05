@extends('layout.base-test')

@section('title', 'Noticia de Prueba')

@section('stylesheets')
    @parent
    <link rel="stylesheet" href="{{ asset('css/noticias/individual.noticia.css') }}">
    <style> 
        .control-panel{
            position:absolute;
            top:0;
            height:60px;
            width:100%;
            padding:10px;
            z-index:5000px;
        }
    </style>
@endsection


@section('body')
    @if(Auth::user()->is('escritor') && Auth::user()->id == $noticia->id_writer)
    <div class="control-panel gradient-45deg-purple-deep-orange gradient-shadow">
        <button onclick="displayModal()" class="btn waves-effect waves gradient-45deg-light-blue-cyan gradient-shadow"><i class="fa fa-gears"></i> MODIFICAR</button>
        @if($noticia->published)
        <button onclick="publicacion(false, {{ $noticia->id }}, this)" class="btn waves-effect waves gradient-45deg-light-blue-cyan gradient-shadow"><i class="fa fa-trash"></i> ELIMINAR PUBLICACIÓN</button>
        @else
        <button onclick="publicacion(true, {{ $noticia->id }}, this)" class="btn waves-effect waves gradient-45deg-light-blue-cyan gradient-shadow"><i class="fa fa-book"></i> PUBLICAR</button>
        @endif
    </div>
    @elseif(Auth::user()->is(['admin','editor']))
    <div class="control-panel gradient-45deg-purple-deep-orange gradient-shadow">
        <button onclick="displayModal()" class="btn waves-effect waves gradient-45deg-light-blue-cyan gradient-shadow"><i class="fa fa-gears"></i> MODIFICAR</button>
        @if($noticia->published)
        <button onclick="publicacion(false, {{ $noticia->id }}, this)" class="btn waves-effect waves gradient-45deg-light-blue-cyan gradient-shadow"><i class="fa fa-trash"></i> ELIMINAR PUBLICACIÓN</button>
        @else
        <button onclick="publicacion(true, {{ $noticia->id }}, this)" class="btn waves-effect waves gradient-45deg-light-blue-cyan gradient-shadow"><i class="fa fa-book"></i> PUBLICAR</button>
        @endif
    </div>
    @endif
    <div ng-app="myApp">
    
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
                    <b><i>{{ $noticia->nombre }}</i>, {{ \Carbon\Carbon::createFromFormat('Y-m-d',$noticia->fecha_esc)->format('d-m-Y H:m a') }}</b>
                </div>
                <div class="page-tags">
                    @foreach($noticia->tagDeNoticia as $tagDeNoticia)
                        <b data-hex-cl="{{ $noticia->hexcode }}">#{{ $tagDeNoticia->tag->nombre }}@if(!$loop->last) , @endif</b>
                    @endforeach
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
    @if(Auth::user()->is('escritor') && Auth::user()->id == $noticia->id_writer)
        <div class="modal" id="modal-noticia">
        <div class="modal-content">
            <div id="iframe-display">
                <form id="noticia-form">
                    <input type="hidden" name="id" value="{{ $noticia->id }}">
                    <div class="input-field">
                        <input type="text" id="titulo" maxlength="60" name="titulo" data-length="60" value="{{ $noticia->titulo }}">
                        <label for="titulo">Titulo de Noticia</label>
                    </div>
                    <div class="input-field">
                        <textarea type="text" id="descripcion" name="descripcion" maxlength="120" data-length="120" class="materialize-textarea">{{ $noticia->descripcion }}</textarea>
                        <label for="descripcion">Descripcion de la Noticia</label>
                    </div>
                    <div class="row">
                        <div class="col s12 radios">
                            <h6>Posición de Titulo</h6>
                            <p>
                                <input type="radio" name="position" id="se" value="se" @if($noticia->title_position == "se") checked @endif>
                                <label for="se">Superior-externo</label>
                            </p>
                            <p>
                                <input type="radio" name="position" id="ie" value="ie" @if($noticia->title_position == "ie") checked @endif>
                                <label for="ie">Inferior-externo</label>
                            </p>
                            <p>
                                <input type="radio" name="position" id="si" value="si" @if($noticia->title_position == "si") checked @endif>
                                <label for="si">Superior-interno</label>
                            </p>
                            <p>
                                <input type="radio" name="position" id="ci" value="ci" @if($noticia->title_position == "ci") checked @endif>
                                <label for="ci">Central-interno</label>
                            </p>
                            <p>
                                <input type="radio" name="position" id="ii" value="ii" @if($noticia->title_position == "ii") checked @endif>
                                <label for="ii">Inferior-interno</label>
                            </p>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="modal-footer">
            <button onclick="guardarCambios(this)" class="btn waves-effect waves gradient-45deg-light-blue-cyan gradient-shadow"><i class="fa fa-save"></i> GUARDAR</button>
            <button class="modal-action modal-close btn waves-effect waves gradient-45deg-light-blue-cyan gradient-shadow"><i class="fa fa-close"></i> CERRAR</button>
        </div>
    </div>
    @elseif(Auth::user()->is(['admin','editor']))
        <div class="modal" id="modal-noticia">
        <div class="modal-content">
            <div id="iframe-display">
                <form id="noticia-form">
                    <input type="hidden" name="id" value="{{ $noticia->id }}">
                    <div class="input-field">
                        <input type="text" id="titulo" maxlength="60" name="titulo" data-length="60" value="{{ $noticia->titulo }}">
                        <label for="titulo">Titulo de Noticia</label>
                    </div>
                    <div class="input-field">
                        <textarea type="text" id="descripcion" name="descripcion" maxlength="120" data-length="120" class="materialize-textarea">{{ $noticia->descripcion }}</textarea>
                        <label for="descripcion">Descripcion de la Noticia</label>
                    </div>
                    <div class="row">
                        <div class="col s12 radios">
                            <h6>Posición de Titulo</h6>
                            <p>
                                <input type="radio" name="position" id="se" value="se" @if($noticia->title_position == "se") checked @endif>
                                <label for="se">Superior-externo</label>
                            </p>
                            <p>
                                <input type="radio" name="position" id="ie" value="ie" @if($noticia->title_position == "ie") checked @endif>
                                <label for="ie">Inferior-externo</label>
                            </p>
                            <p>
                                <input type="radio" name="position" id="si" value="si" @if($noticia->title_position == "si") checked @endif>
                                <label for="si">Superior-interno</label>
                            </p>
                            <p>
                                <input type="radio" name="position" id="ci" value="ci" @if($noticia->title_position == "ci") checked @endif>
                                <label for="ci">Central-interno</label>
                            </p>
                            <p>
                                <input type="radio" name="position" id="ii" value="ii" @if($noticia->title_position == "ii") checked @endif>
                                <label for="ii">Inferior-interno</label>
                            </p>
                        </div>
                    </div>
                </form>
            </div>  
        </div>
        <div class="modal-footer">
            <button onclick="guardarCambios(this)" class="btn waves-effect waves gradient-45deg-light-blue-cyan gradient-shadow"><i class="fa fa-save"></i> GUARDAR</button>
            <button class="modal-action modal-close btn waves-effect waves gradient-45deg-light-blue-cyan gradient-shadow"><i class="fa fa-close"></i> CERRAR</button>
        </div>
    </div>
    @endif
@endsection

@section('javascripts')
    @parent
    <script>

        $.ajaxSetup({
            headers: {"X-CSRF-Token": $("meta[name=_token]").attr("content")}
        });

        function displayModal(){
            $("#modal-noticia").modal('open');
        }

        function guardarCambios(element){
            try {
                var form = $("#noticia-form");
                form.find('input[type="text"]').each(function(){
                    if(this.value == "")
                        throw 'LLenar todos los campos existentes'
                })
                $(element).prop('disabled', true);
                
                Materialize.toast('Espere....', 6000);
                $.post({
                    url:'/backend/noticias/updateNoticia',
                    data: form.serialize(),
                    success: function(res) {
                        if(res.success)
                            return Materialize.toast(res.success, 4000, '', function(res){
                                location.reload()
                            });
                        else if(res.error)
                            throw res.error
                    }
                });
            } catch(e) {
                return Materialize.toast(e, 4000);
            }

        }

        function publicacion(active, id, element){
            $(element).prop('disabled',true);
            var valor = active;
            Materialize.toast('Espere....', 6000);
            $.ajax({
                url:'/backend/noticias/publicar',
                type:'post',
                data: {noticia: id, action: (valor) ? 'pub':'des'},
                success: res => {
                    if(res.success) {
                        Materialize.toast(res.success, 4000,'',function(){
                            location.reload()
                        });
                    } else if(res.error) {
                        Materialize.toast(res.error, 4000);
                    }
                }
            });
        }

        $(function(){
            $(".modal").modal();
        })
    </script>
@endsection