<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;
use DB;
use App\Models\CmGustos;

class Principal extends Model {

    public $table = "encuesta_tlf";

    public static function menu() {

        $consulta = DB::table('categoria')
                ->join('posicion', 'posicion.id', '=', 'categoria.posicion_id')
                ->join('opcion', 'opcion.categoria_id', '=', 'categoria.id')
                ->leftJoin('candidato', 'candidato.categoria_id', '=', 'categoria.id')
                ->rightJoin('encuesta_web', 'encuesta_web.candidato_id', '=', 'candidato.id')
                ->leftJoin('encuesta', 'encuesta.id', '=', 'encuesta_web.encuesta_id')
                ->select(DB::raw('DISTINCT(categoria.id)'), DB::raw('initcap(categoria.nombre) AS nombrecategoria'), 'posicion.color', 'posicion.id AS posicion_id')
                ->whereRaw('encuesta.estatus = ?', 2)
                ->whereRaw('encuesta.tipo_encuesta = ?', 1)
                ->where('encuesta_web.estatus', 1)
                ->orderBy('posicion.id', 'asc')
                ->get();

        if (!sizeof($consulta) == 0) {

            foreach ($consulta as $categoria) {

                $params[] = $categoria;
            }

            return $params;
        }

        return false;
    }

    public static function consulbanner() {

        $consulta = DB::table('banner')
                ->select('banner.imagen')
                ->whereRaw('banner.estatus = ?', 1)
                ->orderBy('banner.posicion_id', 'asc')
                ->get();

        if (!sizeof($consulta) == 0) {

            foreach ($consulta as $frontend) {

                $params[] = $frontend;
            }

            return $params;
        }

        return false;
    }

