<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

Class Tag extends Model {

    protected $table = "noticias.tag";
    public $timestamps = false;
    protected $fillable = [
        'nombre',
    ];

    /**
     * Una un tag pertenece a varias noticias
     */
    public function tagDeNoticia()
    {
        return $this->hasMany(\App\Models\TagXNoticia::class, 'id_tag');
    }

    /**
     * Funcion para traer los primeros 3 que concuerde con los parametros
     * en el campo de nombre
     */
    public static function getByName($tag) {
        return self::whereRaw("nombre like('%$tag%')")
            ->orderBy('nombre')
            ->limit(3)
            ->get();
    }

}
