<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;
use DB;

class Genero extends Model {

    public $table = "genero";

    public static function consulGener() {

        $consulta = DB::table('genero')
                ->select('id', 'nombre', 'categoria_id')
                ->whereRaw('estatus = ?', 1)
                ->orderBy('id', 'asc')
                ->get();

        if (!sizeof($consulta) == 0) {

            foreach ($consulta as $genero) {

                $params[] = $genero;
            }

            return $params;
        }

        return false;
    }

    public static function consulGenerId($id) {

        $consulta = DB::table('genero')
                ->select('nombre', 'categoria_id')
                ->whereRaw('id = ?', [$id])
                ->whereRaw('estatus = ?', 1)
                ->get();

        if (!sizeof($consulta) == 0) {

            foreach ($consulta as $genero) {

                $params[] = $genero;
            }

            return $params;
        }

        return false;
    }

    public static function consulGenerCatgId($id) {

        $consulta = DB::table('genero')
                ->select('id', 'nombre AS nomgenero')
                ->whereRaw('categoria_id = ?', [$id])
                ->whereRaw('estatus = ?', 1)
                ->get();
        
        if (!sizeof($consulta) == 0) {

            foreach ($consulta as $genero) {

                $params[] = $genero;
            }

            return $params;
        }

        return false;
    }

    public static function udtEstGener($Gener) {

        DB::beginTransaction();
        try {
            DB::table('genero')
                    ->whereRaw('id = ?', $Gener['id'])
                    ->update([
                        'estatus' => $Gener['estatus'],
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

    public static function udtGener($Gener) {

        DB::beginTransaction();
        try {
            DB::table('genero')
                    ->whereRaw('id = ?', $Gener['id'])
                    ->update([
                        'nombre' => $Gener['nombre_catg'],
                        'categoria_id' => $Gener['categoria_id'],
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
