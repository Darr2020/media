<section id="contenedor-grilla">
    <div class="row">
        @if(isset($e[0]))
        <div class="col s12 m12 l4">
            @component('frontend.noticias.elementos.2v', ['type' => $e[0]['type'], 'e' => $e[0]['content']])
            @endcomponent
        </div>
        @endif
        @if(isset($e[1]))
        <div class="col s12 m12 l8">
            @component('frontend.noticias.elementos.4c', ['type' => $e[1]['type'], 'e' => $e[1]['content']])
            @endcomponent
        </div>
        @endif
    </div>
</section>