    public static function extarerHomePrincipal() {

        $categorias = DB::table('categoria')
                ->join('posicion', 'posicion.id', '=', 'categoria.posicion_id')
                ->join('opcion', 'opcion.categoria_id', '=', 'categoria.id')
                ->leftJoin('candidato', 'candidato.categoria_id', '=', 'categoria.id')
                ->rightJoin('encuesta_web', 'encuesta_web.candidato_id', '=', 'candidato.id')
                ->leftJoin('encuesta', 'encuesta.id', '=', 'encuesta_web.encuesta_id')
                ->select(DB::raw('DISTINCT(categoria.id)'), 'posicion.id AS posicion_id')
                ->whereRaw('encuesta.estatus = ?', 2)
                ->whereRaw('encuesta.tipo_encuesta = ?', 1)
                ->where('encuesta_web.estatus', 1)
                ->orderBy('posicion.id', 'asc')
                ->get();
//dd('CATEGORIAS: ', $categorias);
        if (!sizeof($categorias) == 0) {

            $encuesta = DB::table('encuesta')
                    ->select('id')
                    ->whereRaw('estatus = ?', 2)
                    ->whereRaw('tipo_encuesta = ?', 1)
                    ->first();

            foreach ($categorias as $catg) {

                $params[] = DB::table('encuesta_web')
                        ->leftJoin('candidato', 'candidato.id', '=', 'encuesta_web.candidato_id')
                        ->leftJoin('encuesta', 'encuesta.id', '=', 'encuesta_web.encuesta_id')
                        ->select('encuesta_web.candidato_id')
                        ->whereRaw('encuesta.estatus = ?', 2)
                        ->whereRaw('encuesta.tipo_encuesta = ?', 1)
                        ->whereRaw('candidato.categoria_id = ?', [$catg->id])
                        ->orderBy('encuesta_web.posicion_act', 'asc')
                        ->get();

                if (isset(Session::get("usuario")->id)) {

                    $paramsvoto[] = DB::table('votos_usuario')
                            ->whereRaw('categoria_id = ?', $catg->id)
                            ->whereRaw('encuesta_id = ?', $encuesta)
                            ->whereRaw('usuario_id = ?', Session::get("usuario")->id)
                            ->count();
                } else {
                    $paramsvoto[] = 0;
                }
            }

            if (!sizeof($params) == 0) {
                foreach ($params as $catg) {

                    $candtos[] = $catg;
                }
                if (!sizeof($candtos) == 0) {
                    if ($candtos != false) {

                        $contador = count($candtos);

                        for ($a = 0; $a < $contador; $a++) {

                            foreach ($candtos[$a] as $key => $id) {

                                $consulta[$a][] = DB::table('candidato')
                                        ->join('encuesta_web', 'encuesta_web.candidato_id', '=', 'candidato.id')
                                        ->join('candidato_multimedia', 'candidato_multimedia.candidato_id', '=', 'candidato.id')
                                        ->leftJoin('candidato_genero', 'candidato_genero.candidato_id', '=', 'candidato.id')
                                        ->leftJoin('encuesta', 'encuesta.id', '=', 'encuesta_web.encuesta_id')
                                        ->leftJoin('genero', 'genero.id', '=', 'candidato_genero.genero_id')
                                        ->leftJoin('categoria', 'categoria.id', '=', 'candidato.categoria_id')
                                        ->join('opcion', 'opcion.categoria_id', '=', 'categoria.id')
                                        ->select('encuesta.tipo_encuesta', 'encuesta_web.encuesta_id', 'candidato.id', DB::raw('initcap(candidato.nombre) AS nombrecandidato'), 'candidato.categoria_id', DB::raw('CASE WHEN encuesta_web.puntaje > 0 THEN encuesta_web.puntaje  ELSE 0 END AS puntaje'), 'candidato_multimedia.img', 'candidato_multimedia.audio', 'candidato_multimedia.video', DB::raw('initcap(genero.nombre) AS nombregenero'), 'categoria.id AS idcategoria', 'categoria.nombre AS nombrecategoria', 'opcion.nombre AS opcionnombre', 'opcion.generoart AS opciongenero', 'opcion.img AS opcionimg', 'opcion.audio AS opcionaudio', 'opcion.video AS opcionvideo', 'encuesta_web.movimiento')
                                        ->whereRaw('candidato_multimedia.estatus = ?', 1)
                                        ->whereRaw('encuesta.estatus = ?', 2)
                                        ->whereRaw('encuesta.tipo_encuesta = ?', 1)
                                        ->whereRaw('candidato.id = ?', $id->candidato_id)
                                        ->orderBy('encuesta_web.posicion_act', 'asc')
                                        ->get();
                            }
                        }

                        if (!sizeof($consulta) == 0) {

                            for ($b = 0; $b < $contador; $b++) {

                                foreach ($consulta[$b] as $categoria) {

                                    foreach ($categoria as $cat) {
                                        $paramss[$cat->idcategoria][$cat->id]['categoria_id'] = $cat->idcategoria;
                                        $paramss[$cat->idcategoria][$cat->id]['encuesta_id'] = $cat->encuesta_id;
                                        $paramss[$cat->idcategoria][$cat->id]['tipo_encuesta'] = $cat->tipo_encuesta;
                                        $paramss[$cat->idcategoria][$cat->id]['nombre_categoria'] = $cat->nombrecategoria;
                                        $paramss[$cat->idcategoria][$cat->id]['id'] = $cat->id;
                                        $paramss[$cat->idcategoria][$cat->id]['nombrecandidato'] = $cat->nombrecandidato;
                                        $paramss[$cat->idcategoria][$cat->id]['movimiento'] = $cat->movimiento;
                                        $paramss[$cat->idcategoria][$cat->id]['puntaje'] = $cat->puntaje;
                                        $paramss[$cat->idcategoria][$cat->id]['img'] = $cat->img;
                                        $paramss[$cat->idcategoria][$cat->id]['audio'] = $cat->audio;
                                        $paramss[$cat->idcategoria][$cat->id]['video'] = $cat->video;
                                        $paramss[$cat->idcategoria][$cat->id]['opcionnombre'] = $cat->opcionnombre;
                                        $paramss[$cat->idcategoria][$cat->id]['opciongenero'] = $cat->opciongenero;
                                        $paramss[$cat->idcategoria][$cat->id]['opcionimg'] = $cat->opcionimg;
                                        $paramss[$cat->idcategoria][$cat->id]['opcionaudio'] = $cat->opcionaudio;
                                        $paramss[$cat->idcategoria][$cat->id]['opcionvideo'] = $cat->opcionvideo;
                                        $paramss[$cat->idcategoria][$cat->id]['generos'][] = $cat->nombregenero;
                                        $paramss[$cat->idcategoria][$cat->id]['votos'] = $paramsvoto[$b];
                                    }
                                }
                            }

                            if (!sizeof($paramss) == 0) {
                                foreach ($paramss as $catt) {

                                    foreach ($catt as $cattt) {

                                        $paramscc[$cattt['categoria_id']][] = $cattt;
                                    }
                                }
                                return $paramscc;
                            }
                        }
                    }
                }
            }
        }
        return false;
    }

