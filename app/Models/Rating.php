<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    protected $table = 'noticias.rating';
    public $timestamps = false;
    protected $fillable = [
        'id_usuario','id_emocion','id_usuario'
    ];

    public function noticia(){
        return $this->belongsTo(Noticia::class, 'id');
    }

    public function usuario(){
        return $this->belongsTo(Usuario::class, 'id');
    }
}
