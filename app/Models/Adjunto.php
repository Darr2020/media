<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

Class Adjunto extends Model {

    protected $table = "noticias.adjuntos";
    public $timestamps = false;
    protected $fillable = [
        'id_noticia','tipo_adjunto', 'contenido'
    ];

    /**
     * Una un tag pertenece a varias noticias
     */
    public function AdjuntoDeNoticia(){
        return $this->belongsTo(\App\Models\Noticia::class, 'id_noticia');
    }

}
