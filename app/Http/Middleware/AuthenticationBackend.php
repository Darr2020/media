<?php

namespace App\Http\Middleware;

use Closure;

class AuthenticationBackend {

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next) {
        
        if (!$request->session()->has("usuario_backend")){
            return redirect()->route("backend_login");
        }
        
        return $next($request);
    }

}
