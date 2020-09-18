<?php

namespace App\Http\Controllers;
use App\Mail\reminderMails;
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
use App\Models\ReminderHistory;
use App\Models\role;
use App\Models\Clicks;
use App\Models\permission;
use Session;
use Excel;
use File;
use Mail;
use Carbon\Carbon;


class reminderController extends Controller
{
	public function getallReminder(){
        $mytime = \Carbon\Carbon::now();
        $date=$mytime->format('Y-m-d G:i:s');
        if(session('role') == 'Agent'){
            $result=Reminder::where(['status'=>'viewed','add_by' => 'AGENT','user_id'=>session('user_id')])->where('date_time', '<=', $date)->orderBy('date_time', 'DESC')->get();
            // dd($result);
        }
        else if(session('role') == 'SuperDuperAdmin'){
           $result=DB::select('SELECT a.id as uid, b.user_id as user_id, upper(substring(a.user_name, 1, 1)) as unam, a.user_name, count(b.id) as rid, b.status from users a,reminders b where a.id=b.user_id AND(b.status="viewed") and b.date_time <= CURRENT_TIMESTAMP GROUP BY b.user_id');
        }
        else if(session('role') == 'Admin'){
            $result=DB::select('SELECT a.id as uid, b.user_id as user_id, upper(substring(a.user_name, 1, 1)) as unam, a.user_name, count(b.id) as rid, b.status from users a,reminders b where a.id=b.user_id AND(b.status="viewed") and b.date_time <= CURRENT_TIMESTAMP GROUP BY b.user_id');
        }
        else if(session('role') == 'SuperAgent'){

            $result=DB::select('SELECT a.id as uid, b.user_id as user_id, upper(substring(a.user_name, 1, 1)) as unam, a.user_name, count(b.id) as rid, b.status from users a,reminders b where a.id=b.user_id and (add_by="SUPERAGENT" or add_by="AGENT" or add_by="ADMIN") AND(b.status="viewed") and b.date_time <= CURRENT_TIMESTAMP GROUP BY b.user_id;');
        }
        return json_decode(json_encode($result),true);
    }
    // 
     public function getReminders(){
        $mytime = \Carbon\Carbon::now();
        $date=$mytime->format('Y-m-d G:i:s');
        $message = '';
        // dd($date);
        if(session('role') == 'Agent'){
            $result=Reminder::where(['add_by' => 'AGENT','user_id'=>session('user_id')])->where('status',null)->where('date_time','<=',$date)->get();
            // dd($result);
        }
        // else if(session('role') == 'Admin'){
        //     $result=DB::table('reminders')->join('users', 'reminders.user_id','=','users.id')->select('reminders.*','users.*')->where('reminders.status',NULL)->where('reminders.date_time','<=',$date)->get();
        //             // Reminder::where('date_time','<=',$date)->where('add_by', 'ADMIN')->where('status',null)->get();
        //     // dd($result);
        // }
        // else if(session('role') == 'SuperAgent'){
        //     $result=DB::table('reminders')
        //             ->join('users', 'reminders.user_id','=','users.id')
        //             ->select('users.id AS uid', 'reminders.id AS id', 'users.user_name', 'reminders.user_id','reminders.status', DB::Raw('reminders.id, COUNT(*) AS rid'), DB::Raw('users.user_name, upper(substring(users.user_name, 1, 1)) as unam'))
        //             ->where('reminders.date_time','<=',$date)->where('reminders.status', null)->groupBy('reminders.user_id')->get();
        //     //          
        //     // Reminder::where('date_time','<=',$date)->where('user_id',session('user_id'))->where('status',null)
        //     //         ->where(function($q) {
        //     //              $q->where('add_by', 'ADMIN')
        //     //                ->orWhere('add_by', 'SuperAgent');
        //     //          })->get();
        // }
        foreach ($result as $key => $value) {
            $currentDate = strtotime($date);
            $futureDate = $currentDate+(60*5);
            $formatDate = date("Y-m-d G:i:s", $futureDate);
            Reminder::where('id',$value->id)->update(["status"=>'viewed']);
            $rem = Reminder::where('id',$value->id)->first();
            $property = coldcallingModel::where('id', $rem->property_id)->first();
            if(empty($property)){
                $property = coldcallingModel::where('id', $rem->property_id)->first();
            }
            $lead = lead::where('id', $rem->property_id)->first();
            $user = user::where('id', session('user_id'))->first();
            $receiverEmail = $user->Email;
            if($rem->reminder_of=='Deals'){
                $subject = $rem->reminder_of;
                $massage = [
                'reminder_of' => $rem->reminder_of,
                'reminder_type' => $rem->reminder_type,
                'deal_start_date' => $deal->deal_start_date,
                'contract_start_date' => $deal->contract_start_date,
                'contract_end_date' => $deal->contract_end_date,
                'building' => $deal->building,
                'referenceNo' => $deal->referenceNo,
                'broker_name' => $deal->broker_name,
                'unit_no' => $deal->unit_no,
                'client_name' => $deal->client_name,
                'contanct_no' => $deal->contanct_no,
                'email' => $deal->email,
                'property_type' => $deal->property_type,
                'rent_sale_value' => $deal->rent_sale_value,
                'rentalCheques' => $deal->rentalCheques,
                'deal_Status' => $deal->deal_Status,
                'agent_name' => $deal->agent_name,
                'gross_commission' => $deal->gross_commission,
                'gc_vat' => $deal->gc_vat,
                'company_commision' => $deal->company_commision,
                'cc_Vat' => $deal->cc_Vat,
                'efAgent_Commission' => $deal->efAgent_Commission,
                'efAgent_Vat' => $deal->efAgent_Vat,
                'secondAgentName' => $deal->secondAgentName,
                'secondAgentCompany' => $deal->secondAgentCompany,
                'sacPhone' => $deal->sacPhone,
                'secondAgent_Commission' => $deal->secondAgent_Commission,
                'sacAgent_Vat' => $deal->sacAgent_Vat,
                'thirdAgentName' => $deal->thirdAgentName,
                'thirdAgentCompany' => $deal->thirdAgentCompany,
                'tacPhone' => $deal->tacPhone,
                'thirdAgentCommission' => $deal->thirdAgentCommission,
                'tacVat' => $deal->tacVat,
                'paymentTerms' => $deal->paymentTerms,
                'chequeNumber' => $deal->chequeNumber,
                'ownerCompanyName' => $deal->ownerCompanyName,
                'ownerName' => $deal->ownerName,
                'ownerPhone' => $deal->ownerPhone,
                'ownerEmail' => $deal->ownerEmail,
                'ownerNameSecond' => $deal->ownerNameSecond,
                'ownerPhoneSecond' => $deal->ownerPhoneSecond,
                'ownerEmailSecond' => $deal->ownerEmailSecond,
                'chequeAmount' => $deal->chequeAmount,
                'note' => $deal->note,

            ];
            }else if($rem->reminder_of=='Leads'){
                $subject = $rem->reminder_of;
                $massage = [
                'reminder_of' => $rem->reminder_of,
                'reminder_type' => $rem->reminder_type,
                'Building' => $lead->building,
                'area' => $lead->area,
                'client_name' => $lead->client_name,
                'email' => $lead->email,
                'contact_no' => $lead->contact_no,
                'submission_date' => $lead->submission_date,
                'view_date_time' => $lead->view_date_time,
                'followup_date' => $lead->followup_date,
                'lead_user' => $lead->lead_user,
                'status' => $lead->status,
                'priority' => $lead->priority,

            ];
            }else{
                $subject = $rem->reminder_of;
                $massage = [
                'reminder_of' => $rem->reminder_of,
                'reminder_type' => $rem->reminder_type,
                'Building' => $property->Building,
                'area' => $property->area,
                'Landloard' => $property->Landlord,
                'email' => $property->email,
                'contact_no' => $property->contact_no,
                'comment' => $property->comment,

            ];
        }
            // $emails = [, ];
            Mail::to($receiverEmail)->cc(['upcoming@edenfort.ae'])->send(new reminderMails($massage, $subject));
            
        }
        
        return json_decode(json_encode($result),true);
    }
    public function getAdminReminders(){
        $mytime = \Carbon\Carbon::now();
        $date=$mytime->format('Y-m-d G:i:s');
        $currentDate = \Carbon\Carbon::now()->format('Y-m-d');
        // dd($currentDate);
        $futureDate = \Carbon\Carbon::now()->addMonths(3)->format('Y-m-d');
    
        // $result1;
        if(session('role') == 'Admin'){
            $result1= DB::table('reminders')->select('reminders.id as rid','reminders.*', 'users.*')->join('users', 'users.id','=','reminders.user_id')->where('user_id',session('user_id'))->where('reminders.date_time','<=',$date)->where('reminders.status',NULL)->get();
            // Reminder::where('date_time','<=',$date)->where('status',null)->get();
          // dd($result1);
            $deals = deal::whereBetween('contract_end_date', array($currentDate, $futureDate))->orderBy('contract_end_date', 'ASC')->get();
        }
        else if(session('role') =='SuperDuperAdmin'){
            $result1= DB::table('reminders')->select('reminders.id as rid','reminders.*', 'users.*')->join('users', 'users.id','=','reminders.user_id')->where('user_id',session('user_id'))->where('reminders.date_time','<=',$date)->where('reminders.status',NULL)->get();
            // Reminder::where('date_time','<=',$date)->where('status',null)->get();
          // dd($result1);
            $deals = deal::whereBetween('contract_end_date', array($currentDate, $futureDate))->orderBy('contract_end_date', 'ASC')->get();
        }
        else if(session('role') == 'SuperAgent'){
            $result1=DB::table('reminders')->select('reminders.id as rid','reminders.*', 'users.*')->join('users', 'users.id','=','reminders.user_id')->where('user_id',session('user_id'))->where('reminders.date_time','<=',$date)->where('reminders.status',NULL)->get();

            $deals = deal::whereBetween('contract_end_date', array($currentDate, $futureDate))->orderBy('contract_end_date', 'ASC')->get();
            // Reminder::where('date_time','<=',$date)->where('user_id',session('user_id'))            ->where('status',null)
            //               ->where(function($q) {
            //                   $q->where('add_by', 'ADMIN')
            //                     ->orWhere('add_by', 'SuperAgent');
            //               })->get();
        }
        if(session('role') == 'Admin' || session('role') == 'SuperDuperAdmin'|| session('role') == 'SuperAgent'){
        foreach ($deals as $key => $value) {
            if($value->email_notification == 0){

            deal::where('id',$value->id)->update(['email_notification'=>1]);
            $subject = "Deals";
            $massage = [
                'reminder_of' => "Deals_without_reminder",
                'reminder_of-1' => "Deals",
                'reminder_type' => "Deal Contract",
                'deal_start_date' => $value->deal_start_date,
                'contract_start_date' => $value->contract_start_date,
                'contract_end_date' => $value->contract_end_date,
                'building' => $value->building,
                'referenceNo' => $value->referenceNo,
                'broker_name' => $value->broker_name,
                'unit_no' => $value->unit_no,
                'client_name' => $value->client_name,
                'contanct_no' => $value->contanct_no,
                'email' => $value->email,
                'property_type' => $value->property_type,
                'rent_sale_value' => $value->rent_sale_value,
                'rentalCheques' => $value->rentalCheques,
                'deal_Status' => $value->deal_Status,
                'agent_name' => $value->agent_name,
                'gross_commission' => $value->gross_commission,
                'gc_vat' => $value->gc_vat,
                'company_commision' => $value->company_commision,
                'cc_Vat' => $value->cc_Vat,
                'efAgent_Commission' => $value->efAgent_Commission,
                'efAgent_Vat' => $value->efAgent_Vat,
                'secondAgentName' => $value->secondAgentName,
                'secondAgentCompany' => $value->secondAgentCompany,
                'sacPhone' => $value->sacPhone,
                'secondAgent_Commission' => $value->secondAgent_Commission,
                'sacAgent_Vat' => $value->sacAgent_Vat,
                'thirdAgentName' => $value->thirdAgentName,
                'thirdAgentCompany' => $value->thirdAgentCompany,
                'tacPhone' => $value->tacPhone,
                'thirdAgentCommission' => $value->thirdAgentCommission,
                'tacVat' => $value->tacVat,
                'paymentTerms' => $value->paymentTerms,
                'chequeNumber' => $value->chequeNumber,
                'ownerCompanyName' => $value->ownerCompanyName,
                'ownerName' => $value->ownerName,
                'ownerPhone' => $value->ownerPhone,
                'ownerEmail' => $value->ownerEmail,
                'ownerNameSecond' => $value->ownerNameSecond,
                'ownerPhoneSecond' => $value->ownerPhoneSecond,
                'ownerEmailSecond' => $value->ownerEmailSecond,
                'chequeAmount' => $value->chequeAmount,
                'note' => $value->note,

            ];

            Mail::to('upcoming@edenfort.ae')->send(new reminderMails($massage,$subject));
            }
        }

        }
        foreach ($result1 as $key => $value) {
            $currentDate = strtotime($date);
            $futureDate = $currentDate+(60*5);
            $formatDate = date("Y-m-d G:i:s", $futureDate);
            Reminder::where('id',$value->rid)->update(["status"=>'viewed']);

            $rem = Reminder::where('id',$value->rid)->first();
            $property = coldcallingModel::where('id', $rem->property_id)->first();
            $deal = deal::where('id', $rem->property_id)->first();
            $lead = lead::where('id', $rem->property_id)->first();
            $user = user::where('id', session('user_id'))->first();
            $receiverEmail = $user->Email;
            if($rem->reminder_of=='Deals'){
                $subject = $rem->reminder_of;
                $massage = [
                'reminder_of' => $rem->reminder_of,
                'reminder_type' => $rem->reminder_type,
                'deal_start_date' => $deal->deal_start_date,
                'contract_start_date' => $deal->contract_start_date,
                'contract_end_date' => $deal->contract_end_date,
                'building' => $deal->building,
                'referenceNo' => $deal->referenceNo,
                'broker_name' => $deal->broker_name,
                'unit_no' => $deal->unit_no,
                'client_name' => $deal->client_name,
                'contanct_no' => $deal->contanct_no,
                'email' => $deal->email,
                'property_type' => $deal->property_type,
                'rent_sale_value' => $deal->rent_sale_value,
                'rentalCheques' => $deal->rentalCheques,
                'deal_Status' => $deal->deal_Status,
                'agent_name' => $deal->agent_name,
                'gross_commission' => $deal->gross_commission,
                'gc_vat' => $deal->gc_vat,
                'company_commision' => $deal->company_commision,
                'cc_Vat' => $deal->cc_Vat,
                'efAgent_Commission' => $deal->efAgent_Commission,
                'efAgent_Vat' => $deal->efAgent_Vat,
                'secondAgentName' => $deal->secondAgentName,
                'secondAgentCompany' => $deal->secondAgentCompany,
                'sacPhone' => $deal->sacPhone,
                'secondAgent_Commission' => $deal->secondAgent_Commission,
                'sacAgent_Vat' => $deal->sacAgent_Vat,
                'thirdAgentName' => $deal->thirdAgentName,
                'thirdAgentCompany' => $deal->thirdAgentCompany,
                'tacPhone' => $deal->tacPhone,
                'thirdAgentCommission' => $deal->thirdAgentCommission,
                'tacVat' => $deal->tacVat,
                'paymentTerms' => $deal->paymentTerms,
                'chequeNumber' => $deal->chequeNumber,
                'ownerCompanyName' => $deal->ownerCompanyName,
                'ownerName' => $deal->ownerName,
                'ownerPhone' => $deal->ownerPhone,
                'ownerEmail' => $deal->ownerEmail,
                'ownerNameSecond' => $deal->ownerNameSecond,
                'ownerPhoneSecond' => $deal->ownerPhoneSecond,
                'ownerEmailSecond' => $deal->ownerEmailSecond,
                'chequeAmount' => $deal->chequeAmount,
                'note' => $deal->note,

            ];
            }
            else if($rem->reminder_of=='Leads'){
                $subject = $rem->reminder_of;
                $massage = [
                'reminder_of' => $rem->reminder_of,
                'reminder_type' => $rem->reminder_type,
                'Building' => $lead->building,
                'area' => $lead->area,
                'client_name' => $lead->client_name,
                'email' => $lead->email,
                'contact_no' => $lead->contact_no,
                'submission_date' => $lead->submission_date,
                'view_date_time' => $lead->view_date_time,
                'followup_date' => $lead->followup_date,
                'lead_user' => $lead->lead_user,
                'status' => $lead->status,
                'priority' => $lead->priority,

            ];
            }else{
                $subject = $rem->reminder_of;
                $massage = [
                'reminder_of' => $rem->reminder_of,
                'reminder_type' => $rem->reminder_type,
                'Building' => $property->Building,
                'area' => $property->area,
                'Landloard' => $property->Landlord,
                'email' => $property->email,
                'contact_no' => $property->contact_no,

            ];
            }
            
            // $emails = [$receiverEmail,'upcoming@edenfort.ae'];
            Mail::to($receiverEmail)->cc(['upcoming@edenfort.ae'])->send(new reminderMails($massage, $subject));
            // Mail::to('')->send(new reminderMails($massage));
            
        }
        // dd($result1, $result2);
        
        return json_decode(json_encode($result1),true);
    }
     // 
    public function deleteReminder(){
        if(input::get('property_id')){
            if(session('role') == 'Admin'){
                 Reminder::where("property_id",input::get('property_id'))->where(['add_by','ADMIN', 'status'=>'viewed'])->update(['status'=>'disable']);
                $result=Reminder::where(['status'=>'viewed','add_by' => 'ADMIN','user_id'=>session('user_id')])->get();
                 $description = 'Disable remidner.' ;
                 Clicks::create(['user_id'=>session('user_id'),'user_name'=>session('user_name'),'page_name'=>'Reminders','description'=>$description]);
                echo count($result);
            }else if(session('role') == 'Agent' || session('role') == 'SuperDuperAdmin'){
                Reminder::where("property_id",input::get('property_id'))->where('user_id',session('user_id'))->update(['status'=>"disable",'reason'=>input::get('name')]);
                $result=Reminder::where(['status'=>'viewed','add_by' => 'AGENT','user_id'=>session('user_id')])->get();
                $description = 'Disable remidner.' ;
                 Clicks::create(['user_id'=>session('user_id'),'user_name'=>session('user_name'),'page_name'=>'Reminders','description'=>$description]);
                echo count($result);
            } else if(session('role') == 'SuperAgent'){
                Reminder::where("property_id",input::get('property_id'))->where(['add_by','SUPERAGENT', 'status'=>'viewed'])->update(['status'=>'disable']);
                $result=Reminder::where('status' , 'viewed')->where('user_id',session('user_id'))
                     ->where(function($q) {
                         $q->where('add_by', 'ADMIN')
                           ->orWhere('add_by', 'SuperAgent');
                     })
                     ->get();
                $description = 'Disable remidner.' ;
                 Clicks::create(['user_id'=>session('user_id'),'user_name'=>session('user_name'),'page_name'=>'Reminders','description'=>$description]);
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

        $description = 'Lead remidner added.' ;
        Clicks::create(['user_id'=>session('user_id'),'user_name'=>session('user_name'),'page_name'=>'Reminders','description'=>$description]);
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

        $description = 'Deal remidner added.' ;
        Clicks::create(['user_id'=>session('user_id'),'user_name'=>session('user_name'),'page_name'=>'Reminders','description'=>$description]);
      return 'true';
    
}
    // 
     public function getreminderRecord(){
        $permissions = permission::where('user_id', session('user_id'))->first();
        if(input::get('active') == 'AGENT'){
          $allBuildings=Building::select("building_name")->orderBy("building_name","ASC")->get();
            if(strtoupper(input::get('ref'))=='COLDCALLING'){

              $buildings = coldcallingModel::where('user_id',session('user_id'))->distinct('Building')->pluck('Building');        
              $areas=coldcallingModel::whereIn('Building',$buildings)->distinct('area')->pluck('area');
              $agents=user::where(['role'=>3])->get();
              $bedrooms=coldcallingModel::whereIn('Building',$buildings)->distinct('Bedroom')->pluck('Bedroom');
              $agentss=user::where(["status"=>1])->whereIn("role",[3,4])->get(["user_name","id"]);   
              $users=DB::select("SELECT a.*,b.Rule_type from users a,roles b where a.role=b.Rule_id AND b.Rule_type='owner'");
              $result_data=coldcallingModel::where("id",input::get('property_id'))->paginate(20);
              $buildingss = coldcallingModel::distinct('Building')->pluck('Building');
              $reminders = Reminder::orderBy('date_time', 'DESC')->get();
                // dd($reminders);
                $current_date = date('Y-m-d H:i:s');
                $Formdisplay = 'none';
                $description = 'View agent coldcalling remidner detail.' ;
                Clicks::create(['user_id'=>session('user_id'),'user_name'=>session('user_name'),'page_name'=>'Reminders','description'=>$description]);
                return view('agentcoldcalling',compact('result_data','buildings','areas','bedrooms','agents','agentss', 'buildingss','permissions', 'allBuildings','reminders','current_date','Formdisplay'));
            }else if(strtoupper(input::get('ref'))=='PROPERTY'){
                $buildings = coldcallingModel::where('user_id',session('user_id'))->distinct('Building')->pluck('Building');        
                $areas=coldcallingModel::whereIn('Building',$buildings)->distinct('area')->pluck('area');
                 $agents=user::where(['role'=>3])->get();
                $bedrooms=coldcallingModel::whereIn('Building',$buildings)->distinct('Bedroom')->pluck('Bedroom');   
                $users=DB::select("SELECT a.*,b.Rule_type from users a,roles b where a.role=b.Rule_id AND b.Rule_type='owner'");
                $result_data=coldcallingModel::where("id",input::get('property_id'))->paginate(20);
                $buildingss = coldcallingModel::distinct('Building')->pluck('Building');
                $reminders = Reminder::orderBy('date_time', 'DESC')->get();
                // dd($reminders);
                $current_date = date('Y-m-d H:i:s');
                $description = 'View agent property remidner detail.' ;
                Clicks::create(['user_id'=>session('user_id'),'user_name'=>session('user_name'),'page_name'=>'Reminders','description'=>$description]);
                return view('agentProperties',compact('result_data','buildings','areas','bedrooms','agents','buildingss','permissions','allBuildings','reminders','current_date'));
            }
            else{
         	    $agents=lead::distinct('lead_user')->pluck('lead_user'); 
                $buildings=Building::distinct('building_name')->get();
	            $sources=lead::distinct('lead_source')->pluck('lead_source');
	            $leads=lead::where('id',input::get('property_id'))->paginate(25);
	            $dbName=DB::getDatabaseName();
	
	            $upcomingLeadId = DB::select("SELECT AUTO_INCREMENT FROM information_schema.TABLES WHERE TABLE_SCHEMA = '$dbName' AND TABLE_NAME = 'leads'");
                $description = 'View agent lead remidner detail.' ;
                Clicks::create(['user_id'=>session('user_id'),'user_name'=>session('user_name'),'page_name'=>'Reminders','description'=>$description]);
         	    return view('leads',['leads'=>$leads,'buildings'=>$buildings,'agents'=>$agents,'sources'=>$sources,'upcomingLeadId'=>$upcomingLeadId,'permissions'=>$permissions]);
         	}
         }
        else if(input::get('active') == 'ADMIN' || input::get('active') == 'SuperAgent'){
          $allBuildings=Building::select("building_name")->orderBy("building_name","ASC")->get();
            if(strtoupper(input::get('ref'))=='COLDCALLING'){

              $permissions = permission::where('user_id', session('user_id'))->first();
              $areas=coldcallingModel::distinct('area')->pluck('area');
              $bedrooms=coldcallingModel::distinct('Bedroom')->pluck('Bedroom');   
              $agents=user::where(['role'=>3,"status"=>1])->orWhere(['role'=>1])->get();
              $agentss=user::where(["status"=>1])->whereIn("role",[3,4])->get(["user_name","id"]);
              $users=DB::select("SELECT a.*,b.Rule_type from users a,roles b where a.role=b.Rule_id AND b.Rule_type='owner'");
              $buildings=coldcallingModel::distinct('Building')->pluck('Building');
              $buildingss=Building::all();
              $result_data=coldcallingModel::where("id",input::get('property_id'))->paginate(20);
              // $buildingss = coldcallingModel::distinct('Building')->pluck('Building');
              $upcoming = coldcallingModel::where('access','Upcoming')->count();
              $Formdisplay = 'none';
              $reminders = Reminder::orderBy('date_time', 'DESC')->get();
                // dd($reminders);
                $current_date = date('Y-m-d H:i:s');
                $description = 'View agent coldcalling remidner detail.' ;
                Clicks::create(['user_id'=>session('user_id'),'user_name'=>session('user_name'),'page_name'=>'Reminders','description'=>$description]);
                return view('coldCalling',compact(['result_data','users','agentss','agents','areas','bedrooms','buildings','buildingss','permissions','upcoming','Formdisplay','reminders','current_date']));
            }else if(strtoupper(input::get('ref'))=='PROPERTY'){
                $permissions = permission::where('user_id', session('user_id'))->first();
                $areas=coldcallingModel::distinct('area')->pluck('area');
                $bedrooms=coldcallingModel::distinct('Bedroom')->pluck('Bedroom');
                $users=DB::select("SELECT a.*,b.Rule_type from users a,roles b where a.role=b.Rule_id AND b.Rule_type='owner'");
                $agents=DB::select("SELECT a.*,b.Rule_type from users a,roles b where a.role=b.Rule_id AND b.Rule_type='agent'");
                 $buildings=Building::all();
                 $agentss=user::where(["status"=>1])->whereIn("role",[3,4])->get(["user_name","id"]);
                $result_data=coldcallingModel::where("id",input::get('property_id'))->paginate(20);
                $buildingss = coldcallingModel::distinct('Building')->pluck('Building');
                $upcoming = coldcallingModel::where('access','Upcoming')->count();
                $reminders = Reminder::orderBy('date_time', 'DESC')->get();
                // dd($reminders);
                $current_date = date('Y-m-d H:i:s');
                $description = 'View property coldcalling remidner detail.' ;
                Clicks::create(['user_id'=>session('user_id'),'user_name'=>session('user_name'),'page_name'=>'Reminders','description'=>$description]);
                return view('addproperties',compact(['result_data','users','agents','areas','bedrooms','buildings','permissions','agentss','upcoming','reminders','current_date']));            }
            else{
                $agents=lead::distinct('lead_user')->pluck('lead_user'); 
                $buildings=Building::distinct('building_name')->get();
                $sources=lead::distinct('lead_source')->pluck('lead_source');
                $leads=lead::where('id',input::get('property_id'))->paginate(25);
                $dbName=DB::getDatabaseName();
    
                $upcomingLeadId = DB::select("SELECT AUTO_INCREMENT FROM information_schema.TABLES WHERE TABLE_SCHEMA = '$dbName' AND TABLE_NAME = 'leads'");
                $description = 'View agent lead remidner detail.' ;
                Clicks::create(['user_id'=>session('user_id'),'user_name'=>session('user_name'),'page_name'=>'Reminders','description'=>$description]);
                return view('leads',['leads'=>$leads,'buildings'=>$buildings,'agents'=>$agents,'sources'=>$sources,'upcomingLeadId'=>$upcomingLeadId,'permissions'=>$permissions]);
            }
         }
    }

    public function getSingleReminderRecord(){
      $permissions = permission::where('user_id', session('user_id'))->first();
      if(input::get('active') == 'SUPERAGENT' || 'ADMIN'){
          if(strtoupper(input::get('ref'))=='COLDCALLING'){
            $areas=coldcallingModel::distinct('area')->pluck('area');
                $bedrooms=coldcallingModel::distinct('Bedroom')->pluck('Bedroom');   
                $agents=user::where(['role'=>3])->get();
                $agentss=user::where(["status"=>1])->whereIn("role",[3,4])->get(["user_name","id"]);
                $users=DB::select("SELECT a.*,b.Rule_type from users a,roles b where a.role=b.Rule_id AND b.Rule_type='owner'");
                $buildings=coldcallingModel::distinct('Building')->pluck('Building');
            $result_data=coldcallingModel::where("id",input::get('property_id'))->paginate(20);
            $buildingss=Building::all();
                if(input::get('status')!='viewed'){
                    Reminder::where('property_id',input::get('property_id'))->where('user_id', session('user_id'))->update(['status'=>'viewed']);
                }
            $upcoming = coldcallingModel::where('access','Upcoming')->count();
            $reminders = Reminder::orderBy('date_time', 'DESC')->get();
            // dd($reminders);
            $current_date = date('Y-m-d H:i:s');
            $Formdisplay = 'none';
            $description = 'View agent coldcalling remidner detail.' ;
            Clicks::create(['user_id'=>session('user_id'),'user_name'=>session('user_name'),'page_name'=>'Reminders','description'=>$description]);
            return view('coldCalling',compact('permissions','result_data','buildings','areas','bedrooms','agents','agentss','buildingss','upcoming','reminders','current_date','Formdisplay'));
          }else if(strtoupper(input::get('ref'))=='PROPERTY'){
            $areas=coldcallingModel::distinct('area')->pluck('area');
                $bedrooms=coldcallingModel::distinct('Bedroom')->pluck('Bedroom');   
                $agents=user::where(['role'=>3])->get();
                $agentss=user::where(["status"=>1])->whereIn("role",[3,4])->get(["user_name","id"]);
                $buildingss = coldcallingModel::distinct('Building')->pluck('Building');
                $users=DB::select("SELECT a.*,b.Rule_type from users a,roles b where a.role=b.Rule_id AND b.Rule_type='owner'");
                 $upcoming = coldcallingModel::where('access','Upcoming')->count();
                // $buildings=coldcallingModel::distinct('Building')->pluck('Building');
                 $buildings=Building::all();
            $result_data=coldcallingModel::where("id",input::get('property_id'))->paginate(20);
                if(input::get('status')!='viewed'){
                    Reminder::where('property_id',input::get('property_id'))->where('user_id', session('user_id'))->update(['status'=>'viewed']);
                }
            $reminders = Reminder::orderBy('date_time', 'DESC')->get();
            // dd($reminders);
            $current_date = date('Y-m-d H:i:s');
            $description = 'View agent property remidner detail.' ;
                Clicks::create(['user_id'=>session('user_id'),'user_name'=>session('user_name'),'page_name'=>'Reminders','description'=>$description]);
            return view('addproperties',compact('permissions','result_data','buildings','areas','bedrooms','agents','agentss','buildingss','upcoming','reminders','current_date'));
          }else if(strtoupper(input::get('ref'))=='LEADS'){
              $agents=lead::distinct('lead_user')->get(); 
                $buildings=Building::distinct('building_name')->get();
              $sources=lead::distinct('lead_source')->pluck('lead_source');
              $leads=lead::where('id',input::get('property_id'))->paginate(25);
              $dbName=DB::getDatabaseName();
  
              $upcomingLeadId = DB::select("SELECT AUTO_INCREMENT FROM information_schema.TABLES WHERE TABLE_SCHEMA = '$dbName' AND TABLE_NAME = 'leads'");
                if(input::get('status')!='viewed'){
                    Reminder::where('property_id',input::get('property_id'))->where('user_id', session('user_id'))->update(['status'=>'viewed']);
                        }
                $description = 'View agent lead remidner detail.' ;
                Clicks::create(['user_id'=>session('user_id'),'user_name'=>session('user_name'),'page_name'=>'Reminders','description'=>$description]);
              return view('agentLeadReport',['leads'=>$leads,'buildings'=>$buildings,'agents'=>$agents,'sources'=>$sources,'upcomingLeadId'=>$upcomingLeadId,'permissions'=>$permissions]);
          }else{
              $buildings=Building::all();
                $agents=user::where(['role'=>3])->get();
                $deals=deal::where("id",input::get('property_id'))->paginate(25);
                $dbName=DB::getDatabaseName();
                $getAgentName = '';
                $upcomingDealId = DB::select("SELECT AUTO_INCREMENT FROM information_schema.TABLES WHERE TABLE_SCHEMA = '$dbName' AND TABLE_NAME = 'deals'");
                if(input::get('status')!='viewed'){
                    Reminder::where('property_id',input::get('property_id'))->where('user_id', session('user_id'))->update(['status'=>'viewed']);
                }
                $date = Carbon::now()->toDateString();
                $description = 'View agent deal remidner detail.' ;
                Clicks::create(['user_id'=>session('user_id'),'user_name'=>session('user_name'),'page_name'=>'Reminders','description'=>$description]);
              return view('dealsInformation',compact('deals','buildings','agents','upcomingDealId','permissions', 'date'));
          }
         }
    }

     public function oneUserReminder($id){
        $mytime = \Carbon\Carbon::now();
        $datetime = $mytime->format('Y-m-d G:i:s');
        $permissions = permission::where('user_id', session('user_id'))->first();
        $user = user::where('id', $id)->get()->first();
        $reminder = Reminder::where('user_id', $id)->where('date_time','<=', $datetime)->where(function($q) {
                         $q->where('status', 'viewed');
                           // ->orWhere('status', null);
                     })->orderBy('date_time', 'DESC')
                     ->get();
        // $result=Reminder::where('status' , 'viewed')->where('user_id',session('user_id'))
        //              ->where(function($q) {
        //                  $q->where('add_by', 'ADMIN')
        //                    ->orWhere('add_by', 'SuperAgent');
        //              })
        //              ->get();
        $description = 'Open '.$user->user_name.' remidners.' ;
        Clicks::create(['user_id'=>session('user_id'),'user_name'=>session('user_name'),'page_name'=>'Reminders','description'=>$description]);
        return view('single-user-reminder', compact('reminder','user','permissions'));
    }

    public function remindersCount(){

        if(session('role') == 'Agent'){
            $remindersCount = DB::select('SELECT t.user_id as userid, t.add_by as urole, t.status as status, COUNT(t.status) as unviewed_reminders, a.id as uid, a.role, b.Rule_type as User from reminders t, users a, roles b where (t.status= "" and t.user_id=a.id and a.role=b.Rule_id AND b.Rule_type="Agent") GROUP BY t.user_id');
        }else if(session('role') == 'Admin'){
            $remindersCount = DB::select('SELECT t.user_id as userid, t.add_by as urole, t.status as status, COUNT(t.status) as unviewed_reminders, a.id as uid, a.role, b.Rule_type as User from reminders t, users a, roles b where (t.status= "" and t.user_id=a.id and a.role=b.Rule_id AND b.Rule_type="Admin") GROUP BY t.user_id');
        }else if(session('role') == 'SuperAgent'){
            $remindersCount = DB::select('SELECT t.user_id as userid, t.add_by as urole, t.status as status, COUNT(t.status) as unviewed_reminders, a.id as uid, a.role, b.Rule_type as User from reminders t, users a, roles b where (t.status= "" and t.user_id=a.id and a.role=b.Rule_id AND b.Rule_type="SuperAgent") GROUP BY t.user_id');
        }
        return json_decode(json_encode($remindersCount),true);
    }

     public function deleteSingleReminder(){
        // $reason=strip_tags(input::get('reason'));
        if(input::get('property_id')){
            if(session('role') == 'Agent'){
                Reminder::where('property_id',$id)->where(['add_by' => 'AGENT', 'status' => 'viewed' ,'user_id'=>session('user_id')])->update(["status"=>'disable']);
                $description = 'Disable remidners.' ;
                Clicks::create(['user_id'=>session('user_id'),'user_name'=>session('user_name'),'page_name'=>'Reminders','description'=>$description]);
            }else if(session('role') == 'Admin'){
                Reminder::where('property_id',input::get('property_id'))->where(['add_by' => 'ADMIN','user_id'=>session('user_id')])->update(["status"=>'disable', 'reason'=>input::get('name')]);
                $description = 'Disable remidners.' ;
                Clicks::create(['user_id'=>session('user_id'),'user_name'=>session('user_name'),'page_name'=>'Reminders','description'=>$description]);
                // Reminder::where('property_id',$property_id)->where(['add_by' => 'ADMIN','user_id'=>session('user_id')])->update(["status"=>'viewed']);
            }
            else if(session('role') == 'SuperDuperAdmin'){
                Reminder::where('property_id',input::get('property_id'))->where(['add_by' => 'ADMIN','user_id'=>session('user_id')])->update(["status"=>'disable', 'reason'=>input::get('name')]);
                $description = 'Disable remidners.' ;
                Clicks::create(['user_id'=>session('user_id'),'user_name'=>session('user_name'),'page_name'=>'Reminders','description'=>$description]);
                // Reminder::where('property_id',$property_id)->where(['add_by' => 'ADMIN','user_id'=>session('user_id')])->update(["status"=>'viewed']);
            }
            else if(session('role') == 'SuperAgent'){
                Reminder::where('property_id',input::get('property_id'))->where(['user_id'=>session('user_id')])
                ->where(function($q) {
                             $q->where('add_by', 'ADMIN')
                               ->orWhere('add_by', 'SuperAgent')
                               ->orWhere('add_by', 'Agent');
                         })->update(["status"=>'disable', 'reason'=>input::get('name')]);
                $description = 'Disable remidners.' ;
                Clicks::create(['user_id'=>session('user_id'),'user_name'=>session('user_name'),'page_name'=>'Reminders','description'=>$description]);
            }
            return "true";
        }else{
            return "false";
        }
        
    }


    public function updateReminderRecord(){
      if(input::get('property_id')){
        $timedate = date('Y-m-d H:i:s', strtotime(input::get('datetime')));
        if(session('role') == 'Admin' ){

            $property = Reminder::where('property_id',input::get('property_id'))->where('user_id',session('user_id'))->first(['property_id']);
            $property_id = $property->property_id;
            $oldReminder = Reminder::where('property_id',input::get('property_id'))->where('user_id',session('user_id'))->first(['property_id', 'reminder_type', 'reminder_of', 'user_id', 'date_time', 'description']);

            // $history = json_encode($oldReminder);
            Reminder::where('property_id', input::get('property_id'))->where('user_id', session('user_id'))->update(['description' => input::get('description'), 'date_time' => $timedate, 'status' => NULL]);

            $description = 'Update remidners.' ;
            Clicks::create(['user_id'=>session('user_id'),'user_name'=>session('user_name'),'page_name'=>'Reminders','description'=>$description]);

            ReminderHistory::updateOrCreate(
              ['property_id' => $property_id],
              ['history' => $oldReminder]
            );
            
        }
        else if(session('role') == 'SuperDuperAdmin' ){

            $property = Reminder::where('property_id',input::get('property_id'))->where('user_id',session('user_id'))->first(['property_id']);
            $property_id = $property->property_id;
            $oldReminder = Reminder::where('property_id',input::get('property_id'))->where('user_id',session('user_id'))->first(['property_id', 'reminder_type', 'reminder_of', 'user_id', 'date_time', 'description']);

            // $history = json_encode($oldReminder);
            Reminder::where('property_id', input::get('property_id'))->where('user_id', session('user_id'))->update(['description' => input::get('description'), 'date_time' => $timedate, 'status' => NULL]);

            $description = 'Update remidners.' ;
            Clicks::create(['user_id'=>session('user_id'),'user_name'=>session('user_name'),'page_name'=>'Reminders','description'=>$description]);

            ReminderHistory::updateOrCreate(
              ['property_id' => $property_id],
              ['history' => $oldReminder]
            );
            
        }
        else if(session('role') == 'SuperAgent' ){

            $property = Reminder::where('property_id',input::get('property_id'))->where('user_id',session('user_id'))->first(['property_id']);
            $property_id = $property->property_id;
            $oldReminder = Reminder::where('property_id',input::get('property_id'))->where('user_id',session('user_id'))->first(['property_id', 'reminder_type', 'reminder_of', 'user_id', 'date_time', 'description']);

            // $history = json_encode($oldReminder);
            Reminder::where('property_id', input::get('property_id'))->where('user_id', session('user_id'))->update(['description' => input::get('description'), 'date_time' => $timedate, 'status' => NULL]);

            $description = 'Update remidners.' ;
            Clicks::create(['user_id'=>session('user_id'),'user_name'=>session('user_name'),'page_name'=>'Reminders','description'=>$description]);

            ReminderHistory::updateOrCreate(
              ['property_id' => $property_id],
              ['history' => $oldReminder]
            );
            
        }

        return "true";
      }else{
            return "false";
        }
    }
}