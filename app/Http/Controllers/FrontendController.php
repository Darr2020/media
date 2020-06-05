<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Principal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use App\Models\CmGustos;

class FrontendController extends Controller {

    /**
     * Renderizar iFrame de topRanking
     * @param null
     */
    public function topRankingIframe() {
        $data = Principal::extarerHomePrincipal();

        if ($data) {
            $data = self::parseData($data);
        }

        return view('frontend.iframes.topranking')->with(compact('data'));
    }

    /**
     * Formatear de forma mas flexible información del topRanking
     * @param Array|Null $data - Toda la información del TopRanking
     */
    public static function parseData($data) {
        $accepted = ['puntaje', 'nombrecandidato', 'encuesta_id', 'categoria_id', 'tipo_encuesta', 'votos', 'img', 'generos', 'votos'];
        $currentCategory = '';
        $result = [];
        foreach ($data as $candidatos) {
            foreach ($candidatos as $key => $single) {
                if ($single['nombre_categoria'] != $currentCategory) {
                    $currentCategory = strtoupper($single['nombre_categoria']);
                }
                $result[$currentCategory][$key] = new \stdClass();
                foreach ($single as $keyOld => $attr) {
                    if (in_array($keyOld, $accepted)) {
                        $result[$currentCategory][$key]->{$keyOld} = (is_string($attr)) ? strtoupper($attr) : $attr;
                    }
                }
            }
        }
        return $result;
    }

    public function principal() {

        $this->params['carousel'] = Principal::consulbanner(); 
        $this->params['home'] = Principal::extarerHomePrincipal();
        if ($this->params['home'] != false) {
            $this->params['rankweb'] = count($this->params['home']);
        }

        return view("frontend.home.principal", ['params' => $this->params]);
    }

    public function categoria_detalle(Request $request) {

        $this->params['data']['categorias'] = Principal::consulCategId($request->id);
        $this->params['data']['candweb'] = Principal::candweb($request->id);
        $this->params['data']['candtlf'] = Principal::candtlf($request->id);
        $this->params['data']['rankingweb'] = Principal::rankingweb($this->params['data']['candweb']);
        $this->params['data']['rankingtelf'] = Principal::rankingtelf($this->params['data']['candtlf']);
        $this->params['id'] = $request->id;
        $this->params['data']['menu'] = Principal::menu();
        if ($this->params['data']['rankingtelf'] != false) {
            $this->params['ranktefl'] = count($this->params['data']['rankingtelf']);
        } else {
            $this->params['ranktefl'] = 0;
        }
        if ($this->params['data']['rankingweb'] != false) {
            $this->params['rankweb'] = count($this->params['data']['rankingweb']);
        } else {
            $this->params['rankweb'] = 0;
        }
        $this->params['voto'] = Principal::buscarvotos($request->id);

        return view("frontend.home.mediametrica", ['params' => $this->params]);
    }

    public function buscarvideo(Request $request) {
        if ($request->ajax()) {

            $this->params['data']['video'] = Principal::buscavideo($request->id,$request->encuesta_id,$request->opt);

            return response()->json($this->params['data']['video']);
        }
    }

    public function buscaraudio(Request $request) {

        if ($request->ajax()) {

            $this->params['data']['audio'] = Principal::buscaraudio($request->id);

            return response()->json($this->params['data']['audio']);
        }
    }
}
