@extends("layout.base-test")

@section("title", "PRUEBA DE GRILLA")

@section('stylesheets')
    @parent
    <link rel="stylesheet" href="{{ asset('css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/noticias/main.noticia.css') }}">
@endsection

@section('floating')
@endsection

@section('body')
<div class="container">
    <div id="infinite"> 
        @foreach($print as $keyBloque => $p)
            @include('frontend.noticias.grillas.'.$p->type, ['e' => $p->elements])
        @endforeach
    </div>
</div>
@endsection

@section('javascripts')
    @parent
    <script src="{{ asset('js/infinite-scroll.min.js') }}"></script>
    <script src="{{ asset('js/noticias/test.js') }}"></script>
@endsection