    public static function consulCateg() {

        $consulta = DB::table('categoria')
                ->join('posicion', 'posicion.id', '=', 'categoria.posicion_id')
                ->join('opcion', 'opcion.categoria_id', '=', 'categoria.id')
                ->leftJoin('candidato', 'candidato.categoria_id', '=', 'categoria.id')
                ->rightJoin('encuesta_tlf', 'encuesta_tlf.candidato_id', '=', 'candidato.id')
                ->select(DB::raw('DISTINCT(categoria.id)'), DB::raw('initcap(categoria.nombre) AS nombrecategoria'), 'opcion.nombre', 'opcion.generoart', 'opcion.img', 'opcion.audio', 'opcion.video', 'posicion.id AS posicion_id')
                ->orderBy('posicion.id', 'asc')
                ->get();

        if (!sizeof($consulta) == 0) {

            foreach ($consulta as $categoria) {

                $params[] = $categoria;
            }

            return $params;
        }

        return false;
    }

    public static function consulCategId($id) {

        $consulta = DB::table('categoria')
                ->join('opcion', 'opcion.categoria_id', '=', 'categoria.id')
                ->select('categoria.id', 'opcion.img', 'opcion.audio', 'opcion.video', 'opcion.generoart')
                ->whereRaw('categoria.id = ?', [$id])
                ->orderBy('categoria.id', 'asc')
                ->get();

        if (!sizeof($consulta) == 0) {

            foreach ($consulta as $categoria) {

                $params[] = $categoria;
            }

            return $params;
        }

        return false;
    }

    public static function candweb($id) {

        $consulta = DB::table('encuesta_web')
                ->leftJoin('candidato', 'candidato.id', '=', 'encuesta_web.candidato_id')
                ->leftJoin('encuesta', 'encuesta.id', '=', 'encuesta_web.encuesta_id')
                ->select('encuesta_web.candidato_id')
                ->whereRaw('candidato.categoria_id = ?', [$id])
                ->whereRaw('encuesta.estatus = ?', 2)
                ->whereRaw('encuesta.tipo_encuesta = ?', 1)
                ->orderBy('encuesta_web.posicion_act', 'asc')
                ->get();

        if (!sizeof($consulta) == 0) {

            foreach ($consulta as $categoria) {

                $params[] = $categoria;
            }

            return $params;
        }

        return false;
    }

    public static function candtlf($id) {

        $consulta = DB::table('encuesta_tlf')
                ->leftJoin('candidato', 'candidato.id', '=', 'encuesta_tlf.candidato_id')
                ->leftJoin('encuesta', 'encuesta.id', '=', 'encuesta_tlf.encuesta_id')
                ->select('encuesta_tlf.candidato_id')
                ->whereRaw('candidato.categoria_id = ?', [$id])
                ->whereRaw('encuesta.estatus = ?', 2)
                ->whereRaw('encuesta.tipo_encuesta = ?', 2)
                ->orderBy('encuesta_tlf.puntaje_tlf', 'desc')
                ->get();

        if (!sizeof($consulta) == 0) {

            foreach ($consulta as $categoria) {

                $params[] = $categoria;
            }

            return $params;
        }

        return false;
    }

