<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Comun\AppComun;
use App\Models\EncuestaAll;


class EncuestaController extends Controller {

    public function __construct() {
        $this->params = array();
    }

    //Index de Encuesta Telefónica (ET)
    public function encuestaIndex() {
        $encuesta = EncuestaAll::getAllPollTlf();
        $enc_sin_publicar = EncuestaAll::countEncuestaTlfSinPublicar();
        $last_enctlf = EncuestaAll::getUltimaEncuestaTlf();

        return view("backend.encuesta_tlf.enc_index", [
            "encuesta" => $encuesta,
            "enc_sin_publicar" => $enc_sin_publicar,
            "last_enctlf" => $last_enctlf
        ]);
    }

    public function encuestaTlfP1() {

        return view("backend.encuesta_tlf.enc_tlf_paso1");
    }


    public function encuestaTlfP1Mod($id) {
        $enc_data = EncuestaAll::getInfoPollById($id);

        return view("backend.encuesta_tlf.enc_tlf_editarP1",[
            "enc_data" => $enc_data
        ]
    );
    }


    public function encuestaTlfP2($id) {
        $enc_data = EncuestaAll::getInfoPollById($id);
        $categorias = EncuestaAll::getAllCategoriasWithCand();

        //Verificar si la encuesta esta presente en la tabla encuesta_tlf
        $exist_etlf = EncuestaAll::ExisteEnEncuestaTlf($id);
        if($exist_etlf!=0){
            //Trae aquellas categorias que tienen candidatos con puntaje en la tabla encuesta_tlf
          $categoriasB=EncuestaAll::countPuntosCandidatosPorEncuestaTlf($id);
          $categoriasA =$categorias;

            //foreach con todas las categorias y sus candidatos activos
            foreach($categoriasA as $key => $caa){
                $param_cat[$key]['categoria_id'] = $caa->categoria_id;
                $param_cat[$key]['categoria'] = $caa->categoria;

                //foreach con las categorias y sus candidatos que tienen puntaje en la tabla encuesta_tlf
                foreach($categoriasB as $cab){
                    //categorias que coinciden
                    if($caa->categoria_id == $cab->categoria_id){
                        $param_cat[$key]['estatus_cat_enctlf'] = $cab->estatus_cat_enctlf;
                        $param_cat[$key]['candidatos_con_puntos'] = $cab->candidatos_con_puntos;
                        break;
                    }else{
                        $param_cat[$key]['estatus_cat_enctlf'] = null;
                        $param_cat[$key]['candidatos_con_puntos'] = null;
                    }
                   
                }//End ForeachB

            }//End ForeachA

            $categorias = $param_cat;
        }

        return view("backend.encuesta_tlf.enc_tlf_paso2", [
            "encuesta" => $enc_data,
            "categoria" => $categorias
        ]);
    }

    //MOD 20-10-2018
    public function encuestaTlfShow($enc_id) {
        $enc_data = EncuestaAll::getInfoPollById($enc_id);
        $info_candidatos = EncuestaAll::getDataCandidatoByPoll($enc_id);

        return view("backend.encuesta_tlf.enc_tlf_show", [
            "encuesta" => $enc_data,
            "info_candidatos" => $info_candidatos
        ]);
    }

