
            <div class="col s12 m12"><br>
                <h5 class="center login-form-text2">Administración | Editar parametro</h5>
                <div class="col s12"><br>
                    <div class="col s12 divider"></div>
                </div>
                
                    <div class="row">
                        <form  id="fedit_param" ><br>
                            <div class="col s12 m12">
                                <div class="input-field col s12 m12">
                                    <span>Nombre del parametro</span>
                                    <input  type="text" id="param_name" class="validate" value="{{ $cfparams[0]->nombre }}" disabled/>    
                                </div>
                                <div class="input-field col s12 m12">
                                    <span>Valor para el parametro</span>
                                    <input type="number" id="param_value" class="validate" min="1" onkeypress="return solonumeros(event)" value="{{ $cfparams[0]->valor }}" required/>
                                    
                                    <input type="hidden" id="cf_param_id" name="cf_param_id" value="{{$cfparams[0]->id}}"/>
                                    <input type="hidden" id="flag" name="flag" value="1"/>
                                </div>
                            </div>    

                            <div class="input-field col s12">
                                <div class="col s12 m6">
                                    <a onclick="guardar_cparams()" class="btn green waves-effect waves-light">
                                                Guardar
                                        <i class="material-icons right">save</i>
                                    </a>                                            
                                </div>
                            </div>
                        </form>
                    </div> 
            </div>

