<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Comun\AppComun;

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

use App\Traits\NewsTrait;
use App\Traits\NewsConfigTrait;
use App\Traits\NewsPageTrait;

use App\Models\CategoriaNoticia;
use App\Models\Noticia;
use App\Models\Comentario;
use App\Models\Config;
use App\Models\Layouts;
use App\Models\Positions;
use App\Models\Publicidad;
use App\Models\Iframe;
use App\Models\Principal;
use App\Models\Adjunto;
use App\Models\TagXNoticia;
use App\Models\Tag;

class NoticiasController extends Controller
{
    use NewsTrait, NewsConfigTrait, NewsPageTrait;

    /**
     * Constantes de Configuración
     */
    const GRID = 1;
    const ELEMENT = 2;
    const LAYOUTS = 3;

    /**
     * Tipos de Elementos
     */
    const NOTICIA = 1;
    const PUBLICIDAD = 3;
    const IFRAME = 2;

    /**
     * Utilizadas para el momento de almacenar la noticia, en el NewsTrait
     */
    public $file_image = [];
    public $file_portada;
    public $file_noticia;

    /**
     * Ruta principal donde se muestran todas las noticias
     * @param $categoria - Categoria de la noticia
     * @return View - Vista retornada
     */
    public function index(Request $request){

        #Todas las categorias
        $categorias = CategoriaNoticia::orderBy('id')->get();

        #Noticias mas vistas
        $most = Noticia::mostViewed(3, null, true);

        #Todas las grillas
        $tot = collect(Config::getConfig(Config::GRIDS_APPROVED));
        $elements = collect(Config::getConfig(Config::ELEMENTS_APPROVED));
        $global = Config::getConfig(Config::MAIN);

        #Tomar todas las noticias en orden
        $noticias = Noticia::getPublished(true, $global->cantidad_maxima_principal);

        #Tomar todos los banners publicitarios en order de peso
        $banners = Publicidad::getOrder();

        $banner = Publicidad::where('tipo_banner',3)->orderBy('peso')->first();

        /**
         * Funcion encargada de construir completamente la página principal y la página de categorias
         * Se encarga de devolver la porción de la pagina que fue solicitada
         * @param Grillas $tot
         * @param Elementos $elements
         * @param Noticias $noticias
         * @param Banners $banners
         * @param Page $page - Numero de página
         * @return Json $response
         */
        $print = $this->orderEverythingForMainPage($tot, $elements, $noticias, $banners);

        return view('frontend.noticias.main')->with(compact('categorias','print','most','banner'));
    }

    /**
     * Like and Dislike news
     * @param Request $request - Categoria de la noticia
     * @param $action
     * @param $id
     */
    public function likeAndDislike(Request $request, $id, $action){
        try {
            DB::beginTransaction();

            //noticia existe
            $noticia = Noticia::find($id);
            if(!$noticia){
                throw new \Exception('Error: Noticia inexistente');
            }

            //Usuario Inicio Sessión
            $usuario = Session::get('usuario');
            if(!$usuario){
                throw new \Exception('Error: Acción no permitida');
            }

            $rating = DB::table('noticias.rating')
                ->where('id_usuario', $usuario->id)
                ->where('id_noticia', $id)
                ->first();

            switch($action){
                
                case 'like':
                    
                    if(!$rating){
                        DB::table('noticias.rating')->insert([
                            'id_usuario' => $usuario->id,
                            'id_noticia' => $id,
                            'id_emocion' => 1
                        ]);
                    } else {
                        DB::table('noticias.rating')
                            ->where('id_usuario', $usuario->id)
                            ->where('id_noticia', $id)
                        ->update([
                            'id_emocion' => 1
                        ]);    
                    }
                    
                break;

                case 'dislike':
                    //usuario ya le dio dislike
                    if(!$rating){
                        DB::table('noticias.rating')->insert([
                            'id_usuario' => $usuario->id,
                            'id_noticia' => $id,
                            'id_emocion' => 2
                        ]);
                    } else {
                        DB::table('noticias.rating')
                            ->where('id_usuario', $usuario->id)
                            ->where('id_noticia', $id)
                        ->update([
                            'id_emocion' => 2
                        ]);    
                    }
                break;

                default:
                    //action no existe
                    throw new \Exception('Error: Acción inexistente');
                break;

            }

            DB::commit();
            
            return response()->json([
                'success' => [
                    'likes' => $noticia->likes(),
                    'dislikes' => $noticia->dislikes(),
                ]
            ]);

        } catch(\Exception $e) {
            
            DB::rollBack();
            error_log($e);
            return response()->json([
                'error' => $e->getMessage()
            ]);
        } 
    }
    
