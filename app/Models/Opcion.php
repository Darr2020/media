<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;
use DB;

class Opcion extends Model {

    public $table = "opcion";

    public static function consulOpcio() {

        $consulta = DB::table('opcion')
                ->select('id', 'nombre', 'infor', 'gen', 'generoart', 'img', 'audio', 'video', 'redes', 'pag', 'seg', 'cia')
                ->whereRaw('estatus = ?', 1)
                ->orderBy('id', 'asc')
                ->get();

        if (!sizeof($consulta) == 0) {

            foreach ($consulta as $opcion) {

                $params[] = $opcion;
            }

            return $params;
        }

        return false;
    }

    public static function consulOpcioId($id) {

        $consulta = DB::table('opcion')
                ->select('nombre', 'infor', 'gen', 'generoart', 'img', 'audio', 'video', 'redes', 'pag', 'seg', 'cia')
                ->whereRaw('id = ?', [$id])
                ->whereRaw('estatus = ?', 1)
                ->get();

        if (!sizeof($consulta) == 0) {

            foreach ($consulta as $opcion) {

                $params[] = $opcion;
            }

            return $params;
        }

        return false;
    }

    public static function consulOpcioCatgId($id) {

        $consulta = DB::table('opcion')
                ->select('nombre', 'infor', 'gen', 'generoart', 'img', 'audio', 'video', 'redes', 'pag', 'seg', 'cia')
                ->whereRaw('categoria_id = ?', [$id])
                ->whereRaw('estatus = ?', 1)
                ->get();

        if (!sizeof($consulta) == 0) {

            foreach ($consulta as $opcion) {

                $params[] = $opcion;
            }

            return $params;
        }

        return false;
    }

    public static function udtEstOpcio($Opcio) {

        DB::beginTransaction();
        try {
            DB::table('opcion')
                    ->whereRaw('id = ?', [$Opcio['id']])
                    ->update([
                        'estatus' => $Opcio['estatus'],
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

    public static function udtOpcio($Opcio) {

        DB::beginTransaction();
        try {
            DB::table('opcion')
                    ->whereRaw('id = ?', [$Opcio['id']])
                    ->update([
                        'nombre' => $Opcio['nombre'],
                        'infor' => $Opcio['inform'],
                        'gen' => $Opcio['generp'],
                        'generoart' => $Opcio['genera'],
                        'img' => $Opcio['imagen'],
                        'audio' => $Opcio['audio'],
                        'video' => $Opcio['video'],
                        'redes' => $Opcio['redes'],
                        'pag' => $Opcio['pagina'],
                        'cia' => $Opcio['ciania'],
                        'seg' => $Opcio['seguid'],
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
