<?php

namespace App\Http\Controllers\Candidato;

use App\Http\Controllers\Controller;
use App\Models\Candidato;
use App\Models\CandidatoRedes;
use App\Models\Categoria;
use App\Models\Genero;
use App\Models\Opcion;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;
use Illuminate\Http\Request;
use Spipu\Html2Pdf\Html2Pdf;

class CandidatoController extends Controller {

    public function __construct() {

        $this->params = array();
    }

    public function consulCandit() {

        $this->params['data']['categ'] = Categoria::consulCategActivas();

        return view("backend.categoria.ccandit", ['params' => $this->params]);
    }

    public function getCandit(Request $request) {

        if ($request->ajax()) {
            $this->params['data']['cand'] = Candidato::consulCandCatgId($request->id);

            return response()->json($this->params['data']['cand']);
        }
    }

    public function guardarCandiop(Request $request) {

        $saves = Candidato::savesCadnn($request->all());

        if ($saves) {
            return response()->json($saves);
        }
    }

    public function buscandoCandidato(Request $request) {

        if ($request->ajax()) {
            $candidato_id = Candidato::exisCandCatgId($request->id, $request->nombre);
            if ($candidato_id == false) {
                return response()->json(false);
            } else {
                $this->params['data']['cand'] = Candidato::consulCandtosId($candidato_id);
                return response()->json($this->params['data']['cand']);
                //return response()->json(1);
            }
        }
    }

}
