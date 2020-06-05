@forelse($print as $keyBloque => $p)
    @include('frontend.noticias.grillas.'.$p->type, ['e' => $p->elements])
@empty
    <span class="empty"></span>
@endforelse