<section id="contenedor-grilla">
    <div class="row">
        @foreach($e as $key => $el)
            @if(in_array($key, [0,1,2]))
            <div class="col s12 m6 l4 row-spec">
                @component('frontend.noticias.elementos.half', ['type' => $el['type'], 'e' => $el['content']])@endcomponent
            </div>
            @endif
        @endforeach
    </div>
    <div class="row">
        @if(isset($e[3]))
            <div class="col s12 m6 l4 row-spec">
            @component('frontend.noticias.elementos.half', ['type' => $e[3]['type'], 'e' => $e[3]['content']])@endcomponent
            </div>
        @endif
        @if(isset($e[4]))
            <div class="col s12 m6 l8 row-spec">
            @component('frontend.noticias.elementos.2h', ['type' => $e[4]['type'], 'e' => $e[4]['content']])@endcomponent
            </div>
        @endif
    </div>
</section>