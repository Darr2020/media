<section id="contenedor-grilla">
    <div class="row">
        <div class="col s12 m12 l4 row-spec">
            @if(isset($e[0]))
                @component('frontend.noticias.elementos.half', ['type' => $e[0]['type'], 'e' => $e[0]['content']])@endcomponent
            @endif
        </div>
        <div class="col s12 m12 l8 row-spec">
            @if(isset($e[1]))
                @component('frontend.noticias.elementos.2h', ['type' => $e[1]['type'], 'e' => $e[1]['content']])@endcomponent
            @endif
        </div>
    </div>
    <div class="row">
        <div class="col s12 m12 l8 row-spec">
            @if(isset($e[2]))
                @component('frontend.noticias.elementos.2h', ['type' => $e[2]['type'], 'e' => $e[2]['content']])@endcomponent
            @endif
        </div>
        <div class="col s12 m12 l4 row-spec">
            @if(isset($e[3]))
                @component('frontend.noticias.elementos.half', ['type' => $e[3]['type'], 'e' => $e[3]['content']])@endcomponent
            @endif
        </div>
    </div>
</section>