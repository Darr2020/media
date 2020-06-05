<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;
use DB;

class Categoria extends Model {

    public $table = "categoria";

    public static function consulCateg() {

        $consulta = DB::table('categoria')
                ->leftJoin('candidato', 'candidato.categoria_id', '=', 'categoria.id')
                ->select('categoria.id', DB::raw('initcap(categoria.nombre) AS nombre'), 'categoria.descateg', 'categoria.descand', 'categoria.estatus', DB::raw('COUNT(candidato.categoria_id) AS contcand'))
                ->groupBy('categoria.id', 'categoria.descateg', 'categoria.descand', 'categoria.estatus')
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

    public static function consulCategActivas() {

        $consulta = DB::table('categoria')
                ->leftJoin('candidato', 'candidato.categoria_id', '=', 'categoria.id')
                ->select('categoria.id', DB::raw('initcap(categoria.nombre) AS nombre'), 'categoria.descateg', 'categoria.descand', 'categoria.estatus', DB::raw('COUNT(candidato.categoria_id) AS contcand'))
                ->whereRaw('categoria.estatus = ?', 1)
                ->groupBy('categoria.id', 'categoria.descateg', 'categoria.descand', 'categoria.estatus')
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

    public static function consulCategId($id) {

        $consulta = DB::table('categoria')
                ->select('categoria.id', DB::raw('initcap(categoria.nombre) AS nombre'), 'categoria.descateg', 'categoria.descand')
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

    public static function savesCateg($categ) {

        DB::beginTransaction();
        try {

            if ($categ['nomCatg'] != "") {

                $categoria_id = DB::table('categoria')->insertGetId(
                        ['nombre' => $categ['nomCatg'],
                            'descateg' => $categ['desCateg'],
                            'descand' => $categ['desCand'],
                            'create_at' => 'now()',
                            'usuario_reg' => 1,
                            'updated_at' => 'now()',
                            'usuario_upd' => 1
                ]);

                if (isset($categ['nombre'])) {
                    $nombre = true;
                } else {
                    $nombre = false;
                }
                if (isset($categ['infor'])) {
                    $infor = true;
                } else {
                    $infor = false;
                }
                if (isset($categ['gen'])) {
                    $gen = true;
                } else {
                    $gen = false;
                }
                if (isset($categ['generoArt'])) {
                    $generoArt = true;
                } else {
                    $generoArt = false;
                }
                if (isset($categ['img'])) {
                    $img = true;
                } else {
                    $img = false;
                }
                if (isset($categ['audio'])) {
                    $audio = true;
                } else {
                    $audio = false;
                }
                if (isset($categ['video'])) {
                    $video = true;
                } else {
                    $video = false;
                }
                if (isset($categ['redes'])) {
                    $redes = true;
                } else {
                    $redes = false;
                }
                if (isset($categ['pag'])) {
                    $pag = true;
                } else {
                    $pag = false;
                }
                if (isset($categ['cia'])) {
                    $cia = true;
                } else {
                    $cia = false;
                }
                if (isset($categ['seg'])) {
                    $seg = true;
                } else {
                    $seg = false;
                }

                DB::table('opcion')->insert(
                        ['nombre' => $nombre,
                            'infor' => $infor,
                            'gen' => $gen,
                            'generoart' => $generoArt,
                            'img' => $img,
                            'audio' => $audio,
                            'video' => $video,
                            'redes' => $redes,
                            'pag' => $pag,
                            'cia' => $cia,
                            'seg' => $seg,
                            'estatus' => 1,
                            'categoria_id' => $categoria_id,
                            'create_at' => 'now()',
                            'usuario_reg' => 1,
                            'updated_at' => 'now()',
                            'usuario_upd' => 1
                ]);

                if (isset($categ['generoArt'])) {
                    if (isset($categ['generosArt'])) {
                        $genero = array_keys(array_count_values($categ['generosArt']));
                        $num_for = count($genero);

                        for ($x = 0; $x < $num_for; $x++) {
                            DB::table('genero')->insert(
                                    ['nombre' => $genero[$x],
                                        'estatus' => 1,
                                        'categoria_id' => $categoria_id,
                                        'create_at' => 'now()',
                                        'usuario_reg' => 1,
                                        'updated_at' => 'now()',
                                        'usuario_upd' => 1
                            ]);
                        }
                    }
                }
                DB::commit();

                return true;
            } else {
                return false; /* No se ingreso ningun nombre de categoria intente nuevo */
            }
        } catch (\Exception $exc) {
            error_log($exc, 0);
            DB::rollback();
            return false;
        }
    }

    public static function udtEstCateg($categ) {

        DB::beginTransaction();
        try {
            DB::table('categoria')
                    ->whereRaw('id = ?', $categ['id'])
                    ->update([
                        'estatus' => $categ['estatus'],
                        'updated_at' => 'now()',
                        'usuario_upd' => Session::get('usuario_backend')->id
            ]);
            DB::table('candidato')
                    ->whereRaw('categoria_id = ?', $categ['id'])
                    ->update([
                        'estatus' => $categ['estatus'],
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

    public static function udtCateg($categ) {

        DB::beginTransaction();
        try {

            if ($categ['desCateg'] != "") {

                DB::table('categoria')
                        ->whereRaw('id = ?', $categ['cat_id'])
                        ->update([
                            'descateg' => $categ['desCateg'],
                            'descand' => $categ['desCand'],
                            'updated_at' => 'now()',
                            'usuario_upd' => Session::get('usuario_backend')->id
                ]);

                if (isset($categ['nombre'])) {
                    $nombre = true;
                } else {
                    $nombre = false;
                }
                if (isset($categ['infor'])) {
                    $infor = true;
                } else {
                    $infor = false;
                }
                if (isset($categ['gen'])) {
                    $gen = true;
                } else {
                    $gen = false;
                }
                if (isset($categ['generoArt'])) {
                    $generoArt = true;
                } else {
                    $generoArt = false;
                }
                if (isset($categ['img'])) {
                    $img = true;
                } else {
                    $img = false;
                }
                if (isset($categ['audio'])) {
                    $audio = true;
                } else {
                    $audio = false;
                }
                if (isset($categ['video'])) {
                    $video = true;
                } else {
                    $video = false;
                }
                if (isset($categ['redes'])) {
                    $redes = true;
                } else {
                    $redes = false;
                }
                if (isset($categ['pag'])) {
                    $pag = true;
                } else {
                    $pag = false;
                }
                if (isset($categ['cia'])) {
                    $cia = true;
                } else {
                    $cia = false;
                }
                if (isset($categ['seg'])) {
                    $seg = true;
                } else {
                    $seg = false;
                }

                DB::table('opcion')
                        ->whereRaw('categoria_id = ?', $categ['cat_id'])
                        ->update([
                            'nombre' => $nombre,
                            'infor' => $infor,
                            'gen' => $gen,
                            'generoart' => $generoArt,
                            'img' => $img,
                            'audio' => $audio,
                            'video' => $video,
                            'redes' => $redes,
                            'pag' => $pag,
                            'cia' => $cia,
                            'seg' => $seg,
                            'updated_at' => 'now()',
                            'usuario_upd' => Session::get('usuario_backend')->id
                ]);


                if (isset($categ['generoArt'])) {

                    DB::table('genero')
                            ->where('categoria_id', $categ['cat_id'])
                            ->delete();

                    if ($categ['gener'] == 0) {
                        $genero = array_keys(array_count_values($categ['generosArt']));
                        $num_for = count($genero);

                        for ($x = 0; $x < $num_for; $x++) {
                            DB::table('genero')->insert(
                                    ['nombre' => $genero[$x],
                                        'estatus' => 1,
                                        'categoria_id' => $categ['cat_id'],
                                        'create_at' => 'now()',
                                        'usuario_reg' => Session::get('usuario_backend')->id,
                                        'updated_at' => 'now()',
                                        'usuario_upd' => Session::get('usuario_backend')->id
                            ]);
                        }
                    } else if ($categ['gener'] == 1) {
                        $generocero = explode(",", $categ['generosValues']);
                        $genero = array_keys(array_count_values($generocero));
                        $num_for = count($genero);

                        for ($x = 0; $x < $num_for; $x++) {
                            DB::table('genero')->insert(
                                    ['nombre' => $genero[$x],
                                        'estatus' => 1,
                                        'categoria_id' => $categ['cat_id'],
                                        'create_at' => 'now()',
                                        'usuario_reg' => Session::get('usuario_backend')->id,
                                        'updated_at' => 'now()',
                                        'usuario_upd' => Session::get('usuario_backend')->id
                            ]);
                        }
                    }
                } else {
                    DB::table('genero')
                            ->where('categoria_id', $categ['cat_id'])
                            ->delete();
                }
                DB::commit();

                return true;
            } else {
                return false; /* No se ingreso ningun nombre de categoria intente nuevo */
            }
        } catch (\Exception $exc) {
            error_log($exc, 0);
            DB::rollback();
            return false;
        }
    }

}
