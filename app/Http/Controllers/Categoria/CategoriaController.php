<?php

namespace App\Http\Controllers\Categoria;

use App\Http\Controllers\Controller;
use App\Models\Candidato;
use App\Models\CandidatoRedes;
use App\Models\Categoria;
use App\Models\Genero;
use App\Models\Opcion;
use App\Models\AdministradorWeb;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Comun\AppComun;
use Illuminate\Support\Facades\View;
use Illuminate\Http\Request;
use Spipu\Html2Pdf\Html2Pdf;

class CategoriaController extends Controller {

    public function __construct() {

        $this->params = array();
    }

    public function index() {

        return view('backend.categoria.categoria');
    }

    public function consulCateg() {

        $this->params['data']['categ'] = Categoria::consulCategActivas();
        
        return view("backend.categoria.area", ['params' => $this->params]);
    }

    public function consulCat(Request $request) {

        if ($request->ajax()) {

            $this->params['data']['categ'] = Categoria::consulCateg();
            return response()->json($this->params['data']['categ']);
        }

        return view("backend.categoria.carea");
    }

    public function guardarCateg(Request $request) {

        if ($request->tipo == 1) {
            $saves = Categoria::savesCateg($request->all());
        } else if ($request->tipo == 2) {
            $saves = Categoria::udtCateg($request->all());
        }

        if ($saves === true) {
            return response()->json(1);
        } else {
            return response()->json(2);
        }
    }

    public function getCatg(Request $request) {

        if ($request->ajax()) {
            $this->params['data']['opciones'] = Opcion::consulOpcioCatgId($request->id);
            $this->params['data']['generos'] = Genero::consulGenerCatgId($request->id);

            return response()->json($this->params['data']);
        }
    }

    public function activaciones(Request $request) {

        if ($request->ajax()) {

            if ($request->opt == 1 || $request->opt == 2) {
                $saves = Categoria::udtEstCateg($request->all());
            } else  if ($request->opt == 5 || $request->opt == 6) {
                $saves = Candidato::udtEstCand($request->all());
            }

            if ($saves === true) {
                return response()->json(1);
            } else {
                return response()->json(2);
            }
        }
    }

    public function consultas(Request $request) {

        if ($request->opt == 3 || $request->opt == 4) {

            $this->params['data']['categoria'] = Categoria::consulCategId($request->id);
            $this->params['data']['opciones'] = Opcion::consulOpcioCatgId($request->id);
            $this->params['data']['generos'] = Genero::consulGenerCatgId($request->id);
            
            if ($request->opt == 3) {
                return view("backend.categoria.ccategoria", ['params' => $this->params]);
            } else if ($request->opt == 4 && $request->cond == 0) {
                return view("backend.categoria.ecategoria", ['params' => $this->params]);
            } else {
                return false;
            }
            
        } else if ($request->opt == 7 || $request->opt == 8) {
            $this->params['data']['candidato'] = Candidato::consulCandId($request->id);
            $this->params['data']['generos'] = Candidato::consulCandGenId($request->id);
            $this->params['data']['genero'] = Candidato::consulGenerCatgId($request->id,$this->params['data']['candidato'][0]->categoria_id);
            $this->params['data']['multimedia'] = Candidato::consulCandMultId($request->id);
            $this->params['data']['redes'] = Candidato::consulCanRedestId($request->id);

            if ($request->opt == 7) {
                return view("backend.categoria.ccandidato", ['params' => $this->params]);
            } else if ($request->opt == 8) {
                return view("backend.categoria.ecandidato", ['params' => $this->params]);
            }
        }
    }

}