    public static function rankingweb($candtos) {

        if ($candtos != false) {
            foreach ($candtos as $key => $id) {

                $consulta[] = DB::table('candidato')
                        ->join('encuesta_web', 'encuesta_web.candidato_id', '=', 'candidato.id')
                        ->join('candidato_multimedia', 'candidato_multimedia.candidato_id', '=', 'candidato.id')
                        ->leftJoin('candidato_genero', 'candidato_genero.candidato_id', '=', 'candidato.id')
                        ->leftJoin('candidato_redes', 'candidato_redes.candidato_id', '=', 'candidato.id')
                        ->leftJoin('genero', 'genero.id', '=', 'candidato_genero.genero_id')
                        ->leftJoin('encuesta', 'encuesta.id', '=', 'encuesta_web.encuesta_id')
                        ->select('candidato_multimedia.id as candidato_multimedia_id', 'candidato.id', DB::raw('initcap(candidato.nombre) AS nombrecandidato'), 'candidato.detalle', 'candidato.sexo', 'candidato.pag', 'candidato.seguidores', DB::raw('CASE WHEN encuesta_web.puntaje > 0 THEN encuesta_web.puntaje  ELSE 0 END AS puntaje'), 'candidato_multimedia.img', 'candidato_multimedia.audio', 'candidato_multimedia.video', DB::raw('initcap(genero.nombre) AS nombregenero'), 'encuesta_web.encuesta_id', 'encuesta_web.movimiento', 'candidato_redes.nombre AS redessociales', 'genero.id AS genero_id', 'candidato_redes.id AS redes_id')
                        ->whereRaw('candidato_multimedia.estatus = ?', 1)
                        ->whereRaw('encuesta.estatus = ?', 2)
                        ->whereRaw('encuesta.tipo_encuesta = ?', 1)
                        ->whereRaw('candidato.id = ?', $id)
                        ->orderBy('encuesta_web.posicion_act', 'asc')
                        ->get();
            }

            if (!sizeof($consulta) == 0) {

                foreach ($consulta as $categoria) {

                    foreach ($categoria as $cat) {

                        $params[$cat->id]['candidato_multimedia_id'] = $cat->candidato_multimedia_id;
                        $params[$cat->id]['id'] = $cat->id;
                        $params[$cat->id]['encuesta_id'] = $cat->encuesta_id;
                        $params[$cat->id]['nombrecandidato'] = $cat->nombrecandidato;
                        $params[$cat->id]['detalle'] = $cat->detalle;
                        $params[$cat->id]['sexo'] = $cat->sexo;
                        $params[$cat->id]['pag'] = $cat->pag;
                        $params[$cat->id]['seguidores'] = $cat->seguidores;
                        $params[$cat->id]['puntaje'] = $cat->puntaje;
                        $params[$cat->id]['movimiento'] = $cat->movimiento;
                        $params[$cat->id]['img'] = $cat->img;
                        $params[$cat->id]['audio'] = $cat->audio;
                        $params[$cat->id]['video'] = $cat->video;
                        $params[$cat->id]['generos'][$cat->genero_id] = $cat->nombregenero;
                        $params[$cat->id]['redes'][$cat->redes_id] = $cat->redessociales;
                    }
                }
//dd($params);
                foreach ($params as $catt) {

                    $paramsc[] = $catt;
                }
                return $paramsc;
            }
        }
        return false;
    }

