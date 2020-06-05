<?php

namespace App\Models;

use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Input;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use DB;

class Candidato extends Model {

    public $table = "candidato";

    public static function consulCand() {

        $consulta = DB::table('candidato')
                ->select('id', DB::raw('initcap(nombre) AS nombre'), 'detalle', 'sexo', 'pag', 'seguidores', 'categoria_id', 'estatus')
                ->orderBy('id', 'asc')
                ->get();

        if (!sizeof($consulta) == 0) {

            foreach ($consulta as $candidato) {

                $params[] = $candidato;
            }

            return $params;
        }

        return false;
    }

    public static function consulCandId($id) {

        $consulta = DB::table('candidato')
                ->select('id', DB::raw('initcap(nombre) AS nombrecandidato'), 'detalle', 'sexo', 'pag', 'seguidores', 'categoria_id', 'estatus')
                ->whereRaw('id = ?', [$id])
                ->get();

        if (!sizeof($consulta) == 0) {

            foreach ($consulta as $candidato) {

                $params[] = $candidato;
            }

            return $params;
        }

        return false;
    }

    public static function consulCandGenId($id) {

        $consulta = DB::table('candidato_genero')
                ->leftJoin('genero', 'genero.id', '=', 'candidato_genero.genero_id')
                ->select('genero.id AS gen_id', DB::raw('initcap(genero.nombre) AS nombregenero'))
                ->whereRaw('candidato_genero.candidato_id = ?', [$id])
                ->get();

        if (!sizeof($consulta) == 0) {

            foreach ($consulta as $candidato) {

                $params[] = $candidato;
            }

            return $params;
        }

        return false;
    }

