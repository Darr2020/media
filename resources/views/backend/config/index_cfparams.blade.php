@extends("backend.layout.layout")
@section("title", "MediaMétrica |Configurar Parametros")
@section('stylesheets')
@parent
@endsection
@section("body")

<!--breadcrumbs start-->
<div id="breadcrumbs-wrapper">
    <div class="container">
        <div class="row">
            <div class="col s12 m12 l12">
                <h5 class="breadcrumbs-title">MediaMétrica</h5>
                <ol class="breadcrumbs">
                    <li><a href="#">Administración</a></li>
                    <li class="active">Configurar parametros</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<!--breadcrumbs end-->


<div class="container">
    <div class="section">
        <div class="row">
            <div class="card-panel">
                    <div class="row">
                        {{-- Crear parametros --}}
                        <div class="col s12">
                            <h4 class="header">Crear Parametro</h4>
                            <div class="col s12 m6">
                                <a onclick="new_cfparam()" class="btn btn-large waves-effect waves-light cyan">
                                    Crear Parametro <i class="material-icons right">add_box</i></a>
                            </div>
                        </div>
                        <div class="col s12"><br>
                            <div class="col s12 divider"></div>
                        </div>

                        <div class="col s12">
                        {{-- Listados --}}
                        <div class="col s12">
                            <div class="row">
                                <!--DataTables-->
                                <div id="table-datatables"> 
                                    <div class="row">
                                        <div class="col s12">
                                            <h4 class="header">Listado de parametros</h4>
                                        </div>
                                        <div class="col s12"><br>
                                            <table id="dataTable" class="responsive-table display" cellspacing="0" width="100%">
                                                <thead>
                                                    <tr>
                                                        <th style="text-align: center" width="5%">#</th>
                                                        <th style="text-align: center" width="50%">Nombre</th>
                                                        <th style="text-align: center" width="10%">Valor</th>
                                                        <th style="text-align: center" width="15%">Acción</th>
                                                    </tr>
                                                </thead>
                                                <tbody>  
                                                    @php
                                                        $b=0;
                                                    @endphp
                                                    @if($cfparams != null) 
                                                        @foreach($cfparams as $cfp)
                                                            @php
                                                                $b++;
                                                            @endphp
                                                        <tr>
                                                            <td style="text-align: center">{{ $b }}</td>
                                                            <td style="text-align: center">{{ $cfp->nombre }}</td>
                                                            <td style="text-align: center">{{ $cfp->valor }}</td>
                                                            <td style="text-align: center">
                                                               <a onclick="edit_cfparam({{ $cfp->id }})" class="btn orange waves-effect waves-light" style="font-size: 12.6px;">
                                                                   Editar <i class="material-icons right">edit</i>
                                                               </a>   
                                                            </td>
                                                        @endforeach                                            
                                                        </tr>

                                                    @else
                                                    <tr>
                                                        <td style="text-align: center" colspan="3">{{ 'Sin información para mostrar' }}</td>
                                                    </tr>

                                                    @endif
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                
                              

                            </div> 
                        </div>
                    </div>
                    </div>{{-- row --}}

            </div>{{-- card panel --}}
        </div>
    </div>
</div>

{{-- MODAL --}}
        <!-- START MODALGeneric -->
        <div id="ModalG" class="modal modal-fixed-footer">
            <div class="modal-content">
                <div class="modal-body" id="cuerpo">

                </div>
            </div>
            <!-- END MODAL CONTANT --> 

            <div class="modal-footer">
                <a href="#!" class="modal-action modal-close waves-effect waves-red btn-flat ">Cerrar</a>
            </div>
        </div>
        <!-- END MODALG -->  

@endsection
@section('javascripts')
@parent
<script src="{{ asset('js/config_parameters.js') }}" charset="utf-8"></script>
@endsection
