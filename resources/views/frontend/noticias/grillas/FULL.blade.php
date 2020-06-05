@if(isset($e[0]))
    @component('frontend.noticias.elementos.full', ['type' => $e[0]['type'], 'e' => $e[0]['content']])
    @endcomponent
@endif