    //MOD 20-10-2018
    public function buscarCandidatosPorCateg(Request $request) {
        $categoria_id = $request->id;
        $encuesta_id = $request->enc_id;

        ////// Trae todos los candidatos de acuerdo a la categoria
        $candidato = EncuestaAll::getCandByCategoriaId($categoria_id);
        ///// Retorna la información de la categoria consultada por id
        $categoria = EncuestaAll::getDataCategoriaById($categoria_id);

        ////// Da la información básica de la encuesta consultada por id
        $enc_data = EncuestaAll::getInfoPollById($encuesta_id);
       // dd('enc_data',$enc_data);

        if ($enc_data != null) {
            if ($enc_data->tipo_encuesta == 2) {
                //ET
                ///// Devuelve la información de los candidatos que estan en la tabla encuesta_tlf,  
                /// consultada por encuesta_id y categoria_id
                $enc_candidato_tlf = EncuestaAll::getDataEncuestaTlfCandidato($categoria_id, $encuesta_id);

                ///// Count de la tabla encuesta_tlf, indica si ya hay registros en dicha tabla
                /// para la encuesta y categoria señalada
                $existe_enc_tlf = EncuestaAll::getExisteEnEncuestatlf($categoria_id, $encuesta_id);

                ///// Trae todos los candidatos de la tabla candidatos, esto es para la primera vez
                //Para cuando no hayan candidatos en la tabla encuesta_tlf
                $candidato_all = EncuestaAll::getDataCandScoreByCategoriaOnly($categoria_id);

                ///// Conteo para saber cuantos candidatos tiene asociado una categoria
                $count_cand_cate = EncuestaAll::countCandidatosPorCategoria($categoria_id);
                /////Saber la sumatoria de puntos de los candidatos filtrado por encuesta_id y categoria_id
                $sum_ptos_cand = EncuestaAll::sumaPuntosTlf($encuesta_id, $categoria_id); //es null si no hay candidatos en la encuesta
                ///// Indica la cantidad de candidatos que tienen puntos de la encuesta, por categoria
                $count_ptos_cancat = EncuestaAll::countPuntosCandidatosPorCategoria($categoria_id); //es cero si no hay candidatos en la encuesta


                if ($enc_candidato_tlf != null && $existe_enc_tlf > 0) {
                    ///// Trae todos los candidatos de la tabla candidatos asociados con la categoria
                    $candidato_all_v1 = $candidato_all;

                    $a = 0;
                    /////Se hace un cruce con los candidatos que ya esten presentes en la tabla encuesta_tlf
                    /// De esta forma se obtiene el puntaje, y se conservan aquellos candidatos sin puntos
                    foreach ($candidato_all_v1 as $call) {
                        $params[$a]['id'] = $call->id;
                        $params[$a]['categoria_id'] = $call->categoria_id;
                        $params[$a]['nombre'] = $call->nombre;
                        $params[$a]['detalle'] = $call->detalle;
                        $params[$a]['sexo'] = $call->sexo;
                        $params[$a]['pag'] = $call->pag;
                        $params[$a]['estatus'] = $call->estatus;
                        $params[$a]['nom_categoria'] = $call->nom_categoria;

                        foreach ($enc_candidato_tlf as $ec) {
                            if ($ec->candidato_id == $call->id) {
                                $params[$a]['puntaje_tlf'] = $ec->puntaje_tlf;
                                break;
                            } else if ($ec->candidato_id != $call->id) {
                                $params[$a]['puntaje_tlf'] = null;
                            }
                        }// foreach
                        $a++;
                        $candidato_all = $params;
                    }// foreach
                }
            }//2do if
        } //1er if

        return view("backend.encuesta_tlf.enc_tlf_cand_cate", [
            "encuesta" => $enc_data,
            "candidato" => $candidato,
            "categoria" => $categoria,
            "enc_candidato_tlf" => $enc_candidato_tlf,
            "existe_enc_tlf" => $existe_enc_tlf,
            "candidato_all" => $candidato_all,
            "count_cand_cate" => $count_cand_cate,
            "sum_ptos_cand" => $sum_ptos_cand,
            "count_ptos_cancat" => $count_ptos_cancat
        ]);
    }

