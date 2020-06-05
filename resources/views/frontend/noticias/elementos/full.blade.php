@if($type == 1)
    @if(in_array($e->title_position, ['ie']))
    <section id="noticia-principal" type="noticia" order="inferior">
        <a href="/ver/noticia/{{ $e->id }}"><img class="main-image" src="{{ asset('storage/portadas/'.$e->foto_portada) }}"></a>
        <a href="{{ route('noticia_individual', ['id' => $e->id]) }}" class="title">{{ mb_strtolower($e->titulo) }}</a>
        <div class="bottom"> 
            <span class="views"><i class="fa fa-eye"></i> {{ \App\Tools\NoticiaTool::fitViews($e->vistas) }} vistas</span>
            <span class="megusta"><span class="cant">{{ $e->megusta }}</span><img src="{{ asset('images/noticias/like.png') }}"></span>
            <span class="nomegusta"><span class="cant">{{ $e->nomegusta }}</span><img src="{{ asset('images/noticias/dislike.png') }}"></span>
            <span class="categoria" data-hex-cl="{{ $e->hexcode }}" data-hex-bg="{{ $e->hexcode }}">{{ $e->categoria }}</span>
        </div>
    </section>  
    @elseif(in_array($e->title_position, ['se']))
    <section id="noticia-principal" type="noticia" order="superior">
            <a href="{{ route('noticia_individual', ['id' => $e->id]) }}" class="title">{{ mb_strtolower($e->titulo) }}</a>
        <a href="/ver/noticia/{{ $e->id }}"><img class="main-image" src="{{ asset('storage/portadas/'.$e->foto_portada) }}"></a>
        <div class="bottom"> 
            <span class="views"><i class="fa fa-eye"></i> {{ \App\Tools\NoticiaTool::fitViews($e->vistas) }} vistas</span>
            <span class="megusta"><span class="cant">{{ $e->megusta }}</span><img src="{{ asset('images/noticias/like.png') }}"></span>
            <span class="nomegusta"><span class="cant">{{ $e->nomegusta }}</span><img src="{{ asset('images/noticias/dislike.png') }}"></span>
            <span class="categoria" data-hex-cl="{{ $e->hexcode }}" data-hex-bg="{{ $e->hexcode }}">{{ $e->categoria }}</span>
        </div>
    </section>
    @elseif(in_array($e->title_position, ['ci','ii','si']))
    <section id="noticia-principal" type="noticia" order="central" situ="{{ $e->title_position }}">
        <a href="{{ route('noticia_individual', ['id' => $e->id]) }}" class="title">{{ mb_strtolower($e->titulo) }}</a>
        <a href="/ver/noticia/{{ $e->id }}"><img class="main-image" src="{{ asset('storage/portadas/'.$e->foto_portada) }}"></a>
        <div class="bottom"> 
            <span class="views"><i class="fa fa-eye"></i> {{ \App\Tools\NoticiaTool::fitViews($e->vistas) }} vistas</span>
            <span class="megusta"><span class="cant">{{ $e->megusta }}</span><img src="{{ asset('images/noticias/like.png') }}"></span>
            <span class="nomegusta"><span class="cant">{{ $e->nomegusta }}</span><img src="{{ asset('images/noticias/dislike.png') }}"></span>
            <span class="categoria" data-hex-cl="{{ $e->hexcode }}" data-hex-bg="{{ $e->hexcode }}">{{ $e->categoria }}</span>
        </div>
    </section>  
    @endif
@elseif($type == 2)
    <section id="noticia-principal" type="iframe">
        {!! $e->contenido !!}
    </section>  
@elseif($type == 3)
    <section id="noticia-principal" type="publicidad">
        <div class="label">ESPACIO PUBLICITARIO</div>
        <a href="{{ $e->link }}"><img src="{{ asset('images/publicidad/'.$e->imagen) }}" alt="{{ $e->nombre }}"></a>
    </section>  
@endif