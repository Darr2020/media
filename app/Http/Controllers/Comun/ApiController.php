<?php

namespace App\Http\Controllers\Comun;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tag;

class ApiController extends Controller {
    
    /**
     * Controlador de la API para obtener los tags de las noticias
     * @param string tags
     * @return json tags
     */
    public function obtenerTagsPorNombre(Request $request, $tag){
        return Tag::getByName((string) $tag)->toJson();
    }

    /**
     * Controlador de la API para obtener todos los tags
     * @param string tags
     * @return json tags
     */
    public function obtenerTags(Request $request){
        return Tag::all()->toJson();
    }
}