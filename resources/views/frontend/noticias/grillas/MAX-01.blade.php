<section id="contenedor-grilla" class="maxi">
    <div class="row">
        <div class="col s12 m12 l4">
            @foreach($elements as $key => $g)
                @if(in_array($key, [0,1]))
                <div class="item fullheight {{ \App\Tools\NoticiaTool::getPosition($g->title_position) }}" data-dir="{{ route('noticia_individual', ['id' => $g->id]) }}">
                    <img src="{{ asset('storage/portadas/'.$g->foto_portada) }}">
                    <div class="overlay"></div>
                    <span class="categoria" data-hex-bg="{{ $g->hexcode }}">{{ $g->categoria }}</span>
                    <div class="title" data-hex-cl="{{ $g->hexcode }}">{{ $g->titulo }}</div>
                    <div class="desc">{{ $g->descripcion }}</div>
                    <div class="date"><i class="material-icons">access_time</i> {{ \App\Tools\NoticiaTool::format($g->fecha_publish) }}</div>
                    <div class="views">{{ \App\Tools\NoticiaTool::fitViews($g->vistas) }}</div>
                </div>
                @endif
            @endforeach
        </div>
        <div class="col s12 m12 l4">
            @if($elements[2])
            <div class="item half {{ \App\Tools\NoticiaTool::getPosition($elements[2]->title_position) }}" data-dir="{{ route('noticia_individual', ['id' => $elements[2]->id]) }}">
                <img src="{{ asset('storage/portadas/'.$elements[2]->foto_portada) }}">
                <div class="overlay"></div>
                <span class="categoria" data-hex-bg="{{ $elements[2]->hexcode }}">{{ $elements[2]->categoria }}</span>
                <div class="title" data-hex-cl="{{ $elements[2]->hexcode }}">{{ $elements[2]->titulo }}</div>
                <div class="desc">{{ $elements[2]->descripcion }}</div>
                <div class="date"><i class="material-icons">access_time</i> {{ \App\Tools\NoticiaTool::format($elements[2]->fecha_publish) }}</div>
                <div class="views">{{ \App\Tools\NoticiaTool::fitViews($elements[2]->vistas) }}</div>
            </div>
            @endif
            @if($elements[3])
            <div class="item fullheight {{ \App\Tools\NoticiaTool::getPosition($elements[3]->title_position) }}" data-dir="{{ route('noticia_individual', ['id' => $elements[3]->id]) }}">
                <img src="{{ asset('storage/portadas/'.$elements[3]->foto_portada) }}">
                <div class="overlay"></div>
                <span class="categoria" data-hex-bg="{{ $elements[3]->hexcode }}">{{ $elements[3]->categoria }}</span>
                <div class="title" data-hex-cl="{{ $elements[3]->hexcode }}">{{ $elements[3]->titulo }}</div>
                <div class="desc">{{ $elements[3]->descripcion }}</div>
                <div class="date"><i class="material-icons">access_time</i> {{ \App\Tools\NoticiaTool::format($elements[3]->fecha_publish) }}</div>
                <div class="views">{{ \App\Tools\NoticiaTool::fitViews($elements[3]->vistas) }}</div>
            </div>
            @endif
            @if($elements[4])
            <div class="item half {{ \App\Tools\NoticiaTool::getPosition($elements[4]->title_position) }}" data-dir="{{ route('noticia_individual', ['id' => $elements[4]->id]) }}">
                <img src="{{ asset('storage/portadas/'.$elements[4]->foto_portada) }}">
                <div class="overlay"></div>
                <span class="categoria" data-hex-bg="{{ $elements[4]->hexcode }}">{{ $elements[4]->categoria }}</span>
                <div class="title" data-hex-cl="{{ $elements[4]->hexcode }}">{{ $elements[4]->titulo }}</div>
                <div class="desc">{{ $elements[4]->descripcion }}</div>
                <div class="date"><i class="material-icons">access_time</i> {{ \App\Tools\NoticiaTool::format($elements[4]->fecha_publish) }}</div>
                <div class="views">{{ \App\Tools\NoticiaTool::fitViews($elements[4]->vistas) }}</div>
            </div>
            @endif
        </div>
        <div class="col s12 m12 l4">
            @foreach($elements as $key => $g)
                @if(in_array($key, [5,6]))
                <div class="item fullheight {{ \App\Tools\NoticiaTool::getPosition($g->title_position) }}" data-dir="{{ route('noticia_individual', ['id' => $g->id]) }}">
                    <img src="{{ asset('storage/portadas/'.$g->foto_portada) }}">
                    <div class="overlay"></div>
                    <span class="categoria" data-hex-bg="{{ $g->hexcode }}">{{ $g->categoria }}</span>
                    <div class="title" data-hex-cl="{{ $g->hexcode }}">{{ $g->titulo }}</div>
                    <div class="desc">{{ $g->descripcion }}</div>
                    <div class="date"><i class="material-icons">access_time</i> {{ \App\Tools\NoticiaTool::format($g->fecha_publish) }}</div>
                    <div class="views">{{ \App\Tools\NoticiaTool::fitViews($g->vistas) }}</div>
                </div>
                @endif
            @endforeach
        </div>
    </div>

</section>
    