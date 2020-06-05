<?php

namespace App\Http\Controllers;

use Socialite;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Usuario;

class SocialLoginController extends Controller {

    // Metodo encargado de la redireccion a la red social
    public function redirectToProvider($provider) {
        return Socialite::driver($provider)->redirect();
    }

    // Metodo encargado de obtener la información del usuario
    public function handleProviderCallback($provider) {

        // Obtenemos los datos del usuario
        $social_user = Socialite::driver($provider)->user();
        // Comprobamos si el usuario ya existe
        $usuario_existe = Usuario::validar_usuario($social_user->email,$provider);

        if ($usuario_existe) {
            $user = Usuario::obtener_usuario_by_email($social_user->email);

            return $this->authAndRedirect($user); // Login y redirección
        } else {
            // En caso de que no exista creamos un nuevo usuario con sus datos.
            //Para crear el usuario en BD
            $userId = Usuario::save_user($social_user,$provider); //esta retornando true o false; Ahora retorna el id del usuario
            $user = Usuario::obtener_usuario_by_id($userId);
            return $this->authAndRedirect($user); // Login y redirección
        }
    }

    // Login y redirección
    public function authAndRedirect($user) {        
        session(["usuario" => $user]);
        $perfilId = $user->perfil_id;
        /////// De acuerdo al perfil mostrar el frontend o el backend
        if ($perfilId == 1) {
            return redirect('/');
        } 
    }

}
