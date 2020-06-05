<section id="contenedor-grilla">
    <div class="row">
        <div class="col s12 m12 l8">
            <div class="row">
                @if(isset($e[0]))
                <div class="col s12 row-spec">
                    @component('frontend.noticias.elementos.2h', ['type' => $e[0]['type'], 'e' => $e[0]['content']])@endcomponent
                </div>
                @endif
            </div>
            <div class="row">
                @if(isset($e[1]))
                <div class="col s12 row-spec">
                    @component('frontend.noticias.elementos.2h', ['type' => $e[1]['type'], 'e' => $e[1]['content']])@endcomponent
                </div>
                @endif
            </div>
        </div>
        <div class="col s12 m12 l4">
            @if(isset($e[2]))
                @component('frontend.noticias.elementos.2v', ['type' => $e[2]['type'], 'e' => $e[2]['content']])@endcomponent
            @endif
        </div>
    </div>
</section>