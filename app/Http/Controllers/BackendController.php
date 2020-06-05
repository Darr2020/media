<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use App\Models\ConfigParametro;


class BackendController extends Controller {

    public function __construct() {
        $this->params = array();
    }

    public function index() {

        return view("backend.inicio");
    }



    public function indexCfParams() {
        $existe_conf_params = ConfigParametro::get_config_parametro();

        return view("backend.config.index_cfparams",[
            "cfparams" => $existe_conf_params
        ]);
    }


    public function newConfParams(){
         return view("backend.config.new_param");
    }

    public function editConfParams(Request $request){
         $datos_cf_params = ConfigParametro::get_config_parametro_byId($request->cf_param_id);

         return view("backend.config.edit_param",[
            "cfparams" => $datos_cf_params
         ]);
    }

    public function configParams() {
        $existe_conf_params = ConfigParametro::get_config_parametro();

        return view('backend.config.parametros',[
            "cfparams" => $existe_conf_params
        ]);
    }

    public function actualizarConfParams(Request $request) {
        if($request['flag'] == 1)
        {
            
            $update_conf_params = ConfigParametro::actualizar_config_parameters($request->all());

                if ($update_conf_params == true) {
                    return 1; //proceso realizado exitosamente
                } else {
                    return 2; //ocurrió un problema al guardar
                }

        }else{
            //crear
            $save_cfp = ConfigParametro::guardar_config_parameters($request->all());
                if ($save_cfp == true) {
                    return 1; //proceso realizado exitosamente
                } else {
                    return 2; //ocurrió un problema al guardar
                }
        }
    }  
}
