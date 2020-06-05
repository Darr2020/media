@extends("backend.layout.layout")
@section("title", "MediaMétrica | Administración de Usuarios")
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
                    <li class="active">Usuarios Backend</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<!--breadcrumbs end-->
<!--start container-->
<div class="container">
    <div class="row">
        <div class=""> 
            {{-- Crear Usuario Backend --}}
            <div class="col s12">
                <h4 class="header">Crear Usuario</h4>
                <div class="col s12 m6">
                    <a onclick="new_userb()" class="btn btn-large waves-effect waves-light cyan">
                                    Crear Usuario <i class="material-icons right">person_add</i></a>
                </div>
            </div>
            <div class="col s12"><br>
                <div class="col s12 divider"></div>
            </div>

            <!--DataTables-->
            <div id="table-datatables">
                    <div class="col s12">
                        <h4 class="header">Lista de Usuarios</h4>
                    </div>

                    <div class="col s12"><br>
                        <table id="dataTable" class="responsive-table display" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th style="text-align: center" width="5%">#</th>
                                    <th style="text-align: center" width="35%">Nombre</th>
                                    <th style="text-align: center" width="15%">Correo</th>
                                    <th style="text-align: center" width="15%">Reiniciar Clave</th>
                                    <th style="text-align: center" width="15%">Activar/Desactivar</th>
                                    <th style="text-align: center" width="15%">Acción</th>
                                </tr>
                            </thead>
                            <tbody>  
                                @php
                                    $b=0;
                                @endphp
                                @if($usuarios != null) 
                                    @foreach($usuarios as $user)
                                        @php
                                            $b++;
                                        @endphp
                                    <tr>
                                        <td style="text-align: center">{{ $b }}</td>
                                        <td style="text-align: center">{{ $user->nombre }}</td>
                                        <td style="text-align: center">{{ $user->correo }}</td>
                                        <td style="text-align: center">
                                            @if($user->estatus==1 || $user->estatus==true)
                                                <a onclick="reboot_pass_userb({{ $user->id }})" class="btn-floating btn-flat waves-effect waves-light purple lightrn-1 white-text tooltipped" data-position="top" data-delay="50" data-tooltip="Reiniciar la contraseña"><i class="material-icons right">autorenew</i>
                                                </a>
                                            @else
                                                <a class="btn-floating btn-flat waves-effect waves-light grey lightrn-1 white-text"><i class="material-icons right">autorenew</i>
                                                </a>
                                            @endif
                                        </td>
                                        <td style="text-align: center">

                                            @if($user->estatus==1 || $user->estatus==true)
                                                <a onclick="status_userb({{ $user->id }},{{'false'}})" class="btn red waves-effect waves-light" style="font-size: 12.6px;">Inactivar <i class="material-icons right">remove_circle</i>
                                                </a>   
                                            @else
                                                <a onclick="status_userb({{ $user->id }},{{'true'}})" class="btn orange waves-effect waves-light" style="font-size: 12.6px;">Activar <i class="material-icons right">add_circle_outline</i>
                                                </a>   
                                            @endif

                                        </td>
                                        <td style="text-align: center">
                                            @if($user->estatus==1 || $user->estatus==true)
                                                <a onclick="edit_userb({{ $user->id }})" class="btn green waves-effect waves-light" style="font-size: 12.6px;">Editar <i class="material-icons right">edit</i>
                                                </a>   
                                            @else
                                                <a href="#!" class="btn grey waves-effect waves-light" style="font-size: 12.6px;">Editar <i class="material-icons right">edit</i>
                                                </a>   
                                            @endif
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
    </div><!--card panel-->
</div>
<!--end container-->

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
    <script src="{{ asset('js/usuario.js') }}" charset="utf-8"></script>
@endsection
