<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use App\Models\CmGustos;

class GustosController extends Controller {

    public function __construct() {
        $this->params = array();
    }

    public function emitFeel(Request $request) {

        if ($request->ajax()) {

            //Datos referente al multimedia que se desea aplicar el like o dislike
            $params['encuesta_id'] = $request['encuesta_id'];
            $params['categoria_id'] = $request['categoria_id'];
            $params['candidato_multimedia_id'] = $request['candidato_multimedia_id'];
            $params['candidato_id'] = $request['candidato_id'];
            $params['tipo_multimedia'] = $request['tipo_multimedia'];
            $params['emotion'] = $request['emotion'];
            $params['usuario_id'] = Session::get("usuario")->id;

            //Verificar si ya el usuario emitió el gusto
            $existe_lgbd = CmGustos::existe_emotion_en_bd_byUserId($params);

            if ($existe_lgbd == 0) { // insert
                $new_emocion = CmGustos::new_emotion($params);
                if ($new_emocion !== false) { error_log('insert emitFeel');
                    //Una vez emitido el gusto, ahora debemos saber cuanto es el contador para los like y dislike
                    $params['me_gusta'] = CmGustos::get_like_generic_cand($params['encuesta_id'], $params['categoria_id'], $params['candidato_multimedia_id'], $params['candidato_id'], $params['tipo_multimedia'], 1);

                    $params['no_me_gusta'] = CmGustos::get_dislike_generic_cand($params['encuesta_id'], $params['categoria_id'], $params['candidato_multimedia_id'], $params['candidato_id'], $params['tipo_multimedia'], 2);

                    $params['tipo_accion'] = 1; //primera vez 

                    return response()->json($params);
                } else {
                    return 2; //Falló
                }
            } else {//update
                $update_emocion = CmGustos::actualizar_emotion($params);
                if ($update_emocion !== false) {error_log('update emitFeel');

                    //Una vez emitido el gusto, ahora debemos saber cuanto es el contador para los like y dislike
                    $params['me_gusta'] = CmGustos:: get_like_generic_cand($params['encuesta_id'], $params['categoria_id'], $params['candidato_multimedia_id'], $params['candidato_id'], $params['tipo_multimedia'], 1);

                    $params['no_me_gusta'] = CmGustos::get_dislike_generic_cand($params['encuesta_id'], $params['categoria_id'], $params['candidato_multimedia_id'], $params['candidato_id'], $params['tipo_multimedia'], 2);

                    $params['tipo_accion'] = 2; //actualizar 

                    return response()->json($params);
                } else {
                    return 2; //Falló
                }
            }
        }
    }

}