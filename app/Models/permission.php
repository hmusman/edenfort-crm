<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class permission extends Model
{
    //
    public function user(){
    	return $this->belongsTo('\App\Models\user','user_id');
    }
    protected $fillable = ['user_id','dashboardView','propertyView','propertyAdd','propertyEdit','propertyDelete','propertyAssign','propertyBulk','coldcallingView','coldcallingAdd', 'coldCallingAssign','coldcallingBulk','leadView','leadAdd','leadEdit','leadBulk','buildingView','buildingAdd','supervisionView','supervisionAdd','dealDelete','supervisionEdit','dealView','dealAdd','dealEdit','dealBulk','loanView','loanEdit','loanAdd','updated_at'];
    
    public static function permissions(){
        return permission::where("user_id",session("user_id"))->first();
    }
}
