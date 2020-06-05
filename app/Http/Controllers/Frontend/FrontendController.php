<?php

namespace App\Http\Controllers\Frontend;

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

class FrontendController extends Controller {

    public function __construct() {

        $this->params = array();
    }

    public function index() {

        return view('backend.frontend.categoria');
    }

    public function carousel() {

        $this->params['data']['carousel'] = AdministradorWeb::consulbanner();
        $this->params['posicionuod'] = AdministradorWeb::posicion();

        return view("backend.frontend.admincarrusel", ['params' => $this->params]);
    }

    public function posicioncatg() {

        $this->params['data']['posicioncatg'] = AdministradorWeb::consulPosCateg();
        $this->params['posicionuod'] = AdministradorWeb::posicion();

        return view("backend.frontend.poscateg", ['params' => $this->params]);
    }

    public function activaciones(Request $request) {

        if ($request->ajax()) {

            $saves = AdministradorWeb::udtEstBanner($request->all());

            if ($saves === true) {
                return response()->json(1);
            } else {
                return response()->json(2);
            }
        }
    }

    public function consultas(Request $request) {

        $this->params['opt'] = $request->opt;
        $this->params['bannerid'] = AdministradorWeb::consulbannerId($request->id);
        $this->params['posicionnew'] = AdministradorWeb::consulPosicionNew();
        $this->params['posicionuod'] = AdministradorWeb::posicion();

        return view("backend.frontend.cebanner", ['params' => $this->params]);
    }

    public function guardarBanner(Request $request) {

        if ($request->tipo != 3) {
            $saves = AdministradorWeb::savesBanner($request->all());
        } else if ($request->tipo == 3) {
            $saves = AdministradorWeb::posCategoria($request->all());
        }
        if ($saves) {
            return response()->json($saves);
        }
    }

    public function cambiarColor(Request $request) {

        if ($request->ajax()) {

            $saves = AdministradorWeb::cambiarColor($request->all());

            if ($saves === true) {
                return response()->json(1);
            } else {
                return response()->json(2);
            }
        }
    }

}
