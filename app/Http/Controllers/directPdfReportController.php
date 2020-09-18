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
use App\Models\Clicks;
class directPdfReportController extends Controller
{
    public function index(){
        $permissions = permission::where("user_id",session("user_id"))->first();
        $agents = user::whereIn('role', array(3,4,5))->get();

        $description = 'Direct pdf report is visited.';
        Clicks::create(['user_id'=>session('user_id'),'user_name'=>session('user_name'),'page_name'=>'PDF Report','description'=>$description]);
        return view("direct-pdf-report",compact("agents", "permissions"));
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
            $description = 'Pdf report generated of '.$agentName.' and report type is '.$request->report_type;
            Clicks::create(['user_id'=>session('user_id'),'user_name'=>session('user_name'),'page_name'=>'PDF Report','description'=>$description]);
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
            $description = 'Pdf report generated of '.$agentName.' and report type is '.$request->report_type;
            Clicks::create(['user_id'=>session('user_id'),'user_name'=>session('user_name'),'page_name'=>'PDF Report','description'=>$description]);
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
            $description = 'Pdf report generated of '.$agentName.' and report type is '.$request->report_type;
            Clicks::create(['user_id'=>session('user_id'),'user_name'=>session('user_name'),'page_name'=>'Generate PDF Report','description'=>$description]);
            view()->share(['coldcallings'=>$coldcallings,'fromDate'=>@$fromDate,"toDate"=>@$toDate,"agentName"=>$agentName->user_name,'reportType'=>$report_type,  'total_coldcallings'=>$total_coldcallings]);   
        }

        $pdf = PDF::loadView('direct-report-template')->setPaper('a2', 'portrait');

        return $pdf->download(''.$agentName->user_name.'-direct-report.pdf');
    }

    public function ClicksReport(Request $request){
        
        $permissions = permission::where("user_id",session("user_id"))->first();
        $agents = user::whereIn('role', array(3,4,5))->get();
        $description = 'Clicks report page is visited.';
        $clicks = Clicks::all();
        Clicks::create(['user_id'=>session('user_id'),'user_name'=>session('user_name'),'page_name'=>'Clicks Report','description'=>$description]);
        return view('ClickReport',compact("agents", "permissions","clicks"));
    }
    
    public function SearchClicksReport(Request $request){
        
        // dd($request->all());
        $agent = $request->agent;
        $from_date = $request->from_date;
        $to_date = $request->to_date;
        $user = user::where('id',$agent)->first();
        if(!empty($agent) && !empty($from_date) && !empty($to_date)){
            $clicks = Clicks::where('user_id',$agent)->whereBetween('created_at',[$from_date,$to_date])->get();
            $search_result_for = '<h5> Your Search result is for following perameters. </h5><br> <p><strong>Agent:</strong> '.$user->user_name.', <strong>From Date:</strong> '.$from_date.', <strong>To Date:</strong> '.$to_date.'</p>';
        }else if(!empty($agent) && !empty($from_date)){
            $clicks = Clicks::where('user_id',$agent)->where('created_at','>',$from_date)->get();
            $search_result_for = '<h5> Your Search result is for following perameters. </h5><br> <p><strong>Agent:</strong> '.$user->user_name.', <strong>From Date:</strong> '.$from_date;
        }else if(!empty($agent) && !empty($to_date)){
            $clicks = Clicks::where('user_id',$agent)->where('created_at','<',$to_date)->get();
            $search_result_for = '<h5> Your Search result is for following perameters. </h5><br> <p><strong>Agent:</strong> '.$user->user_name.', <strong>To Date:</strong> '.$to_date.'</p>';
        }else if(!empty($agent)){
            $clicks = Clicks::where('user_id',$agent)->get();
            $search_result_for = '<h5> Your Search result is for following perameters. </h5><br> <p><strong>Agent:</strong> '.$user->user_name;
        }else{
            $clicks = Clicks::all();
        }

        $permissions = permission::where("user_id",session("user_id"))->first();
        $agents = user::whereIn('role', array(3,4,5))->get();
        $description = 'Clicks report Search';
        Clicks::create(['user_id'=>session('user_id'),'user_name'=>session('user_name'),'page_name'=>'Clicks Report','description'=>$description]);
        return view('ClickReport',compact("agents", "permissions","clicks","search_result_for"));
    }    
}