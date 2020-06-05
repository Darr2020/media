<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Positions extends Model
{
    protected $table = 'noticias.layout_positions';

    public function layout(){
        return $this->belongsTo(\App\Models\Layout::class, 'id');
    }

    public function element(){
        return $this->hasOne(\App\Models\Element::class,'id','id_element');
    }
}
