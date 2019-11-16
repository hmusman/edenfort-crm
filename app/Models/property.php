<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    protected $table='properties';
    public function getUpcomingDate()
    {
        return $this->hasOne('App\Models\Reminder','id','property_id');
    }
     public function getAddBy()
    {
        return $this->hasOne('App\Models\user','id','add_by');
    }
    public function getReminderRemarks()
    {
        return $this->hasOne('App\Models\Reminder','id','property_id');
    }
     public function user(){
    
         return $this->belongsTo('\App\Models\user','user_id','id');
    }
    public function Agent(){
    
        return $this->belongsTo('\App\Models\user','user_id','id');
    }
    
}