    public static function consulGenerCatgId($id, $categoria_id) {

        $consulta = DB::select(DB::raw("select genero.id, initcap(genero.nombre) AS nombregenero
                                        from genero where genero.categoria_id = " . $categoria_id . " and genero.id NOT IN
                                        (select candidato_genero.genero_id 
                                        from candidato_genero, genero
                                        where candidato_genero.candidato_id = " . $id . ")
                                        "));
        if (!sizeof($consulta) == 0) {

            foreach ($consulta as $candidato) {

                $params[] = $candidato;
            }

            return $params;
        }

        return false;
    }

    public static function consulCandMultId($id) {

        $consulta = DB::table('candidato_multimedia')
                ->select('candidato_multimedia.img', 'candidato_multimedia.audio', 'candidato_multimedia.video', 'candidato_multimedia.empresa')
                ->whereRaw('candidato_multimedia.candidato_id = ?', [$id])
                ->whereRaw('candidato_multimedia.estatus = ?', 1)
                ->get();

        if (!sizeof($consulta) == 0) {

            foreach ($consulta as $candidato) {

                $params[] = $candidato;
            }

            return $params;
        }

        return false;
    }

    public static function consulCanRedestId($id) {

        $consulta = DB::table('candidato_redes')
                ->select('candidato_redes.id', 'candidato_redes.nombre AS nombreredes')
                ->whereRaw('candidato_redes.candidato_id = ?', [$id])
                ->get();

        if (!sizeof($consulta) == 0) {

            foreach ($consulta as $candidato) {

                $params[] = $candidato;
            }

            return $params;
        }

        return false;
    }

    public static function consulCandCatgId($id) {

        $consulta = DB::table('candidato')
                ->select('id', DB::raw('initcap(nombre) AS nombre'), 'detalle', 'sexo', 'pag', 'seguidores', 'estatus')
                ->whereRaw('categoria_id = ?', [$id])
                ->get();

        if (!sizeof($consulta) == 0) {

            foreach ($consulta as $candidato) {

                $params[] = $candidato;
            }

            return $params;
        }

        return false;
    }

    public static function consulCandtosId($candtos) {

        foreach ($candtos as $key => $id) {

            $consulta[] = DB::table('candidato')
                    ->select('id', DB::raw('initcap(nombre) AS nombrecandidato'))
                    ->whereRaw('id = ?', $id)
                    ->get();
        }
        if (!sizeof($consulta) == 0) {

            return $consulta;
        }
        return false;
    }

    public static function exisCandCatgId($id, $nombre) {

        $consulta = DB::select(DB::raw("select candidato.id from candidato 
                                        where candidato.categoria_id = " . $id . " 
                                        and candidato.nombre ILIKE '%" . $nombre . "%'"));
        if (!sizeof($consulta) == 0) {

            foreach ($consulta as $candidato) {

                $params[] = $candidato;
            }

            return $params;
        }

        return false;
    }

    public static function savesCadnn($Cand) {

        DB::beginTransaction();
        try {

            if ($Cand['nombre'] != "") {
                $fecha = date("d-m-Y");

                if (isset($Cand['gen'])) {
                    $gen = $Cand['gen'];
                } else {
                    $gen = 0;
                }
                if (isset($Cand['infor'])) {
                    $infor = $Cand['infor'];
                } else {
                    $infor = null;
                }
                if (isset($Cand['pag'])) {
                    $pag = $Cand['pag'];
                } else {
                    $pag = null;
                }
                if (isset($Cand['seg'])) {
                    $seg = $Cand['seg'];
                } else {
                    $seg = null;
                }

                if ($Cand['tipo'] == 1) {
                    $candidato_id = DB::table('candidato')->insertGetId(
                            ['categoria_id' => $Cand['categ'],
                                'nombre' => $Cand['nombre'],
                                'detalle' => $infor,
                                'sexo' => $gen,
                                'pag' => $pag,
                                'seguidores' => $seg,
                                'estatus' => 1,
                                'create_at' => 'now()',
                                'usuario_reg' => Session::get('usuario_backend')->id,
                                'updated_at' => 'now()',
                                'usuario_upd' => Session::get('usuario_backend')->id
                    ]);

                    if (isset($Cand['generoArt'])) {
                        $generos = array_keys(array_count_values($Cand['generoArt']));
                        $num_for = count($generos);
                        for ($x = 0; $x < $num_for; $x++) {
                            DB::table('candidato_genero')->insert(
                                    ['candidato_id' => $candidato_id,
                                        'genero_id' => $generos[$x],
                                        'estatus' => 1,
                                        'create_at' => 'now()',
                                        'usuario_reg' => Session::get('usuario_backend')->id,
                                        'updated_at' => 'now()',
                                        'usuario_upd' => Session::get('usuario_backend')->id
                            ]);
                        }
                    }

                    if (isset($Cand['redes'])) {
                        $redes = array_keys(array_count_values($Cand['redes']));
                        $num_for = count($redes);

                        for ($x = 0; $x < $num_for; $x++) {
                            DB::table('candidato_redes')->insert(
                                    ['nombre' => $redes[$x],
                                        'candidato_id' => $candidato_id,
                                        'estatus' => 1,
                                        'create_at' => 'now()',
                                        'usuario_reg' => Session::get('usuario_backend')->id,
                                        'updated_at' => 'now()',
                                        'usuario_upd' => Session::get('usuario_backend')->id
                            ]);
                        }
                    }
                } else {
                    if ($Cand['moom'] == 1) {

                        if (isset($Cand['gen'])) {
                            $gen = $Cand['gen'];
                        } else {
                            $gen = 0;
                        }
                        if (isset($Cand['infor'])) {
                            $infor = $Cand['infor'];
                        } else {
                            $infor = null;
                        }

                        DB::table('candidato')
                                ->whereRaw('id = ?', $Cand['cand_id'])
                                ->update([
                                    'detalle' => $infor,
                                    'sexo' => $gen,
                                    'updated_at' => 'now()',
                                    'usuario_upd' => Session::get('usuario_backend')->id
                        ]);
                    }

                    if ($Cand['moom'] == 2) {
                        if (isset($Cand['generoArt'])) {

                            DB::table('candidato_genero')
                                    ->where('candidato_id', $Cand['cand_id'])
                                    ->delete();

                            $generos = array_keys(array_count_values($Cand['generoArt']));
                            $num_for = count($generos);
                            for ($x = 0; $x < $num_for; $x++) {
                                DB::table('candidato_genero')->insert(
                                        ['candidato_id' => $Cand['cand_id'],
                                            'genero_id' => $generos[$x],
                                            'estatus' => 1,
                                            'create_at' => 'now()',
                                            'usuario_reg' => Session::get('usuario_backend')->id,
                                            'updated_at' => 'now()',
                                            'usuario_upd' => Session::get('usuario_backend')->id
                                ]);
                            }
                        }
                    }

                    if ($Cand['moom'] == 3) {

                        if (isset($Cand['pag'])) {
                            $pag = $Cand['pag'];
                        } else {
                            $pag = null;
                        }
                        if (isset($Cand['seg'])) {
                            $seg = $Cand['seg'];
                        } else {
                            $seg = null;
                        }

                        DB::table('candidato')
                                ->whereRaw('id = ?', $Cand['cand_id'])
                                ->update([
                                    'pag' => $pag,
                                    'seguidores' => $seg,
                                    'updated_at' => 'now()',
                                    'usuario_upd' => Session::get('usuario_backend')->id
                        ]);
                        if (isset($Cand['redes'])) {

                            DB::table('candidato_redes')
                                    ->where('candidato_id', $Cand['cand_id'])
                                    ->delete();

                            $redes = array_keys(array_count_values($Cand['redes']));
                            $num_for = count($redes);

                            for ($x = 0; $x < $num_for; $x++) {
                                DB::table('candidato_redes')->insert(
                                        ['nombre' => $redes[$x],
                                            'candidato_id' => $Cand['cand_id'],
                                            'estatus' => 1,
                                            'create_at' => 'now()',
                                            'usuario_reg' => Session::get('usuario_backend')->id,
                                            'updated_at' => 'now()',
                                            'usuario_upd' => Session::get('usuario_backend')->id
                                ]);
                            }
                        }
                    }
                }

                if (isset($Cand['imgg'])) {
                    if ($Cand['imgg'] != 0) {
                        if ($Cand['tipo'] == 2) {
                            $candidato_id = $Cand['cand_id'];
                        }
                        $tipo = $Cand['imgg']->getClientMimeType();
                        $ext = $Cand['imgg']->getClientOriginalExtension();
                        if ($tipo == 'image/jpeg' || $tipo == 'image/jpg' || $tipo == 'image/png' || $tipo == 'image/gif') {
                            $nombre_file = $Cand['categ'] . '_' . $candidato_id . '_' . $fecha . '.' . $ext;
                            $upload_success = $Cand['imgg']->move(public_path() . '/candidatos/images', $nombre_file);
                            //Si se sube el archivo en la carpeta, se guarda en BD
                            if ($upload_success) {

                                if ($Cand['tipo'] == 2) {

                                    DB::table('candidato_multimedia')
                                            ->whereRaw('candidato_id = ?', $Cand['cand_id'])
                                            ->update([
                                                'estatus' => 2,
                                                'updated_at' => 'now()',
                                                'usuario_upd' => Session::get('usuario_backend')->id
                                    ]);
                                    $candidato_id = $Cand['cand_id'];
                                }

                                $multiId = DB::table('candidato_multimedia')->insertGetId(
                                        ['img' => $nombre_file,
                                            'candidato_id' => $candidato_id,
                                            'estatus' => 1,
                                            'create_at' => 'now()',
                                            'usuario_reg' => Session::get('usuario_backend')->id,
                                            'updated_at' => 'now()',
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
                if (isset($Cand['aud'])) {
                    if ($Cand['aud'] != 0) {
                        if ($Cand['tipo'] == 2) {
                            $candidato_id = $Cand['cand_id'];
                        }
                        $tipoa = $Cand['aud']->getClientMimeType();
                        $exta = $Cand['aud']->getClientOriginalExtension();
                        if ($tipoa === 'audio/mpeg' || $tipoa === 'audio/mp3' || $tipoa === 'application/octet-stream') {
                            $nombre_file = $Cand['categ'] . '_' . $candidato_id . '_' . $fecha . '.' . $exta;
                            $upload_success = $Cand['aud']->move(public_path() . '/candidatos/audio', $nombre_file);
                            //Si se sube el archivo en la carpeta, se guarda en BD
                            if ($upload_success) {
                                if (isset($multiId)) {
                                    DB::table('candidato_multimedia')
                                            ->whereRaw('id = ?', $multiId)
                                            ->update([
                                                'audio' => $nombre_file,
                                                'updated_at' => 'now()',
                                                'usuario_upd' => Session::get('usuario_backend')->id
                                    ]);
                                } else {
                                    if ($Cand['tipo'] == 2) {

                                        DB::table('candidato_multimedia')
                                                ->whereRaw('candidato_id = ?', $Cand['cand_id'])
                                                ->update([
                                                    'estatus' => 2,
                                                    'updated_at' => 'now()',
                                                    'usuario_upd' => Session::get('usuario_backend')->id
                                        ]);
                                        $candidato_id = $Cand['cand_id'];
                                    }
                                    $multiId = DB::table('candidato_multimedia')->insertGetId(
                                            ['audio' => $nombre_file,
                                                'candidato_id' => $candidato_id,
                                                'estatus' => 1,
                                                'create_at' => 'now()',
                                                'usuario_reg' => Session::get('usuario_backend')->id,
                                                'updated_at' => 'now()',
                                                'usuario_upd' => Session::get('usuario_backend')->id
                                    ]);
                                }
                            } else {
                                return 5; //No se pudo guardar el audio en la carpeta
                            }
                        } else {
                            return 6;  //Error de formato en el audio debe ser 'audio/mpeg' 'audio/mp3' 'application/octet-stream'
                        }
                    }
                }
                if (isset($Cand['video'])) {
                    if (isset($multiId)) {
                        DB::table('candidato_multimedia')
                                ->whereRaw('id = ?', $multiId)
                                ->update([
                                    'video' => $Cand['video'],
                                    'updated_at' => 'now()',
                                    'usuario_upd' => Session::get('usuario_backend')->id
                        ]);
                    } else {
                        if ($Cand['tipo'] == 2) {

                            DB::table('candidato_multimedia')
                                    ->whereRaw('candidato_id = ?', $Cand['cand_id'])
                                    ->update([
                                        'estatus' => 2,
                                        'updated_at' => 'now()',
                                        'usuario_upd' => Session::get('usuario_backend')->id
                            ]);
                            $candidato_id = $Cand['cand_id'];
                        }
                        $multiId = DB::table('candidato_multimedia')->insertGetId(
                                ['video' => $Cand['video'],
                                    'candidato_id' => $candidato_id,
                                    'estatus' => 1,
                                    'create_at' => 'now()',
                                    'usuario_reg' => Session::get('usuario_backend')->id,
                                    'updated_at' => 'now()',
                                    'usuario_upd' => Session::get('usuario_backend')->id
                        ]);
                    }
                }

                if (isset($Cand['cia'])) {
                    if (isset($multiId)) {
                        DB::table('candidato_multimedia')
                                ->whereRaw('id = ?', $multiId)
                                ->update([
                                    'empresa' => $Cand['cia'],
                                    'updated_at' => 'now()',
                                    'usuario_upd' => Session::get('usuario_backend')->id
                        ]);
                    } else {
                        if ($Cand['tipo'] == 2) {

                            DB::table('candidato_multimedia')
                                    ->whereRaw('candidato_id = ?', $Cand['cand_id'])
                                    ->update([
                                        'estatus' => 2,
                                        'updated_at' => 'now()',
                                        'usuario_upd' => Session::get('usuario_backend')->id
                            ]);
                            $candidato_id = $Cand['cand_id'];
                        }
                        DB::table('candidato_multimedia')->insert(
                                ['empresa' => $Cand['cia'],
                                    'candidato_id' => $candidato_id,
                                    'estatus' => 1,
                                    'create_at' => 'now()',
                                    'usuario_reg' => Session::get('usuario_backend')->id,
                                    'updated_at' => 'now()',
                                    'usuario_upd' => Session::get('usuario_backend')->id
                        ]);
                    }
                }
                DB::commit();
                return 1;
            } else {
                return 2; /* No se ingreso ningun nombre de candidato intente nuevo */
            }
        } catch (\Exception $exc) {
            error_log($exc, 0);
            DB::rollback();
            return 7; /* No se guardo la informacion en base de datos */
        }
    }

    public static function udtEstCand($Cand) {

        DB::beginTransaction();
        try {
            DB::table('candidato')
                    ->whereRaw('id = ?', $Cand['id'])
                    ->update([
                        'estatus' => $Cand['estatus'],
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

    public static function udtCand($Cand) {

        DB::beginTransaction();
        try {

            DB::table('candidato')
                    ->whereRaw('id = ?', [$Cand['id']])
                    ->update([
                        'nombre' => $Cand['nombre'],
                        'infor' => $Cand['inform'],
                        'gen' => $Cand['generp'],
                        'img' => $Cand['imagen'],
                        'audio' => $Cand['audio'],
                        'video' => $Cand['video'],
                        'pag' => $Cand['pagina'],
                        'cia' => $Cand['cia'],
                        'seg' => $Cand['seguid'],
                        'categoria_id' => $Cand['categoria_id'],
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

}
