<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Layouts extends Model
{
    protected $table = 'noticias.layouts';

    public function getPositions(){
        return $this->hasMany(\App\Models\Positions::class, 'id_layout');
    }

    public static function getByName($name){
        return self::where('name', $name)->first();
    }
}
