<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;
use DB;

class CandidatoRedes extends Model {

    public $table = "candidato_redes";

    public static function consulCandRedes() {

        $consulta = DB::table('candidato_redes')
                ->select('id', 'nombre', 'candidato_id')
                ->whereRaw('estatus = ?', 1)
                ->orderBy('id', 'asc')
                ->get();

        if (!sizeof($consulta) == 0) {

            foreach ($consulta as $candidatos_redes) {

                $params[] = $candidatos_redes;
            }

            return $params;
        }

        return false;
    }

    public static function consulCandRedesId($id) {

        $consulta = DB::table('candidato_redes')
                ->select('id', 'nombre')
                ->whereRaw('candidato_id = ?', [$id])
                ->whereRaw('estatus = ?', 1)
                ->get();

        if (!sizeof($consulta) == 0) {

            foreach ($consulta as $candidatos_redes) {

                $params[] = $candidatos_redes;
            }

            return $params;
        }

        return false;
    }

    public static function savesCandRedes($CandRedes) {
        
        DB::beginTransaction();
        try {
            
        } catch (\Exception $exc) {
            error_log($exc, 0);
            DB::rollback();
            return false;
        }
    }

    public static function udtEstCandRedes($CandRedes) {

        DB::beginTransaction();
        try {
            DB::table('candidato_redes')
                    ->whereRaw('id = ?', [$CandRedes['id']])
                    ->update([
                        'estatus' => [$CandRedes['estatus']],
                        'updated_at' => 'now()',
                        'usuario_upd' => Session::get('usuario_id')
            ]);

            DB::commit();
            return true;
        } catch (\Exception $exc) {
            error_log($exc, 0);
            DB::rollback();
            return false;
        }
    }

    public static function udtCandRedes($CandRedes) {

        DB::beginTransaction();
        try {
            DB::table('candidato_redes')
                    ->whereRaw('candidato_id = ?', [$CandRedes['id']])
                    ->update([
                        'nombre' => $CandRedes['nombre'],
                        'updated_at' => 'now()',
                        'usuario_upd' => Session::get('usuario_id')
            ]);

            DB::commit();
            return true;
        } catch (\Exception $exc) {
            error_log($exc, 0);
            DB::rollback();
            return false;
        }
    }

}
