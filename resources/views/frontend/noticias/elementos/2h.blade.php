@if($type == 1)
<div class="item fullwidth inferior">
    <a href="{{ route('noticia_individual', ['id' => $e->id]) }}"><span class="title">{{ mb_strtolower($e->titulo) }}</span></a>
    <a href="{{ route('noticia_individual', ['id' => $e->id]) }}"><img src="{{ asset('storage/portadas/'.$e->foto_portada) }}"></a>
    <p class="desc">{{ $e->descripcion }}</p>
    <div class="bottom">
        <div class="views"><i class="fa fa-eye"></i> {{ \App\Tools\NoticiaTool::fitViews($e->vistas) }} vistas</div>
        <span class="megusta"><span class="cant">{{ $e->megusta }}</span><img src="{{ asset('images/noticias/like.png') }}"></span>
        <span class="nomegusta"><span class="cant">{{ $e->nomegusta }}</span><img src="{{ asset('images/noticias/dislike.png') }}"></span>
        <span class="categoria" data-hex-bg="{{ $e->hexcode }}" data-hex-cl="{{ $e->hexcode }}">{{ $e->categoria }}</span>
    </div>
</div>
@elseif($type == 2)
<div class="item fullwidth iframe">
    {!! $e->contenido !!}
</div>
@elseif($type == 3)
<div class="item fullwidth publicidad">
    <div class="label">ESPACIO PUBLICITARIO</div>
    <a href="{{ $e->link }}"><img src="{{ asset('images/publicidad/'.$e->imagen) }}" alt="{{ $e->nombre }}"></a>
</div>
@endif