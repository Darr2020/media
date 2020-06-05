<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Iframe extends Model
{
    protected $table = "noticias.iframe";
    public $timestamps = false;
    protected $fillable = [
        'nombre','contenido','active'
    ];
    protected static $available = [
        'nombre','contenido','active'
    ];

    const INSERT = 0;
    const UPDATE = 1;
    const DELETE = 2;

    /**
     * Metodo para obtener el request y procesarlo
     */
    public static function handle($type, Request $request){
        switch($type){
            
            case self::INSERT:
                $result = self::insert([
                    'nombre' => $request->titulo,
                    'contenido' => $request->value,
                ]);
                if(!$result){
                    throw new \Exception('Error de base de datos');
                }
                $result = ['success' => 'Se ha insertado el iframe correctamente'];
            break;

            case self::UPDATE:
                if(!in_array($request->label, self::$available)){
                    throw new \Exception('Error de parametros');
                }
                $result = self::where('id', $request->key)->update([
                    $request->label => $request->value
                ]);
                if(!$result){
                    throw new \Exception('Error de base de datos');
                }
                $result = ['success' => 'Se ha modificado el iframe correctamente'];
            break;

            case self::DELETE:

            break;
        }

        return $result;
    }
}
