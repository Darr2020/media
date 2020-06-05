<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class ProfileMiddleware
{

    private $perfiles = ['admin','editor','escritor'];

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $perfil)
    {
        $perfilesSolicitados = explode('|',$perfil);
        
        foreach($perfilesSolicitados as $perfil){
            if(Auth::user()->is($perfil)){
                return $next($request);
            }
        }

        if($request->ajax()){
            return response()->json([
                'error' => 'Permiso denegado.'
            ]);
        } else {
            return redirect('404'); 
        }
    }
}
