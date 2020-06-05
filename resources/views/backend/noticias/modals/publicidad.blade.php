<form id="modify-form">
    <h3>Modificar Banner Publicitario</h3>
    <input type="hidden" name="id" value="{{ $publicidad->id }}" required>
    <div class="row">
        <div class="col s6">
            <div class="input-field">
                <input type="text" data-length="50" maxlength="50" name="nombre" id="new-nombre" value="{{ $publicidad->nombre }}">
                <label for="new-nombre">Nombre del Banner</label>
            </div>
        </div>
        <div class="col s6">
            <div class="input-field">
                <input type="number" data-length="5" maxlength="5" id="new-peso" name="peso" value="{{ $publicidad->peso }}">
                <label for="new-peso">Peso</label> 
            </div>
        </div>
        
    </div>
    <div class="row">
        <div class="col s12">
            <div class="input-field">
                <input type="text" data-length="110" maxlength="110" id="new-link" name="link" value="{!! $publicidad->link !!}">
                <label for="new-link">Link de Vinculo</label> 
            </div>
            <img id="modal-pub-image" src="{{ asset('images/publicidad/'.$publicidad->imagen) }}" alt="{{ $publicidad->nombre }}">
        </div>
    </div>
</form>