    public static function rankingtelf($candtos) {

        if ($candtos != false) {
            foreach ($candtos as $key => $id) {

                $consulta[] = DB::table('candidato')
                        ->join('encuesta_tlf', 'encuesta_tlf.candidato_id', '=', 'candidato.id')
                        ->join('candidato_multimedia', 'candidato_multimedia.candidato_id', '=', 'candidato.id')
                        ->leftJoin('candidato_genero', 'candidato_genero.candidato_id', '=', 'candidato.id')
                        ->leftJoin('candidato_redes', 'candidato_redes.candidato_id', '=', 'candidato.id')
                        ->leftJoin('genero', 'genero.id', '=', 'candidato_genero.genero_id')
                        ->leftJoin('encuesta', 'encuesta.id', '=', 'encuesta_tlf.encuesta_id')
                        ->select('encuesta_tlf.encuesta_id','candidato_multimedia.id as candidato_multimedia_id', 'candidato.id', DB::raw('initcap(candidato.nombre) AS nombrecandidato'), 'candidato.detalle', 'candidato.sexo', 'candidato.pag', 'candidato.seguidores', DB::raw('CASE WHEN encuesta_tlf.puntaje_tlf > 0 THEN encuesta_tlf.puntaje_tlf  ELSE 0 END AS puntaje'), 'candidato_multimedia.img', 'candidato_multimedia.audio', 'candidato_multimedia.video', DB::raw('initcap(genero.nombre) AS nombregenero'), 'candidato_redes.nombre AS redessociales', 'genero.id AS genero_id', 'candidato_redes.id AS redes_id')
                        ->whereRaw('candidato_multimedia.estatus = ?', 1)
                        ->whereRaw('encuesta.estatus = ?', 2)
                        ->whereRaw('encuesta.tipo_encuesta = ?', 2)
                        ->whereRaw('candidato.id = ?', $id)
                        ->orderBy('encuesta_tlf.puntaje_tlf', 'desc')
                        ->get();
            }
            if (!sizeof($consulta) == 0) {

                foreach ($consulta as $categoria) {

                    foreach ($categoria as $cat) {

                        $params[$cat->id]['candidato_multimedia_id'] = $cat->candidato_multimedia_id;
                        $params[$cat->id]['id'] = $cat->id;
                        $params[$cat->id]['encuesta_id'] = $cat->encuesta_id;
                        $params[$cat->id]['nombrecandidato'] = $cat->nombrecandidato;
                        $params[$cat->id]['detalle'] = $cat->detalle;
                        $params[$cat->id]['sexo'] = $cat->sexo;
                        $params[$cat->id]['pag'] = $cat->pag;
                        $params[$cat->id]['seguidores'] = $cat->seguidores;
                        $params[$cat->id]['puntaje'] = $cat->puntaje;
                        $params[$cat->id]['img'] = $cat->img;
                        $params[$cat->id]['audio'] = $cat->audio;
                        $params[$cat->id]['video'] = $cat->video;
                        $params[$cat->id]['generos'][$cat->genero_id] = $cat->nombregenero;
                        $params[$cat->id]['redes'][$cat->redes_id] = $cat->redessociales;
                    }
                }
                foreach ($params as $catt) {

                    $paramsc[] = $catt;
                }
                return $paramsc;
            }
        }
        return false;
    }

