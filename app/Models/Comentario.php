<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comentario extends Model
{
    protected $table = 'noticias.comentarios';
    public $timestamps = false;
    protected $fillable = [
        'id_usuario','id_noticia','comentario','fecha_done'
    ];

    public function noticia(){
        return $this->belongsTo(Noticia::class, 'id');
    }
    
    public function usuario(){
        return $this->belongsTo(Usuario::class, 'id_usuario');
    }
}
