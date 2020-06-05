<?php

namespace App\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\CategoriaNoticia;
use Illuminate\Validation\Rule;
use App\Models\Noticia;
use App\Models\Iframe;
use App\Models\Publicidad;
use App\Models\Element;
use App\Models\Config;

trait NewsConfigTrait
{

    /**
     * Vista para la gestión de la grilla
     * @param Request $request
     * @return View
     */
    public function configuracionDeModulo(Request $request){

        #Obtener todas las noticias publicadas
        $noticias = Noticia::getPublished(true);

        #Todos los iFrames definidos
        $iframes = Iframe::all();

        #Obtener el archivo de configuracion global del modulo de noticias.
        $config = Config::getConfig(Config::MAIN);

        #Todos los elementos de la pantalla
        $elements = Config::getConfig(Config::ELEMENTS);
        
        #Todos los elementos de la pantalla
        $grids = Config::getConfig(Config::GRIDS);

        #Todos los layouts de las pantallas
        $layouts = Config::getConfig(Config::LAYOUTS);

        $this->mergeData($elements, $grids, $layouts);  

        return view('backend.noticias.config')->with(compact(['config','grids','elements','noticias','iframes']));
    }

    /**
     * Configuración de los banners de la publicidad
     * @param Request $request
     * @return View $view 
     */
    public function configuracionDePublicidad(Request $request){
        $publicidad = Publicidad::select('nombre','id','fecha_agregado','active','peso')->get();
        return view('backend.noticias.publicidad', compact('publicidad'));
    }

    /**
     * Configuración de los banners de la publicidad
     * @param Request $request
     * @return View $view 
     */
    public function configuracionDeIframes(Request $request){
        $iframes = Iframe::select('nombre','id','fecha_agregado','active')->get();
        return view('backend.noticias.iframes')->with(compact('iframes'));
    }

    /**
     * Ruta para obtener el modal de edición de iframe
     * @param Request $request
     * @return Json $response
     */
    public function showIframe(Request $request){
        try {

            if(!$request->iframe){
                throw new \Exception('Error de valores');
            }
            
            $iframe = Iframe::find($request->iframe);

            return response()->json([
                'success' => View::make('backend.noticias.modals.iframes',['iframes' => $iframe])->render()
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ]);
        }
    }

    /**
     * Ruta para modificar todos los valores del banner publicitario.
     * @param Request $request
     * @return Json $response
     */
    public function updateBanner(Request $request){
        try {

            DB::beginTransaction();

            $val = Validator::make($request->all(), [
                'id' => 'required|integer',
                'peso' => 'required|integer',
                'link' => 'required|url',
                'nombre' => 'required|string',
            ]);

            if($val->fails()){
                throw new \Exception('Error de parametros enviados');
            }

            $publicidad = Publicidad::find($request->id);

            if(!$publicidad){
                throw new \Exception('No existe el banner publicitario especificado.');
            }

            $publicidad->peso = $request->peso;
            $publicidad->link = $request->link;
            $publicidad->nombre = $request->nombre;
            $publicidad->save();
            
            DB::commit();

            return response()->json([
                'success' => 'Se ha modificado el banner publicitario exitosamente'
            ]);

        } catch (\Exception $e) {
            
            DB::rollBack();
            
            return response()->json([
                'error' => $e->getMessage()
            ]);
        }
    }

    /**
     * Ruta para modificar todos los valores del banner publicitario.
     * @param Request $request
     * @return Json $response
     */
    private $positions = ['si','se','ii','ci','ie'];
    public function updateNoticia(Request $request){
        try {

            DB::beginTransaction();

            $val = Validator::make($request->all(), [
                'id' => ['required','integer', Rule::exists('pgsql.noticias.noticia')],
                'position' => ['required', Rule::in($this->positions)],
                'titulo' => 'required|string|max:60',
                'descripcion' => 'required|string|max:120',
            ]);

            if($val->fails()){
                dump($val->errors());
                throw new \Exception('Error de parametros');
            }

            $resultado = Noticia::where('id',$request->id)->update([
                'titulo' => $request->titulo,
                'title_position' => $request->position,
                'descripcion' => $request->descripcion
            ]);

            if(!$resultado){
                throw new \Exception('Error de base de datos');
            }

            DB::commit();

            return response()->json([
                'success' => 'Se ha modificado la noticia exitosamente'
            ]);

        } catch (\Exception $e) {
            
            DB::rollBack();
            
            return response()->json([
                'error' => $e->getMessage()
            ]);
        }
    }

