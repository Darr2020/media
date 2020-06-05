<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\DB;

Class Usuario extends Authenticatable{

    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = "usuario";
    protected $fillable = [
        'nombre', 'correo', 'avatar', 'clave',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'clave', 'remember_token',
    ];

    public static function validar_usuario($correo) {
        return DB::table('usuario as u')
                        ->whereRaw('u.correo = ?', [$correo])
                        ->select('u.*')->count();
    }

    public static function obtener_usuario_by_email($correo) {
        $user_id = DB::table('usuario as u')
                ->whereRaw('u.correo = ?', [$correo])
                ->where("u.estatus", "=", true)
                ->select('u.id')
                ->first();

        if ($user_id) {

            $user_perfil = DB::table('usuario_perfil as up')
                    ->join('usuario as u', 'up.usuario_id', '=', 'u.id')
                    ->join('perfil as p', 'up.perfil_id', '=', 'p.id')
                    ->whereRaw('up.usuario_id = ?', [$user_id->id])
                    ->select('u.*', 'up.perfil_id', 'p.descripcion as perfil')
                    ->first();

            return $user_perfil;
        }
    }

    public static function obtener_usuario_by_id($user_id) {
        $user_perfil = DB::table('usuario_perfil as up')
                ->join('usuario as u', 'up.usuario_id', '=', 'u.id')
                ->join('perfil as p', 'up.perfil_id', '=', 'p.id')
                ->whereRaw('up.usuario_id = ?', [$user_id])
                ->select('u.*', 'up.perfil_id', 'p.descripcion as perfil')
                ->first();

        return $user_perfil;
    }

        public static function validar_usuario_front($correo) {
        return DB::table('usuario as u')
                        ->leftJoin('usuario_perfil','usuario_perfil.usuario_id','=','u.id')
                        ->whereRaw('u.correo = ?', [$correo])
                        ->whereRaw('usuario_perfil.perfil_id = ?', [1])
                        ->where("u.proveedor", "=", 'correo')
                        ->select('u.*')->count();
    }


    public static function get_all_users_backend($user_id){
        return DB::table('usuario as u')
                ->join('usuario_perfil as up', 'up.usuario_id', '=', 'u.id')
                ->join('perfil as p', 'up.perfil_id', '=', 'p.id')
                ->whereRaw('up.perfil_id != ?',[1])
                ->whereRaw('u.id <>?', [$user_id])
                ->select('u.*', 'up.perfil_id', 'p.descripcion as perfil')
                ->get();
    }    
    
    public static function existe_usuariob($correo){
    return DB::table('usuario as u')
                ->join('usuario_perfil as up', 'up.usuario_id', '=', 'u.id')
                ->join('perfil as p', 'up.perfil_id', '=', 'p.id')
                ->whereRaw('u.correo = ?', [$correo])
                ->where('up.perfil_id',"=",2 )
                ->select('u.*')
                ->count();
    }

    public static function obtener_info_userbById($user_id){
                return DB::table('usuario as u')
                ->join('usuario_perfil as up', 'up.usuario_id', '=', 'u.id')
                ->join('perfil as p', 'up.perfil_id', '=', 'p.id')
                ->whereRaw('u.id =?', [$user_id])
                ->select('u.id','u.nombre','u.correo','up.perfil_id','p.descripcion as perfil')
                ->get();
    }

    public function perfil(){
        return $this->hasOne(\App\Models\UsuarioPerfil::class, 'usuario_id');
    }

    public function is($permision){
        if(is_array($permision)){
            foreach($permision as $p){
                switch($p){
            
                    case 'admin':
                    $result = ($this->perfil->perfil_id == 2);
                    break;
        
                    case 'editor':
                    $result = ($this->perfil->perfil_id == 3);
                    break;
        
                    case 'escritor':
                    $result = ($this->perfil->perfil_id == 4);
                    break;
        
                }
                if($result == true){
                    return true;
                }
            }
            return false;
        } else {
            switch($permision){
            
                case 'admin':
                return ($this->perfil->perfil_id == 2);
                break;
    
                case 'editor':
                return ($this->perfil->perfil_id == 3);
                break;
    
                case 'escritor':
                return ($this->perfil->perfil_id == 4);
                break;
    
            }
        }
    }




    public static function save_userb($params,$user_id) {
        DB::beginTransaction();
        try {
            $userb_id =  DB::table('usuario')->insertGetId(
                    [
                        'nombre' => ucwords(strtolower(trim($params['nombreb']))),
                        'correo' => strtolower(trim($params['correob'])),
                        'clave' => bcrypt('Metrica*2018'),
                        'proveedor' => 'correo',
                        'validado' => false, //Cuando cambie la clave se colocará en true
                        'ingreso' => false,
                    ]
            );

            if ($userb_id) {
                DB::table('usuario_perfil')->insert(
                        [
                            'usuario_id' => $userb_id,
                            'perfil_id' => $params['perfilb']
                        ]
                );
            }

            DB::commit();
            return $userb_id;
        } catch (\Exception $exc) {
            error_log($exc, 0);
            DB::rollback();
            return false;
        }
    }


    public static function update_userb_passw($user_id,$clave){
        DB::beginTransaction();
        try {
            DB::table('usuario')
                    ->whereRaw('id = ?', [$user_id])
                    ->update([
                        'clave' => bcrypt($clave),
                        'validado' => true,
                        'ingreso' => true
            ]);

            DB::commit();
            return true;
        } catch (\Exception $exc) {
            error_log($exc, 0);
            DB::rollback();
            return false;
        }
    }


    public static function update_userb_status($params){
        DB::beginTransaction();
        try {
            DB::table('usuario')
                    ->whereRaw('id = ?', [$params['user_id']])
                    ->update([
                        'estatus' => $params['valor']
            ]);

            DB::commit();
            return true;
        } catch (\Exception $exc) {
            error_log($exc, 0);
            DB::rollback();
            return false;
        }
    }


    public static function update_userb_rebootPassw($user_id){
        DB::beginTransaction();
        try {
            DB::table('usuario')
                    ->whereRaw('id = ?', [$user_id])
                    ->update([
                        'clave' => bcrypt('Metrica*2018'),
                        'validado' => false, 
                        'ingreso' => false
            ]);

            DB::commit();
            return true;
        } catch (\Exception $exc) {
            error_log($exc, 0);
            DB::rollback();
            return false;
        }
    }


    public static function update_userb_info($params){
        DB::beginTransaction();
        try {
            DB::table('usuario')
                ->whereRaw('id = ?', [$params['user_id']])
                ->update([
                    'nombre' => ucwords(strtolower(trim($params['nombreb']))),
                    'correo' => strtolower(trim($params['correob'])),
            ]);
            
            DB::table('public.usuario_perfil')
                ->where('usuario_id', $params['user_id'])
                ->update([
                    'perfil_id' => $params['perfilb']
                ]);
            

            DB::commit();
            return true;
        } catch (\Exception $exc) {
            error_log($exc, 0);
            DB::rollback();
            return false;
        } 
    }


    
    ////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////          FRONTEND              /////////////////////////////////  

    public static function save_user($social_user, $provider) {
        DB::beginTransaction();
        try {
            $user_id = DB::table('usuario')->insertGetId(
                    [
                        'nombre' => $social_user->name,
                        'correo' => $social_user->email,
                        'avatar' => $social_user->avatar,
                        'proveedor' => $provider,
                        'validado' => true,
                    ]
            );

            DB::table('usuario_perfil')->insert(
                    [
                        'usuario_id' => $user_id,
                        'perfil_id' => 1,
                    ]
            );

            DB::commit();
            return $user_id;
        } catch (\Exception $exc) {
            error_log($exc, 0);
            DB::rollback();
            return false;
        }
    }

    public static function guardar_usuario_front($params) {
        DB::beginTransaction();
        try {
            $userf_id = DB::table('usuario')->insertGetId(
                    [
                        'nombre' => $params['nombre'],
                        'correo' => $params['correo'],
                        'clave' => bcrypt($params['password']),
                        'proveedor' => 'correo',
                        'validado' => true //Cuando se envie el correo cambiar por false
                    ]
            );

            if ($userf_id) {
                DB::table('usuario_perfil')->insert(
                        [
                            'usuario_id' => $userf_id,
                            'perfil_id' => 1
                        ]
                );
            }

            DB::commit();
            return $userf_id;
        } catch (\Exception $exc) {
            error_log($exc, 0);
            DB::rollback();
            return false;
        }
    }

}
