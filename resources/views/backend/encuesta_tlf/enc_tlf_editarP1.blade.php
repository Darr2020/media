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
                    <li><a href="{{route('enc_tlf_index')}}">Encuesta Telefónica</a>
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
                        <form class="col s12" id="form_enc1_mod" enctype="multipart/form-data">
                            <h4 class="header2">Paso 1</h4>
                            <div class="row">
                                <div class="input-field col s6">
                                    <label>Desde</label>
                                    <input id="fecha_desde_mod" type="text" class="datepicker" placeholder="Elige la fecha desde" value="{{ \App\Http\Controllers\Comun\AppComun::dar_formato_fecha_slash($enc_data->fecha_desde) }}">
                                </div>

                                <div class=" input-field col s6">
                                    <input id="fecha_hasta_mod" type="text" class="datepicker" placeholder="Elige la fecha hasta" value="{{
                                    \App\Http\Controllers\Comun\AppComun::dar_formato_fecha_slash($enc_data->fecha_hasta) }}">
                                </div>              

                                <div class="input-field col s12">
                                    <input id="muestra_mod" type="number" class="validate" value="{{ $enc_data->muestra }}" min="1" onkeypress="return solonumeros(event)">
                                    <label for="muestra_mod">Muestra</label>
                                </div>

                                <div class="input-field col s12 m6 l6">
                                    <input  type="number" id="muestra_feme_mod" class="validate" value="{{ $enc_data->muestra_femenina }}" min="1" onkeypress="return solonumeros(event)"/>
                                    <label for="muestra_feme_mod">Cantidad del sexo femenino</label>
                                </div>
                                <div class="input-field col s12 m6 l6">
                                    <input type="number" id="muestra_masc_mod" class="validate" value="{{ $enc_data->muestra_masculina }}" min="1" onkeypress="return solonumeros(event)"/>
                                    <label for="muestra_masc_mod">Cantidad del sexo masculino</label>
                                </div>

                                <div class="input-field col s12 m12 l12">
                                    <textarea id="descripcion_mod" class="materialize-textarea validate" length="220">{{ $enc_data->descripcion }}</textarea>
                                    <label for="descripcion_mod">Descripcion</label>
                                </div>  

                                {{-- Archivo subido --}}
                                @if($enc_data->archivo !=null)
                                <div class="input-field col s12 m12 l12">
                                    <p>Archivo subido</p> 

                                    <a class="waves-effect waves-light btn gradient-45deg-light-blue-cyan z-depth-4 mr-1" target='_blank' href="/encuesta/enc_tlf/{{ $enc_data->archivo}}">
                                        Ver PDF 
                                        <i class="material-icons right">picture_as_pdf</i>
                                    </a>                                    
                                </div>
                                <div class="input-field col s12 m12 l12">
                                    <p>Subir archivo</p>
                                    <input type="file" id="archivo_mod" class="dropify btn-file" data-default-file="/encuesta/enc_tlf/{{ $enc_data->archivo }}" accept="application/pdf" />

                                    <input id="pqr" name="pqr" type="hidden" value="1">
                                </div>
                                @else
                                <div class="input-field col s12 m12 l12">
                                    <p>Subir archivo</p>
                                    <input type="file" id="archivo_mod" class="dropify btn-file" accept="application/pdf" required />

                                    <input id="pqr" name="pqr" type="hidden" value="0">
                                </div>
                                @endif

                                <div class="input-field col s12">
                                    <input id="enc_id" name="enc_id" type="hidden" value="{{ $enc_data->id }}">
                                    <div class="col s12 m6">
                                        <button class="btn green waves-effect waves-light mod_enc1" type="submit">
                                            Guardar Encuesta
                                            <i class="material-icons right">save</i>
                                        </button>
                                    </div>
                                    <div class="col s12 m6" style="text-align: right;">
                                        <a href="{{route('enc_tlf_index')}}" class="btn deep-orange accent-3 waves-effect waves-light tooltipped" data-position="top" data-delay="50" data-tooltip="Ir al index de Encuesta Telefónica">
                                            Volver
                                            <i class="material-icons right">reply</i>
                                        </a>
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
<script src="{{ asset('js/encuesta_tlf_EditarPaso1.js') }}" charset="utf-8"></script>
@endsection
