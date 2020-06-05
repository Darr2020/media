<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use App\Models\Rating;

Class Noticia extends Model {

    protected $table = "noticias.noticia";
    public $timestamps = false;
    protected $fillable = [
        'titulo','descripcion', 'id_writer',
        'foto_portada', 'cover', 'published', 'id_categoria',
        'fecha_esc', 'id_publisher','code','title_position'
    ];

    const INSERT = 0;
    const UPDATE = 1;
    const DELETE = 2;

    /**
     * Obtiene las noticias con los parametros del datatables
     * @param Request $request
     * @return Array $data
     */
    public static $searched = false;
    public static $orderBy = 'id';
    public static $orderDir = null;
    public static $limit = 10;
    public static $startAt = 0;
    public static $dataColumns = ['noticias.noticia.titulo','noticias.noticia.id_categoria','noticias.noticia.id_writer','noticias.noticia.fecha_esc','noticias.noticia.published',];
    public static function getNoticiasByParams($request){
        
        self::$searched = ($patt = $request->search['value']) ?: $patt;
        self::$startAt = $request->start;
        self::$orderBy = $request->order;
        self::$limit = $request->length;

        $query = self::select(
            'noticias.noticia.id', 
            'noticias.noticia.titulo', 
            'noticias.noticia.cover',
            'noticias.noticia.published',
            'noticias.noticia.descripcion',
            'noticias.noticia.id',
            'noticias.noticia.fecha_esc',
            'noticias.categoria.nombre as categoria',
            'public.usuario.nombre')
        ->join('public.usuario','public.usuario.id','=','noticias.noticia.id_writer')
        ->join('noticias.categoria', 'noticias.noticia.id_categoria', '=', 'noticias.categoria.id')
        ->distinct();

        if(Auth::user()->is('escritor')){
            $query->where('noticias.noticia.id_writer', Auth::user()->id);
        }

        if(self::$searched){
            $query->orWhereRaw("noticias.noticia.titulo like('%".self::$searched."%')");
            $query->orWhereRaw("noticias.categoria.nombre::varchar like('%".self::$searched."%')");
            $query->orWhereRaw("noticias.noticia.fecha_esc::varchar like('%".self::$searched."%')");
        }

        if(self::$orderBy){
            foreach(self::$orderBy as $order){
                $query->orderBy(self::$dataColumns[(integer) $order['column']], $order['dir']);
            }
        }

        $query->limit(self::$limit, self::$startAt);

        return [
            'draw' => $request->draw,
            'recordsTotal' => self::count(),
            'recordsFiltered' => $query->get()->count(),
            'data' => $query->get()->toArray()
        ];

    }


    /**
     * Obtener toda la data de la pagina de noticias
     * @param void
     * @return Array|Noticia $noticias
     */
    public static function getMainPageSecond($count = null){
        $resultado = self::select(
            DB::raw('count(noticias.vista.id) as vistas'),
            'noticias.categoria.nombre as categoria',
            'noticias.noticia.titulo',
            'noticias.noticia.foto_portada',
            'noticias.noticia.title_position',
            'noticias.noticia.fecha_esc',
            'noticias.noticia.fecha_publish',
            'noticias.noticia.descripcion',
            'noticias.noticia.id',
            'noticias.categoria.nombre',
            'noticias.categoria.hexcode',
            'public.usuario.nombre')
        ->where('noticias.noticia.published',true)
        ->leftJoin('noticias.categoria','noticias.categoria.id','=','noticias.noticia.id_categoria')
        ->leftJoin('public.usuario','public.usuario.id', '=', 'noticias.noticia.id_writer')
        ->leftJoin('noticias.vista','noticias.vista.id_noticia','=','noticias.noticia.id')
        ->groupBy(['noticias.noticia.id','noticias.vista.id_noticia','public.usuario.id','noticias.categoria.id'])
        ->orderBy('fecha_publish','DESC')
        ->limit(($count) ?: 6)
        ->distinct()
        ->get();

        $resultado->nomegusta = Rating::where('id_emocion', 2)->where('id_noticia', $resultado->id)->count();
        $resultado->megusta = Rating::where('id_emocion', 1)->where('id_noticia', $resultado->id)->count();
        return $resultado;
    }

    /**
     * Obtener toda la data registrada de una noticia
     * @param Noticia $id
     * @return Array $data
     */
    public static function getSingleFullData($id) {
        $resultado =  self::select(
            DB::raw('count(noticias.vista.id_noticia) as vistas'),
            'noticias.categoria.nombre as categoria',
            'noticias.categoria.id as id_categoria',
            'noticias.noticia.titulo',
            'noticias.noticia.foto_portada',
            'noticias.noticia.title_position',
            'noticias.noticia.fecha_esc',
            'noticias.noticia.fecha_publish',
            'noticias.noticia.descripcion',
            'noticias.noticia.published',
            'noticias.noticia.code',
            'noticias.noticia.id',
            'noticias.categoria.nombre',
            'noticias.categoria.hexcode',
            'public.usuario.nombre')
        ->where('noticias.noticia.id', $id)
        ->leftJoin('noticias.categoria','noticias.categoria.id','=','noticias.noticia.id_categoria')
        ->leftJoin('public.usuario','public.usuario.id', '=', 'noticias.noticia.id_writer')
        ->leftJoin('noticias.vista','noticias.vista.id_noticia','=','noticias.noticia.id')
        ->groupBy(['noticias.noticia.id','noticias.vista.id_noticia','public.usuario.id','noticias.categoria.id'])
        ->distinct()
        ->first();

        $resultado->nomegusta = Rating::where('id_emocion', 2)->where('id_noticia', $resultado->id)->count();
        $resultado->megusta = Rating::where('id_emocion', 1)->where('id_noticia', $resultado->id)->count();
        
        return $resultado;
    }

    /**
     * Ruta de API, obtener todas las noticias publicadas
     * @param void
     * @return Array $data
     */
    public static function getPublished($type = null, $count = null) {
        $result = self::select(
            DB::raw('count(noticias.vista.id) as vistas'),
            'noticias.categoria.nombre as categoria',
            'noticias.noticia.titulo',
            'noticias.noticia.foto_portada',
            'noticias.noticia.title_position',
            'noticias.noticia.fecha_esc',
            'noticias.noticia.fecha_publish',
            'noticias.noticia.descripcion',
            'noticias.noticia.id',
            'noticias.categoria.nombre',
            'noticias.categoria.hexcode',
            'public.usuario.nombre')
        ->where('noticias.noticia.published',true)
        ->leftJoin('noticias.categoria','noticias.categoria.id','=','noticias.noticia.id_categoria')
        ->leftJoin('public.usuario','public.usuario.id', '=', 'noticias.noticia.id_writer')
        ->leftJoin('noticias.vista','noticias.vista.id_noticia','=','noticias.noticia.id')
        ->groupBy(['noticias.noticia.id','noticias.vista.id_noticia','public.usuario.id','noticias.categoria.id'])
        ->orderBy('noticias.noticia.fecha_publish', 'DESC')
        ->distinct();

        if($count){
            $result->limit($count);
        }

        $result = $result->get();

        $result->transform(function($item, $k) {
            $item->nomegusta = Rating::where('id_emocion', 2)->where('id_noticia', $item->id)->count();
            $item->megusta = Rating::where('id_emocion', 1)->where('id_noticia', $item->id)->count();
            return $item;
        });

        if($type){
            return $result;
        } else {
            return $result->get()->toJson();
        }
    }

    /**
     * Obtener todas las noticias publicadas de una categoria
     * @param void
     * @param Categoria $categoria
     * @param Type $tipo
     * @param Count $limit
     * @return Array $data
     */
    public static function getPublishedByCategory($categoria, $type = null,$count = null) {
        
        $result = self::select(
            DB::raw('count(noticias.vista.id) as vistas'),
            'noticias.categoria.nombre as categoria',
            'noticias.noticia.titulo',
            'noticias.noticia.foto_portada',
            'noticias.noticia.title_position',
            'noticias.noticia.fecha_esc',
            'noticias.noticia.fecha_publish',
            'noticias.noticia.descripcion',
            'noticias.noticia.id',
            'noticias.categoria.nombre',
            'noticias.categoria.hexcode',
            'public.usuario.nombre')
        ->where('noticias.noticia.published',true)
        ->where('noticias.categoria.id', $categoria)
        ->leftJoin('noticias.categoria','noticias.categoria.id','=','noticias.noticia.id_categoria')
        ->leftJoin('public.usuario','public.usuario.id', '=', 'noticias.noticia.id_writer')
        ->leftJoin('noticias.vista','noticias.vista.id_noticia','=','noticias.noticia.id')
        ->groupBy(['noticias.noticia.id','noticias.vista.id_noticia','public.usuario.id','noticias.categoria.id'])
        ->orderBy('noticias.noticia.fecha_publish', 'DESC')
        ->distinct();

        if($count){
            $result->limit($count);
        }

        $result = $result->get();

        $result->transform(function($item, $k) {
            $item->nomegusta = Rating::where('id_emocion', 2)->where('id_noticia', $item->id)->count();
            $item->megusta = Rating::where('id_emocion', 1)->where('id_noticia', $item->id)->count();
            return $item;
        });

        if($type){
            return $result;
        } else {
            return $result->get()->toJson();
        }
    }

    /**
     * Noticias mas vistas
     * @param Cantidad $cant
     * @param Categoria|Null $categoria
     * @return Array $data
     */
    public static function mostViewed($cant = 1, $categoria = null, $type = null){
        $result = self::select(
            DB::raw('count(noticias.vista.id) as vistas'),
            'noticias.categoria.nombre as categoria',
            'noticias.noticia.titulo',
            'noticias.noticia.foto_portada',
            'noticias.noticia.title_position',
            'noticias.noticia.fecha_esc',
            'noticias.noticia.fecha_publish',
            'noticias.noticia.descripcion',
            'noticias.noticia.id',
            'noticias.categoria.nombre',
            'noticias.categoria.hexcode',
            'public.usuario.nombre')
        ->where('noticias.noticia.published',true);
        
        if($categoria){
            $result->where('noticias.noticia.id_categoria', $categoria);
        }

        $result->leftJoin('noticias.categoria','noticias.categoria.id','=','noticias.noticia.id_categoria');
        $result->leftJoin('public.usuario','public.usuario.id', '=', 'noticias.noticia.id_writer');
        $result->leftJoin('noticias.vista','noticias.vista.id_noticia','=','noticias.noticia.id');
        $result->groupBy(['noticias.noticia.id','noticias.vista.id_noticia','public.usuario.id','noticias.categoria.id']);
        $result->orderBy('vistas','DESC');
        $result->limit($cant);
        $result->distinct();
        $result = $result->get();

        $result->transform(function($item, $k) {
            $item->nomegusta = Rating::where('id_emocion', 2)->where('id_noticia', $item->id)->count();
            $item->megusta = Rating::where('id_emocion', 1)->where('id_noticia', $item->id)->count();
            return $item;
        });

        if($type){
            return $result;
        } else {
            return $result;
        }
    }

    /**
     * Obtener toda la data de la página principal
     * @param Noticia $noticia
     * @return Array $data
     */
    public static function getSinglePageData($noticia){

        foreach($noticia->TagDeNoticia->toArray() as $tag){
            $tags[] = $tag['id_tag']; 
        }

        $interest = self::select(
            DB::raw('count(noticias.vista.id) as vistas'),
            'noticias.categoria.nombre as categoria',
            'noticias.noticia.titulo',
            'noticias.noticia.foto_portada',
            'noticias.noticia.title_position',
            'noticias.noticia.fecha_esc',
            'noticias.noticia.fecha_publish',
            'noticias.noticia.descripcion',
            'noticias.noticia.id',
            'noticias.categoria.nombre',
            'noticias.categoria.hexcode',
            'public.usuario.nombre')
        ->where('noticias.noticia.published',true)
        ->where('noticias.noticia.id_categoria', $noticia->id_categoria)
        ->whereIn('noticias.etiquetas_noticia.id', $tags)
        ->leftJoin('noticias.categoria','noticias.categoria.id','=','noticias.noticia.id_categoria')
        ->leftJoin('noticias.etiquetas_noticia','noticias.etiquetas_noticia.id_noticia','=','noticias.noticia.id')
        ->leftJoin('public.usuario','public.usuario.id', '=', 'noticias.noticia.id_writer')
        ->leftJoin('noticias.vista','noticias.vista.id_noticia','=','noticias.noticia.id')
        ->groupBy(['noticias.noticia.id','noticias.vista.id_noticia','public.usuario.id','noticias.categoria.id'])
        ->orderBy('vistas','DESC')
        ->inRandomOrder()
        ->limit(3)
        ->get();

        return $interest;
    }

    /**
     * Noticias del infinite Scroll
     * @param $categoria null\integer
     * @return Array $data
     */
    public static function getScroll($categoria = null){
        $no = Session::get('loaded');
        $noticias = self::select(
            DB::raw('count(noticias.vista.id) as vistas'),
            'noticias.categoria.nombre as categoria',
            'noticias.noticia.titulo',
            'noticias.noticia.foto_portada',
            'noticias.noticia.title_position',
            'noticias.noticia.fecha_esc',
            'noticias.noticia.fecha_publish',
            'noticias.noticia.descripcion',
            'noticias.noticia.id',
            'noticias.categoria.nombre',
            'noticias.categoria.hexcode',
            'public.usuario.nombre')
        ->where('noticias.noticia.published',true)
        ->whereNotIn('noticias.noticia.id', $no)
        ->leftJoin('noticias.categoria','noticias.categoria.id','=','noticias.noticia.id_categoria')
        ->leftJoin('public.usuario','public.usuario.id', '=', 'noticias.noticia.id_writer')
        ->leftJoin('noticias.vista','noticias.vista.id_noticia','=','noticias.noticia.id')
        ->groupBy(['noticias.noticia.id','noticias.vista.id_noticia','public.usuario.id','noticias.categoria.id'])
        ->orderBy('vistas','DESC')
        ->inRandomOrder()
        ->distinct()
        ->limit(4);

        if($categoria)
        {
            $noticias->where('noticias.categoria.id', $categoria);
        }

        $result = $noticias->get();

        if($result->count() > 0)
        {
            foreach($result as $r)
            {
                $no[] = $r->id;
            }
        }

        Session::put('loaded', $no);

        return $result;
    }

    /**
     * Una noticia puede tener muchas etiquetas
     */
    public function TagDeNoticia(){
        return $this->hasMany(\App\Models\TagXNoticia::class, 'id_noticia');
    }

    /**
     * Una noticia puede tener muchos adjuntos
     */
    public function AdjuntoDeNoticia(){
        return $this->hasMany(\App\Models\Adjunto::class, 'id_noticia');
    }

    /**
     * Una noticia tiene una categoria
     */
    public function NoticiaCategoria(){
        return $this->hasOne(\App\Models\CategoriaNoticia::class, 'id');
    }

    /**
     * Comentarios de la noticia
     */
    public function comentarios(){
        return $this->hasMany(Comentario::class, 'id_noticia');
    }

    /**
     * Ratings de las noticias
     */
    public function ratings(){
        return $this->hasMany(Rating::class, 'id_noticia');
    }

    public function likes(){
        return DB::table('noticias.rating')
            ->where('id_noticia', $this->id)
            ->where('id_emocion',1)
            ->count();
    }

    public function dislikes(){
        return DB::table('noticias.rating')
            ->where('id_noticia', $this->id)
            ->where('id_emocion',2)
            ->count();
    }

}