    /**
     * Comentarios de una Noticia
     * @param Request $request
     * @return Json $data
     */
    public function commentsAction(Request $request, $noticia){
        try {

            $noticia = Noticia::find($noticia);

            if(!$noticia){
                throw new \Exception('inexistent resource');
            }

            $comentarios = Comentario::select('comentarios.fecha_done','comentarios.comentario','comentarios.id','public.usuario.nombre','public.usuario.avatar')
                ->join('public.usuario','public.usuario.id','=','comentarios.id_usuario')    
                ->where('comentarios.id_noticia', $noticia->id)
                ->get();
            
            return response()->json($comentarios->toArray());

        } catch(\Exception $e) {
            error_log($e);
            return response()->json([
                'error' => $e->getMessage()
            ]);
        }
    }

    /**
     * Agregar comentarios
     * @param Request $request
     * @return Json $data
     */
    public function addCommentsAction(Request $request){
        try {

            DB::beginTransaction();

            $noticia = Noticia::find($request->noticia);
            $usuario = Session::get('usuario');

            if(!$noticia){
                throw new \Exception('inexistent resource');
            }

            if(!$usuario){
                throw new \Exception('inexistent user');
            }

            if(!$request->comentario){
                throw new \Exception('inexistent parameter');
            }

            if(strlen($request->comentario) > 500){
                throw new \Exception('invalid resource');
            }

            $noticia->comentarios()->create([
                'id_noticia' => $noticia->id,
                'id_usuario' => $usuario->id,
                'comentario' => $request->comentario,
            ]);

            DB::commit();

            $comentarios = Comentario::select('comentarios.fecha_done','comentarios.comentario','comentarios.id','public.usuario.nombre','public.usuario.avatar')
                ->join('public.usuario','public.usuario.id','=','comentarios.id_usuario')    
                ->where('comentarios.id_noticia', $noticia->id)
                ->get();

            return response()->json(['success' => $comentarios->toArray()]);

        } catch(\Exception $e) {
            DB::rollBack();
            error_log($e);
            return response()->json([
                'error' => $e->getMessage()
            ]);
        }
    }


    /**
     * Noticias de prueba
     * @param $categoria - Categoria de la noticia
     * @return View - Vista retornada
     */
    public function indexTest(Request $request){

        #Todas las grillas
        $tot = collect(Config::getConfig(Config::GRIDS));
        $elements = collect(Config::getConfig(Config::ELEMENTS));

        #Tomar todas las noticias en orden
        $noticias = Noticia::getPublished(true);

        #Tomar todos los banners publicitarios en order de peso
        $banners = Publicidad::getOrder();

        /**
         * Funcion encargada de construir completamente la página principal y la página de categorias
         * Se encarga de devolver la porción de la pagina que fue solicitada
         * @param Grillas $tot
         * @param Elementos $elements
         * @param Noticias $noticias
         * @param Banners $banners
         * @param Page $page - Numero de página
         * @return Json $response
         */
        $print = $this->orderEverythingForMainPage($tot, $elements, $noticias, $banners);

        return view('frontend.noticias.main-test')->with(compact('print'));
    }

    /**
     * Ruta principal donde se muestran todas las noticias
     * @param $categoria - Categoria de la noticia
     * @return View - Vista retornada
     */
    public function categoria(Request $request, $categoria){

        #Todas las categorias
        $categorias = CategoriaNoticia::orderBy('id')->get();

        #Noticias mas vistas
        $most = Noticia::mostViewed(3, $categoria);

        #Todas las grillas
        $tot = collect(Config::getConfig(Config::GRIDS_APPROVED));
        $elements = collect(Config::getConfig(Config::ELEMENTS_APPROVED));
        $global = Config::getConfig(Config::MAIN);

        #Tomar todas las noticias en orden
        $noticias = Noticia::getPublishedByCategory($categoria,  true, $global->cantidad_maxima_categoria);

        #Tomar todos los banners publicitarios en order de peso
        $banners = Publicidad::getOrder();

        #una sola publicidad vertical
        $banner = Publicidad::where('tipo_banner',3)->orderBy('peso')->first();
        
        #Devuelve la organización de las grillas de cáda categoria
        $print = $this->orderEverythingForCategory($categoria, $tot, $elements, $noticias, $banners);

        return view('frontend.noticias.categoria')->with([
            'print' => $print,
            'categorias' => $categorias,
            'categoria' => $categoria,
            'most' => $most,
            'banner' => $banner,
        ]);
    }

