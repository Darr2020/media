@if($type == 1)
    @if(\App\Tools\NoticiaTool::getPosition($e->title_position) == "superior")
    <div class="item long superior">
        <div class="row">
            <div class="col s12 m4 l4 image">
                <a href="{{ route('noticia_individual', ['id' => $e->id]) }}"><img src="{{ asset('storage/portadas/'.$e->foto_portada) }}"></a>
            </div>
            <div class="col s12 m4 l6 data">
                <a href="{{ route('noticia_individual', ['id' => $e->id]) }}"><span class="title">{{ mb_strtolower($e->titulo) }}</span></a>
                <p class="desc">{{ $e->descripcion }}</p>
            </div>
            <div class="col s12 m4 l2 bottom">
                <div class="views"><i class="fa fa-eye"></i> {{ \App\Tools\NoticiaTool::fitViews($e->vistas) }} vistas</div>
                <span class="megusta"><span class="cant">{{ $e->megusta }}</span><img src="{{ asset('images/noticias/like.png') }}"></span>
                <span class="nomegusta"><span class="cant">{{ $e->nomegusta }}</span><img src="{{ asset('images/noticias/dislike.png') }}"></span>
                <span class="categoria" data-hex-bg="{{ $e->hexcode }}" data-hex-cl="{{ $e->hexcode }}">{{ $e->categoria }}</span>
            </div>
        </div>
    </div>
    @elseif(\App\Tools\NoticiaTool::getPosition($e->title_position) == "inferior" || \App\Tools\NoticiaTool::getPosition($e->title_position) == "central")
    <div class="item long inferior">
        <div class="row">
            <div class="col s12 m4 l6">
                <a href="{{ route('noticia_individual', ['id' => $e->id]) }}"><span class="title">{{ mb_strtolower($e->titulo) }}</span></a>
                <p class="desc">{{ $e->descripcion }}</p>
            </div>
            <div class="col s12 m4 l4">
                <a href="{{ route('noticia_individual', ['id' => $e->id]) }}"><img src="{{ asset('storage/portadas/'.$e->foto_portada) }}"></a>
            </div>
            <div class="col s12 m4 l2 bottom">
                <div class="views"><i class="fa fa-eye"></i> {{ \App\Tools\NoticiaTool::fitViews($e->vistas) }} vistas</div>
                <span class="megusta"><span class="cant">{{ $e->megusta }}</span><img src="{{ asset('images/noticias/like.png') }}"></span>
                <span class="nomegusta"><span class="cant">{{ $e->nomegusta }}</span><img src="{{ asset('images/noticias/dislike.png') }}"></span>
                <span class="categoria" data-hex-bg="{{ $e->hexcode }}" data-hex-cl="{{ $e->hexcode }}">{{ $e->categoria }}</span>
            </div>
        </div>
    </div>
    @endif
@elseif($type == 2)
<h2>Error</h2>
@elseif($type == 3)
<div class="item long publicidad">
    <div class="label">ESPACIO PUBLICITARIO</div>
    <a href="{{ $e->link }}"><img src="{{ asset('images/publicidad/'.$e->imagen) }}" alt="{{ $e->nombre }}"></a>
</div>
@endif