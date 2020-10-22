<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class coldcallingModel extends Model
{
    protected $table='coldcallings';
    
     public function user(){
    
        return $this->belongsTo('\App\Models\user','user_id','id');
    }
    public function buildingCount(){
    
        return $this->hasMany('\App\Models\coldcallingModel','Building','Building');
    }
    public function getAddBy()
    {
        return $this->hasOne('App\Models\user','id','user_id');
    }

    public function Agent(){
    
        return $this->belongsTo('\App\Models\user','user_id','id');
    }
    
    
}
