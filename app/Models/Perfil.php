<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

Class Perfil extends Model {

    protected $table = "perfil";
    protected $fillable = [
        'descripcion',
    ];

}