    /**
     * Ruta que muestra las noticias individuales
     * @param $hash - hash identificador de la noticia
     * @return View - Vista retornada
     */
    public function showIndividual(Request $request, $id){

        #Todas las categorias
        $categorias = CategoriaNoticia::orderBy('id')->get();
        
        $noticia = Noticia::getSingleFullData($id);
        $topRanking = \App\Http\Controllers\FrontendController::parseData(Principal::extarerHomePrincipal());
        
        $most = Noticia::mostViewed(5, null, true);
        $interes = Noticia::mostViewed(3, $noticia->id_categoria, true);
        
        if(!$noticia || !$noticia->published){
            return view('404');
        }

        //Si se inicio Sesión, verificar si hay rating
        $rating = null;
        if(Session::has('usuario')){
            $rating = DB::table('noticias.rating')
                ->where('id_usuario', Session::get('usuario')->id)
                ->where('id_noticia', $id)
                ->first();
        }

        $this->ratingHandler($noticia, $request);

        $html = Storage::disk('noticia')->get($noticia->code.".html");

        return view('frontend.noticias.individual')->with(compact('categorias','noticia','html','interes','topRanking','most','rating'));
    }

    /**
     * Ruta que muestra las noticias individuales
     * @param $hash - hash identificador de la noticia
     * @return View - Vista retornada
     */
    public function showIndividualTest(Request $request, $id){
        
        $noticia = Noticia::getSingleFullData($id);
        
        if(!$noticia){
            return view('error.400');
        }

        $topRanking = \App\Http\Controllers\FrontendController::parseData(Principal::extarerHomePrincipal());

        $descripcion = Storage::disk('noticia')->get($noticia->code.".html");

        return view('frontend.noticias.individual-test')->with([
            'noticia' => $noticia,
            'html' => $descripcion,
            'topRanking' => $topRanking,
        ]);
    }

     /**
     * Metodos de gestion de la noticia
     * @param Request $request
     * @return Json
     */
    public function publicarNoticia(Request $request){
        
        try {

            $validActions = ['pub','des'];

            $val = Validator::make($request->all(), [
                'noticia' => 'required|integer',
                'action' => ['required', Rule::in($validActions)]
            ]);

            $noticia = Noticia::findOrFail($request->noticia);

            if(!$noticia)
            {
                throw new \Exception('Noticia inexistente');
            }
    
            if($val->fails())
            {
                throw new \Exception('Parametros invalidos');
            }

            $result = $this->{strtolower($request->action)}($request->noticia);

            return response()->json([
                'success' => $result
            ]);


        } catch(\Exception $e) {    

            error_log($e->getMessage());

            return response()->json([
                'error' => $e->getMessage()
            ]);
        }
        
    }

    /**
     * Ruta del back-end para agregar nuevas noticias
     * @param Request $request
     * @return View - Vista retornada
     */
    public function newNoticia(Request $request){

        #Todas las categorias
        $categorias = CategoriaNoticia::orderBy('id')->get();

        return view('backend.noticias.nueva')->with(compact('categorias'));
    }

    /**
     * Ruta del back-end para mostrar todas las noticias y gestionarlas
     * @param Request $request
     * @return View - Vista retornada
     */
    public function showNoticiasBackend(Request $request){
        return view('backend.noticias.show');
    }

    /**
     * Obtener todas las noticias publicadas en un margen de fechas recientes.
     * @return Json - Noticias
     */
    public function noticiasPublicadas(Request $request){
        return Noticia::getPublished();
    }

    /**
     * Procesamiento serverside Datatable
     * @param Request $request
     * @return View - Vista retornada
     */
    public function noticiaServerSide(Request $request){
        $noticias = Noticia::getNoticiasByParams($request);
        return response()->json($noticias);
    }

