<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use App\Models\Votacion;
use App\Models\Usuario;

class VotacionController extends Controller {

    public function votando(Request $request) {

        if ($request->ajax()) {
            $saves = Votacion::savesVoto($request->all());

            if ($saves === true) {
                return response()->json(1);
            } else {
                return response()->json(2);
            }
        }
    }
    public function contacto(Request $request) {

        if ($request->ajax()) {
            $saves = Usuario::savesContacto($request->all());

            if ($saves === true) {
                return response()->json(1);
            } else {
                return response()->json(2);
            }
        }
    }

}
