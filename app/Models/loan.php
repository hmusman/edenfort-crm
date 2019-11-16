<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class loan extends Model
{
    protected $table = 'loans';
	public function getAgent(){
        return $this->hasOne('\App\Models\user','id','agent_id');
    }
}
