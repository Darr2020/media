<section id="contenedor-grilla">
    <div class="row">
        <div class="col s12 m12 l4">
            @if(isset($e[0]))
            @component('frontend.noticias.elementos.2v', ['type' => $e[0]['type'], 'e' => $e[0]['content']])@endcomponent
            @endif
        </div>
        <div class="col s12 m12 l8">
            <div class="row">
                @if(isset($e[1]))
                <div class="col s12 row-spec">
                    @component('frontend.noticias.elementos.2h', ['type' => $e[1]['type'], 'e' => $e[1]['content']])@endcomponent
                </div>
                @endif
            </div>
            <div class="row">
                @foreach($e as $key => $el)
                    @if(in_array($key, [2,3]))
                    <div class="col s6">
                        @component('frontend.noticias.elementos.half', ['type' => $el['type'], 'e' => $el['content']])@endcomponent
                    </div>
                    @endif
                @endforeach
            </div>
        </div>
    </div>
</section>