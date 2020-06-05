<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Element extends Model
{
    protected $table = 'noticias.elements';

    public function position(){
        return $this->hasOne(\App\Models\Positions::class, 'id_element');
    }
}
