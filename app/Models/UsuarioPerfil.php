<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

Class UsuarioPerfil extends Model {

    protected $table = "usuario_perfil";
    protected $fillable = [
        'usuario_id', 'perfil_id',
    ];

    public function usuario(){
        return $this->belongsTo(\App\Models\Perfil::class, 'id');
    }

}
