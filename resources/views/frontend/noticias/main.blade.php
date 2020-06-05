@extends("layout.base")

@section("title", "MediaMétrica | Noticias")

@section('stylesheets')
    @parent
    <link rel="stylesheet" href="{{ asset('css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/noticias/main.noticia.css') }}">
@endsection


@section('floating')
@parent
@endsection

@section('navbar-top')
@endsection

@section('body')
<div class="container noticias">
    <section id="categories">
        @foreach($categorias as $c)
            @if($loop->last)
            <span><a href="{{ route('categoria_individual', ['id' => $c->id ]) }}" style="color:#{{ $c->hexcode }}">{{ $c->nombre }}</a></span>
            @else
            <span><a href="{{ route('categoria_individual', ['id' => $c->id ]) }}" style="color:#{{ $c->hexcode }}">{{ $c->nombre }}</a><b>|</b></span>
            @endif
        @endforeach
    </section>
    <section id="infinite"> 
        @foreach($print as $keyBloque => $p)
            @include('frontend.noticias.grillas.'.$p->type, ['e' => $p->elements])
        @endforeach
    </section>
    <section class="most">
        <div class="row">
            <div class="col s12 m6 l8">
                <h4 class="title">Lo + visto</h4>
                @foreach($most as $key => $e)
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
            <div class="col s12 m6 l4">
                <a href="{{ $banner->link }}"><img style="border-radius:10px;height:600px;width:100%" src="{{ asset('images/publicidad/'.$banner->imagen) }}" alt="{{ $banner->nombre }}"></a>
            </div>
        </div>
    </section>
</div>
@endsection

@section('javascripts')
    @parent
    <script src="{{ asset('js/infinite-scroll.min.js') }}"></script>
    <script src="{{ asset('js/noticias/main.js') }}"></script>
@endsection