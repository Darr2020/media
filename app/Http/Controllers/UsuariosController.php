<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Usuario;
use App\Models\Perfil;

class LoginException extends \Exception {
    
}

class UsuariosController extends Controller {

    const USUARIO_PUBLICO = 1;
    const USUARIO_ADMINISTRADOR = 2;
    const USUARIO_EDITOR = 3;
    const USUARIO_ESCRITOR = 4;

    public $backend = [2,3,4];

 ///ingreso por backend 
    public function checkBAction(Request $request) {
        try {

            $this->isEmpty(trim($request->usuario));
            $this->isEmpty(trim($request->clave));
            $usuario_existe = Usuario::validar_usuario(trim($request->usuario));
            //dd('Usuario existe',$usuario_existe);
            
            if ($usuario_existe ==1) {   
                $user = trim($request->usuario);
                $pass = trim($request->clave); 
                $usuario = Usuario::obtener_usuario_by_email($user);
  
                if($usuario !=null){
                    $cv_bd = $usuario->clave;
                        if(trim($request->flagi)==1 ){
                               if(in_array($usuario->perfil_id, $this->backend)){
                                   if (password_verify($pass, $cv_bd)) {
                                        Auth::loginUsingId($usuario->id);    
                                        session(["usuario_backend" => $usuario]);
                                        ///////////////////  ¿Primer ingreso?   /////////////////////
                                        if($usuario->ingreso == false){
                                            return 0; //Para que cambie la clave
                                        }else{
                                            return 1; //dar ingreso al sistema
                                        }
                                    ////////////////////////////////////////////////////////////
                                    }else {
                                        return 91; //las claves no coinciden
                                    }


                               }else{
                                    return 92; //Usuario sin perfil backend
                               }                   
                        }
                }else{
                    return 4;//Usuario Inactivo
                }
            
      
            } else if ($usuario_existe==0) {
                return 90; //no existe en la BD
            }            

        } catch (LoginException $e) {
            return $e->getMessage();
        }
    }


///ingreso por frontend 
    public function checkFAction(Request $request) {
        try {
            $this->isEmpty(trim($request->usuario));
            $this->isEmpty(trim($request->clave));
            $usuario_existe = Usuario::validar_usuario(trim($request->usuario));
            if ($usuario_existe  ==1) {   
                $user = trim($request->usuario);
                $pass = trim($request->clave); 
                $usuario = Usuario::obtener_usuario_by_email($user);
        
                if($usuario !=null){
                $cv_bd = $usuario->clave;
                    ///ingreso por frontend 
                    if(trim($request->flagi)==2 ){  
                        if($usuario->perfil_id == self::USUARIO_PUBLICO){
                            if (password_verify($pass, $cv_bd)) {
                                unset($usuario->clave);
                                session(["usuario" => $usuario]);
                                return 1; //Perfil publico
                            } else {
                                return 91;
                            }
                        } else {
                            return 91; //las claves no coinciden
                        }
                    } else {
                        return 92; //Usuario sin perfil publico
                    }
                }else{
                    return 4;//Usuario Inactivo
                }
            } else if ($usuario_existe==0) {
                return 90; //no existe en la BD
            }            

        } catch (LoginException $e) {
            return $e->getMessage();
        }
    }


    public function isEmpty($data) {
        if (empty($data)) {
            throw new LoginException(4);
        }
    }


    public function indexAdminUsers() {
        $users_list = Usuario::get_all_users_backend(Session::get("usuario_backend")->id);
        return view("backend.usuario.admin_users",[
            "usuarios" => $users_list,
        ]);
    }

    public  function newUserBackend(){
        $perfiles = Perfil::whereRaW('id != ?',[1])->get();
        return view("backend.usuario.userb_new", [
            'perfiles' => $perfiles,
        ]);
    }


    public  function saveUserBackend(Request $request){
        ////////////// Verificar si el correo existe en la bd con el perfil backend
        $e_userb = Usuario::existe_usuariob($request->correob);

        if($e_userb==0){
            $guardar_userb = Usuario::save_userb($request->all(),Session::get("usuario_backend")->id);
            if($guardar_userb != false){
                return 1; //Exitoso
            }else{
                return 2; //Error al guardar
            }

        }else{
            return 0; //El correo ya existe con el perfil backend
        }
    }

    public function cambiarClaveUserb(){
        $data_user = Session::get("usuario_backend");
        return view("backend.usuario.userb_cambiar_clave",[
            "usuario" => $data_user
        ]);
    } 

    public function guardarCambioClaveUserb(Request $request){
        // chequear que la clave sea igual a la clave repetida
        if(trim($request->clave) == trim($request->clave_re) ) {
            $upass_userb = Usuario::update_userb_passw($request->user_id,$request->clave);
            if($upass_userb  == true){
                return 1;//Exito
            }else{
                return 2;//Falló la operación
            }

        }else{
            return 0; //Las claves no coinciden
        }
    }

    public function guardarCambioEstatusUserb(Request $request){
        $up_status_ub = Usuario::update_userb_status($request->all());
        if($up_status_ub == true){
            return 1; //Exito
        }else{
            return 2; //Falló
        }

    }

    public function reiniciarClaveUserb(Request $request){
        $reboot_passw = Usuario::update_userb_rebootPassw($request['user_id']);
        if($reboot_passw == true){
            return 1; //Exito
        }else{
            return 2; //Falló
        }

    }


    public function modalEditarUserBackend(Request $request){
        $data_userb = Usuario::obtener_info_userbById($request['user_id']);
        $perfiles = Perfil::whereRaW('id != ?',[1])->get();
    
        return view("backend.usuario.userb_edit",[
            "usuario" => $data_userb,
            "perfiles" => $perfiles
        ]);
    }


    public function updateUserBackend(Request $request){
        $update_ub = Usuario::update_userb_info($request->all());
        if($update_ub==true){
            return 1; //Exito
        }else{
            return 2; //Falló
        }

    }


////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////         FRONTEND    ///////////////////////////////////////////// 
    public function loginFrontendModal() {

        return view("frontend.login.loginf");
    }

    public function registerFrontendModal() {

        return view("frontend.login.registerf");
    }

    public function forgotPasswFrontendModal() {

        return view("frontend.login.forgotpf");
    }

    public function registerUserF(Request $request) {

        //verificamos si el correo existe con perfil frontend
        $existe_userf = Usuario::validar_usuario_front($request['correo']);
        if ($existe_userf == 0) {
            //El usuario no esta registrado en BD con el correo como proveedor
            //Verifdicar una vez más si la claves coinciden antes de guardar
            if ($request['password_again'] == $request['password']) {
                $suf_id = Usuario::guardar_usuario_front($request->all());
                if ($suf_id != false) {
                    return 1; //Exito. Debe enviarse correo con enlace para validarse
                } else {
                    return 2; //fallo
                }
            } else {
                return 0; //las claves no coinciden
            }
        } else {
            return 3;
        }
    }

}
