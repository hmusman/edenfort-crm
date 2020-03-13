<?php

namespace App\Http\Controllers;

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
        $agents = user::where(["status"=>1,"role"=>3])->get();
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
                $query->where("coldcallings.created_at",">=",$request->from_date);
            }
            if($request->to_date){
                $toDate = $request->to_date;
                $query->where("coldcallings.created_at","<=",$request->to_date);
            }
            $searchTerm = $request->agent;
            $query->where(function($q) use ($searchTerm){
                $q->where('user_id',$searchTerm);
            });
            $query->join('users','coldcallings.user_id','=','users.id');
            $coldcallings = $query->get();
            view()->share(['coldcallings'=>$coldcallings,'fromDate'=>@$fromDate,"toDate"=>@$toDate,"agentName"=>$agentName->user_name,'reportType'=>$request->report_type]);   
        }

        $pdf = PDF::loadView('direct-report-template')->setPaper('a2', 'portrait');
        return $pdf->download(''.$agentName->user_name.'-direct-report.pdf');
    }
    
}