<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CategoriaNoticia extends Model
{
    protected $table = "noticias.categoria";

    public $timestamps = false;


    /**
     * Una categoria tiene muchas noticias
     */
    public function noticias(){
        return $this->hasMany(\App\Models\Noticia::class, 'id_categoria');
    }
}
