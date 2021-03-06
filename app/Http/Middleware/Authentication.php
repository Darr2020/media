<?php

namespace App\Http\Middleware;

use Closure;

class Authentication {

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next) {
        
        if (!$request->session()->has("usuario")){
            return redirect()->route("pagina_principal");
        }
        
        return $next($request);
    }

}
