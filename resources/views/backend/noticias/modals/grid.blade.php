<div class="card">
    <div class="card-body">
        <h3>{{ $current->label }}</h3>
        <img src="{{ asset('images/noticias/grilla_layouts/'.$current->image) }}" width="200px" height="100px" alt="{{ $current->label }}">
    </div>
</div>
<div class="card">
    <div class="card-body">
        @foreach($layouts as $key => $l)
            @if($l->name == $current->name)
                @continue
            @endif
            <img src="{{ asset('images/noticias/grilla_layouts/'.$l->image) }}" data-key="{{ $key }}" data-position="{{ $position }}" onclick="select(this)" class="picture" alt="{{ $l->label }}">
        @endforeach
    </div>
</div>