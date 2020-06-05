<section id="contenedor-grilla">
    <div class="row">
        @if(isset($e[0]))
        <div class="col s12 m12 l12 @if($e[0]['type'] == 3) row-3C-publicidad @else row-3C @endif">
            @component('frontend.noticias.elementos.3c', ['type' => $e[0]['type'], 'e' => $e[0]['content']])@endcomponent
        </div>
        @endif
    </div>
    <div class="row">
        @if(isset($e[1]))
        <div class="col s12 m6 l4 row-3C">
            @component('frontend.noticias.elementos.half', ['type' => $e[1]['type'], 'e' => $e[1]['content']])@endcomponent
        </div>
        @endif
        @if(isset($e[2]))
        <div class="col s12 m6 l8 row-3C">
            @component('frontend.noticias.elementos.2h', ['type' => $e[2]['type'], 'e' => $e[2]['content']])@endcomponent
        </div>
        @endif
    </div>
</section>