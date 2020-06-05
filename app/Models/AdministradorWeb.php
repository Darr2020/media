<?php

namespace App\Models;

use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Input;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use DB;
use Spatie\Image\Image;


class AdministradorWeb extends Model {

    public static function consulbanner() {

        $consulta = DB::table('banner')
                ->select('banner.id', 'banner.posicion_id', 'banner.estatus', 'banner.imagen')
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

    public static function consulbannerId($id) {

        $consulta = DB::table('banner')
                ->select('banner.id', 'banner.posicion_id', 'banner.estatus', 'banner.imagen')
                ->whereRaw('banner.id = ?', [$id])
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

    public static function consulPosCateg() {

        $consulta = DB::table('categoria')
                ->leftJoin('posicion', 'posicion.id', '=', 'categoria.posicion_id')
                ->select('categoria.id', DB::raw('initcap(categoria.nombre) AS nombrecategoria'), 'categoria.posicion_id', 'categoria.estatus', 'posicion.id AS posicionid', 'posicion.color')
                ->whereRaw('categoria.estatus = ?', 1)
                ->orderBy('posicion.id', 'asc')
                ->get();

        if (!sizeof($consulta) == 0) {

            foreach ($consulta as $frontend) {

                $params[] = $frontend;
            }
            return $params;
        }

        return false;
    }

    public static function posicion() {

        $consulta = DB::table('posicion')
                ->select('posicion.id', 'posicion.color')
                ->orderBy('posicion.id', 'asc')
                ->get();

        if (!sizeof($consulta) == 0) {

            foreach ($consulta as $frontend) {

                $params[] = $frontend;
            }

            return $params;
        }

        return false;
    }

    public static function consulPosicionNew() {

        $consulta = DB::select(DB::raw("select posicion.id
                                        from posicion where posicion.id NOT IN
                                        (select banner.posicion_id
                                        from banner)
                                        order by posicion.id asc"));

        if (!sizeof($consulta) == 0) {

            foreach ($consulta as $frontend) {

                $params[] = $frontend;
            }

            return $params;
        }

        return false;
    }

    public static function udtEstBanner($banner) {

        DB::beginTransaction();
        try {
            DB::table('banner')
                    ->whereRaw('id = ?', $banner['id'])
                    ->update([
                        'estatus' => $banner['estatus'],
                        'updated_at' => 'now()',
                        'usuario_upd' => Session::get('usuario_backend')->id
            ]);

            DB::commit();
            return true;
        } catch (\Exception $exc) {
            error_log($exc, 0);
            DB::rollback();
            return false;
        }
    }

    public static function savesBanner($bann) {

        DB::beginTransaction();
        try {

            if ($bann['imgg'] != null || $bann['posicion_id'] != 0) {

                $fecha = date("d-m-Y");

                if ($bann['tipo'] == 1) {

                    if (isset($bann['imgg'])) {
                        if ($bann['imgg'] != 0) {
                            $tipo = $bann['imgg']->getClientMimeType();
                            $ext = $bann['imgg']->getClientOriginalExtension();
                            if ($tipo == 'image/jpeg' || $tipo == 'image/jpg' || $tipo == 'image/png' || $tipo == 'image/gif') {
                                $nombre_file = 'banner_' . $bann['posicion_id'] . '.' . $ext;
                                $upload_success = $bann['imgg']->move(public_path() . '/images/gallary/', $nombre_file);
                                
                                $tamaño = Image::load($upload_success)->width(50)->height(50);

                                if ($tamaño) {
                                     //Si se sube el archivo en la carpeta, se guarda en BD
                                    if ($upload_success) {
                                        DB::table('banner')->insert(
                                            ['imagen' => $nombre_file,
                                                'posicion_id' => $bann['posicion_id'],
                                                'estatus' => 1,
                                                'usuario_reg' => Session::get('usuario_backend')->id,
                                                'usuario_upd' => Session::get('usuario_backend')->id
                                    ]);
                                    } else {
                                        return 3; //No se pudo guardar la imagen en la carpeta
                                    }

                                }
                               
                            } else {
                                return 4; //Error de formato en la imagen debe ser 'image/jpeg' 'image/jpg' 'image/png' 'image/gif'
                            }
                        }
                    }
                } else if ($bann['tipo'] == 2) {

                    if (isset($bann['imgg'])) {
                        if ($bann['imgg'] != 0) {
                            $tipo = $bann['imgg']->getClientMimeType();
                            $ext = $bann['imgg']->getClientOriginalExtension();
                            if ($tipo == 'image/jpeg' || $tipo == 'image/jpg' || $tipo == 'image/png' || $tipo == 'image/gif') {
                                $nombre_file = 'banner_' . $bann['posicion_id'] . '.' . $ext;
                                $upload_success = $bann['imgg']->move(public_path() . '/images/gallary/', $nombre_file);
                                //Si se sube el archivo en la carpeta, se guarda en BD
                                if ($upload_success) {
                                    DB::table('banner')
                                            ->whereRaw('id = ?', $bann['banner_id'])
                                            ->update([
                                                'imagen' => $nombre_file,
                                                'usuario_upd' => Session::get('usuario_backend')->id
                                    ]);
                                } else {
                                    return 3; //No se pudo guardar la imagen en la carpeta
                                }
                            } else {
                                return 4; //Error de formato en la imagen debe ser 'image/jpeg' 'image/jpg' 'image/png' 'image/gif'
                            }
                        }
                    }

                    if (isset($bann['posicion_id'])) {
                        DB::table('banner')
                                ->whereRaw('id = ?', $bann['banner_id'])
                                ->update([
                                    'posicion_id' => $bann['posicion_id'],
                                    'usuario_upd' => Session::get('usuario_backend')->id
                        ]);
                    }
                } else {
                    return 7;
                }

                DB::commit();
                return 1;
            } else {
                return 2; /* No se ingreso ninguna imagen intente nuevo */
            }
        } catch (\Exception $exc) {
            error_log($exc, 0);
            DB::rollback();
            return 7; /* No se guardo la informacion en base de datos */
        }
    }

    public static function posCategoria($banner) {

        DB::beginTransaction();
        try {
            if (isset($banner['posicion_id'])) {
                DB::table('categoria')
                        ->whereRaw('id = ?', $banner['banner_id'])
                        ->update([
                            'posicion_id' => $banner['posicion_id'],
                            'usuario_upd' => Session::get('usuario_backend')->id
                ]);
                DB::commit();
                return true;
            }
        } catch (\Exception $exc) {
            error_log($exc, 0);
            DB::rollback();
            return false;
        }
    }

    public static function cambiarColor($color) {

        DB::beginTransaction();
        try {
            if (isset($color['color'])) {
                DB::table('posicion')
                        ->whereRaw('id = ?', $color['posicion_id'])
                        ->update([
                            'color' => $color['color'],
                            'usuario_upd' => Session::get('usuario_backend')->id
                ]);
                DB::commit();
                return true;
            }
        } catch (\Exception $exc) {
            error_log($exc, 0);
            DB::rollback();
            return false;
        }
    }

}
