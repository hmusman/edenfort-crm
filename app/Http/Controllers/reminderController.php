<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Supervision;
use App\Models\SupervisionCheaque;
use App\Models\SupervisionMaintenance;
use App\Models\SupervisionComplain;
use App\Models\property;
use App\Models\lead;
use App\Models\Building;
use App\Models\coldcallingModel;
use Illuminate\Support\Facades\Input;
use DB;
use App\Models\user;
use App\Models\deal;
use App\Models\userFiles;
use App\Models\Reminder;
use App\Models\role;
use App\Models\permission;
use Session;
use Excel;
use File;
use Mail;
class reminderController extends Controller
{
	public function getallReminder(){
        if(session('role') == 'Agent'){
            $result=Reminder::where(['status'=>'viewed','add_by' => 'AGENT','user_id'=>session('user_id')])->get();
        }else if(session('role') == 'Admin'){
            $result=Reminder::where(['status'=>'viewed',"add_by"=>"ADMIN"])->get();
        }else if(session('role') == 'SuperAgent'){
            $result=Reminder::where('status' , 'viewed')->where('user_id',session('user_id'))
                     ->where(function($q) {
                         $q->where('add_by', 'ADMIN')
                           ->orWhere('add_by', 'SuperAgent');
                     })
                     ->get();
        }
        return json_decode(json_encode($result),true);
    }
    // 
     public function getReminders(){
        $mytime = \Carbon\Carbon::now();
        $date=$mytime->format('Y-m-d G:i:s');
        if(session('role') == 'Agent'){
            $result=Reminder::where('date_time','<=',$date)->where(['add_by' => 'AGENT','user_id'=>session('user_id')])->where('status',null)->get();
        }else if(session('role') == 'Admin'){
            $result=Reminder::where('date_time','<=',$date)->where('add_by', 'ADMIN')->where('status',null)->get();
        }
        else if(session('role') == 'SuperAgent'){
            $result=Reminder::where('date_time','<=',$date)->where('user_id',session('user_id'))->where('status',null)
                    ->where(function($q) {
                         $q->where('add_by', 'ADMIN')
                           ->orWhere('add_by', 'SuperAgent');
                     })->get();
        }
        foreach ($result as $key => $value) {
            // $currentDate = strtotime($date);
            // $futureDate = $currentDate+(60*5);
            // $formatDate = date("Y-m-d G:i:s", $futureDate);
            Reminder::where('id',$value->id)->update(["status"=>'viewed']);
        }
        return json_decode(json_encode($result),true);
    }
     // 
    public function deleteReminder(){
        $mytime = \Carbon\Carbon::now();
        $date=$mytime->format('Y-m-d G:i').':00';
        if(input::get('property_id')){
            if(session('role') == 'Admin'){
                 Reminder::where("property_id",input::get('property_id'))->where('add_by','ADMIN')->delete();
                $result=Reminder::where(['add_by' => 'ADMIN','status' => 'viewed'])->get();
                echo count($result);
            }else if(session('role') == 'Agent'){
                Reminder::where("property_id",input::get('property_id'))->where('user_id',session('user_id'))->delete();
                $result=Reminder::where(['status'=>'viewed','add_by' => 'AGENT','user_id'=>session('user_id')])->get();
                echo count($result);
            } else if(session('role') == 'SuperAgent'){
                Reminder::where("property_id",input::get('property_id'))->where('user_id',session('user_id'))->delete();
                $result=Reminder::where('status' , 'viewed')->where('user_id',session('user_id'))
                     ->where(function($q) {
                         $q->where('add_by', 'ADMIN')
                           ->orWhere('add_by', 'SuperAgent');
                     })
                     ->get();
                echo count($result);
            } 
        }else{
            echo "false";
        }
    }
    
