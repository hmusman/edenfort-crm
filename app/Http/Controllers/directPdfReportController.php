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
            if($request->access_type != ''){
                // dd($request->access_type);
                $access = $request->access_type;
                // dd($access);
                if($access == 'Pending'){
                    $query->where("access","=",NULL);

                }else{

                    $query->where("access","=",$access);
                }
                
            }
            
            $searchTerm = $request->agent;
            $query->where(function($q) use ($searchTerm){
                $q->where('user_id',$searchTerm)
                ->orWhere('add_by', $searchTerm);
            });
            $properties = $query->get();
            view()->share(['properties'=>$properties,'fromDate'=>@$fromDate,"toDate"=>@$toDate,"agentName"=>$agentName->user_name,'reportType'=>$request->report_type]);    
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
            
            $leads = $query->where("lead_user",$agentName->user_name)->get();
            view()->share(['leads'=>$leads,'fromDate'=>@$fromDate,"toDate"=>@$toDate,"agentName"=>$agentName->user_name,'reportType'=>$request->report_type]);  
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
            if($request->access_type != ''){
                // dd($request->access_type);
                $accessType = $request->access_type;
                if($accessType == 'Pending'){
                    $query->where("coldcallings.access","=",NULL);
                }else{

                    $query->where("coldcallings.access","=",$accessType);
                }
                
            }

            $searchTerm = $request->agent;
            $query->where(function($q) use ($searchTerm){
                $q->where('user_id',$searchTerm);
            });
            $query->join('users','coldcallings.user_id','=','users.id');
            $coldcallings = $query->get();
            $report_type = 'Property';
            view()->share(['coldcallings'=>$coldcallings,'fromDate'=>@$fromDate,"toDate"=>@$toDate,"agentName"=>$agentName->user_name,'reportType'=>$report_type]);   
        }

        $pdf = PDF::loadView('direct-report-template')->setPaper('a2', 'portrait');

        return $pdf->download(''.$agentName->user_name.'-direct-report.pdf');
    }
    
}