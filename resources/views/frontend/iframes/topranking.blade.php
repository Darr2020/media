@extends('layout.iframe-layout')

@section('stylesheets')
    @parent
    <style>

        body {
            width:350px;
        }

        ul.collapsible{
            border-radius:10px;
            overflow:hidden;
            padding:0;
            margin:0;
        }
        div.collapsible-header{
            background: linear-gradient(to right, #652D90,#EC3F39);
            background: -webkit-linear-gradient(to right, #652D90,#EC3F39);
            background: -o-linear-gradient(to right, #652D90,#EC3F39);
            background: -moz-linear-gradient(to right, #652D90,#EC3F39);
            color:#FFF;
            font-size:1.5em;
            text-shadow:rgba(250,250,250,.5) 0 0 10px;
            margin:0;
        }

        div.collapsible-body {
            padding:0;
        }

        .candidatos{
            margin:5px 5px;
            height:50px;
            position:relative;
        }

        div.collapsible-body img{
            position:absolute;
            top:0;
            left:0;
            width:50px;
            height:50px;
        }
        .info {
            text-transform:uppercase;
            font-size:.8em;
            position:absolute;
            top:-5px;
            left:20%;
        }
        button.spec{
            position:absolute;
            right:0;
            top:0;
            padding:5px 10px;
            text-transform:uppercase;
            background: linear-gradient(to right, #652D90,#EC3F39);
            background: -webkit-linear-gradient(to right, #652D90,#EC3F39);
            background: -o-linear-gradient(to right, #652D90,#EC3F39);
            background: -moz-linear-gradient(to right, #652D90,#EC3F39);
            font-weight:bold;
            font-size:.5em;
            color:#FFF;
            border-radius:10px;
            border:none;
            transition:.5s;
        }
        button.spec:hover{
            background:#EC3F39;
        }
    </style>
@endsection

@section('javascripts')
    @parent
    <script>
        function redirect(id) {
            $('input[name="id"]').val(id);
            $('#redform').submit();
        }
    </script>
@endsection

@section('body')
<form id="redform" method="POST" target="_blank" action="/categoria_detalle">
    {{ csrf_field() }}
    <input type="hidden" value="0" name="id">
</form>
<ul class="collapsible" data-collapsible="accordion">
    @foreach($data as $categoria => $candidatos)
        <li>
            <div class="collapsible-header @if($categoria == 'MUSICA') active @endif">
                <b>{{ $categoria }}</b>
            </div>
            <div class="collapsible-body">
                @foreach($candidatos as $key => $single)
                    @if(!in_array($key, [0,1,2]))
                        @continue
                    @endif
                    <div class="candidatos" data-position="{{ $key }}">
                        <img src="{{ asset("candidatos/images/".strtolower($single->img))}}">    
                        <p class="info">
                            <b>Nombre:</b> {{ $single->nombrecandidato }}<br>
                            <b>Categoria:</b> {{ $categoria }}<br>
                            <b>{{ $single->votos }} Votos</b>
                        </p>
                        <button class="spec waves waves-light" onclick="redirect({{ $single->categoria_id }})">ver mas</button>
                    </div>
                @endforeach
            </div>
        </li>
    @endforeach
</ul>
@endsection