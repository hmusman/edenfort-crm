<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
class ReminderHistory extends Model
{
	protected $table = 'reminders_history';
	protected $fillable=['property_id', 'history'];
    // public $timestamps = false;
    // public function reminderDate($value)
    // {
    //     return Carbon::parse($value)->format('Y-m-d\TH:i');
    // }
    
     public function reminders(){
    
        return $this->belongsTo('\App\Models\Reminder','property_id','property_id');
    }
}
