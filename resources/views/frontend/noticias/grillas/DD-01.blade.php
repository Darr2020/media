<section id="contenedor-grilla">
    <div class="row type1">
    <div class="col s12 m12 l4">
        @foreach($e as $key => $el)
            @if(in_array($key, [0,1]))
            @component('frontend.noticias.elementos.half', ['type' => $el['type'], 'e' => $el['content']])@endcomponent
            @endif
        @endforeach
    </div>
    <div class="col s12 m12 l4">
        @foreach($e as $key => $el)
            @if(in_array($key, [2,3]))
                @component('frontend.noticias.elementos.half', ['type' => $el['type'], 'e' => $el['content']])@endcomponent
            @endif
        @endforeach
    </div>
    @if(isset($e[4]))
    <div class="col s12 m12 l4">
        @component('frontend.noticias.elementos.2v', ['type' => $e[4]['type'], 'e' => $e[4]['content']])@endcomponent
    </div>
    @endif
</div>
</section>