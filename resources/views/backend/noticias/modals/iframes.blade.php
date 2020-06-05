<div class="iframe-view">
    {!! $iframes->contenido !!}
</div>
<form id="iframe-form">
    <input type="hidden" name="id" value="{{ $iframes->id }}" required>
    <div class="input-field">
        <textarea class="materialize-textarea" data-length="500" maxlength="500" name="code" id="iframe-modify" required>
        {{ $iframes->contenido }}
        </textarea>
        <label for="iframe-modify">Modificar Iframe</label>
    </div>
</form>