    private function orderEverythingForCategory($categoria, $tot, $elements, $noticias, $banners, $page = 1){
        
        //Obtener todas las noticias de esa categoria que son fixed
        $fixeds = collect([]);
        $elements->each(function($e, $k) use (&$fixeds, $categoria) {
            if($e->type == self::NOTICIA && $e->value != null){
                $noticia = Noticia::find($e->value);
                if($noticia->id_categoria == $categoria){
                    $e->noticia = $noticia;   
                    $fixeds->push($e);
                }
            }
        });

        //Los que son fixeds, se eliminan de la lista de noticias
        if(!$fixeds->isEmpty()){
            $fixeds->each(function($item) use(&$noticias){
                $noticias->transform(function($itemN) use ($item){
                    if($itemN->id == $item->noticia->id){
                        return false;
                    }
                    return $itemN;
                });
            });
        }

        $banners = collect($banners->toArray());
        $banners  = new AdvertHandler($banners);
        $tot->transform(function($e, $k) use ($elements, &$noticias, &$banners, &$fixeds) {
            $append = [];
            foreach($elements as $element){
                if($e->position == $element->grid_position){
                    $element = collect($element);
                    if($element['type'] == self::NOTICIA ){
                        $fixeds = $fixeds->filter()->values();
                        $noticias = $noticias->filter()->values();
                        if(!$fixeds->isEmpty()){
                            $fixed = $fixeds->splice(0,1);
                            if(!$fixed->isEmpty()){
                                $nuevo = $fixed->first();
                                array_push($append, [
                                    'content' => $nuevo->noticia,
                                    'type' => self::NOTICIA
                                ]);
                            }   
                        } else {
                            $noticia = $noticias->splice(0,1);
                            if(!$noticia->isEmpty()){
                                $nuevo = $noticia->first();
                                array_push($append, [
                                    'content' => $nuevo,
                                    'type' => self::NOTICIA
                                ]);
                            }   
                        }
                    } else if($element['type'] == self::PUBLICIDAD) {
                        if($element['value'] != null){
                            $nuevo = Publicidad::find($element['value']);
                            $banners->setUsed($element['value']);
                            array_push($append, [
                                'content' => $nuevo,
                                'type' => self::PUBLICIDAD
                            ]);
                        } else {
                            $nuevo = $banners->getFirst($element);
                            if(!$nuevo){
                                $noticias = $noticias->filter()->values();
                                $noticia = $noticias->splice(0,1);
                                if(!$noticia->isEmpty()){
                                    $nuevo = $noticia->first();
                                    array_push($append, [
                                        'content' => $nuevo,
                                        'type' => self::NOTICIA
                                    ]);
                                }
                            }
                            array_push($append, [
                                'content' => $nuevo,
                                'type' => self::PUBLICIDAD
                            ]);
                        }
                    }
                }
            }
            if(count($append) > 0){
                $e->elements = $append;
                return $e;
            } else {
                return false;
            }
        });
        $tot = $tot->filter()->values();
        $take = ($page - 1)*5;
        $chunk = $tot->splice($take, 5);
        return $chunk;
    }

