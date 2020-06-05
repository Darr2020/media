<?php

namespace App\Models;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Intervention\Image\Facades\Image;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;

class Publicidad extends Model
{
    public $timestamps = false;
    protected $table = "noticias.publicidad";
    protected $fillable = ['peso','tipo_banner','imagen','nombre','active','fecha_agregado','link'];
    protected static $available = ['peso','tipo_banner','imagen','nombre','active','fecha_agregado','link'];
    
    /**
     * Acciones del Mutator
     */
    const INSERT = 0;
    const UPDATE = 1;

    /**
     * Tipos de banners
     */
    const CUADRADO = 0;
    const HORIZONTAL = 1;
    const VERTICAL = 2;

    /**
     * Metodo para obtener el request y procesarlo
     */
    private static $methods = [
        self::INSERT => 'insertAdvertisement',
        self::UPDATE => 'updateAdvertisement',
    ];

    /**
     * @param int $type
     * @param Request $request
     * @return Json $response
     */
    public static function handle($type, Request $request){
        return self::{self::$methods[$type]}($request);
    }

    /**
     * Obtener todos los banners publicitarios en orden de peso
     * @param null
     * @return Collection $banners
     */
    public static function getOrder(){
        return self::where('active', true)
            ->orderBy('peso', 'DESC')
            ->get();
    }

    /**
     * Insertar nuevo banner publicitario
     * @param Request $request
     */
    private static function insertAdvertisement(Request $request){
        
        $val = Validator::make($request->all(), [
            'peso' => 'required|integer',
            'value' => 'required|string',
            'image' => 'required|file',
            'tipo_banner' => 'required|integer',
            'link' => 'required|string',
        ]);

        if($val->fails()){
            throw new \Exception('Parametros invalidos');         
        }

        $image = $request->image;
        $ext = $image->getClientOriginalExtension();
        $name = substr(hash('sha256',$image->getClientOriginalName().date('d-m-Y')), 0 , 20).'.'.$ext;
        $path = Storage::disk('publicidad')->getAdapter()->getPathPrefix();

        $image = Image::make($image->getRealPath());
        
        $result = self::insert([
            'peso' => $request->peso,
            'imagen' => $name,
            'nombre' => $request->value,
            'tipo_banner' => $request->tipo_banner,
            'link' => $request->link
        ]);

        if(!$result){
            throw new \Exception('Error de base de datos');
        }

        Storage::disk('publicidad')->put($name, $image->stream());

        return ['success' => 'Nuevo banner publicitario, agregado exitosamente'];
    }

    /**
     * Actualizar los banner publicitario
     * @param Request $request
     */
    private static function updateAdvertisement(Request $request){
        
        $val = Validator::make($request->all(), [
            'label' => ['required','string', Rule::in(self::$available)],
            'value' => 'required',
            'key' => ['required','integer','exists:pgsql.noticias.publicidad,id']
        ]);

        $value = $request->value;
        $value = ($value === 'true' || $value === 'false') ? ($value === 'true') ? true:false:$value;

        if($val->fails()){
            throw new \Exception('Parametros invalidos');         
        }

        $result = self::where('id', $request->key)->update([
            $request->label => $value
        ]);

        if(!$result){
            throw new \Exception('Error de base de datos');
        }

        if(is_bool($value)){
            return ['success' => 'El banner publicitario ha sido '.(string) (($value) ? 'activado':'desactivado')];
        }

        return ['success' => 'El banner publicitario fue modificado exitosamente'];

    }
}
