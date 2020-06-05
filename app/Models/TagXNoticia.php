<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

Class TagXNoticia extends Model {

    protected $table = "noticias.etiquetas_noticia";
    public $timestamps = false;
    protected $fillable = [
        'id_noticia', 'id_tag'
    ];

    /**
     * varios tags tienen varias noticias
     */
    public function noticia(){
        return $this->belongsTo(\App\Models\Noticia::class, 'id');
    }

    /**
     * varias noticias tienen varios tags
     */
    public function tag(){
        return $this->belongsTo(\App\Models\Tag::class, 'id_tag');
    }

}
