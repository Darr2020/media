<?php

namespace App\Traits;

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\Comun\AppComun;
use Illuminate\Http\Request;

use App\Traits\NewsTrait;
use App\Traits\NewConfigTrait;

use App\Models\CategoriaNoticia;
use App\Models\Noticia;
use App\Models\Adjunto;
use App\Models\TagXNoticia;
use App\Models\Tag;

trait NewsTrait
{
    /**
     * Encuentra si existe la categoria basandose en el parametro pasado.
     * @param $categoria - Categoria de la noticia
     * @return Boolean - Existe o no la categoria
     */
    private function categoryExists($categoria, $type = 'id'){
        if(!CategoriaNoticia::exists($type, $categoria)){
            throw response()->view('errors.custom', [], 500);
        }
    }

    /**
     * Crear un nombre para cada portada de cada noticia
     * @param String $randomString
     * @param Array $fileData
     * @return String
     */
    public function getMainName($randomString, array $fileData){
        return $randomString.'-main.'.strtolower($fileData['ext']);
    }

    /**
     * Devuelve los nombres de los adjuntos de una noticia
     * @param String $randomString
     * @param Array $fileData
     * @return String
     */
    public function getSecondaryName($randomString, array $fileData, $position){
        return $randomString.'-media'.$position.'.'.strtolower($fileData['ext']);
    }

    /**
     * Obtener la informacion importante de cada archivo
     * @param File $file
     * @return Array $array;
     */
    public function parseFile($file){

        $array =  [
            "name" => $file->getClientOriginalName(),
            "ext" => $file->getClientOriginalExtension(),
            "size" => $file->getClientSize(),
        ];
        return $array;
    }

    /**
     * Ruta del back-end para guardar la noticia
     * @param Request $request
     * @return View - Vista retornada
     */
    public function guardarNoticia(Request $request){
        try {

            //Guardar la Noticia
            DB::beginTransaction();
        
            //Validar el request
            Validator::make($request->all(), [
                'contenido' => 'required|string',
                'titulo' => 'required|string|size:50',
                'categoria' => 'required|integer',
                'tag' => 'required|array',
                'descripcion' => 'required|string|size:300',
                'portada' => 'required|file|size:4048',
                'images' => 'sometimes|array'
            ]);
            
            //Hash de la Noticia
            $randomString = AppComun::generateRandomString(10);
            $bcrypt = hash('SHA256', $randomString);
            $hash = substr($bcrypt, 9, strlen($bcrypt) - 20);
            
            //Nombre del ".html" de la noticia
            $this->file_noticia = $hash.'.html';

            //Nombre de la imagen de portada
            $imagenData = $this->parseFile($request->portada);
            $this->file_portada = $this->getMainName($hash, $imagenData);
            
            $request->portada->move(storage_path().'/app/public/portadas', $this->file_portada);

            $id_usuario = Session::get('usuario_backend')->id;
            
            $noticia = new Noticia;
            $noticia->titulo = $request->titulo;
            $noticia->descripcion = $request->descripcion;
            $noticia->code = $hash;
            $noticia->id_writer = $id_usuario;
            $noticia->foto_portada = $this->file_portada;
            $noticia->id_categoria = $request->categoria;
            $noticia->title_position = $request->title_position;
            $noticia->save();

            //verificar que los tags existen, los que no existan, ingresarlos
            foreach($request->tag as $key => $tag_defined){
                $tag[$key] = Tag::whereRaw("LOWER(tag.nombre) = '".strtolower($tag_defined)."'::text")->first();
                if(!$tag[$key]){
                    $tag[$key] = Tag::create([
                        'nombre' => $tag_defined
                    ]);
                }
            }

            //Guardar los tags
            foreach($tag as $tagToSave){
                $tagxnoticia = new TagXNoticia;
                $tagxnoticia->id_tag = $tagToSave->id;
                $noticia->TagDeNoticia()->save($tagxnoticia);
            }

            //guardar la noticia en storage .html
            $this->file_noticia = $hash.'.html';
            Storage::disk('noticia')->put($hash.'.html', $request->contenido);

            DB::commit();

            //Culminar    
            return response()->json([
                'success' => 'La noticia fue cargada exitosamente'
            ]);

        } catch(\Exception $e) {

            DB::rollBack();

            //eliminar noticia si existe
            if(Storage::disk('noticia')->exists($this->file_noticia)){
                Storage::disk('noticia')->delete($this->file_noticia);
            }

            //eliminar portada si existe
            if(Storage::disk('portada')->exists($this->file_portada)){
                Storage::disk('portada')->delete($this->file_portada);
            }

            error_log($e);

            return json_encode(['error' => $e->getMessage()]);
       
        }
        
    }

    /**
     * Clasificar todos los tipos de grillas
     * @param Array $files
     * @return Array $data
     */
    private function classify(array $files){
        $data = [];
        $current = '';
        foreach($files as $key => $f){
            if(explode('-',$f)[0] != $current){
                $current = explode('-',$f)[0];
            }
            $data[$current][] = $f;
        }
        return $data;
    }

    /**
     * Apagar las grillas si hay un espacio sin noticia.
     * @param Object $grilla
     * @param Object $config
     */
    private function thereIsEmpty($grilla, $config)
    {
        if(!$grilla){
            $config->grilla_switch = false;
        } else {
            foreach($grilla as $g)
            {
                if(!$g){
                    $config->grilla_switch = false;
                }
            }
        }

        return $config;
    }

    /**
     * Mostrar una configuracion mucho mas eficiente.
     * @param Configuracion $config
     * @return ConfigFlex $vars
     */
    private function parseConfig($config)
    {
        $vars = new \stdClass();

        foreach($config->switches as $key => $c){
            $vars->{$key} = $c->valor;
        }

        if(isset($config->grilla_current_layout)){
            $vars->grilla_current_layout = $config->grilla_current_layout;
        }

        return $vars;
    }

    /**
     * Funcion que añade las vistas a las paginas cada vez que una ip entra.
     * @param Noticia $id
     * @param Request $request
     * @return void
     */
    private function ratingHandler($noticia, $request)
    {
        $prev = str_replace(url('/'),'',url()->previous()); 
        if($prev == '/noticias'){
            if(Session::has('usuario')){
                $usuario = Session::get('usuario');
                DB::table('noticias.vista')->insert([
                    'id_noticia' => $noticia->id,
                    'ip_address' => $request->ip(),
                    'id_usuario' => $usuario->id,
                ]);
            } else {
                DB::table('noticias.vista')->insert([
                    'id_noticia' => $noticia->id,
                    'ip_address' => $request->ip(),
                    'id_usuario' => null,
                ]);
            }
        }
    }


    public function addImage(){
        return 'true';
    }

    public function removeImage(){
        return 'true';
    }

}
