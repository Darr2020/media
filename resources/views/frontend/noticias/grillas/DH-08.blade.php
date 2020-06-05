<section id="contenedor-grilla">
    <div class="row">
        <div class="col s12 m12 l4">
            @if(isset($e[0]))
            @component('frontend.noticias.elementos.2v', ['type' => $e[0]['type'], 'e' => $e[0]['content']])@endcomponent
            @endif
        </div>
        <div class="col s12 m12 l8">
            <div class="row">
                @foreach($e as $key => $el)
                    @if(in_array($key, [1,2]))
                    <div class="col s6 row-spec">
                        @component('frontend.noticias.elementos.half', ['type' => $el['type'], 'e' => $el['content']])@endcomponent
                    </div>
                    @endif
                @endforeach
            </div>
            <div class="row">
                @if(isset($e[3]))
                <div class="col s12 row-spec">
                    @component('frontend.noticias.elementos.2h', ['type' => $e[3]['type'], 'e' => $e[3]['content']])@endcomponent
                </div>
                @endif
            </div>
        </div>
    </div>
</section>