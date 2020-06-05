<section id="contenedor-grilla">
    <div class="row type1">
    @if(isset($e[0]))
    <div class="col s12 m12 l4">
        @component('frontend.noticias.elementos.2v', ['type' => $e[0]['type'], 'e' => $e[0]['content']])@endcomponent
    </div>
    @endif
    <div class="col s12 m12 l4">
        @foreach($e as $key => $el)
            @if(in_array($key, [1,2]))
            @component('frontend.noticias.elementos.half', ['type' => $el['type'], 'e' => $el['content']])@endcomponent
            @endif
        @endforeach
    </div>
    <div class="col s12 m12 l4">
        @foreach($e as $key => $el)
            @if(in_array($key, [3,4]))
                @component('frontend.noticias.elementos.half', ['type' => $el['type'], 'e' => $el['content']])@endcomponent
            @endif
        @endforeach
    </div>
</div>
</section>