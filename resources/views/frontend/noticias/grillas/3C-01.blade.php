<section id="contenedor-grilla">
    <div class="row">
        @foreach($e as $key => $el)
            @if(in_array($key, [0,1,2]))
            <div class="col s12 m6 l4 row-3C">
                @component('frontend.noticias.elementos.half', ['type' => $el['type'], 'e' => $el['content']])@endcomponent
            </div>
            @endif
        @endforeach
    </div>
    <div class="row">
        @if(isset($e[3]))
        <div class="col s12 m12 l12 @if($e[3]['type'] == 3) row-3C-publicidad @else row-3C @endif">
            @component('frontend.noticias.elementos.3c', ['type' => $e[3]['type'], 'e' => $e[3]['content']])@endcomponent
        </div>
        @endif
    </div>
</section>