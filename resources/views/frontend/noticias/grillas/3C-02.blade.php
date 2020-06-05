<section id="contenedor-grilla">
    <div class="row">
        @if(isset($e[0]))
        <div class="col s12 m12 l12 @if($e[0]['type'] == 3) row-3C-publicidad @else row-3C @endif">
            @component('frontend.noticias.elementos.3c', ['type' => $e[0]['type'], 'e' => $e[0]['content']])@endcomponent
        </div>
        @endif
    </div>
    <div class="row">
        @foreach($e as $key => $el)
            @if(in_array($key, [1,2,3]))
            <div class="col s12 m6 l4 row-3C">
                @component('frontend.noticias.elementos.half', ['type' => $e['type'], 'e' => $e['content']])@endcomponent
            </div>
            @endif
        @endforeach
    </div>
</section>