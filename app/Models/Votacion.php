<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;
use DB;

class Votacion extends Model {

    public $table = "votacion";

    public static function savesVoto($voto) {

        DB::beginTransaction();
        try {

            if ($voto['id'] != "" && $voto['opt'] != "" && $voto['enc'] != "") {

                $votar = DB::table('encuesta_web')
                        ->where('candidato_id', $voto['id'])
                        ->where('categoria_id', $voto['opt'])
                        ->where('encuesta_id', $voto['enc'])
                        ->increment('puntaje', 1);

                $reg_voto = DB::table('votos_usuario')->insert(
                        ['candidato_id' => $voto['id'],
                         'categoria_id' => $voto['opt'],
			 'encuesta_id' => $voto['enc'],
                         'usuario_id' => Session::get("usuario")->id
                        ]);

                $cand = DB::table('encuesta_web')
                        ->select('candidato_id', 'posicion_act')
                        ->where('categoria_id', $voto['opt'])
                        ->where('encuesta_id', $voto['enc'])
                        ->orderBy('puntaje', 'desc')
                        ->get();

                $total = count($cand);

                for ($x = 1; $x <= $total; $x++) {

                    $i = $x - 1;
                    $t = $cand[$i]->posicion_act;

                    if ($t < $x) {
                        $mov = 'baja';
                    } else if ($t > $x) {
                        $mov = 'sube';
                    } else if ($t = $x) {
                        $mov = 'estable';
                    }

                    $updd = DB::table('encuesta_web')
                            ->where('candidato_id', $cand[$i]->candidato_id)
                            ->where('categoria_id', $voto['opt'])
                            ->where('encuesta_id', $voto['enc'])
                            ->update([
                        'posicion_ant' => $t,
                        'posicion_act' => $x,
                        'movimiento' => $mov
                    ]);

                }

                DB::commit();

                return true;
            } else {
                return false;
            }
        } catch (\Exception $exc) {
            error_log($exc, 0);
            DB::rollback();
            return false;
        }
    }

}
