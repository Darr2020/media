@extends("backend.layout.layout")
@section("title", "MediaMétrica | Encuesta - Parte I")
@section('stylesheets')
@parent
<!-- Custome CSS-->
<link rel="stylesheet" href="{{ asset('vendors/dropify/css/dropify.min.css') }}">
@endsection
@section("body")

<!--breadcrumbs start-->
<div id="breadcrumbs-wrapper">
    <div class="container">
        <div class="row">
            <div class="col s12 m12 l12">
                <h5 class="breadcrumbs-title">Encuestas</h5>
                <ol class="breadcrumbs">
                    <li><a href="#!">Encuesta Telefónica</a>
                    </li>
                    <li class="active">Parte I</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<!--breadcrumbs end-->


<div class="container">
    <div class="section">
        <div class="row">
            <h4 class="header2">Encuesta telefónica</h4>
            <div class="divider"></div>

            <div id="test1" class="col s12">
                <!--Test 1-->
                <div class="card-panel">
                    <div class="row">
                        <form class="col s12" id="form_enc1" enctype="multipart/form-data">
                            <h4 class="header2">Paso 1</h4>
                            <div class="row">
                                <div class="input-field col s6">
                                    <label>Desde</label>
                                    <input id="fecha_desde" type="text" class="datepicker" placeholder="Elige la fecha desde">
                                </div>

                                <div class=" input-field col s6">
                                    <input id="fecha_hasta" type="text" class="datepicker" placeholder="Elige la fecha hasta">
                                </div>              

                                <div class="input-field col s12">
                                    <input id="muestra" type="number" class="validate" min="1" onkeypress="return solonumeros(event)">
                                    <label for="muestra">Muestra</label>
                                </div>

                                <div class="input-field col s12 m6 l6">
                                    <input  type="number" id="muestra_feme" class="validate" min="1" onkeypress="return solonumeros(event)"/>
                                    <label for="number">Cantidad del sexo femenino</label>
                                </div>
                                <div class="input-field col s12 m6 l6">
                                    <input type="number" id="muestra_masc" class="validate" min="1" onkeypress="return solonumeros(event)"/>
                                    <label for="muestra_masc">Cantidad del sexo masculino</label>
                                </div>

                                <div class="input-field col s12 m12 l12">
                                    <textarea id="descripcion" class="materialize-textarea validate" length="220"></textarea>
                                    <label for="descripcion">Descripcion</label>
                                </div>  
                                <div class="input-field col s12 m12 l12">
                                    <p>Subir archivo</p>
                                    <input type="file" id="archivo" class="dropify btn-file" data-default-file="" accept="application/pdf" />
                                </div>
                                <div class="input-field col s12">
                                    <div class="col s12">
                                        <button class="btn green waves-effect waves-light enc1" type="submit" disabled>
                                            Guardar Encuesta
                                            <i class="material-icons right">save</i>
                                        </button>
                                    </div>
                                </div>
                            </div> 
                        </form>
                    </div>
                </div>                            
            </div>
        </div>       
    </div>
</div>



@endsection
@section('javascripts')
@parent
<!--js propio-->
<script src="{{ asset('js/calendar.js') }}"></script>
<script src="{{ asset('vendors/dropify/js/dropify.min.js') }}"></script>
<script src="{{ asset('js/scripts/form-file-uploads.js') }}"></script>
<script src="{{ asset('js/encuesta_tlf_paso1.js') }}" charset="utf-8"></script>
@endsection
