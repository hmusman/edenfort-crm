<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
class Reminder extends Model
{
	protected $table='reminders';
    public $timestamps = false;
    public function reminderDate($value)
    {
        return Carbon::parse($value)->format('Y-m-d\TH:i');
    }
    
     //lead relation with reminder
    public function lead(){
    
        return $this->belongsTo('\App\Models\lead','property_id');
    }
     public function user(){
    
        return $this->hasOne('\App\Models\user','id','user_id');
    }
}
