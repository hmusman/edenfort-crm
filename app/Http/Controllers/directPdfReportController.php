<?php

namespace App\Http\Controllers;

ini_set('max_execution_time', 600);

use Illuminate\Http\Request;
use App\Models\Supervision;
use App\Models\SupervisionCheaque;
use App\Models\SupervisionMaintenance;
use App\Models\SupervisionComplain;
use App\Models\property;
use App\Models\coldcallingModel;
use Illuminate\Support\Facades\Input;
use DB;
use App\Models\lead;
use Mail;
use PDF;
use App\Models\user;
use App\Models\role;
use App\Models\Reminder;
use App\Models\Building;
use App\Models\permission;
class directPdfReportController extends Controller
{
    public function index(){
        $agents = user::whereIn('role', array(3,4))->get();
        return view("direct-pdf-report",compact("agents"));
    }
    public function generate(Request $request){
        $request->validate([
            'agent' => 'required',
            'report_type' => 'required'
        ]);
        // dd($request->all());
        $agentName = user::find($request->agent);
        if($request->report_type == "property"){
            $query = property::query();
            
            if($request->from_date){
                $fromDate = $request->from_date;
                $query->where("created_at",">=",$request->from_date);
            }
            if($request->to_date){
                $toDate = $request->to_date;
                $query->where("created_at","<=",$request->to_date);
            }

            $total_properties;
            if(!empty($request->point)){
                
                $access = explode(',', $request->point);
                // $access_type[] = $access;
                // dd($access);


                $query->whereIn('access', $access);
                
                 $total_properties =  $query->whereIn('access', $access)->where('user_id',$request->agent)->count();
            }
            $searchTerm = $request->agent;
            $query->where(function($q) use ($searchTerm){
                $q->where('user_id',$searchTerm)
                ->orWhere('add_by', $searchTerm);
            });
            $properties = $query->get();
            $total_properties =  $query->where('user_id',$request->agent)->count();
            view()->share(['properties'=>$properties,'fromDate'=>@$fromDate,"toDate"=>@$toDate,"agentName"=>$agentName->user_name,'reportType'=>$request->report_type, 'total_properties'=>$total_properties]);    
        }else if($request->report_type == "lead"){
            $query = lead::query();
            if($request->from_date){
                $fromDate = $request->from_date;
                $query->where("created_at",">=",$request->from_date);
            }
            if($request->to_date){
                $toDate = $request->to_date;
                $query->where("created_at","<=",$request->to_date);
            }
            $total_leads;
            if(!empty($request->point)){
                
                $access = explode(',', $request->point);
                // $access_type[] = $access;
                // dd($access);


                $query->whereIn('status', $access);
                
                $total_leads = $query->whereIn('status', $access)->where("lead_user",$agentName->user_name)->count();
            }
            
            $leads = $query->where("lead_user",$agentName->user_name)->get();
            $total_leads = $query->where("lead_user",$agentName->user_name)->count();
            view()->share(['leads'=>$leads,'fromDate'=>@$fromDate,"toDate"=>@$toDate,"agentName"=>$agentName->user_name,'reportType'=>$request->report_type, 'total_leads'=>$total_leads]);  
        }else if($request->report_type == "coldcallings"){
            $query = coldcallingModel::query();
            
            if($request->from_date){
                $fromDate = $request->from_date;
                $query->where("coldcallings.updated_at",">=",$request->from_date);
            }
            if($request->to_date){
                $toDate = $request->to_date;
                $query->where("coldcallings.updated_at","<=",$request->to_date);
            }

            $total_coldcallings;
            if(!empty($request->point)){
                
                $access = explode(',', $request->point);
                // $access_type[] = $access;
                // dd($access);


                $query->whereIn('coldcallings.access', $access);
                // dd($query);
                $total_coldcallings =  $query->whereIn('coldcallings.access', $access)->where('user_id',$request->agent)->count();
            }
            // if($request->point){
            //     // dd($request->access_type);
            //     $str_arr = preg_split ("/\,/", $request->point);  
            //     dd($str_arr);
            //     $accessType = $request->point;
            //     if($accessType == 'Pending'){
            //         $query->where("coldcallings.access","=",NULL);
            //     }else{

            //         $query->where("coldcallings.access","=",$accessType);
            //     }
                
            // }

            $searchTerm = $request->agent;
            $query->where(function($q) use ($searchTerm){
                $q->where('user_id',$searchTerm);
            });
            $total_coldcallings =  $query->where('user_id',$searchTerm)->count();
            $query->join('users','coldcallings.user_id','=','users.id');
            $coldcallings = $query->get();
            $report_type = 'Property';
            view()->share(['coldcallings'=>$coldcallings,'fromDate'=>@$fromDate,"toDate"=>@$toDate,"agentName"=>$agentName->user_name,'reportType'=>$report_type,  'total_coldcallings'=>$total_coldcallings]);   
        }

        $pdf = PDF::loadView('direct-report-template')->setPaper('a2', 'portrait');

        return $pdf->download(''.$agentName->user_name.'-direct-report.pdf');
    }
    
}