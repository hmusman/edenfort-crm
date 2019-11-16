<?php

namespace App\Models;
use App\role;
use Illuminate\Database\Eloquent\Model;
use DB;
use App\Models\deal;
use Carbon\Carbon;
class user extends Model
{
	protected $table = "users";
    public function role(){
    		 return $this->hasMany('App\role','role', 'Rule_id');
    	}
    public function property(){
    		 return $this->hasMany('\App\Models\property');
    	}
    	public function coldcalling(){
    		 return $this->hasMany('\App\Models\coldcallingModel');
    	}
    	 public function getAgentsDeals()
    {
        return $this->hasMany('\App\Models\deal','agent_name','id');
    }
    public static function getCommissions(){
        $getOpenDate = DB::table('months')->select('month')->where('status','open')->first();
        $year = date('Y',strtotime($getOpenDate->month));
        $month = date('m',strtotime($getOpenDate->month));
        $companyCommission = deal::whereYear('deal_start_date', '=', $year)
              ->whereMonth('deal_start_date', '=', $month)
              ->sum("company_commision");
        $agentCommission = deal::whereYear('deal_start_date', '=', $year)
              ->whereMonth('deal_start_date', '=', $month)
              ->sum("efAgentCommission");
        $results = array(
                "companyCommission" => $companyCommission,
                "agentCommission" => $agentCommission,
            );
            return $results;
    }
         public function getAgentsSaleLeads($user)
    {

         $cDate=Date('Y-m-d');
       $current = date('Y-m-d', strtotime($cDate. ' -0 days'));

        $getSale = DB::table('leads')->where('lead_user',$user)->where('type','Sale')->whereDate('updated_at', '=', $current)->get();
        $countgetSale=count($getSale);
        return $countgetSale;
    }   
    //get Agent Leads which have Rent type
         public function getAgentsRentLeads($user)
    {

         $cDate=Date('Y-m-d');
       $current = date('Y-m-d', strtotime($cDate. ' -0 days'));

        $getSale = DB::table('leads')->where('lead_user',$user)->where('type','Rent')->whereDate('updated_at', '=', $current)->get();
        $countgetSale=count($getSale);
        return $countgetSale;
    }   
    
public function permission(){
      return $this->hasOne('\App\Models\permission');
    }
    
       //get agent leads of current month
        public function getAgentLeads($agentName)
    {


$todayDate = Carbon::today()->subDays(30);

         $agentTotalLeads = DB::table('leads')->where('lead_user',$agentName)->where('created_at', '>=', date($todayDate))->get();
         $countTotal=count($agentTotalLeads);
         return $countTotal;
 
    }   
  //get agent leads of current month  on which he works 
        public function getAgentWorking($agentName)
    {


$todayDate = Carbon::today()->subDays(30);

        //  $agentTotalLeads = DB::table('leads')->where('lead_user',$agentName)->where('created_at', '>=', date($todayDate))->whereNotNull('follow_up')->get();
        //  $countTotal=count($agentTotalLeads);
        
          $agentTotalLeads = DB::table('leads_record')->where('user_id',$agentName)->where('created_at', '>=', date($todayDate))->get();
         $countTotal=count($agentTotalLeads);
         return $countTotal;

    }  
}
