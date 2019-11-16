<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class lead extends Model
{
    //
    
    protected $fillable=['submission_date','client_name','contact_no','email','source','area','building','type','priority','rent','buy','view_date_time','move_inn','outcome','followup_date','follow_up','feedback','user_id','lead_user','mail_id','subject','reference','lead_source'];
    
    	public function reminder(){
    		 return $this->hasMany('\App\Models\Reminder','property_id');
    	}
    	
    	public function user(){
    
        return $this->belongsTo('\App\Models\user');
    }
    	public function getLeadRecord(){
            return $this->hasMany('\App\Models\leadsRecord','lead_id','id');
        }
}
