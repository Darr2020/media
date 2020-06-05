

            <div class="col s12 m12"><br>
                <h5 class="center login-form-text2">Administración | Nuevo parametro</h5>

                <div class="col s12"><br>
                            <div class="col s12 divider"></div>
                </div>
                
                    <div class="row">
                        <form  id="fnew_param" ><br>
                            <div class="col s12 m12">
                                <div class="input-field col s12 m12">
                                                <input  type="text" id="param_name" class="validate" value="" required/>
                                                <label for="param_name">Nombre del nuevo parametro</label>
                                </div>
                                <div class="input-field col s12 m12">
                                                <input type="number" id="param_value" class="validate" min="1" onkeypress="return solonumeros(event)" value="" required/>
                                                <label for="param_value">Valor para el nuevo parametro</label>

                                                <input type="hidden" id="flag" name="flag" value="0" />
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

