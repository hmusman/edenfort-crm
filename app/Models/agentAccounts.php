<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class agentAccounts extends Model
{
    protected $table='agent_accounts';
     public function user(){
    
         return $this->belongsTo('\App\Models\user','agent_id','id');
    }
    
}
