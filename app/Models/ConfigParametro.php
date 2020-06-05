<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

Class ConfigParametro extends Model {

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = "config_parametro";


    public static function get_config_parametro() {
        $confP = DB::table('config_parametro as cp')
                ->where("cp.estatus", "=", 1)
                ->select('cp.*')
                ->orderBy('cp.nombre')
                ->get();

        if (!sizeof($confP) == 0) {
            foreach ($confP as $cp) {
                $params[] = $cp;
            }
            return $params;
        }

        return null;

    }

        public static function get_config_parametro_byId($cf_param_id) {
        $cf_param = DB::table('config_parametro as cp')
                ->where("cp.estatus", "=", 1)
                ->whereRaw('cp.id = ?', [$cf_param_id])
                ->select('cp.*')
                ->get();

        if (!sizeof($cf_param) == 0) {
            foreach ($cf_param as $cp) {
                $params[] = $cp;
            }
            return $params;
        }

        return null;

    }


    public static function get_min_categoria_por_encuesta() {
        $confP_mcpe = DB::table('config_parametro as cp')
                ->where("cp.estatus", "=", 1)
                ->whereRaw('cp.nombre = ?', ['Mínimo de categorías por encuesta'])
                ->select('cp.valor')
                ->get();

        if (!sizeof($confP_mcpe) == 0) {
            foreach ($confP_mcpe as $cpmcpe) {
                $params[] = $cpmcpe;
            }
            return $params;
        }

        return null;

    }


        public static function get_min_candidatos_por_categoria() {
        $confP_mcpc = DB::table('config_parametro as cp')
                ->where("cp.estatus", "=", 1)
                ->whereRaw('cp.nombre = ?', ['Mínimo de candidatos por categoría'])
                ->select('cp.valor')
                ->get();

        if (!sizeof($confP_mcpc) == 0) {
            foreach ($confP_mcpc as $cpmcpc) {
                $params[] = $cpmcpc;
            }
            return $params;
        }

        return null;

    }



    public static function actualizar_config_parameters($params) {
        DB::beginTransaction();
        try {
                
                DB::table('config_parametro')
                            ->whereRaw('id = ?', [$params['cf_param_id']])
                            ->update([
                               'valor' => $params['param_value']
                ]);
                

            DB::commit();
            return true;
        } catch (\Exception $exc) {
            error_log($exc, 0);
            DB::rollback();
            return false;
        }
    }

    public static function guardar_config_parameters($params) {
        DB::beginTransaction();
        try {

                DB::table('config_parametro')->insert(
                    [
                        'nombre' => ucwords(strtolower($params['param_name'])),
                        'valor' => $params['param_value']
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


}
