<section id="contenedor-grilla">
    <div class="row">
        @if(isset($e[0]))
        <div class="col s12 m12 l8">
            @component('frontend.noticias.elementos.4c', ['type' => $e[0]['type'], 'e' => $e[0]['content']])@endcomponent
        </div>
        @endif
        <div class="col s12 m12 l4">
        @foreach($e as $key => $el)
            @if(in_array($key, [1,2]))
                @component('frontend.noticias.elementos.half', ['type' => $el['type'], 'e' => $el['content']])@endcomponent
            @endif
        @endforeach
        </div>
    </div>
</section>