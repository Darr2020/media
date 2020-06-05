<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;
use DB;

Class CmGustos extends Model {

    protected $table = "cm_gustos";

    public static function obtener_gusto_bd($encuesta_id, $categoria_id, $candidato_multimedia_id, $candidato_id, $tipo_multimedia) {

        return DB::table('cm_gustos as cmg')
                        ->whereRaw('cmg.encuesta_id = ?', [$encuesta_id])
                        ->whereRaw('cmg.categoria_id = ?', [$categoria_id])
                        ->whereRaw('cmg.candidato_multimedia_id = ?', [$candidato_multimedia_id])
                        ->whereRaw('cmg.candidato_id = ?', [$candidato_id])
                        ->whereRaw('cmg.tipo_multimedia = ?', [$tipo_multimedia])
                        ->count();
    }

    public static function get_like_generic_cand($encuesta_id, $categoria_id, $candidato_multimedia_id, $candidato_id, $tipo_multimedia) {

        return DB::table('cm_gustos as cmg')
                        ->whereRaw('cmg.encuesta_id = ?', [$encuesta_id])
                        ->whereRaw('cmg.categoria_id = ?', [$categoria_id])
                        ->whereRaw('cmg.candidato_multimedia_id = ?', [$candidato_multimedia_id])
                        ->whereRaw('cmg.candidato_id = ?', [$candidato_id])
                        ->whereRaw('cmg.tipo_multimedia = ?', [$tipo_multimedia])
                        ->where('cmg.gusto', "=", 1) //1 me gusta
                        ->count();
    }

    public static function get_dislike_generic_cand($encuesta_id, $categoria_id, $candidato_multimedia_id, $candidato_id, $tipo_multimedia) {

        return DB::table('cm_gustos as cmg')
                        ->whereRaw('cmg.encuesta_id = ?', [$encuesta_id])
                        ->whereRaw('cmg.categoria_id = ?', [$categoria_id])
                        ->whereRaw('cmg.candidato_multimedia_id = ?', [$candidato_multimedia_id])
                        ->whereRaw('cmg.candidato_id = ?', [$candidato_id])
                        ->whereRaw('cmg.tipo_multimedia = ?', [$tipo_multimedia])
                        ->where('cmg.gusto', "=", 2) //1 no me gusta
                        ->count();
    }

    public static function existe_emotion_en_bd_byUserId($params) {
        return DB::table('cm_gustos as cmg')
                        ->whereRaw('cmg.encuesta_id = ?', [$params['encuesta_id']])
                        ->whereRaw('cmg.categoria_id = ?', [$params['categoria_id']])
                        ->whereRaw('cmg.candidato_multimedia_id = ?', [$params['candidato_multimedia_id']])
                        ->whereRaw('cmg.candidato_id = ?', [$params['candidato_id']])
                        ->whereRaw('cmg.tipo_multimedia = ?', [$params['tipo_multimedia']])
                        ->whereRaw('cmg.usuario_id = ?', [$params['usuario_id']])
                        ->count();
    }

    public static function get_feeling_byUser($encuesta_id, $categoria_id, $candidato_multimedia_id, $candidato_id, $tipo_multimedia, $usuario_id) {
        return DB::table('cm_gustos as cmg')
                        ->select('cmg.gusto')
                        ->whereRaw('cmg.encuesta_id = ?', [$encuesta_id])
                        ->whereRaw('cmg.categoria_id = ?', [$categoria_id])
                        ->whereRaw('cmg.candidato_multimedia_id = ?', [$candidato_multimedia_id])
                        ->whereRaw('cmg.candidato_id = ?', [$candidato_id])
                        ->whereRaw('cmg.tipo_multimedia = ?', [$tipo_multimedia])
                        ->whereRaw('cmg.usuario_id = ?', [$usuario_id])
                        ->first();
    }

    public static function new_emotion($params) {
        DB::beginTransaction();
        try {
            $cmgusto_id = DB::table('cm_gustos')->insertGetId(
                    [
                        'encuesta_id' => $params['encuesta_id'],
                        'categoria_id' => $params['categoria_id'],
                        'candidato_multimedia_id' => $params['candidato_multimedia_id'],
                        'candidato_id' => $params['candidato_id'],
                        'tipo_multimedia' => $params['tipo_multimedia'],
                        'gusto' => $params['emotion'],
                        'usuario_id' => $params['usuario_id']
                    ]
            );

            DB::commit();
            return $cmgusto_id;
        } catch (\Exception $exc) {
            error_log($exc, 0);
            DB::rollback();
            return false;
        }
    }

    public static function actualizar_emotion($params) {
        DB::beginTransaction();
        try {
            DB::table('cm_gustos')
                    ->whereRaw('encuesta_id = ?', [$params['encuesta_id']])
                    ->whereRaw('categoria_id = ?', [$params['categoria_id']])
                    ->whereRaw('candidato_multimedia_id = ?', [$params['candidato_multimedia_id']])
                    ->whereRaw('tipo_multimedia = ?', [$params['tipo_multimedia']])
                    ->whereRaw('usuario_id = ?', [$params['usuario_id']])
                    ->update([
                        'gusto' => $params['emotion'],
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

}