    /**
     * @param Grillas $tot
     * @param Elementos $elements
     * @param Noticias $noticias
     * @param Banners $banners
     * @param Page $page - Numero de página
     * @return Json $response
     * El procedimiento explicado de forma simple es el siguiente:
     * Este procedimiento se encarga totalmente de construir dinamicamente la información que va en cada elemento,
     * manual o automatica, estos son sus pasos:
     *  1.- Itera todas las grillas definidas 25(aprox)
     *  2.- Itera todos los elementos que coincidan con esa grilla (para cada grilla)
     *  3.- Verifica que tipo de información va en ese elemento (Noticia, Publicidad, Video)
     *  4.- Verifica si el elemento esta nulo (Automatico) o si esta definido
     *          En caso de estar definido:
     *             (noticia) => Se elimina la noticia de la lista de disponibles para automaticas, y se coloca en la casilla en la cual fue definida.
     *             (publicidad) => Se coloca en la casilla en la cual fue definida y se le suma un punto de utilización, solo se vera nuevamente si los demás banners fueron mostrados
     *             (iframes) => Simplemente se coloca el iframe que fue definido en esa casilla
     */
    private function orderEverythingForMainPage($tot, $elements, $noticias, $banners, $page = 1){
        $banners = collect($banners->toArray());
        $banners  = new AdvertHandler($banners);
        $tot->transform(function($e, $k) use ($elements, &$noticias, &$banners) {
            $append = [];
            foreach($elements as $element){
                if($e->position == $element->grid_position){
                    $element = collect($element);
                    if($element['type'] == self::NOTICIA ){
                        if($element['value'] != null){
                            $nuevo = Noticia::getSingleFullData($element['value']);
                            $noticias->transform(function($n) use ($element){
                                if($n != false){
                                    if($element['value'] == $n->id){
                                        return false;
                                    } else {
                                        return $n;
                                    }
                                }
                            });
                            array_push($append, [
                                'content' => $nuevo,
                                'type' => self::NOTICIA
                            ]);
                            
                        } else {
                            $noticias = $noticias->filter()->values();
                            $noticia = $noticias->splice(0,1);
                            if(!$noticia->isEmpty()){
                                $nuevo = $noticia->first();
                                array_push($append, [
                                    'content' => $nuevo,
                                    'type' => self::NOTICIA
                                ]);
                            }
                        }
                    } else if($element['type'] == self::IFRAME){
                        $nuevo = Iframe::find($element['value']);
                        array_push($append, [
                            'content' => $nuevo,
                            'type' => self::IFRAME
                        ]);
                    } else if($element['type'] == self::PUBLICIDAD) {
                        if($element['value'] != null){
                            $nuevo = Publicidad::find($element['value']);
                            $banners->setUsed($element['value']);
                            array_push($append, [
                                'content' => $nuevo,
                                'type' => self::PUBLICIDAD
                            ]);
                        } else {
                            $nuevo = $banners->getFirst($element);
                            if(!$nuevo){
                                $noticias = $noticias->filter()->values();
                                $noticia = $noticias->splice(0,1);
                                if(!$noticia->isEmpty()){
                                    $nuevo = $noticia->first();
                                    array_push($append, [
                                        'content' => $nuevo,
                                        'type' => self::NOTICIA
                                    ]);
                                }
                            }
                            array_push($append, [
                                'content' => $nuevo,
                                'type' => self::PUBLICIDAD
                            ]);
                        }
                    }
                }
            }
            if(count($append) > 0){
                $e->elements = $append;
                return $e;
            } else {
                return false;
            }
        });

        $tot = $tot->filter();
        $take = ($page - 1)*5;
        $chunk = $tot->splice($take, 5);
        return $chunk;
    }

    /**
     * Publicar la noticia
     */
    public function pub($id)
    {
        
        Noticia::where('id', $id)->update([
            'published' => true,
            'fecha_publish' => 'now()',
            'id_publisher' => Session::get('usuario_backend')->id,
        ]);

        return 'Publicacion Realizada';
    }

    /**
     * Eliminar la noticia de publicaciones
     * @param Noticia $id
     * @return Json $response
     */
    private function des($id)
    {
        Noticia::where('id', $id)->update([
            'published' => false,
            'fecha_publish' => null,
            'id_publisher' => null,
        ]);

        return 'Publicacion Eliminada';
    }

}

class AdvertHandler {

    protected $current;
    protected $used = [];
    protected $grids;

    public function __construct($definition){
        $this->grids = new Config(Config::GRIDS);
        $this->current = $definition;
    }

    /**
     * Funcion que elimina de la lista de publicidades aquellas que esten fixed
     * @return void
     * @param $value
     */
    public function setUsed($value){
        $current = $this->current;
        $result = $current->filter(function($e, $k) use ($value){
            return $e['id'] == $value;
        });
        $current->transform(function($e, $k) use ($value){
            return ($e['id'] == $value) ? false:$e;
        });
        $current = $current->filter()->values();
        array_push($this->used, $result->first());
        $this->current = $current;
    }

    /**
     * Funcion que obtiene la publicidad que encaja con el contenedor
     * Si no hay ninguna noticia que quepa en ese espacio, se coloca una noticia
     * @param Element $element
     * @return Publicidad $pub
     */
    public function getFirst($element){
        $this->grids->instanceByValue('position', $element['grid_position']);
        $a = $this->grids->getSelected();
        $layout = Layouts::getByName($a->type);
        $tipo_banner = $layout->getPositions[$element['element_position']]->element->tipo_banner;
        $current = $this->current;
        $result = $current->filter(function($e, $k) use ($tipo_banner){
            return $e['tipo_banner'] == $tipo_banner;
        })->first();
        if($result){
            $current->transform(function($e, $k) use ($tipo_banner){
                return ($e['tipo_banner'] == $tipo_banner) ? false:$e;
            });
            $current = $current->filter()->values();
            return $result;
        } else {
            return false;
        }
    }
}