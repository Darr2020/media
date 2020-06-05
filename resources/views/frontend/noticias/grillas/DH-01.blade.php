<section id="contenedor-grilla">
    <div class="row">
        @if(isset($e[0]))
            <div class="col s12 m6 l8 row-spec">
            @component('frontend.noticias.elementos.2h', ['type' => $e[0]['type'], 'e' => $e[0]['content']])@endcomponent
            </div>
        @endif
        @if(isset($e[1]))
            <div class="col s12 m6 l4 row-spec">
            @component('frontend.noticias.elementos.half', ['type' => $e[1]['type'], 'e' => $e[1]['content']])@endcomponent
            </div>
        @endif
    </div>
    <div class="row">
        @foreach($e as $key => $el)
            @if(in_array($key, [2,3,4]))
            <div class="col s12 m6 l4 row-spec">
                @component('frontend.noticias.elementos.half', ['type' => $el['type'], 'e' => $el['content']])@endcomponent
            </div>
            @endif
        @endforeach
    </div>
</section>