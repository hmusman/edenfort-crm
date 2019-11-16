<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;
use Carbon\Carbon;
class deal extends Model
{
   
    //
    protected $table = "deals";
     protected $fillable=['deal_start_date','contract_start_date','contract_end_date','broker_name','unit_no','referenceNo','client_name','contanct_no','email','property_type','rent_sale_value','rentalCheques','building','dealStatus','agent_name','gross_commission','gc_vat','sac_vat','company_commision','cc_vat','efAgentCommission','efAgentVat','secondAgentName','secondAgentCompany','sacPhone','secondAgentCommission','sacAgentVat','thirdAgentName','thirdAgentCompany','tacPhone','thirdAgentCommission','tacVat','paymentTerms','chequeNumber','ownerCompanyName','ownerName','ownerPhone','ownerEmail','ownerNameSecond','ownerPhoneSecond','ownerEmailSecond','chequeAmount','note','user_id'];
     public static function getCurrenMonthSalary($id){
         $getSalaray = DB::table('agent_accounts')->where('agent_id',$id)->whereYear('created_at', Carbon::now()->year)->whereMonth('created_at', Carbon::now()->month)->count();
         if($getSalaray > 0){
             return true;
         }else{
              return false;
         }
     }
     public static function getCurrenMonthSalaryAmount($id,$month,$year){
         $getSalaray = DB::table('agent_accounts')->where('agent_id',$id)->whereYear('created_at', $year)->whereMonth('created_at', $month)->first();
        return $getSalaray;
     }
     public static function getMonthDeals($id,$month,$currentYear){
         $getDeals = DB::table('deals')->where('agent_name',$id)->whereYear('deal_start_date', $currentYear)->whereMonth('deal_start_date', $month)->get();
        return $getDeals;
     }
     public static function getDealBudget($id,$month,$currentYear){
         $getCommission = DB::table('deals')->where('agent_name',$id)->whereYear('deal_start_date', $currentYear)->whereMonth('deal_start_date', $month)->sum('company_commision');
        return $getCommission;
     }
     public static function getAgentSalary($id,$month,$currentYear){
         $getSalary = DB::table('agent_accounts')->where('agent_id',$id)->whereYear('created_at', $currentYear)->whereMonth('created_at', $month)->first();
         return $getSalary;
        
     }
     public static function getTotalDealsCommissions($month,$currentYear){
         $getCompanyCommission = DB::table('deals')->whereYear('deal_start_date', $currentYear)->whereMonth('deal_start_date', $month)->sum('company_commision');
         $getAgentCommission = DB::table('deals')->whereYear('deal_start_date', $currentYear)->whereMonth('deal_start_date', $month)->sum('efAgentCommission');
         $commissions = array($getCompanyCommission,$getAgentCommission);
        return $commissions;
     }
}