    /**
     * Ruta para modificar todos los valores del banner publicitario.
     * @param Request $request
     * @return Json $response
     */
    public function updateMainConfig(Request $request){
        try {

            DB::beginTransaction();

            $val = Validator::make($request->all(), [
                'cantidad_categoria' => 'required|integer',
                'cantidad_main' => 'required|integer',
            ]);

            $config = new Config(Config::MAIN);
            $main = $config->getCurrent();
            $main->cantidad_maxima_principal = $request->cantidad_main;
            $main->cantidad_maxima_categoria = $request->cantidad_categoria;
            $config->saveAll();
            DB::commit();

            return response()->json([
                'success' => 'Se ha modificado la configuración principal'
            ]);

        } catch (\Exception $e) {
            
            DB::rollBack();
            
            return response()->json([
                'error' => $e->getMessage()
            ]);
        }
    }

    /**
     * Ruta para modificar todos los valores del banner publicitario.
     * @param Request $request
     * @return Json $response
     */
    public function showPublicidad(Request $request){
        try {

            if(!$request->publicidad){
                throw new \Exception('Error de valores');
            }
            
            $publicidad = Publicidad::find($request->publicidad);

            return response()->json([
                'success' => View::make('backend.noticias.modals.publicidad',['publicidad' => $publicidad])->render(),
                'image' => $publicidad->imagen
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ]);
        }
    }

    /**
     * Configuracion de las definiciones del Sistema, Iframe, Publicidad.
     * @param Request $request
     * @return Json Response
     */
    public function updateDefinitions(Request $request){
        try {

            DB::beginTransaction();

            $val = Validator::make($request->all(), [
                'type' => 'required|integer',
                'def' => 'required|integer',
                'value' => 'required|string',
                'key' => 'required|integer',
                'titulo' => 'required|string',
                'peso' => 'sometimes|integer',
                'label' => 'sometimes|string',
                'image' => 'sometimes|file',
                'link' => 'sometimes|url',
            ]);
    
            if($request->def == 0){
                $resultado = Publicidad::handle($request->type, $request);
            } else if($request->def == 1) {
                $resultado = Iframe::handle($request->type, $request);
            }
            
            DB::commit();

            return response()->json($resultado);

        } catch(\Exception $e) {
            
            DB::rollBack();
            
            return response()->json([
                'error' => $e->getMessage()
            ]);
        }
    }