    public function insertLeadReminder(){
      
        $dateTime=input::get('reminderDate');
        $description=input::get('reminderDescription');
        $currentUser=session('user_id');
        $reminderName=input::get('reminderName');
        $addby=strtoupper(session('role'));
        $reminderLeadId=input::get('reminderLeadId');
        DB::table('reminders')->insert(['date_time'=>$dateTime,'description'=>$description,'reminder_type'=>$reminderName,'reminder_of'=>'Leads','user_id'=>$currentUser,'add_by'=>$addby,'property_id'=>$reminderLeadId]);
        DB::table('leads_record')->insert(['description'=>$description,'user_id'=>$currentUser,'lead_id'=>$reminderLeadId]);
        return 'true';
    
}
//deal reminder
   public function insertDealReminder(){
      
        $dateTime=input::get('reminderDate');
        $description=input::get('reminderDescription');
        $currentUser=session('user_id');
        $reminderName=input::get('reminderName');
        $addby=strtoupper(session('role'));
        $reminderDealId=input::get('reminderDealId');
        DB::table('reminders')->insert(['date_time'=>$dateTime,'description'=>$description,'reminder_type'=>$reminderName,'reminder_of'=>'Deals','user_id'=>$currentUser,'add_by'=>$addby,'property_id'=>$reminderDealId]);
      return 'true';
    
}
    // 
     public function getreminderRecord(){
        $permissions = permission::where('user_id', session('user_id'))->first();
        if(input::get('active') == 'ADMIN' || input::get('active') == 'SUPERAGENT'){
         	if(strtoupper(input::get('ref'))=='COLDCALLING'){
         		$areas=coldcallingModel::distinct('area')->pluck('area');
                $bedrooms=coldcallingModel::distinct('Bedroom')->pluck('Bedroom');   
                $agents=user::where(['role'=>3])->get();
                $users=DB::select("SELECT a.*,b.Rule_type from users a,roles b where a.role=b.Rule_id AND b.Rule_type='owner'");
                $buildings=coldcallingModel::distinct('Building')->pluck('Building');
         		$result_data=coldcallingModel::where("id",input::get('property_id'))->paginate(20);
         		$buildingss=Building::all();
         		return view('coldCalling',compact('permissions','result_data','buildings','areas','bedrooms','agents','buildingss'));
         	}else if(strtoupper(input::get('ref'))=='PROPERTY'){
         		$areas=property::distinct('area')->pluck('area');
                $bedrooms=property::distinct('Bedroom')->pluck('Bedroom');   
                $agents=user::where(['role'=>3])->get();
                $buildingss = coldcallingModel::distinct('Building')->pluck('Building');
                $users=DB::select("SELECT a.*,b.Rule_type from users a,roles b where a.role=b.Rule_id AND b.Rule_type='owner'");
                // $buildings=property::distinct('Building')->pluck('Building');
                 $buildings=Building::all();
         		$result_data=property::where("id",input::get('property_id'))->paginate(20);
         		return view('addproperties',compact('permissions','result_data','buildings','areas','bedrooms','agents','buildingss'));
         	}else if(strtoupper(input::get('ref'))=='LEADS'){
         	    $agents=lead::distinct('lead_user')->get(); 
                $buildings=Building::distinct('building_name')->get();
	            $sources=lead::distinct('lead_source')->pluck('lead_source');
	            $leads=lead::where('id',input::get('property_id'))->paginate(25);
	            $dbName=DB::getDatabaseName();
	
	            $upcomingLeadId = DB::select("SELECT AUTO_INCREMENT FROM information_schema.TABLES WHERE TABLE_SCHEMA = '$dbName' AND TABLE_NAME = 'leads'");
         	    return view('agentLeadReport',['leads'=>$leads,'buildings'=>$buildings,'agents'=>$agents,'sources'=>$sources,'upcomingLeadId'=>$upcomingLeadId,'permissions'=>$permissions]);
         	}else{
         	    $buildings=Building::all();
                $agents=user::where(['role'=>3])->get();
                $deals=deal::where("id",input::get('property_id'))->get();
                $dbName=DB::getDatabaseName();
                $upcomingDealId = DB::select("SELECT AUTO_INCREMENT FROM information_schema.TABLES WHERE TABLE_SCHEMA = '$dbName' AND TABLE_NAME = 'deals'");
         	    return view('dealsInformation',compact('deals','buildings','agents','upcomingDealId','permissions'));
         	}
         }else if(input::get('active') == 'AGENT'){
            if(strtoupper(input::get('ref'))=='COLDCALLING'){
              $buildings = property::where('user_id',session('user_id'))->distinct('Building')->pluck('Building');        
              $areas=coldcallingModel::whereIn('Building',$buildings)->distinct('area')->pluck('area');
              $agents=user::where(['role'=>3])->get();
              $bedrooms=coldcallingModel::whereIn('Building',$buildings)->distinct('Bedroom')->pluck('Bedroom');   
              $users=DB::select("SELECT a.*,b.Rule_type from users a,roles b where a.role=b.Rule_id AND b.Rule_type='owner'");
              $result_data=coldcallingModel::where("id",input::get('property_id'))->paginate(20);
              $buildingss = coldcallingModel::distinct('Building')->pluck('Building');
                return view('agentcoldcalling',compact('result_data','buildings','areas','bedrooms','agents','buildingss','permissions'));
            }else if(strtoupper(input::get('ref'))=='PROPERTY'){
                $buildings = property::where('user_id',session('user_id'))->distinct('Building')->pluck('Building');        
                $areas=property::whereIn('Building',$buildings)->distinct('area')->pluck('area');
                 $agents=user::where(['role'=>3])->get();
                $bedrooms=property::whereIn('Building',$buildings)->distinct('Bedroom')->pluck('Bedroom');   
                $users=DB::select("SELECT a.*,b.Rule_type from users a,roles b where a.role=b.Rule_id AND b.Rule_type='owner'");
                $result_data=property::where("id",input::get('property_id'))->paginate(20);
                $buildingss = coldcallingModel::distinct('Building')->pluck('Building');
                return view('agentcoldcalling',compact('result_data','buildings','areas','bedrooms','agents','buildingss','permissions'));
            }
            else{
         	    $agents=lead::distinct('lead_user')->pluck('lead_user'); 
                $buildings=Building::distinct('building_name')->get();
	            $sources=lead::distinct('lead_source')->pluck('lead_source');
	            $leads=lead::where('id',input::get('property_id'))->paginate(25);
	            $dbName=DB::getDatabaseName();
	
	            $upcomingLeadId = DB::select("SELECT AUTO_INCREMENT FROM information_schema.TABLES WHERE TABLE_SCHEMA = '$dbName' AND TABLE_NAME = 'leads'");
         	    return view('leads',['leads'=>$leads,'buildings'=>$buildings,'agents'=>$agents,'sources'=>$sources,'upcomingLeadId'=>$upcomingLeadId,'permissions'=>$permissions]);
         	}
         }
        
    }
}