    public static function buscavideo($id, $encuesta_id,$opt) {

        $consulta = DB::table('candidato')
                ->join('candidato_multimedia', 'candidato_multimedia.candidato_id', '=', 'candidato.id')
                ->leftJoin('candidato_genero', 'candidato_genero.candidato_id', '=', 'candidato.id')
                ->leftJoin('candidato_redes', 'candidato_redes.candidato_id', '=', 'candidato.id')
                ->leftJoin('genero', 'genero.id', '=', 'candidato_genero.genero_id')
                ->select('candidato_multimedia.id as candidato_multimedia_id', 'candidato.categoria_id', 'candidato.nombre AS nombrecandidato', 'candidato.detalle', 'candidato.sexo', 'candidato.pag', 'candidato.seguidores', 'candidato_multimedia.img', 'candidato_multimedia.video', DB::raw('initcap(genero.nombre) AS nombregenero'), 'candidato_redes.nombre AS redessociales', 'genero.id AS genero_id', 'candidato_redes.id AS redes_id')
                ->whereRaw('candidato.id = ?', [$id])
                ->whereRaw('candidato_multimedia.estatus = ?', 1)
                ->get();

        $gusta = DB::table('cm_gustos as cmg')
                ->whereRaw('cmg.encuesta_id = ?', [$encuesta_id])
                ->whereRaw('cmg.candidato_id = ?', [$id])
                ->where('cmg.gusto', "=", 1) //1 me gusta
                ->count();
        $no_gusta = DB::table('cm_gustos as cmg')
                ->whereRaw('cmg.encuesta_id = ?', [$encuesta_id])
                ->whereRaw('cmg.candidato_id = ?', [$id])
                ->where('cmg.gusto', "=", 2) //1 no me gusta
                ->count();

            if($opt==1){//video web
                $tipo_multimedia= 2; //video
            }else if($opt==2){//video tlf
                $tipo_multimedia= 2; //video
            }
            else if($opt==3){//imagen web
                $tipo_multimedia= 1; //imagen
            }else if($opt==4){//imagen tlf
                $tipo_multimedia= 1; //imagen
            }

        if (!sizeof($consulta) == 0) {

            foreach ($consulta as $categoria) {
                $params['nombre'] = $categoria->nombrecandidato;
                $params['detalle'] = $categoria->detalle;
                $params['sexo'] = $categoria->sexo;
                $params['pag'] = $categoria->pag;
                $params['seguidores'] = $categoria->seguidores;
                $params['img'] = $categoria->img;
                $params['video'] = $categoria->video;
                $params['generos'][$categoria->genero_id] = $categoria->nombregenero;
                $params['redes'][$categoria->redes_id] = $categoria->redessociales;
                $params['gusta'] = $gusta;
                $params['no_me_gusta'] = $no_gusta;
                $params['candidato_multimedia_id'] = $categoria->candidato_multimedia_id;
                $params['categoria_id'] = $categoria->categoria_id;
                if(isset(Session::get("usuario")->id)){
                $gusto_user=CmGustos::get_feeling_byUser($encuesta_id,$params['categoria_id'],$params['candidato_multimedia_id'],$id,$tipo_multimedia, Session::get("usuario")->id);
                    if($gusto_user!=null){
                        $params['gusto_usuario'] = $gusto_user->gusto;
                    }else{
                        $params['gusto_usuario'] = null;
                    }
                }else{
                    $params['gusto_usuario'] = null;
                }
            }
            return $params;
        }

        return false;
    }

    public static function buscaraudio($id) {

        $consulta = DB::table('candidato')
                ->join('candidato_multimedia', 'candidato_multimedia.candidato_id', '=', 'candidato.id')
                ->select('candidato.nombre', 'candidato_multimedia.audio')
                ->whereRaw('candidato.id = ?', [$id])
                ->whereRaw('candidato_multimedia.estatus = ?', 1)
                ->get();

        if (!sizeof($consulta) == 0) {

            foreach ($consulta as $categoria) {

                $params[] = $categoria;
            }

            return $params;
        }

        return false;
    }

    public static function buscarvotos($id) {

        if (isset(Session::get("usuario")->id)) {

            $encuesta = DB::table('encuesta')
                    ->select('id')
                    ->whereRaw('estatus = ?', 2)
                    ->whereRaw('tipo_encuesta = ?', 1)
                    ->first();

            return DB::table('votos_usuario')
                            ->whereRaw('categoria_id = ?', $id)
                            ->whereRaw('encuesta_id = ?', $encuesta)
                            ->whereRaw('usuario_id = ?', Session::get("usuario")->id)
                            ->count();
        } else {
            return false;
        }
    }

}