    /**
     * Autorizar el cambio de la configuración, puede ser revertido.
     * @param Request $request
     * @return Json Response
     */
    public function authorizeChange(Request $request) {
        
        try {

            if(!$request->type){
                throw new \Exception('error de request');
            }

            $response = Config::overridChange($request->type);

            return response()->json($response);

        } catch(\Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ]);
        }

    }

    /**
     * Interseccion entre los archivos de configuración
     * @param $elements
     * @param $grids
     * @param $layouts
     */
    private function mergeData(&$elements, $grids, $layouts){
        $forms = [1 => 'NOTICIA',3 => 'PUBLICIDAD', 2 => 'IFRAME'];
        foreach($elements as $key => $e) {
            $index = $e->grid_position - 1;
            $e->image = $grids[$index]->type.'-'.(string) '0'.(string) ($e->element_position + 1);
            $e->label = $grids[$index]->label;
            if($e->value != null){
                if($e->type == 1){
                    $noticia = Noticia::find($e->value);
                    $e->value = ($noticia) ? $noticia->titulo:'AUTOMATICO';
                } else if($e->type == 3) {
                    $pub = Publicidad::find($e->value);
                    $e->value = ($pub) ? $pub->nombre:'AUTOMATICO';
                } else if($e->type == 2) {
                    $ifr = Iframe::find($e->value);
                    $e->value = ($ifr) ? $ifr->nombre:'AUTOMATICO';
                }
            } else {
                $e->value = 'AUTOMATICO';
            }
            $e->type = $forms[$e->type];
            $dif = array_filter($layouts, function($e) use ($grids, $index){
                return $e->name == $grids[$index]->type;
            });
            $dif = array_values($dif)[0];
            $e->form = $dif->types->{'P'.(string) ($e->element_position + 1)};
        }
    }

    /**
     * Página concreta para definir los elementos en el espacio
     * @param Request $request
     * @return View $view
     */
    private $elementDefi;
    public function defineSpecific(Request $request, $key){
        
        //Obtener información de ese elemento
        $element = Config::getByKey(Config::ELEMENTS, $key);
        $grid = Config::getByKey(Config::GRIDS, $element->grid_position - 1);
        $layout = Config::getByValue(Config::LAYOUTS, 'name', $grid->type);
        $type = $layout->types->{"P".(string) ($element->element_position + 1)};
        $e = Element::where('identificator', $type)->first();
        switch($element->type){
            case self::NOTICIA:
                $r = Noticia::find($element->value);
                $result['value'] = ($r) ? $r->titulo:null;
                $result['type'] = 'NOTICIA';
            break;
            
            case self::IFRAME:
                $r = Iframe::find($element->value);
                $result['value'] = ($r) ? $r->nombre:null;
                $result['type'] = 'IFRAME DE VIDEO';
            break;
            
            case self::PUBLICIDAD:
                $r = Publicidad::find($element->value);
                $result['value'] = ($r) ? $r->nombre:null;
                $result['type'] = 'BANNER PUBLICITARIO';
            break;
        }

        //Dependiendo del perfil, asignar cosas a ese espacio.
        if(Auth::user()->is(['admin','editor'])){
            
            if($e->publicidad) {
                $publicidad = Publicidad::where('tipo_banner', $e->tipo_banner)->where('active', true)->get();
            }
    
            if($e->iframe) {
                $iframes = Iframe::all();
            }
            
            $noticias = Noticia::all();
        } else if(Auth::user()->is('escritor')){
            $noticias = Noticia::where('id_writer', Auth::user()->id)->get();
        }

        return view('backend.noticias.define')->with([
            'position' => $key,
            'info' => $result,
            'elemento' => $element,
            'grid' => $grid,
            'layout' => $layout,
            'noticias' => $noticias,
            'iframes' => (isset($iframes)) ? $iframes:null,
            'publicidad' => (isset($publicidad)) ? $publicidad:null,
        ]);

    }

    /**
     * Definicion especifica de elemento en una posición
     * @param Request $request
     * @return Json
     */
    public function defineSpecificElement(Request $request){
        try {

            $validation = Validator::make($request->all(), [
                'id' => 'sometimes',
                'key' => 'required|integer',
                'type' => ['required', Rule::in([1,2,3])]
            ]);

            if($validation->fails()){
                throw new \Exception('Error de parametros');
            }

            switch($request->type){

                case self::NOTICIA:
                    if($request->id != null){
                        $result = Noticia::find($request->id);
                        if(!$result){
                            throw new \Exception('La noticia seleccionada no existe');
                        }
                    }
                break;

                case self::IFRAME:
                    $result = Iframe::find($request->id);
                    if(!$result){
                        throw new \Exception('El iframe seleccionado no existe');
                    }
                break;
                
                case self::PUBLICIDAD:
                    if($request->id != null){
                        $result = Publicidad::find($request->id);
                        if(!$result){
                            throw new \Exception('El banner publicitario seleccionado no existe');
                        }
                    }
                break;
                
            }
            $config = new Config(Config::ELEMENTS, $request->key);
            $selected = $config->getSelected();

            if($selected->value){
                $msg = 'Se ha reemplazado el elemento de forma exitosa';
            } else {
                if($request->id){
                    $msg = 'Se definio el elemento exitosamente';
                } else {
                    $msg = 'Se definio el elemento a: AUTOMATICO';
                }
            }

            $selected->type = $request->type;
            $selected->value = $request->id;

            $config->setSelected($selected);
            $config->save();

            return response()->json([
                'success' => $msg
            ]);

        } catch(\Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ]);
        }
    }

    /**
     * Funcion para mostrar todos los modales de la configuracion de grillas
     * @param Request $request
     * @return View $view
     */
    public function displayModal(Request $request){
        try {

            $val = Validator::make($request->all(), [
                'type' => 'required|integer',
                'assign' => 'required|integer',
            ]);

            if($val->fails()){
                throw new \Exception('Error de parametros');
            }

            $view = $this->renderModal($request->type, $request->assign);

            return response()->json($view);

    
        } catch(\Exception $e) {

            return response()->json([
                'error' => $e->getMessage()
            ]);
        }
    }

    /**
     * Renderizacion del contenido del modal.
     * @param $type - Tipo de Modal
     * @param $assign - Valor
     */
    private $modals = [ self::GRID => 'grid', self::ELEMENT => 'element'];
    private function renderModal($type, $assign){
        switch($type){

            case self::GRID:
                $layouts = Config::getConfig(Config::LAYOUTS);
                $current = Config::getGridData($assign);
                $position = $assign;
                $view = View::make('backend.noticias.modals.'.$this->modals[$type])->with(compact('layouts','current','position'));
                $result = ['html' => $view->render()];
            break;

            case self::ELEMENT:
                $elements = Config::getConfig(Config::ELEMENTS);
                $current = $elements[$assign];
                $grid = Config::getGridData($current->grid_position - 1);
                $current->grid = $grid;
                $current->key = $assign;
                $result = ['data' => $current];
            break;

            default:
                throw new \Exception('Error de parametros - No existe este tipo');
            break;
        }
        return $result;
    }

    public function updateConfig(Request $request){
        try {

            $val = Validator::make($request->all(), [
                'form' => 'required|integer',
                'type' => 'sometimes|integer',
                'key' => 'sometimes|integer',
                'position' => 'sometimes|integer',
                'value' => 'sometimes|string',
            ]);

            
            if($val->fails())
            {
                throw new \Exception('Error de parametros');
            }

            if($request->form == Config::GRIDS){
                
                #Actualizar el archivo de configuración de los bloques
                $grids = new Config(Config::GRIDS);
                $layout = Config::getConfig(Config::LAYOUTS, $request->key)[$request->key];
                $selected = $grids->get($request->position);
                $selected->type = $layout->name;
                $selected->label = $layout->label;
                $grids->set($selected);
                $grids->save();
                $grid = $grids->getSelected();

                #Actualizar el archivo de la configuración de los elementos
                $elements = new Config(Config::ELEMENTS);
                $flexible = collect($elements->getCurrent());

                $restantes = $flexible->filter(function($item) use ($grid) {
                    return $grid->position == $item->grid_position;
                });

                $distintos = $flexible->diffKeys($restantes);

                $nuevo = [];
                for($i = 0; $i < $layout->positions; $i++){
                    $nuevo[$i-1] = new \stdClass();
                    $nuevo[$i-1]->grid_position = $grid->position;
                    $nuevo[$i-1]->element_position = $i;
                    $nuevo[$i-1]->type = 1;
                    $nuevo[$i-1]->value = null;
                }

                $nuevo = collect($nuevo);

                $restart = $distintos->values();

                $def = $restart->merge($nuevo);
                
                $ultimo = [];
                $contador = 1;
                while($contador <= $def->count()){
                    for($i = 0; $i < $def->count(); $i++){
                        if($def[$i]->grid_position == $contador){
                            $ultimo[$i]['grid_position'] = $def[$i]->grid_position;
                            $ultimo[$i]['element_position'] = $def[$i]->element_position;
                            $ultimo[$i]['type'] = $def[$i]->type;
                            $ultimo[$i]['value'] = $def[$i]->value;
                        }
                    }
                    $contador++;
                }

                Config::setConfig(Config::ELEMENTS, array_values($ultimo));

                return response()->json([
                    'success' => 'Se ha modificado el bloque '.(string) ($request->position + 1).' exitosamente'
                ]);

            } else if($request->form == Config::ELEMENTS){
                

                $elements = new Config(Config::ELEMENTS);
                $elements->get($request->key);
                $selected = $elements->getSelected();
                $selected->type = $request->type;

                if($request->type == self::NOTICIA){
                    $selected->value = ($request->value == 'undefined') ? null:$request->value;
                } else if($request->type == self::IFRAME) {
                    if(!$request->value){
                        throw new \Exception('Error, debe elegir un iframe');
                    }
                    $selected->value = $request->value;
                } else if($request->type == self::PUBLICIDAD){
                    $selected->value = ($request->value) ? $request->value:null;
                }

                $elements->setSelected($selected);
                $elements->save();

                return response()->json([
                    'success' => 'Se ha modificado la grilla exitosamente'
                ]);
            }
        } catch(\Exception $e) {

            return response()->json([
                'error' => $e->getMessage()
            ]);
        }
    }

}
