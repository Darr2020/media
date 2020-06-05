<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;
use App\Models\Posicion;
use App\Models\Votacion;

Class EncuestaAll extends Model {

    public static function existeEnPosicion($id) {
        return DB::table('posicion as p')
                        ->whereRaw('p.id = ?', [$id])
                        ->select('p.*')->count();
    }

//MOD 22102018 
    public static function getCategoriasPorEncuestaWeb($encuesta_id) {
        $ec_categ = DB::table('encuesta_web as ew')
                ->join('candidato as ca', 'ew.candidato_id', '=', 'ca.id')
                ->join('categoria as c', 'ew.categoria_id', '=', 'c.id')
                ->join('encuesta as e', 'ew.encuesta_id', '=', 'e.id')
                ->select('ew.categoria_id', 'c.nombre')
                ->where('e.tipo_encuesta', "=", 1)
                ->whereRaw('ew.encuesta_id = ?', [$encuesta_id])
                ->groupBy('ew.categoria_id', 'c.nombre')
                ->orderBy('ew.categoria_id', 'asc')
                ->get();

        if (!sizeof($ec_categ) == 0) {
            foreach ($ec_categ as $ecc) {
                $params[] = $ecc;
            }
            return $params;
        }
        return null;
    }

    public static function getBanderaEncuesta($encuesta_id) {
        $be = DB::table('encuesta as e')
                ->select('e.bandera')
                ->whereRaw('e.id = ?', [$encuesta_id])
                ->get();
        if (!sizeof($be) == 0) {
            foreach ($be as $b) {
                $params[] = $b;
            }
            return $params;
        }
        return null;
    }

    //MOD 20102018
    public static function ExisteEnEncuestaTlfByEncCand($encuesta_id, $categoria_id, $candidato_id) {
        return DB::table('encuesta_tlf as et')
                        ->whereRaw('et.encuesta_id = ?', [$encuesta_id])
                        ->whereRaw('et.categoria_id = ?', [$categoria_id])
                        ->whereRaw('et.candidato_id = ?', [$candidato_id])
                        ->select('et.*')->count();
    }

    //MOD 22102018
    public static function ExisteEnEncuestaWebByEncCatCand($encuesta_id, $categoria_id, $candidato_id) {
        return DB::table('encuesta_web as ew')
                        ->whereRaw('ew.encuesta_id = ?', [$encuesta_id])
                        ->whereRaw('ew.categoria_id = ?', [$categoria_id])
                        ->whereRaw('ew.candidato_id = ?', [$candidato_id])
                        ->select('ew.*')->count();
    }

    public static function ExisteEnEncuestaCandidato($encuesta_id) {
        return DB::table('encuesta_candidato as ec')
                        ->whereRaw('ec.encuesta_id = ?', [$encuesta_id])
                        ->select('ec.*')->count();
    }

    public static function ExisteEnEncuestaTlf($encuesta_id) {
        return DB::table('encuesta_tlf as et')
                        ->whereRaw('et.encuesta_id = ?', [$encuesta_id])
                        ->select('et.*')->count();
    }

   public static function ExisteEnEncuestaWeb($encuesta_id) {
        return DB::table('encuesta_web as ew')
                        ->whereRaw('ew.encuesta_id = ?', [$encuesta_id])
                        ->select('ew.*')->count();
    }

    //MOD 22102018
    public static function getEncuestaWeb($encuesta_id, $categoria_id, $candidato_id) {
        return DB::table('encuesta_web as ew')
                        ->whereRaw('ew.encuesta_id = ?', [$encuesta_id])
                        ->whereRaw('ew.categoria_id = ?', [$categoria_id])
                        ->whereRaw('ew.candidato_id = ?', [$candidato_id])
                        ->first();
    }

//MOD 21102018
    public static function getUltimaEncuestaTlf() {
        return DB::table('encuesta as e')
                        ->where('e.tipo_encuesta', "=", 2)
                        ->orderBy('e.id', 'asc')
                        ->get();
    }



    public static function getAllPollWeb() {
        $info_enc = DB::table('encuesta as e')
                ->select('e.*')
                ->where('e.tipo_encuesta', "=", 1)
                ->get();
        if (!sizeof($info_enc) == 0) {
            foreach ($info_enc as $ienc) {
                $params[] = $ienc;
            }
            return $params;
        }
        return false;
    }

    //MOD 21102018
    public static function getAllEncTlfParaWebByEncId($encuesta_id) {
        return DB::table('encuesta_tlf as et')
                        ->join('candidato as ca', 'et.candidato_id', '=', 'ca.id')
                        ->join('categoria as c', 'et.categoria_id', '=', 'c.id')
                        ->select('et.candidato_id', 'et.categoria_id', 'et.puntaje_tlf')
                        ->whereRaw('et.encuesta_id = ?', [$encuesta_id])
//                        ->where('ca.estatus', "=", 1)
//                        ->where('c.estatus', "=", 1)
                        ->get();
    }

    //MOD 21102018
    public static function getInfoPollById($encuesta_id) {
        return DB::table('encuesta as e')
                        ->whereRaw('e.id = ?', [$encuesta_id])
                        ->first();
    }

    public static function getAllCategoriasWithCand() {
        $info_categ = DB::table('candidato as ca')
                ->join('categoria as c', 'ca.categoria_id', '=', 'c.id')
                ->select('ca.categoria_id', 'c.nombre as categoria')
                ->where('ca.estatus', "=", 1)
                ->where('c.estatus', "=", 1)
                ->groupBy('ca.categoria_id', 'c.nombre')
                ->orderBy('c.nombre', 'asc')
                ->get();

        if (!sizeof($info_categ) == 0) {
            foreach ($info_categ as $icat) {
                $params[] = $icat;
            }
            return $params;
        }
        return false;
    }

    //MOD 20102018
    public static function traer_categorias_activas_order_by_id() {
        $all_categ = DB::table('candidato as ca')
                ->join('categoria as c', 'ca.categoria_id', '=', 'c.id')
                ->select('ca.categoria_id', 'c.nombre as nom_categoria')
                ->where('ca.estatus', "=", 1)
                ->where('c.estatus', "=", 1)
                ->groupBy('ca.categoria_id', 'c.nombre')
                ->orderBy('ca.categoria_id', 'asc')
                ->get();

        if (!sizeof($all_categ) == 0) {
            foreach ($all_categ as $acat) {
                $params[] = $acat;
            }
            return $params;
        }
        return false;
    }

    public static function getAllPollTlf() {
        $info_enc = DB::table('encuesta as e')
                ->select('e.*')
                ->where('e.tipo_encuesta', "=", 2)
                ->get();
        if (!sizeof($info_enc) == 0) {
            foreach ($info_enc as $ienc) {
                $params[] = $ienc;
            }
            return $params;
        }
        return false;
    }

    public static function getCandByCategoriaId($id) {
        $info_cand_categ = DB::table('candidato as ca')
                ->join('categoria as c', 'ca.categoria_id', '=', 'c.id')
                ->select('ca.id', 'ca.categoria_id', 'ca.nombre', 'ca.detalle', 'ca.sexo', 'ca.pag', 'ca.estatus', 'c.nombre as nom_categoria')
                ->whereRaw('ca.categoria_id = ?', [$id])
                ->where('ca.estatus', "=", 1)
                ->where('c.estatus', "=", 1)
                ->orderBy('ca.id', 'asc')
                ->get();
        if (!sizeof($info_cand_categ) == 0) {
            foreach ($info_cand_categ as $icandcat) {
                $params[] = $icandcat;
            }
            return $params;
        }
        return null;
    }

    public static function getDataCategoriaById($id) {
        return DB::table('categoria as c')
                        ->whereRaw('c.id = ?', [$id])
                        ->first();
    }

    public static function getDataCandidatoById($id) {
        return DB::table('candidato as ca')
                        ->whereRaw('ca.id = ?', [$id])
                        ->first();
    }

    //MOD 20102018
    public static function getDataEncuestaTlfCandidato($categoria_id, $encuesta_id) {
        $info_enc_can = DB::table('encuesta_tlf as et')
                ->join('candidato as ca', 'et.candidato_id', '=', 'ca.id')
                ->join('categoria as c', 'et.categoria_id', '=', 'c.id')
                ->join('categoria as cat', 'ca.categoria_id', '=', 'cat.id')
                ->join('encuesta as e', 'et.encuesta_id', '=', 'e.id')
                ->select('et.encuesta_id', 'et.candidato_id', 'et.puntaje_tlf', 'ca.nombre as nombre_candidato', 'ca.categoria_id', 'c.nombre as nombre_categoria')
                ->whereRaw('et.categoria_id = ?', [$categoria_id])
                ->whereRaw('ca.categoria_id = ?', [$categoria_id])
                ->whereRaw('et.encuesta_id = ?', [$encuesta_id])
//                ->where('ca.estatus', "=", 1)
//                ->where('c.estatus', "=", 1)
//                ->where('e.estatus', "=", 1)
                ->orderBy('et.candidato_id', 'asc')
                ->get();
        if (!sizeof($info_enc_can) == 0) {
            foreach ($info_enc_can as $ienccan) {
                $params[] = $ienccan;
            }
            return $params;
        }
        return null;
    }

    public static function getDataEncuestaCandidato($categoria_id, $encuesta_id) {
        $info_enc_can = DB::table('encuesta_web as ew')
                ->join('candidato as ca', 'ew.candidato_id', '=', 'ca.id')
                ->join('categoria as c', 'ew.categoria_id', '=', 'c.id')
                ->join('encuesta as e', 'ew.encuesta_id', '=', 'e.id')
                ->select('ew.encuesta_id', 'ew.candidato_id', 'ew.puntaje', 'ca.nombre as nombre_candidato', 'ew.categoria_id', 'c.nombre as nombre_categoria')
                ->whereRaw('ew.categoria_id = ?', [$categoria_id])
                ->whereRaw('ew.encuesta_id = ?', [$encuesta_id])
                ->where('e.tipo_encuesta', "=", 1)
                ->orderBy('ew.candidato_id', 'asc')
                ->get();
        if (!sizeof($info_enc_can) == 0) {
            foreach ($info_enc_can as $ienccan) {
                $params[] = $ienccan;
            }
            return $params;
        }
        return null;
    }

    //MOD 20102018
    public static function getExisteEnEncuestaTlf($categoria_id, $encuesta_id) {
        return DB::table('encuesta_tlf as et')
                        ->join('categoria as c', 'et.categoria_id', '=', 'c.id')
                        ->whereRaw('et.categoria_id = ?', [$categoria_id])
                        ->whereRaw('et.encuesta_id = ?', [$encuesta_id])
                        ->select('et.*')->count();
    }

    //MOD 21102018
    public static function getExisteEnEncuestaWeb($categoria_id, $encuesta_id) {
        return DB::table('encuesta_web as ew')
                        ->join('candidato as ca', 'ew.candidato_id', '=', 'ca.id')
                        ->join('categoria as c', 'ew.categoria_id', '=', 'c.id')
                        ->join('encuesta as e', 'ew.encuesta_id', '=', 'e.id')
                        ->whereRaw('ew.categoria_id = ?', [$categoria_id])
                        ->whereRaw('ew.encuesta_id = ?', [$encuesta_id])
                        ->where('e.tipo_encuesta', "=", 1)
                        ->select('ec.*')->count();
    }

    //MOD 20102018
    public static function getDataCandScoreByCategoriaOnly($categoria_id) {
        $enc_can = DB::table('candidato as ca')
                ->join('categoria as c', 'ca.categoria_id', '=', 'c.id')
                ->select('ca.id', 'ca.categoria_id', 'ca.nombre', 'ca.detalle', 'ca.sexo', 'ca.pag', 'ca.estatus', 'c.nombre as nom_categoria')
                ->whereRaw('ca.categoria_id = ?', [$categoria_id])
//                ->where('ca.estatus', "=", 1)
//                ->where('c.estatus', "=", 1)
                ->orderBy('ca.id', 'asc')
                ->get();
        if (!sizeof($enc_can) == 0) {
            foreach ($enc_can as $eco) {
                $params[] = $eco;
            }
            return $params;
        }
        return null;
    }

    public static function getDataCandScoreByCategoriaPoll($categoria_id) {
        $enc_can_ptos = DB::table('candidato as ca')
                ->join('categoria as c', 'ca.categoria_id', '=', 'c.id')
                ->leftJoin('encuesta_candidato as ec', 'ec.candidato_id', '=', 'ca.id')
                ->select('ca.id', 'ca.categoria_id', 'ca.nombre', 'ca.detalle', 'ca.sexo', 'ca.pag', 'ca.estatus', 'c.nombre as nom_categoria', 'ec.puntaje_tlf', 'ec.puntaje_web')
                ->whereRaw('ca.categoria_id = ?', [$categoria_id])
                ->where('ca.estatus', "=", 1)
                ->where('c.estatus', "=", 1)
                ->orderBy('ec.candidato_id', 'asc')
                ->get();
        if (!sizeof($enc_can_ptos) == 0) {
            foreach ($enc_can_ptos as $ecp) {
                $params[] = $ecp;
            }
            return $params;
        }
        return null;
    }

    public static function getDataCandScoreByCategoria2($categoria_id, $encuesta_id) {
        $enc_can_ptos = DB::table('candidato as ca')
                ->join('categoria as c', 'ca.categoria_id', '=', 'c.id')
                ->leftJoin('encuesta_candidato as ec', 'ec.candidato_id', '=', 'ca.id')
                ->join('encuesta as e', 'ec.encuesta_id', '=', 'e.id')
                ->select('ca.id', 'ca.categoria_id', 'ca.nombre', 'ca.detalle', 'ca.sexo', 'ca.pag', 'ca.estatus', 'c.nombre as nom_categoria', 'ec.puntaje_tlf', 'ec.puntaje_web')
                ->whereRaw('ca.categoria_id = ?', [$categoria_id])
                ->whereRaw('e.id = ?', [$encuesta_id])
                ->where('ca.estatus', "=", 1)
                ->where('c.estatus', "=", 1)
                ->orderBy('ec.candidato_id', 'asc')
                ->get();
        if (!sizeof($enc_can_ptos) == 0) {
            foreach ($enc_can_ptos as $ecp) {
                $params[] = $ecp;
            }
            return $params;
        }
        return null;
    }

    //MOD 20102018
    public static function getDataPollTlfCandByCategoria($encuesta_id, $categoria_id) {
        $enc_categoria = DB::table('encuesta_tlf as et')
                ->join('candidato as ca', 'et.candidato_id', '=', 'ca.id')
                ->join('categoria as c', 'et.categoria_id', '=', 'c.id')
                ->join('encuesta as e', 'et.encuesta_id', '=', 'e.id')
                ->select('et.encuesta_id', 'et.candidato_id', 'et.puntaje_tlf', 'ca.nombre as nom_candidato', 'ca.detalle', 'ca.sexo', 'ca.pag', 'ca.seguidores', 'et.categoria_id', 'c.nombre as nom_categoria')
                ->whereRaw('et.encuesta_id = ?', [$encuesta_id])
                ->whereRaw('et.categoria_id = ?', [$categoria_id])
                ->where('e.tipo_encuesta', "=", 2)
                ->orderBy('et.categoria_id', 'asc')
                ->orderBy('et.candidato_id', 'asc')
                ->get();
        if (!sizeof($enc_categoria) == 0) {
            foreach ($enc_categoria as $enccat) {
                $params[] = $enccat;
            }
            return $params;
        }
        return null;
    }

    //MOD 21102018
    public static function getDataPollWebCandByCategoria($encuesta_id, $categoria_id) {
        $enc_categoria = DB::table('encuesta_web as ew')
                ->join('candidato as ca', 'ew.candidato_id', '=', 'ca.id')
                ->join('categoria as c', 'ew.categoria_id', '=', 'c.id')
                ->join('encuesta as e', 'ew.encuesta_id', '=', 'e.id')
                ->select('ew.encuesta_id', 'ew.candidato_id', 'ew.puntaje', 'ca.nombre as nom_candidato', 'ca.detalle', 'ca.sexo', 'ca.pag', 'ca.seguidores', 'ca.categoria_id', 'c.nombre as nom_categoria')
                ->whereRaw('ew.encuesta_id = ?', [$encuesta_id])
                ->whereRaw('ew.categoria_id = ?', [$categoria_id])
                ->where('e.tipo_encuesta', "=", 1)
                ->orderBy('ew.categoria_id', 'asc')
                ->orderBy('ew.candidato_id', 'asc')
                ->get();
        if (!sizeof($enc_categoria) == 0) {
            foreach ($enc_categoria as $enccat) {
                $params[] = $enccat;
            }
            return $params;
        }
        return null;
    }

    //MOD 20102018
    public static function countCandidatosPorCategoria($categoria_id) {
        return DB::table('candidato as ca')
                        ->join('categoria as c', 'ca.categoria_id', '=', 'c.id')
                        ->whereRaw('ca.categoria_id = ?', [$categoria_id])
//                        ->where('ca.estatus', "=", 1)
//                        ->where('c.estatus', "=", 1)
                        ->select('ca.*')->count();
    }

    //MOD 20102018
    public static function sumaPuntosTlf($encuesta_id, $categoria_id) {
        $suma_ptos_tlf = DB::table('encuesta_tlf as et')
                ->join('candidato as ca', 'et.candidato_id', '=', 'ca.id')
                ->join('categoria as c', 'et.categoria_id', '=', 'c.id')
                ->join('encuesta as e', 'et.encuesta_id', '=', 'e.id')
                ->select(DB::raw('SUM(et.puntaje_tlf) as puntos_enc_tlf'))
                ->whereRaw('et.encuesta_id = ?', [$encuesta_id])
                ->whereRaw('et.categoria_id = ?', [$categoria_id])
//                ->where('ca.estatus', "=", 1)
//                ->where('c.estatus', "=", 1)
//                ->where('e.publicar', "=", false)
                ->get();

        if (!sizeof($suma_ptos_tlf) == 0) {
            foreach ($suma_ptos_tlf as $suma) {
                $params[] = $suma;
            }
            return $params;
        }
        return null;
    }

    //MOD 21102018
    public static function sumaPuntosWeb($encuesta_id, $categoria_id) {
        $suma_ptos_web = DB::table('encuesta_web as ew')
                ->join('candidato as ca', 'ew.candidato_id', '=', 'ca.id')
                ->join('categoria as c', 'ew.categoria_id', '=', 'c.id')
                ->join('encuesta as e', 'ew.encuesta_id', '=', 'e.id')
                ->select(DB::raw('SUM(ew.puntaje) as puntaje'), 'e.bandera')
                ->whereRaw('ew.encuesta_id = ?', [$encuesta_id])
                ->whereRaw('ew.categoria_id = ?', [$categoria_id])
                ->groupBy('e.bandera')
                ->get();

        if (!sizeof($suma_ptos_web) == 0) {
            foreach ($suma_ptos_web as $suma) {
                $params[] = $suma;
            }
            return $params;
        }
        return null;
    }

    //MOD 20102018
    public static function countPuntosCandidatosPorCategoria($categoria_id) {
        $ppt = DB::table('candidato as ca')
                ->join('categoria as c', 'ca.categoria_id', '=', 'c.id')
                ->join('encuesta_tlf as et', 'et.candidato_id', '=', 'ca.id')
                ->join('encuesta as e', 'et.encuesta_id', '=', 'e.id')
                ->select(DB::raw('COUNT(et.puntaje_tlf) AS puntaje_tlf'))
                ->whereRaw('ca.categoria_id = ?', [$categoria_id])
//                ->where('ca.estatus', "=", 1)
//                ->where('c.estatus', "=", 1)
//                ->where('e.publicar', "=", false)
                ->get();
        if (!sizeof($ppt) == 0) {
            foreach ($ppt as $rt) {
                $params[] = $rt;
            }
            return $params;
        }

        return false;
    }

    //MOD 21102018
    public static function countPuntosCandidatosPorCategoriaWeb($categoria_id) {
        $pp = DB::table('candidato as ca')
                ->join('categoria as c', 'ca.categoria_id', '=', 'c.id')
                ->join('encuesta_web as ew', 'ew.candidato_id', '=', 'ca.id')
                ->join('encuesta as e', 'ew.encuesta_id', '=', 'e.id')
                ->select(DB::raw('COUNT(ew.puntaje) AS puntaje_web'))
                ->whereRaw('ca.categoria_id = ?', [$categoria_id])
                ->where('e.tipo_encuesta', "=", 1)
                ->where('e.bandera', "=", 1)
                ->get();
        if (!sizeof($pp) == 0) {
            foreach ($pp as $r) {
                $params[] = $r;
            }
            return $params;
        }

        return false;
    }

    //MOD 21102018
    public static function countOrdenCandidatosPorCategoria($categoria_id) {
        return DB::table('candidato as ca')
                        ->join('categoria as c', 'ca.categoria_id', '=', 'c.id')
                        ->join('encuesta_web as ew', 'ew.candidato_id', '=', 'ca.id')
                        ->join('encuesta as e', 'ew.encuesta_id', '=', 'e.id')
                        ->whereRaw('ca.categoria_id = ?', [$categoria_id])
                        ->where('e.tipo_encuesta', "=", 1)
                        ->where('e.bandera', "=", 2)
                        ->select('ew.puntaje')->count();
    }

    //MOD 20102018
    public static function countEncuestaTlfSinPublicar() {
        return DB::table('encuesta as e')
                        ->where('e.estatus', "=", 1)
                        ->where('e.tipo_encuesta', "=", 2)
                        ->select('e.*')->count();
    }

//MOD 21102018
    public static function countEncuestaWebSinPublicar() {
        return DB::table('encuesta as e')
                        ->where('e.estatus', "=", 1)
                        ->where('e.tipo_encuesta', "=", 1)
                        ->select('e.*')->count();
    }

    //MOD 20102018
    public static function countPuntosCandidatosPorEncuestaTlf($encuesta_id) {
        $cant_pcand = DB::table('candidato as ca')
                ->join('categoria as c', 'ca.categoria_id', '=', 'c.id')
                ->join('encuesta_tlf as et', 'et.candidato_id', '=', 'ca.id')
                ->join('encuesta as e', 'et.encuesta_id', '=', 'e.id')
                ->select('ca.categoria_id', 'c.nombre as nom_categoria','et.estatus as estatus_cat_enctlf', DB::raw('COUNT(et.puntaje_tlf) AS candidatos_con_puntos'))
                ->whereRaw('et.encuesta_id = ?', [$encuesta_id])
                ->where('ca.estatus', "=", 1)
                ->where('c.estatus', "=", 1)
                ->groupBy('ca.categoria_id', 'nom_categoria','estatus_cat_enctlf')
                ->orderBy('ca.categoria_id', 'asc')
                ->get();

        if (!sizeof($cant_pcand) == 0) {
            foreach ($cant_pcand as $cpcand) {
                $params[] = $cpcand;
            }
            return $params;
        }

        return null;
    }

    public static function countPuntosCandidatosPorEncuestaTlfActivas($encuesta_id) {
        $cant_pcand = DB::table('candidato as ca')
                ->join('categoria as c', 'ca.categoria_id', '=', 'c.id')
                ->join('encuesta_tlf as et', 'et.candidato_id', '=', 'ca.id')
                ->join('encuesta as e', 'et.encuesta_id', '=', 'e.id')
                ->select('ca.categoria_id', 'c.nombre as nom_categoria','et.estatus as estatus_cat_enctlf', DB::raw('COUNT(et.puntaje_tlf) AS candidatos_con_puntos'))
                ->whereRaw('et.encuesta_id = ?', [$encuesta_id])
                ->where('ca.estatus', "=", 1)
                ->where('c.estatus', "=", 1)
                ->where('et.estatus', "=", 1)
                ->groupBy('ca.categoria_id', 'nom_categoria','estatus_cat_enctlf')
                ->orderBy('ca.categoria_id', 'asc')
                ->get();

        if (!sizeof($cant_pcand) == 0) {
            foreach ($cant_pcand as $cpcand) {
                $params[] = $cpcand;
            }
            return $params;
        }

        return null;
    }


    //MOD 21102018
    public static function countPuntosCandidatosPorEncuestaWeb($encuesta_id) {
        $cant_pcand = DB::table('candidato as ca')
                ->join('categoria as c', 'ca.categoria_id', '=', 'c.id')
                ->join('encuesta_web as ew', 'ew.candidato_id', '=', 'ca.id')
                ->join('encuesta as e', 'ew.encuesta_id', '=', 'e.id')
                ->select('ew.encuesta_id', 'ca.categoria_id', 'c.nombre as nom_categoria', 'e.bandera','ew.estatus as estatus_cat_encweb', DB::raw('COUNT(ew.puntaje) AS candidatos_con_puntos'))
                ->whereRaw('ew.encuesta_id = ?', [$encuesta_id])
                ->where('ca.estatus', "=", 1)
                ->where('c.estatus', "=", 1)
                ->groupBy('ew.encuesta_id', 'ca.categoria_id', 'nom_categoria', 'e.bandera','estatus_cat_encweb')
                ->orderBy('ca.categoria_id', 'asc')
                ->get();

        if (!sizeof($cant_pcand) == 0) {
            foreach ($cant_pcand as $cpcand) {
                $params[] = $cpcand;
            }
            return $params;
        }

        return null;
    }


    public static function countPuntosCandidatosPorEncuestaWebActivas($encuesta_id) {
        $cant_pcand = DB::table('candidato as ca')
                ->join('categoria as c', 'ca.categoria_id', '=', 'c.id')
                ->join('encuesta_web as ew', 'ew.candidato_id', '=', 'ca.id')
                ->join('encuesta as e', 'ew.encuesta_id', '=', 'e.id')
                ->select('ew.encuesta_id', 'ca.categoria_id', 'c.nombre as nom_categoria', 'e.bandera','ew.estatus as estatus_cat_encweb', DB::raw('COUNT(ew.puntaje) AS candidatos_con_puntos'))
                ->whereRaw('ew.encuesta_id = ?', [$encuesta_id])
                ->where('ca.estatus', "=", 1)
                ->where('c.estatus', "=", 1)
                ->where('ew.estatus', "=", 1)
                ->groupBy('ew.encuesta_id', 'ca.categoria_id', 'nom_categoria', 'e.bandera','estatus_cat_encweb')
                ->orderBy('ca.categoria_id', 'asc')
                ->get();

        if (!sizeof($cant_pcand) == 0) {
            foreach ($cant_pcand as $cpcand) {
                $params[] = $cpcand;
            }
            return $params;
        }

        return null;
    }




    //MOD 21102018
    public static function countOrdenCandidatosPorEncuestaWeb($encuesta_id) {
        $cant_ocand = DB::table('encuesta_web as ew')
                ->join('candidato as ca', 'ew.candidato_id', '=', 'ca.id')
                ->join('encuesta as e', 'ew.encuesta_id', '=', 'e.id')
                ->join('categoria as c', 'ca.categoria_id', '=', 'c.id')
                ->select('ew.encuesta_id', 'ca.categoria_id', 'c.nombre as nom_categoria', DB::raw('COUNT(ew.puntaje) AS candidatos_con_orden'))
                ->whereRaw('ew.encuesta_id = ?', [$encuesta_id])
//                ->where('ca.estatus', "=", 1)
//                ->where('c.estatus', "=", 1)
//                ->where('e.publicar', "=", false)
                ->where('e.bandera', "=", 2)
                ->groupBy('ew.encuesta_id', 'ca.categoria_id', 'nom_categoria')
                ->orderBy('ca.categoria_id', 'asc')
                ->get();
        if (!sizeof($cant_ocand) == 0) {
            foreach ($cant_ocand as $cpcand) {
                $params[] = $cpcand;
            }
            return $params;
        }

        return null;
    }

    //MOD 21102018
    public static function countOrdenCandidatosPorEncuestaWeb2($encuesta_id) {
        $cant_ocand = DB::table('encuesta_web as ew')
                ->join('encuesta as e', 'ew.encuesta_id', '=', 'e.id')
                ->select('ew.encuesta_id', DB::raw('COUNT(ew.puntaje) AS candidatos_con_orden'))
                ->whereRaw('ew.encuesta_id = ?', [$encuesta_id])
                ->where('e.tipo_encuesta', "=", 1)
                ->where('e.bandera', "=", 2)
                ->groupBy('ew.encuesta_id')
                ->get();
        if (!sizeof($cant_ocand) == 0) {
            foreach ($cant_ocand as $cpcand) {
                $params[] = $cpcand;
            }
            return $params;
        }

        return false;
    }

    //MOD 20102018
    public static function getDataCandidatoByPoll($encuesta_id) {
        $data_enca = DB::table('encuesta_tlf as et')
                ->join('encuesta as e', 'et.encuesta_id', '=', 'e.id')
                ->join('candidato as ca', 'et.candidato_id', '=', 'ca.id')
                ->join('categoria as c', 'ca.categoria_id', '=', 'c.id')
                ->select('et.candidato_id', 'ca.nombre as nom_candidato', 'ca.detalle as det_candidato', 'et.puntaje_tlf', 'et.categoria_id', 'c.nombre as nom_categoria', 'c.descateg as desc_categoria')
                ->whereRaw('et.encuesta_id = ?', [$encuesta_id])
                ->where('et.estatus', "=", 1)
                ->where('e.tipo_encuesta', "=", 2)
                ->orderBy('nom_candidato', 'asc')
                ->get();

        if (!sizeof($data_enca) == 0) {
            foreach ($data_enca as $denca) {
                $params[] = $denca;
            }
            return $params;
        }
        return null;
    }

    //MOD 21102018
    public static function getDataCandidatoByPollWeb($encuesta_id) {
        $data_enca = DB::table('encuesta_web as ew')
                ->join('encuesta as e', 'ew.encuesta_id', '=', 'e.id')
                ->join('candidato as ca', 'ew.candidato_id', '=', 'ca.id')
                ->join('categoria as c', 'ew.categoria_id', '=', 'c.id')
                ->select('ew.candidato_id', 'ca.nombre as nom_candidato', 'ca.detalle as det_candidato', 'ew.puntaje', 'ca.categoria_id', 'c.nombre as nom_categoria', 'c.descateg as desc_categoria', 'e.bandera')
                ->whereRaw('ew.encuesta_id = ?', [$encuesta_id])
                ->where('ew.estatus', "=", 1)
                ->where('e.tipo_encuesta', "=", 1)
                ->orderBy('nom_candidato', 'asc')
                ->get();

        if (!sizeof($data_enca) == 0) {
            foreach ($data_enca as $denca) {
                $params[] = $denca;
            }
            return $params;
        }
        return null;
    }

//MOD 21102018
    public static function getUltimaEncuestaWeb() {
        return DB::table('encuesta as e')
                        ->where('e.tipo_encuesta', "=", 1)
                        ->orderBy('e.id', 'asc')
                        ->get();
    }

    //MOD 22102018
    public static function getAllEncWebByEC($encuesta_id) {
        return DB::table('encuesta_web as ew')
                        ->join('candidato as ca', 'ew.candidato_id', '=', 'ca.id')
                        ->join('categoria as c', 'ew.categoria_id', '=', 'c.id')
                        ->select('ew.*')
                        ->whereRaw('ew.encuesta_id = ?', [$encuesta_id])
                        ->get();
    }

    public static function getAllEncTlfByEC($encuesta_id) {
        return DB::table('encuesta_tlf as et')
                        ->join('candidato as ca', 'et.candidato_id', '=', 'ca.id')
                        ->join('categoria as c', 'et.categoria_id', '=', 'c.id')
                        ->select('et.*')
                        ->whereRaw('et.encuesta_id = ?', [$encuesta_id])
                        ->get();
    }


//////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    public static function update_poll($params) {
        DB::beginTransaction();
        try {

            DB::table('encuesta')
                    ->whereRaw('id = ?', [$params['enc_id']])
                    ->update([
                       'fecha_desde' => $params['fecha_desde'],
                        'fecha_hasta' => $params['fecha_hasta'],
                        'muestra' => $params['muestra'],
                        'muestra_femenina' => $params['muestra_feme'],
                        'muestra_masculina' => $params['muestra_masc'],
                        'descripcion' => $params['descripcion'],
                        'usuario_updated' => $params['usuario_id'],
                        'updated_at' => 'now()'
            ]);


            DB::commit();
            return true;
        } catch (\Exception $exc) {
            error_log($exc, 0);
            DB::rollback();
            return false;
        }
    }


    public static function save_poll($params) {
        DB::beginTransaction();
        try {
            $poll_id = DB::table('encuesta')->insertGetId(
                    [
                        'fecha_desde' => $params['fecha_desde'],
                        'fecha_hasta' => $params['fecha_hasta'],
                        'muestra' => $params['muestra'],
                        'muestra_femenina' => $params['muestra_feme'],
                        'muestra_masculina' => $params['muestra_masc'],
                        'descripcion' => $params['descripcion'],
                        'tipo_encuesta' => 2,
                        'publicar' => false,
                        'usuario_created' => $params['usuario_id'],
                        'estatus' => 1,
                        'bandera' => 1
                    ]
            );

            DB::commit();
            return $poll_id;
        } catch (\Exception $exc) {
            error_log($exc, 0);
            DB::rollback();
            return false;
        }
    }

    public static function save_file($encuesta_id, $nombre_file, $usuario_id) {
        DB::beginTransaction();
        try {
            DB::table('encuesta')
                    ->whereRaw('id = ?', [$encuesta_id])
                    ->update([
                        'archivo' => $nombre_file,
                        'usuario_updated' => $usuario_id,
                        'updated_at' => 'now()'
            ]);

            DB::commit();
            return true;
        } catch (\Exception $exc) {
            error_log($exc, 0);
            DB::rollback();
            return false;
        }
    }

    //MOD 20102018
    public static function update_encuesta_tlf_publicar($encuesta_id, $usuario_id) {
        DB::beginTransaction();
        try {

            DB::table('encuesta')
                    ->where('id', '=', $encuesta_id)
                    ->where('tipo_encuesta', '=', 2)
                    ->update([
                        'estatus' => 2, //Publicado
                        'usuario_updated' => $usuario_id,
                        'updated_at' => 'now()',
                        'fecha_publicacion' => 'now()'
            ]);

            DB::table('encuesta')
                    ->where('id', '<>', $encuesta_id)
                    ->where('tipo_encuesta', '=', 2)
                    ->update([
                        'estatus' => 3, //Archivado
                        'usuario_updated' => $usuario_id,
                        'updated_at' => 'now()'
            ]);


            DB::commit();
            return true;
        } catch (\Exception $exc) {
            error_log($exc, 0);
            DB::rollback();
            return false;
        }
    }

    //MOD 22102018
    public static function update_encuesta_web_publicar($encuesta_id, $usuario_id, $categorias_enc) {
        DB::beginTransaction();
        try {

            DB::table('encuesta')
                    ->whereRaw('id = ?', [$encuesta_id])
                    ->where('tipo_encuesta', '=', 1)
                    ->update([
                        'estatus' => 2, //Publicado
                        'usuario_updated' => $usuario_id,
                        'updated_at' => 'now()',
                        'fecha_publicacion' => 'now()'
            ]);


            DB::table('encuesta')
                    ->where('id', '<>', $encuesta_id)
                    ->where('tipo_encuesta', '=', 1)
                    ->update([
                        'estatus' => 3, //Archivado
                        'usuario_updated' => $usuario_id,
                        'updated_at' => 'now()'
            ]);

        DB::table('encuesta_web')
                    ->where('encuesta_id', '=', $encuesta_id)
                    ->update([
                            'posicion_ant' => 1,
                            'posicion_act' => 1,
                            'movimiento' => 'nuevo'
            ]);

                    
            //Para cuando se pública un EW, para guardar la poisición y guardar en caso de que no existe la posición
            if ($categorias_enc != 0) {
                foreach ($categorias_enc as $value) {
                    ////Saber si el id de la posicion que se desea guardar en categoria,existe en la tabla posición
                    $existe_posicion = self::existeEnPosicion($value->categoria_id);
                    ////Si no existe el ID
                    if ($existe_posicion == 0) {
                        //generar un color aleatorio y guardarlo en posicion y posterior en categoria
                        $color_ran = dechex(rand(0x000000, 0xFFFFFF));
                        $color = '#' . $color_ran;
                        DB::table('posicion')->insert(
                                [
                                    'id' => $value->categoria_id,
                                    'color' => $color,
                                    'usuario_reg' => $usuario_id,
                                    'usuario_upd' => $usuario_id,
                                    'create_at' => 'now()',
                                    'updated_at' => 'now()'
                                ]
                        );
                    }/////if

                    DB::table('categoria')
                            ->whereRaw('id = ?', [$value->categoria_id])
                            ->update([
                                'usuario_upd' => $usuario_id,
                                'updated_at' => 'now()',
                                'posicion_id' => $value->categoria_id
                    ]);
                }//foreach
            }

            DB::commit();
            return true;
        } catch (\Exception $exc) {
            error_log($exc, 0);
            DB::rollback();
            return false;
        }
    }

    //MOD 21102018
    public static function save_poll_web($usuario_id, $bandera) {
        DB::beginTransaction();
        try {
            $poll_id = DB::table('encuesta')->insertGetId(
                    [
                        'tipo_encuesta' => 1,
                        'usuario_created' => $usuario_id,
                        'estatus' => 1,
                        'bandera' => $bandera
                    ]
            );

            DB::commit();
            return $poll_id;
        } catch (\Exception $exc) {
            error_log($exc, 0);
            DB::rollback();
            return false;
        }
    }

    public static function update_categoriabyEnc($usuario_id, $params) {
        DB::beginTransaction();
        try {

            foreach ($params as $value) {
                DB::table('categoria')
                        ->whereRaw('id = ?', [$value->categoria_id])
                        ->update([
                            'usuario_upd' => $usuario_id,
                            'updated_at' => 'now()',
                            'posicion_id' => $value->categoria_id
                ]);
            }


            DB::commit();
            return true;
        } catch (\Exception $exc) {
            error_log($exc, 0);
            DB::rollback();
            return false;
        }
    }

    //MOD 21102018
    public static function save_poll_cand($encuesta_id, $params) {
        DB::beginTransaction();
        try {
            $posicion = 1;
            foreach ($params as $value) {
                DB::table('encuesta_web')->insert(
                        [
                            'encuesta_id' => $encuesta_id,
                            'categoria_id' => $value->categoria_id,
                            'candidato_id' => $value->candidato_id,
                            'puntaje' => $value->puntaje_tlf,
                            'posicion_ant' => $posicion,
                            'posicion_act' => $posicion,
                            'movimiento' => 'nuevo',
                        ]
                );
                $posicion++;
            }


            DB::commit();
            return true;
        } catch (\Exception $exc) {
            error_log($exc, 0);
            DB::rollback();
            return false;
        }
    }

    //MOD 22102018
    public static function save_pollweb_cand($encuesta_id, $params) {
        DB::beginTransaction();
        try {
            $posicion = 1;
            foreach ($params as $value) {
                DB::table('encuesta_web')->insert(
                        [
                            'encuesta_id' => $encuesta_id,
                            'categoria_id' => $value->categoria_id,
                            'candidato_id' => $value->candidato_id,
                            'puntaje' => $value->puntaje,
                            'posicion_ant' => $posicion,
                            'posicion_act' => $posicion,
                            'movimiento' => 'nuevo',
                            'estatus' => $value->estatus
                        ]
                );
                $posicion++;
            }


            DB::commit();
            return true;
        } catch (\Exception $exc) {
            error_log($exc, 0);
            DB::rollback();
            return false;
        }
    }

    public static function remove_encuesta_candidato($id) {
        DB::beginTransaction();
        try {

            DB::table('encuesta_web')
                    ->whereRaw('id = ?', [$id])
                    ->delete();

            DB::commit();
            return true;
        } catch (\Exception $exc) {
            error_log($exc, 0);
            DB::rollback();
            return false;
        }
    }

    /////////////////////////////////// OTRA FORMA DE GUARDAR O EDITAR PUNTAJE ET y EW /////////////////////
    //////////////////////////////////////////                                      ////////////////////   

    public static function guardar_valori_candidato($params, $usuario_id) {
        DB::beginTransaction();
        try {

            DB::table('encuesta_web')->insert(
                    [
                        'encuesta_id' => $params['enc_id'],
                        'categoria_id' => $params['cat_id'],
                        'candidato_id' => $params['cand_id'],
                        'puntaje' => $params['valor']
                    ]
            );


            DB::table('encuesta')
                    ->where('id', '=', $params['enc_id'])
                    ->update([
                        'usuario_updated' => $usuario_id,
                        'updated_at' => 'now()',
                        'bandera' => $params['flag']
            ]);


            DB::commit();
            return true;
        } catch (\Exception $exc) {
            error_log($exc, 0);
            DB::rollback();
            return false;
        }
    }

    public static function salvar_puntaje_tlf($encuesta_id, $categoria_id, $candidato_id, $puntaje) {
        DB::beginTransaction();
        try {
            DB::table('encuesta_tlf')->insert(
                    [
                        'encuesta_id' => $encuesta_id,
                        'categoria_id' => $categoria_id,
                        'candidato_id' => $candidato_id,
                        'puntaje_tlf' => $puntaje
                    ]
            );

            DB::commit();
            return true;
        } catch (\Exception $exc) {
            error_log($exc, 0);
            DB::rollback();
            return false;
        }
    }

    public static function actualizar_puntaje_tlf($encuesta_id, $categoria_id, $candidato_id, $puntaje) {
        DB::beginTransaction();
        try {
            DB::table('encuesta_tlf')
                    ->whereRaw('encuesta_id = ?', [$encuesta_id])
                    ->whereRaw('categoria_id = ?', [$categoria_id])
                    ->whereRaw('candidato_id = ?', [$candidato_id])
                    ->update(
                            [
                                'puntaje_tlf' => $puntaje
                            ]
            );

            DB::commit();
            return true;
        } catch (\Exception $exc) {
            error_log($exc, 0);
            DB::rollback();
            return false;
        }
    }

    public static function salvar_puntaje_web($encuesta_id, $categoria_id, $candidato_id, $puntaje) {
        DB::beginTransaction();
        try {
            DB::table('encuesta_web')->insert(
                    [
                        'encuesta_id' => $encuesta_id,
                        'categoria_id' => $categoria_id,
                        'candidato_id' => $candidato_id,
                        'puntaje' => $puntaje
                    ]
            );

            DB::commit();
            return true;
        } catch (\Exception $exc) {
            error_log($exc, 0);
            DB::rollback();
            return false;
        }
    }

    //MOD 22102018
    public static function actualizar_puntaje_web($encuesta_id, $categoria_id, $candidato_id, $puntaje, $posicion, $movimiento) {
        DB::beginTransaction();
        try {
            DB::table('encuesta_web')
                    ->whereRaw('encuesta_id = ?', [$encuesta_id])
                    ->whereRaw('categoria_id= ?', $categoria_id)
                    ->whereRaw('candidato_id = ?', [$candidato_id])
                    ->update(
                            [
                                'puntaje' => $puntaje,
                                'posicion_ant' => $posicion,
                                'posicion_act' => $posicion,
                                'movimiento' => $movimiento
                            ]
            );

            DB::commit();
            return true;
        } catch (\Exception $exc) {
            error_log($exc, 0);
            DB::rollback();
            return false;
        }
    }

    public static function guardar_votacion_inicial($datos, $bandera) {
        DB::beginTransaction();
        try {
            //puntaje_web
            if ($bandera == 1) {


                DB::table('votacion')->insert(
                        [
                            'encuesta_id' => $var,
                            'categoria_id' => $var,
                            'candidato_id' => $var,
                            'puntaje' => $var,
                            'posicion_ant' => $var,
                            'posicion_act' => $$var
                        ]
                );
            }//if


            DB::commit();
            return true;
        } catch (\Exception $exc) {
            error_log($exc, 0);
            DB::rollback();
            return false;
        }
    }


    public static function cambiar_estatus_categoria_enctlf($encuesta_id,$categoria_id,$estatus) {
        DB::beginTransaction();
        try {

            DB::table('encuesta_tlf')
                    ->where('encuesta_id', '=', $encuesta_id)
                    ->where('categoria_id', '=', $categoria_id)
                    ->update([
                        'estatus' => $estatus
            ]);


            DB::commit();
            return true;
        } catch (\Exception $exc) {
            error_log($exc, 0);
            DB::rollback();
            return false;
        }
    }

    public static function cambiar_estatus_categoria_encweb($encuesta_id,$categoria_id,$estatus) {
        DB::beginTransaction();
        try {

            DB::table('encuesta_web')
                    ->where('encuesta_id', '=', $encuesta_id)
                    ->where('categoria_id', '=', $categoria_id)
                    ->update([
                        'estatus' => $estatus
            ]);

            DB::commit();
            return true;
        } catch (\Exception $exc) {
            error_log($exc, 0);
            DB::rollback();
            return false;
        }
    }


    public static function save_poll_tlf($usuario_id, $params) {
        DB::beginTransaction();
        try {
            $pollTlf_id = DB::table('encuesta')->insertGetId(
                    [
                        'fecha_desde' => $params->fecha_desde,
                        'fecha_hasta' => $params->fecha_hasta,
                        'muestra' => $params->muestra,
                        'muestra_femenina' => $params->muestra_femenina,
                        'muestra_masculina' => $params->muestra_masculina,
                        'descripcion' => $params->descripcion,
                        'tipo_encuesta' => 2,
                        'usuario_created' => $usuario_id,
                        'estatus' => 1,
                        'bandera' => $params->bandera

                    ]
            );

            DB::commit();
            return $pollTlf_id;
        } catch (\Exception $exc) {
            error_log($exc, 0);
            DB::rollback();
            return false;
        }
    }


    public static function save_polltlf_cand($encuesta_id, $params) {
        
        DB::beginTransaction();
        try {
           
            foreach ($params as $value) {
                DB::table('encuesta_tlf')->insert(
                        [
                            'encuesta_id' => $encuesta_id,
                            'categoria_id' => $value->categoria_id,
                            'candidato_id' => $value->candidato_id,
                            'puntaje_tlf' => $value->puntaje_tlf,
                            'estatus' => $value->estatus
                        ]
                );
                
            }

            DB::commit();
            return true;
        } catch (\Exception $exc) {
            error_log($exc, 0);
            DB::rollback();
            return false;
        }
    }

}