    //MOD 20-10-2018
    public function mostrarEncuestaPorCategoria(Request $request) {
        $enc_cate_cand = EncuestaAll::getDataPollTlfCandByCategoria($request->enc_id, $request->cate_id);
        $enc_data = EncuestaAll::getInfoPollById($request->enc_id);
        $categoria = EncuestaAll::getDataCategoriaById($request->cate_id);

        /////Saber la sumatoria de puntos de los candidatos filtrado por encuesta_id y categoria_id
        $sum_ptos_cand = EncuestaAll::sumaPuntosTlf($request->enc_id, $request->cate_id);

        return view("backend.encuesta_tlf.enc_show_categoria", [
            "encuesta" => $enc_data,
            "categoria" => $categoria,
            "enc_cate_cand" => $enc_cate_cand,
            "sum_ptos_cand" => $sum_ptos_cand
        ]);
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////                                                      ////////////////////////////   
    //////////////////////////////////////////////////////////////////////////////////////////////////////////////

    public function guardarEncuesta(Request $request) {
        try {
            $params['fecha_desde'] = AppComun::girarFormatoFecha($request['fecha_desde']); // formato dd/mm/yyyy
            $params['fecha_hasta'] = AppComun::girarFormatoFecha($request['fecha_hasta']); // formato dd/mm/yyyy
            $params['muestra'] = trim($request['muestra']);
            $params['muestra_feme'] = trim($request['muestra_feme']);
            $params['muestra_masc'] = trim($request['muestra_masc']);
            $params['descripcion'] = trim($request['descripcion']);
            $params['usuario_id'] = Session::get("usuario_backend")->id;

            if ($request->hasFile('file')) {
                $encuesta_id = EncuestaAll::save_poll($params); //guardando la primera parte de la encuesta, retornando el id

                if ($encuesta_id !== false) {
                    $tipo = $request->file->getClientMimeType();
                    $tamanio = $request->file->getClientSize();
                    $ext = $request->file->getClientOriginalExtension();
                    if ($tipo == 'application/pdf' || $ext == 'pdf') {
                        /////Dando formato dd-mm-yyyy
                        $fecha_desde = AppComun::dar_formato_fecha_guion($request['fecha_desde']);
                        $fecha_hasta = AppComun::dar_formato_fecha_guion($request['fecha_hasta']);

                        $nombre_file = $encuesta_id . '_' . $fecha_desde . '_' . $fecha_hasta . '.' . 'pdf';
                        $upload_success = $request->file->move(public_path() . '/encuesta/enc_tlf', $nombre_file);
                        //Si se sube el archivo en la carpeta, se guarda en BD
                        if ($upload_success) {
                            $up_file = EncuestaAll::save_file($encuesta_id, $nombre_file, $params['usuario_id']); //actualizando en la encuesta el archivo
                            if ($up_file == true) {
                                return 1; //proceso realizado de forma exitosa
                            } else {
                                return 0; //Error en el proceso, guardando el archivo
                            }
                        } else {
                            return 2; //No se pudo crear el archivo en la carpeta
                        }
                    } else {
                        return 5; //Error de formato
                    }
                } else if ($encuesta_id == false) {
                    return 4; //Error al guardar encuesta
                }
            } else {
                return 3; //Error de proceso, no hay archivo;
            }
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }


  //Actualizar Encuesta
    public function actualizarEncuesta(Request $request) {
        try {
            $params['enc_id'] = $request['enc_id'];
            $params['fecha_desde'] = AppComun::girarFormatoFecha($request['fecha_desde']); // formato dd/mm/yyyy
            $params['fecha_hasta'] = AppComun::girarFormatoFecha($request['fecha_hasta']); // formato dd/mm/yyyy
            $params['muestra'] = trim($request['muestra']);
            $params['muestra_feme'] = trim($request['muestra_feme']);
            $params['muestra_masc'] = trim($request['muestra_masc']);
            $params['descripcion'] = trim($request['descripcion']);
            $params['usuario_id'] = Session::get("usuario_backend")->id;

        ///////Se actualiza la encuesta ////////
        $mod_enc = EncuestaAll::update_poll($params); 

        ///////// Si tiene archivo  /////////
            if ($request->hasFile('file')) {
                if ($mod_enc !== false) {
                    $tipo = $request->file->getClientMimeType();
                    $tamanio = $request->file->getClientSize();
                    $ext = $request->file->getClientOriginalExtension();
                    if ($tipo == 'application/pdf' || $ext == 'pdf') {
                        /////Dando formato dd-mm-yyyy
                        $fecha_desde = AppComun::dar_formato_fecha_guion($request['fecha_desde']);
                        $fecha_hasta = AppComun::dar_formato_fecha_guion($request['fecha_hasta']);

                        $nombre_file = $params['enc_id'] . '_' . $fecha_desde . '_' . $fecha_hasta . '.' . 'pdf';
                        $upload_success = $request->file->move(public_path() . '/encuesta/enc_tlf', $nombre_file);
                        //Si se sube el archivo en la carpeta, se guarda en BD
                        if ($upload_success) {
                            $up_file = EncuestaAll::save_file($params['enc_id'], $nombre_file, $params['usuario_id']); //actualizando en la encuesta el archivo
                            if ($up_file == true) {
                                return 1; //proceso realizado de forma exitosa
                            } else {
                                return 0; //Error en el proceso, guardando el archivo
                            }
                        } else {
                            return 2; //No se pudo crear el archivo en la carpeta
                        }
                    } else {
                        return 4; //Error de formato
                    }
                } else if ($encuesta_id == false) {
                    return 3; //Error al guardar encuesta
                }
            } else{
                return 1; //proceso realizado de forma exitosa
            }
        } catch (\Exception $e) {
            return $e->getMessage();
        }

    }


    public function publicarEncTlf(Request $request) {
        $push_poll_phone = EncuestaAll::update_encuesta_tlf_publicar($request->enc_id, Session::get("usuario_backend")->id);
        if ($push_poll_phone == true) {
            return 1; //Actualización exitosa
        } else {
            return 2; //Ocurrio un error al actualizar
        }
    }

    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //////////////////////////////////////////////////////////////////////////////////////////////////////////////
    /////////////////////////////////////           ENCUESTA WEB         /////////////////////////////////////////
//MOD 21-10-2018
    public function encuestaWebIndex() {
        $encuesta = EncuestaAll::getAllPollWeb();
        $enc_sin_publicar = EncuestaAll::countEncuestaWebSinPublicar();
        $last_enctlf = EncuestaAll::getUltimaEncuestaTlf();
        $last_encweb = EncuestaAll::getUltimaEncuestaWeb();
        $paramst = $last_enctlf->last();
        $paramsw = $last_encweb->last();

        return view("backend.encuesta_web.index", [
            "encuesta" => $encuesta,
            "enc_sin_publicar" => $enc_sin_publicar,
            "last_enctlf" => $paramst,
            "last_encweb" => $paramsw,
        ]);
    }

    public function encuestaWebTlfP2($id) {
        $enc_data = EncuestaAll::getInfoPollById($id);
        $categorias = EncuestaAll::getAllCategoriasWithCand();

        //Verificar si la encuesta esta presente en la tabla encuesta_web
        $exist_eweb = EncuestaAll::ExisteEnEncuestaWeb($id);
        if($exist_eweb!=0){
            //Trae aquellas categorias que tienen candidatos con puntaje en la tabla encuesta_web
          $categoriasB=EncuestaAll::countPuntosCandidatosPorEncuestaWeb($id);
          $categoriasA =$categorias;

            //foreach con todas las categorias y sus candidatos activos
            foreach($categoriasA as $key => $caa){
                $param_cat[$key]['categoria_id'] = $caa->categoria_id;
                $param_cat[$key]['categoria'] = $caa->categoria;

                //foreach con las categorias y sus candidatos que tienen puntaje en la tabla encuesta_tlf
                foreach($categoriasB as $cab){
                    //categorias que coinciden
                    if($caa->categoria_id == $cab->categoria_id){
                        $param_cat[$key]['estatus_cat_encweb'] = $cab->estatus_cat_encweb;
                        $param_cat[$key]['candidatos_con_puntos'] = $cab->candidatos_con_puntos;
                        $param_cat[$key]['bandera'] = $cab->bandera;
                        break;
                    }else{
                        $param_cat[$key]['estatus_cat_encweb'] = null;
                        $param_cat[$key]['candidatos_con_puntos'] = null;
                        $param_cat[$key]['bandera'] = null;
                    }
                   
                }//End ForeachB

            }//End ForeachA

            $categorias = $param_cat;

        }

        return view("backend.encuesta_web.encw_paso2", [
            "encuesta" => $enc_data,
            "categoria" => $categorias,
            "exist_eweb" => $exist_eweb
        ]);
    }

    //MOD 21-10-2018
    public function buscarCandidatosPorCategWeb(Request $request) {
        $categoria_id = $request->id;
        $encuesta_id = $request->enc_id;
        $ban = EncuestaAll::getBanderaEncuesta($encuesta_id);
        $bandera = $ban[0]->bandera;

        ////// Da la información básica de la encuesta consultada por id
        $enc_data = EncuestaAll::getInfoPollById($encuesta_id);

        ////// Trae todos los candidatos de acuerdo a la categoria
        $candidato = EncuestaAll::getCandByCategoriaId($categoria_id);

        ///// Retorna la información de la categoria consultada por id
        $categoria = EncuestaAll::getDataCategoriaById($categoria_id);

        ///// Devuelve la información de los candidatos que estan en la tabla encuesta_candidato,  
        /// consultada por encuesta_id y categoria_id
        $enc_candidato = EncuestaAll::getDataEncuestaCandidato($categoria_id, $encuesta_id);

        /////saber si la encuesta tiene orden en vez de puntaje
        $count_orden_enc = EncuestaAll::countOrdenCandidatosPorEncuestaWeb2($encuesta_id);

        ///// Count de la tabla encuesta_candidato, indica si ya hay registros en dicha tabla
        /// para la encuesta dada y señalando una categoria en especifico
        $existe_encCand = EncuestaAll::getExisteEnEncuestaWeb($categoria_id, $encuesta_id);

        if ($enc_candidato == null and $existe_encCand == 0) {
            ///// Trae todos los candidatos de la tabla candidatos, esto es para la primera vez
            //Para cuando no hayan candidatos en la tabla encuesta_candidato
            $candidato_all = EncuestaAll::getDataCandScoreByCategoriaOnly($categoria_id);
        } else {
            ///// Trae todos los candidatos de la tabla candidatos 
            $candidato_all_v1 = EncuestaAll::getDataCandScoreByCategoriaOnly($categoria_id);

            $a = 0;
            /////Se hace un cruce con los candidatos que ya esten presentes en la tabla encuesta_candidato
            /// De esta forma se obtiene el puntaje, y se conservan aquellos candidatos sin puntos
            foreach ($candidato_all_v1 as $call) {
                $params[$a]['id'] = $call->id;
                $params[$a]['categoria_id'] = $call->categoria_id;
                $params[$a]['nombre'] = $call->nombre;
                $params[$a]['detalle'] = $call->detalle;
                $params[$a]['sexo'] = $call->sexo;
                $params[$a]['pag'] = $call->pag;
                $params[$a]['estatus'] = $call->estatus;
                $params[$a]['nom_categoria'] = $call->nom_categoria;

                foreach ($enc_candidato as $ec) {
                    if ($bandera == 1) {
                        if ($ec->candidato_id == $call->id) {
                            $params[$a]['puntaje_web'] = $ec->puntaje;
                            break;
                        } else if ($ec->candidato_id != $call->id) {
                            $params[$a]['puntaje_web'] = null;
                        }
                    }
                    if ($bandera == 2) {
                        if ($ec->candidato_id == $call->id) {
                            $params[$a]['orden'] = $ec->puntaje;
                            break;
                        } else if ($ec->candidato_id != $call->id) {
                            $params[$a]['orden'] = null;
                        }
                    }
                }// foreach
                $a++;
                $candidato_all = $params;
            }// foreach
        }


        ///// Conteo para saber cuantos candidatos tiene asociado una categoria
        $count_cand_cate = EncuestaAll::countCandidatosPorCategoria($categoria_id);
        /////Saber la sumatoria de puntos de los candidatos filtrado por encuesta_id y categoria_id
        $sum_ptos_cand = EncuestaAll::sumaPuntosWeb($encuesta_id, $categoria_id); //es null si no hay candidatos en la encuesta
        ///// Indica la cantidad de candidatos que tienen puntos de la encuesta, por categoria
        $count_ptos_cancat = EncuestaAll::countPuntosCandidatosPorCategoriaWeb($categoria_id); //es cero si no hay candidatos en la encuesta
        ///// Indica la cantidad de candidatos que tienen orden de la encuesta, por categoria
        $count_orden_cancat = EncuestaAll::countOrdenCandidatosPorCategoria($categoria_id);

        return view("backend.encuesta_web.encw_cand_cate", [
            "encuesta" => $enc_data,
            "candidato" => $candidato,
            "categoria" => $categoria,
            "enc_candidato" => $enc_candidato,
            "existe_encCand" => $existe_encCand,
            "candidato_all" => $candidato_all,
            "count_cand_cate" => $count_cand_cate,
            "sum_ptos_cand" => $sum_ptos_cand,
            "count_ptos_cancat" => $count_ptos_cancat,
            "bandera" => $bandera,
            "count_orden_cancat" => $count_orden_cancat,
            "count_orden_enc" => $count_orden_enc,
        ]);
    }

    //MOD 21-10-2018
    public function mostrarEncuestaPorCategoriaWeb(Request $request) {
        $enc_cate_cand = EncuestaAll::getDataPollWebCandByCategoria($request->enc_id, $request->cate_id);
        $enc_data = EncuestaAll::getInfoPollById($request->enc_id);
        $categoria = EncuestaAll::getDataCategoriaById($request->cate_id);
        /////Saber la sumatoria de puntos de los candidatos filtrado por encuesta_id y categoria_id
        $sum_ptos_cand = EncuestaAll::sumaPuntosWeb($request->enc_id, $request->cate_id);

        return view("backend.encuesta_web.encw_show_categoria", [
            "encuesta" => $enc_data,
            "categoria" => $categoria,
            "enc_cate_cand" => $enc_cate_cand,
            "sum_ptos_cand" => $sum_ptos_cand
        ]);
    }

    //MOD 2110-2018
    public function encuestaTlfShowWeb($enc_id) {
        $enc_data = EncuestaAll::getInfoPollById($enc_id);
        $info_candidatos = EncuestaAll::getDataCandidatoByPollWeb($enc_id);
        $ban = EncuestaAll::getBanderaEncuesta($enc_id);
        $bandera = $ban[0]->bandera;

        return view("backend.encuesta_web.encw_show", [
            "encuesta" => $enc_data,
            "info_candidatos" => $info_candidatos,
            "bandera" => $bandera
        ]);
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////                                                      ////////////////////////////   
    //////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///A PARTIR DE UNA ENCUESTA TELEFONICA
    //MOD 20-10-2018
    public function encuestaWebTlf() {
        $last_enc = EncuestaAll::getUltimaEncuestaTlf();
        $params = $last_enc->last();
        ///// La última encuesta telefonica esta en EC
        $cec_existe = EncuestaAll::ExisteEnEncuestaTlf($params->id);
        $enc_ant = EncuestaAll::getAllEncTlfParaWebByEncId($params->id);

        if ($cec_existe > 0) {
            //entonces la bandera se guardará en encuesta como 1. Lo que significa que se le pondrá puntaje web
            $bandera = 1;
        } else {
            /////No se le asignado puntaje entonces la bandera se guardará en encuesta como 2. Lo que significa que se le pondrá orden y no puntaje web
            $bandera = 2;
        }

        $save_enc_web_id = EncuestaAll::save_poll_web(Session::get("usuario_backend")->id, $bandera);
        if ($save_enc_web_id != false) {
            $save_enc_can = EncuestaAll::save_poll_cand($save_enc_web_id, $enc_ant);
            if ($save_enc_can != false) {
                return 1;
            } else {
                return 3;
            }
        } else {
            return 2;
        }
    }

    //MOD 22102018
    public function publicarEncWeb(Request $request) {
        //obtener las categorias de los candidatos de la encuesta a publicar
        $categorias_ecw = EncuestaAll::getCategoriasPorEncuestaWeb($request->enc_id);

        $push_poll_phone = EncuestaAll::update_encuesta_web_publicar($request->enc_id, Session::get("usuario_backend")->id, $categorias_ecw);

        if ($push_poll_phone == true) {
            return 1; //Proceso exitoso
        } else {
            return 2; //Ocurrio un error al actualizar
        }
    }

    //MOD 22102018
    public function encuestaWebVacia() {
        $bandera = 0; //Indica que no tiene ni puntaje web ni orden
        $save_enc_web_id = EncuestaAll::save_poll_web(Session::get("usuario_backend")->id, $bandera);
        if ($save_enc_web_id != false) {
            return 1;
        } else {
            return 2;
        }
    }

    public function removerCandDeEncuestaCandidato(Request $request) {
        $post = EncuestaAll::getEncuestaWeb($request->enc_id, $request->cat_id, $request->cand_id);
        $remove_cec = EncuestaAll::remove_encuesta_candidato($post->id);
        if ($remove_cec == true) {
            return 1; //proceso realizado exitosamente
        } else {
            return 2; //ocurrió un problema al guardar
        }
    }

    /////////////////////////////////////////////////////////////////////////////////////////////////////
    /////////////// Nuevo tratamiento al ingresar o editar puntaje u orden en ET y EW ///////////////////

    public function guardarIniOrdPto(Request $request) {
        ////consultar si el binomio encuesta_id y candidato existe en la tabla EC
        $presente_ec = EncuestaAll::ExisteEnEncuestaWebByEncCatCand($request['enc_id'], $request['cat_id'], $request['cand_id']);
        if ($presente_ec == 0) {
            ///insert
            $add_valor_enc = EncuestaAll::guardar_valori_candidato($request->all(), Session::get("usuario_backend")->id);
            if ($add_valor_enc == true) {
                return 1; //exito
            } else {
                return 2; //fallo
            }
        }
    }

    public function verifyDataEncOWeb(Request $request) {
        if ($request['candidato_ordenweb']) {
            $posicion = 1;
            $movimiento = 'nuevo';
            foreach ($request['candidato_ordenweb'] as $key => $value) {
                ////consultar si el binomio encuesta_id y candidato existe en la tabla EW. Donde $key es el id del candidato
                //$request['id'] es de la categoria
                if ($value != null) {
                    $presente_ec = EncuestaAll::ExisteEnEncuestaWebByEncCatCand($request['enc_id'], $request['id'], $key);
                    if ($presente_ec == 0) {
                        ///insert
                        $add_score_encw = EncuestaAll::salvar_puntaje_web($request['enc_id'], $request['id'], $key, $value);
                        if ($add_score_encw == false) {
                            return 'fallo'; //fallo
                        }
                    } else {
                        ///update
                        $update_score_encw = EncuestaAll::actualizar_puntaje_web($request['enc_id'], $request['id'], $key, $value, $posicion, $movimiento);
                        if ($update_score_encw == false) {
                            return 'fallo'; //fallo
                        }
                    }
                }
                $posicion++;
            }
        } else {
            return 0;
        }
    }

    public function verifyDataEncWeb(Request $request) {
        if ($request['candidato_puntajeweb']) {
        $posicion = 1;
            $movimiento = 'nuevo';
            foreach ($request['candidato_puntajeweb'] as $key => $value) {
                ////consultar si el binomio encuesta_id y candidato existe en la tabla EW. Donde $key es el id del candidato
                //$request['id'] es el id de la categoria
                if ($value != null) {
                    $presente_ec = EncuestaAll::ExisteEnEncuestaWebByEncCatCand($request['enc_id'], $request['id'], $key);
                    if ($presente_ec == 0) {
                        ///insert
                        $add_score_encw = EncuestaAll::salvar_puntaje_web($request['enc_id'], $request['id'], $key, $value, $posicion, $movimiento);
                        if ($add_score_encw == false) {
                            return 'fallo'; //fallo
                        }
                    } else {
                        ///update
                        $update_score_encw = EncuestaAll::actualizar_puntaje_web($request['enc_id'], $request['id'], $key, $value, $posicion, $movimiento);
                        if ($update_score_encw == false) {
                            return 'fallo'; //fallo
                        }
                    }
                }
        $posicion++;
            }
        } else {
            return 0;
        }
    }

    public function verifyData(Request $request) {
        if ($request['candidato_puntaje']) {
            foreach ($request['candidato_puntaje'] as $key => $value) {
                ////consultar si el binomio encuesta_id y candidato existe en la tabla ET. Donde $key es el id del candidato
                if ($value != null) {
                    $presente_ec = EncuestaAll::ExisteEnEncuestaTlfByEncCand($request['enc_id'], $request['id'], $key);
                    if ($presente_ec == 0) {
                        ///insert
                        $add_score_enc = EncuestaAll::salvar_puntaje_tlf($request['enc_id'], $request['id'], $key, $value);
                        if ($add_score_enc == false) {
                            return 'fallo'; //fallo
                        }
                    } else {
                        ///update
                        $update_score_enc = EncuestaAll::actualizar_puntaje_tlf($request['enc_id'], $request['id'], $key, $value);
                        if ($update_score_enc == false) {
                            return 'fallo'; //fallo
                        }
                    }
                }
            }
        } else {
            return 0;
        }
    }

    public function encuestaWebClonar() {
        $last_encw = EncuestaAll::getUltimaEncuestaWeb();
        $params = $last_encw->last();
        //Traer la data de la encuesta web
        $encw_ant = EncuestaAll::getAllEncWebByEC($params->id);
        $bandera = $params->bandera; //1 es puntaje web, 2 es para orden
        $save_encweb_id = EncuestaAll::save_poll_web(Session::get("usuario_backend")->id, $bandera);
        if ($save_encweb_id != false) {
            $save_enccan = EncuestaAll::save_pollweb_cand($save_encweb_id, $encw_ant);
            if ($save_enccan != false) {
                return 1;
            } else {
                return 3;
            }
        } else {
            return 2;
        }
    }


    public function removerCategoriaDeEncTlf(Request $request) {
        $cambiar_estatus_cat_et =  EncuestaAll::cambiar_estatus_categoria_enctlf($request->enc_id,$request->cat_id,$request->valor);
        if ($cambiar_estatus_cat_et == true) {
            return 1; //proceso realizado exitosamente
        } else {
            return 2; //ocurrió un problema al guardar
        }

    }

    public function removerCategoriaDeEncWeb(Request $request) {
        $cambiar_estatus_cat_ew =  EncuestaAll::cambiar_estatus_categoria_encweb($request->enc_id,$request->cat_id,$request->valor);
        if ($cambiar_estatus_cat_ew == true) {
            return 1; //proceso realizado exitosamente
        } else {
            return 2; //ocurrió un problema al guardar
        }
    }

    public function encuestaTlfClonar() {
        $last_enctlf = EncuestaAll::getUltimaEncuestaTlf();
        $params = $last_enctlf->last();
        //Traer la data de la encuesta tlf
        $enctlf_ant = EncuestaAll::getAllEncTlfByEC($params->id);
        
        $save_enctlf_id = EncuestaAll::save_poll_tlf(Session::get("usuario_backend")->id, $params);
        if ($save_enctlf_id != false) {
            $save_enccan = EncuestaAll::save_polltlf_cand($save_enctlf_id, $enctlf_ant);
            if ($save_enccan != false) {
                return 1;
            } else {
                return 3;
            }
        } else {
            return 2;
        }
    }

}
